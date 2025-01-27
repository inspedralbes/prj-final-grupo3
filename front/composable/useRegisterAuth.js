import * as com from '../services/communicationManager';
import { useAuthStore } from '~/store/authUser';

export function useRegisterAuth() {
    const authStore = useAuthStore();

    const loading = ref(false); // Loadin state
    const error = ref(null); // For server errors
    const success = ref(false); // For success register
    const registerError = ref('');

    const registerData = reactive({
        name: "Jhon",
        surname: "Doe",
        email: "jhon@example.com",
        email_alternative: "jhonalternativ@example.com",
        password: "password123",
        password_confirmation: "password123",
        birth_date: "1990-02-11",
        phone_number: "123456789",
        gender: "male"
    });
    // const registerData = reactive({
    //     name: registerAuth.name.value,
    //     surname: registerAuth.surname.value,
    //     email: registerAuth.email.value,
    //     emailalternative: registerAuth.emailalternative.value,
    //     password: registerAuth.password.value,
    //     password_confirmation: registerAuth.password.value,
    //     birth_date: registerAuth.formData.dates,
    //     phone_number: "123456789",
    //     gender: "male",
    // });

    // Form variables
    // const name = ref('');
    // const surname = ref('');
    // const email = ref('');
    // const emailalternative = ref('');
    // const password = ref('');
    // const formData = ref({
    //     birth_date: '',
    // });

    const registerUser = async () => {
        loading.value = true;
        success.value = false;

        if (registerData.password != registerData.password_confirmation) {
            registerError.value = 'Les contrasenyes no coincideixen.';
            return;
        }

        try {
            const response = await com.register(registerData);
            // Here pass the info to a store
            authStore.login(response.user, response.token);
            console.log(authStore.token, authStore.user);

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
        registerData
    };
}