import { createPinia } from 'pinia'
import { createPersistedState } from 'pinia-plugin-persistedstate'

export default defineNuxtPlugin((nuxtApp) => {
  nuxtApp.$pinia.use(createPersistedState({
    storage: {
      getItem: (key) => {
        const sessionData = sessionStorage.getItem(key)
        return sessionData || localStorage.getItem(key)
      },
      setItem: (key, value) => {
        sessionStorage.setItem(key, value)
        localStorage.setItem(key, value)
      },
      removeItem: (key) => {
        sessionStorage.removeItem(key)
        localStorage.removeItem(key)
      }
    },
    key: prefix => `${prefix}`
  }))
})