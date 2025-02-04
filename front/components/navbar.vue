<template>
  <nav class="bg-white shadow-md p-4">
    <div v-if="!authStore.token">
      <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold text-blue-600">
          <NuxtLink to="/">Triplan</NuxtLink>
        </h1>
        <div class="space-x-4">
          <button class="px-4 py-2 text-blue-600 hover:text-blue-800">
            <NuxtLink to="/login">Iniciar sessió</NuxtLink>
          </button>
          <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <NuxtLink to="/register">Registrar-se</NuxtLink>
          </button>
        </div>
      </div>
    </div>
    <div v-else>
      <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold text-blue-600">
          <NuxtLink to="/">Triplan</NuxtLink>
        </h1>
        <div class="space-x-4">

          <div class="relative inline-block text-left dropdown-container">
            <!-- Avatar open/close menu -->
            <img @click="navBar.toggleDropdown" :src="navBar.avatar.value" :alt="authStore.user.name"
              class="w-8 h-8 rounded-full cursor-pointer" />

            <!-- Dropdown Menu -->
            <div v-if="navBar.isOpen.value"
              class="absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-20">
              <ul class="py-1">
                <li>
                  <NuxtLink to="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfil
                  </NuxtLink>
                </li>
                <li>
                  <NuxtLink to="/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Configuració
                  </NuxtLink>
                </li>
                <li>
                  <button @click="navBar.handleLogout"
                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                    Tanca sessió
                  </button>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { useAuthStore } from '~/store/authUser';
import { useNavBar } from '~/composable/useNavBar';

const authStore = useAuthStore();
const navBar = useNavBar();

</script>

<style scoped>
/* Opcional: Mejora el diseño en pantallas pequeñas */
@media (max-width: 640px) {
  .w-48 {
    width: 100%;
    max-width: 200px;
  }
}
</style>