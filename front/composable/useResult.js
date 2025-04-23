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
  
    // ... resto del código del PDF (como te mostré antes) ...
  
  
    // Portada
    doc.setFont("times", "bold");
    doc.setFontSize(20);
    doc.text(viatge.titol || "Planificació del viatge", pageWidth / 2, pageHeight / 2 - 10, { align: "center" });
  
    doc.setFontSize(12);
    doc.setFont("times", "normal");
    doc.text(`Preu total estimat: ${viatge.preuTotal || "No disponible"}`, pageWidth / 2, pageHeight / 2 + 10, { align: "center" });
  
    addWatermark();
  
    // Dies del viatge
    viatge.dies.forEach((dia, index) => {
      doc.addPage();
      let y = topMargin;
  
      addWatermark();
  
      // Títol del dia
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
  
            y += 2; // petit espai entre activitats
          }
        });
      } else {
        doc.setFont("times", "italic");
        doc.setFontSize(11);
        doc.text("No hi ha activitats definides per aquest dia.", leftMargin, y);
      }
    });
  
    // Guarda
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

  const getImageBase64 = (url) => {
    return new Promise((resolve, reject) => {
      const img = new Image();
      img.crossOrigin = "anonymous"; // Si necesitas CORS
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

  const totsElsDiesMostrats = computed(() => {
    return modeVista.value === 'resum';
  });

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
    totsElsDiesMostrats,
  };
}
