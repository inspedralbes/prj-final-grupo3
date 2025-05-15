import { useAuthStore } from '~/store/authUser';
import * as com from '~/services/communicationManager';

export function useIndex() {

    const authStore = useAuthStore();

    const handlePlanTrip = () => {
        if (authStore.user) {
            navigateTo('/planner');
        } else {
            navigateTo('/login');
        }
    };

    return {
        handlePlanTrip,
    }
}