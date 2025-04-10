import { Router } from "express";
import { GeminiController } from "../controllers/GeminiController.js";

const router = Router();

router.post("/response", GeminiController.getGeminiResponse);

export default router;