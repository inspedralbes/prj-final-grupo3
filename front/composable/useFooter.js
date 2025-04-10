import { useRouter } from 'nuxt/app';

export function useFooter() {
  const router = useRouter();

  const navigateToPage = (path) => {
    router.push({
      path: `${path}`,
    });
  };

  return {
    navigateToPage,
  };
}