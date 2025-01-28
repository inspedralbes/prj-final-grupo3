export default defineNuxtPlugin((nuxtApp) => {
    return {
        provide: {
            sessionStorage: sessionStorage,
        },
    };
});