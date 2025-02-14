import { useRoute, useRouter } from 'vue-router';
import { computed, ref, watch } from 'vue'; 
import { marked } from 'marked';

export function useResult() {
    
    // Captura el resultat de la query
    const route = useRoute();
    const router = useRouter();
    const response = ref(route.query.response ? JSON.parse(route.query.response) : null); 
    
    // function to stay alert if the new response changes
    watch(
      () => route.query.response,
      (newResponse) => {
        response.value = newResponse ? JSON.parse(newResponse) : null;
      }
    );
    
    // only select the text that we want to show
    const responseText = computed(() => {
      if (response.value && response.value.candidates && response.value.candidates[0]?.content?.parts[0]?.text) {
        return response.value.candidates[0].content.parts[0].text;
      }
      return null;
    });
    
    // convert markdown to html
    const formattedResponseText = computed(() => {
      if (responseText.value) {
        return marked(responseText.value);
      }
      return '';
    });
    
    // show option for confirmation
    const showConfirmation = ref(false);
    const showCancelOptions = () => {
      showConfirmation.value = true;
    };
    
    // function if we accept the plan
    const handleAccept = () => {
      alert("Planning del viatge guardat correctament");
      router.push("/"); 
    };
    
    // function for cancelation to return to home
    const handleCancel = () => {
      alert("El viatge s'ha cancel·lat.");
      router.push("/");
    };
    
    // function to generate a new trip
    async function generateNewTrip() {
      try {
        console.log('Generando un nuevo viaje con los datos anteriores...');
    
        // Asegúrate de que 'responseText' contiene los datos relevantes del viaje anterior
        const previousDataText = responseText.value;
        router.push({ name: 'loading' });
        // Crear el mensaje para la API, incluyendo los datos previos
        const newTripMessage = `
          Hazme un nuevo viaje basándote en estos datos:
          ${previousDataText}
        `;
    
        // Enviar los datos anteriores y el mensaje para generar un nuevo plan
        const response = await fetch('/api/gemini', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            text: newTripMessage // Aquí estamos enviando el mensaje que incluye los datos previos
          }),
        });
    
        if (!response.ok) {
          throw new Error('Error en la respuesta del servidor');
        }
    
        const data = await response.json(); // Aquí se espera un JSON válido
        console.log('Respuesta del servidor:', data);
    
        // Redirigir a la misma página pero con la nueva respuesta
        router.push({
          path: '/result',
          query: { response: JSON.stringify(data) }
        });
    
        showConfirmation.value = false;
    
      } catch (error) {
        console.error('Error al generar un nuevo viaje:', error);
      }
    }

    return {
        response,
        responseText,
        formattedResponseText,
        showConfirmation,
        showCancelOptions,
        handleAccept,
        handleCancel,
        generateNewTrip
    }
}