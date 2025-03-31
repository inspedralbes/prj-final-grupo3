<template>
  <footer class="bg-gray-100 mt-auto">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
        <!-- Logo and Copyright -->
        <div class="flex items-center space-x-2">
          <!-- <img src="/logo.png" alt="Triplan Logo" class="h-8 w-auto" /> -->
          <p class="text-gray-600 text-sm">
            © {{ new Date().getFullYear() }} Triplan. All rights reserved.
          </p>
        </div>

        <!-- Links -->
        <div class="flex space-x-6">
          <a href="#" class="text-gray-600 hover:text-blue-600 text-sm">About Us</a>
          <a href="#" class="text-gray-600 hover:text-blue-600 text-sm">Privacy Policy</a>
          <a href="#" class="text-gray-600 hover:text-blue-600 text-sm">Terms of Service</a>
          <a href="#" class="text-gray-600 hover:text-blue-600 text-sm">Contact</a>
        </div>
      </div>
    </div>
  </footer>
</template>