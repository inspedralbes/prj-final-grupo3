<template>
  <div
    class="flex relative min-h-screen justify-center items-center bg-[url('~/assets/images/sky.jpg')] bg-center bg-cover bg-no-repeat bg-fixed"
  >
    <div
      class="min-h-[80vh] w-[80%] rounded-lg shadow-2xl bg-white p-6 flex flex-col"
    >
      <div class="flex flex-col gap-4">
        <p class="text-2xl font-bold">Historial de viatges</p>
        <div class="flex gap-2">
          <input
            type="search"
            placeholder="Buscar viatge"
            class="p-3 border border-gray-300 rounded-lg flex-grow"
          />
          <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition"
          >
            Buscar
          </button>
        </div>
      </div>

      <div class="mt-6 flex flex-col gap-6 items-center">
        <div class="box">
          <div class="ticket"></div>
          <span class="absolute text-2xl font-bold font-['Arial'] text-blue-950 top-1.5 left-3">TRIPLAN</span>
          <span class="absolute text-sm font-bold font-['Arial'] text-blue-950 top-1.5 right-3">VIATGE</span>
        </div>
        <div class="box">
          <div class="ticket"></div>
          <span class="absolute text-2xl font-bold font-['Arial'] text-blue-950 top-1.5 left-3">TRIPLAN</span>
          <span class="absolute text-sm font-bold font-['Arial'] text-blue-950 top-1.5 right-3">VIATGE</span>
        </div>
        <div class="box">
          <div class="ticket"></div>
          <span class="absolute text-2xl font-bold font-['Arial'] text-blue-950 top-1.5 left-3">TRIPLAN</span>
          <span class="absolute text-sm font-bold font-['Arial'] text-blue-950 top-1.5 right-3">VIATGE</span>
        </div>
        <div class="box">
          <div class="ticket"></div>
          <span class="absolute text-2xl font-bold font-['Arial'] text-blue-950 top-1.5 left-3">TRIPLAN</span>
          <span class="absolute text-sm font-bold font-['Arial'] text-blue-950 top-1.5 right-3">VIATGE</span>
        </div>
        <div class="box">
          <div class="ticket"></div>
          <span class="absolute text-2xl font-bold font-['Arial'] text-blue-950 top-1.5 left-3">TRIPLAN</span>
          <span class="absolute text-sm font-bold font-['Arial'] text-blue-950 top-1.5 right-3">VIATGE</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script></script>

<style>
.box {
    position: relative;
}
.ticket {
  width: 60vw;
  height: 30vh;
  background: #ffb300;
  border-radius: 3px;
  box-shadow: 0 0 10px #aaa;
  border-top: 1px solid #e89f3d;
  border-bottom: 1px solid #e89f3d;
}
</style>
