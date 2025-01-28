import * as com from '../services/communicationManager';
import { useAuthStore } from '~/store/authUser';

export function useLoginAuth() {
    const authStore = useAuthStore();

    const loading = ref(false); // Loadin state
    const error = ref(null); // For server errors
    const success = ref(false); // For success register
    const loginError = ref('');

    // Form variables
    const loginData = reactive({
        email: '',
        password: '',
        rememberMe: false
    });

    const loginUser = async () => {
        loading.value = true;
        // success.value = false;

        console.log(loginData);

        try {
            const response = await com.login(loginData);

            if (response.status === 'error') {
                loginError.value = "Error en el login";
                console.error("Error en el login", error.value);
            } else {
                authStore.login(response.user, response.token);
                if (rememberMe) {
                    console.log('El mensaje es exitoso para el login');

                    sessionStorage.setItem('token', response.token);
                    sessionStorage.setItem('user', JSON.stringify(response.user));
                }
            }
            navigateTo('/');

            success.value = true; // Indicate success register
            console.log("Login exitoso", response);

        } catch (err) {
            error.value = err.message || 'Error al registrar el usuario';
        } finally {
            loading.value = false; // Stop loading state
        }

    };

    return {
        loading,
        error,
        success,
        loginError,
        loginData,
        loginUser
    };
}