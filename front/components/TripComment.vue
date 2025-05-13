<template>
  <div class="mt-10 border-t pt-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">
      Comentaris dels usuaris
    </h2>

    <!-- Skeleton -->
    <div v-if="loading">
      <div v-for="n in 3" :key="n" class="mb-6 animate-pulse flex space-x-4">
        <div class="w-12 h-12 bg-gray-300 rounded-full"></div>
        <div class="flex-1 space-y-3 py-1">
          <div class="h-4 bg-gray-300 rounded w-1/3"></div>
          <div class="h-4 bg-gray-200 rounded w-5/6"></div>
          <div class="h-3 bg-gray-100 rounded w-1/4"></div>
        </div>
      </div>
    </div>

    <!-- Comentaris -->
    <transition-group name="fade" tag="div" v-else-if="comments.length" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div v-for="comment in comments" :key="comment.id" class="p-4 bg-white rounded-lg shadow flex space-x-4">
        <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-bold uppercase">
          {{ comment.user?.name?.charAt(0) || 'U' }}
        </div>
        <div class="flex-1">
          <p class="font-semibold text-gray-800 mb-1 text-sm">
            {{ comment.user?.name || 'Usuari' }}
            <span v-if="authStore.user && comment.user?.id === authStore.user.id" class="ml-2 text-blue-500 text-xs"></span>
          </p>
          <div class="flex items-center mb-1">
            <span v-for="n in 5" :key="n" class="text-sm mr-0.5">
              <span :class="n <= comment.rating ? 'text-yellow-400' : 'text-gray-200'">★</span>
            </span>
          </div>
          <div class="flex justify-between items-center mt-2">
            <p class="text-xs text-gray-400">{{ formatDate(comment.created_at) }}</p>

            <!-- Botó eliminar -->
            <button v-if="authStore.user && comment.user?.id === authStore.user.id"
              @click="handleDelete(comment.id)"
              class="text-red-500 hover:text-red-700 text-xs ml-2"
              title="Eliminar comentari"
              :disabled="deletingCommentId === comment.id">
              <span v-if="deletingCommentId === comment.id">Eliminant...</span>
              <span v-else>🗑️ Elimina</span>
            </button>
          </div>

          <!-- Botó de Like toggle -->
          <div v-if="authStore.user && comment.user?.id !== authStore.user.id" class="flex items-center gap-1 text-xs ml-2">
            <button
              @click="handleLike(comment.id)"
              :disabled="likingCommentId === comment.id"
              :class="[
                'text-sm transition',
                hasLiked(comment) ? 'text-pink-600 hover:text-pink-700' : 'text-gray-400 hover:text-pink-500'
              ]"
              title="Like / Unlike"
            >
              <span v-if="likingCommentId === comment.id">💬...</span>
              <span v-else>{{ hasLiked(comment) ? '💖' : '🤍' }}</span>
            </button>
            <span class="text-gray-500 text-xs">{{ comment.likes?.length || 0 }}</span>
          </div>

          <p class="text-gray-700 text-sm mt-2">{{ comment.text }}</p>
        </div>
      </div>
    </transition-group>

    <!-- Cap comentari -->
    <div v-else class="text-gray-500 italic">Encara no hi ha comentaris.</div>

    <!-- Formulari -->
    <div class="mt-8 bg-gray-50 p-6 rounded-xl shadow-inner">
      <div v-if="isLoggedIn">
        <!-- Textarea -->
        <textarea v-model="newComment" rows="3"
          class="w-full border border-gray-300 rounded-md p-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400"
          placeholder="Escriu el teu comentari..."></textarea>

        <!-- Selecció d'estrelles -->
        <div class="flex items-center space-x-1 mt-3">
          <span class="text-sm text-gray-700">Valoració:</span>
          <template v-for="n in 5" :key="n">
            <button type="button" @click="rating = n" class="text-xl focus:outline-none">
              <span :class="n <= rating ? 'text-yellow-400' : 'text-gray-300'">★</span>
            </button>
          </template>
        </div>

        <!-- Botó d'enviament -->
        <button @click="submitComment"
          class="mt-4 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition"
          :disabled="sending">
          {{ sending ? "Enviant..." : "Envia" }}
        </button>

        <!-- Missatge d'èxit -->
        <p v-if="successMessage" class="text-green-600 mt-2">
          {{ successMessage }}
        </p>
      </div>

      <div v-else class="text-gray-600">
        <NuxtLink to="/login" class="text-blue-500 underline">Inicia sessió</NuxtLink>
        per escriure un comentari.
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useAuthStore } from "@/store/authUser";
import {
  fetchCommentsForTrip,
  postComment,
  deleteComment,
  likeComment
} from "~/services/communicationManager";
import Swal from 'sweetalert2'


const props = defineProps({ tripId: Number });
const authStore = useAuthStore();
const isLoggedIn = !!authStore.token;

const comments = ref([]);
const newComment = ref("");
const loading = ref(true);
const sending = ref(false);
const successMessage = ref("");
const rating = ref(null);
const deletingCommentId = ref(null);
const likingCommentId = ref(null);

const hasLiked = (comment) => {
  return authStore.user && comment.likes?.some((like) => like.user_id === authStore.user.id);
};

const handleLike = async (commentId) => {
  likingCommentId.value = commentId;
  try {
    await likeComment(commentId, authStore.token);
    await loadComments();
  } catch (err) {
    console.error("Error fent like:", err);
  } finally {
    likingCommentId.value = null;
  }
};

const handleDelete = async (commentId) => {
  const result = await Swal.fire({
    title: 'Estàs segur?',
    text: 'Aquesta acció eliminarà el comentari definitivament.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#e53e3e',
    cancelButtonColor: '#718096',
    confirmButtonText: 'Sí, elimina-ho!',
    cancelButtonText: 'Cancel·la',
  });

  if (!result.isConfirmed) return;

  deletingCommentId.value = commentId;

  try {
    await deleteComment(commentId, authStore.token);
    await loadComments();
    Swal.fire('Eliminat!', 'El teu comentari ha estat eliminat.', 'success');
  } catch (err) {
    console.error('Error eliminant comentari:', err);
    Swal.fire('Error!', 'No s\'ha pogut eliminar el comentari.', 'error');
  } finally {
    deletingCommentId.value = null;
  }
};

const formatDate = (isoString) => {
  return new Date(isoString).toLocaleString("ca-ES", {
    day: "numeric",
    month: "long",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  });
};

const loadComments = async () => {
  try {
    loading.value = true;
    const data = await fetchCommentsForTrip(props.tripId);
    comments.value = data;
  } catch (error) {
    console.error("Error carregant comentaris:", error);
  } finally {
    loading.value = false;
  }
};

const submitComment = async () => {
  if (!newComment.value.trim()) return;
  try {
    sending.value = true;
    await postComment(props.tripId, newComment.value, authStore.token, rating.value);
    newComment.value = "";
    rating.value = null;
    successMessage.value = "Comentari afegit correctament!";
    setTimeout(() => (successMessage.value = ""), 3000);
    await loadComments();
  } catch (err) {
    console.error("Error enviant comentari:", err);
  } finally {
    sending.value = false;
  }
};

onMounted(loadComments);
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(10px);
}
</style>
