import { useRoute, useRouter } from "vue-router";
import { computed, ref } from "vue";
import { marked } from "marked";
import { jsPDF } from "jspdf";
import { getTravelGemini, savePlaning, sendTravelEmail } from '@/services/communicationManager';
import { useAIGeminiStore } from "~/store/aiGeminiStore";
import { useAuthStore } from "~/store/authUser";
import { useAlert } from './useAlert';

export function useResult() {
  const aiGeminiStore = useAIGeminiStore();
  const userStore = useAuthStore();
  const response = ref(null);
  const router = useRouter();
  const showConfirmation = ref(false);
  const diaActualIndex = ref(0);
  const diaActual = computed(() => diesViatge.value[diaActualIndex.value] || null);
  const modeVista = ref("pas-a-pas");
  const { customAlert } = useAlert();

  // En useResult.js, modifica la definición del computed property responseText
  const responseText = computed(() => {
    if (aiGeminiStore.responseText) {
      try {
        // Limpiar posibles delimitadores de código o markdown
        let cleanText = aiGeminiStore.responseText;

        // Eliminar cualquier bloque de código markdown
        cleanText = cleanText.replace(/```json\s*/g, '');
        cleanText = cleanText.replace(/```\s*$/g, '');
        cleanText = cleanText.replace(/```/g, '');

        // Eliminar posibles espacios en blanco al principio y final
        cleanText = cleanText.trim();

        // Asegurarse de que el texto comienza con { y termina con }
        if (!cleanText.startsWith('{') || !cleanText.endsWith('}')) {
          // Intentar encontrar el objeto JSON dentro del texto
          const match = cleanText.match(/\{[\s\S]*\}/);
          if (match) {
            cleanText = match[0];
          }
        }

        // Intentar analizar el JSON limpio
        const json = JSON.parse(cleanText);
        console.log("JSON RESPONSE (limpio):", json);
        return json;
      } catch (error) {
        console.error("Error al procesar JSON:", error);
        console.log("Texto original:", aiGeminiStore.responseText);
        return null; // o un objeto de error/estado
      }
    }
  });

  const formattedResponseText = computed(() => {
    if (responseText.value) {
      return marked(responseText.value);
    }
    return "";
  });

  const showCancelOptions = () => {
    showConfirmation.value = true;
  };

  const handleAccept = async () => {
    const response = savePlaning(responseText.value, aiGeminiStore.currentUserToken, aiGeminiStore.lastTravelId);
    console.log(response);

    try {
      if (response) {
        customAlert("Planning del viatge guardat correctament", 'positive', 'success', 'top', 3500);

        console.log("ID del viatge:", aiGeminiStore.lastTravelId);
        console.log("ID de l'usuari:", userStore.user);
        console.log("Token:", userStore.token);

        if (!aiGeminiStore.lastTravelId || !userStore.user.id) {
          console.error("Falta l'ID del viatge o l'id de l'usuari.");
          return;
        }
        console.log("Enviant correu per al viatge amb ID:", aiGeminiStore.lastTravelId, "al usuario amb ID:", userStore.user.id);

        router.push("/loading");

        const data = await sendTravelEmail(aiGeminiStore.lastTravelId, userStore.user, userStore.token);

        console.log("Resposta del backend:", data);

        if (!data) {
          customAlert(
            "Error: El servidor no ha retornat cap resposta en enviar el correu.",
            'negative',
            'error',
            'top',
            5000
          );
          return;
        }

        if (!data.viatge) {
          customAlert(
            "Error: Les dades del viatge no s'han rebut correctament del servidor.",
            'negative',
            'error',
            'top',
            5000
          );
          return;
        }

        aiGeminiStore.responseText = JSON.stringify({ viatge: data.viatge });
        localStorage.removeItem('tripplan_form_data');
        localStorage.removeItem('tripplan_chat_memory');
        localStorage.removeItem('tripplan_chat_memory' + '_messages');
        router.push("/");
      }
    } catch (error) {
      console.error("Error en enviar el correu:", error);
      customAlert(
        "Hi ha hagut un error en enviar el correu.",
        'negative',
        'error',
        'top',
        5000
      );
    }
  };


  const handleCancel = () => {
    customAlert("El viatge s'ha cancel·lat.", 'negative', 'info', 'top', 3500);
    router.push("/");
  };

  const downloadPDF = async () => {
    const logoBase64 = await getImageBase64("/apple-icon.png");

    const doc = new jsPDF("p", "mm", "a4");
    const viatge = responseText.value?.viatge;
    if (!viatge) return;

    const pageWidth = doc.internal.pageSize.getWidth();
    const pageHeight = doc.internal.pageSize.getHeight();
    const leftMargin = 20;
    const topMargin = 25;
    const lineHeight = 7;

    const totalPages = viatge.dies.length + 1;

    const addWatermark = () => {
      const imgWidth = 40;
      const imgHeight = 40;
      doc.addImage(logoBase64, "PNG", pageWidth - imgWidth - 10, pageHeight - imgHeight - 10, imgWidth, imgHeight);
    };

    const addPageNumber = (pageNum) => {
      doc.setFontSize(10);
      doc.setTextColor(150);
      doc.text(`Pàgina ${pageNum} de ${totalPages}`, pageWidth / 2, pageHeight - 10, { align: "center" });
    };

    // First Page
    doc.setFont("times", "bold");
    doc.setFontSize(20);
    doc.text(viatge.titol || "Planificació del viatge", pageWidth / 2, pageHeight / 2 - 10, { align: "center" });

    doc.setFontSize(12);
    doc.setFont("times", "normal");
    doc.text(`Preu total estimat: ${viatge.preuTotal || "No disponible"}`, pageWidth / 2, pageHeight / 2 + 10, { align: "center" });

    addWatermark();

    // Travel days
    viatge.dies.forEach((dia, index) => {
      doc.addPage();
      let y = topMargin;

      addWatermark();

      // Title
      doc.setFont("times", "bold");
      doc.setFontSize(16);
      doc.text(`Dia ${index + 1}`, leftMargin, y);
      y += lineHeight * 2;

      if (Array.isArray(dia.activitats)) {
        dia.activitats.forEach((act) => {
          if (typeof act === 'object') {
            const horari = act.horari || "Sense horari";
            const nom = act.nom || "Activitat";
            const descripcio = act.descripcio || "";
            const preu = act.preu || "Preu no disponible";

            const bloc = `${horari} | ${nom}\nDescripció: ${descripcio}\nPreu: ${preu}\n`;
            const lines = doc.splitTextToSize(bloc, pageWidth - 2 * leftMargin);

            doc.setFont("times", "normal");
            doc.setFontSize(11);
            lines.forEach((line) => {
              if (y + lineHeight > pageHeight - 20) {
                doc.addPage();
                y = topMargin;
                addWatermark();
              }
              doc.text(line, leftMargin, y);
              y += lineHeight;
            });

            y += 2; // Space between activities
          }
        });
      } else {
        doc.setFont("times", "italic");
        doc.setFontSize(11);
        doc.text("No hi ha activitats definides per aquest dia.", leftMargin, y);
      }
    });

    // Save
    doc.save("planificacio_viatge.pdf");
  };

  const generateNewTrip = async () => {
    try {
      router.push({ name: "loading" });

      const newTripMessage = `
      Fes un nou viatge basat en aquestes dades. Ha de ser un viatge diferent però coherent amb les mateixes dates, pressupost i interessos.
      
      Original: ${aiGeminiStore.initialResponse}
      
      El nou viatge ha de seguir EXACTAMENT la mateixa estructura però amb activitats i experiències totalment diferents.

      HA D'INCLOURE OBLIGATÒRIAMENT la següent informació per poder representar la ruta en un mapa:
      
      "coordenades": {
        "centre_mapa": {
          "coords": [00.000000, 00.000000]
        },
        "nivel_zoom": 15,
        "rutes_per_dia": [
          {
            "dia_index": 0,
            "color": "#HEX",
            "llocs": [
              {
                "id": 1,
                "nom": "Nom del lloc",
                "descripcio": "Descripció del lloc",
                "google_maps_url": "https://www.google.com/maps/search/nom+del+lloc",
                "coords": [00.000000, 00.000000]
              },
              {
                "id": 2,
                "nom": "Nom del lloc",
                "descripcio": "Descripció del lloc",
                "google_maps_url": "https://www.google.com/maps/search/nom+del+lloc",
                "coords": [00.000000, 00.000000]
              }
            ],
            "orden_visita": [1, 2, ...],
            "distancia_total_metres": 1200
          },
          {
            "dia_index": 1,
            "color": "#DIFERENT_HEX",
            "llocs": [
              // llocs pel segon dia
            ],
            "orden_visita": [5, 6, ...],
            "distancia_total_metres": 1500
          }
          // Continua per cada dia...
        ]
      }
      
      Les coordenades han de ser precises amb 6 decimals.
      Cada dia ha de tenir un color diferent i distintiu en format hexadecimal (#FF5733, #4287f5, etc.).
      Els colors han de ser llegibles en un mapa i han de contrastar entre ells.
      Suggeriments de colors per dia: Dia 1 = "#3366CC", Dia 2 = "#DC3912", Dia 3 = "#FF9900", Dia 4 = "#109618", Dia 5 = "#990099".
      
      Retorna la resposta sempre en el mateix format:
      {
        "viatge": {
          "titol": "...",
          "dies": [
            {
              "dia": "Data del dia",
              "paraulaClau": "(Una paraula o 2 paraules (amb espai) si es necesari clau que facin referència al pla de cada dia mes especific, com ara el nom del lloc més important del dia en anglès o el nom del país)",
              "resumDia": "(resum curt pero detallada del plan del dia)",
              "allotjament": "...",
              "color_dia": "#HEX", // Color que identifica aquest dia, igual que a rutes_per_dia
              "activitats": [
                {
                  "nom": "...",
                  "descripcio": "...",
                  "preu": "...",
                  "horari": "...",
                  "ubicacio": {
                    "nom": "Nom del lloc",
                    "google_maps_url": "https://www.google.com/maps/search/nom+del+lloc"
                  }
                },
                ...
              ]
            }
          ],
          "preuTotal": "...",
          "comentaris": "comentari/s curt sobre el preu total del viatge, com ara si és un pressupost ajustat o si es poden fer ajustos per reduir costos.",
          "coordenades": {
            "centre_mapa": {
              "coords": [00.000000, 00.000000]
            },
            "nivel_zoom": 15,
            "rutes_per_dia": [
              {
                "dia_index": 0,
                "color": "#HEX", // Mateix color que color_dia del primer dia
                "llocs": [
                  {
                    "id": 1,
                    "nom": "Nom del lloc",
                    "descripcio": "Descripció del lloc",
                    "google_maps_url": "https://www.google.com/maps/search/nom+del+lloc",
                    "coords": [00.000000, 00.000000]
                  },
                  ...
                ],
                "orden_visita": [1, 2, ...],
                "distancia_total_metres": 1200
              },
              ...
            ]
          }
        }
      }
      
      📌 **MOLT IMPORTANT sobre les URLs de Google Maps:**
      
      Per a cada lloc, DEUS generar una URL de Google Maps completa i funcional.
      La URL ha de ser completa i funcional, ja que quan es carregui al mapa, ha de mostrar el lloc exactament com si anes a Google Maps.
      
      NO deixis cap lloc sense URL de Google Maps.
      NO proporcions només el nom del lloc en el camp google_maps_url.
      
      Els colors tenen que representar un dia en concret i ser consistents en tot el JSON.
      Si una activitat del dia 1 té color "#3366CC", totes les activitats i rutes d'aquell dia han de tenir el mateix color.
      Els colors han de ser diferents per cada dia per distingir clarament les rutes al mapa.
      
      INSTRUCCIONS IMPORTANTS:
      - MANTENIR el mateix nombre de dies i mateix format de dates que el viatge original
      - El camp "resumDia" ha de ser un text curt que resumeixi les activitats del dia
      - El camp "paraulaClau" ha de ser 1 o 2 paraules clau que identifiquin l'aspecte més important del dia
      - Cal que cada dia tingui el seu propi allotjament i detalls d'activitats diferents de l'original
      - Assegura't que cada dia tingui com a mínim 3 activitats
      - Tota la informació ha d'estar en català
      
      📌 **Important:** la resposta ha de ser **només un JSON vàlid**, **sense text introductori**, sense cap bloc de codi (res de \`\`\`json), i sense formatació markdown. Retorna només l'objecte JSON pur.

      📌 **EXTREMADAMENT IMPORTANT:** 
      - La teva resposta ha de ser NOMÉS un objecte JSON vàlid, res més.
      - NO incloure \`\`\`json ni \`\`\` ni cap altra marca de format.
      - La resposta ha de començar directament amb { i acabar amb }.
      - Si inclous marques de format, el sistema fallarà completament.
    `;

      const systemPrompt = `
      Format EXACTE per a totes les dates:
      - Dia del mes en número sense zeros al davant
      - Dia de la setmana en català amb la primera lletra en majúscula
      - Mes en minúscules en català
      - 'de' com a separador
      - 'd'' com a separador abans de vocals
      - Any complet en números
      
      Exemple correcte: "Dimecres 9 d'abril de 2025"
      Exemple correcte: "Dilluns 5 de maig de 2025"
      
      És CRUCIAL que:
      1. El JSON resultant sigui vàlid i ben format
      2. Totes les URLs de Google Maps siguin completes i funcionals
      3. Les coordenades siguin precises amb 6 decimals
      4. Els colors per dia siguin consistents i contrastats
      5. No incloguis res fora del JSON (ni introduccions, ni explicacions, NI CODI DE MARKDOWN)
      6. Cada lloc tingui una coordenada vàlida i una URL de Google Maps funcional
      7. TOTES les propietats obligatòries estiguin presents i ben formades
    `;

      const newTripMessageWithSystemPrompt = `${systemPrompt}\n\n${newTripMessage}`;

      const data = await getTravelGemini(newTripMessageWithSystemPrompt);

      await aiGeminiStore.setResponse(data);

      router.push({ path: "/result" });

      showConfirmation.value = false;
    } catch (error) {
      console.error("Error al generar un nuevo viaje:", error);
      router.push({ path: "/planner" });
    }
  };

  const getImageBase64 = (url) => {
    return new Promise((resolve, reject) => {
      const img = new Image();
      img.crossOrigin = "anonymous"; // CORS
      img.onload = () => {
        const canvas = document.createElement("canvas");
        canvas.width = img.width;
        canvas.height = img.height;
        const ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0);
        const dataURL = canvas.toDataURL("image/png");
        resolve(dataURL);
      };
      img.onerror = () => reject(new Error("No es pot carregar la imatge."));
      img.src = url;
    });
  };

  const diesViatge = computed(() => {
    return responseText.value.viatge?.dies || [];
  });

  const titol = computed(() => {
    return responseText.value.viatge?.titol || "";
  });

  const preuTotal = computed(() => {
    return responseText.value.viatge?.preuTotal || 0;
  })

  const tokenUser = computed(() => {
    return userStore.token;
  })

  const comentaris = computed(() => {
    return responseText.value.viatge?.comentaris || "";
  })

  const totsElsDiesMostrats = computed(() => {
    return modeVista.value === 'resum';
  });

  // const mostrarSeguentDia = () => {
  //   if (diaActualIndex.value < diesViatge.value.length - 1) {
  //     console.log('avanço');
  //     diaActualIndex.value++;
  //   } else {
  //     console.log('no avanço, ja que @click no m"magrada');
  //     modeVista.value = "resum";
  //   }
  // };

  const mostrarDiaAnterior = () => {
    if (diaActualIndex.value > 0) {
      console.log('torno');
      diaActualIndex.value--;
    } else {
      console.log('no avanço, ja estic al primer dia');
      // modeVista.value = "resum";
    }
  };

  const mostrarDiaSeguent = () => {
    if (diaActualIndex.value < diesViatge.value.length - 1) {
      console.log('avanço');
      diaActualIndex.value++;
    } else {
      console.log('no avanço, ja estic al ultim dia');
      // modeVista.value = "resum";
    }
  };

  onBeforeMount(() => {
    // localStorage.removeItem('tripplan_form_data');
    // localStorage.removeItem('tripplan_chat_memory');
    // localStorage.removeItem('tripplan_chat_memory' + '_messages');
  })

  return {
    response,
    responseText,
    formattedResponseText,
    showConfirmation,
    showCancelOptions,
    handleAccept,
    handleCancel,
    generateNewTrip,
    downloadPDF,
    diesViatge,
    diaActual,
    mostrarDiaAnterior,
    mostrarDiaSeguent,
    diaActualIndex,
    // mostrarSeguentDia,
    modeVista,
    preuTotal,
    comentaris,
    tokenUser,
    titol,
    totsElsDiesMostrats,
  };
}
