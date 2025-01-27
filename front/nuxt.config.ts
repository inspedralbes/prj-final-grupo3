// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2024-11-01',
  devtools: { enabled: true },
  modules: [
    '@nuxtjs/tailwindcss',
    // '@nuxtjs/proxy',
  ],
  css: [
    '~/assets/css/tailwind.css',
  ],
  // proxy: {
  //   '/api/': {
  //     target: 'http://localhost:8000', // URL del backend
  //     pathRewrite: { '^/api/': '/api/' },
  //     changeOrigin: true,
  //   },
  // },
})


