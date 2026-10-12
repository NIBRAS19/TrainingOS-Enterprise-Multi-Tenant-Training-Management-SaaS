# Vue frontend integration

The existing TrainingOS frontend uses `credentials: include` but currently does not persist the bearer token returned by `/auth/login`.

There are two supported paths:

## Option A — Sanctum SPA cookies

Before login:

```ts
await fetch(`${API_BASE.replace('/api/v1','')}/sanctum/csrf-cookie`, {
  credentials: 'include',
})
```

Then call `/auth/login` with `credentials: 'include'`. Sanctum's first-party SPA flow is documented by Laravel and uses session cookies rather than storing an API token in localStorage.

## Option B — Bearer token

Store the returned `data.token` in an in-memory store or other deliberate credential store and send:

```http
Authorization: Bearer <token>
X-Organization-Id: <organization-id>
Accept: application/json
Content-Type: application/json
```

For a first-party Vue SPA, prefer Sanctum's cookie-based SPA flow over putting long-lived bearer tokens in localStorage.
