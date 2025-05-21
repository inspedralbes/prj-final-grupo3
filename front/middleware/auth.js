import { useAuthStore } from '~/store/authUser'

export default defineNuxtRouteMiddleware((to, from) => {
  const user = useAuthStore()?.user

  const publicRoutes = ['/', '/login', '/register', '/explore']

  // if not logged in and trying to go to login or register page
  if (!user.value && !publicRoutes.includes(to.path)) {
    return navigateTo('/login')
  }

  // if user is logged in and trying to go to login or register page
  if (user.value && ['/login', '/register'].includes(to.path)) {
    return navigateTo('/')
  }
})
