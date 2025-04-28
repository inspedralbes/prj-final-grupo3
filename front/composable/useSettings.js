import * as com from '../services/communicationManager';
import { useAuthStore } from '../store/authUser';
import { useAlert } from './useAlert';
import { ref, reactive, onMounted } from 'vue';
import { ElMessage } from 'element-plus';

export function useSettings() {
  const authStore = useAuthStore();
  const config = useRuntimeConfig();
  const customAlert = useAlert().customAlert;

  const currentUser = ref({});
  const avatar = ref();
  const isEditing = ref(false);
  const newAvatarFile = ref(null);

  const showPasswordForm = ref(false);
  const passwordForm = reactive({
    currentPassword: '',
    newPassword: '',
    confirmPassword: '',
  });

  const togglePasswordForm = () => {
    showPasswordForm.value = !showPasswordForm.value;
  };

  const toggleEdit = () => {
    isEditing.value = !isEditing.value;
  };

  const confirmEdit = async () => {
    const newDataUser = reactive({
      ...currentUser.value
    });

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
    showPasswordForm.value = false;
  };

  const handleAvatarChange = (uploadFile) => {
    newAvatarFile.value = uploadFile;

    const reader = new FileReader();
    reader.onload = () => {
      avatar.value = reader.result;
    };
    reader.readAsDataURL(uploadFile.raw);
  };

  const getCurrentUser = async () => {
    const response = await com.getCurrentUser(authStore.token);
    const baseURL = config.public.appName;
    avatar.value = `${baseURL}/${response.avatar}`;
    
    if (response.status === 'error') {
      customAlert(response.message, 'negative', 'error', 'top', 1500);
      authStore.logout();
    } else {
      customAlert('Informació carregada', 'success', 'success', 'top', 1500);
      const birth = response.birth_date.split(' ');
      response.birth_date = birth[0];
      currentUser.value = response;
    }
  };

  const changePassword = async () => {
    if (passwordForm.value.newPassword !== passwordForm.value.confirmPassword) {
      ElMessage.error('Les contrasenyes no coincideixen.');
      return;
    }
    try {
      await authStore.changePassword(passwordForm.value);
      ElMessage.success('Contrasenya actualitzada correctament!');
      showPasswordForm.value = false;
    } catch (error) {
      ElMessage.error('Error al canviar la contrasenya.');
    }
  };

  onMounted(async () => {
    await getCurrentUser();
  });

  return {
    currentUser,
    avatar,
    isEditing,
    toggleEdit,
    confirmEdit,
    cancelEdit,
    handleAvatarChange,
    showPasswordForm,
    togglePasswordForm,
    passwordForm,
    changePassword
  };
}
