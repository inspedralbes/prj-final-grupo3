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
            customAlert('Informació carregada', 'success', 'success', 'top', 5000);
            currentUser.value = response.user

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
            console.log(data);
            const [day, month, year] = data.split('-');  // Asumiendo formato DD/MM/YYYY
            console.log(`${day}-${month}-${year}`);
            
            return `${day}-${month}-${year}`;

        }

        newDataUser.birth_date = formatData(newDataUser.birth_date);

        console.log(newDataUser);
        

        // console.log(newDataUser);

        // Logic to confirm changes
        const response = await com.changeInfoUser(authStore.token, newDataUser)
        console.log(response);

        // Poner alerta para notificar al usuario de que ha realizado los cambios de manera crorrecta

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
        // newDataUser,
        toggleEdit,
        confirmEdit,
        cancelEdit
    }
}