<template>
  <header>
    <title>Triplan</title>
  </header>
  <div class="min-h-screen bg-gray-50">
    <!-- Main Content -->
    <main class="container mx-auto mt-10 p-4">
      <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-3xl font-bold text-center mb-8">Planifica el viatge dels teus somnis</h2>

        <form @submit.prevent="handleSubmit" class="space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Destination -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Destí</label>
              <input type="text" v-model="formData.destination"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                placeholder="On vols anar?">
            </div>

            <!--type of trip -->
            <div class="flex items-center space x-4">
              <div class="w-1/2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Amb qui viatges?</label>
                <select v-model="selectedType" name="type" id="" class="border p-2 rounded">
                  <option value="alone">Sol</option>
                  <option value="friends">Amics</option>
                  <option value="family">Família</option>
                  <option value="partner">Parella</option>
                </select>
              </div>
              <!-- if selectedtype is friends or family -->
              <div v-if="selectedType === 'friends' || selectedType === 'family'" class="w-1/2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Quantitat de persones:</label>
                <input type="number" v-model="formData.travelers" min="1" class="border p-2 rounded w-full"
                  placeholder="Introdueix el nombre de persones" />
              </div>
            </div>

            <!-- Init date -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Anada</label>
              <input type="date" v-model="formData.datesinit"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Final date -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Tornada</label>
              <input type="date" v-model="formData.datesfinal"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Budget -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Estableix el pressupost mínim (€)</label>
              <div>
                <!-- Budget Min -->
                <div class="w-3/3"> 
                  <input id="minBudget" type="number" v-model="budgetMin" min="0"
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                    @input="syncWithBudget" />
                  <!-- Range Slider-->
                  <input type="range" v-model="budgetMin" :min="0" :max="budgetMax" step="100"
                    class="w-full h-2 bg-blue-200 rounded-md mt-2" @input="syncWithBudget" />
                </div>
              </div>
            </div>
              <div>
                <!-- Budget Min -->
                 <label class="block text-sm font-medium text-gray-700 mb-2">Estableix el pressupost màxim (€)</label>
                <div class="w-3/3">
                  <input id="maxBudget" type="number" v-model="budgetMax" min="0"
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                    @input="syncWithBudget"/>
                  <!-- Range Slider -->
                  <input type="range" v-model="budgetMax" :min="budgetMin" :max="10000" step="100"
                    class="w-full h-2 bg-blue-500 rounded-md mt-2" @input="syncWithBudget" />
                </div>
              </div>
          </div>

          <!-- Interests -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Interessos</label>
            <textarea v-model="formData.interests"
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" rows="3"
              placeholder="Que t'interessa? (e.x., cultura, aventura, relax)"></textarea>
          </div>

          <button type="submit"
            class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
            Planifica el meu viatge
          </button>
        </form>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue';

// Datos del formulario
const formData = ref({
  destination: '',
  datesinit: '',
  datesfinal: '',
  travelers: 1,
  interests: ''
});

// Definició dels pressupostos inicials
const budgetMax = ref(7500);
const budgetMin = ref(250);

const selectedType = ref('alone');
// Funció per sincronitzar mínim i màxim
const syncWithBudget = () => {
  // Assegura que el mínim no sigui més gran que el màxim
  if (budgetMin.value > budgetMax.value) {
    budgetMin.value = budgetMax.value - 100;
  }

  // Assegura que el màxim no sigui més petit que el mínim
  if (budgetMax.value < budgetMin.value) {
    budgetMax.value = budgetMin.value + 100;
  }
};

// Enviar el formulari
const handleSubmit = () => {
  console.log('Form submitted:');
  console.log('Pressupost mínim:', budgetMin.value);
  console.log('Pressupost màxim:', budgetMax.value);
};
</script>
