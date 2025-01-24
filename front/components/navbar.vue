<template>
    <nav class="bg-white shadow-md p-4">
        <div class="container mx-auto flex justify-between items-center">
          <h1 class="text-2xl font-bold text-blue-600"><NuxtLink to="/">Triplan</NuxtLink></h1>
          <div class="space-x-4">
            <button class="px-4 py-2 text-blue-600 hover:text-blue-800"><NuxtLink to="/login">Iniciar sessió</NuxtLink></button>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"><NuxtLink to="/register">Registrar-se</NuxtLink></button>
          </div>
        </div>
      </nav>
</template>

<script>
export default {
  name: "navbar",
};
</script>