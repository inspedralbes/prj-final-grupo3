import { ref } from 'vue'
import { getHighlightedTrips } from '~/services/communicationManager'

export function useExplore() {
  const trips = ref([])
  const loading = ref(false)
  const error = ref(null)

  async function loadHighlightedTrips() {
    loading.value = true
    error.value = null

    try {
      const data = await getHighlightedTrips()
      trips.value = data
    } catch (err) {
      error.value = 'No s\'han pogut carregar els viatges destacats.'
    } finally {
      loading.value = false
    }
  }

  return {
    trips,
    loading,
    error,
    loadHighlightedTrips
  }
}
