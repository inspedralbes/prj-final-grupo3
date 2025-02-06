<template>
  <div
    class="flex flex-col relative min-h-screen justify-center items-center bg-[url('~/assets/images/sky.jpg')] bg-center bg-cover bg-no-repeat bg-fixed gap-4">
    <div class="min-h-[10vh] max-h-[80vh] w-[80%] rounded-lg shadow-2xl bg-white p-6 flex flex-col overflow-y-auto">
      <div class="flex flex-col gap-4">
        <p class="text-2xl font-bold">Historial de viatges</p>
        <div class="flex gap-2">
          <input type="search" placeholder="Buscar viatge" class="p-3 border border-gray-300 rounded-lg flex-grow" />
          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
            Buscar
          </button>
        </div>
      </div>
    </div>
    <div class="min-h-[80vh] max-h-[80vh] w-[80%] rounded-lg shadow-2xl bg-white p-6 flex flex-col overflow-y-auto">
      <div class="flex flex-col gap-6 items-center">
        <div class="box">
          <div class="ticket">
            <div class="ticket-header">
              <p class="flex text-2xl font-bold font-['Arial'] text-blue-950">TRIPLAN</p>
              <p class="flex text-xl font-['Arial'] text-gray-100">Informació del viatge</p>
              <p class="flex text-sm font-bold font-['Arial'] text-blue-950">VIATGE</p>
            </div>
            <div class="content">
              <!-- Contingut -->
              <div class="flight-info font-['Arial'] text-5xl font-bold">
                <p>MRD</p>
                <img src="../assets/images/plane.svg" alt="" class="w-12 h-15">
                <p>BCN</p>
              </div>
              <div class="sub-content">
                <!-- Sub contingut -->
                <p class="watermark">TriPlan</p>
                <div class="grid grid-cols-3 gap-4 w-[80%] sm:w-[30vw] p-4">
                  <div class="flex flex-col gap-2">
                    <p class="font-semibold">Nom</p>
                    <p>Antonio, Aivan</p>
                  </div>
                  <div class="flex flex-col gap-2">
                    <p class="font-semibold">Destí</p>
                    <p>Barcelona</p>
                  </div>
                  <div class="flex flex-col gap-2">
                    <p class="font-semibold">Data</p>
                    <p>11/02/2025 - 13/02/2025</p>
                  </div>
                  <div class="flex flex-col gap-2">
                    <p class="font-semibold">Quantitat dies</p>
                    <p>7</p>
                  </div>
                  <div class="flex flex-col gap-2">
                    <p class="font-semibold">Mobilitat</p>
                    <p>Aèria</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="barcode-container flex justify-around">
              <p class="absolute font-mono text-sm bottom-2 left-30 text-gray-100 font-bold">Data de creació: </p>
              <div class="barcode"></div>
              <div class="barcode"></div>
              <div class="barcode"></div>
            </div>
          </div>
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
  width: 70vw;
  height: 40vh;
  background: #ffb300;
  border-radius: 3px;
  box-shadow: 0 0 10px #aaa;
  border-top: 1px solid #e89f3d;
  border-bottom: 1px solid #e89f3d;
}

.content {
  position: absolute;
  top: 40px;
  width: 100%;
  height: 17vh;
  background: #eee;
}

.sub-content {
  background: #e5e5e5;
  width: 100%;
  height: 20vh;
  position: absolute;
  top: 100px;
}

.ticket-header {
  position: absolute;
  top: .5vh;
  left: 10px;
  right: 10px;
  display: flex;
  justify-content: space-between;
  color: #fff;
  padding: 0 10px;
}

.ticket-header span {
  display: inline-block;
}

.barcode-container {
  position: absolute;
  bottom: 1vh;
  width: 100%;
  display: flex;
  justify-content: space-between;
  padding: 0 10px;
}

.barcode {
  display: flex;
  height: 30px;
  width: 90px;
  background: #222;
  box-shadow: inset 0 1px 0 #FFB300, inset -2px 0 0 #FFB300,
    inset -4px 0 0 #222,
    inset -5px 0 0 #FFB300,
    inset -6px 0 0 #222,
    inset -9px 0 0 #FFB300,
    inset -12px 0 0 #222,
    inset -13px 0 0 #FFB300,
    inset -14px 0 0 #222,
    inset -15px 0 0 #FFB300,
    inset -16px 0 0 #222,
    inset -17px 0 0 #FFB300,
    inset -19px 0 0 #222,
    inset -20px 0 0 #FFB300,
    inset -23px 0 0 #222,
    inset -25px 0 0 #FFB300,
    inset -26px 0 0 #222,
    inset -26px 0 0 #FFB300,
    inset -27px 0 0 #222,
    inset -30px 0 0 #FFB300,
    inset -31px 0 0 #222,
    inset -33px 0 0 #FFB300,
    inset -35px 0 0 #222,
    inset -37px 0 0 #FFB300,
    inset -40px 0 0 #222,
    inset -43px 0 0 #FFB300,
    inset -44px 0 0 #222,
    inset -45px 0 0 #FFB300,
    inset -46px 0 0 #222,
    inset -48px 0 0 #FFB300,
    inset -49px 0 0 #222,
    inset -50px 0 0 #FFB300,
    inset -52px 0 0 #222,
    inset -54px 0 0 #FFB300,
    inset -55px 0 0 #222,
    inset -57px 0 0 #FFB300,
    inset -59px 0 0 #222,
    inset -61px 0 0 #FFB300,
    inset -64px 0 0 #222,
    inset -66px 0 0 #FFB300,
    inset -67px 0 0 #222,
    inset -68px 0 0 #FFB300,
    inset -69px 0 0 #222,
    inset -71px 0 0 #FFB300,
    inset -72px 0 0 #222,
    inset -73px 0 0 #FFB300,
    inset -75px 0 0 #222,
    inset -77px 0 0 #FFB300,
    inset -80px 0 0 #222,
    inset -82px 0 0 #FFB300,
    inset -83px 0 0 #222,
    inset -84px 0 0 #FFB300,
    inset -86px 0 0 #222,
    inset -88px 0 0 #FFB300,
    inset -89px 0 0 #222,
    inset -90px 0 0 #FFB300;
}

.watermark {
  position: absolute;
  left: 1vw;
  font-family: Arial;
  font-size: 15rem;
  font-weight: bold;
  color: rgba(255, 255, 255, 0.2);
}

.flight-info {
  position: absolute;
  width: 20vw;
  top: 3vh;
  left: 1vw;
  display: flex;
  justify-content: space-between;
  padding: 0 1vw;
}
</style>