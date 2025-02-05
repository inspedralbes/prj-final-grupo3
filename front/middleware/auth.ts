import { useAuthStore } from "~/store/authUser";

export default defineNuxtRouteMiddleware((to, from) => {
    const user = useAuthStore().user;
    
    // If user is not logged in and trying to access a protected route
    if (!user.value && to.path !== '/login' && to.path !== '/register' && to.path !== '/') {
      return navigateTo('/login');
    }
    
    // If user is logged in and trying to access login/register pages
    if (user.value && (to.path === '/login' || to.path === '/register')) {
      return navigateTo('/');
    }
  });