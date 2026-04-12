# EGS Backend - Laravel & Elasticsearch

Este es el núcleo de servicios del ecosistema **EGS**, una API robusta construida con **Laravel 11** diseñada para gestionar catálogos de productos a gran escala. Implementa una arquitectura híbrida que combina la fiabilidad de **MySQL** con la potencia de búsqueda de **Elasticsearch**.

** Base URL:** `https://backend-egs-1.onrender.com`

---

## Arquitectura Técnica

El proyecto destaca por el uso de patrones de diseño avanzados para garantizar la integridad y velocidad de los datos:

* **Sincronización vía Observers:** Implementación de `ProductObserver` vinculado al ciclo de vida del modelo Eloquent. Cada inserción, actualización o eliminación en MySQL se replica en milisegundos en el índice de Elasticsearch.
* **Capa de Servicios (Service Layer):** La lógica de búsqueda está encapsulada en `ProductSearchService`, desacoplando la infraestructura de los controladores.
* **Transformación de Datos (DTO):** Uso de `ProductSearchResource` para normalizar los resultados de Elasticsearch, asegurando que el frontend reciba datos limpios y tipados.
* **Búsqueda Semántica:** Configuración de pesos (*weighting*) donde el **Nombre** tiene mayor relevancia que la **Descripción**, optimizando la precisión de los resultados.

---

## Stack Tecnológico

| Componente | Tecnología |
| :--- | :--- |
| **Framework** | Laravel 11 (PHP 8.2+) |
| **Base de Datos** | MySQL (Persistencia relacional) |
| **Motor de Búsqueda** | Elasticsearch (Búsqueda Full-text) |
| **Despliegue** | Render (PaaS) |

---

## Conexión con React Native (Entorno Local)

Si estás desarrollando el frontend en **React Native** y necesitas consumir este backend desde tu máquina local, sigue estos pasos:

### 1. Túnel de Red (ngrok)
Para que tu dispositivo móvil o emulador acceda al servidor local de Laravel:
```bash
# Inicia tu servidor local
php artisan serve

# En otra terminal, abre el túnel
ngrok http 8000
```

### 2. Configuración de API
Copia la URL generada por ngrok (ej. https://a1b2-c3d4.ngrok-free.app) y asígnala en tu archivo de configuración del frontend:
```bash
// constants/Config.js
export const API_URL = '[https://tu-url-de-ngrok.ngrok-free.app/api](https://tu-url-de-ngrok.ngrok-free.app/api)';
```

### Endpoints de la API
## Gestión de Productos (MySQL)

| Método | EndPoint | Descripción |
| :--- | :--- |
| **GET** | /api/products | Lista todos los productos disponibles. |
| **POST** | /api/products | Crea un producto (Valida vía StoreProductRequest). |
| **GET** | /api/products/{id} | Obtiene el detalle de un producto específico. |
| **DELETE** | /api/products/{id} | Elimina el producto de MySQL y Elasticsearch. |
| **GET** | /API/products/search?q="" | Servicio que filtra por cohicidencia usando ELASTICSEARCH |

## Motor de Búsqueda (Elasticsearch)
Endpoint: ** GET /api/products/search?q={termino}** 

Características: * Búsqueda Fuzzy (tolera errores tipográficos).

Resultados formateados mediante DTO para consistencia.

### Configuración del Entorno
Nota: Las credenciales de MySQL y las API Keys de Elasticsearch han sido configuradas directamente en el entorno de despliegue de Render para permitir una ejecución inmediata sin configuraciones adicionales.

## Desarrollado por Renzo Boneth | Full Stack and Mobile Developer

## 📡 Endpoints y Pruebas

### 🧡 Postman Collection
Puedes importar y probar todos los endpoints directamente usando nuestra colección compartida:
👉 [**Abrir Colección de Postman**](https://web.postman.co/workspace/My-Workspace~7a22c154-183e-4238-8294-570db0efbc3a/collection/34531239-af357493-bc9e-4b6f-8fc7-9dbe51e3cc9f?action=share&source=copy-link&creator=34531239)

