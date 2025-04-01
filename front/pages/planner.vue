<template>
  <header>
    <title>Triplan</title>
  </header>
  <div class="h-screen bg-gray-50">
    <main class="container mx-auto p-4">
      <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-3xl font-bold text-center mb-8">
          Planifica el viatge dels teus somnis
        </h2>

        <!--form for planner-->
        <form @submit.prevent="planner.handleSubmit" class="space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- country -->
            <div class="relative">
              <label class="block text-sm font-medium text-gray-700 mb-2">País</label>

              <!-- user writes -->
              <input required v-model="planner.searchQuery.value" @input="planner.filterCountries"
                @focus="planner.showDropdown.value = true" @blur="planner.hideDropdown" type="text"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                placeholder="On viatges?" />

              <!-- dropdown countries list -->
              <ul v-if="planner.showDropdown.value && planner.filteredCountries.value.length"
                class="absolute w-full border border-gray-300 bg-white shadow-md rounded-md mt-1 max-h-40 overflow-y-auto z-50">
                <li v-for="country in planner.filteredCountries.value" :key="country.id"
                  @mousedown="planner.selectCountry(country)" class="p-2 hover:bg-gray-200 cursor-pointer">
                  {{ country.name }}
                </li>
              </ul>
            </div>

            <!--type of trip -->
            <div class="flex items-center space-x-4">
              <div class="w-1/2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Amb qui viatges?</label>
                <select v-model="planner.formData.value.type" name="type" class="border p-2 rounded w-full" required>
                  <option disabled selected value="">Selecciona</option>
                  <option v-for="type in planner.types.value" :key="type.id" :value="type.id">
                    {{ type.id === 1 ? "Sol/a" : type.id === 2 ? "Família" : type.id === 3 ? "Amics" : type.id === 4 ?
          "Parella" : "" }}
                  </option>
                </select>
              </div>

              <div v-if="planner.formData.value.type === 2 || planner.formData.value.type === 3" class="w-1/2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Quant. de persones</label>
                <input type="number" v-model="planner.formData.value.travelers" min="1"
                  class="border p-2 rounded w-full" placeholder="3" required>
              </div>
            </div>

            <!-- Select dates -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-5 h-1">Selecciona les dates</label>
              <VueDatePicker v-model="planner.dateRange.value" range multi-calendars :enable-time-picker="false"
                locale="ca" class="w-full border p-2 rounded-md" :text-input="true" :text-input-options="{
          selectText: 'Confirmar',
          cancelText: 'Cancel·lar',
        }" :min-date="new Date()" />
            </div>

            <div class="flex items-center space x-4">
              <!-- rent a car -->
              <div class="w-1/2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Lloguer de vehicle</label>
                <select v-model="planner.formData.value.vehicle" class="border p-2 rounded" required>
                  <option disabled selected value="">Selecciona</option>
                  <option value="yes">Si</option>
                  <!-- <option value="no">No</option> -->
                  <option v-for="movility in planner.movilities.value.filter(m => m.id === 4)" :key="movility.id"
                    :value="movility.id">
                    {{ movility.id === 1 ? "Bicicleta" : movility.id === 2 ? "Cotxe" : movility.id === 3 ? "Moto" :
          movility.id === 4 ? "No" : "" }}
                  </option>
                </select>
              </div>
              <!-- if vehicle is yes-->
              <!-- Selección de Tipus de vehicle usando la lista de movilities -->
              <div v-if="planner.formData.value.vehicle === 'yes'" class="w-1/2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipus de vehicle</label>
                <select v-model.number="planner.formData.value.vehicletype" class="border p-2 rounded w-full" required>
                  <option disabled selected value="">Selecciona</option>
                  <option v-for="movility in planner.movilities.value.filter(m => m.id !== 4)" :key="movility.id"
                    :value="movility.id">
                    {{ movility.id === 1 ? "Bicicleta" : movility.id === 2 ? "Cotxe" : movility.id === 3 ? "Moto" : ""
                    }}
                  </option>
                </select>
              </div>
            </div>

            <!-- Budget -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Estableix el pressupost mínim (€)</label>
              <div>
                <!-- Budget Min -->
                <div class="w-3/3">
                  <input required id="minBudget" type="number" v-model="planner.formData.value.budgetmin" min="0"
                    placeholder="200"
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                    @input="planner.syncWithBudget" />
                  <!-- Range Slider-->
                  <input type="range" v-model="planner.budgetMin.value" :min="0" :max="planner.budgetMax.value"
                    step="100" class="w-full h-2 bg-blue-200 rounded-md mt-2" @input="planner.syncWithBudget" />
                </div>
              </div>
            </div>
            <div>
              <!-- Budget Min -->
              <label class="block text-sm font-medium text-gray-700 mb-2">Estableix el pressupost màxim (€)</label>
              <div class="w-3/3">
                <input required id="maxBudget" type="number" v-model="planner.formData.value.budgetmax" min="0"
                  placeholder="3000"
                  class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                  @input="planner.syncWithBudget" />
                <!-- Range Slider -->
                <input type="range" v-model="planner.budgetMax.value" :min="planner.budgetMin.value" :max="10000"
                  step="100" class="w-full h-2 bg-blue-500 rounded-md mt-2" @input="planner.syncWithBudget" />
              </div>
            </div>
          </div>

          <!-- Interests -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Interessos</label>
            <textarea v-model="planner.formData.value.interests"
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" rows="3"
              placeholder="Que t'interessa? (e.x., cultura, aventura, relax)" required></textarea>
          </div>

          <button type="submit"
            class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
            Planifica el meu viatge
          </button>
        </form>
      </div>
    </main>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { usePlanner } from '~/composable/usePlanner';

const planner = usePlanner();

console.log(planner.types.value)

onMounted(() => {
  planner.loadInitialData();
});
</script>

<style>
.dp_main {
  width: 100%;
}
</style>
