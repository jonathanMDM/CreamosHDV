# Guía de Despliegue en Heroku - Creamos Hojas de Vida

Este documento contiene los pasos detallados para subir el sistema a Heroku.

## 1. Requisitos Previos

-   Tener una cuenta en [Heroku](https://www.heroku.com/).
-   Tener instalado [Heroku CLI](https://devcenter.heroku.com/articles/heroku-cli).
-   Tener un repositorio Git inicializado en esta carpeta.

## 2. Pasos para el Despliegue

### A. Login y Creación de la App

Abre una terminal en esta carpeta y ejecuta:

```bash
heroku login
heroku create nombre-de-tu-app
```

### B. Configurar la Base de Datos

Heroku usa PostgreSQL. Agrega el addon gratuito (o el que prefieras):

```bash
heroku addons:create heroku-postgresql:mini
```

### C. Configurar Variables de Entorno (Config Vars)

Debes configurar las variables que Laravel necesita. Puedes hacerlo desde el panel de Heroku o por terminal:

```bash
heroku config:set APP_NAME="Creamos Hojas de Vida"
heroku config:set APP_ENV=production
heroku config:set APP_KEY=$(php artisan key:generate --show)
heroku config:set APP_DEBUG=false
heroku config:set APP_URL=https://nombre-de-tu-app.herokuapp.com
```

### D. Subir el Código

```bash
git add .
git commit -m "Preparado para Heroku"
git push heroku main
```

### E. Ejecutar Migraciones en Heroku

Una vez subido el código, crea las tablas en la base de datos de Heroku:

```bash
heroku run php artisan migrate --force
```

## 3. Notas Importantes

-   **Imágenes:** Heroku tiene un sistema de archivos "efímero". Esto significa que si subes archivos directamente a la carpeta del servidor, se borrarán cada vez que se reinicie el sistema. Para un sistema de producción profesional, se recomienda usar **Amazon S3** o similar para el almacenamiento de archivos (como los comprobantes de transferencia).
-   **Procfile:** Ya he creado el archivo `Procfile` en la raíz del proyecto para que Heroku sepa cómo arrancar el servidor.
