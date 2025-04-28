<script setup>
import { useSettings } from '~/composable/useSettings';
import { useAuthStore } from '~/store/authUser';
import { Edit, Check, Close } from '@element-plus/icons-vue';

const authStore = useAuthStore();
const settings = useSettings();

const fullName = `${authStore.user?.name} ${authStore.user?.surname}`
</script>

<template>
  <div class="flex items-center justify-center h-screen w-full bg-gray-50">
    <el-card class="w-[500px]">
      <template #header>
        <div class="flex justify-between items-center">
          <span class="text-xl">Configuració</span>
          <el-button v-if="!settings.isEditing.value" @click="settings.toggleEdit" type="primary" :icon="Edit" circle />
          <div v-else class="flex gap-2">
            <el-button @click="settings.confirmEdit" type="success">
              <el-icon>
                <Check />
              </el-icon>
            </el-button>
            <el-button @click="settings.cancelEdit" type="danger">
              <el-icon>
                <Close />
              </el-icon>
            </el-button>
          </div>
        </div>
      </template>

      <div class="space-y-6">
        <!-- Avatar -->
        <div class="flex justify-center">
          <el-avatar :size="100" :src="settings.avatar.value" :alt="`${fullName || 'User'}'s avatar`"
            class="bg-white border border-gray-200" />
        </div>

        <!-- Botons d'accions -->
        <div class="flex gap-2 justify-center" v-if="settings.isEditing.value">
          <!-- Change avatar -->
          <el-upload class="upload-demo" action="" :auto-upload="false" :show-file-list="false"
            :on-change="settings.handleAvatarChange" accept="image/*">
            <el-button type="primary">Canviar foto de perfil</el-button>
          </el-upload>
        </div>

        <!-- Formulari d'usuari -->
        <el-form label-position="top">
          <el-row :gutter="20">
            <el-col :span="12">
              <el-form-item label="Nom">
                <el-input v-model="settings.currentUser.value.name" :disabled="!settings.isEditing.value" clearable />
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item label="Cognom">
                <el-input v-model="settings.currentUser.value.surname" :disabled="!settings.isEditing.value" clearable />
              </el-form-item>
            </el-col>
          </el-row>

          <el-row :gutter="20">
            <el-col :span="12">
              <el-form-item label="Correu">
                <el-input v-model="settings.currentUser.value.email" type="email" clearable
                  :disabled="!settings.isEditing.value" />
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item label="Correu alternatiu">
                <el-input v-model="settings.currentUser.value.email_alternative" type="email" clearable
                  :disabled="!settings.isEditing.value" />
              </el-form-item>
            </el-col>
          </el-row>

          <el-row :gutter="20">
            <el-col :span="12">
              <el-form-item label="Data de naixement">
                <el-date-picker v-model="settings.currentUser.value.birth_date" type="date" format="YYYY-MM-DD"
                  value-format="YYYY-MM-DD" :disabled="!settings.isEditing.value" style="width: 100%" />
              </el-form-item>
            </el-col>
            <el-col :span="12">
              <el-form-item label="Telèfon">
                <el-input v-model="settings.currentUser.value.phone_number" type="tel" clearable
                  :disabled="!settings.isEditing.value" />
              </el-form-item>
            </el-col>
          </el-row>
        </el-form>

        <!-- Formulari de canvi de contrasenya -->
        <div v-if="settings.isEditing.value && settings.showPasswordForm" class="space-y-4 mt-4">
          <el-form label-position="top">
            <el-form-item label="Contrasenya actual">
              <el-input v-model="settings.passwordForm.currentPassword" type="password" clearable/>
            </el-form-item>
            <el-form-item label="Nova contrasenya">
              <el-input v-model="settings.passwordForm.newPassword" type="password" clearable/>
            </el-form-item>
            <el-form-item label="Confirmar nova contrasenya">
              <el-input v-model="settings.passwordForm.confirmPassword" type="password" clearable/>
            </el-form-item>
          </el-form>
        </div>
      </div>
    </el-card>
  </div>
</template>
