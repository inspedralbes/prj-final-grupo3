<template>
    <!-- <h1>Perfil de l'usuari</h1>
    <NuxtLink :to="`/trip-details`" class="bg-red-300 p-2 rounded-full hover:bg-red-400 border">
        Veure l'historial dels viatges
    </NuxtLink> -->

    <div class="flex flex-row gap-3 p-4">
        <div class="shadow-lg rounded-xl w-1/3 min-h-[80vh] p-5">
            <!-- informacion de perfil -->
             <div class="flex flex-col items-center justify-center min-h-[20vh]">
                <!-- imagen -->
                 <!-- <img src="" alt=""> -->
                 <img :src="navBar.avatar.value"
                 class="w-20 h-20 rounded-full cursor-pointer " />
             </div>
             <div>
                <!-- datos usuario -->
                 <p class="text-2xl font-serif">{{ authStore.user.surname }}, {{ authStore.user.name }}</p>
                 <p class="text-sm">{{ authStore.user.email }}</p>
             </div>
        </div>
        <div class="shadow-lg rounded-xl w-[70%] min-h-[80vh] p-5">
            dashboard
        </div>
    </div>
</template>

<script setup>
import { useAuthStore } from '~/store/authUser';
import { useNavBar } from '~/composable/useNavBar';
import auth from '~/middleware/auth';

const authStore = useAuthStore();
const navBar = useNavBar();
</script>