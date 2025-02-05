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
        console.log(response);
        if (response.status === 'error') {
            customAlert(response.message, 'negative', 'error', 'top', 5000);
            authStore.logout();
        } else {
            // customAlert('Informació obtinguda correctament', 'success', 'success', 'top', 5000);
            currentUser.value = response.user
            console.log(currentUser.value);

        }
    }

    const toggleEdit = () => {
        isEditing.value = !isEditing.value;
    };

    const confirmEdit = async (userId) => {
        console.log(userId);
        
        // Logic to confirm changes
        // const response = await com.changeInfoUser(userId)
        // console.log(response);
        
        toggleEdit();
      };

    const cancelEdit = () => {
        isEditing.value = false;
        // Logic to cancel changes
      };

    onMounted(async () => {
        getCurrentUser();
        avatar.value = config.public.appName + authStore.user.avatar
    })

    return {
        currentUser,
        avatar,
        isEditing,
        toggleEdit,
        confirmEdit,
        cancelEdit
    }
}