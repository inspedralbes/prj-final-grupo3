

<template>
  <title>Triplan</title>
  <div class="p-6 max-w-screen-xl mx-auto">
    <h1 class="text-4xl font-bold text-center text-blue-700 mb-10">Viatges destacats per inspirar-te ✈️</h1>

    <!-- <div v-if="loading" class="text-center text-gray-500 text-lg">Carregant viatges...</div> -->
    <div v-if="loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <div v-for="n in 6" :key="n"
        class="max-w-sm p-4 border border-gray-200 rounded-2xl shadow animate-pulse bg-white">
        <div class="w-full h-48 bg-gray-200 rounded mb-4"></div>
        <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
        <div class="h-3 bg-gray-200 rounded w-5/6 mb-4"></div>
        <div class="h-10 bg-gray-300 rounded w-32"></div>
        <span class="sr-only">Carregant...</span>
      </div>
    </div>

    <div v-else-if="error" class="text-red-500 text-center">{{ error }}</div>

    <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <div v-for="trip in trips" :key="trip.id"
        class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1 hover:scale-[1.02]">
        <img :src="trip.cover_image || '/default-trip.jpg'" alt="Imatge viatge" class="w-full h-48 object-cover" />
        <div class="p-5">
          <h2 class="text-xl font-semibold text-gray-800 mb-2 truncate">{{ trip.title }}</h2>
          <p class="text-sm text-gray-600 line-clamp-3 mb-4">
            {{ trip.description || 'Sense descripció disponible' }}
          </p>
          <NuxtLink :to="`/trip/${trip.id}`"
            class="inline-block mt-auto bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Veure viatge
          </NuxtLink>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useExplore } from '../composable/useExplore';

const { trips, loading, error, loadHighlightedTrips } = useExplore()

onMounted(() => {
  loadHighlightedTrips()
})
</script>


<style scoped>
/* Per tallar text bonic */
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>