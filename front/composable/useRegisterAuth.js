import * as com from '../services/communicationManager';

export function useRegisterAuth() {
    const loading = ref(false); // Loadin state
    const error = ref(null); // For server errors
    const success = ref(false); // For success register

    // Form variables
    const name = ref('');
    const surname = ref('');
    const email = ref('');
    const emailalternative = ref('');
    const password = ref('');
    const formData = ref({
        birth_date: '',
    });

    const registerUser = async (userData) => {
        loading.value = true;
        error.value = null;
        success.value = false;        

        try {
            const response = await com.register(userData);

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
        name,
        surname,
        email,
        emailalternative,
        password,
        formData
    };
}