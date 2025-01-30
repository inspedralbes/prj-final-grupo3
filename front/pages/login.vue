<template>
    <header>
        <title>Triplan</title>
    </header>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-3xl font-bold text-center mb-8">Benvingut de nou!</h2>

            <!--form for login-->
            <form @submit.prevent="handleLogin" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Correu</label>
                    <input type="email" v-model="email" required
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        placeholder="elteucorreu@gmail.com" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contrasenya</label>
                    <div class="relative">
                        <input :type="isPasswordVisible ? 'text' : 'password'" v-model="password" required minlength="8"
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                            placeholder="••••••••" />
                        <button type="button" @click="togglePasswordVisibility('password')"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2">
                            <span v-if="isPasswordVisible">👁️</span>
                            <span v-else>👁️‍🗨️</span>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                    Iniciar Sessió
                </button>
            </form>

            <p class="mt-6 text-center text-gray-600">
                No tens un compte?
                <NuxtLink to="/register" class="text-blue-600 hover:text-blue-800 font-medium">
                    Registra't aquí
                </NuxtLink>
            </p>

            <NuxtLink to="/" class="block mt-4 text-center text-gray-500 hover:text-gray-700">
                Tornar al inici
            </NuxtLink>
        </div>
    </div>
</template>

<script setup>
const user = useState("user");
const email = ref("");
const password = ref("");
const isPasswordVisible = ref(false);

const handleLogin = () => {
    user.value = { email: email.value };
    navigateTo("/planner");
};

const togglePasswordVisibility = (field) => {
    if (field === "password") {
        isPasswordVisible.value = !isPasswordVisible.value;
    }
};
</script>
