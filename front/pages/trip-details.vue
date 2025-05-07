<template>
  <div
    class="flex flex-col relative min-h-screen justify-center items-center bg-[url('~/assets/images/sky.jpg')] bg-center bg-cover bg-no-repeat bg-fixed gap-4">
    <div class="min-h-[10vh] max-h-[80vh] w-[80%] rounded-lg shadow-2xl bg-white p-6 flex flex-col overflow-y-auto">
      <div class="flex flex-col gap-4">
        <p class="text-2xl font-bold">Historial de viatges</p>
        <div class="flex gap-2">
          <input v-model="tripDetails.searchQuery.value" type="search"
            placeholder="Buscar viatge (quantitat de dies, pres. min, pres. max, destí, data, movilitat ...)"
            class="p-3 border border-gray-300 rounded-lg flex-grow" />
        </div>
      </div>
    </div>
    <div class="min-h-[50vh] max-h-[80vh] w-[80%] rounded-lg shadow-2xl bg-white p-6 flex flex-col overflow-y-auto">
      <div class="flex flex-col gap-6 items-center">
        <p v-if="tripDetails.filteredTrips.length === 0"
          class="text-center text-lg font-semibold text-gray-300 flex items-center justify-center min-h-[50vh]">
          No hi ha cap historial de viatges. Has de viatjar més!
        </p>

        <div class="relative" v-for="travel in tripDetails.filteredTrips.value" :key="travel.id">
          <div class="flex justify-end py-2">
            <img src="../assets/images/delete.svg" alt="" class="size-8 cursor-pointer hover:rotate-180 transition duration-300"
              @click="tripDetails.deleteTravel(travel.id)" />
          </div>
          <div class="w-[70vw] h-[40vh] bg-[#ffb300] rounded-md shadow-lg border-t border-b border-[#e89f3d] relative">
            <div class="absolute top-[0.5vh] left-2.5 right-2.5 flex justify-between text-white px-2.5">
              <p class="flex text-2xl font-bold font-['Arial'] text-blue-950">TRIPLAN</p>
              <p class="flex text-xl font-['Arial'] text-gray-100">Informació del viatge</p>
              <p class="flex text-sm font-bold font-['Arial'] text-blue-950">VIATGE #00{{ travel.id }}</p>
            </div>


            <div class="absolute top-10 w-full h-[17vh] bg-gray-200">
              <div
                class="absolute top-3 left-[1vw] flex justify-between px-[1vw] gap-[1vw] font-['Arial'] text-5xl font-bold">
                <p>{{ travel.user.name.slice(0, 3).toUpperCase() }}</p>
                <img src="../assets/images/plane.svg" alt="" class="w-12 h-15">
                <p>{{ travel.country.code }}</p>
              </div>

              <div
                class="absolute top-4 right-[6vw] flex justify-between px-[1vw] gap-[1vw] font-['Arial'] text-4xl font-bold">
                <p>{{ travel.user.name.slice(0, 3).toUpperCase() }}</p>
                <img src="../assets/images/plane.svg" alt="" class="w-12 h-15">
                <p>{{ travel.country.code }}</p>
              </div>

              <div class="absolute top-[100px] w-full h-[20vh] bg-[#e5e5e5] flex">
                <p class="absolute left-[1vw] font-['Arial'] text-[15rem] font-bold text-white/20">TriPlan</p>
                <div class="grid grid-cols-5 gap-4 w-[70%] p-4">
                  <div class="flex flex-col gap-2">
                    <p class="font-semibold">Nom</p>
                    <p class="break-words">{{ travel.user.surname }}, {{ travel.user.name }}</p>
                  </div>
                  <div class="flex flex-col gap-2">
                    <p class="font-semibold">Correu</p>
                    <p class="break-words">{{ travel.user.email }}</p>
                  </div>
                  <div class="flex flex-col gap-2">
                    <p class="font-semibold">Destí</p>
                    <p class="break-words">{{ travel.country.name }}</p>
                  </div>
                  <div class="flex flex-col gap-2">
                    <p class="font-semibold">Data</p>
                    <p class="break-words">
                      <!-- {{ travel.date_init }} fins a {{ travel.date_end }} -->
                      {{ new Date(travel.date_init).toLocaleDateString('es-ES') }} fins a
                      {{ new Date(travel.date_end).toLocaleDateString('es-ES') }}
                    </p>
                  </div>
                  <div class="flex flex-col gap-2">
                    <p class="font-semibold">Quantitat dies</p>
                    <p class="break-words">{{ travel.qunt_date }}</p>
                  </div>
                  <div class="flex flex-col gap-2">
                    <p class="font-semibold">Mobilitat</p>
                    <p class="break-words">{{ travel.movility.type }}</p>
                  </div>
                  <div class="flex flex-col gap-2">
                    <p class="font-semibold">Pressupost min</p>
                    <p class="break-words">{{ travel.budget.min_budget }}€</p>
                  </div>
                  <div class="flex flex-col gap-2">
                    <p class="font-semibold">Pressupost max</p>
                    <p class="break-words">{{ travel.budget.max_budget }}€</p>
                  </div>
                  <!-- <div class="flex flex-col gap-2">
                    <p class="font-semibold">Preu final</p>
                    <p class="break-words">{{ travel.budget.final_price }}€</p>
                  </div> -->
                </div>
                <div class="description-trip relative p-4 w-[30%]">
                  <div class="flex flex-col gap-2">
                    <p class="font-semibold">Descripció</p>
                    <p class="break-words">{{ travel.description }}</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="absolute bottom-[1vh] w-full flex justify-around px-2.5">
              <div
                class="flex h-[30px] w-[90px] bg-[#222] [box-shadow:inset_0_1px_0_#FFB300,inset_-2px_0_0_#FFB300,inset_-4px_0_0_#222,inset_-5px_0_0_#FFB300,inset_-6px_0_0_#222,inset_-9px_0_0_#FFB300,inset_-12px_0_0_#222,...]">
              </div>
              <p class="flex relative font-mono text-sm text-gray-100 font-bold top-2">
                DATA DE CREACIÓ: {{ travel.created_at }}
              </p>
              <div
                class="flex h-[30px] w-[90px] bg-[#222] [box-shadow:inset_0_1px_0_#FFB300,inset_-2px_0_0_#FFB300,inset_-4px_0_0_#222,...]">
              </div>
              <div
                class="flex h-[30px] w-[90px] bg-[#222] [box-shadow:inset_0_1px_0_#FFB300,inset_-2px_0_0_#FFB300,inset_-4px_0_0_#222,...]">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useTripDetails } from '~/composable/useTripDetails';

