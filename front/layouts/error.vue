<template>
    <div class="w-full p-4 px-8 flex flex-row min-h-screen items-center">
        <div class="h-full">
            <img src="../assets/images/plane-radar.png" alt="" class="h-full" title="Plane Radar">
        </div>
        <div class="flex-1 h-full p-4 flex flex-col gap-4">
            <div>
                <!-- <p class="text-4xl font-semibold font-['Arial'] text-gray-700">404</p> -->
                <p class="text-8xl font-bold font-['Arial'] text-[#dc4028]">Oops!</p>
                <p class="text-2xl font-bold font-['Arial'] text-[#dc4028]">La pàgina que busques no existeix.</p>
                <p class="text-md text-gray-500">Hem buscat per tot arreu, però sembla que la pàgina que estàs intentant
                    visitar no existeix, ha estat eliminada o l’enllaç és incorrecte. 
                    És possible que hagis escrit malament l’adreça o que el contingut s’hagi mogut recentment.
                </p>
            </div>
            <div class="text-gray-500 text-md">
                <p class="text-lg text-gray-600 font-semibold">Però no et preocupis, aquí tens algunes opcions:</p>
                <p> ⬅ Tornar a la pàgina principal</p>
                <p> ✅ Comprovar si has escrit la URL correctament</p>
                <p> 🕵🏽‍♂️ Utilitzar el menú de navegació per trobar el que busques</p>
                <p> ❌ Si creus que es tracta d’un error, no dubtis a contactar amb nosaltres</p>
            </div>
            <p class="text-gray-500 text-lg font-semibold"> Gràcies per la teva comprensió i paciència. Esperem poder
                ajudar-te a trobar el que necessites!</p>
            <div class="flex items-center gap-4">
                <a href="/"
                    class="font-bold text-[#2d57a8] p-2 px-3 border-4 border-[#2d57a8] hover:bg-[#2d57a8] hover:text-white rounded transition duration-200 ease-in-out">
                    Torna a la pàgina principal</a>
                <p class="cursor-pointer border-b text-gray-500 italic">triplan.cat</p>
            </div>
        </div>
    </div>
</template>

<script setup>
// const props = defineProps({
//     error: {
//         type: Object,
//         default: () => ({
//             statusCode: 404,
//             message: 'Page Not Found'
//         })
//     }
// })
// console.log(props)
</script>
