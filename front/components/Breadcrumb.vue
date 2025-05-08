<template>
    <nav class="flex text-sm text-gray-700 dark:text-gray-300 mb-6" aria-label="Breadcrumb">
      <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
        <li class="inline-flex items-center">
          <NuxtLink to="/" class="inline-flex items-center text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
            <svg class="w-4 h-4 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 2L2 10h3v6h4v-4h2v4h4v-6h3L10 2z"/>
            </svg>
            Inici
          </NuxtLink>
        </li>
        <li v-for="(crumb, index) in crumbs" :key="index" class="flex items-center">
          <svg class="w-3 h-3 text-gray-400 mx-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
            <path d="M1 9l4-4-4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span v-if="crumb.to">
            <NuxtLink :to="crumb.to" class="text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
              {{ crumb.label }}
            </NuxtLink>
          </span>
          <span v-else class="text-gray-500 dark:text-gray-400">{{ crumb.label }}</span>
        </li>
      </ol>
    </nav>
  </template>
  
  <script setup>
  defineProps({
    crumbs: {
      type: Array,
      required: true
    }
  })
  </script>
  