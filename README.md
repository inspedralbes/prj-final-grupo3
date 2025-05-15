# TriPlan

## Integrants
- Andrew Turner
- Aivan Antonio
- Brian Jaén
- Eduard Vilaseca Vilà

## Descripció
TriPlan és una eina integral per planificar i gaudir del teu viatge de manera personalitzada. Els usuaris poden registrar-se i adaptar completament la seva experiència seleccionant la destinació, la durada, el tipus de viatge (familiar, en parella, amb amics o en solitari) i el pressupost, oferint plans optimitzats segons les seves necessitats i preferències.

La plataforma utilitza intel·ligència artificial mitjançant l'API de Gemini per generar itineraris personalitzats, complementats amb imatges rellevants obtingudes través de l'API de Pexels.

## Arquitectura
El projecte està estructurat en tres components principals:
- **Front-end**: Aplicació Nuxt per la interfície d'usuari.
- **Back-end Laravel**: API RESTful desenvolupada amb Laravel per gestionar usuaris, perfils, preferències i dades del sistema.
- **Back-end Node.js**: Servidor dedicat a la comunicació amb l'API de Gemini i el processament de les respostes, incloent la integració amb serveis d'imatges.

Per a més detalls sobre l'arquitectura i guies d'instal·lació, consulta la [documentació completa](./doc/README.md).

## Tecnologies
- **Front-end**: Nuxt, JavaScript, HTML, CSS
- **Back-end**: Laravel 11, PHP 8, Node.js, Express
- **Base de dades**: MySQL
- **APIs externes**: Gemini AI, Pexels
- **Desplegament**: Docker, Nginx

## Desplegament ràpid amb Docker
Per iniciar tots els serveis (front-end, back-end i base de dades) amb Docker:

```bash
# Clona el repositori
git clone https://github.com/user/prj-final-grupo3.git
cd prj-final-grupo3

# Inicia els serveis amb Docker Compose
docker-compose up -d
```

Això iniciarà:
- Front-end Nuxt a http://localhost:3000
- API Laravel a http://localhost:8000
- API Node.js a http://localhost:3006
- Base de dades MySQL a localhost:3307
- Adminer (gestor de BD) a http://localhost:8080

## Gestor de tasques
- [Taiga](https://tree.taiga.io/project/eduardv1-projecte-final/timeline)

## Prototip gràfic
- [Penpot](https://design.penpot.app/#/view/96c4bd8e-df43-800f-8005-9d45f12c808b?page-id=4f46a787-64aa-806f-8005-9d4687b1f6b8&section=interactions&index=0)

## Producció
- [URL](https://triplan.cat)

## Estat
- Producció v1.3

## Logo
![favicon-96x96](https://github.com/user-attachments/assets/f5ef9263-b3cc-463c-b600-3c474d4ad8b5)
