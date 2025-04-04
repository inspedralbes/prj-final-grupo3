import { ref, computed, watch } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '~/store/authUser';
import { useAlert } from './useAlert';
import { getCountries, getTypes, getMovilities, postTravel } from '@/services/communicationManager';
import { use } from 'marked';

export function usePlanner() {
  const config = useRuntimeConfig();
  const router = useRouter();
  const authStore = useAuthStore();
  const { customAlert } = useAlert(); // Importa el hook useAler

  const formData = ref({
    country: "",
    datesinit: "",
    datesfinal: "",
    travelers: 1,
    interests: "",
    type: "",
    budgetmin: 250,
    budgetmax: "",
    vehicle: "",
    vehicletype: "",
  });

  const dateRange = ref([]);
  const countries = ref([]);
  const filteredCountries = ref([]);
  const filteredMovilities = ref([]);
  const searchQuery = ref("");
  const showDropdown = ref(false);
  const budgetMax = ref(7500);
  const budgetMin = ref(250);
  const types = ref([]);
  const movilities = ref([]);

  // Load initial data
  const loadInitialData = async () => {
    try {
      const [countryList, movilityList, typeList] = await Promise.all([
        getCountries(),
        getMovilities(),
        getTypes(),
      ]);


      countries.value = countryList;
      filteredCountries.value = countryList;
      movilities.value = movilityList;
      filteredMovilities.value = movilityList;
      types.value = typeList;
    } catch (error) {
      console.error("Error carregant dades:", error);
    }
  };

  const filterCountries = () => {
    const query = searchQuery.value.toLowerCase();
    filteredCountries.value = countries.value.filter((country) =>
      country.name.toLowerCase().includes(query)
    );
    formData.value.country = searchQuery.value;
  };

  const filterMovilities = (query) => {
    filteredMovilities.value = movilities.value.filter(movility =>
      movility.name.toLowerCase().includes(query.toLowerCase())
    );
  };

  const selectCountry = (country) => {
    searchQuery.value = country.name;
    formData.value.country = country.id;
    showDropdown.value = false;
  };

  const hideDropdown = () => {
    setTimeout(() => {
      showDropdown.value = false;
    }, 200);
  };

  const selectedType = computed(() => formData.value.type);
  const vehicle = computed(() => formData.value.vehicle);

  // Watch for date changes
  watch(dateRange, (newValue) => {
    if (newValue.length === 2) {
      formData.value.datesinit = newValue[0];
      formData.value.datesfinal = newValue[1];
    }
  });

  // Watch for budget changes
  watch(budgetMin, (newValue) => {
    formData.value.budgetmin = newValue;
  });

  watch(budgetMax, (newValue) => {
    formData.value.budgetmax = newValue;
  });

  watch(() => formData.value.vehicle, (newVal) => {
    if (newVal !== "yes") {
      formData.value.vehicletype = 4;
    } else {
      formData.value.vehicletype = "";
    }
  });

  const validateForm = () => {
    if (budgetMin.value >= budgetMax.value) {
      customAlert("El pressupost mínim ha de ser inferior al màxim.",
        'negative',
        'error',
        'top',
        3500);
      return false;
    }

    if (!dateRange.value || dateRange.value.length !== 2) {
      customAlert("Selecciona una data d'inici i una data final.",
        'negative',
        'error',
        'top',
        3500);
      return false;
    }

    const startDate = new Date(formData.value.datesinit);
    const endDate = new Date(formData.value.datesfinal);
    const today = new Date();

    today.setHours(0, 0, 0, 0);
    startDate.setHours(0, 0, 0, 0);
    endDate.setHours(0, 0, 0, 0);

    if (startDate < today) {
      customAlert("La data d'inici no pot ser anterior a la data actual.",
        'negative',
        'error',
        'top',
        3500);
      return false;
    }

    if (endDate <= startDate) {
      customAlert("La data de tornada ha de ser posterior a la d'anada.",
        'negative',
        'error',
        'top',
        3500);
      return false;
    }

    return true;
  };

  const syncWithBudget = () => {
    if (budgetMin.value > budgetMax.value) {
      budgetMin.value = budgetMax.value - 100;
    }
    if (budgetMax.value < budgetMin.value) {
      budgetMax.value = budgetMin.value + 100;
    }
  };

  const handleSubmit = async () => {
    if (!validateForm()) return;

    try {
      const travelData = {
        id_user: authStore.user.id,
        id_country: formData.value.country,
        date_init: formData.value.datesinit,
        date_end: formData.value.datesfinal,
        id_type: formData.value.type,
        id_budget_min: formData.value.budgetmin,
        id_budget_max: formData.value.budgetmax,
        id_movility: formData.value.vehicletype,
        description: formData.value.interests,
      };

      const dbResponse = await postTravel(travelData, authStore.token);

      const currentCountry = countries.value.find(country => country.id === formData.value.country);

      console.log(currentCountry.name);


      if (dbResponse.code === 201) {
        const vehicleTypes = {
          1: "Bicicleta",
          2: "Moto",
          3: "Cotxe",
          4: "No vehicle"
        };

        const requestText = `
          Planifica un viatge per a ${formData.value.travelers} persones ${formData.value.type === "alone" ? "sol" : `amb ${formData.value.type}`}.
          Destí: ${currentCountry.name}.
          Dates: del ${formData.value.datesinit} al ${formData.value.datesfinal}.
          Pressupost: entre ${formData.value.budgetmin}€ i ${formData.value.budgetmax}€.
          Interessos: ${formData.value.interests}.
          Vehicle: ${formData.value.vehicletype}.
          Tipus de vehicle: ${vehicleTypes[formData.value.vehicletype] || "No especificat"}.
          Cada dia ha d'incloure tos els seus detalls.
          El nombre de dies ha de coincidir amb els dies que t'he indicat abans.Gràcies.   
          Bastant detallat i a més que el resultat ha d'estar estructurat com un objecte que contingui un array anomenat dies, on cada element representa un dia del viatge.
          📌 **Important:** la resposta ha de ser **només un JSON vàlid**, **sense text introductori**, sense cap bloc de codi (res de \`\`\`json), i sense formatació markdown. Retorna només l'objecte JSON pur.
          Exemple esperat:
          Retorna la resposta sempre en el mateix format.
          {
            "viatge": {
              "titol": "...",
              "dies": [
                {
                  "dia": Data del dia,
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
          Tota la informació ha d'estar en català.
          Gràcies!
         `;

        router.push({ name: "loading" });

        const key = config.public.apiKey;
        const text = JSON.stringify(requestText);

        const response = await fetch(`https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${key}`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            contents: [{ parts: [{ text }] }]
          })
        });

        if (!response.ok) throw new Error("Error al cridar la IA de Gemini");

        const result = await response.json();

        router.push({
          name: "result",
          query: { response: JSON.stringify(result) },
        });
      }
    } catch (error) {
      console.error("Error al enviar el formulari:", error);
      customAlert({
        title: 'Error',
        message: 'S\'ha produït un error en processar la sol·licitud. Si el problema persisteix, siusplau, contacta amb el nostre equip de suport.',
        type: 'error',
        showCancelButton: false,
        confirmButtonText: 'Tancar'
      })
    }
  };

  return {
    formData,
    dateRange,
    searchQuery,
    showDropdown,
    filteredCountries,
    types,
    movilities,
    budgetMin,
    budgetMax,
    filterCountries,
    filterMovilities,
    selectCountry,
    hideDropdown,
    syncWithBudget,
    handleSubmit,
    loadInitialData,
    selectedType,
    vehicle
  };
}