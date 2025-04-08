import { Router } from "express";
import { GeminiController } from "../controllers/GeminiController";

const router = Router();

router.get("/response", GeminiController.getGeminiResponse);

export default router;