import { defineStore } from "pinia";

export const useAIGeminiStore = defineStore('ai', {

  state: () => ({
    responseText: null, // Initial state
    initialResponse: null, // Initial state
  }),
  getters: {
    response: (state) => state.responseText ? state.responseText : '',
    baseResponse: (state) => state.initialResponse ? state.initialResponse : '',
  },
  actions: {
    setResponse(newResponse) {
      this.responseText = newResponse
    },
    setInitialResponse(newResponse) {
      this.initialResponse = newResponse
    }
  },
  persist: {
    enabled: true, // Activate persist
    strategies: [
      {
        key: 'aiGemini', // key storage
        storage: localStorage,
        paths: ['responseText', 'initialResponse'] // Specify the fields to be persisted
      },
    ],
  },
});
