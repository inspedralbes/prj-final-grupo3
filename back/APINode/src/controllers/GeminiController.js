import { GeminiModel } from "../models/GeminiModel.js";
export class GeminiController {
  static async getGeminiResponse(req, res) {
    const { text } = req.body;
    try {
      const response = await GeminiModel.getResponse(text);
      res.status(200).json(response);
    } catch (error) {
      console.error(error);
      res.status(500).json({ error: "Error en la solicitud" });
    }
  }
} 