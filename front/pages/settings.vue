<script setup>
import { useSettings } from '~/composable/useSettings';
import { useAuthStore } from '~/store/authUser';
import { PencilIcon } from '@heroicons/vue/24/solid'


const authStore = useAuthStore();
const settings = useSettings();

</script>

<template>
    <div
        class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 flex items-center justify-center">
        <!-- Contenedor principal con hover controlado por Tailwind -->
        <div class="relative group bg-white p-6 rounded-lg shadow-lg max-w-md w-full">

            <!-- Pencil icon show when make hover -->
            <PencilIcon
                class="w-6 h-6 text-blue-400 absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer hover:text-blue-500" />

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
                        <input id="name" type="text" :value="settings.currentUser.value.name" disabled
                            class="w-full bg-blue-50 border border-gray-300 rounded px-2 py-1" />
                    </div>
                    <div>
                        <label for="surname" class="block mb-1">Cognom:</label>
                        <input id="surname" type="text" :value="settings.currentUser.value.surname" disabled
                            class="w-full bg-blue-50 border border-gray-300 rounded px-2 py-1" />
                    </div>
                </div>

                <!-- Email & Alternative Email -->
                <div class="flex items-center space-x-4">
                    <div>
                        <label for="email" class="block mb-1">Correu:</label>
                        <input id="email" type="email" :value="settings.currentUser.value.email" disabled
                            class="w-full bg-blue-50 border border-gray-300 rounded px-2 py-1" />
                    </div>
                    <div>
                        <label for="email_alternative" class="block mb-1">Correu alternatiu:</label>
                        <input id="email_alternative" type="email" :value="settings.currentUser.value.email_alternative"
                            disabled class="w-full bg-blue-50 border border-gray-300 rounded px-2 py-1" />
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div>
                        <label for="birth_date" class="block mb-1">Data de naixement:</label>
                        <input id="birth_date" type="date" :value="settings.currentUser.value.birth_date" disabled
                            class="w-full bg-blue-50 border border-gray-300 rounded px-2 py-1" />
                    </div>
                    <div>
                        <label for="phone" class="block mb-1">Telèfon:</label>
                        <input id="phone" type="number" :value="settings.currentUser.value.phone_number" disabled
                            class="w-full bg-blue-50 border border-gray-300 rounded px-2 py-1" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.shadow-around {
    filter: drop-shadow(0 0 5px rgb(255, 255, 0));
}
</style>
