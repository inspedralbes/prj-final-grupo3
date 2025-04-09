import { CONFIG } from "../config/config.js";
export class GeminiModel {
    static async getResponse(text) {
        console.log('text', text);
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
            if (
                data &&
                data.candidates &&
                data.candidates[0]?.content?.parts[0]?.text
              ) {
                console.log('json', data.candidates[0].content.parts[0].text);
                data = data.candidates[0].content.parts[0].text;
              }
              console.log('data', data);
            return data;
        } catch (error) {
            console.error(error);
            throw new Error("Error en la solicitud");
        }
    }
}