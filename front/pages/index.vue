<template>
  <header>
    <title>Triplan</title>
  </header>
  <div class="relative min-h-screen bg-gray-50 flex items-center justify-center">
    <!-- carrusel background -->
    <div class="absolute inset-0 w-full h-full">
      <!-- carrusel -->
      <Swiper class="mySwiper" :slides-per-view="1" :space-between="0" loop pagination :autoplay="{ delay: 2500 }">
        <SwiperSlide>
          <img src="~/assets/images/img1.png" alt="Destí 1" class="w-full h-full object-cover" />
        </SwiperSlide>
        <SwiperSlide>
          <img src="~/assets/images/img2.png" alt="Destí 2" class="w-full h-full object-cover" />
        </SwiperSlide>
        <SwiperSlide>
          <img src="~/assets/images/img3.png" alt="Destí 3" class="w-full h-full object-cover" />
        </SwiperSlide>
        <SwiperSlide>
          <img src="~/assets/images/img4.png" alt="Destí 4" class="w-full h-full object-cover" />
        </SwiperSlide>
        
      </Swiper>
    </div>

    <!-- welcome -->
    <div class="relative z-10 max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-12 text-center">
      <h1 class="text-5xl font-bold text-blue-600 mb-6">Benvingut a Triplan!</h1>
      <p class="text-xl text-gray-600 mb-8">El teu viatge comença aquí. Planifica el teu viatge perfecte amb nosaltres!
      </p>

      <div class="space-y-4">
        <button @click="index.handlePlanTrip"
          class="px-8 py-4 bg-blue-600 text-white text-lg rounded-lg hover:bg-blue-700 transition duration-200">
          Fes clic aquí per planificar el teu viatge! </button>

        <div v-if="!authStore.user" class="pt-4">
          <p class="text-gray-600 mb-4">Inicia sessió per planificar el teu viatge.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>

import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/swiper-bundle.css'; 
import { useIndex } from '~/composable/useIndex';
import { useAuthStore } from '~/store/authUser';

const authStore = useAuthStore();
const index = useIndex();
index

</script> 