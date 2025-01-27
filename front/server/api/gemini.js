// server/api/gemini.js
export default defineEventHandler(async (event) => {
    const { text } = await useBody(event);  // Obtenim el text de la petició
  
    console.log('Rebent la petició:', text);  // Afegeix un log per veure el text rebut
  
    const GEMINI_API_KEY = 'AIzaSyACPzTa479Ejd-BSdEQtMluWYV_itlvNUI';  // La teva clau API
  
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
  
      console.log('Resposta de Gemini:', response);  // Afegeix un log per veure la resposta
  
      return response;  // Retorna la resposta de Gemini al frontend
    } catch (error) {
      console.error('Error en cridar Gemini:', error);  // Log del missatge d'error
      throw createError({ statusCode: 500, message: 'Error en cridar Gemini' });
    }
  });
  