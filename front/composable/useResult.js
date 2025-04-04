import { useRoute, useRouter } from 'vue-router';
import { computed, ref, watch } from 'vue';
import { marked } from 'marked';
import { jsPDF } from "jspdf";

export function useResult() {
  const route = useRoute();
  const router = useRouter();
  const response = ref(route.query.response ? JSON.parse(route.query.response) : null);
  const showConfirmation = ref(false);

  watch(
    () => route.query.response,
    (newResponse) => {
      response.value = newResponse ? JSON.parse(newResponse) : null;
    }
  );

  const responseText = computed(() => {
    if (response.value && response.value.candidates && response.value.candidates[0]?.content?.parts[0]?.text) {
      return response.value.candidates[0].content.parts[0].text;
    }
    return null;
  });

  const formattedResponseText = computed(() => {
    if (responseText.value) {
      return marked(responseText.value);
    }
    return '';
  });

  const showCancelOptions = () => {
    showConfirmation.value = true;
  };

  const handleAccept = () => {
    alert("Planning del viatge guardat correctament");
    router.push("/");
  };

  const handleCancel = () => {
    alert("El viatge s'ha cancel·lat.");
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

    lines.forEach(line => {
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
      const previousDataText = responseText.value;
      router.push({ name: 'loading' });
      
      const newTripMessage = `
        Hazme un nuevo viaje basándote en estos datos:
        ${previousDataText}
      `;

      const response = await fetch('/api/gemini', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          text: newTripMessage
        }),
      });

      if (!response.ok) {
        throw new Error('Error en la respuesta del servidor');
      }

      const data = await response.json();
      
      router.push({
        path: '/result',
        query: { response: JSON.stringify(data) }
      });

      showConfirmation.value = false;

    } catch (error) {
      console.error('Error al generar un nuevo viaje:', error);
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
    downloadPDF
  };
}