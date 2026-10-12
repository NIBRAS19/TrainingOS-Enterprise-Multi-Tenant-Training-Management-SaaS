# TrainingOS Frontend

Production-style Vue 3 + TypeScript + Vite frontend for the Training Management SaaS PRD.

## Stack

- Vue 3
- TypeScript
- Vite
- Vue Router
- Pinia
- Responsive custom CSS design system
- Laravel-ready REST API service boundary

## Run locally

```bash
npm install
npm run dev
```

Open http://localhost:5173

## Build

```bash
npm run typecheck
npm run build
```

## Backend connection

Set:

```env
VITE_API_URL=http://localhost:8000/api/v1
```

The frontend currently uses mock data for all operational screens so the UX can be developed before Laravel endpoints are connected. Replace the mock collections in `src/data/mock.ts` with API-backed stores/services.

## Demo routes

- `/auth/login`
- `/auth/register`
- `/app/dashboard`
- `/app/learners`
- `/app/trainers`
- `/app/courses`
- `/app/courses/create`
- `/app/batches`
- `/app/batches/create`
- `/app/calendar`
- `/app/attendance`
- `/app/assessments`
- `/app/certificates`
- `/app/documents`
- `/app/reports`
- `/app/analytics`
- `/app/team`
- `/app/notifications`
- `/app/settings`
- `/verify-certificate/TRN-2026-000184`

## Laravel integration pattern

Keep the frontend API-first:

`Vue page -> Pinia store/composable -> src/services/api.ts -> Laravel /api/v1`

The backend should enforce authentication, tenant resolution, RBAC, policies, validation, rate limiting and resource authorization. Frontend visibility is UX only and must never be treated as authorization.
