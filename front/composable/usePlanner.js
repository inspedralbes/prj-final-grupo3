import { ref, computed, watch } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '~/store/authUser';
import { useAlert } from './useAlert';
import { getCountries, getTypes, getMovilities, postTravel, getTravelGemini } from '@/services/communicationManager';
import { useAIGeminiStore } from '~/store/aiGeminiStore';
import { gemini } from '~/mocks/mock-ai-response';


export function usePlanner() {
  const router = useRouter();
  const authStore = useAuthStore();
  const aiGeminiStore = useAIGeminiStore();
  const { customAlert } = useAlert();

  const formData = ref({
    country: "",
    datesinit: "",
    datesfinal: "",
    travelers: 1,
    interests: "",
    type: "",
    budgetmin: 250,
    budgetmax: 3500,
    vehicle: "",
    vehicletype: "",
  });

  const formDataChat = ref({ interests: "" });

  const chatMessages = ref([]);
  const isTyping = ref(false);
  const isFirstMessage = ref(true);

  const dateRange = ref([]);
  const countries = ref([]);
  const filteredCountries = ref([]);
  const filteredMovilities = ref([]);
  const searchQuery = ref("");
  const showDropdown = ref(false);
  const budgetMax = ref(7500);
  const budgetMin = ref(250);
  const budgetRange = ref([budgetMin.value, budgetMax.value])
  const types = ref([]);
  const movilities = ref([]);
  const isWindowOpen = ref(false)

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

  const responseGemini = ref(gemini.getResponse(formDataChat.value.interests));

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

  const onSliderChange = ([min, max]) => {
    budgetMin.value = min
    budgetMax.value = max
    formData.value.budgetmin = min
    formData.value.budgetmax = max
  }

  // Watch for date changes
  watch(dateRange, (newValue) => {
    if (newValue.length === 2) {
      formData.value.datesinit = newValue[0];
      formData.value.datesfinal = newValue[1];
    }
  });

  //Watch for vehicle
  watch(() => formData.value.vehicle, (newVal) => {
    if (newVal !== "yes") {
      formData.value.vehicletype = 4;
    } else {
      formData.value.vehicletype = "";
    }
  });

  //Watch for budget
  watch([budgetMin, budgetMax], ([min, max]) => {
    budgetRange.value = [min, max]
    formData.value.budgetmin = min
    formData.value.budgetmax = max
  })

  watch(budgetRange, ([min, max]) => {
    budgetMin.value = min
    budgetMax.value = max
    formData.value.budgetmin = min
    formData.value.budgetmax = max
  })

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

    if (!formData.value.country) {
      customAlert("Selecciona un país.",
        'negative',
        'error',
        'top',
        3500);
      return false;
    }

    if (!formData.value.type) {
      customAlert("Selecciona amb qui viatges.",
        'negative',
        'error',
        'top',
        3500);
      return false;
    }

    if (!formData.value.vehicle) {
      customAlert("Selecciona el lloguer de vehicle",
        'negative',
        'error',
        'top',
        3500);
      return false;
    }

    if (!formData.value.vehicletype) {
      customAlert("Selecciona el tipus de vehicle.",
        'negative',
        'error',
        'top',
        3500);
      return false;
    }

    if (!formData.value.interests) {
      customAlert("Selecciona alguns interessos.",
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

  const handleSubmit = async () => {
    if (!validateForm()) return;

    // formData.value.budgetmin = budgetMin.value
    // formData.value.budgetmax = budgetMax.value

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

      if (dbResponse.code === 201) {
        const vehicleTypes = {
          1: "Bicicleta",
          2: "Moto",
          3: "Cotxe",
          4: "No vehicle"
        };

        const requestText = `
          Planifica un viatge per a ${formData.value.travelers} persones ${formData.value.type === 1 ? "sol" : `amb ${formData.value.type}`}.
          Destí: ${currentCountry.name}.
          Dates: del ${formData.value.datesinit} al ${formData.value.datesfinal}.
          Pressupost: entre ${formData.value.budgetmin}€ i ${formData.value.budgetmax}€.
          Interessos: ${formData.value.interests}.
          Vehicle: ${formData.value.vehicletype}.
          Tipus de vehicle: ${vehicleTypes[formData.value.vehicletype] || "No especificat"}.
          Cada dia ha d'incloure tos els seus detalls.
          El nombre de dies ha de coincidir amb els dies que t'he indicat abans.Gràcies.   
          Bastant detallat i a més que el resultat ha d'estar estructurat com un objecte que contingui un array anomenat dies, on cada element representa un dia del viatge.
          Exemple esperat:
          Retorna la resposta sempre en el mateix format.
          {
            "viatge": {
              "titol": "...",
              "dies": [
                {
                  "dia": Data del dia,
                  "resumDia": "(resum detallada del plan del dia)",
                  "paraulaClau": "(una paraula clau per a cada dia)",
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
          📌 **Important:** la resposta ha de ser **només un JSON vàlid**, **sense text introductori**, sense cap bloc de codi (res de \`\`\`json), i sense formatació markdown. Retorna només l'objecte JSON pur.
          Gràcies!
         `;

        router.push({ name: "loading" });

        const result = await getTravelGemini(requestText);

        await aiGeminiStore.setInitialResponse(result);

        await aiGeminiStore.setResponse(aiGeminiStore.initialResponse);

        console.log('Persistencia en pinia', aiGeminiStore.initialResponse);

        router.push({ name: "result" });
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

  const simulateTyping = async (message) => {
    isTyping.value = true;
    // Add a temporary typing message

    // Simulate typing delay
    await new Promise(resolve => setTimeout(resolve, 1000));

    // Remove typing message
    chatMessages.value = chatMessages.value.filter(msg => !msg.isTyping);

    // Add actual AI message
    chatMessages.value.push({
      text: message,
      isAI: true
    });

    isTyping.value = false;
  };

  const handleSubmitChat = async () => {
    if (!formDataChat.value.interests.trim()) return;

    chatMessages.value.push({
      text: formDataChat.value.interests,
      isAI: false
    });

    const userMessage = `Actúa como un asistente especializado en viajes y turismo. Tu única función es proporcionar información, consejos y asistencia relacionados con viajes, destinos, alojamientos, transportes, actividades turísticas, cultura e historia de destinos, equipaje, documentación de viaje, y temas similares. Si te dicen algo relacionado con el viaje el cual estais conversando debes proporcionar la informacion que te diga.

    Si el usuario hace una pregunta o solicitud que NO está relacionada con viajes o turismo, responde exactamente con, pero ATENCION, tiene que ser con el idioma el cual es se este comunicando contigo: "Em sap greu, només puc mantenir converses relacionades amb viatges i turisme. Hi ha res sobre destinacions, planificació de viatges o activitats turístiques en allò que et pugui ajudar?"

    Instrucciones importantes:
    1. No uses formato markdown en tus respuestas, solo texto plano. Nada de **negrita** o *cursiva*. 
    2. Responde siempre en catalán da igual en el idioma que te hable.
    3. Mantén tus respuestas informativas pero concisas.
    4. No proporciones información sobre temas no relacionados con viajes bajo ninguna circunstancia.
    5. No reformules preguntas no relacionadas con viajes para intentar responderlas.

    Solo debes actuar como un asistente de viajes, nada más.

    Si el usuario tiene alguna falta debes interpretarlo para poder seguir la conversacion.

    Si el usuario pide información sobre un destino, debes proporcionar información detallada y precisa sobre ese destino, incluyendo información sobre alojamiento, transporte, actividades turísticas, cultura e historia de ese destino.
    
    Esta es la peticion del usuario unicamente: ${formDataChat.value.interests}
    `;
    console.log(userMessage);

    formDataChat.value.interests = "";

    try {
      const response = await getTravelGemini(userMessage);
      await simulateTyping(response);
      isFirstMessage.value = false;
    } catch (error) {
      console.log(error);

      if (!isFirstMessage.value) {
        chatMessages.value = chatMessages.value.filter(msg => !msg.isTyping);
      }
      await simulateTyping("Ho sento, hi ha hagut un error processant la teva petició. Si us plau, torna-ho a intentar.");
    } finally {
      isTyping.value = false;
    }
  };

  const openChat = () => {
    isWindowOpen.value = !isWindowOpen.value;
    console.log('is window open: ', isWindowOpen.value);
    firstMessage()
  };

  const firstMessage = () => {
    // Reset first message state when opening window
    isFirstMessage.value = true;
    // Add welcome message when opening the window
    isTyping.value = false;
    if (chatMessages.value.length === 0) {
      chatMessages.value.push({
        text: `Hola <strong>${authStore.user.name}</strong>! Sóc el teu assistent de viatges. Com puc ajudar-te avui?`,
        isAI: true
      });
    }
  }

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
    // syncWithBudget,
    handleSubmit,
    loadInitialData,
    selectedType,
    vehicle,
    budgetRange,
    onSliderChange,
    isWindowOpen,
    openChat,
    formDataChat,
    handleSubmitChat,
    responseGemini,
    gemini,
    chatMessages,
    isTyping,
    isFirstMessage
  };
}