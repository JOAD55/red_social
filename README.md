# Red Social — API REST

API REST en PHP (sin framework) con MySQL para gestionar **usuarios** y **mensajes** de una red social. Responde en JSON y está pensada para correr en MAMP. Incluye un frontend sencillo en vanilla JS.

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
│   ├── modelos/              # usuarios.php y mensaje.php (acceso a datos)
│   ├── controladores/        # usuarios.php y mensaje.php (lógica por método HTTP)
│   └── rutas/rutas.php       # Punto de entrada: cabeceras CORS y enrutado
├── FRONT/
│   ├── index.html            # Inicio de sesión (consulta usuario por correo)
│   ├── registro.html         # Registro de nuevo usuario
│   ├── style.css             # Estilos
│   └── js/
│       ├── index.js          # Lógica de inicio de sesión
│       └── registro.js       # Lógica de registro
├── SQL/DBHeidi.sql           # Creación de la BD y las tablas
└── plantilla.htaccess        # Reglas de reescritura de URL
```

## Instalación

1. Copia el proyecto en `htdocs` (p. ej. `D:\MAMP\htdocs\red_social`).
2. Ejecuta `SQL/DBHeidi.sql` en tu cliente MySQL (HeidiSQL, phpMyAdmin…) para crear la base `red_social` y las tablas `usuarios` y `mensaje`.
3. Ajusta las credenciales en `BACK/conexion.php` (servidor, usuario, contraseña y **puerto** según tu MAMP; por defecto `3308`).
4. Copia `plantilla.htaccess` como `.htaccess` en la raíz del servidor web y revisa que las rutas `/red_social/BACK/rutas/rutas.php` coincidan con tu instalación.
5. Sirve `FRONT/` con MAMP. El frontend llama a `http://localhost:81` (ver `FRONT/js/`), así que el servidor web debe responder en el puerto `81` o ajusta las URLs en `FRONT/js/index.js` y `FRONT/js/registro.js`.

## Endpoints

Base: `http://localhost/` (según tu `.htaccess`). Los cuerpos van en JSON.

### Usuarios — `/usuario`

| Método | Ruta           | Descripción        | Cuerpo                                  |
|--------|----------------|--------------------|-----------------------------------------|
| GET    | `/usuario`     | Lista usuarios     | —                                       |
| GET    | `/usuario/{id}`| Obtiene un usuario | —                                       |
| POST   | `/usuario`     | Crea un usuario    | `nombre`, `correo`, `contrasena`        |
| POST   | `/usuario/correo` | Busca usuario por correo | `correo`                            |
| PUT    | `/usuario`     | Actualiza          | `id`, `nombre`, `correo`, `contrasena`  |
| DELETE | `/usuario/{id}`| Elimina            | —                                       |

### Mensajes — `/mensaje`

| Método | Ruta            | Descripción        | Cuerpo                                 |
|--------|-----------------|--------------------|----------------------------------------|
| GET    | `/mensaje`      | Lista mensajes     | —                                      |
| GET    | `/mensaje/{id}` | Obtiene un mensaje | —                                      |
| POST   | `/mensaje`      | Crea un mensaje    | `texto`, `remitente`, `destinatario`   |
| PUT    | `/mensaje`      | Actualiza          | `id`, `texto`, `remitente`, `destinatario` | DELETE | `/mensaje/{id}` | Elimina            | —                                      |

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
- `201` recurso creado
- `400` campos obligatorios faltantes, id ausente o error en la ejecución (`{"Error": "..."}`)
- `404` usuario no encontrado
- `500` error del servidor

## Base de datos

- **usuarios**: `id`, `nombre`, `correo` (único), `contrasena`
- **mensaje**: `id`, `texto`, `fecha_hora`, `remitente`, `destinatario`

## Frontend

El frontend (carpeta `FRONT/`) es HTML/CSS/JS vanilla y no requiere compilación:

- `index.html`: formulario de inicio de sesión. Al hacer clic en "Ingresar" envía `POST /usuario/correo` con el correo y avisa si el usuario existe.
- `registro.html`: formulario de registro. Envía `POST /usuario` con `nombre`, `correo` y `contrasena`.
- `FRONT/js/index.js` y `FRONT/js/registro.js` apuntan a `http://localhost:81`; cámbialos si tu MAMP corre en otro puerto.

## Notas

- El índice de `$uri[]` en `rutas.php` y los controladores depende de la URL usada; si cambias la ruta base, ajústalo.
- CORS está abierto a cualquier origen (`*`) — restríngelo en producción.
- Las contraseñas se guardan cifradas con `password_hash`.
