import { CONFIG } from "../config/config.js";
export class GeminiModel {
    static async getResponse(text) {
        try {
            const response = await fetch(`https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${CONFIG.API_KEY}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    contents: [{ parts: [{ text }] }]
                })
            });
            const data = await response.json();
            return data;
        } catch (error) {
            console.error(error);
            throw new Error("Error en la solicitud");
        }
    }
}