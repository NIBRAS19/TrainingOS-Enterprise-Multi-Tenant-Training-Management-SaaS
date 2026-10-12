# TrainingOS Backend

Production-style Laravel 13 API backend for the TrainingOS Vue 3 SaaS frontend.

## Stack

- PHP 8.3+
- Laravel 13
- Laravel Sanctum 4.3+
- PostgreSQL
- Vue 3 frontend integration
- DOMPDF for certificates
- Simple QrCode for certificate verification QR codes

## Run locally

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

The demo seed creates:

- `owner@trainingos.test` / `password`
- `trainer@trainingos.test` / `password`

## Frontend API

Set the frontend `VITE_API_URL` to:

```text
http://localhost:8000/api/v1
```

The login endpoint returns a Sanctum bearer token. For the existing frontend fetch wrapper, persist that token and attach:

```http
Authorization: Bearer <token>
X-Organization-Id: <organization-id>
Accept: application/json
```

The backend also supports Sanctum SPA authentication for first-party cookie-based setups; Laravel's Sanctum documentation recommends `statefulApi()` for SPA authentication and `auth:sanctum` on protected API routes. See the official docs before choosing the production auth transport.

## Tenant security

Every organization-owned model includes `organization_id` and the `BelongsToTenant` trait adds a tenant global scope. The `tenant` middleware resolves an active organization from membership and the optional `X-Organization-Id` header.

Do not trust tenant IDs, role IDs or resource IDs supplied by the browser. Authorization is enforced server-side.

## Core endpoints

```text
POST   /api/v1/auth/register
POST   /api/v1/auth/login
POST   /api/v1/auth/forgot-password
POST   /api/v1/auth/reset-password
GET    /api/v1/auth/me
POST   /api/v1/auth/logout
POST   /api/v1/auth/switch-organization

GET    /api/v1/dashboard
GET    /api/v1/analytics
GET    /api/v1/calendar?from=2026-09-01&to=2026-09-30

CRUD   /api/v1/learners
CRUD   /api/v1/trainers
CRUD   /api/v1/courses
CRUD   /api/v1/batches

POST   /api/v1/sessions/{session}/attendance
GET    /api/v1/sessions/{session}/attendance
CRUD   /api/v1/assessments
GET    /api/v1/assessments/{assessment}/results
POST   /api/v1/assessments/{assessment}/submit

GET    /api/v1/certificates
POST   /api/v1/certificates/generate
GET    /api/v1/certificates/{certificate}/download
POST   /api/v1/certificates/{certificate}/revoke
GET    /api/v1/public/certificates/{number}

CRUD   /api/v1/documents
GET    /api/v1/reports/{type}
GET    /api/v1/notifications
GET    /api/v1/team
GET    /api/v1/settings
```

## Security notes

- Use HTTPS in production.
- Restrict CORS to the exact frontend origin.
- Keep document storage private.
- Review certificate public fields before launch.
- Add production rate limits, mail delivery and centralized logging.
- Run tenant-isolation and authorization tests before deployment.
