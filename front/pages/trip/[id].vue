<template>
    <div class="max-w-4xl mx-auto px-4 py-10">
      <Breadcrumb :crumbs="[
        { label: 'Explora', to: '/explore' },
        { label: trip?.title || 'Carregant...' }
      ]" />
  
      <TripDetails v-if="trip" :trip="trip" />      

      <TripComment v-if="trip" :tripId="trip.id" />

  
      <div v-else-if="loading" role="status" class="p-4 border border-gray-200 rounded-xl shadow animate-pulse md:p-6">
        <div class="h-64 bg-gray-300 rounded w-full mb-4"></div>
        <div class="h-6 bg-gray-300 rounded w-1/2 mb-2"></div>
        <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
        <div class="h-4 bg-gray-200 rounded w-2/3 mb-4"></div>
        <div class="h-10 bg-gray-300 rounded w-32"></div>
        <span class="sr-only">Carregant...</span>
      </div>
  
      <div v-else-if="error" class="text-red-500 text-center">{{ error }}</div>


    </div>
  </template>
  
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { useRoute } from 'vue-router'
  import { getTripById } from '~/services/communicationManager'
  import TripDetails from '~/components/TripDetails.vue'
  import Breadcrumb from '~/components/Breadcrumb.vue'
  import TripComment from '~/components/TripComment.vue'

  
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
  