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
import { ref, onMounted } from 'vue';
import { useAIGeminiStore } from "~/store/aiGeminiStore";

const aiGeminiStore = useAIGeminiStore();

const mapContainer = ref(null);
const mapLoaded = ref(false);
let map = null;

const props = defineProps({
  diaIndex: {
    type: Number,
    required: true
  },
  show: {
    type: Boolean,
    default: true
  },
});

function cleanJsonText(jsonText) {
  if (!jsonText) return null;

  // Eliminar marcadores de bloque de código
  let cleanText = jsonText;

  // Eliminar ```json al inicio
  cleanText = cleanText.replace(/^\s*```json\s*/g, '');

  // Eliminar ``` al final
  cleanText = cleanText.replace(/\s*```\s*$/g, '');

  // Eliminar cualquier ``` restante
  cleanText = cleanText.replace(/```/g, '');

  // Eliminar espacios en blanco al principio y final
  cleanText = cleanText.trim();

  // Asegurarse de que el texto comienza con { y termina con }
  if (!cleanText.startsWith('{') || !cleanText.endsWith('}')) {
    // Intentar encontrar el objeto JSON dentro del texto
    const match = cleanText.match(/\{[\s\S]*\}/);
    if (match) {
      cleanText = match[0];
    }
  }

  return cleanText;
}

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

    // Obtener datos de coordenadas del store
    const jsonText = cleanJsonText(aiGeminiStore.responseText);
    const coords = jsonText ? JSON.parse(jsonText).viatge.coordenades : null;

    if (coords) {
    } else {
      console.error("No se pudieron obtener las coordenadas. Texto original:", aiGeminiStore.responseText);
    }

    // Crear el mapa centrado en el punto medio aproximado
    const map = L.map(mapContainer.value).setView([coords.centre_mapa.coords[0], coords.centre_mapa.coords[1]], coords.nivel_zoom);

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

    // MODIFICADO: Filtrar para mostrar solo la ruta del día seleccionado
    const rutaDia = coords.rutes_per_dia.find(ruta => ruta.dia_index === props.diaIndex);

    if (rutaDia) {
      // Crear bounds para ajustar la vista
      const bounds = L.latLngBounds();

      // Añadir marcadores para los lugares de este día específico, respetando orden_visita
      const markers = [];

      rutaDia.orden_visita.forEach(id => {
        const spot = rutaDia.llocs.find(lugar => lugar.id === id);
        if (spot) {
          // Añadir marcador
          const marker = L.marker([spot.coords[0], spot.coords[1]], {
            icon: createCustomIcon(rutaDia.color)
          }).addTo(map);

          // Configurar popup
          let googleMapsUrl = spot.google_maps_url || `https://www.google.com/maps?q=${spot.coords[0]},${spot.coords[1]}`;

          marker.bindPopup(`
                <div class="font-bold">${spot.nom}</div>
                <div>${spot.descripcio}</div>
                <div>
                  <a href="${googleMapsUrl}" target="_blank" class="text-blue-500 underline">Veure més.</a>
                </div>
              `);

          // Añadir al bounds
          bounds.extend([spot.coords[0], spot.coords[1]]);

          markers.push(marker);
        }
      });

      // Crear la línea que conecte los puntos (la ruta)
      const routePoints = rutaDia.orden_visita.map(id => {
        const spot = rutaDia.llocs.find(lugar => lugar.id === id);
        return spot ? [spot.coords[0], spot.coords[1]] : null;
      }).filter(point => point !== null);

      if (routePoints.length > 1) {
        // Crear y añadir la ruta al mapa
        const route = L.polyline(routePoints, {
          color: rutaDia.color || '#3B82F6',
          weight: 4,
          opacity: 0.7,
          dashArray: '10, 10',
          lineCap: 'round'
        }).addTo(map);

        // Ajustar el mapa para mostrar todos los puntos
        map.fitBounds(bounds, { padding: [30, 30] });

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

        // Iniciar animación
        animateRoute();
      }
    }

    // Mostrar el mapa
    setTimeout(() => {
      map.invalidateSize();
      mapLoaded.value = true;
    }, 200);

  } catch (error) {
    console.error('Error loading map:', error);
  }
}

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