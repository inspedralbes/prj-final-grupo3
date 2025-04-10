<template>
  <!-- <h1>Perfil de l'usuari</h1>
<NuxtLink :to="`/trip-details`" class="bg-red-300 p-2 rounded-full hover:bg-red-400 border">
    Veure l'historial dels viatges
</NuxtLink> -->
  <div class="flex flex-col md:flex-row gap-3 p-4">
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
              <p class="text-lg font-bold hidden md:block">Imatges (en progres)</p>
              <img src="../assets/images/fotos.svg" alt="" class="md:hidden size-7 cursor-pointer">
            </NuxtLink>
          </div>
          <div class="border-b p-2">
            <NuxtLink to="">
              <p class="text-lg font-bold hidden md:block">Publicacions (en progres)</p>
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
  </div>
</template>

<script setup>
import { useAuthStore } from '~/store/authUser';
import { useNavBar } from '~/composable/useNavBar';

const authStore = useAuthStore();
const navBar = useNavBar();
</script>