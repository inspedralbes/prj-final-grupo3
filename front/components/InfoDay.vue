<template>  
    <li class="border-l-4 border-blue-500 pl-3">
          <p class="text-sm font-semibold text-gray-600">{{ prop.act?.hora }}</p>
          <p class="text-base text-gray-800">{{ prop.act?.descripcio }}</p>
          <p class="text-sm text-gray-500 italic">Pressupost: {{ prop.act?.pressupost }}</p>
    </li>
</template>

<script setup>
const prop = defineProps ({
    act: Object
})
console.log(prop.act);
</script>