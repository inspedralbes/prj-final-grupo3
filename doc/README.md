# Documentació del Projecte

## Arquitectura Bàsica

- **Back-end (servidor Laravel)**: Utilitzem Laravel com a API per gestionar la comunicació amb una base de dades. Aquesta API
  és responsable de servir tota la informació que necessita el front-end, així com de gestionar operacions com la
  creació, lectura, actualització i eliminació de dades (CRUD).

- **Back-end (servidor Node.js)**: Disposem d'un servidor Node.js dedicat específicament a realitzar les peticions a l'API de Gemini, processar les respostes i integrar-les amb altres serveis, com ara la cerca d'imatges a través de Pexels. Aquest servidor actua com una capa intermèdia que optimitza i enriqueix les dades obtingudes del model d'IA.

- **Front-end (client)**: Utilitzem el framework de Nuxt per gestionar la interfície d'usuari. Nuxt s'encarrega de la part interactiva i
  visual de l'aplicació, proporcionant una experiència d'usuari dinàmica i reactiva.

- **Part d'Administració**: Laravel també s'utilitza per a la part d'administració, on es permet als usuaris gestionar
  el CRUD dels productes (afegir, editar, eliminar i visualitzar productes) a través d'una interfície.

## Tecnologies

- **Nuxt**: Framework JavaScript per crear interfícies d'usuari reactives i components reutilitzables.
- **Laravel 11**: Framework PHP que facilita el desenvolupament d'aplicacions web robustes, amb una sintaxi elegant i
  orientada a objectes.
- **Node.js**: Entorn d'execució per JavaScript al servidor, utilitzat per gestionar les peticions a l'API de Gemini i processar les dades rebudes.
- **Express**: Framework web per Node.js que permet crear API RESTful de manera ràpida i senzilla.
- **JavaScript**: Llenguatge de programació utilitzat per afegir interactivitat i comportament a l'aplicació tant al front-end com al servidor Node.js.
- **CSS/TailwindCSS**: Utilitzat per estilitzar la interfície d'usuari, millorant la presentació visual de l'aplicació.
- **PHP 8**: Llenguatge de programació utilitzat al back-end de Laravel.
- **HTML**: Llenguatge de marcat per estructurar les pàgines web al front-end.

## APIs i Serveis Externs

- **Gemini API**: Utilitzem l'API de Gemini per a la generació de contingut basat en IA.
- **Pexels API**: Integrada al servidor Node.js per obtenir imatges relacionades amb els plans de viatge generats.

## Plugins i Eines de Desenvolupament

- Per fer proves i verificar que la comunicació amb l'API funcioni correctament quan es realitzen peticions HTTP, hem
  utilitzat:
  - **Thunder Client**: Plugin de VS Code que permet realitzar peticions HTTP des de l'editor.
  - **Postman**: Eina per provar APIs de manera fàcil i visual, permetent enviar peticions HTTP i veure les respostes.

## Com Desplegar l'Aplicació a l'Entorn de Desenvolupament

Segueix aquests passos per configurar i executar l'aplicació en un entorn de desenvolupament:

### Laravel (back/APIlaravel)

1. **Instal·lació de Dependències**:

   - Accedeix al directori back/APIlaravel i executa:
   ```bash
   composer install
   ```
   per instal·lar totes les dependències necessàries per a Laravel.

2. **Configuració de l'Arxiu .env**:
   - Crea una còpia de l'arxiu .env.example i anomena'l .env:
   ```bash
   cp .env.example .env
   ```
   - Dins del .env, defineix les configuracions de la base de dades ajustant les següents línies:

```env
DB_HOST=el_teu_host
DB_PORT=el_teu_port
DB_DATABASE=el_nom_de_la_teva_base_de_dades
DB_USERNAME=el_teu_usuari
DB_PASSWORD=la_teva_contrassenya
```

- Substitueix els valors pels corresponents del teu entorn.

3. **Iniciar el Servei del Servidor de Base de Dades**:

   - Assegura't que el servei de la base de dades (per exemple, MySQL o MariaDB) estigui en funcionament i crea la base
     de dades especificada al fitxer .env.

4. **Migracions, Generació de Clau i Inserció de Dades**:

   - Per configurar les taules a la base de dades i generar la clau de l'aplicació:
     ```bash
     php artisan key:generate
     php artisan migrate:fresh
     ```
     
     Si necessites reiniciar les migracions, pots utilitzar:
     ```bash
     php artisan migrate:rollback
     ```
     o
     ```bash
     php artisan migrate:reset
     ```

