# 🚀 Guía Rápida de Inicio - CreamosHDV

## Paso 1: Iniciar el Servidor

```bash
cd "/Users/jonathanm/Documents/PERSONAL/Desarrollo Software/CreamosHDV"
php artisan serve
```

## Paso 2: Acceder al Sistema

Abrir en el navegador: **http://127.0.0.1:8000**

## Paso 3: Iniciar Sesión

**Email:** admin@creamoshdv.com  
**Contraseña:** admin123

## Paso 4: Flujo de Trabajo Recomendado

### 1️⃣ Registrar Asesores

-   Ir a **Asesores** → **Nuevo Asesor**
-   Completar todos los datos
-   El número de WhatsApp debe ser sin espacios (ejemplo: 3001234567)

### 2️⃣ Crear Servicios

-   Ir a **Servicios** → **Nuevo Servicio**
-   Definir el valor del servicio
-   Establecer el porcentaje de comisión (0-100)

### 3️⃣ Registrar Ventas

-   Ir a **Ventas** → **Nueva Venta**
-   Seleccionar asesor y servicio
-   **La comisión se calcula automáticamente**
-   Verificar el resumen antes de guardar

### 4️⃣ Consultar Estadísticas

-   El **Dashboard** muestra:
    -   Totales generales
    -   Ventas recientes
    -   Top asesores
    -   Accesos rápidos

## 📊 Ejemplo de Uso

### Ejemplo 1: Registrar un Asesor

```
Nombre: Juan Pérez
Cédula: 1234567890
Banco: Nequi
Número de Cuenta: 3001234567
WhatsApp: 3001234567
Ciudad: Bogotá
```

### Ejemplo 2: Crear un Servicio

```
Nombre: Hoja de Vida Profesional
Valor: 50000
Comisión: 20%
```

### Ejemplo 3: Registrar una Venta

```
Asesor: Juan Pérez
Servicio: Hoja de Vida Profesional
→ Valor: $50,000
→ Comisión: $10,000 (20%)
```

## 🎯 Funciones Clave

### Ver Detalles de un Asesor

1. Ir a **Asesores**
2. Clic en el botón **👁️ (ojo)**
3. Ver toda la información y estadísticas
4. Usar el botón de WhatsApp para contactar

### Editar Información

-   Todos los módulos tienen botón de **✏️ Editar**
-   Los cambios se guardan inmediatamente
-   Las comisiones se recalculan automáticamente

### Eliminar Registros

-   Botón **🗑️ Eliminar** disponible en todos los módulos
-   Confirmación antes de eliminar
-   **Cuidado:** Eliminar un asesor elimina sus ventas

## 💡 Consejos

1. **Registra primero los asesores y servicios** antes de crear ventas
2. **Verifica los porcentajes de comisión** al crear servicios
3. **Usa el Dashboard** para ver el rendimiento general
4. **El botón de WhatsApp** abre directamente el chat
5. **Las fechas se registran automáticamente**

## ⚠️ Importante

-   No cerrar la terminal donde corre `php artisan serve`
-   Para detener el servidor: **Ctrl + C**
-   Los datos se guardan en `database/database.sqlite`
-   Hacer backup periódico de la base de datos

## 🔧 Solución de Problemas

### El servidor no inicia

```bash
php artisan cache:clear
php artisan config:clear
php artisan serve
```

### No puedo iniciar sesión

```bash
php artisan db:seed --class=AdminUserSeeder
```

### Error de base de datos

```bash
php artisan migrate:fresh --seed
```

## 📱 Acceso desde Otros Dispositivos

Para acceder desde otros dispositivos en la misma red:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Luego acceder desde: **http://[TU-IP]:8000**

---

**¡Listo para usar! 🎉**
