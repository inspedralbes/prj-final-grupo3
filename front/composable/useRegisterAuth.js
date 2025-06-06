import * as com from '../services/communicationManager';
import { useAuthStore } from '~/store/authUser';
import { useAlert } from './useAlert';
import auth from '~/middleware/auth';

export function useRegisterAuth() {
  const authStore = useAuthStore();

  const { customAlert } = useAlert();

  const loading = ref(false); // Loadin state
  const error = ref(null); // For server errors
  const success = ref(false); // For success register
  const registerError = ref('');
  const isPasswordVisible = ref(false);
  const isConfirmPasswordVisible = ref(false);

  // const registerData = reactive({
  //     name: "Jhon",
  //     surname: "Doe",
  //     email: "jhon@example.com",
  //     email_alternative: "jhonalternativ@example.com",
  //     password: "password123",
  //     password_confirmation: "password123",
  //     birth_date: "1990-02-11",
  //     phone_number: "123456789",
  //     gender: "male"
  // });

  // Form variables
  const registerData = reactive({
    name: '',
    surname: '',
    email: '',
    email_alternative: '',
    password: '',
    password_confirmation: '',
    birth_date: '',
    phone_number: '',
    gender: '',
  });

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
      if (response.status === 'error') {
        error.value = response.message;

        customAlert(error.value, 'negative', 'error', 'top', 5000);
        return;
      } else {

        authStore.login(response.user, response.token);

        navigateTo('/');
        success.value = true; // Indicate success register
      }
      return response;
    } catch (err) {
      error.value = err.message || 'Error al registrar el usuario';
    } finally {
      loading.value = false; // Stop loading state
    }
  };

  const togglePasswordVisibility = (field) => {
    if (field === 'password') {
      isPasswordVisible.value = !isPasswordVisible.value;
    } else if (field === 'confirmpassword') {
      isConfirmPasswordVisible.value = !isConfirmPasswordVisible.value;
    }
  };

  function handleRegister() {
    user.value = { name: name.value, email: email.value };
    navigateTo('/app');
  }

  return {
    registerUser,
    togglePasswordVisibility,
    handleRegister,
    loading,
    error,
    success,
    registerError,
    registerData,
    isPasswordVisible,
    isConfirmPasswordVisible,
  };
}