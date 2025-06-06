<template>
  <div class="flex flex-col min-h-screen bg-gray-50">
    <main class="flex-1 container mx-auto p-4">
      <el-card class="max-w-2xl mx-auto">
        <template #header>
          <h2 class="text-3xl font-bold text-center text-gray-800">
            Planifica el viatge dels teus somnis
          </h2>
        </template>

        <!-- Skeleton del formulario completo -->
        <div v-if="planner.isFormLoading.value" role="status" class="animate-pulse space-y-6 py-4">
          <!-- Fila 1: País + Tipo de viaje -->
          <div class="flex flex-col md:flex-row gap-4">
            <div class="w-full md:w-1/2 space-y-2">
              <div class="h-4 bg-gray-200 rounded-full w-24"></div>
              <div class="h-10 bg-gray-200 rounded-md w-full"></div>
            </div>
            <div class="w-full md:w-1/2 space-y-2">
              <div class="h-4 bg-gray-200 rounded-full w-36"></div>
              <div class="h-10 bg-gray-200 rounded-md w-full"></div>
            </div>
          </div>

          <!-- Fila 2: Fechas + Vehículo -->
          <div class="flex flex-col md:flex-row gap-4">
            <div class="w-full md:w-1/2 space-y-2">
              <div class="h-4 bg-gray-200 rounded-full w-32"></div>
              <div class="h-10 bg-gray-200 rounded-md w-full"></div>
            </div>
            <div class="w-full md:w-1/2 space-y-2">
              <div class="h-4 bg-gray-200 rounded-full w-40"></div>
              <div class="h-10 bg-gray-200 rounded-md w-full"></div>
            </div>
          </div>

          <!-- Fila 3: Presupuesto -->
          <div class="space-y-2">
            <div class="h-4 bg-gray-200 rounded-full w-48"></div>
            <div class="flex items-center justify-between gap-4 mb-2">
              <div class="w-28 h-10 bg-gray-200 rounded-md"></div>
              <div class="w-4 h-4 bg-gray-200 rounded-full"></div>
              <div class="w-28 h-10 bg-gray-200 rounded-md"></div>
            </div>
            <div class="h-6 bg-gray-200 rounded-md w-full"></div>
          </div>

          <!-- Fila 4: Intereses -->
          <div class="space-y-2">
            <div class="h-4 bg-gray-200 rounded-full w-28"></div>
            <div class="h-24 bg-gray-200 rounded-md w-full"></div>
          </div>

          <!-- Fila 5: Botón de submit -->
          <div class="flex gap-4 mt-8">
            <div class="h-12 bg-gray-200 rounded-md flex-1"></div>
            <div class="h-12 w-12 bg-gray-200 rounded-md"></div>
          </div>

          <span class="sr-only">Carregant formulari...</span>
        </div>

        <!-- Formulario real -->
        <el-form v-else @submit.prevent="planner.handleSubmit" :model="planner.formData.value" label-position="top"
          class="planner-form fade-in">
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
                  <el-input-number v-model="planner.budgetRange.value[0]" :min="0" :max="planner.budgetRange.value[1]"
                    :value="planner.budgetRange.value[0]" :step="100" controls-position="right" class="w-28" />
                </div>
                <span class="text-gray-400">-</span>
                <div class="flex items-center gap-2">
                  <label class="text-sm text-gray-600 font-medium">Max</label>
                  <el-input-number v-model="planner.budgetRange.value[1]" :min="planner.budgetRange.value[0]"
                    :value="planner.budgetRange.value[1]" :max="10000" :step="100" controls-position="right"
                    class="w-28" />
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

          <!-- Botones -->
          <div class="flex gap-4 mt-8">
            <el-button type="primary" native-type="submit" class="flex-1 h-12 text-lg font-medium">
              Planifica el meu viatge
            </el-button>

            <el-tooltip content="Netejar formulari" placement="top">
              <el-button type="default" @click="planner.resetForm" class="h-12 w-12 flex items-center justify-center">
                <ArrowPathIcon class="h-5 w-5" />
              </el-button>
            </el-tooltip>
          </div>
        </el-form>
      </el-card>
    </main>

    <button
      class="fixed bottom-4 right-4 bg-white rounded-full p-2 shadow-lg hover:shadow-xl transition-shadow duration-200"
      @click="planner.openChat">
      <ChatBubbleOvalLeftIcon v-if="!planner.isLoading.value" class="w-8 h-8 text-[#3f9eff]" />

      <!-- Icono de carga con animación de giro -->
      <div v-else class="flex items-center justify-center">
        <svg class="animate-spin h-10 w-10 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor"
            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
          </path>
        </svg>
      </div>
    </button>

    <Transition enter-active-class="transition-transform duration-300 ease-out"
      enter-from-class="translate-x-full opacity-0" enter-to-class="translate-x-0 opacity-100"
      leave-active-class="animate-bounce-out-down" leave-from-class="translate-x-0 opacity-100" leave-to-class="">

      <WindowChatBot v-if="planner.isWindowOpen.value" v-model:isOpen="planner.isWindowOpen.value"
        title="Asistent de planificació" :onSave="planner.saveMemoryBank">
        <form @submit.prevent="planner.handleSubmitChat" class="flex flex-col h-full">
          <div class="flex-1 overflow-y-auto mb-4 space-y-4 p-4" ref="chatContainer"
            :class="[chatContainer ? 'flex-1 overflow-y-auto mb-4 space-y-4 p-4 scroll-smooth transition-all duration-300 ease-in-out' : '']">
            <!-- Skeleton para cuando está cargando los mensajes -->
            <template v-if="planner.isFormLoading.value">
              <div class="animate-pulse space-y-4">
                <div class="flex justify-start">
                  <div class="bg-gray-200 p-3 rounded-lg w-3/4 h-16"></div>
                </div>
                <div class="flex justify-end">
                  <div class="bg-blue-200 p-3 rounded-lg w-2/4 h-12"></div>
                </div>
                <div class="flex justify-start">
                  <div class="bg-gray-200 p-3 rounded-lg w-4/5 h-20"></div>
                </div>
              </div>
            </template>

            <!-- Mensajes reales -->
            <template v-else>
              <div v-for="(message, index) in planner.chatMessages.value" :key="index"
                :class="['flex', message.isAI ? 'justify-start' : 'justify-end']">
                <div :class="['max-w-[80%] p-3 rounded-lg', message.isAI ? 'bg-gray-100' : 'bg-[#3f9eff] text-white']">
                  <p class="text-sm break-words whitespace-pre-wrap overflow-hidden" v-html="message.text"></p>
                  <div v-if="!planner.isOnline" class="px-3 py-1 text-xs bg-red-500 text-white rounded-t-md mx-auto">
                    Sense connexió a Internet
                  </div>
                </div>
              </div>
              <div v-if="planner.isTyping.value" class="flex justify-start">
                <div class="bg-gray-100 p-3 rounded-lg">
                  <div class="flex space-x-1">
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                  </div>
                </div>
              </div>
            </template>
          </div>

          <!-- Área de entrada de mensajes -->
          <div class="flex gap-2 p-4 border-t border-gray-200">
            <!-- Skeleton para el área de entrada cuando está cargando -->
            <template v-if="planner.isFormLoading.value">
              <div class="animate-pulse flex flex-1 gap-2">
                <div class="h-10 bg-gray-200 rounded flex-1"></div>
                <div class="h-10 w-14 bg-gray-200 rounded"></div>
              </div>
            </template>

            <!-- Área de entrada real -->
            <template v-else>
              <textarea v-model="planner.formDataChat.value.interests" placeholder="Escriu el teu missatge..."
                maxlength="500"
                class="flex-1 border border-gray-300 text-sm rounded-md py-2 px-1 focus:outline-none focus:ring-2 focus:ring-primary resize-none overflow-hidden"
                :disabled="planner.isTyping.value" rows="1"
                @input="$event.target.style.height = ''; $event.target.style.height = $event.target.scrollHeight + 'px'"
                @keydown.enter.prevent="
                  planner.resetTextAreaHeight($event);
                if (!planner.isTyping.value && planner.formDataChat.value.interests.trim()) {
                  planner.handleSubmitChat();
                }
                "></textarea>

              <!-- Botón de borrar conversación con tooltip -->
              <div class="relative group">
                <button @click="planner.clearConversation"
                  class="bg-[#3f9eff] text-white px-4 py-2 rounded-md hover:bg-[#2d8aed] transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                  <TrashIcon class="h-6 w-6" />
                </button>

                <!-- Tooltip que aparece al hacer hover (a la izquierda) -->
                <div
                  class="absolute right-full top-1/2 transform -translate-y-1/2 -translate-x-2 mr-1 px-3 py-1 bg-gray-900 text-white text-sm rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-opacity duration-300 whitespace-nowrap">
                  Esborrar la conversa
                  <!-- Flecha del tooltip (apuntando a la derecha) -->
                  <div
                    class="absolute left-full top-1/2 transform -translate-y-1/2 border-4 border-transparent border-l-gray-900">
                  </div>
                </div>
              </div>
            </template>
          </div>
        </form>
      </WindowChatBot>
    </Transition>
  </div>
</template>

<script setup>
import { ChatBubbleOvalLeftIcon, TrashIcon, ArrowPathIcon } from '@heroicons/vue/24/solid'
import { onMounted, ref, watch } from 'vue';
import "@vuepic/vue-datepicker/dist/main.css";
import { usePlanner } from '~/composable/usePlanner';

const planner = usePlanner();

onMounted(() => {
  planner.loadInitialData();
});

const chatContainer = ref(null);

// Watch for changes in chat messages
watch(() => planner.chatMessages.value, () => {
  // Wait for DOM update
  setTimeout(() => {
    if (chatContainer.value) {
      chatContainer.value.scrollTop = chatContainer.value.scrollHeight;
    }
  }, 0);
}, { deep: true });
</script>

<style>
.dp_main {
  width: 100%;
}

/* Animación para el formulario al cargar */
.fade-in {
  animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
  0% {
    opacity: 0;
    transform: translateY(10px);
  }

  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Animación del skeleton */
.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {

  0%,
  100% {
    opacity: 1;
  }

  50% {
    opacity: 0.6;
  }
}
</style>