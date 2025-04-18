<template>
  <div class="flex flex-col min-h-screen bg-gray-50">
    <main class="flex-1 container mx-auto p-4">
      <el-card class="max-w-2xl mx-auto">
        <template #header>
          <h2 class="text-3xl font-bold text-center text-gray-800">
            Planifica el viatge dels teus somnis
          </h2>
        </template>

        <el-form @submit.prevent="planner.handleSubmit" :model="planner.formData.value" label-position="top">
          <el-row :gutter="20">
            <!-- Country -->
            <el-col :span="12">
              <el-form-item class="mb-6">
                <template #label>
                  <span>País <span class="text-red-500">*</span></span>
                </template>
                <el-select v-model="planner.searchQuery.value" filterable placeholder="On viatges?" class="w-full"
                  clearable @change="planner.selectCountry">
                  <el-option v-for="country in planner.filteredCountries.value" :key="country.id" :label="country.name"
                    :value="country" />
                </el-select>
              </el-form-item>
            </el-col>

            <!-- Type of trip -->
            <el-col :span="12">
              <div class="flex flex-col sm:flex-row gap-4">
                <el-form-item class="w-full">
                  <template #label>
                    <span>Amb qui viatges? <span class="text-red-500">*</span></span>
                  </template>
                  <el-select v-model="planner.formData.value.type" placeholder="Selecciona" class="flex-1">
                    <el-option v-for="type in planner.types.value" :key="type.id"
                      :label="type.id === 1 ? 'Sol/a' : type.id === 2 ? 'Família' : type.id === 3 ? 'Amics' : 'Parella'"
                      :value="type.id" />
                  </el-select>
                </el-form-item>

                <el-form-item v-if="planner.formData.value.type === 2 || planner.formData.value.type === 3">
                  <template #label>
                    <span>Quant. de persones <span class="text-red-500">*</span></span>
                  </template>
                  <el-input-number v-model="planner.formData.value.travelers" :min="1" :max="20"
                    controls-position="right" class="flex-1" />
                </el-form-item>
              </div>
            </el-col>
          </el-row>

          <el-row :gutter="20">
            <!-- Dates -->
            <el-col :span="12">
              <el-form-item>
                <template #label>
                  <span>Selecciona les dates <span class="text-red-500">*</span></span>
                </template>
                <el-date-picker v-model="planner.dateRange.value" type="daterange" range-separator="a"
                  start-placeholder="Data inici" end-placeholder="Data fi" :min-date="new Date()"
                  :disabled-date="(time) => time.getTime() < Date.now() - 8.64e7" class="w-full" />
              </el-form-item>
            </el-col>

            <!-- Vehicle -->
            <el-col :span="12">
              <div class="flex flex-col sm:flex-row gap-4">
                <el-form-item class="w-full">
                  <template #label>
                    <span>Lloguer de vehicle <span class="text-red-500">*</span></span>
                  </template>
                  <el-select v-model="planner.formData.value.vehicle" placeholder="Selecciona" class="w-full">
                    <el-option label="Si" value="yes" />
                    <el-option v-for="movility in planner.movilities.value.filter(m => m.id === 4)" :key="movility.id"
                      :label="movility.id === 4 ? 'No' : ''" :value="movility.id" />
                  </el-select>
                </el-form-item>

                <el-form-item v-if="planner.formData.value.vehicle === 'yes'" class="w-full">
                  <template #label>
                    <span>Tipus de vehicle <span class="text-red-500">*</span></span>
                  </template>
                  <el-select v-model="planner.formData.value.vehicletype" placeholder="Selecciona" class="w-full">
                    <el-option v-for="movility in planner.movilities.value.filter(m => m.id !== 4)" :key="movility.id"
                      :label="movility.id === 1 ? 'Bicicleta' : movility.id === 2 ? 'Cotxe' : 'Moto'"
                      :value="movility.id" />
                  </el-select>
                </el-form-item>
              </div>
            </el-col>
          </el-row>

          <el-form-item>
            <template #label>
              <span>Pressupost del viatge (€) <span class="text-red-500">*</span></span>
            </template>
            <div class="w-full">
              <!-- Inputs -->
              <div class="flex items-center justify-between gap-4 mb-2">
                <div class="flex items-center gap-2">
                  <label class="text-sm text-gray-600 font-medium">Mín</label>
                  <el-input-number v-model="planner.budgetRange.value[0]" :min="0" :max="planner.budgetRange.value[1]" :value="planner.budgetRange.value[0]"
                    :step="100" controls-position="right" class="w-28" />
                </div>
                <span class="text-gray-400">-</span>
                <div class="flex items-center gap-2">
                  <label class="text-sm text-gray-600 font-medium">Max</label>
                  <el-input-number v-model="planner.budgetRange.value[1]" :min="planner.budgetRange.value[0]" :value="planner.budgetRange.value[1]"
                    :max="10000" :step="100" controls-position="right" class="w-28" />
                </div>
              </div>

              <!-- Slider -->
              <el-slider v-model="planner.budgetRange.value" range :min="0" :max="10000" :step="100" show-tooltip
                class="w-full" :format-tooltip="(val) => `${val} €`" />
            </div>
          </el-form-item>



          <!-- Interests -->
          <el-form-item>
            <template #label>
              <span>Interessos <span class="text-red-500">*</span></span>
            </template>
            <el-input v-model="planner.formData.value.interests" type="textarea" :rows="3"
              placeholder="Que t'interessa? (e.x., cultura, aventura, relax)" class="w-full" />
          </el-form-item>

          <el-button type="primary" native-type="submit" class="w-full mt-8 h-12 text-lg font-medium">
            Planifica el meu viatge
          </el-button>
        </el-form>
      </el-card>
    </main>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import "@vuepic/vue-datepicker/dist/main.css";
import { usePlanner } from '~/composable/usePlanner';

const planner = usePlanner();

onMounted(() => {
  planner.loadInitialData();
});

</script>

<style>
.dp_main {
  width: 100%;
}
</style>
