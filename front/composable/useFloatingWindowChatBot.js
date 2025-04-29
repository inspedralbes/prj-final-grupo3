import { ref, computed } from 'vue'

export default function useFloatingWindowChatBot(props) {
  const defaultPosition = { top: '80%', left: '70%' }

  const isOpen = ref(props?.isOpen || false)
  const title = ref(props?.title || 'Floating Window')
  const closeOnOverlayClick = ref(props?.closeOnOverlayClick || true)
  const position = ref(props?.position || defaultPosition)
  const isDragging = ref(false)
  const dragOffset = ref({ x: 0, y: 0 })

  const positionStyle = computed(() => {
    // If using transform, dragging calculations become more complex
    // So we'll use direct positioning instead
    return {
      top: position.value.top,
      left: position.value.left
    }
  })

  const close = () => {
    isOpen.value = false
    position.value = defaultPosition
  }

  const open = () => {
    isOpen.value = true
  }

  const updatePosition = (newPosition) => {
    position.value = { ...defaultPosition, ...newPosition }
  }

  const startDrag = (event) => {
    // Only allow left-click drag
    if (event.button !== 0) return

    isDragging.value = true

    // Calculate the offset between click position and window position
    const windowRect = event.target.closest('.floating-window').getBoundingClientRect()
    dragOffset.value = {
      x: event.clientX - windowRect.left,
      y: event.clientY - windowRect.top
    }

    // Add event listeners for drag and end drag
    document.addEventListener('mousemove', handleDrag)
    document.addEventListener('mouseup', endDrag)
  }

  const handleDrag = (event) => {
    if (!isDragging.value) return

    // Calculate new position based on mouse position and initial offset
    const newLeft = event.clientX - dragOffset.value.x
    const newTop = event.clientY - dragOffset.value.y

    // Update position (with bounds checking)
    position.value = {
      left: `${Math.max(0, Math.min(window.innerWidth - 400, newLeft))}px`,
      top: `${Math.max(0, Math.min(window.innerHeight - 100, newTop))}px`
    }
  }

  const endDrag = () => {
    isDragging.value = false
    document.removeEventListener('mousemove', handleDrag)
    document.removeEventListener('mouseup', endDrag)
  }

  return {
    isOpen,
    title,
    closeOnOverlayClick,
    position,
    positionStyle,
    close,
    open,
    updatePosition,
    startDrag,
    isDragging
  }
}