<template>
    <h1>Perfil de l'usuari</h1>
    <NuxtLink :to="`/trip-details`" class="bg-red-300 p-2 rounded-full hover:bg-red-400 border">
        Veure l'historial dels viatges
    </NuxtLink>
</template>

<script setup>
import { useAuthStore } from '~/store/authUser';

const authStore = useAuthStore();
</script>