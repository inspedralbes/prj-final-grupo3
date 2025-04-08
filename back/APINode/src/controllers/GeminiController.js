import { GeminiModel } from "../models/GeminiModel";
export class GeminiController {
    static async getGeminiResponse(req, res) {
      try {
        const response = await GeminiModel.getResponse(req.body.text);
        res.status(200).json(response);
      } catch (error) {
        console.error(error);
        res.status(500).json({ error: "Error en la solicitud" });
      }
    }
  } 