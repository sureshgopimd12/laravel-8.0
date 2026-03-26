# Multi-Tenant CMS SaaS (Laravel Service-Layer Blueprint)

This repository provides a production-minded starter architecture for a **multi-tenant CMS SaaS** (WordPress.com / Wix style) using:

- Laravel (Blade-first, no SPA requirement)
- Service layer + repositories
- Single database multi-tenancy with domain-based tenant resolution
- CMS pages + dynamic sections + media manager
- Plan and billing foundation for Stripe-style subscriptions

---

## 1) Architecture Overview

### Layers

- **Controllers**: orchestration only (no heavy business logic)
- **Services**: business rules (tenant provisioning, page duplication, limits)
- **Repositories**: reusable data access methods
- **Middleware**: resolve tenant context by host/domain
- **Blade views**: dashboard builder and tenant front rendering

### Tenant Isolation Approach

- Single DB strategy using `tenant_id` where applicable
- Tenant detected by request host in `TenantResolver`
- Current tenant injected in container as `app('currentTenant')`

### Scalability Notes (10k+ tenants)

- Composite indexes for tenant/status lookups
- Slug + tenant uniqueness constraints
- JSON content for flexible section schema evolution
- Horizontal-ready storage (`media` with disk abstraction)
- Query scoping by tenant and status for read paths

---

## 2) Module Coverage

### Auth & Roles

- Compatible with Laravel auth scaffolding
- Roles in users table: `super_admin`, `tenant_owner`, `editor`

### Tenant / Website System

- One owner can create multiple tenants
- Domains table supports platform subdomains and future custom domains

### CMS Engine

- `pages` with SEO metadata and publish state
- `sections` as ordered JSON blocks (hero, text, gallery, etc.)
- Page duplication included in `PageService`

### Builder UI

- Blade + Alpine.js section editor
- Ordered section editing with move-up/delete/add behavior

### Media

- Tenant-scoped uploads
- Metadata, alt text, MIME, file size tracked

### Themes

- Tenant linked to theme
- Front rendering via theme Blade templates

### Billing

- Plan model with limits/features JSON
- Subscription model for Stripe provider IDs
- Plan enforcement example: page count gate

### Super Admin

- Dashboard aggregates users/tenants/plans/active tenants

### Security Foundations

- Tenant resolver middleware for host-based isolation
- FormRequest validation
- Blade escaping by default
- Policy hook shown via admin route gate middleware

---

## 3) Request Flow

1. Incoming request host resolved in `TenantResolver`
2. Tenant stored in IoC container
3. Tenant controllers/services enforce plan limits and persistence rules
4. Frontend routes resolve slug and render sections dynamically

---

## 4) Routes Snapshot

- `dashboard/sites/*`: tenant website provisioning
- `dashboard/pages/*`: tenant page CMS and builder
- `dashboard/media/*`: tenant media manager
- `super-admin/`: platform analytics dashboard
- `/{slug}` and `/`: tenant website rendering

---

## 5) Suggested Next Production Steps

- Add queue workers (image optimization, sitemap generation)
- Add Redis cache tags per tenant
- Add Stripe webhook controller for subscription lifecycle
- Add custom-domain verification flow (DNS TXT/CNAME)
- Add policy classes and per-tenant user membership pivot
- Add audit logs and activity stream
- Add API resources + sanctum authentication
- Add multilingual page versioning tables
- Add static export jobs

