<template>
  <div class="min-h-screen bg-gray-50 pt-2 flex items-center justify-center">
    <el-card class="w-[500px]">
      <template #header>
        <h2 class="text-2xl font-semibold text-center">Crear un compte</h2>
      </template>

      <el-form @submit.prevent="registerAuth.registerUser" :model="registerAuth.registerData" label-position="top">
        <el-row :gutter="20">
          <el-col :span="12">
            <el-form-item label="Nom*">
              <el-input v-model="registerAuth.registerData.name" placeholder="Carles" />
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="Cognoms*">
              <el-input v-model="registerAuth.registerData.surname" placeholder="Fernández Marín" />
            </el-form-item>
          </el-col>
        </el-row>

        <el-row :gutter="20">
          <el-col :span="12">
            <el-form-item label="Gènere*">
              <el-select v-model="registerAuth.registerData.gender" placeholder="Selecciona" class="w-full">
                <el-option label="Masculí" value="male" />
                <el-option label="Femení" value="female" />
                <el-option label="Prefereixo no dir-ho" value="other" />
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="Data de naixement*">
              <el-date-picker v-model="registerAuth.registerData.birth_date" type="date" format="YYYY-MM-DD"
                value-format="YYYY-MM-DD" class="w-full" />
            </el-form-item>
          </el-col>
        </el-row>

        <el-form-item label="Número de telèfon*">
          <el-input v-model="registerAuth.registerData.phone_number" placeholder="655767876" />
        </el-form-item>

        <el-form-item label="Correu*">
          <el-input v-model="registerAuth.registerData.email" type="email" placeholder="elteucorreu@gmail.com" />
        </el-form-item>

        <el-form-item label="Correu alternatiu*">
          <el-input v-model="registerAuth.registerData.email_alternative" type="email"
            placeholder="elteucorreualternatiu@gmail.com" />
        </el-form-item>

        <div class="space-y-6">
          <el-row :gutter="20">
            <el-col :span="12">
              <el-form-item label="Contrasenya*">
                <div class="relative group">
                  <el-input v-model="registerAuth.registerData.password"
                    :type="registerAuth.isPasswordVisible.value ? 'text' : 'password'" placeholder="••••••••"
                    class="hover:border-blue-400 focus:ring-2 focus:ring-blue-500 transition-all duration-200" />
                  <button type="button" @click="registerAuth.togglePasswordVisibility('password')"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 p-1 rounded-full hover:bg-gray-100 transition-colors duration-200">
                    <span v-if="registerAuth.isPasswordVisible.value">
                      <EyeSlashIcon class="h-5 w-5 text-gray-600 hover:text-blue-600" />
                    </span>
                    <span v-else>
                      <EyeIcon class="h-5 w-5 text-gray-600 hover:text-blue-600" />
                    </span>
                  </button>
                </div>
                <span class="text-xs text-gray-500 mt-1 block">Mínim 8 caràcters</span>
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item label="Confirmar contrasenya*">
                <div class="relative group">
                  <el-input v-model="registerAuth.registerData.password_confirmation"
                    :type="registerAuth.isConfirmPasswordVisible.value ? 'text' : 'password'" placeholder="••••••••"
                    class="hover:border-blue-400 focus:ring-2 focus:ring-blue-500 transition-all duration-200" />
                  <button type="button" @click="registerAuth.togglePasswordVisibility('confirmpassword')"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 p-1 rounded-full hover:bg-gray-100 transition-colors duration-200">
                    <span v-if="registerAuth.isConfirmPasswordVisible.value">
                      <EyeSlashIcon class="h-5 w-5 text-gray-600 hover:text-blue-600" />
                    </span>
                    <span v-else>
                      <EyeIcon class="h-5 w-5 text-gray-600 hover:text-blue-600" />
                    </span>
                  </button>
                </div>
              </el-form-item>
            </el-col>
          </el-row>
        </div>

        <el-button type="primary" native-type="submit" class="w-full mt-4">
          Crear un compte
        </el-button>

        <div class="text-center mt-6">
          <p class="text-gray-600">
            Ja tens un compte?
            <el-link type="primary" href="/login">Inicia sessió aquí</el-link>
          </p>
          <el-link type="info" href="/" class="mt-2">Tornar a inici</el-link>
        </div>
      </el-form>
    </el-card>
  </div>
</template>

<script setup>
import { useRegisterAuth } from '~/composable/useRegisterAuth';
import { EyeIcon, EyeSlashIcon } from '@heroicons/vue/24/solid';

const registerAuth = useRegisterAuth();
</script>