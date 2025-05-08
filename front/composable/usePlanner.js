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
    budgetmax: 7500,
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
  const geminiMemoryBank = ref('');
  const isLoading = ref(false);

  const STORAGE_KEY = 'tripplan_chat_memory';

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

  const simulateTyping = async (text) => {
    isTyping.value = true;

    const typingMessageIndex = chatMessages.value.push({
      isAI: true,
      // isTyping: true
    }) - 1;

    await new Promise(resolve => setTimeout(resolve, 1500));

    // Replace message with real response
    chatMessages.value[typingMessageIndex] = {
      text: text,
      isAI: true,
      // isTyping: false
    };

    isTyping.value = false;
  };

  // Load memory bank from local storage 
  const loadMemoryBank = () => {
    const savedMemory = localStorage.getItem(STORAGE_KEY);
    if (savedMemory) {
      geminiMemoryBank.value = savedMemory;

      // Load after messafes
      const savedMessages = localStorage.getItem(STORAGE_KEY + '_messages');
      if (savedMessages) {
        chatMessages.value = JSON.parse(savedMessages);
      }
    }
  };

  // Safe the memory bank in local storage
  const saveMemoryBank = () => {
    localStorage.setItem(STORAGE_KEY, geminiMemoryBank.value);
    localStorage.setItem(STORAGE_KEY + '_messages', JSON.stringify(chatMessages.value));
  };

  // Function for adding a message to the memory bank
  const updateMemoryBank = (role, message) => {
    // If memory bank is empty, initialize it with the system context
    if (!geminiMemoryBank.value) {
      geminiMemoryBank.value = `
      Historial de conversación entre un asistente de viajes y un usuario:
      
      Contexto del viaje:
      Destino: ${formData.value.country ? countries.value.find(c => c.id === formData.value.country)?.name : "No especificado"}
      Fechas: ${formData.value.datesinit ? `${formData.value.datesinit} a ${formData.value.datesfinal}` : "No especificadas"}
      Presupuesto: ${formData.value.budgetmin || 0}€ - ${formData.value.budgetmax || 0}€
      Intereses: ${formData.value.interests || "No especificados"}
      Viajeros: ${formData.value.travelers || 1}
      
      Instrucciones para el asistente:
      - Responder siempre en catalán
      - Proporcionar información precisa sobre viajes y turismo
      - No usar formato markdown, solo texto plano
      - Mantener respuestas informativas pero concisas
    `;
    }

    // Add new message to the history
    geminiMemoryBank.value += `\n\n${role}: ${message}`;

    saveMemoryBank();

    return geminiMemoryBank.value;
  };

  // Handle send chat messages
  const handleSubmitChat = async () => {
    if (!formDataChat.value.interests.trim()) return;

    const userMessage = formDataChat.value.interests;

    // Add message to chat UI user
    chatMessages.value.push({
      text: userMessage,
      isAI: false
    });

    // Add message user to memory bank
    const prompt = updateMemoryBank('Usuario', userMessage);

    // Clear input
    formDataChat.value.interests = "";

    try {
      isTyping.value = true;

      const response = await getTravelGemini(prompt);

      await simulateTyping(response);

      // Add response to memory bank
      updateMemoryBank('Asistente', response);
    } catch (error) {
      console.error("Error al comunicarse con Gemini:", error);

      // Delete message if exists 
      chatMessages.value = chatMessages.value.filter(msg => !msg.isTyping);

      await simulateTyping("Ho sento, hi ha hagut un error processant la teva petició. Si us plau, torna-ho a intentar.");
    } finally {
      isTyping.value = false;
    }
  };

  const resetTextAreaHeight = (event) => {
    event.target.style.height = '36px'
  }

  const openChat = async () => {
    isLoading.value = true;

    // Load memory bank if exists
    loadMemoryBank();

    // If not previus messages, generate a welcome message
    if (chatMessages.value.length === 0) {
      const vehicleTypes = {
        1: "Bicicleta",
        2: "Moto",
        3: "Cotxe",
        4: "No vehicle"
      };

      const countreySelected = countries.value.find(country => country.id === formData.value.country);
      const currentCountry = countreySelected ? countreySelected.name : "de moment sense desti seleccionat per l'usauri";

      let dateTravel = (!formData.value.datesinit && !formData.value.datesfinal)
        ? "No ha seleccionat cap data"
        : `del ${formData.value.datesinit} al ${formData.value.datesfinal}`;

      const interesos = formData.value.interests || "No ha seleccionat cap interes";
      const vehicle = formData.value.vehicle || "No ha seleccionat cap vehicle";

      // Crear prompt inicial con información del formulario
      const initialPrompt = `
      Actúa exclusivamente como un asistent especialitzat en viatges i turisme. La teva única funció és proporcionar informació, consells i assistència relacionats amb viatges, destinacions, allotjaments, transports, activitats turístiques, cultura i història de destinacions.
    
      Amb aquesta informació has d'assistir a l'usuari per poder planificar el seu viatge a mida:
      ${formData.value.travelers} persones ${formData.value.type === 1 ? "sol" : `amb ${formData.value.type}`}.
      Destí: ${currentCountry}.
      Dates: ${dateTravel}.
      Pressupost: entre ${formData.value.budgetmin || 0}€ i ${formData.value.budgetmax || 0}€.
      Interessos: ${interesos}.
      Vehicle: ${vehicle}.
      Tipus de vehicle: ${vehicleTypes[formData.value.vehicletype] || "No especificat"}.
    
      Instruccions importants:
      1. Respon sempre en català independentment de l'idioma en què et parli l'usuari.
      2. No utilitzis format markdown a les teves respostes, només text pla. Res de **negreta** o *cursiva*.
      3. Mantén les teves respostes informatives però concises.
      4. No proporcionis informació sobre temes no relacionats amb viatges sota cap circumstància.
      5. Si l'usuari fa una pregunta o sol·licitud que NO està relacionada amb viatges o turisme, respon exactament amb: "Em sap greu, només puc mantenir converses relacionades amb viatges i turisme. Hi ha res sobre destinacions, planificació de viatges o activitats turístiques en què et pugui ajudar?"
      6. Estructura bé el text perquè l'usuari l'entengui el millor possible.
      7. Si l'usuari té alguna falta has d'interpretar-la per poder seguir la conversa.
    
      Centra't en donar informació detallada i útil sobre allotjament, transport, activitats, atraccions, gastronomia, pressupost i consells pràctics per al viatge especificat.
    
      Recorda que ets NOMÉS un assistent de viatges i no pots proporcionar informació sobre cap altre tema.
    `;

      // Initialize memory bank and add system instruction
      geminiMemoryBank.value = '';
      updateMemoryBank('Sistema', initialPrompt);

      try {
        isTyping.value = true;

        // Get initial response from Gemini
        const response = await getTravelGemini(geminiMemoryBank.value);

        // Show response
        await simulateTyping(response);

        // Add response to memory bank
        updateMemoryBank('Asistente', response);
      } catch (error) {
        console.error("Error al inicializar el chat:", error);
        await simulateTyping("Ho sento, hi ha hagut un error iniciant la conversa. Si us plau, torna-ho a intentar.");
      } finally {
        isTyping.value = false;
      }
    }

    isWindowOpen.value = true;
    isLoading.value = false;
  };

  // const firstMessage = () => {
  //   // Reset first message state when opening window
  //   isFirstMessage.value = true;
  //   // Add welcome message when opening the window
  //   isTyping.value = false;
  //   if (chatMessages.value.length === 0) {
  //     chatMessages.value.push({
  //       text: `Hola <strong>${authStore.user.name}</strong>! Sóc el teu assistent de viatges. Com puc ajudar-te avui?`,
  //       isAI: true
  //     });
  //   }
  // }

  // Clear conversation
  const clearConversation = () => {
    chatMessages.value = [];
    geminiMemoryBank.value = '';
    localStorage.removeItem(STORAGE_KEY);
    localStorage.removeItem(STORAGE_KEY + '_messages');
    customAlert("Conversa esborrada correctament.",
      'positive',
      'success',
      'top-end',
      3500);
  };

  // Save when the component is closed
  onBeforeUnmount(() => {
    saveMemoryBank();
  });

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
    isFirstMessage,
    resetTextAreaHeight,
    saveMemoryBank,
    clearConversation,
    isLoading,
  };
}