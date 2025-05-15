<template>
  <title>Carregant...</title>
  <div class="min-h-screen bg-white flex flex-col justify-center items-center space-y-4">
    <!-- gif-->
    <img src="~/assets/gifs/plane2.gif" alt="Cargando..." class="w-80 h-80" />

    <!-- loader -->
    <div class="loaderBar"></div>
  </div>
</template>

<style scoped>
.loaderBar {
  width: 50%;
  height: 10px;
  background: #F9F9F9;
  border-radius: 10px;
  border: 1px solid #006DFE;
  position: relative;
  overflow: hidden;
  margin-top: 20px;
}

.loaderBar::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  border-radius: 5px;
  background: repeating-linear-gradient(45deg, #0031F2 0 30px, #006DFE 0 40px) right/200% 100%;
  animation: fillProgress 7s ease-in-out infinite, lightEffect 1s infinite linear;
  animation-fill-mode: forwards;
}

@keyframes fillProgress {
  0% {
    width: 0;
  }

  33% {
    width: 33.333%;
  }

  66% {
    width: 66.67%;
  }

  100% {
    width: 100%;
  }
}

@keyframes lightEffect {

  0%,
  20%,
  40%,
  60%,
  80%,
  100% {
    background: repeating-linear-gradient(45deg, #0031F2 0 30px, #006DFE 0 40px) right/200% 100%;
  }

  10%,
  30%,
  50%,
  70%,
  90% {
    background: repeating-linear-gradient(45deg, #0031F2 0 30px, #006DFE 0 40px, rgba(255, 255, 255, 0.3) 0 40px) right/200% 100%;
  }
}
</style>
