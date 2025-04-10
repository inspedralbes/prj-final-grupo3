import { defineStore } from "pinia";

export const useAuthStore = defineStore('auth', {

  state: () => ({
    isAuthenticated: false, // Initial state
    token: undefined, // User token
    user: undefined, // Details user loged
  }),
  getters: {
    userAvatar: (state) => state.user ? (state.user.avatar || state.user.photo_pic) : '',
    userName: (state) => state.user ? state.user.name : '',
    userEmail: (state) => state.user ? state.user.email : '',
  },
  actions: {
    login(userData, userToken) {
      this.isAuthenticated = true;
      this.user = userData;
      this.token = userToken;

      sessionStorage.setItem('token', userToken);
      sessionStorage.setItem('user', JSON.stringify(userData));
      sessionStorage.setItem('isAuthenticated', true);
    },
    logout() {
      this.isAuthenticated = false;
      this.user = null;
      this.token = null;
      sessionStorage.removeItem('isAuthenticated');
      sessionStorage.removeItem('token');
      sessionStorage.removeItem('user');
    },
    initialize() {
      this.token = sessionStorage.getItem('token');
      this.user = JSON.parse(sessionStorage.getItem('user'));
    }
  },
  persist: {
    enabled: true, // Activate persist
    strategies: [
      {
        key: 'authStore', // key storage
        storage: sessionStorage,
        paths: ['isAuthenticated', 'token', 'user'] // Especifica qué guardar
      },
    ],
  },
});
