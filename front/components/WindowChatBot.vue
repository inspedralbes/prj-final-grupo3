<template>
  <div>
    <transition enter-active-class="transform transition-all duration-300 ease-in-out"
      enter-from-class="translate-x-full opacity-0" enter-to-class="translate-x-0 opacity-100"
      leave-active-class="transform transition-all duration-300 ease-in-out"
      leave-from-class="translate-x-0 opacity-100" leave-to-class="translate-x-full opacity-0">
      <div v-if="isOpen"
        class="fixed bottom-4 right-4 bg-white rounded-lg shadow-2xl z-[1000] w-[400px] max-w-[90%] max-h-[60vh] overflow-auto">
        <div class="flex justify-between items-center p-4 border-b border-gray-200 select-none">
          <slot name="header">
            <h3 class="text-lg font-semibold text-gray-800">{{ title }}</h3>
          </slot>
          <button
            class="bg-transparent border-transition2xl leading-none text-gray-500 hover:text-gray-700 cursor-pointer transition-colors duration-200 ease-in-out p-1"
            @click="handleClose()">
            ×
          </button>
        </div>
        <div class="p-4">
          <slot></slot>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { watch } from 'vue'

const props = defineProps({
  title: {
    type: String,
    default: 'Asistent de planificació'
  },
  isOpen: {
    type: Boolean,
    default: true
  }
})

const emit = defineEmits(['update:isOpen'])

// Handle close button click
const handleClose = () => {
  emit('update:isOpen', false)
}

// Watch for changes in isOpen prop
watch(() => props.isOpen, (newValue) => {
  emit('update:isOpen', newValue)
})
</script>

<style scoped>
/* Remove the previous transition styles as we're using Tailwind classes now */
</style>