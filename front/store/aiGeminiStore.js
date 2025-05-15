import { defineStore } from "pinia";

export const useAIGeminiStore = defineStore('ai', {

  state: () => ({
    responseText: null, // Initial state
    initialResponse: null, // Initial state
    lastTravelId: null, // Initial state
  }),
  getters: {
    response: (state) => state.responseText ? state.responseText : '',
    baseResponse: (state) => state.initialResponse ? state.initialResponse : '',
    travelId: (state) => state.lastTravelId ? state.lastTravelId : '',
  },
  actions: {
    setResponse(newResponse) {
      this.responseText = newResponse
    },
    setInitialResponse(newResponse) {
      this.initialResponse = newResponse
    },
    setLatestTravelId(newResponse) {
      this.lastTravelId = newResponse
    },
  },
  persist: {
    enabled: true, // Activate persist
    strategies: [
      {
        key: 'aiGemini', // key storage
        storage: localStorage,
        paths: ['responseText', 'initialResponse', 'lastTravelId'] // Specify the fields to be persisted
      },
    ],
  },
});
