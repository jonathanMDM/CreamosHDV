# CreamosHDV - Sistema de Gestión

Sistema completo de gestión para negocio de hojas de vida desarrollado con **Laravel 12**, **PHP**, **MySQL** y **Bootstrap 5**.

## 🎨 Diseño

El sistema utiliza una paleta de colores moderna y profesional:

-   **Azul Oscuro** (#1a1f3a, #2c3e7d, #4a5fc1)
-   **Blanco** (#ffffff)
-   **Negro** (#000000)

## ✨ Características

### 1. **Gestión de Asesores**

-   Registro completo de asesores con:
    -   Nombre completo
    -   Cédula (único)
    -   Banco (Nequi, Bancolombia, Daviplata, Nu, Otros)
    -   Número de cuenta
    -   WhatsApp (con integración directa)
    -   Ciudad
    -   Fecha de registro automática
-   Vista detallada de cada asesor
-   Estadísticas de ventas y comisiones por asesor
-   Botón de WhatsApp para contacto directo

### 2. **Gestión de Servicios**

-   Catálogo de servicios con:
    -   Nombre del servicio
    -   Valor del servicio
    -   Porcentaje de comisión
-   Vista en tarjetas con diseño moderno
-   Estadísticas de ventas por servicio

### 3. **Registro de Ventas**

-   Selección de asesor y servicio
-   **Cálculo automático de comisiones** basado en el porcentaje del servicio
-   Vista previa del valor y comisión antes de guardar
-   Historial completo de ventas
-   Totales automáticos

### 4. **Dashboard Administrativo**

-   Estadísticas generales:
    -   Total de asesores
    -   Total de servicios
    -   Total de ventas
    -   Ingresos totales
    -   Comisiones totales
-   Ventas recientes
-   Top 5 asesores por comisiones
-   Accesos rápidos a funciones principales

### 5. **Autenticación**

-   Sistema de login seguro
-   Solo administradores pueden acceder
-   Protección de todas las rutas

## 🚀 Instalación

El sistema ya está instalado y configurado. Para iniciarlo:

```bash
# Iniciar el servidor
php artisan serve
```

El sistema estará disponible en: **http://127.0.0.1:8000**

## 🔐 Credenciales de Acceso

**Email:** admin@creamoshdv.com  
**Contraseña:** admin123

## 📊 Base de Datos

El sistema utiliza **SQLite** por defecto (archivo: `database/database.sqlite`)

### Tablas principales:

-   `users` - Usuarios administradores
-   `asesors` - Asesores registrados
-   `servicios` - Catálogo de servicios
-   `ventas` - Registro de ventas con comisiones

## 🛠️ Tecnologías Utilizadas

-   **Backend:** Laravel 12, PHP 8.2+
-   **Frontend:** Bootstrap 5, Font Awesome 6
-   **Base de Datos:** SQLite (puede cambiarse a MySQL)
-   **Estilos:** CSS personalizado con diseño moderno

## 📱 Características Especiales

### Integración con WhatsApp

Cada asesor tiene un botón de WhatsApp que abre directamente el chat con el número registrado.

### Cálculo Automático de Comisiones

Al registrar una venta:

1. Se selecciona el servicio
2. El sistema muestra automáticamente el valor del servicio
3. Calcula la comisión basada en el porcentaje configurado
4. Guarda ambos valores en la base de datos

### Diseño Responsivo

El sistema se adapta perfectamente a:

-   Computadores de escritorio
-   Tablets
-   Dispositivos móviles

## 📂 Estructura del Proyecto

```
CreamosHDV/
├── app/
│   ├── Http/Controllers/
│   │   ├── AsesorController.php
│   │   ├── ServicioController.php
│   │   ├── VentaController.php
│   │   └── DashboardController.php
│   └── Models/
│       ├── Asesor.php
│       ├── Servicio.php
│       └── Venta.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── auth/
│       │   └── login.blade.php
│       ├── asesores/
│       ├── servicios/
│       ├── ventas/
│       └── dashboard.blade.php
└── public/
    └── css/
        └── custom.css
```

## 🎯 Uso del Sistema

### 1. Registrar un Asesor

1. Ir a **Asesores** → **Nuevo Asesor**
2. Llenar todos los campos requeridos
3. Guardar

### 2. Crear un Servicio

1. Ir a **Servicios** → **Nuevo Servicio**
2. Ingresar nombre, valor y porcentaje de comisión
3. Guardar

### 3. Registrar una Venta

1. Ir a **Ventas** → **Nueva Venta**
2. Seleccionar el asesor
3. Seleccionar el servicio
4. El sistema mostrará automáticamente el valor y la comisión
5. Guardar

### 4. Ver Información de un Asesor

1. Ir a **Asesores**
2. Hacer clic en el botón de "Ver" (ojo)
3. Se mostrará:
    - Información personal
    - Datos bancarios
    - Estadísticas de ventas
    - Historial completo
    - Botón de WhatsApp

## 🔄 Comandos Útiles

```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Crear nuevo administrador
php artisan tinker
>>> \App\Models\User::create(['name' => 'Nombre', 'email' => 'email@ejemplo.com', 'password' => bcrypt('contraseña')]);

# Ver rutas disponibles
php artisan route:list

# Ejecutar migraciones
php artisan migrate

# Resetear base de datos
php artisan migrate:fresh --seed
```

## 🎨 Personalización

### Cambiar Colores

Editar el archivo: `public/css/custom.css`

```css
:root {
    --primary-dark: #1a1f3a;
    --primary-blue: #2c3e7d;
    --accent-blue: #4a5fc1;
    /* Modificar según necesidad */
}
```

### Agregar Más Bancos

Editar las migraciones y el modelo `Asesor`:

-   `database/migrations/*_create_asesors_table.php`
-   `app/Http/Controllers/AsesorController.php`

## 📞 Soporte

Para cualquier duda o problema con el sistema, contactar al desarrollador.

## 📝 Licencia

Sistema desarrollado exclusivamente para CreamosHDV.

---

**Desarrollado con ❤️ usando Laravel**
