<script setup>
definePageMeta({
  layout: 'error', // Use the error layout
});
</script>

<template>
  <div>
    <NuxtLayout :error="{ statusCode: 404, message: 'Page Not Found' }" />
  </div>
</template>