<template>
  <header>
    <title>Triplan</title>
  </header>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
      <h2 class="text-3xl font-bold text-center mb-8">Benvingut de nou!</h2>

      <el-form @submit.prevent="loginAuth.loginUser" :model="loginAuth.loginData" label-position="top">
        <el-form-item label="Correu electrònic*">
          <el-input v-model="loginAuth.loginData.email" type="email" placeholder="elteucorreu@gmail.com" clearable />
        </el-form-item>

        <el-form-item label="Contrasenya*">
          <div class="relative group w-full">
            <el-input v-model="loginAuth.loginData.password"
              :type="loginAuth.isPasswordVisible.value ? 'text' : 'password'" placeholder="••••••••" minlength="8"
              class="hover:border-blue-400 focus:ring-2 focus:ring-blue-500 transition-all duration-200 w-full" />
            <button type="button" @click="loginAuth.togglePasswordVisibility('password')"
              class="absolute right-2 top-1/2 transform -translate-y-1/2 p-1 rounded-full hover:bg-gray-100 transition-colors duration-200">
              <span v-if="loginAuth.isPasswordVisible.value">
                <EyeSlashIcon class="h-5 w-5 text-gray-600 hover:text-blue-600" />
              </span>
              <span v-else>
                <EyeIcon class="h-5 w-5 text-gray-600 hover:text-blue-600" />
              </span>
            </button>
          </div>
          <span class="text-xs text-gray-500 mt-1 block">Mínim 8 caràcters</span>
        </el-form-item>

        <el-form-item>
          <el-button type="primary" native-type="submit" class="w-full">
            Iniciar Sessió
          </el-button>
        </el-form-item>
      </el-form>

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
import { useLoginAuth } from "~/composable/useLoginAuth";
import { EyeIcon, EyeSlashIcon } from "@heroicons/vue/24/solid";

const loginAuth = useLoginAuth();
</script>
