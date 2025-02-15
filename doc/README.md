# Arquitectura Bàsica

- **Back-end (servidor)**: Utilitzem Laravel com a API per gestionar la comunicació amb una base de dades. Aquesta API
  és responsable de servir tota la informació que necessita el front-end, així com de gestionar operacions com la
  creació, lectura, actualització i eliminació de dades (CRUD).

- **Front-end (client)**: Utilitzem el framework de Nuxt per gestionar la interfície d'usuari. Nuxt s'encarrega de la part interactiva i
  visual de l'aplicació, proporcionant una experiència d'usuari dinàmica i reactiva.
- **Part d'Administració**: Laravel també s'utilitza per a la part d'administració, on es permet als usuaris gestionar
  el CRUD dels productes (afegir, editar, eliminar i visualitzar productes) a través d'una interfície.

## Tecnologies

- **Nuxt**: Framework JavaScript per crear interfícies d'usuari reactives i components reutilitzables.
- **Laravel 11**: Framework PHP que facilita el desenvolupament d'aplicacions web robustes, amb una sintaxi elegant i
  orientada a objectes.
- **JavaScript**: Llenguatge de programació utilitzat per afegir interactivitat i comportament a l'aplicació al
  front-end.
- **CSS**: Utilitzat per estilitzar la interfície d'usuari, millorant la presentació visual de l'aplicació.
- **PHP 8**: Llenguatge de programació utilitzat al back-end, especialment per a Laravel.
- **HTML**: Llenguatge de marcat per estructurar les pàgines web al front-end.

## Plugins

- Per fer proves i verificar que la comunicació amb l'API funcioni correctament quan es realitzen peticions HTTP, hem
  utilitzat:
  - **Thunder Client**: Plugin de VS Code que permet realitzar peticions HTTP des de l'editor.
  - **Postman**: Eina per provar APIs de manera fàcil i visual, permetent enviar peticions HTTP i veure les respostes.

## Com Desplegar l'Aplicació a l'Entorn de Desenvolupament

Segueix aquests passos per configurar i executar l'aplicació en un entorn de desenvolupament:

1. **Instal·lació de Dependències**:

   - Accedeix al directori back/APIlaravel i executa composer install per instal·lar totes les dependències
     necessàries per a Laravel.

2. **Configuració de l'Arxiu .env**:
   - Crea una còpia de l'arxiu .env.example i anomena'l .env.
   - Dins del .env, defineix les configuracions de la base de dades descomentant i ajustant les següents línies:

```env
DB_HOST=el_teu_host
DB_PORT=el_teu_port
DB_DATABASE=el_nom_de_la_teva_base_de_dades
DB_USERNAME=el_teu_usuari
DB_PASSWORD=la_teva_contrassenya
```

- Substitueix el_teu_host, el_teu_port, el_nom_de_la_teva_base_de_dades, el_teu_usuari i la_teva_contrassenya pels
  valors corresponents del teu entorn.

3. **Iniciar el Servei del Servidor de Base de Dades**:

   - Assegura't que el servei de la base de dades (per exemple, MySQL o MariaDB) estigui en funcionament i crea la base
     de dades especificada al fitxer .env.

4. **Migracions, Generació de Clau i Inserció de Dades**:

   - Per configurar les taules a la base de dades, genera la clau de l'aplicació i insereix dades de mostra:
     - php artisan key:generate: Genera una clau única per a l'aplicació en l'arxiu .env, necessària per a la
       seguretat.
     - php artisan migrate:rollback: Esborrarà totes les taules existents si n'hi ha, preparant la base de dades per
       començar de nou.
     - php artisan migrate:reset: Alternativa a rollback que elimina les migracions aplicades i deixa la base de
       dades com si fos nova.
     - php artisan migrate: Crea les taules a la base de dades segons les migracions definides.

5. **Neteja de Caché**:

   - Per evitar problemes de configuració i garantir que es carreguin els últims canvis, neteja el caché amb aquests
     camandes:
     - php artisan config:clear: Neteja la caché de la configuració.
     - php artisan view:clear: Neteja la caché de les vistes de Blade.
     - php artisan cache:clear: Neteja la caché general de l'aplicació.

