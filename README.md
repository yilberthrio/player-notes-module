# Player Notes Module

Aplicación Laravel 12 + Livewire para gestionar jugadores y sus notas internas, con control de acceso por roles/permisos (Spatie Permission).

## 1. Resumen funcional

- Login de usuarios con Laravel Fortify.
- Listado de jugadores con búsqueda, ordenamiento y paginación.
- Módulo de notas por jugador:
  - Crear notas.
  - Editar notas.
  - Eliminar notas.
  - Buscar por contenido o autor.
- Control de acceso por permisos (`admin`, `consultor`, `player`).

## 2. Comportamiento de acceso

- Si un usuario **no tiene sesión**, `/` redirige directamente a `/login`.
- Si el usuario **ya está autenticado**, `/` redirige a `/dashboard`.
- La ruta de registro está deshabilitada (no existe `/register`).

## 3. Stack técnico

- PHP `^8.2`
- Laravel `^12`
- Livewire `^4` + Flux/Blaze
- Laravel Fortify (autenticación)
- Spatie Laravel Permission (roles/permisos)
- TailwindCSS + Vite
- Base de datos: SQLite (por defecto en `.env.example`) o MySQL

## 4. Requisitos previos

- PHP 8.2+
- Composer
- Node.js 20+ y npm
- Motor de base de datos (SQLite o MySQL)
- Extensión PHP `pdo_sqlite` para pruebas automáticas sin depender de MySQL local

## 5. Puesta en marcha (local)

1. Instalar dependencias:

```bash
composer install
npm install
```

2. Crear entorno local:

```bash
cp .env.example .env
php artisan key:generate
```

3. Configurar base de datos en `.env`.

4. Ejecutar migraciones y seeders:

```bash
php artisan migrate --seed
```

5. Levantar frontend:

```bash
npm run dev
```

6. Levantar backend (en otra terminal):

```bash
php artisan serve
```

Opcional: ejecutar todo en paralelo con:

```bash
composer dev
```

## 6. Seeders y datos iniciales

El seeding principal se ejecuta desde `DatabaseSeeder` en este orden:

1. `RoleSeeder`
2. `PermissionSeeder`
3. `PersonSeeder`
4. `EmployeeSeeder`
5. `PlayerSeeder`
6. `UserSeeder`
7. `UserRoleSeeder`

### 6.1 Roles creados

- `admin`
- `player`
- `consultor`

### 6.2 Permisos creados

- `players.view`
- `player-notes.view`
- `player-notes.create`
- `player-notes.update`
- `player-notes.delete`

### 6.3 Matriz de permisos por rol

| Rol | players.view | player-notes.view | create | update | delete |
|---|---|---|---|---|---|
| admin | Yes | Yes | Yes | Yes | Yes |
| consultor | Yes | Yes | No | No | No |
| player | No | No | No | No | No |

### 6.4 Usuarios iniciales (seed)

Todos los usuarios seed tienen contraseña inicial:

```text
12345678
```

| ID | Username | Email | Rol |
|---|---|---|---|
| 1 | `yilberthandres` | `yilberthgalarza444@gmail.com` | admin |
| 2 | `admin2` | `yilberth2@gmail.com` | admin |
| 3 | `player3` | `yilberth3@gmail.com` | player |
| 4 | `player4` | `yilberth4@gmail.com` | player |
| 5 | `consultor` | `yilberth5@gmail.com` | consultor |

## 7. Rutas principales

- `GET /` -> redirección a login o dashboard según sesión.
- `GET /dashboard` -> home interna.
- `GET /players` -> listado de jugadores (requiere `players.view`).
- `GET /players/{player}/notes` -> notas del jugador (requiere `player-notes.view`).
- Fortify maneja rutas de login/logout/reset password.

## 8. Comandos útiles

Recrear base de datos con datos semilla:

```bash
php artisan migrate:fresh --seed
```

Limpiar cachés:

```bash
php artisan optimize:clear
```

Ejecutar pruebas:

```bash
php artisan test
```

La suite está configurada para correr con SQLite en memoria (`:memory:`), sin requerir MySQL local.

## 9. Checklist de pre-entrega

- `php artisan migrate:fresh --seed` ejecuta sin errores.
- Login funcional con usuario semilla.
- Redirección de `/` validada:
  - sin sesión -> `/login`
  - con sesión -> `/dashboard`
- Ruta `/register` deshabilitada.
- `php artisan test` en verde.
- No hay credenciales sensibles en archivos versionados.
- README actualizado.

## 10. Estructura del proyecto (resumen)

- `app/Livewire/Players` -> componentes de lista y notas.
- `app/Services` -> lógica de aplicación.
- `app/Repositories` -> acceso a datos (patrón repositorio).
- `app/Policies` -> autorización de notas.
- `database/migrations` -> esquema de BD.
- `database/seeders` -> datos iniciales.
- `resources/views` -> vistas Blade/Livewire.
- `routes/web.php` -> rutas web de la app.

## 11. Notas para desarrollo

- El seeder `PlayerNoteSeeder` existe pero actualmente no inserta registros.
- Si cambias permisos o roles, ejecuta de nuevo seeders para alinear datos:

```bash
php artisan db:seed
```
