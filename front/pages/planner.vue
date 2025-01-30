<template>
  <header>
    <title>Triplan</title>
  </header>
  <div class="min-h-screen bg-gray-50">

    <main class="container mx-auto mt-10 p-4">
      <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-3xl font-bold text-center mb-8">Planifica el viatge dels teus somnis</h2>

        <!--form for planner-->
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
                <select v-model="formData.type" name="type" id="" class="border p-2 rounded">
                  <option value="sol">Sol</option>
                  <option value="amics">Amics</option>
                  <option value="familia">Família</option>
                  <option value="parella">Parella</option>
                </select>
              </div>
              <!-- if selectedtype is friends or family -->
              <div v-if="selectedType === 'amics' || selectedType === 'familia'" class="w-1/2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Quantitat de persones:</label>
                <input type="number" v-model="formData.travelers" min="1" class="border p-2 rounded w-full"
                  placeholder="2" />
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
                  <input id="minBudget" type="number" v-model="formData.budgetmin" min="0" placeholder="200"
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
                <input id="maxBudget" type="number" v-model="formData.budgetmax" min="0" placeholder="3000"
                  class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                  @input="syncWithBudget" />
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
import { useRouter } from 'vue-router';
import { ref } from 'vue';

// Dades del formulari
const formData = ref({
  destination: '',
  datesinit: '',
  datesfinal: '',
  travelers: '',
  interests: '',
  type: '',
  budgetmin: '',
  budgetmax: ''
});

// definitions for budget min and max for defect
const budgetMax = ref(7500);
const budgetMin = ref(250);

//asign type of travel
const selectedType = computed(() => formData.value.type);

// function to synchronize budget min and max
const syncWithBudget = () => {  
  if (budgetMin.value > budgetMax.value) {
    budgetMin.value = budgetMax.value - 100;
  }

  if (budgetMax.value < budgetMin.value) {
    budgetMax.value = budgetMin.value + 100;
  }
};


//function to stay alert and watch budget min and max
watch(budgetMin, (newValue) => {
  formData.value.budgetmin = newValue;
})

watch(budgetMax, (newValue) => {
  formData.value.budgetmax = newValue;
})


const router = useRouter();



// function to submit the form
const handleSubmit = async () => {
  try {
    if (budgetMin.value >= budgetMax.value) {
      alert('El pressupost mínim ha de ser inferior al màxim.');
      return;
    }

    formData.value.budgetmin = budgetMin.value;
    formData.value.budgetmax = budgetMax.value;

    router.push({ name: 'loading' });

    // generate the prompt for gemini AI
    const requestText = `
      Planifica un viatge per a ${formData.value.travelers} persones ${formData.value.type === 'alone' ? 'sol' : `amb ${formData.value.type}`}.
      Destí: ${formData.value.destination}.
      Dates: del ${formData.value.datesinit} al ${formData.value.datesfinal}.
      Pressupost: entre ${formData.value.budgetmin}€ i ${formData.value.budgetmax}€.
      Interessos: ${formData.value.interests}.
    `;

    console.log('Text a enviar a Gemini:', requestText); 

    // call the gemini API 
    const response = await fetch('/api/gemini', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ text: requestText }),
    });

    if (!response.ok) {
      throw new Error('Error al cridar la IA de Gemini');
    }

    const result = await response.json();

    // redirect to the result page
    router.push({
      name: 'result',
      query: {
        response: JSON.stringify(result),

      },
    });

  } catch (error) {
    console.error('Error al enviar el formulari:', error);
  }
};
</script>
