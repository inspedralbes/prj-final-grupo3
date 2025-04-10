import dotenv from 'dotenv';
dotenv.config();

export const CONFIG = {
  PORT: process.env.PORT || 3006,
  CORS_ORIGIN: process.env.CORS_ORIGIN || 'http://localhost:3000',
  API_KEY: process.env.API_KEY
};