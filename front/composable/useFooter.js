import { useRouter } from 'nuxt/app';

export function useFooter() {
  const router = useRouter();

  const navigateToPage = (page) => {
    switch (page) {
      case 'about-us':
        router.push('/footer/about-us'); // Ruta de /pages/footer/about-us.vue
        break;
      case 'privacy-policy':
        router.push('/footer/privacy-policy'); // Ruta de /pages/footer/privacy-policy.vue
        break;
      case 'terms-of-service':
        router.push('/footer/terms-of-service'); // Ruta de /pages/footer/terms-of-service.vue
        break;
      case 'contact':
        router.push('/footer/contact'); // Ruta de /pages/footer/contact.vue
        break;
      default:
        console.error('Ruta no definida:', page);
    }
  };

  return {
    navigateToPage,
  };
}