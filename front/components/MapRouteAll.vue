<template>
  <Transition name="map-fade" @enter="onEnter" @leave="onLeave">
    <div v-if="show" class="map-container">
      <div v-if="!mapLoaded" class="absolute inset-0 z-10">
        <!-- Skeleton header -->
        <div class="h-12 bg-gray-200 px-4 flex items-center justify-between">
          <div class="flex space-x-2">
            <div class="w-8 h-8 bg-gray-300 rounded"></div>
            <div class="w-8 h-8 bg-gray-300 rounded"></div>
          </div>
          <div class="w-48 h-8 bg-gray-300 rounded"></div>
        </div>

        <!-- Skeleton map content with pulse animation -->
        <div class="flex items-center justify-center h-[calc(100%-6rem)] bg-gray-200 animate-pulse">
          <div class="w-12 h-12 rounded-full bg-blue-400/50 flex items-center justify-center">
            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
          </div>
        </div>

        <!-- Skeleton footer -->
        <div class="h-12 bg-gray-200 px-4 flex items-center justify-end">
          <div class="w-40 h-6 bg-gray-300 rounded"></div>
        </div>
      </div>

      <div ref="mapContainer" id="map" style="height: 250px; width: 100%"></div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, onMounted, defineProps } from 'vue';
import { useAIGeminiStore } from "~/store/aiGeminiStore";

// Añadir prop para controlar si el mapa está visible
const props = defineProps({
  show: {
    type: Boolean,
    default: true
  }
});

const aiGeminiStore = useAIGeminiStore();

// console.log(JSON.parse(aiGeminiStore.responseText).viatge.coordenades);

const coords = JSON.parse(aiGeminiStore.responseText).viatge.coordenades
console.log(coords.centre_mapa);

coords.rutes_per_dia.map(daily_route => {
  console.log(daily_route);
});

const mapContainer = ref(null);
const mapLoaded = ref(false);
let map = null; // Variable para mantener referencia al mapa

// Función para inicializar el mapa
const initMap = async () => {
  if (!mapContainer.value || !process.client) return;

  try {
    // Importar Leaflet solo del lado del cliente
    const L = await import('leaflet');

    // Corregir el problema con los marcadores
    delete L.Icon.Default.prototype._getIconUrl;
    L.Icon.Default.mergeOptions({
      iconRetinaUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon-2x.png',
      iconUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon.png',
      shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png',
    });

    // Crear el mapa centrado en el punto medio aproximado
    map = L.map(mapContainer.value).setView([coords.centre_mapa.coords[0], coords.centre_mapa.coords[1]], coords.nivel_zoom);

    // Añadir la capa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      maxZoom: 19,
    }).addTo(map);

    // Crear iconos personalizados para cada punto
    const createCustomIcon = (color) => {
      return L.divIcon({
        className: 'custom-marker-icon',
        html: `<div style="background-color: ${color}; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.3);"></div>`,
        iconSize: [20, 20],
        iconAnchor: [10, 10],
        popupAnchor: [0, -10]
      });
    };

    // Añadir marcadores para cada punto de interés
    const markers = coords.rutes_per_dia.map(daily_route => {
      // console.log(daily_route.llocs.map(spot => spot.coords));
      const marker = daily_route.llocs.map(spot => {
        console.log(spot);
        const markerSpot = L.marker([spot.coords[0], spot.coords[1]], {
          icon: createCustomIcon(daily_route.color)
        }).addTo(map);

        let googleMapsUrl = spot.google_maps_url || `https://www.google.com/maps?q=${spot.coords[0]},${spot.coords[1]}`;

        markerSpot.bindPopup(`
          <div class="font-bold">${spot.nom}</div>
          <div>${spot.descripcio}</div>
          <div>
            <a href="${googleMapsUrl}" target="_blank" class="text-blue-500 underline">Veure més.</a>
        `);
        return markerSpot;
      })
      return marker;
    });

    // Crear una línea que conecte los puntos (la ruta)
    const routeCoordinates = coords.rutes_per_dia.map(daily_route => {
      return daily_route.llocs.map(spot => [spot.coords[0], spot.coords[1]]);
    });

    // Crear y añadir la ruta al mapa
    const route = L.polyline(routeCoordinates, {
      color: '#3B82F6', // Azul
      weight: 4,
      opacity: 0.7,
      dashArray: '10, 10', // Línea punteada
      lineCap: 'round'
    }).addTo(map);

    // Animar la ruta
    const animateRoute = () => {
      let dashOffsetValue = 0;
      const animationInterval = setInterval(() => {
        dashOffsetValue -= 1;
        const routeElement = document.querySelector('.leaflet-overlay-pane path');
        if (routeElement) {
          routeElement.style.strokeDashoffset = dashOffsetValue;
        } else {
          clearInterval(animationInterval);
        }
      }, 50);
    };

    // Ajustar el mapa para que se vean todos los puntos
    map.fitBounds(route.getBounds(), { padding: [50, 50] });

    // Mostrar el mapa y animar la ruta
    setTimeout(() => {
      if (map) {
        map.invalidateSize();
        mapLoaded.value = true;
        animateRoute();
      }
    }, 200);

  } catch (error) {
    console.error('Error loading map:', error);
  }
};

// Hooks de los eventos de transición
const onEnter = (el) => {
  // Inicializar el mapa cuando comienza la animación de entrada
  setTimeout(initMap, 100);
};

const onLeave = (el) => {
  // Limpiar mapa cuando comienza la animación de salida
  if (map) {
    setTimeout(() => {
      map.remove();
      map = null;
      mapLoaded.value = false;
    }, 100);
  }
};

onMounted(() => {
  if (props.show) {
    // Simular pequeño retraso para mostrar el skeleton
    setTimeout(initMap, 500);
  }
});
</script>

<style>
@import 'leaflet/dist/leaflet.css';

.map-container {
  width: 100%;
  height: 250px;
  position: relative;
  margin: 0;
  padding: 0;
  overflow: hidden;
}

/* Animaciones para la transición */
.map-fade-enter-active,
.map-fade-leave-active {
  transition: all 0.5s ease;
  max-height: 250px;
  opacity: 1;
  transform: translateY(0);
}

.map-fade-enter-from,
.map-fade-leave-to {
  max-height: 0;
  opacity: 0;
  transform: translateY(-10px);
}
</style>