import { ref, computed, onMounted } from 'vue';
import { useAuthStore } from '~/store/authUser';
import { getUserTravelHistory, deleteTravelTicket } from '@/services/communicationManager';

export function useTripDetails() {
  const authStore = useAuthStore();
  const travelData = ref([]);
  const searchQuery = ref('');

  const loadTravelHistory = async () => {
    try {
      const data = await getUserTravelHistory(authStore.user.id, authStore.token);
      travelData.value = data.travels;
    } catch (error) {
      console.error('Error carregant el historial de viatges:', error);
    }
  };

  const filteredTrips = computed(() => {
    const query = searchQuery.value.toLowerCase();

    return travelData.value.filter(travel => {
      const countryName = travel?.country?.name?.toLowerCase() || '';
      const dateInit = travel?.date_init ? new Date(travel.date_init).toLocaleDateString('es-ES') : '';
      const dateEnd = travel?.date_end ? new Date(travel.date_end).toLocaleDateString('es-ES') : '';
      const minBudget = travel?.budget.min_budget?.toString() + '€' || '';
      const maxBudget = travel?.budget.max_budget?.toString() + '€' || '';
      const movility = travel?.movility?.type || '';
      const quantDate = travel?.qunt_date?.toString() + ' dies' || '';

      return (
        countryName.includes(query) ||
        dateInit.includes(query) ||
        dateEnd.includes(query) ||
        minBudget.includes(query) ||
        maxBudget.includes(query) ||
        movility.includes(query) ||
        quantDate.includes(query)
      );
    });
  });

  const deleteTravel = async (travelId) => {
    if (confirm('Vols eliminar aquest viatge?')) {
      console.log('Deleting travel with ID:', travelId);

      navigateTo('/loading');

      try {
        const data = await deleteTravelTicket(authStore.user.id, travelId, authStore.token);

        if (data) {
          console.log('Viatge eliminat correctament:', data);
          navigateTo('/trip-details');
        }
      } catch (error) {
        console.error('Error eliminant el viatge:', error);
        navigateTo('/');
      }
    }
  }

  onMounted(loadTravelHistory);

  return {
    searchQuery,
    filteredTrips,
    deleteTravel,
    loadTravelHistory,
  };
}