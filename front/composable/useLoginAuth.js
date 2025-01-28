import * as com from '../services/communicationManager';
import { useAuthStore } from '~/store/authUser';
import { useAlert } from './useAlert';

export function useLoginAuth() {
    const authStore = useAuthStore();

    const { customAlert } = useAlert();

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
                error.value = response.message;
                console.log(error.value);
                
                customAlert(error.value, 'negative', 'error', 'top', 5000);
                console.error("Error en el login", error.value);
                return
            } else {
                authStore.login(response.user, response.token);
                success.value = true; // Indicate success register
                navigateTo('/');
                if (rememberMe) {
                    console.log('El mensaje es exitoso para el login con remember me');
                    
                    sessionStorage.setItem('token', response.token);
                    sessionStorage.setItem('user', JSON.stringify(response.user));
                }
            }
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