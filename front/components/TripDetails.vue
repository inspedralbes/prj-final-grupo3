<template>
  <div class="bg-white shadow-lg rounded-xl overflow-hidden">
    <img :src="trip.cover_image" alt="Portada del viatge" class="w-full h-80 object-cover" />
    <div class="p-6">
      <h1 class="text-3xl font-bold text-blue-700 mb-4">{{ trip.title }}</h1>
      <p class="text-gray-700 text-lg">{{ trip.description }}</p>
    </div>

    <div v-if="trip.description2" class="bg-gray-100 p-4 rounded-lg mt-6">
      <h2 class="text-xl font-semibold text-gray-800 mb-2">Proposta de viatge</h2>
      <p class="text-gray-600 whitespace-pre-line">{{ trip.description2 }}</p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  trip: {
    type: Object,
    required: true
  }
})
</script>
