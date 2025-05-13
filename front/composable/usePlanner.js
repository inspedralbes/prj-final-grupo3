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

  // Chat bot vars
  const chatMessages = ref([]);
  const isTyping = ref(false);
  const isFirstMessage = ref(true);
  const isWindowOpen = ref(false)
  const geminiMemoryBank = ref('');
  const isLoading = ref(false);
  const STORAGE_KEY = 'tripplan_chat_memory';
  const MAX_MESSAGES = 50;
  const MAX_MEMORY_SIZE = 20000;
  const isOnline = ref(navigator.onLine);

  const dateRange = ref([]);
  const countries = ref([]);
  const filteredCountries = ref([]);
  const filteredMovilities = ref([]);
  const searchQuery = ref("");
  const showDropdown = ref(false);
  const budgetMax = ref(3500);
  const budgetMin = ref(250);
  const budgetRange = ref([budgetMin.value, budgetMax.value])
  const types = ref([]);
  const movilities = ref([]);
  // Key for local storage form
  const FORM_STORAGE_KEY = 'tripplan_form_data';
  const isFormLoading = ref(true);

  // Load initial data
  const loadInitialData = async () => {
    try {
      isFormLoading.value = true; // Activar estado de carga

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

      // Cargar el estado guardado inmediatamente
      await loadFormState();

    } catch (error) {
      console.error("Error carregant dades:", error);
      isFormLoading.value = false; // Desactivar incluso en caso de error
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

  // Función para guardar el estado del formulario
  const saveFormState = () => {
    try {
      // Extraer solo los datos necesarios
      const formDataToSave = {
        country: formData.value.country,
        datesinit: formData.value.datesinit,
        datesfinal: formData.value.datesfinal,
        travelers: formData.value.travelers,
        interests: formData.value.interests,
        type: formData.value.type,
        budgetmin: formData.value.budgetmin,
        budgetmax: formData.value.budgetmax,
        vehicle: formData.value.vehicle,
        vehicletype: formData.value.vehicletype
      };

      // Guardar en localStorage
      localStorage.setItem(FORM_STORAGE_KEY, JSON.stringify(formDataToSave));
      console.log('Estado del formulario guardado');
      return true;
    } catch (error) {
      console.error('Error al guardar el estado del formulario:', error);
      return false;
    }
  };

  // Función para cargar el estado del formulario
  const loadFormState = async () => {
    try {
      isFormLoading.value = true;

      const savedForm = localStorage.getItem(FORM_STORAGE_KEY);
      if (!savedForm) {
        isFormLoading.value = false;
        return false;
      }

      const parsedForm = JSON.parse(savedForm);

      await new Promise(resolve => setTimeout(resolve, 300));

      // Actualizar los valores del formulario
      formData.value = {
        ...formData.value,
        ...parsedForm
      };

      // Sincronizar otros valores relacionados
      if (parsedForm.datesinit && parsedForm.datesfinal) {
        dateRange.value = [parsedForm.datesinit, parsedForm.datesfinal];
      }

      if (parsedForm.budgetmin !== undefined && parsedForm.budgetmax !== undefined) {
        budgetMin.value = parsedForm.budgetmin;
        budgetMax.value = parsedForm.budgetmax;
        budgetRange.value = [parsedForm.budgetmin, parsedForm.budgetmax];
      }

      // Actualizar búsqueda de país si está disponible
      if (parsedForm.country && countries.value.length > 0) {
        const selectedCountry = countries.value.find(c => c.id === parsedForm.country);
        if (selectedCountry) {
          searchQuery.value = selectedCountry.name;
        }
      }

      console.log('Estado del formulario cargado');
      isFormLoading.value = false;
      return true;
    } catch (error) {
      console.error('Error al cargar el estado del formulario:', error);
      isFormLoading.value = false;
      return false;
    }
  };

  // Función para limpiar el estado guardado
  const clearFormState = () => {
    localStorage.removeItem(FORM_STORAGE_KEY);

    // Restablecer valores predeterminados
    formData.value = {
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
    };

    dateRange.value = [];
    budgetMin.value = 250;
    budgetMax.value = 3500;
    budgetRange.value = [250, 3500];
    searchQuery.value = "";
  };

  // Función para resetear el formulario (para exponer al usuario)
  const resetForm = () => {
    clearFormState();
    customAlert("Formulari restablert correctament.",
      'info',
      'info',
      'top',
      2000);
  };

  watch(() => ({ ...formData.value }), () => {
    saveFormState();
  }, { deep: true });

  watch([dateRange, budgetRange], () => {
    saveFormState();
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

  function cleanGeminiResponse(response) {
    // Primero, eliminamos cualquier texto antes del primer {
    let cleanedResponse = response.trim();
    const firstBraceIndex = cleanedResponse.indexOf('{');
    if (firstBraceIndex > 0) {
      cleanedResponse = cleanedResponse.substring(firstBraceIndex);
    }

    // Eliminamos cualquier texto después del último }
    const lastBraceIndex = cleanedResponse.lastIndexOf('}');
    if (lastBraceIndex !== -1 && lastBraceIndex < cleanedResponse.length - 1) {
      cleanedResponse = cleanedResponse.substring(0, lastBraceIndex + 1);
    }

    // Eliminar específicamente los bloques de código markdown ```json ... ```
    cleanedResponse = cleanedResponse.replace(/```json\s*/g, '');
    cleanedResponse = cleanedResponse.replace(/```\s*$/g, '');

    return cleanedResponse;
  }

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
        Cada dia ha d'incloure tots els seus detalls.
        El nombre de dies ha de coincidir amb els dies que t'he indicat abans. Gràcies.
        Bastant detallat i a més que el resultat ha d'estar estructurat com un objecte que contingui un array anomenat dies, on cada element representa un dia del viatge.
        
        HA D'INCLOURE OBLIGATÒRIAMENT la següent informació per poder representar la ruta en un mapa:
        
        "coordenades": {
          "centre_mapa": {
            "coords": [00.000000, 00.000000]
          },
          "nivel_zoom": 15,
          "rutes_per_dia": [
            {
              "dia_index": 0,
              "color": "#HEX",
              "llocs": [
                {
                  "id": 1,
                  "nom": "Nom del lloc",
                  "descripcio": "Descripció del lloc",
                  "google_maps_url": "https://www.google.com/maps/search/nom+del+lloc",
                  "coords": [00.000000, 00.000000]
                },
                {
                  "id": 2,
                  "nom": "Nom del lloc",
                  "descripcio": "Descripció del lloc",
                  "google_maps_url": "https://www.google.com/maps/search/nom+del+lloc",
                  "coords": [00.000000, 00.000000]
                }
              ],
              "orden_visita": [1, 2, ...],
              "distancia_total_metres": 1200
            },
            {
              "dia_index": 1,
              "color": "#DIFERENT_HEX",
              "llocs": [
                // llocs pel segon dia
              ],
              "orden_visita": [5, 6, ...],
              "distancia_total_metres": 1500
            }
            // Continua per cada dia...
          ]
        }
        
        Les coordenades han de ser precises amb 6 decimals. 
        Cada dia ha de tenir un color diferent i distintiu en format hexadecimal (#FF5733, #4287f5, etc.).
        Els colors han de ser llegibles en un mapa i han de contrastar entre ells.
        Suggeriments de colors per dia: Dia 1 = "#3366CC", Dia 2 = "#DC3912", Dia 3 = "#FF9900", Dia 4 = "#109618", Dia 5 = "#990099".
        
        📌 **Important:** la resposta ha de ser **només un JSON vàlid**, **sense text introductori**, sense cap bloc de codi (res de \`\`\`json), i sense formatació markdown. Retorna només l'objecte JSON pur.
        Exemple esperat:
        {
          "viatge": {
            "titol": "...",
            "dies": [
              {
                "dia": "Data del dia",
                "allotjament": "...",
                "color_dia": "#HEX", // Color que identifica aquest dia, igual que a rutes_per_dia
                "activitats": [
                  {
                    "nom": "...",
                    "descripcio": "...",
                    "preu": "...",
                    "horari": "...",
                    "ubicacio": {
                      "nom": "Nom del lloc",
                      "google_maps_url": "https://www.google.com/maps/search/nom+del+lloc"
                    }
                  },
                  ...
                ]
              }
            ],
            "preuTotal": "...",
            "coordenades": {
              "centre_mapa": {
                "coords": [00.000000, 00.000000]
              },
              "nivel_zoom": 15,
              "rutes_per_dia": [
                {
                  "dia_index": 0,
                  "color": "#HEX", // Mateix color que color_dia del primer dia
                  "llocs": [
                    {
                      "id": 1,
                      "nom": "Nom del lloc",
                      "descripcio": "Descripció del lloc",
                      "google_maps_url": "nom del lloc amb adreça completa",
                      "coords": [00.000000, 00.000000]
                    },
                    ...
                  ],
                  "orden_visita": [1, 2, ...],
                  "distancia_total_metres": 1200
                },
                ...
              ]
            }
          }
        }
        
        📌 **MOLT IMPORTANT sobre les URLs de Google Maps:**
        
        Per a cada lloc, DEUS generar una URL de Google Maps completa i funcional.

        Quan retornis l'google_maps_url, te que se com si jo anes a google maps i busques el lloc.
        
        La URL ha de ser completa i funcional, ja que quan es carregui al mapa, ha de mostrar el lloc exactament com si anes a Google Maps.
        
        NO deixis cap lloc sense URL de Google Maps.
        NO proporcions només el nom del lloc en el camp google_maps_url.
        
        Els colors tenen que representar un dia en concret i ser consistents en tot el JSON.
        Si una activitat del dia 1 té color "#3366CC", totes les activitats i rutes d'aquell dia han de tenir el mateix color.
        Els colors han de ser diferents per cada dia per distingir clarament les rutes al mapa.
        
        Tota la informació ha d'estar en català.
        Gràcies!
       `;

        router.push({ name: "loading" });

        const result = await getTravelGemini(requestText);

        const cleanedResult = cleanGeminiResponse(result);

        await aiGeminiStore.setInitialResponse(cleanedResult);

        await aiGeminiStore.setResponse(aiGeminiStore.initialResponse);

        await aiGeminiStore.setLatestTravelId(dbResponse.travel_id);

        console.log('Persistencia en pinia: ', aiGeminiStore.initialResponse);

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

  // Chat bot functions

  // Function for manage size conversation
  const trimConversationIfNeeded = () => {
    // Limit number of messages for performance
    if (chatMessages.value.length > MAX_MESSAGES) {
      const excessMessages = chatMessages.value.length - MAX_MESSAGES;
      chatMessages.value = chatMessages.value.slice(excessMessages);
    }

    // Limit memory bank size
    if (geminiMemoryBank.value.length > MAX_MEMORY_SIZE) {
      // Found point for cutting (after a complete message)
      const cutPoint = geminiMemoryBank.value.indexOf("\n\n", geminiMemoryBank.value.length - MAX_MEMORY_SIZE);
      if (cutPoint > 0) {
        // Save initial context and cut the rest
        const initialContext = geminiMemoryBank.value.substring(0, geminiMemoryBank.value.indexOf("\n\nUsuario:"));
        const trimmedConversation = geminiMemoryBank.value.substring(cutPoint);
        geminiMemoryBank.value = initialContext + trimmedConversation;
      }
    }
  };

  const simulateTyping = async (text) => {
    isTyping.value = true;

    // Wait for typing animation
    await new Promise(resolve => setTimeout(resolve, 1500));

    // Add the final message directly
    chatMessages.value.push({
      text: text,
      isAI: true,
    });

    isTyping.value = false;
  };

  // Load memory bank from local storage 
  const loadMemoryBank = () => {
    try {
      const savedMemory = localStorage.getItem(STORAGE_KEY);
      const timestamp = localStorage.getItem(STORAGE_KEY + '_timestamp');

      // Verificar si los datos son recientes (menos de 24 horas)
      const isRecent = timestamp && (Date.now() - parseInt(timestamp)) < 24 * 60 * 60 * 1000;

      if (savedMemory && isRecent) {
        geminiMemoryBank.value = savedMemory;

        // Cargar mensajes y descomprimir
        const savedMessages = localStorage.getItem(STORAGE_KEY + '_messages');
        if (savedMessages) {
          try {
            const parsedMessages = JSON.parse(savedMessages);
            chatMessages.value = parsedMessages.map(msg => ({
              text: msg.t,
              isAI: msg.a === 1
            }));
          } catch {
            // Si hay error en el parsing, comenzar con chat vacío
            chatMessages.value = [];
          }
        }

        return true;
      } else if (!isRecent && savedMemory) {
        // Datos antiguos, ofrecer cargar o comenzar nuevo
        return 'expired';
      }

      return false;
    } catch (error) {
      console.error('Error loading memory bank:', error);
      return false;
    }
  };

  // Prevent prompt injection
  const sanitizePrompt = (prompt) => {
    // Evitar que el usuario manipule el prompt base
    return prompt
      .replace(/actuar como|comportarte como|simular ser|fingir ser|ignorar|olvidar/gi, '[redactado]')
      .replace(/instrucciones anteriores|cambiar rol|nuevo rol/gi, '[redactado]');
  };

  // Safe the memory bank in local storage
  const saveMemoryBank = () => {
    try {
      if (geminiMemoryBank.value) {
        localStorage.setItem(STORAGE_KEY, geminiMemoryBank.value);
        // Añadir timestamp para saber cuándo se guardó
        localStorage.setItem(STORAGE_KEY + '_timestamp', Date.now().toString());
      }

      if (chatMessages.value.length > 0) {
        // Comprimir los mensajes para ahorrar espacio en localStorage
        const compressedMessages = JSON.stringify(chatMessages.value.map(msg => ({
          t: msg.text,
          a: msg.isAI ? 1 : 0
        })));
        localStorage.setItem(STORAGE_KEY + '_messages', compressedMessages);
      }

      // Guardar estado actual para recuperación
      const currentState = {
        country: formData.value.country,
        dateInit: formData.value.datesinit,
        dateFinal: formData.value.datesfinal,
        interests: formData.value.interests,
        // Otros campos relevantes
      };
      localStorage.setItem(STORAGE_KEY + '_state', JSON.stringify(currentState));

      return true;
    } catch (error) {
      console.error('Error saving memory bank:', error);
      return false;
    }
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
      - No usar formato markdown, solo texto plano, nada de *,' o \`\`\` 
      - Mantener respuestas informativas pero concisas
    `;
    }

    // Add new message to the history
    geminiMemoryBank.value += `\n\n${role}: ${message}`;

    saveMemoryBank();

    return geminiMemoryBank.value;
  };

  // Basic analisys the feelings of the user
  const analyzeUserSentiment = (message) => {
    const lowerMsg = message.toLowerCase();

    // Palabras positivas
    const positiveWords = ['genial', 'fantàstic', 'increïble', 'gràcies', 'bo', 'molt bé', 'excel·lent'];

    // Palabras negativas
    const negativeWords = ['malament', 'terrible', 'horrible', 'no m\'agrada', 'error', 'problema', 'mala'];

    // Palabras de frustración
    const frustrationWords = ['no entens', 'no m\'ajudes', 'inútil', 'no funciona', 'repetint'];

    let score = 0;

    // Contar ocurrencias
    positiveWords.forEach(word => {
      if (lowerMsg.includes(word)) score += 1;
    });

    negativeWords.forEach(word => {
      if (lowerMsg.includes(word)) score -= 1;
    });

    frustrationWords.forEach(word => {
      if (lowerMsg.includes(word)) score -= 2; // Doble peso para frustración
    });

    // Determinar sentimiento
    if (score >= 2) return 'positive';
    if (score <= -2) return 'negative';
    if (score <= -4) return 'frustrated';
    return 'neutral';
  };

  // Handle send chat messages
  const handleSubmitChat = async () => {
    if (!formDataChat.value.interests.trim()) return;

    const userMessage = formDataChat.value.interests;
    const sanitizedMessage = sanitizePrompt(userMessage);

    // Analyze user sentiment
    const sentiment = analyzeUserSentiment(userMessage);

    // Add message to chat UI user
    chatMessages.value.push({
      text: userMessage,
      isAI: false
    });

    // Add message user to memory bank but sinatized by AI
    const prompt = updateMemoryBank('Usuario', sanitizedMessage);

    // Adjust prompt based on user sentiment
    if (sentiment === 'frustrated') {
      // Add instruction for more direct and helpfule respon
      prompt += "\n\nATENCIÓN: El usuario muestra frustración. Proporciona respuestas directas, claras y extremadamente útiles. Evita respuestas largas, céntrate en soluciones concretas.";
    } else if (sentiment === 'negative') {
      // Be empathetic and solve the problem
      prompt += "\n\nATENCIÓN: El usuario muestra insatisfacción. Sé empático y céntrate en resolver su problema específico. Ofrece alternativas claras.";
    } else if (sentiment === 'positive') {
      // Stay positive and optimist
      prompt += "\n\nATENCIÓN: El usuario muestra satisfacción. Mantén un tono positivo y optimista en tu respuesta.";
    }

    // Clear input
    formDataChat.value.interests = "";

    try {
      // isTyping.value = true;

      if (!isOnline.value) {
        chatMessages.value.push({
          text: "No es poden enviar missatges sense connexió a Internet.",
          isAI: true
        });
        return;
      }

      const response = await getTravelGemini(prompt);

      await simulateTyping(response);

      // Add response to memory bank
      updateMemoryBank('Asistente', response);

      trimConversationIfNeeded()
    } catch (error) {
      console.error("Error en el chatbot:", error);

      // Delete message if exists 
      chatMessages.value = chatMessages.value.filter(msg => !msg.isTyping);

      isTyping.value = false;
      chatMessages.value.push({
        text: "Ho sento, ha ocorregut un error inesperat. Pots tornar a provar-ho? Si el problema persisteix, actualitza la pàgina.",
        isAI: true
      });

      // Try load the memory bank if is necessary
      if (error.message.includes('memory') || error.message.includes("storage")) {
        setTimeout(() => {
          try {
            loadMemoryBank();
          } catch (e) {
            // Silent recovery
          }
        }, 2000);
      }
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
        // isTyping.value = true;

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

    isWindowOpen.value = false
  };

  // Save when the component is closed
  onBeforeUnmount(() => {
    saveMemoryBank();
  });

  // Conection detectors
  onMounted(() => {
    window.addEventListener('online', () => { isOnline.value = true });
    window.addEventListener('offline', () => { isOnline.value = false });

    window.addEventListener('beforeunload', saveFormState);

  });

  onBeforeUnmount(() => {
    window.removeEventListener('online', () => { isOnline.value = true });
    window.removeEventListener('offline', () => { isOnline.value = false });

    window.removeEventListener('beforeunload', saveFormState);
    saveFormState();

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
    isOnline,
    saveFormState,
    loadFormState,
    resetForm,
    isFormLoading,
  };
}