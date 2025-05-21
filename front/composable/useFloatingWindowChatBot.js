import { ref, computed } from 'vue'

export default function useFloatingWindowChatBot(props) {

  const isOpen = ref(props?.isOpen || false)
  const title = ref(props?.title || 'Asistent de planificació')

  // const close = () => {
  //   isOpen.value = false
  // }

  // const open = () => {
  //   isOpen.value = true
  // }

  const chatIsOpen = () => {
    isOpen.value = !isOpen.value
  }

  return {
    chatIsOpen,
    isOpen,
    title,
  }
}