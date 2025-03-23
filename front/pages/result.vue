<template>
  <title>Triplan</title>
  <div class="min-h-screen bg-gray-50">
    <main class="container mx-auto mt-10 p-4">
      <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-3xl font-bold text-center mb-8">Planificació del teu viatge</h2>

        <div v-if="responseText" v-html="formattedResponseText" class="prose prose-lg max-w-none custom-prose"></div>

        <div v-else>
          <p class="text-lg text-red-500">No hi ha cap resultat a mostrar.</p>
        </div>

        <!--download pdf-->
        <div v-if="responseText" class="flex justify-center mt-6">
          <button @click="downloadPDF"
            class="bg-green-600 text-white py-4 px-5 rounded-lg hover:bg-green-700 transition duration-200 text-lg font-semibold">
            📄 Descarregar PDF
          </button>
        </div>
        <!--buttons accept or decline-->
        <div v-if="!result.showConfirmation.value" class="flex justify-center gap-x-6 mt-8">
          <button @click="result.handleAccept"
            class="bg-blue-600 text-white py-4 px-8 rounded-lg hover:bg-blue-700 transition duration-200 text-lg font-semibold">
            Acceptar
          </button>

          <button @click="result.showCancelOptions"
            class="bg-red-600 text-white py-4 px-8 rounded-lg hover:bg-red-700 transition duration-200 text-lg font-semibold">
            Cancel·lar
          </button>
        </div>

        <!--button for new trip if the user wants to do it-->
        <div v-if="result.showConfirmation.value" class="mt-8 text-center">
          <p class="text-lg font-semibold text-gray-700 mb-4">Estàs segur que vols cancel·lar?</p>
          <div class="flex justify-center gap-x-6">
            <button @click="result.handleCancel"
              class="bg-red-600 text-white py-4 px-8 rounded-lg hover:bg-red-700 transition duration-200 text-lg font-semibold">
              Sí, cancel·lar
            </button>
            <button @click="result.generateNewTrip"
              class="bg-blue-600 text-white py-4 px-8 rounded-lg hover:bg-blue-700 transition duration-200 text-lg font-semibold">
              No, generar un nou viatge
            </button>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { useResult } from '~/composable/useResult';
import { useRoute, useRouter } from 'vue-router';
import { computed, ref, watch } from 'vue';
import { marked } from 'marked';
import { jsPDF } from "jspdf";
import html2canvas from "html2canvas";

const result = useResult();
const route = useRoute();
const router = useRouter();

const response = ref(route.query.response ? JSON.parse(route.query.response) : null);

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
  const titleGap = 10; // Espacio entre el título y el contenido

  // Añadir título centrado
  const title = "PLANIFICACIÓ DEL VIATGE";
  doc.setFont("times", "bold");
  doc.setFontSize(20);
  const titleX = (pageWidth - doc.getTextWidth(title)) / 2;
  doc.text(title, titleX, topMargin);

  // Configurar el estilo para el cuerpo del texto
  doc.setFont("times", "normal");
  doc.setFontSize(10);

  // Extraer el texto del elemento (sin etiquetas HTML)
  const text = element.innerText;
  // Calcular el ancho disponible (respectando los márgenes)
  const availableWidth = pageWidth - leftMargin - rightMargin;
  // Dividir el texto en líneas que se ajusten al ancho disponible
  const lines = doc.splitTextToSize(text, availableWidth);

  // Calcular la altura de línea (ajusta este valor si es necesario)
  const lineHeight = 7;

  // La posición inicial en Y se sitúa debajo del título (se estima unos 20 mm para el título)
  let y = topMargin + 20 + titleGap;

  // Iterar las líneas y agregarlas al PDF, añadiendo páginas cuando sea necesario
  lines.forEach(line => {
    if (y + lineHeight > pageHeight - bottomMargin) {
      doc.addPage();
      y = topMargin; // reiniciamos en la nueva página
    }
    doc.text(line, leftMargin, y);
    y += lineHeight;
  });

  doc.save("planificacio_viatge.pdf");
};

</script>

<style>
.custom-prose p {
  margin-bottom: 1.5rem;
}
</style>