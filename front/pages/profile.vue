<template>
  <div class="flex items-center justify-center min-h-[90vh] relative">
    <div class="absolute inset-0">
        <Swiper effect="fade" class="h-full" :modules="[Autoplay, Pagination, EffectFade]" :slides-per-view="1" :space-between="0" :loop="true"
          :autoplay="{ delay: 2500 }" :pagination="true" :speed="1000">
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

    <div class="shadow-lg rounded-xl w-full md:w-1/3 md:min-h-[60vh] p-3 z-10 bg-white/90 backdrop-blur-sm">
      <div class="bg-black/90 text-white p-3 px-5 rounded-t-lg">
        <p class="text-xl font-bold">Perfil</p>
      </div>
       <div class="flex flex-col items-center justify-center min-h-[25vh]">
         <img :src="navBar.avatar.value" class="size-20 rounded-full cursor-pointer" />
       </div>
       <div class="p-7">
         <div class="flex items-center gap-3">
           <p class="text-2xl font-serif">{{ authStore.user?.surname }}, <b>{{ authStore.user?.name }}</b></p>
           <NuxtLink to="/settings">
             <img src="../assets/images/settings.svg" alt="Settings" class="size-6 cursor-pointer">
           </NuxtLink>
         </div>
         <p class="text-sm">{{ authStore.user?.email }}</p>
 
         <div class="flex md:flex-col mt-5 md:mt-10 w-full gap-3 justify-evenly md:block">
           <!-- <div class="border-b p-2">
             <NuxtLink to="/favorite-travels">
               <p class="text-lg font-bold hidden md:block">Viatges favorits</p>
               <img src="../assets/images/publication.svg" alt="" class="md:hidden size-7 cursor-pointer">
             </NuxtLink>
           </div> -->
           <div class="border-b p-2">
             <NuxtLink to="/trip-details">
               <p class="text-lg font-bold hidden md:block text-gray-600 hover:text-gray-800">Historial de viatges</p>
               <img src="../assets/images/history.svg" alt="" class="md:hidden size-7 cursor-pointer">
             </NuxtLink>
           </div>
         </div>
       </div>
     </div>
  </div>
  <!-- <div class="flex flex-col md:flex-row gap-3 p-4">
    <div class="shadow-lg rounded-xl w-full md:w-1/3 md:min-h-[60vh] p-5 md:sticky top-4 self-start">
      <div class="flex flex-col items-center justify-center min-h-[25vh]">
        <img :src="navBar.avatar.value" class="w-20 h-20 rounded-full cursor-pointer" />
      </div>
      <div class="p-5">
        <div class="flex items-center gap-3">
          <p class="text-2xl font-serif">{{ authStore.user?.surname }}, {{ authStore.user?.name }}</p>
          <NuxtLink to="/settings">
            <img src="../assets/images/settings.svg" alt="Settings" class="size-6 cursor-pointer">
          </NuxtLink>
        </div>
        <p class="text-sm">{{ authStore.user?.email }}</p>

        <div class="flex md:flex-col mt-5 md:mt-10 w-full gap-3 justify-evenly md:block">
          <div class="border-b p-2">
            <NuxtLink to="">
              <p class="text-lg font-bold hidden md:block">Viatges favorits</p>
              <img src="../assets/images/publication.svg" alt="" class="md:hidden size-7 cursor-pointer">
            </NuxtLink>
          </div>
          <div class="border-b p-2">
            <NuxtLink to="/trip-details">
              <p class="text-lg font-bold hidden md:block">Historial de viatges</p>
              <img src="../assets/images/history.svg" alt="" class="md:hidden size-7 cursor-pointer">
            </NuxtLink>
          </div>
        </div>
      </div>
    </div>

    <div class="w-full md:w-[70%] flex flex-col gap-3 overflow-y-auto h-[100vh]">
      <div class="shadow-md rounded-xl w-full min-h-[30vh] items-center flex justify-center bg-gray-200/50">
        <p class="text-2xl text-gray-300">En progres</p>
      </div>
      <div class="shadow-md rounded-xl w-full min-h-[30vh] items-center flex justify-center bg-gray-200/50">
        <p class="text-2xl text-gray-300">En progres</p>
      </div>
      <div class="shadow-md rounded-xl w-full min-h-[30vh] items-center flex justify-center bg-gray-200/50">
        <p class="text-2xl text-gray-300">En progres</p>
      </div>
      <div class="shadow-md rounded-xl w-full min-h-[30vh] items-center flex justify-center bg-gray-200/50">
        <p class="text-2xl text-gray-300">En progres</p>
      </div>
      <div class="shadow-md rounded-xl w-full min-h-[30vh] items-center flex justify-center bg-gray-200/50">
        <p class="text-2xl text-gray-300">En progres</p>
      </div>
    </div>
  </div> -->
</template>

<script setup>
import { useAuthStore } from '~/store/authUser';
import { useNavBar } from '~/composable/useNavBar';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, EffectFade, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/swiper-bundle.css';

const authStore = useAuthStore();
const navBar = useNavBar();
</script>