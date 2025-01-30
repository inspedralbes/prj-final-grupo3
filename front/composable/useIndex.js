import { useAuthStore } from '~/store/authUser';
import * as com from '~/services/communicationManager';

export function useIndex() {

    const authStore = useAuthStore();

    onMounted(async () => {
        if (process.client) {
            authStore.initialize();
            const response = await com.getCurrentUser(sessionStorage.getItem('token'));

            console.log(authStore.token);

            if (!authStore.token) {
                if (response.status === 'error') {
                    authStore.logout();
                    navigateTo('/login');
                }

            } else {
                navigateTo('/');
            }
        }
    });

    return {

    }
}