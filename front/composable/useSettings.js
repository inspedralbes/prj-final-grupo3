import * as com from '../services/communicationManager';
import { useAuthStore } from '../store/authUser';
import { useAlert } from './useAlert';

export function useSettings() {

  const authStore = useAuthStore();
  const config = useRuntimeConfig()
  const customAlert = useAlert().customAlert;

  const currentUser = ref({});
  const avatar = ref()
  const isEditing = ref(false);


  const getCurrentUser = async () => {

    const response = await com.getCurrentUser(authStore.token);
    // console.log(response);
    if (response.status === 'error') {
      customAlert(response.message, 'negative', 'error', 'top', 5000);
      authStore.logout();
    } else {
      customAlert('Informació carregada', 'success', 'success', 'top', 5000);
      const birth = response.birth_date.split(' ');
      response.birth_date = birth[0];
      currentUser.value = response
    }
  }

  const toggleEdit = () => {
    isEditing.value = !isEditing.value;
  };

  const confirmEdit = async () => {
    const newDataUser = reactive({
      ...currentUser.value
    })

    // console.log(newDataUser.birth_date);
    const formatData = (data) => {
      console.log("pre form data", data);
      const birth = data.split(' ');  // Asumiendo formato DD/MM/YYYY
      console.log(birth[0] + ' 00:00:00');

      return birth[0];
    }

    console.log("new Data User =>", newDataUser.birth_date);
    // newDataUser.birth_date = formatData(newDataUser.birth_date)

    // Logic to confirm changes
    const response = await com.changeInfoUser(authStore.token, newDataUser);
    // console.log(response);

    const data = await com.getCurrentUser(authStore.token);
    console.log(data);

    const birth = data.birth_date.split(' ');
    console.log(birth[0]);
    data.birth_date = birth[0];
    currentUser.value = data
    console.log(currentUser.value);

    currentUser.value = data;

    // Poner alerta para notificar al usuario de que ha realizado los cambios de manera crorrecta

    toggleEdit();
  };

  const cancelEdit = () => {
    isEditing.value = false;
    // Logic to cancel changes
  };

  onMounted(async () => {
    getCurrentUser();
    const baseURL = config.public.appName
    // const avatarParts = authStore.user.avatar
    //     .split("/")
    //     .filter((_, index) => index !== 2)
    const avatarUrl = `${baseURL}/${authStore.user.avatar}`;
    avatar.value = avatarUrl;
  })

  return {
    currentUser,
    avatar,
    isEditing,
    // newDataUser,
    toggleEdit,
    confirmEdit,
    cancelEdit
  }
}