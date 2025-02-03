import { useAuthStore } from '../store/authUser';
import * as com from '~/services/communicationManager';
import { useRoute, useRouter } from 'nuxt/app'

export function useNavBar() {

    const route = useRoute() // Get the current route

    const config = useRuntimeConfig()
    const authStore = useAuthStore();

    const isOpen = ref(false)
    const avatar = config.public.appName
    
    const handleLogout = () => {
        authStore.logout();
        navigateTo('/login');
    };

    const toggleDropdown = () => {
        isOpen.value = !isOpen.value
    }

    // Cerrar el dropdown si se hace clic fuera de él
    const handleClickOutside = (event) => {
        if (!event.target.closest('.relative')) {
            isOpen.value = false
        }
    }

    // Cerrar el dropdown cuando se navega entre rutas
    watch(route, () => {
        isOpen.value = false
    })

    onMounted(async () => {
        document.addEventListener('click', handleClickOutside)
        if (process.client) {
            authStore.initialize();
            const response = await com.getCurrentUser(authStore.token);

            console.log(authStore.token);

            if (!authStore.token) {
                if (response.status === 'error') {
                    authStore.logout();
                    navigateTo('/');
                }
            } else {
                // navigateTo('/');
            }
        }
    });

    onBeforeUnmount(() => {
        document.removeEventListener('click', handleClickOutside)
    })

    return {
        handleLogout,
        handleClickOutside,
        toggleDropdown,
        avatar,
        isOpen
    }
}