5. **Neteja de Caché**:

   - Per evitar problemes de configuració i garantir que es carreguin els últims canvis:
     ```bash
     php artisan config:clear
     php artisan view:clear
     php artisan cache:clear
     ```

6. **Iniciar el Servidor de Laravel**:
   - Per executar l'aplicació:
   ```bash
   php artisan serve
   ```
   - Aquesta comanda iniciarà el servidor de desenvolupament de Laravel, normalment a http://localhost:8000.

### Node.js (back/APINode)

1. **Instal·lació de Dependències**:
   - Accedeix al directori back/APINode i executa:
   ```bash
   npm install
   ```
   per instal·lar totes les dependències necessàries per al servidor Node.js.

2. **Configuració de l'Arxiu .env**:
   - Crea una còpia de l'arxiu .env.example i anomena'l .env:
   ```bash
   cp .env.example .env
   ```
   - Configura les variables d'entorn necessàries:
   ```env
   API_KEY=la_teva_clau_api_gemini
   CORS_ORIGIN=http://localhost:3000
   PORT=3006
   ```
   - És essencial que la API_KEY sigui vàlida per al funcionament de Gemini, i el CORS_ORIGIN ha de correspondre a l'URL del front-end.

3. **Iniciar el Servidor de Node.js**:
   - Per executar el servidor Node.js en mode desenvolupament:
   ```bash
   npm run dev
   ```
   o
   ```bash
   npm start
   ```
   - El servidor s'iniciarà al port especificat al fitxer .env (per defecte, 3006).

### Front-end (Nuxt)

1. **Instal·lació de Dependències**:
   - Accedeix al directori front i executa:
   ```bash
   npm install
   ```

2. **Configuració de l'Arxiu d'Entorn**:
   - Crea una còpia de l'arxiu .env.example i anomena'l .env:
   ```bash
   cp .env.example .env
   ```
   - Configura les variables d'entorn necessàries:
   ```env
   NUXT_PUBLIC_API_BASE_URL=http://localhost:8000/api
   NUXT_PUBLIC_NODE_API_URL=http://localhost:3006/api
   ```
   - Assegura't que aquestes URL corresponen als servidors de Laravel i Node.js.

3. **Iniciar el Servidor de Desenvolupament**:
   - Per executar l'aplicació Nuxt:
   ```bash
   npm run dev
   ```
   - El servidor de desenvolupament s'iniciarà normalment a http://localhost:3000.

4. **Compilació per a Producció** (quan sigui necessari):
   ```bash
   npm run build
   npm run generate
   ```

### Desplegar amb Docker Compose en desenvolupament

Si prefereixes utilitzar Docker per configurar tot l'entorn, segueix aquests passos:

