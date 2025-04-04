<?php

return [
  'paths' => ['api/*', 'auth/*',], // Definir las rutas a las que se aplica CORS
  'allowed_methods' => ['*'], // Métodos permitidos
  'allowed_origins' => ['http://localhost:3000'], // Orígenes permitidos (puedes restringirlo si es necesario)
  'allowed_origins_patterns' => [],
  'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization'], // Encabezados permitidos
  'exposed_headers' => [],
  'max_age' => 0,
  'supports_credentials' => true,
];