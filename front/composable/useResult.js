import { useRoute, useRouter } from "vue-router";
import { computed, ref } from "vue";
import { marked } from "marked";
import { jsPDF } from "jspdf";
import { getTravelGemini, savePlaning } from '@/services/communicationManager';
import { useAIGeminiStore } from "~/store/aiGeminiStore";

export function useResult() {
  const aiGeminiStore = useAIGeminiStore();
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
    const response = savePlaning(responseText.value, aiGeminiStore.currentUserToken);
    console.log(response);
    // alert("Planning del viatge guardat correctament");
    showConfirmation.value = false;
    // aiGeminiStore.responseText = null;
    // router.push("/");
  };

  const handleCancel = () => {
    alert("El viatge s'ha cancel·lat.");
    // aiGeminiStore.responseText = null;
    router.push("/");
  };

  const downloadPDF = () => {
    const element = document.querySelector(".custom-prose");
    if (!element) return;

    const doc = new jsPDF("p", "mm", "a4");
    const pageWidth = doc.internal.pageSize.getWidth();
    const pageHeight = doc.internal.pageSize.getHeight();

    // Definir márgenes y espacio
    const leftMargin = 15;
    const rightMargin = 15;
    const topMargin = 15;
    const bottomMargin = 15;
    const titleGap = 10;

    // Añadir título centrado
    const title = "PLANIFICACIÓ DEL VIATGE";
    doc.setFont("times", "bold");
    doc.setFontSize(20);
    const titleX = (pageWidth - doc.getTextWidth(title)) / 2;
    doc.text(title, titleX, topMargin);

    // Configurar el estilo para el cuerpo del texto
    doc.setFont("times", "normal");
    doc.setFontSize(10);

    const text = element.innerText;
    const availableWidth = pageWidth - leftMargin - rightMargin;
    const lines = doc.splitTextToSize(text, availableWidth);
    const lineHeight = 7;
    let y = topMargin + 20 + titleGap;

    lines.forEach((line) => {
      if (y + lineHeight > pageHeight - bottomMargin) {
        doc.addPage();
        y = topMargin;
      }
      doc.text(line, leftMargin, y);
      y += lineHeight;
    });

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
              preuTotal: "...",
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

  const diesViatge = computed(() => {
    return responseText.value.viatge?.dies || [];
  });

  const titol = computed(() => {
    return responseText.value.viatge?.titol || "";
  });


  const preuTotal = computed(() => {
    return responseText.value.viatge?.preuTotal || 0;
  })

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
    localStorage.removeItem('tripplan_form_data');
    localStorage.removeItem('tripplan_chat_memory');
    localStorage.removeItem('tripplan_chat_memory' + '_messages');
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
    titol,
  };
}
