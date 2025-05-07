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
    console.log('[confirmEdit] inici');
  
    const volCanviarContrasenya =
      showPasswordForm.value &&
      passwordForm.currentPassword.trim() !== '' &&
      passwordForm.newPassword.trim() !== '' &&
      passwordForm.confirmPassword.trim() !== '';
    console.log('[confirmEdit] Vol canviar contrasenya?', volCanviarContrasenya);


  
    if (volCanviarContrasenya) {
      console.log('[confirmEdit] Intentant canviar contrasenya...');
      const passwordOk = await changePassword();
      if (!passwordOk) {
        console.warn('[confirmEdit] Canvi de contrasenya fallit. Cancel·lant confirmació.');
        return; // Evita desar altres canvis si la contrasenya falla
      }
    }
  
    const newDataUser = reactive({
      ...currentUser.value,
    });
  
    if (newAvatarFile.value) {
      newDataUser.avatarFile = newAvatarFile.value;
    }
  
    try {
      const response = await com.changeInfoUser(authStore.token, newDataUser);
      const dataUser = await com.getCurrentUser(authStore.token);
  
      if (response.status === 'error') {
        customAlert(response.message, 'negative', 'error', 'top', 2000);
        console.error('[confirmEdit] Error canvi perfil:', response.message);
        return;
      }
  
      currentUser.value = dataUser;
      authStore.user = dataUser;
      customAlert(response.message, 'success', 'success', 'top', 2000);
      console.log('[confirmEdit] Informació de perfil actualitzada correctament.');
    } catch (error) {
      console.error('[confirmEdit] Excepció inesperada:', error);
      ElMessage.error('Error inesperat durant el canvi de dades.');
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
    if (passwordForm.newPassword !== passwordForm.confirmPassword) {
      ElMessage.error('Les contrasenyes no coincideixen.');
      return false;
    }
  
    try {
      const response = await com.changeUserPassword(authStore.token, passwordForm);
  
      if (response.status === 'success') {
        ElMessage.success(response.message || 'Contrasenya canviada.');
        console.log('[changePassword] Contrasenya canviada correctament');
        showPasswordForm.value = false;
        passwordForm.currentPassword = '';
        passwordForm.newPassword = '';
        passwordForm.confirmPassword = '';
        return true;
      } else {
        ElMessage.error(response.message || 'Error al canviar la contrasenya.');
        console.error('[changePassword] Error resposta:', response);
        return false;
      }
    } catch (error) {
      console.error('[changePassword] Excepció:', error);
      ElMessage.error('Error inesperat al canviar la contrasenya.');
      return false;
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
