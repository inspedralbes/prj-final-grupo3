import express from 'express';
import cors from 'cors';
import { corsOptions, dynamicCors, corsErrorHandler } from './src/config/cors.js';
import { CONFIG } from "./src/config/config.js";
import geminiRoutes from './src/routes/geminiRoutes.js';


const app = express();

app.use(express.json());
app.use(cors(corsOptions));
app.disable('x-powered-by');

const PORT = CONFIG.PORT || 3006;

app.get("/", (req, res) => {
  res.send("Hello from Node.js!");
});

app.use("/api/gemini", geminiRoutes);

app.listen(PORT, () => {
  console.log(`Servidor escuchando en el puerto ${PORT}`);
});

