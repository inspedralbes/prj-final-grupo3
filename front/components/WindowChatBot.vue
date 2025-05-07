<template>
  <div v-if="isOpen"
    class="fixed bottom-4 right-4 bg-white z-[50] rounded-lg shadow-2xl w-[400px] max-w-[90%] max-h-[60vh] overflow-hidden"
    :class="[isOpen == false ? 'bottom-10 right-10 bg-white rounded-lg shadow-2xl w-[400px] max-w-[90%] max-h-[60vh] overflow-hidden' : '']">
    <!-- Header - Fixed -->
    <div class="flex justify-between items-center p-4 border-b border-gray-200 select-none bg-white sticky top-0 z-10">
      <slot name="header">
        <h3 class="text-lg font-semibold text-gray-800">{{ title }}</h3>
      </slot>
      <button
        class="bg-transparent border-none text-2xl leading-none text-gray-500 hover:text-gray-700 cursor-pointer transition-colors duration-200 ease-in-out p-1"
        @click="handleClose()">
        ×
      </button>
    </div>
    <!-- Content - Scrollable -->
    <div class="p-4 overflow-y-auto h-[calc(60vh-4rem)]">
      <slot></slot>
    </div>
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