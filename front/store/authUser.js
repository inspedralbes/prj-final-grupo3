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
            // console.log('User logged in:', userData);
            // console.log('User token:', userToken);
            
            this.isAuthenticated = true;
            this.user = userData;
            this.token = userToken;

            sessionStorage.setItem('token', userToken);
            sessionStorage.setItem('user', JSON.stringify(userData));
            // console.log('Token guardado en sessionStorage:', sessionStorage.getItem('token'));
        },
        logout() {
            this.isAuthenticated = false;
            this.user = null;
            this.token = null;
            sessionStorage.removeItem('token');
            sessionStorage.removeItem('user');
        },
        initialize() {
            const token = sessionStorage.getItem('token');
            const user = JSON.parse(sessionStorage.getItem('user'));
            if (token && user) {
                this.login(user, token);
            }
        }
    },
    persist: {
        enabled: true, // Activate persist
        strategies: [
            {
                key: 'userStorage', // key storage
                storage: sessionStorage,
            },
        ],
    },
});
