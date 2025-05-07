import { useRoute, useRouter } from "vue-router";
import { computed, ref } from "vue";
import { marked } from "marked";
import { jsPDF } from "jspdf";
import { getTravelGemini, savePlaning } from '@/services/communicationManager';
import { useAIGeminiStore } from "~/store/aiGeminiStore";
import { useAuthStore } from "~/store/authUser";

export function useResult() {
  const aiGeminiStore = useAIGeminiStore();
  const userStore = useAuthStore();
  const response = ref(null);
  const router = useRouter();
  const showConfirmation = ref(false);
  const diaActualIndex = ref(0);
  const diaActual = computed(() => diesViatge.value[diaActualIndex.value] || null);
  const modeVista = ref("pas-a-pas");

  const responseText = computed(() => {
    if (aiGeminiStore.responseText) {
      const json = JSON.parse(aiGeminiStore.responseText);
      console.log("JSON RESPONSE:", json);
      return json;
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
        alert("Planning del viatge guardat correctament");

        console.log("ID del viatge:", aiGeminiStore.lastTravelId);
        console.log("ID de l'usuari:", userStore.user);
        console.log("Token:", userStore.token);
        // const token = localStorage.getItem("token");
        // console.log("Token localStorage:", token);

        if (!aiGeminiStore.lastTravelId || !userStore.user.id) {
          console.error("Falta l'ID del viatge o l'id de l'usuari.");
          return;
        }

        console.log("Enviant correu per al viatge amb ID:", aiGeminiStore.lastTravelId, "al usuario amb ID:", userStore.user.id);

        const res = await fetch(`/api/travel/${aiGeminiStore.lastTravelId}/send-email`, {
          method: "POST",
          headers: {
            Authorization: `Bearer ${userStore.token}`,
          },
          body: JSON.stringify(userStore.user),
        });

        console.log("Resposta del backend:", res);

        aiGeminiStore.responseText = null;
        console.log("button clicked");
        router.push("/");
      }
    } catch (error) {
      console.error("Error en enviar el correu:", error);
    }
  };


  const handleCancel = () => {
    alert("El viatge s'ha cancel·lat.");
    // aiGeminiStore.responseText = null;
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
      Fes un nou vaitge basan-te en aquestes dades, intenta que sigui un viatge diferent, però sigui coherent amb aquestes dades y seguint la mateixa estrucutra del json que et dono:
        ${aiGeminiStore.initialResponse}.
         Sense cap bloc de codi (res de \`\`\`json), i sense formatació markdown. Retorna només l'objecte JSON pur.
         Retorna la resposta sempre en el mateix format.
          {
            "viatge": {
              "titol": "...",
              "dies": [
                {
                  "dia": número de dia y dia de la setmana,
                  "allotjament": "...",
                  "activitats": [
                    {
                      "nom": "...",
                      "descripcio": "...",
                      "preu": "...",
                      "horari": "..."
                    },
                    ...
                  ]
                }
              ],
              "preuTotal": "ha de ser un integer, sense text, i ha de ser un preu total aproximat del viatge, incloent allotjament i activitats.",
              "comentaris": "comentari/s curt sobre el preu total del viatge, com ara si és un pressupost ajustat o si es poden fer ajustos per reduir costos.",
            }
          }
          Recorda mantenir els mateixos dies que ha seleccionat l'usuari, però intenta que sigui un viatge diferent.
          Tota la informació ha d'estar en català.
      `;

      const systemPrompt = `
        Por favor, formatea todas las fechas en catalán siguiendo este formato exacto:
        - Día del mes en número sin ceros a la izquierda
        - Día de la semana en catalán, primera letra en mayúscula
        - Mes en minúsculas en catalán
        - 'de' como separador
        - 'd'' como separador
        - Año completo en números

        Ejemplo: "Dimecres 9 d'abril de 2025"
        Asegúrate de usar siempre este formato para cualquier fecha que aparezca en la respuesta.
        `;

      const newTripMessageWithSystemPrompt = `${systemPrompt}\n\n${newTripMessage}`;

      const data = await getTravelGemini(newTripMessageWithSystemPrompt);

      await aiGeminiStore.setResponse(data);

      router.push({ path: "/result" });

      showConfirmation.value = false;
    } catch (error) {
      console.error("Error al generar un nuevo viaje:", error);
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
