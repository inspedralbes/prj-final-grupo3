<script setup>
import { useSettings } from '~/composable/useSettings';
import { useAuthStore } from '~/store/authUser';

const authStore = useAuthStore();
const settings = useSettings();

settings

</script>

<template>
    <div class="fixed inset-0 flex justify-center items-center">
        <div class="bg-white w-auto max-w-full p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold">Configuració</h3>
            </div>
            <div class="mt-4 flex items-center space-x-4">
                <div class="flex items-center">
                    <!-- Fix img -->
                    <!-- <img :src="settings.avatar + authStore.user.avatar" :alt="authStore.user.name"
                        class=" rounded-full" /> -->
                </div>
                <div class="flex items-center">
                    <label for="name" class="mr-2">Nom: </label>
                    <input id="name"
                        class="w-auto max-w-[120px] inline-flex bg-blue-200 border-2 rounded-lg px-2 focus:outline-8 focus:ring-blue-500"
                        type="text" :value="settings.currentUser.value.name" disabled>
                </div>

                <div class="flex items-center">
                    <label for="surname" class="mr-2">Cognom: </label>
                    <input id="surname"
                        class="w-auto max-w-[120px] inline-flex bg-blue-200 border-2 rounded-lg px-2 focus:outline-8 focus:ring-blue-500"
                        type="text" :value="settings.currentUser.value.surname" disabled>
                </div>
            </div>
        </div>
    </div>

</template>

<style scoped>
.wi-fit {
    display: flex;
}
</style>