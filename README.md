# Red Social — API REST

API REST en PHP (sin framework) con MySQL para gestionar **usuarios** y **mensajes** de una red social. Responde en JSON y está pensada para correr en MAMP.

Dale estrellita al repo.

## Requisitos

- PHP 7.4+ con la extensión `mysqli`
- MySQL
- Apache con `mod_rewrite` (MAMP)
- Un cliente HTTP para probar (Yaak, Postman, curl…)

## Estructura

```
red_social/
├── BACK/
│   ├── conexion.php          # Constantes de conexión a la BD
│   ├── librerias/bd.php      # Clase DATABASE (conexión mysqli)
│   ├── modelos/              # Usuario y Mensaje (acceso a datos)
│   ├── controladores/        # usuarios.php y mensaje.php (lógica por método HTTP)
│   └── rutas/rutas.php       # Punto de entrada: cabeceras CORS y enrutado
├── SQL/DBHeidi.sql           # Creación de la BD y las tablas
└── plantilla.htaccess        # Reglas de reescritura de URL
```

## Instalación

1. Copia el proyecto en `htdocs` (p. ej. `D:\MAMP\htdocs\red_social`).
2. Ejecuta `SQL/DBHeidi.sql` en tu cliente MySQL (HeidiSQL, phpMyAdmin…) para crear la base `red_social` y las tablas `usuarios` y `mensaje`.
3. Ajusta las credenciales en `BACK/conexion.php` (servidor, usuario, contraseña y **puerto** según tu MAMP; por defecto `3308`).
4. Copia `plantilla.htaccess` como `.htaccess` en la raíz del servidor web y revisa que las rutas `/red_social/BACK/rutas/rutas.php` coincidan con tu instalación.

## Endpoints

Base: `http://localhost/` (según tu `.htaccess`). Los cuerpos van en JSON.

### Usuarios — `/usuario`

| Método | Ruta           | Descripción        | Cuerpo                                  |
|--------|----------------|--------------------|-----------------------------------------|
| GET    | `/usuario`     | Lista usuarios     | —                                       |
| GET    | `/usuario/{id}`| Obtiene un usuario | —                                       |
| POST   | `/usuario`     | Crea un usuario    | `nombre`, `correo`, `contrasena`        |
| PUT    | `/usuario`     | Actualiza          | `id`, `nombre`, `correo`, `contrasena`  |
| DELETE | `/usuario/{id}`| Elimina            | —                                       |

### Mensajes — `/mensaje`

| Método | Ruta            | Descripción        | Cuerpo                                 |
|--------|-----------------|--------------------|----------------------------------------|
| GET    | `/mensaje`      | Lista mensajes     | —                                      |
| GET    | `/mensaje/{id}` | Obtiene un mensaje | —                                      |
| POST   | `/mensaje`      | Crea un mensaje    | `texto`, `remitente`, `destinatario`   |
| PUT    | `/mensaje`      | Actualiza          | `id`, `texto`, `remitente`, `destinatario` |
| DELETE | `/mensaje/{id}` | Elimina            | —                                      |

`fecha_hora` del mensaje no se envía: la define el modelo.

### Ejemplo

```bash
curl -X POST http://localhost/usuario \
  -H "Content-Type: application/json" \
  -d '{"nombre":"Ana","correo":"ana@mail.com","contrasena":"1234"}'
```

Respuesta: `{"mensaje":"Usuario registrado con exito"}`

### Códigos de respuesta

- `200` operación correcta
- `400` campos obligatorios faltantes, id ausente o error en la ejecución (`{"Error": "..."}`)

## Base de datos

- **usuarios**: `id`, `nombre`, `correo` (único), `contrasena`
- **mensaje**: `id`, `texto`, `fecha_hora`, `remitente`, `destinatario`

## Notas

- El índice de `$uri[]` en `rutas.php` y los controladores depende de la URL usada; si cambias la ruta base, ajústalo.
- CORS está abierto a cualquier origen (`*`) — restríngelo en producción.
