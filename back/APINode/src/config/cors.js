import { CONFIG } from "./config.js";

export const corsOptions = {
    origin: CONFIG.CORS_ORIGIN || ['http://localhost:3000'],
    methods: ['GET', 'POST', 'PUT', 'DELETE','PATCH'],
    allowedHeaders: ['Content-Type', 'Authorization'],
    exposedHeaders: ['Content-Range', 'X-Content-Range'],
    credentials: true,
    maxAge: 86400,
    preflightContinue: false,
    optionsSuccessStatus: 204,
  };

export const dynamicCors = (req, callback) => {
    const options = {
      origin: (origin, cb) => {
        const whitelist = corsOptions.origin;
        
        if (whitelist.indexOf(origin) !== -1 || !origin) {
          cb(null, true);
        } else {
          cb(new Error('No permitido por CORS'));
        }
      },
      methods: corsOptions.methods,
      credentials: corsOptions.credentials,
      maxAge: corsOptions.maxAge
    };
    callback(null, options);
  };
  
export const corsErrorHandler = (err, req, res, next) => {
    if (err.message === 'No permitido por CORS') {
      res.status(403).json({
        error: 'No tienes permiso para acceder a este recurso'
      });
    } else {
      next(err);
    }
  };

  