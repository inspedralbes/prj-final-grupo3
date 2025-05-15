import { CONFIG } from "../config/config.js";
import { PexelsService } from "./PexelsService.js";

export class GeminiModel {
  static async getResponse(text) {
    try {
      const response = await fetch(
        `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${CONFIG.API_KEY}`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            contents: [{ parts: [{ text }] }],
          }),
        }
      );

      const data = await response.json();

      let responseText = "";
      if (
        data &&
        data.candidates &&
        data.candidates[0]?.content?.parts[0]?.text
      ) {
        responseText = data.candidates[0].content.parts[0].text;

        responseText = responseText.trim();
        if (responseText.startsWith("```")) {
          responseText = responseText.replace(/^```(?:json)?/, "").replace(/```$/, "").trim();
        }
      }

      try {
        const tripData = JSON.parse(responseText);

        if (
          tripData.viatge &&
          tripData.viatge.dies &&
          Array.isArray(tripData.viatge.dies) &&
          tripData.viatge.dies.length > 0
        ) {
          for (const dia of tripData.viatge.dies) {
            const searchQuery = dia.paraulaClau;

            const imageUrl = await PexelsService.getImageByQuery(searchQuery);

            if (imageUrl) {
              dia.imatgeUrl = imageUrl;
            } else {
            }
          }
        } else {
          console.warn("El JSON recibido no contiene 'viatge.dies' o está vacío.");
        }

        return JSON.stringify(tripData);
      } catch (error) {
        console.error("Error procesando el JSON o añadiendo imágenes:", error);
        console.error("Contenido de responseText:", responseText);
        return responseText;
      }

    } catch (error) {
      console.error(error);
      throw new Error("Error en la solicitud");
    }
  }
}