1. **Instal·lació de Docker i Docker Compose**:

   - Assegura't de tenir Docker i Docker Compose instal·lats al teu sistema. Pots obtenir-los des de:
     - [Docker](https://www.docker.com/get-started)
     - [Docker Compose](https://docs.docker.com/compose/install/)
     - [Docker Desktop](https://www.docker.com/products/docker-desktop) (per a Windows i Mac)

2. **Configuració dels fitxers .env**:

   - Configura els fitxers .env per a cada component (Laravel, Node.js i Nuxt) seguint els passos anteriors.
   - Per a la base de dades en Docker, utilitza:
   ```env
   DB_HOST=db
   DB_PORT=3306
   DB_DATABASE=el_nom_de_la_teva_base_de_dades
   DB_USERNAME=el_teu_usuari
   DB_PASSWORD=la_teva_contrassenya
   ```

3. **Iniciar el projecte amb Docker Compose**:

   - Des del directori arrel del projecte, executa:
   ```bash
   docker-compose up -d
   ```
   - Aquesta comanda iniciarà tots els serveis (Laravel, Node.js, Nuxt i base de dades).

4. **Migracions i configuració inicial**:

   - Un cop els contenidors estiguin en funcionament, executa les migracions de Laravel:
   ```bash
   docker-compose exec app bash
   php artisan migrate
   php artisan key:generate
   ```

5. **Accés a l'aplicació**:

   - Front-end: http://localhost:3000
   - API Laravel: http://localhost:8000/api
   - API Node.js: http://localhost:3006/api

6. **Aturar els serveis**:
   ```bash
   docker-compose down
   ```

# Desplegament a producció de l'aplicació

## 🌐 Desplegar Nuxt en Producció

Seguiu aquests passos per desplegar l'aplicació **Nuxt** en un servidor de producció.

### Preparació

1. **Construir l'Aplicació per a Producció**:

   - Accedeix al directori front:
     ```bash
     cd front
     ```
   - Executa la compilació per a producció:
     ```bash
     npm run build
     npm run generate
     ```
   - Això generarà la carpeta `public/` dintre de `./output` amb tots els arxius estàtics.

2. **Pujar els Fitxers al Servidor**:

   - Puja la carpeta `public/` a la ubicació del servidor on vols desplegar l'aplicació.

3. **Configurar el Servidor Web**:

   #### Configuració amb Nginx (HTTP)

   ```nginx
   server {
       listen 80;
       server_name el_teu_domini.com;

       root /var/www/nuxt/public;
       index index.html;
       location / {
           try_files $uri $uri/ /index.html;
       }
   }
   ```

   #### Configuració amb Nginx (HTTPS)

   1. **Instal·lar Certbot**:
   ```bash
   sudo apt update
   sudo apt install certbot python3-certbot-nginx -y
   ```

   2. **Generar certificat**:
   ```bash
   sudo certbot --nginx -d el_teu_domini.com -d www.el_teu_domini.com
   ```

   3. **Configuració HTTPS**:
   ```nginx
   server {
      listen 80;
      listen [::]:80;
      server_name el_teu_domini.com www.el_teu_domini.com;

      # Redirecció a HTTPS
      return 301 https://$host$request_uri;
   }

   server {
      listen 443 ssl;
      server_name el_teu_domini.com www.el_teu_domini.com;

      ssl_certificate /etc/letsencrypt/live/el_teu_domini.com/fullchain.pem;
      ssl_certificate_key /etc/letsencrypt/live/el_teu_domini.com/privkey.pem;
      include /etc/letsencrypt/options-ssl-nginx.conf;
      ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem;

      # Directori de Nuxt.js (Frontend)
      root /var/www/html;
      index index.html;

      # Bloquejar l'accés arxius ocults
      location ~ /\.ht {
        deny all;
      }

      # Rutes de Nuxt.js
      location / {
        try_files $uri $uri/ /index.html;
      }

      error_log /var/log/nginx/app_error.log;
      access_log /var/log/nginx/app_access.log;
   }
   ```

4. **Activar la configuració i reiniciar Nginx**:
   ```bash
   sudo ln -s /etc/nginx/sites-available/nuxt /etc/nginx/sites-enabled/
   sudo systemctl restart nginx
   ```

## 🌐 Desplegar Laravel en Producció

Seguiu aquests passos per desplegar l'API de **Laravel** en un servidor de producció.

### Preparació i Configuració

1. **Clonar el Repositori**:
   ```bash
   git clone https://url-del-teu-repositori.git
   ```

2. **Configurar el Servidor Web**:

   #### Configuració amb Nginx (API)
   ```nginx
   server {
      listen 80;
      server_name api.el_teu_domini.com;

      root /var/www/laravel/public;
      index index.php;

      location / {
          try_files $uri $uri/ /index.php?$query_string;
      }

      location ~ \.php$ {
          include snippets/fastcgi-php.conf;
          fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
      }

      location ~ /\.ht {
          deny all;
      }

      error_log /var/log/nginx/laravel_error.log;
      access_log /var/log/nginx/laravel_access.log;
   }
   ```

   #### Configuració amb Nginx (HTTPS)
   ```nginx
   server {
      listen 80;
      listen [::]:80;
      server_name api.el_teu_domini.com;

      # Redirecció a HTTPS
      return 301 https://$host$request_uri;
   }

   server {
      listen 443 ssl;
      server_name api.el_teu_domini.com;

      ssl_certificate /etc/letsencrypt/live/api.el_teu_domini.com/fullchain.pem;
      ssl_certificate_key /etc/letsencrypt/live/api.el_teu_domini.com/privkey.pem;
      include /etc/letsencrypt/options-ssl-nginx.conf;
      ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem;

      root /var/www/laravel/public;
      index index.php;

      location / {
          try_files $uri $uri/ /index.php?$query_string;
      }

      location ~ \.php$ {
          include snippets/fastcgi-php.conf;
          fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
      }

      location ~ /\.ht {
          deny all;
      }

      error_log /var/log/nginx/laravel_error.log;
      access_log /var/log/nginx/laravel_access.log;
   }
   ```

3. **Moure els Arxius al Directori de Treball**:
   ```bash
   mv nom-del-repositori /var/www/laravel
   ```

4. **Configurar l'entorn**:
   ```bash
   cd /var/www/laravel
   cp .env.example .env
   composer install --optimize-autoloader --no-dev
   php artisan key:generate
   ```

5. **Configurar la Base de Dades**:
   - Edita el fitxer .env amb les dades de la base de dades de producció.

6. **Configurar Permisos**:
   ```bash
   sudo chown -R www-data:www-data /var/www/laravel
   sudo chmod -R 775 /var/www/laravel/storage /var/www/laravel/bootstrap/cache
   ```

7. **Executar Migracions**:
   ```bash
   php artisan migrate --force
   ```

8. **Optimització per a Producció**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

## 🌐 Desplegar Node.js en Producció

Seguiu aquests passos per desplegar el servidor **Node.js** en un entorn de producció.

### Preparació i Configuració

1. **Clonar el Repositori**:
   ```bash
   git clone https://url-del-teu-repositori.git
   ```

2. **Configurar l'entorn**:
   ```bash
   cd back/APINode
   cp .env.example .env
   # Edita el fitxer .env amb les claus API i configuracions de producció
   npm install --production
   ```

3. **Utilitzar PM2 per Gestionar el Procés**:
   
   PM2 és un gestor de processos per Node.js que permet mantenir l'aplicació en execució contínua.
   
   ```bash
   # Instal·lar PM2 globalment
   npm install -g pm2
   
   # Iniciar l'aplicació amb PM2
   pm2 start app.js --name "api-gemini"
   
   # Configurar PM2 per iniciar-se amb el sistema
   pm2 startup
   pm2 save
   ```

4. **Configurar Nginx com a Proxy Invers**:

   #### Configuració amb Nginx (HTTP)
   ```nginx
   server {
       listen 80;
       server_name api-node.el_teu_domini.com;

       location / {
           proxy_pass http://localhost:3006;
           proxy_http_version 1.1;
           proxy_set_header Upgrade $http_upgrade;
           proxy_set_header Connection 'upgrade';
           proxy_set_header Host $host;
           proxy_cache_bypass $http_upgrade;
       }
       
       error_log /var/log/nginx/node_error.log;
       access_log /var/log/nginx/node_access.log;
   }
   ```

   #### Configuració amb Nginx (HTTPS)
   ```nginx
   server {
       listen 80;
       listen [::]:80;
       server_name api-node.el_teu_domini.com;
       
       # Redirecció a HTTPS
       return 301 https://$host$request_uri;
   }

   server {
       listen 443 ssl;
       server_name api-node.el_teu_domini.com;
       
       ssl_certificate /etc/letsencrypt/live/api-node.el_teu_domini.com/fullchain.pem;
       ssl_certificate_key /etc/letsencrypt/live/api-node.el_teu_domini.com/privkey.pem;
       include /etc/letsencrypt/options-ssl-nginx.conf;
       ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem;
       
       location / {
           proxy_pass http://localhost:3006;
           proxy_http_version 1.1;
           proxy_set_header Upgrade $http_upgrade;
           proxy_set_header Connection 'upgrade';
           proxy_set_header Host $host;
           proxy_cache_bypass $http_upgrade;
       }
       
       error_log /var/log/nginx/node_error.log;
       access_log /var/log/nginx/node_access.log;
   }
   ```

5. **Activar la configuració i reiniciar Nginx**:
   ```bash
   sudo ln -s /etc/nginx/sites-available/node /etc/nginx/sites-enabled/
   sudo systemctl restart nginx
   ```

6. **Monitorització i Logs**:
   ```bash
   # Veure logs en temps real
   pm2 logs api-gemini
   
   # Monitoritzar l'aplicació
   pm2 monit
   ```

## Consideracions Finals

- **Seguretat**: Les claus API i credencials sensibles han de mantenir-se segures i mai exposar-se públicament. Utilitza variables d'entorn per a totes les dades sensibles.

- **CORS**: Assegura't que la configuració CORS als servidors Laravel i Node.js permeti únicament les sol·licituds des dels dominis autoritzats.

- **Monitorització**: Implementa sistemes de monitorització per detectar problemes i temps d'inactivitat.

- **Còpies de seguretat**: Configura còpies de seguretat regulars de la base de dades i del codi.

- **Renovació de certificats SSL**: Configura la renovació automàtica dels certificats SSL:
  ```bash
  sudo certbot renew --dry-run  # Prova la renovació
  ```
  Certbot hauria de configurar una tasca cron automàticament per renovar els certificats abans que caduquin.

- **Escalabilitat**: Per a entorns amb més càrrega, considera implementar balanceig de càrrega i replicació dels servidors.
