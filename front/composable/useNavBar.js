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

  // Add a watch on authStore.user
  watch(() => authStore.user, async (newUser) => {
    if (newUser && newUser.avatar) {
      const baseURL = config.public.appName;
      const avatarUrl = `${baseURL}/${newUser.avatar}`;
      avatar.value = avatarUrl;
    }
  }, { immediate: true });


  const handleLogout = async () => {
    authStore.logout();
    await navigateTo('/login'); // wait for the navigation is completed
  };

  const toggleDropdown = (event) => {
    isOpen.value = !isOpen.value;
  };

  const handleClickOutside = (event) => {
    if (!event.target.closest('.dropdown-container')) {
      isOpen.value = false;
    }
  };

  // Close the dropdown when the route changes
  watch(route, () => {
    isOpen.value = false;
  });

  onMounted(async () => {

    document.addEventListener('click', handleClickOutside);

    if (process.client) {
      await authStore.initialize();
      const response = await com.getCurrentUser(authStore.token);

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