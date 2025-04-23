<template>
  <div v-if="prop.vista !== 'resum' && dia" class="bg-white rounded-lg shadow-md p-4 border">
    <div class="flex items-center justify-between mb-3">
      <h3 class="text-xl font-bold">{{ dia.dia }}</h3>
      <img :src="downArrow" alt="Arrow" class="size-6 cursor-pointer arrow-icon"
        @click="showMoreDetails" :class="{ 'rotated': mostrandoDetalles }" />
    </div>

    <p class="text-gray-600 text-sm" v-show="!mostrandoDetalles">{{ dia.resumenDia }}</p>

    <transition name="expand" @enter="startTransition" @after-enter="endTransition" @before-leave="startTransition"
      @after-leave="endTransition">
      <div v-show="mostrandoDetalles" class="overflow-hidden">
        <ul class="space-y-2">
          <InfoDay v-for="(act, index) in dia.activitats" :key="index" :act="act" />
        </ul>
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
}

function endTransition(element) {
  element.style.height = '';
  element.style.overflow = 'visible';
}
</script>

<style scoped>
.expand-enter-active,
.expand-leave-active {
  transition: all 0.4s ease-out;
  overflow: hidden;
}

.expand-enter-from,
.expand-leave-to {
  height: 0 !important;
  opacity: 0;
}

/* Nova implementació de la transició de fletxa */
.arrow-icon {
  transition: transform 0.6s ease-in-out;
}

.arrow-icon.rotated {
  transform: rotate(-180deg);
}
</style>