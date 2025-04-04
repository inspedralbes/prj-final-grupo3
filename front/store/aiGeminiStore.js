import { defineStore } from "pinia";

export const useAIGeminiStore = defineStore('ai', {

  state: () => ({
    responseText: null, // Initial state
  }),
  getters: {
    response: (state) => state.responseText ? state.responseText : '',
  },
  actions: {
    setResponse(newResponse) {
      this.responseText = newResponse
    }
  },
  persist: {
    enabled: true, // Activate persist
    strategies: [
      {
        key: 'aiGemini', // key storage
        storage: localStorage,
        paths: ['responseText'] // Specify the fields to be persisted
      },
    ],
  },
});
