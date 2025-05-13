// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2024-11-01',
  devtools: { enabled: true },
  modules: [
    '@nuxtjs/tailwindcss',
    '@pinia/nuxt',
  ],
  css: [
    '~/assets/css/tailwind.css',
    'element-plus/dist/index.css',
    'leaflet/dist/leaflet.css',
  ],
  build: {
    transpile: ['element-plus/es', '@vue-leaflet/vue-leaflet'],
  },
  ssr: false,
  runtimeConfig: {
    // Public vars
    public: {
      apiUrl: process.env.NUXT_API_URL,
      appName: process.env.NUXT_APP_NAME,
      apiKey: process.env.NUXT_GEMINI_API_KEY,
      apiUrlNode: process.env.NUXT_APP_URL_NODE
    },
  }
})


