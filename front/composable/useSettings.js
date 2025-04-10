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
  const newAvatarFile = ref(null);


  const getCurrentUser = async () => {

    const response = await com.getCurrentUser(authStore.token);
    const baseURL = config.public.appName;
    avatar.value = `${baseURL}/${response.avatar}`	
    // console.log(response);
    if (response.status === 'error') {
      customAlert(response.message, 'negative', 'error', 'top', 1500);
      authStore.logout();
    } else {
      customAlert('Informació carregada', 'success', 'success', 'top', 1500);
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

    if (newAvatarFile.value) {
      newDataUser.avatarFile = newAvatarFile.value;
    }

    const response = await com.changeInfoUser(authStore.token, newDataUser);
    const dataUser = await com.getCurrentUser(authStore.token);

    if (response.status === 'error') {
      customAlert(response.message, 'negative', 'error', 'top', 2000);
      return;
    } else {
      currentUser.value = dataUser;
      authStore.user = dataUser; 
      customAlert(response.message, 'success', 'success', 'top', 2000);
    }
    toggleEdit();
  };

  const cancelEdit = () => {
    isEditing.value = false;
    // Logic to cancel changes
  };

  const handleAvatarChange = (uploadFile) => {
    newAvatarFile.value = uploadFile;

    //previsualize
    const reader = new FileReader();
    reader.onload = () => {
      avatar.value = reader.result;
    };
    reader.readAsDataURL(uploadFile.raw);
  }

  onMounted(async () => {
    await getCurrentUser();
    const baseURL = config.public.appName
    // const avatarUrl = `${baseURL}/${authStore.user.avatar}`;
    const avatarUrl = `${baseURL}/${currentUser.value.avatar}`;	
    avatar.value = avatarUrl;
  })

  return {
    currentUser,
    avatar,
    isEditing,
    toggleEdit,
    confirmEdit,
    cancelEdit,
    handleAvatarChange    
  }
}