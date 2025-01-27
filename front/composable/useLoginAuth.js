import * as com from '../services/communicationManager';
import { useAuthStore } from '~/store/authUser';

export function useLoginAuth() {
    const loading = ref(false); // Loadin state
    const error = ref(null); // For server errors
    const success = ref(false); // For success register
    const registerError = ref('');

    const authStore = useAuthStore();

    // Form variables
    const email = ref("");
    const password = ref("");


    const loginUser = async (userData) => {
        loading.value = true;
        error.value = null;
        success.value = false;

        if (userData.password != userData.password_confirmation) {
            registerError.value = 'Les contrasenyes no coincideixen.';
            return;
        }

        try {
            const response = await com.register(userData);
            // Here pass the info to a store
            authStore.login(response.user, response.token);
            console.log(authStore.token, authStore.user);

            authStore.
                navigateTo('/');
            success.value = true; // Indicate success register
            return response;
        } catch (err) {
            error.value = err.message || 'Error al registrar el usuario';
        } finally {
            loading.value = false; // Stop loading state
        }
    };

    return {
        registerUser,
        loading,
        error,
        success,
        registerError,
        email,
        password,
        loginUser
    };
}