<template>
  <div v-if="prop.vista !== 'resum' && dia" class="bg-white rounded-lg shadow-md p-4 border bg-cover bg-center"
    :style="{ backgroundImage: `linear-gradient(rgba(255, 255, 255, 0.70), rgba(255, 255, 255, 0.70)), url(${dia.imatgeUrl})` }">
    <div class="flex items-center justify-between mb-3 bg-white/50 rounded-t-lg p-2 border-b-2 border-gray-400">
      <h3 class="text-xl font-bold">{{ dia.dia }}</h3>
      <img :src="downArrow" alt="Arrow" class="size-6 cursor-pointer arrow-icon" @click="showMoreDetails"
        :class="{ 'rotated': mostrandoDetalles }" />
    </div>

    <transition name="fade">
      <p v-if="!mostrandoDetalles" class="text-gray-600 text-sm ml-2 summary-text">{{ dia.resumDia }}</p>
    </transition>

    <transition name="expand" @enter="startTransition" @after-enter="endTransition" @before-leave="startTransition"
      @after-leave="endTransition">
      <div v-show="mostrandoDetalles" class="transition-wrapper">
        <div class="transition-content">
          <ul class="space-y-4">
            <InfoDay v-for="(act, index) in dia.activitats" :key="index" :act="act" />
          </ul>
        </div>
      </div>
    </transition>
  </div>

  <div v-else-if="prop.vista === 'resum' && dia">
    <InfoSummary :summary="prop.dia" />
  </div>

  <div v-else>
    No hi ha cap resultat a mostrar.
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import downArrow from '../assets/images/down-arrow.svg'
import upArrow from '../assets/images/up-arrow.svg'

const prop = defineProps({
  dia: Object,
  vista: String,
  index: Number,
  expandit: Boolean
})

const emit = defineEmits(['toggle']);
const mostrandoDetalles = ref(false);

watch(() => prop.expandit, (nouValor) => {
  mostrandoDetalles.value = nouValor;
});

function showMoreDetails() {
  emit('toggle');
}

function startTransition(element) {
  const height = element.scrollHeight;

  element.style.height = '0px';

  element.offsetHeight;

  element.style.height = height + 'px';

  element.style.overflow = 'hidden';

  const childElements = element.querySelectorAll('.transition-content *');
  childElements.forEach((el, index) => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(15px)';

    setTimeout(() => {
      el.style.opacity = '1';
      el.style.transform = 'translateY(0)';
    }, 100 + (index * 60));
  });
}

function endTransition(element) {
  element.style.height = '';

  element.style.overflow = 'hidden';

  const childElements = element.querySelectorAll('.transition-content *');
  childElements.forEach(el => {
    el.style.opacity = '';
    el.style.transform = '';
  });
}
</script>

<style scoped>
.expand-enter-active,
.expand-leave-active {
  transition: all 0.8s ease-out;
  overflow: hidden !important;
}

.expand-enter-from,
.expand-leave-to {
  height: 0 !important;
  opacity: 0;
}

.summary-text {
  display: block;
  transform-origin: top;
}

.fade-enter-active,
.fade-leave-active {
  transition: all 0.6s ease;
  max-height: 100px;
  opacity: 1;
  transform: translateY(0);
}

.fade-enter-from,
.fade-leave-to {
  max-height: 0;
  opacity: 0;
  transform: translateY(-15px);
  margin-bottom: 0;
}

.transition-wrapper {
  overflow: hidden !important;
}

.arrow-icon {
  transition: transform 0.9s ease-in-out;
}

.arrow-icon.rotated {
  transform: rotate(-180deg);
}

.transition-content {
  position: relative;
  overflow: hidden;
}

.transition-content * {
  transition: opacity 0.7s ease, transform 0.7s ease;
}
</style>