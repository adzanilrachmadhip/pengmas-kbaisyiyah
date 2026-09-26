# Prompt: Build ECMS Backend for This Laravel Project

## Context

This project is a website built on the **ECMS (Extensible Content Management System)** concept. The frontend design already exists in this repo. Your job is to build the backend so that every piece of content in the design becomes editable through an admin panel, **without changing the layout**.

Project details (fill in before running):
- Project name: `[NAMA PROJECT]`
- Short description: `[DESKRIPSI SINGKAT WEBSITE]`
- Design location: `[mis. resources/views/, public/design/, atau folder lain]`
- Frontend stack: `[Blade + Bootstrap / Blade + Tailwind / Inertia + React / dll]`
- Language of admin UI: `[Indonesia / English]`

### ECMS core principles (must follow)

1. **Duplicate-view architecture**: the admin panel renders the *same* views as the public site. In admin mode, editable elements get edit affordances (hover border, label, edit icon). In public mode, they render as plain output.
2. **Content-only editing**: admins edit text, images, links, and collection items. They cannot change layout, structure, CSS, or section order unless explicitly defined as configurable.
3. **Layout locking**: the existing HTML structure and CSS classes of the design must stay intact. You may only add data attributes, Blade components/directives, and admin-only scripts.
4. **Content type abstraction**:
   - *Single-instance* content (hero title, about text, contact info) → key-value / section fields
   - *Collection* content (portfolio, services, FAQ, testimonials, team) → CRUD with ordering and publish status
   - *Media* (images, icons, files) → upload with validation
5. **Extensibility**: adding a new section should require only a migration/config entry, a model (if collection), and marking up the view — no changes to core ECMS code.

## Step 0 — Explore before coding

Do NOT write code yet. First:

1. Read `composer.json`, `package.json`, `.env.example`, `routes/`, `database/migrations/`, and the design files.
2. Identify the Laravel version, existing auth setup, frontend tooling (Vite, Tailwind, Bootstrap, Inertia, etc.).
3. Inventory every section in the design. For each section, list:
   - section name
   - editable fields and their type (short text, long text, rich text, image, URL, icon, number)
   - whether it is single-instance or a collection
4. Present this inventory as a table plus an implementation plan, and list any assumptions. Wait for my confirmation before implementing.

## Step 1 — Data layer

- Migrations:
  - `site_settings` (global: site name, logo, contact, social links, SEO defaults)
  - `section_contents` for single-instance fields (`section`, `key`, `value`, `type`, timestamps), unique on `section + key`
  - one table per collection (e.g. `portfolios`, `faqs`, `testimonials`) with `sort_order`, `status` (draft/published), timestamps, soft deletes
  - `media` table if images are reused across sections
- Eloquent models with proper `$fillable`, `$casts`, scopes (`published()`, `ordered()`).
- Seeders that populate **all content currently hardcoded in the design**, so the site looks identical after migration.

## Step 2 — Content rendering in views

- Create a reusable mechanism to output editable content, e.g.:
  - Blade component `<x-ecms.text section="hero" key="title" tag="h1" class="..." />`
  - Blade component `<x-ecms.image section="hero" key="background" />`
  - or a helper `ecms('hero.title')` for plain values
- In admin mode, components add `data-ecms-section`, `data-ecms-key`, `data-ecms-type` attributes. In public mode, they output clean markup only.
- Replace hardcoded content in the design views with these components. Keep every existing tag, class, and wrapper unchanged.
- Collections: loop over published, ordered items; in admin mode add `data-ecms-collection` and `data-ecms-id` plus add/edit/delete controls.
- Cache section content (e.g. `Cache::rememberForever` per section) and invalidate on update.

## Step 3 — Admin backend

- Authentication: reuse existing auth if present; otherwise install Laravel Breeze (or a minimal session-based admin login). Protect all admin routes with `auth` middleware and a simple role/gate (`is_admin`).
- Routes under `/admin`:
  - `GET /admin` → admin dashboard rendering the site in edit mode (sidebar to jump to sections, top bar: Preview, Logout)
  - `PATCH /admin/content/{section}/{key}` → update single field (JSON)
  - `POST /admin/media` → upload image, return URL (JSON)
  - `apiResource`-style routes per collection: index, store, update, destroy
  - `POST /admin/{collection}/reorder` → update `sort_order`
  - `PATCH /admin/{collection}/{id}/status` → publish/unpublish
  - `PUT /admin/settings` → global settings
- Use Form Requests for validation (max lengths, required fields, image mime/size), and a service layer (`ContentService`, `CollectionService`, `MediaService`) so controllers stay thin.
- All admin endpoints return consistent JSON: `{ success, message, data, errors }`.

## Step 4 — Admin editing UI (glue only)

- Follow the project's existing frontend stack. If none, use minimal vanilla JS.
- Short text: inline edit (contenteditable or small popover), save via PATCH, show toast.
- Long/rich text, images, and collection items: modal form with live preview, character counter, image preview before upload.
- Visual indicators: dashed border + label on hover for editable elements. Do not alter the design's own styling.
- All requests include the CSRF token.

## Step 5 — Security

- Escape all plain text output. For rich text, sanitize with `mews/purifier` (or equivalent) using a strict whitelist.
- Uploads: whitelist mime types (jpeg, png, webp, gif, svg only if sanitized), max size (e.g. 2 MB), store on `public` disk with randomized names, run `storage:link`.
- Rate-limit admin write endpoints and login.
- Mass-assignment protection on all models; authorize every admin action via policy/gate.

## Step 6 — Testing and verification

- Feature tests (Pest or PHPUnit, whichever the project uses) for:
  - public pages render with seeded content
  - guests cannot access admin routes
  - updating single-instance content, collection CRUD, reorder, publish toggle
  - upload validation (reject wrong type/oversized)
- Run `php artisan migrate:fresh --seed` and `php artisan test`; all must pass.
- Visually compare the public page before and after: layout must be identical.

## Working rules

- Work in small steps; after each step, summarize what changed and which files were touched.
- Commit after each completed step with a clear message.
- Don't install packages beyond what's listed without asking.
- If the design has something ambiguous (e.g. unclear whether a block is static or editable), ask instead of guessing.
- Don't delete or restructure existing design files.

## Definition of done

- Every visible piece of content in the design is editable from `/admin`.
- Public site looks identical to the original design.
- Adding a new section follows a documented pattern (write it in `docs/ECMS.md`).
- All tests pass; README updated with setup steps (install, migrate, seed, default admin account, storage link).