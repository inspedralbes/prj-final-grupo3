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

            <!-- country -->
            <div class="relative">
              <label class="block text-sm font-medium text-gray-700 mb-2">País</label>

              <!-- user writes -->
              <input v-model="searchQuery" @input="filterCountries" @focus="showDropdown = true" @blur="hideDropdown"
                type="text" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                placeholder="On viatges?" />

              <!-- dropdown countries list -->
              <ul v-if="showDropdown && filteredCountries.length"
                class="absolute w-full border border-gray-300 bg-white shadow-md rounded-md mt-1 max-h-40 overflow-y-auto z-50">
                <li v-for="country in filteredCountries" :key="country.id" @mousedown="selectCountry(country.name)"
                  class="p-2 hover:bg-gray-200 cursor-pointer">
                  {{ country.name }}
                </li>
              </ul>
            </div>

            <!-- Destination -->
            <!-- <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Destí</label>
              <input type="text" v-model="formData.destination"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                placeholder="Ciutat on viatges">
            </div> -->

            <!--type of trip -->
            <div class="flex items-center space x-4">
              <div class="w-1/2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Amb qui viatges?</label>
                <select v-model="formData.type" name="type" id="" class="border p-2 rounded">
                  <option disabled selected value="">Selecciona</option>
                  <option value="sol">Sol</option>
                  <option value="amics">Amics</option>
                  <option value="familia">Família</option>
                  <option value="parella">Parella</option>
                </select>
              </div>
              <!-- if selectedtype is friends or family -->
              <div v-if="selectedType === 'amics' || selectedType === 'familia'" class="w-1/2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Quant. de persones:</label>
                <input type="number" v-model="formData.travelers" min="1" class="border p-2 rounded w-full"
                  placeholder="2" />
              </div>
            </div>

            <!-- Select dates -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-5 h-1">Selecciona les dates</label>
              <VueDatePicker v-model="dateRange" range multi-calendars :enable-time-picker="false" locale="ca"
                class="w-full border p-2 rounded-md" :text-input="true" :text-input-options="{
                  selectText: 'Confirmar',
                  cancelText: 'Cancel·lar'
                }" :min-date="new Date()" />
            </div>

            <div class="flex items-center space x-4">
              <!-- rent a car -->
              <div class="w-1/2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Lloguer de vehicle</label>
                <select v-model="formData.vehicle" class="border p-2 rounded">
                  <option value="" selected disabled>Selecciona</option>
                  <option value="yes">Si</option>
                  <option value="no">No</option>
                </select>
              </div>

              <!-- if vehicle is yes-->
              <div v-if="formData.vehicle === 'yes'" class="w-1/2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipus de vehicle</label>
                <select v-model="formData.vehicletype" class="border p-2 rounded w-full">
                  <option value="" selected disabled>Selecciona</option>
                  <option value="car">Cotxe</option>
                  <option value="bike">Bici</option>
                  <option value="motorcycle">Moto</option>
                </select>
              </div>

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
import { ref, computed, watch, onMounted } from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { getCountries } from '@/services/communicationManager';

const router = useRouter();

const formData = ref({
  country: '',
  datesinit: '',
  datesfinal: '',
  travelers: '',
  interests: '',
  type: '',
  budgetmin: '',
  budgetmax: '',
  vehicle: '',
  vehicletype: '',
});

const dateRange = ref([]);
const countries = ref([]);
const filteredCountries = ref([]);
const searchQuery = ref('');
const showDropdown = ref(false);
const budgetMax = ref(7500);
const budgetMin = ref(250);

// charge list of countries p
onMounted(async () => {
  try {
    const countryList = await getCountries();
    countries.value = countryList;
    filteredCountries.value = countryList; // Inicialmente muestra todos
  } catch (error) {
    console.error('Error carregant els països:', error);
  }
});

// filter countries
const filterCountries = () => {
  const query = searchQuery.value.toLowerCase();
  filteredCountries.value = countries.value.filter(country =>
    country.name.toLowerCase().includes(query)
  );
  formData.value.country = searchQuery.value;
};

// choose country from list
const selectCountry = (name) => {
  searchQuery.value = name;  // Para que aparezca en el input
  formData.value.country = name;  // Para que se guarde correctamente en el formulario
  showDropdown.value = false;  // Ocultar la lista desplegable
};
// hides dropdown
const hideDropdown = () => {
  setTimeout(() => {
    showDropdown.value = false;
  }, 200);
};

// control type of trip
const selectedType = computed(() => formData.value.type);
const vehicle = computed(() => formData.value.vehicle);

// Watch sincronize dates
watch(dateRange, (newValue) => {
  if (newValue.length === 2) {
    formData.value.datesinit = newValue[0];
    formData.value.datesfinal = newValue[1];
  }
});

// Watch update budget min and max
watch(budgetMin, (newValue) => {
  formData.value.budgetmin = newValue;
});

watch(budgetMax, (newValue) => {
  formData.value.budgetmax = newValue;
});

// validates form
const validateForm = () => {
  if (budgetMin.value >= budgetMax.value) {
    alert('El pressupost mínim ha de ser inferior al màxim.');
    return false;
  }

  if (!dateRange.value || dateRange.value.length !== 2) {
    alert('Selecciona una data inicial i final per al viatge.');
    return false;
  }

  const startDate = new Date(formData.value.datesinit);
  const endDate = new Date(formData.value.datesfinal);
  const today = new Date();

  today.setHours(0, 0, 0, 0);
  startDate.setHours(0, 0, 0, 0);
  endDate.setHours(0, 0, 0, 0);

  if (startDate < today) {
    alert("La data d'inici no pot ser anterior a la data actual.");
    return false;
  }

  if (endDate <= startDate) {
    alert("La data de tornada ha de ser posterior a la d'anada.");
    return false;
  }

  return true;
};

// updates budgets
const syncWithBudget = () => {
  if (budgetMin.value > budgetMax.value) {
    budgetMin.value = budgetMax.value - 100;
  }
  if (budgetMax.value < budgetMin.value) {
    budgetMax.value = budgetMin.value + 100;
  }
};

// sends form
const handleSubmit = async () => {
  if (!validateForm()) return;

  try {
    const requestText = `
      Planifica un viatge per a ${formData.value.travelers} persones ${formData.value.type === 'alone' ? 'sol' : `amb ${formData.value.type}`}.
      Destí: ${formData.value.country}.
      Dates: del ${formData.value.datesinit} al ${formData.value.datesfinal}.
      Pressupost: entre ${formData.value.budgetmin}€ i ${formData.value.budgetmax}€.
      Interessos: ${formData.value.interests}.
      Vehicle: ${formData.value.vehicle}.
      Tipus de vehicle: ${formData.value.vehicletype}.
    `;

    router.push({ name: 'loading' });

    const response = await fetch('/api/gemini', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ text: requestText }),
    });

    if (!response.ok) throw new Error('Error al cridar la IA de Gemini');

    const result = await response.json();

    router.push({
      name: 'result',
      query: { response: JSON.stringify(result) },
    });

  } catch (error) {
    console.error('Error al enviar el formulari:', error);
    alert("S'ha produït un error en processar la sol·licitud");
  }
};
</script>

<style>
.dp_main {
  width: 100%;
}

</style>
