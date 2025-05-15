// server/api/gemini.js
export default defineEventHandler(async (event) => {
  const { text } = await readBody(event);  // Usa readBody en lugar de useBody

  const GEMINI_API_KEY = 'AIzaSyCV945dJTTupmcS0Tmu2QC9eqDbR4Wn1og';  // La teva clau API

  try {
    // Crida a l'API de Gemini
    const response = await $fetch("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" + GEMINI_API_KEY, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        contents: [{ parts: [{ text }] }]
      })
    });

    console.log('Resposta de Gemini:', response);  // Log de la resposta

    return response;  // Retorna la resposta de Gemini al frontend
  } catch (error) {
    console.error('Error en cridar Gemini:', error.response?.data || error.message);  // Log del missatge d'error
    throw createError({ statusCode: 500, message: 'Error en cridar Gemini' });
  }
});