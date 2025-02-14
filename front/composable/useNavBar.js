import { useAuthStore } from '../store/authUser';
import * as com from '~/services/communicationManager';
import { useRoute, useRouter } from 'nuxt/app';
import { ref, watch, onMounted, onBeforeUnmount } from 'vue';

export function useNavBar() {
    const route = useRoute();
    const router = useRouter();
    const config = useRuntimeConfig();
    const authStore = useAuthStore();

    const isOpen = ref(false);
    const avatar = ref('');

    const handleLogout = async () => {
        authStore.logout();
        await navigateTo('/login'); // Esperar la navegación
    };

    const toggleDropdown = (event) => {
        isOpen.value = !isOpen.value;
    };

    const handleClickOutside = (event) => {
        if (!event.target.closest('.dropdown-container')) {
            isOpen.value = false;
        }
    };

    // Cerrar el dropdown al cambiar de ruta
    watch(route, () => {
        isOpen.value = false;
    });

    onMounted(async () => {

        document.addEventListener('click', handleClickOutside);

        if (process.client) {
            await authStore.initialize(); // Asegúrate de inicializar el authStore
            const response = await com.getCurrentUser(authStore.token);

            if (authStore.user && authStore.user.avatar) {
                const baseURL = config.public.appName
                const avatarParts = authStore.user.avatar
                    .split("/")
                    .filter((_, index) => index !== 2)  // Elimina la tercera posición
                const avatarUrl = `${baseURL}/${avatarParts[3]}`;
                avatar.value = avatarUrl;
            } else {
                avatar.value = '/default-avatar.png'; // Imagen por defecto si no hay avatar
            }

            if (!authStore.token && response.status === 'error') {
                authStore.logout();
                await navigateTo('/');
            }
        }
    });

    onBeforeUnmount(() => {
        document.removeEventListener('click', handleClickOutside);
    });

    return {
        handleLogout,
        toggleDropdown,
        isOpen,
        avatar,
    };
}