const tripDetails = useTripDetails();



</script>

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

.ticket:after {
  content: '';
  position: absolute;
  right: 22vw;
  top: 0px;
  width: 3px;
  height: 100%;
  box-shadow: inset 0 0 0 #FFB300,
    inset 0 -10px 0 #999999,
    inset 0 -20px 0 #E5E5E5,
    inset 0 -30px 0 #999999,
    inset 0 -40px 0 #E5E5E5,
    inset 0 -50px 0 #999999,
    inset 0 -60px 0 #E5E5E5,
    inset 0 -70px 0 #999999,
    inset 0 -80px 0 #E5E5E5,
    inset 0 -90px 0 #999999,
    inset 0 -100px 0 #E5E5E5,
    inset 0 -110px 0 #999999,
    inset 0 -120px 0 #E5E5E5,
    inset 0 -130px 0 #999999,
    inset 0 -140px 0 #E5E5E5,
    inset 0 -150px 0 #B0B0B0,
    inset 0 -160px 0 #EEEEEE,
    inset 0 -170px 0 #B0B0B0,
    inset 0 -180px 0 #EEEEEE,
    inset 0 -190px 0 #B0B0B0,
    inset 0 -200px 0 #EEEEEE,
    inset 0 -210px 0 #B0B0B0,
    inset 0 -220px 0 #EEEEEE,
    inset 0 -230px 0 #B0B0B0,
    inset 0 -240px 0 #EEEEEE,
    inset 0 -250px 0 #B0B0B0,
    inset 0 -260px 0 #EEEEEE,
    inset 0 -270px 0 #B0B0B0,
    inset 0 -280px 0 #EEEEEE,
    inset 0 -290px 0 #B0B0B0,
    inset 0 -300px 0 #EEEEEE,
    inset 0 -310px 0 #B0B0B0,
    inset 0 -320px 0 #EEEEEE,
    inset 0 -330px 0 #B0B0B0,
    inset 0 -340px 0 #EEEEEE,
    inset 0 -350px 0 #B0B0B0,
    inset 0 -360px 0 #EEEEEE,
    inset 0 -370px 0 #B0B0B0,
    inset 0 -380px 0 #EEEEEE,
    inset 0 -390px 0 #B0B0B0,
    inset 0 -400px 0 #EEEEEE,
    inset 0 -410px 0 #B0B0B0,
    inset 0 -420px 0 #EEEEEE,
    inset 0 -430px 0 #B0B0B0,
    inset 0 -440px 0 #EEEEEE,
    inset 0 -450px 0 #B0B0B0;
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
  top: 3vh;
  left: 1vw;
  display: flex;
  justify-content: space-between;
  padding: 0 1vw;
  gap: 1vw;
}

.flight-info-right {
  position: absolute;
  top: 4vh;
  right: 6vw;
  display: flex;
  justify-content: space-between;
  padding: 0 1vw;
  gap: 1vw;
}
</style>