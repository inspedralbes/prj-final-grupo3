<template>
    <div class="max-w-4xl mx-auto px-4 py-10">
      <div v-if="loading" class="animate-pulse space-y-4">
        <div class="w-full h-80 bg-gray-200 rounded-xl"></div>
        <div class="h-6 bg-gray-200 rounded w-2/3 mt-6"></div>
        <div class="h-4 bg-gray-200 rounded w-full"></div>
        <div class="h-4 bg-gray-200 rounded w-5/6"></div>
      </div>
  
      <div v-else-if="error" class="text-red-500 text-center">{{ error }}</div>
  
      <TripDetails v-else :trip="trip" />
    </div>
  </template>
  
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { useRoute } from 'vue-router'
  import { getTripById } from '~/services/communicationManager';
  import TripDetails from '~/components/TripDetails.vue'    
  
  const route = useRoute()
  const trip = ref(null)
  const loading = ref(true)
  const error = ref(null)
  
  onMounted(async () => {
    try {
        const response = await getTripById(route.params.id)
      trip.value = response
    } catch (err) {
      error.value = 'No s\'ha pogut carregar el viatge.'
    } finally {
      loading.value = false
    }
  })
  </script>
  