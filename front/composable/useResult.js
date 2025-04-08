import { useRoute, useRouter } from "vue-router";
import { computed, ref } from "vue";
import { marked } from "marked";
import { jsPDF } from "jspdf";
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

  const handleAccept = () => {
    alert("Planning del viatge guardat correctament");
    aiGeminiStore.responseText = null;
    router.push("/");
  };

  const handleCancel = () => {
    alert("El viatge s'ha cancel·lat.");
    aiGeminiStore.responseText = null;
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
      // const previousDataText = responseText.value;
      router.push({ name: "loading" });

      const newTripMessage = `
      Fes un nou vaitge basan-te en aquestes dades, intenta que sigui un viatge diferent, però sigui coherent amb aquestes dades i dintre de un preu raonable:
        ${aiGeminiStore.responseText}.
         Sense cap bloc de codi (res de \`\`\`json), i sense formatació markdown. Retorna només l'objecte JSON pur.
      `;

      const response = await fetch("/api/gemini", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          text: newTripMessage,
        }),
      });

      if (!response.ok) {
        throw new Error("Error en la respuesta del servidor");
      }

      const data = await response.json();

      let newResponseText = null

      if (
        data &&
        data.candidates &&
        data.candidates[0]?.content?.parts[0]?.text
      ) {
        console.log('json', data.candidates[0].content.parts[0].text);
        newResponseText = data.candidates[0].content.parts[0].text;
      }

      await aiGeminiStore.setResponse(newResponseText);
      // await aiGeminiStore.setResponse(JSON.stringify(newResponseText));

      router.push({
        path: "/result",
        // query: { response: JSON.stringify(data) },
      });

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

  const mostrarSeguentDia = () => {
    if (diaActualIndex.value < diesViatge.value.length - 1) {
      console.log('avanço');
      diaActualIndex.value++;
    } else {
      console.log('no avanço, ja que @click no m"magrada');
      modeVista.value = "resum";
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
    mostrarSeguentDia,
    modeVista,
    preuTotal,
    titol,
  };
}
