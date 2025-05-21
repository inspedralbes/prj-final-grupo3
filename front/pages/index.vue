<template>
  <header>
    <title>Triplan</title>
  </header>
  <div class="flex flex-col min-h-screen">
    <div class="relative flex-1 flex items-center justify-center">
      <!-- carrusel background -->
      <div class="absolute inset-0">
        <Swiper effect="fade" class="h-full" :modules="[Autoplay, Pagination, EffectFade]" :slides-per-view="1"
          :space-between="0" :loop="true" :autoplay="{ delay: 2500 }" :pagination="true" :speed="1000">
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
      <div class="relative z-10 max-w-2xl mx-auto bg-white/90 backdrop-blur-sm rounded-lg shadow-lg p-12 text-center">
        <h1 class="text-5xl font-bold text-blue-600 mb-6">Benvingut a Triplan!</h1>
        <p class="text-xl text-gray-600 mb-8">El teu viatge comença aquí. Planifica el teu viatge perfecte amb
          nosaltres!
        </p>

        <div class="space-y-4">
          <button @click="index.handlePlanTrip"
            class="px-8 py-4 bg-blue-600 text-white text-lg rounded-lg hover:bg-blue-700 transition duration-200">
            Fes clic aquí per planificar el teu viatge! 
          </button>

          <div class="mt-4">
            <NuxtLink to="/explore">
              <button class="px-8 py-4 bg-orange-500 text-white text-lg rounded-lg hover:bg-orange-600 transition duration-200">
                Descobreix viatges destacats 🔍
              </button>
            </NuxtLink>
          </div>

          <div v-if="!authStore.user" class="pt-4">
            <p class="text-gray-600 mb-4">Inicia sessió per planificar el teu viatge.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>

import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, EffectFade, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/swiper-bundle.css';
import { useIndex } from '~/composable/useIndex';
import { useAuthStore } from '~/store/authUser';

const authStore = useAuthStore();
const index = useIndex();

</script>