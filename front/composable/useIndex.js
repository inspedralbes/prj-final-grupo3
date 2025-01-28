import { useAuthStore } from '~/store/authUser';

export function useIndex() {

    const authStore = useAuthStore();

    console.log(sessionStorage.getItem('authStore'));

    onMounted(() => {
        authStore.initialize();
        console.log(sessionStorage.getItem('authStore'));
        if (authStore.isAuthenticated) {
            // navigateTo('/');
        }
    });

    return {

    }
}