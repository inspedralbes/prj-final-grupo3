
<template>
  <footer class="bg-gray-100 mt-auto">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
        <!-- Logo and Copyright -->
        <div class="flex items-center space-x-2">
          <!-- <img src="/logo.png" alt="Triplan Logo" class="h-8 w-auto" /> -->
          <p class="text-gray-600 text-sm">
            © {{ new Date().getFullYear() }} Triplan. Tots els drets reservats.
          </p>
        </div>

        <!-- Links -->
        <div class="flex space-x-6">
          <button @click="navigateToPage('about-us')" class="text-gray-600 hover:text-blue-600 text-sm">Sobre nosaltres</button>
          <button @click="navigateToPage('privacy-policy')" class="text-gray-600 hover:text-blue-600 text-sm">Política de privacitat</button>
          <button @click="navigateToPage('terms-of-service')" class="text-gray-600 hover:text-blue-600 text-sm">Condicions del servei</button>
          <button @click="navigateToPage('contact')" class="text-gray-600 hover:text-blue-600 text-sm">Contacta amb nosaltres</button>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { useFooter } from '~/composable/useFooter';

const { navigateToPage } = useFooter();
</script>