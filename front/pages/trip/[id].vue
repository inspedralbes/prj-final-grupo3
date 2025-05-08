<template>
    <div class="max-w-4xl mx-auto px-4 py-10">
      <Breadcrumb :crumbs="[
        { label: 'Explora', to: '/explore' },
        { label: trip?.title || 'Carregant...' }
      ]" />
  
      <TripDetails v-if="trip" :trip="trip" />
      <div v-else-if="loading" class="text-center text-gray-500 text-lg">Carregant viatge...</div>
      <div v-else-if="error" class="text-red-500 text-center">{{ error }}</div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { useRoute } from 'vue-router'
  import { getTripById } from '~/services/communicationManager'
  import TripDetails from '~/components/TripDetails.vue'
  import Breadcrumb from '~/components/Breadcrumb.vue'
  
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
  