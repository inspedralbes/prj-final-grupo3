import { useAuthStore } from '../store/authUser';

export function useNavBar() {

    const authStore = useAuthStore();

    const handleLogout = () => {
        authStore.logout();
        navigateTo('/login');
    };

    return {
        handleLogout
    }
}