6. **Iniciar el Servidor de Laravel**:
   - Per executar l'aplicació i accedir a ella des del teu navegador, inicia el servidor de desenvolupament de Laravel
     amb:

```bash
php artisan serve
```

- Per producció, pot ser més adient configurar un servidor web com Nginx o Apache.

### Desplegar amb Docker Compose en desenvolupament

Si vols desplegar l'aplicació utilitzant Docker, segueix aquests passos per configurar i executar l'aplicació de manera
senzilla utilitzant Docker Compose. Aquest mètode ja inclou tot el necessari per a l'entorn de desenvolupament (base de
dades, Laravel, Node.js, etc.), excepte la configuració de ports.

1. **Instal·lació de Docker i Docker Compose**:

   - Abans de començar, assegura't que tens Docker i Docker Compose instal·lats al teu sistema. Pots descarregar-los
     des de:
     - [Docker](https://www.docker.com/get-started)
     - [Docker Compose](https://docs.docker.com/compose/install/)
     - [Docker Desktop](https://www.docker.com/products/docker-desktop): (per a usuaris de Windows i Mac)

2. **Configuració del fitxer `.env`**:

   - Abans de començar, assegura't de configurar el fitxer `.env` amb les teves dades de la base de dades i altres
     configuracions específiques. El fitxer `.env` ja està present dins del projecte, però has de verificar les
     configuracions de la base de dades:
     ```env
     DB_HOST=db
     DB_PORT=3306
     DB_DATABASE=el_nom_de_la_teva_base_de_dades
     DB_USERNAME=el_teu_usuari
     DB_PASSWORD=la_teva_contrassenya
     ```
     - **Nota**: `DB_HOST` es refereix al servei de base de dades que es definirà dins de Docker Compose com a `db`.

3. **Iniciar el projecte amb Docker Compose**:

   - Des del directori arrel del projecte (on es troba el fitxer `docker-compose.yml`), executa la següent comanda per
     iniciar tots els serveis (laravel, node.js i base de dades) de manera automàtica:
     ```bash
     docker-compose up -d
     ```
     Aquesta comanda descarregarà les imatges necessàries i iniciarà els contenidors en segon pla.

4. **Migracions i configuració inicial**:

   - Un cop el contenidor de Laravel estigui en funcionament, pots executar les migracions per configurar les taules de
     la base de dades. Executa aquesta comanda per accedir al contenidor de Laravel i realitzar les migracions:
     ```bash
     docker-compose exec app bash
     php artisan migrate
     php artisan key:generate
     ```
     Això generarà la clau d'aplicació i crearà les taules a la base de dades.

5. **Accés a l'aplicació**:

   - Un cop els serveis estiguin en funcionament, pots accedir a l'aplicació a través del navegador mitjançant l'URL
     configurat. Recorda que hauràs de configurar els ports a l'arxiu `docker-compose.yml` segons els teus requisits.

6. **Parar els serveis**:
   - Si necessites aturar l'aplicació i tots els serveis associats, executa:
     ```bash
     docker-compose down
     ```

# Desplegament a producció de l'aplicació

## 🌐 Desplegar Nuxt en Producció

Seguiu aquests passos per desplegar una aplicació **Nuxt** en un servidor de producció.

## Configuració

---

1. **Construir l'Aplicació per a Producció**:

   - Accedeix al directori del projecte Nuxt:
     ```bash
     cd front
     ```
   - Executa la següent comanda per generar els arxius optimitzats per a producció:
     ```bash
     npm run build
     ```
   - Després, genera els arxius estàtics per a desplegar:
     ```bash
     npm run generate
     ```
   - Això generarà una carpeta `public/` dintre de `./output` amb tots els arxius necessaris.

2. **Pujar els Fitxers al Servidor**:

   - Puja la carpeta `public/` al servidor dins de la ubicació on es vol desplegar l'aplicació.

3. **Configurar el Servidor per Servir Nuxt**:

   - Si el servidor és Apache, assegura't que el `.htaccess` està correcte.
   - Si el servidor és Nginx, edita la configuració:
     ```bash
     sudo nano /etc/nginx/sites-available/nuxt
     ```

   ### Configuració per protocol http

   - Afegeix la configuració següent:

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

   - Guarda i surt (`Ctrl + X`, `Y`, `Enter`).
   - Activa el fitxer de configuració i reinicia Nginx:
     ```bash
     sudo ln -s /etc/nginx/sites-available/nuxt /etc/nginx/sites-enabled/
     sudo systemctl restart nginx
     ```

4. **Assegurar-se que el Servei està en Funcionament**:

   - Accedeix a l'URL corresponent (`http://el_teu_domini.com`) per verificar que l'aplicació Nuxt està funcionant correctament.

### Configuració per protocol HTTPS

1. **Instal·lar Certbot i el Plugin per Nginx**

```bash
sudo apt update
sudo apt install certbot python3-certbot-nginx -y
```

2. **Generara el certificat amb certbot:**

```bash
sudo certbot --nginx -d el_teu_domini.com -d www.el_teu_domini.com
```

- Certbot renova automàticament els certificats, però pots comprovar-ho manualment amb:

```bash
sudo certbot renew --dry-run
```

3. **Afegeix la configuració següent:**

```nginx
server {
   listen 80;
   listen [::]:80;
   server_name el_teu_domini.com www.el_teu_domini.com;

   # Redirecció a HTTPS
   if ($host = www.el_teu_domini.com) {
   return 301 https://$host$request_uri;
   }

   if ($host = el_teu_domini.com) {
   return 301 https://$host$request_uri;
   }

   return 404;
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

 # Rutes de Nuxt.js per el frontend
  location / {
    try_files $uri $uri/ /index.html;
  }

  error_log /var/log/nginx/ilinker_error.log;
  access_log /var/log/nginx/ilinker_access.log;
}
```

- Guarda i surt (`Ctrl + X`, `Y`, `Enter`).
- Activa el fitxer de configuració i reinicia Nginx:

  ```bash
  sudo ln -s /etc/nginx/sites-available/nuxt /etc/nginx/sites-enabled/
  sudo systemctl restart nginx
  ```

5. **Assegurar-se que el Servei està en Funcionament**:

   - Accedeix a l'URL corresponent (`http://el_teu_domini.com`) per verificar que l'aplicació Nuxt està funcionant correctament.

Ara l'aplicació Nuxt estarà desplegada correctament en producció. 🚀

# 🌐 Desplegar Laravel en Producció

Seguiu aquests passos per desplegar una aplicació **Laravel** en un servidor de producció.

## Configuració

---

## 1. **Clonar el Repositori**

Primer, clona el repositori del projecte al servidor de producció.

```bash
git clone https://url-del-teu-repositori.git
```

## 2. **Configurar el Servidor per Servir Laravel**:

- Si el servidor és Apache, assegura't que el `.htaccess` està correcte.
- Si el servidor és Nginx, edita la configuració:
  ```bash
  sudo nano /etc/nginx/sites-available/laravel
  ```

### Configuració per protocol http

- Afegeix la configuració següent:

  ```nginx
  server {
   listen 80;
   server_name el_teu_domini.com;

   # Rutes Laravel API
   location ^~ /api/ {
   root /var/www/backend/public;  # Ruta del tu backend Laravel

   try_files $uri $uri/ @backend;
   }
  }

  # Reescritura per l'API de Laravel
  location @backend {
    rewrite ^/api/(.*)$ /$1 break;
    fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
    fastcgi_index index.php;
    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME /var/www/back/public/index.php;
  }

  error_log /var/log/nginx/ilinker_error.log;
  access_log /var/log/nginx/ilinker_access.log;
  ```

  - Guarda i surt (`Ctrl + X`, `Y`, `Enter`).

- Activa el fitxer de configuració i reinicia Nginx:

  ```bash
  sudo ln -s /etc/nginx/sites-available/laravel /etc/nginx/sites-enabled/
  sudo systemctl restart nginx
  ```

  ### Configuració per protocol HTTPS

1. **Instal·lar Certbot i el Plugin per Nginx**

```bash
sudo apt update
sudo apt install certbot python3-certbot-nginx -y
```

2. **Generara el certificat amb certbot:**

```bash
sudo certbot --nginx -d el_teu_domini.com -d www.el_teu_domini.com
```

- Certbot renova automàticament els certificats, però pots comprovar-ho manualment amb:

```bash
sudo certbot renew --dry-run
```

3. **Afegeix la configuració següent:**

```nginx
server {
   listen 80;
   listen [::]:80;
   server_name el_teu_domini.com www.el_teu_domini.com;

   # Redirecció a HTTPS
   if ($host = www.el_teu_domini.com) {
   return 301 https://$host$request_uri;
   }

   if ($host = el_teu_domini.com) {
   return 301 https://$host$request_uri;
   }

   return 404;
}

server {
 listen 443 ssl;
 server_name el_teu_domini.com www.el_teu_domini.com;

 ssl_certificate /etc/letsencrypt/live/el_teu_domini.com/fullchain.pem;
 ssl_certificate_key /etc/letsencrypt/live/el_teu_domini.com/privkey.pem;
 include /etc/letsencrypt/options-ssl-nginx.conf;
 ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem;

 server_name el_teu_domini.com;

   # Rutes Laravel API
   location ^~ /api/ {
   root /var/www/backend/public;  # Ruta del tu backend Laravel

   try_files $uri $uri/ @backend;
   }
  }

  # Reescritura per l'API de Laravel
  location @backend {
    rewrite ^/api/(.*)$ /$1 break;
    fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
    fastcgi_index index.php;
    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME /var/www/back/public/index.php;
  }

  error_log /var/log/nginx/ilinker_error.log;
  access_log /var/log/nginx/ilinker_access.log;
```

- Guarda i surt (`Ctrl + X`, `Y`, `Enter`).
- Activa el fitxer de configuració i reinicia Nginx:

  ```bash
  sudo ln -s /etc/nginx/sites-available/laravel /etc/nginx/sites-enabled/
  sudo systemctl restart nginx
  ```

5. **Assegurar-se que el Servei està en Funcionament**:

   - Accedeix a l'URL corresponent (`http://el_teu_domini.com`) per verificar que l'aplicació Nuxt està funcionant correctament.

Ara l'aplicació Nuxt estarà desplegada correctament en producció. 🚀

## 3. **Moure el Contingut a /var/www/backend**

Després de clonar el repositori, mou el contingut al directori de treball adequat:

```bash
mv nom-del-repositori /var/www/backend
```

## 4. **Configurar el Fitxer .env**

A continuació, copia el fitxer .env.example com a .env:

```bash
cd /var/www/backend
cp .env.example .env
```

Obre el fitxer .env i realitza les configuracions necessàries, com per exemple les variables de connexió a la base de dades i altres configuracions específiques per a producció.

## 5. **Instal·lar les Dependències amb Composer**

Un cop configurat el fitxer .env, instal·la les dependències de Composer:

```bash
composer install --optimize-autoloader --no-dev
```

## 6. **Generar la Clau d’Aplicació**

Genera la clau d’aplicació de Laravel:

```bash
php artisan key:generate
```

## 7. **Establir els Permisos Correctes**

És important establir els permisos correctes per a les carpetes de storage i cache:

```bash
sudo chown -R www-data:www-data /var/www/backend
sudo chmod -R 775 /var/www/backend/storage /var/www/backend/bootstrap/cache
```

## 8. **Migrar la Base de Dades**

Si cal, executa les migracions per configurar la base de dades:

```bash
php artisan migrate --force
```

## 9. **Configurar l’Entorn de Producció**

Assegura’t que el teu entorn de producció estigui configurat per executar amb les opcions de producció. Pots habilitar la cache i altres optimitzacions:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 10. **Verificar el Desplegament**

Un cop completats aquests passos, accedeix a la teva aplicació a través de l’URL del teu servidor per verificar que el desplegament s’ha realitzat correctament.

## Consideracions Finals

* **Verifica les Configuracions d'Entorn**: Assegura't que les configuracions de l'arxiu .env coincideixin amb l'entorn
  on es desplega l'aplicació (producció o desenvolupament).
* **Seguretat**: Mai comparteixis l'arxiu .env públicament, ja que conté informació sensible com les credencials de la
  base de dades.
* **Optimització**: Si estàs desplegant en un entorn de producció, pots utilitzar php artisan config:cache per millorar
  el rendiment un cop estigui tot configurat correctament, però fes-ho només quan no estiguis fent canvis freqüents a
  les configuracions.