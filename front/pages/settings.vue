<script setup>
import { ref } from 'vue';
import { useSettings } from '~/composable/useSettings';
import { useAuthStore } from '~/store/authUser';
import { PencilIcon, CheckIcon, XMarkIcon } from '@heroicons/vue/24/solid';

const authStore = useAuthStore();
const settings = useSettings();

</script>

<template>
    <div
        class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 flex items-center justify-center">
        <!-- Contenedor principal -->
        <div class="relative group bg-white p-6 rounded-lg shadow-lg max-w-md w-full">

            <div class="absolute top-2 right-2 flex space-x-2">
                <button v-if="!settings.isEditing.value" @click="settings.toggleEdit"
                    class="text-blue-500 hover:text-blue-700 transition">
                    <PencilIcon class="w-6 h-6" />
                </button>
                <div v-else class="flex space-x-2">
                    <button @click="settings.confirmEdit(authStore.user?.id)" class="text-green-500 hover:text-green-700 transition">
                        <CheckIcon class="w-6 h-6" />
                    </button>
                    <button @click="settings.cancelEdit" class="text-red-500 hover:text-red-700 transition">
                        <XMarkIcon class="w-6 h-6" />
                    </button>
                </div>
            </div>

            <div class="border border-blue-200 rounded-lg p-4 space-y-4">
                <h3 class="text-xl font-semibold text-center">Configuració</h3>

                <!-- Avatar -->
                <div class="flex items-center justify-center mb-4">
                    <img :src="settings.avatar.value" :alt="authStore.user?.name"
                        class="w-24 h-24 rounded-full border border-blue-200" />
                </div>

                <!-- Name & Surname -->
                <div class="flex items-center space-x-4">
                    <div>
                        <label for="name" class="block mb-1">Nom:</label>
                        <input id="name" type="text" v-model="settings.currentUser.value.name"
                            :disabled="!settings.isEditing.value"
                            class="w-full bg-blue-50 border border-gray-300 rounded px-2 py-1 focus:bg-white focus:border-blue-500" />
                    </div>
                    <div>
                        <label for="surname" class="block mb-1">Cognom:</label>
                        <input id="surname" type="text" v-model="settings.currentUser.value.surname"
                            :disabled="!settings.isEditing.value"
                            class="w-full bg-blue-50 border border-gray-300 rounded px-2 py-1 focus:bg-white focus:border-blue-500" />
                    </div>
                </div>

                <!-- Email & Alternative Email -->
                <div class="flex items-center space-x-4">
                    <div>
                        <label for="email" class="block mb-1">Correu:</label>
                        <input id="email" type="email" v-model="settings.currentUser.value.email"
                            :disabled="!settings.isEditing.value"
                            class="w-full bg-blue-50 border border-gray-300 rounded px-2 py-1 focus:bg-white focus:border-blue-500" />
                    </div>
                    <div>
                        <label for="email_alternative" class="block mb-1">Correu alternatiu:</label>
                        <input id="email_alternative" type="email"
                            v-model="settings.currentUser.value.email_alternative" :disabled="!settings.isEditing.value"
                            class="w-full bg-blue-50 border border-gray-300 rounded px-2 py-1 focus:bg-white focus:border-blue-500" />
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div>
                        <label for="birth_date" class="block mb-1">Data de naixement:</label>
                        <input id="birth_date" type="date" v-model="settings.currentUser.value.birth_date"
                            :disabled="!settings.isEditing.value"
                            class="w-full bg-blue-50 border border-gray-300 rounded px-2 py-1 focus:bg-white focus:border-blue-500" />
                    </div>
                    <div>
                        <label for="phone" class="block mb-1">Telèfon:</label>
                        <input id="phone" type="number" v-model="settings.currentUser.value.phone_number"
                            :disabled="!settings.isEditing.value"
                            class="w-full bg-blue-50 border border-gray-300 rounded px-2 py-1 focus:bg-white focus:border-blue-500" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Opcional: resaltar los campos cuando están activos */
input:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(59, 130, 246, 0.8);
}
</style>