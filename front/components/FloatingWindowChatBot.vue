<template>
  <div>
    <transition name="float">
      <div v-if="isOpen"
        class="floating-window fixed bg-white rounded-lg shadow-2xl z-[1000] w-[400px] max-w-[90%] max-h-[90vh] overflow-auto pointer-events-auto"
        :style="positionStyle" :class="{ 'cursor-grabbing': isDragging }">
        <div class="flex justify-between items-center px-4 py-2 border-b border-gray-200 cursor-grab select-none"
          @mousedown="startDrag" :class="{ 'cursor-grabbing': isDragging }">
          <slot name="header">
            <h3 class="text-lg font-semibold text-gray-800">{{ title }}</h3>
          </slot>
          <button
            class="bg-transparent border-none text-2xl leading-none text-gray-500 hover:text-gray-700 cursor-pointer transition-colors duration-200 ease-in-out p-1"
            @click="close">
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
import useFloatingWindowChatBot from '~/composable/useFloatingWindowChatBot'

const props = defineProps({
  title: {
    type: String,
    default: 'Floating Window'
  },
  isOpen: {
    type: Boolean,
    default: false
  },
  closeOnOverlayClick: {
    type: Boolean,
    default: true
  },
  position: {
    type: Object,
    default: () => ({ top: '80%', left: '70%' })
  }
})

const emit = defineEmits(['close'])

const {
  isOpen: windowOpen,
  title: windowTitle,
  closeOnOverlayClick: overlayClick,
  positionStyle,
  close: closeWindow,
  updatePosition,
  startDrag,
  isDragging
} = useFloatingWindowChatBot(props)

// Sync props with composable state
watch(() => props.isOpen, (newValue) => {
  if (newValue !== windowOpen.value) {
    if (newValue) windowOpen.value = true
    else closeWindow()
  }
})

watch(() => props.position, (newValue) => {
  updatePosition(newValue)
}, { deep: true })

// Emit close event when window is closed
watch(windowOpen, (newValue) => {
  if (!newValue) {
    emit('close')
  }
})

// Expose composable methods and state to template
const isOpen = windowOpen
const title = windowTitle
const closeOnOverlayClick = overlayClick
const close = closeWindow
</script>

<style scoped>
/* Keep only transition animations */
.float-enter-active,
.float-leave-active {
  transition: opacity 0.3s, transform 0.3s;
}

.float-enter-from,
.float-leave-to {
  opacity: 0;
  transform: translate(0, -20px);
}

/* Prevent text selection while dragging */
.floating-window {
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
</style>