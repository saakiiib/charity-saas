# CharityHub — Multi-Tenant Charity Website Platform
## Full Project Concept & Implementation Guide

---

## WHAT THIS PROJECT IS

A SaaS-style platform built in Laravel + Bootstrap where YOU (super admin) manage multiple charity websites from one codebase. Each charity (tenant) gets their own domain, their own branding, their own content — all managed from your central admin panel. No separate hosting or codebase per charity. One Laravel project serves all of them.

Think of it like Wix or Squarespace but specifically for charities, and you control everything from the backend.

---

## HOW IT WORKS (Big Picture)

```
Your Admin Panel (charityhubhub.co.uk)
    └── Tenants Module
        └── Add Charity → set domain, logo, colors, theme
        └── Each charity has its own management dashboard

Charity Domain (helpcharity.com)
    └── Points DNS to your server
    └── Laravel middleware detects domain
    └── Loads that charity's data, colors, theme, content
    └── Shows their public website
```

Everything is one codebase. The middleware identifies which charity is being visited and injects their data. All pages are Blade templates — same templates for all charities, just different data and different CSS theme file.

---

## ADMIN PANEL STRUCTURE

### Main Sidebar
```
Dashboard
Charities
Settings
```

### Charities Module
- List all charities in a DataTable
- Add new charity
- Each row has: Name, Domain, Theme, Status, Actions
- Actions: Manage | Delete | Toggle Status

### Charity Management Dashboard
When you click Manage on a charity, you enter that charity's management space. It has its own sidebar:

```
← Back to Charities
──────────────────
Company Details
Theme & Colors
──────────────────
Pages
  Home
  About
  Services
  Get Involved
  Blog / Updates
  Contact
  Donate
──────────────────
Services List
Blog / Updates List
Team Members
Testimonials
Gallery
──────────────────
Contact Submissions
```

From each page section you manage the content of that specific page for that charity. Simple forms, no complex CMS.

---

## TENANT / CHARITY DATA (Company Details)

All stored in the tenants table. One row per charity. Fields:

- name
- domain
- tagline
- email
- phone
- address
- logo
- favicon
- primary_color
- secondary_color
- theme_id (1 to 5)
- facebook, instagram, twitter, linkedin, youtube
- donate_url (external donation link)
- status
- meta_title, meta_description (global SEO fallback)

This single table drives the entire branding of each charity website.

---

## PUBLIC WEBSITE PAGES

Every charity website has these pages. All static Blade templates — no dynamic page builder, no complex CMS. Content is managed from simple admin forms per section.

### Home Page Sections (in order)
1. Navbar (logo, nav links, donate button)
2. Hero / Banner (heading, subheading, background image, CTA button)
3. How We Make a Difference (3 columns with icons and text)
4. Stats / Impact Numbers (e.g. 5000 people supported, 10 years, 200 volunteers)
5. About Us Preview (short paragraph + image + link to about page)
6. What We Do / Services (cards linking to services page)
7. Recent Updates / Blog (latest 3 posts)
8. Testimonials (quotes from people helped)
9. Gallery (photo grid)
10. CTA Section (big banner with donate or get involved button)
11. Footer (logo, links, social icons, contact info, copyright)

### About Page Sections
1. Page Header / Banner
2. Our Story / History (text + image)
3. Core Values (icon cards)
4. Impact Stats (same as home or different)
5. Meet The Team (team member cards)
6. CTA Section

### Services / What We Do Page
1. Page Header
2. Services Grid (cards with icon, title, short description)
3. Each service has a detail page (slug based)
4. CTA Section

### Get Involved Page
1. Page Header
2. Ways to get involved (volunteer, donate, fundraise, spread the word)
3. Each section is an anchor link
4. Simple contact/signup CTA per section

### Blog / Updates Page
1. Page Header
2. Blog post grid (title, date, excerpt, image, read more)
3. Single blog post detail page (slug based)

### Contact Page
1. Page Header
2. Contact form (name, email, phone, message, submit)
3. Contact details (address, email, phone)
4. Optional map embed

### Donate Page
1. Simple page that redirects to external donate_url
   OR has embedded donation widget
   OR shows bank details / ways to donate

---

## DATABASE TABLES NEEDED

Keep it simple. Only add tenant_id to existing tables and new simple tables.

### Existing tenants table
Already exists. Just add: favicon, secondary_color, theme_id, address, social links, donate_url, global meta fields.

### New tables to add

**tenant_services**
Each charity has their own services/what they do list.
Fields: id, tenant_id, title, slug, short_description, description, icon, image, order, status

**tenant_posts** (blog/updates)
Fields: id, tenant_id, title, slug, excerpt, content, image, published_at, status

**tenant_team**
Fields: id, tenant_id, name, role, bio, image, order, status

**tenant_testimonials**
Fields: id, tenant_id, name, quote, role, image, order, status

**tenant_gallery**
Fields: id, tenant_id, image, caption, order, status

**tenant_contacts** (form submissions)
Fields: id, tenant_id, name, email, phone, message, is_read, created_at

All tables have tenant_id. Every query adds: ->where('tenant_id', $tenant->id)
That single line is the only code difference between one charity and another.

---

## THEME SYSTEM

### Concept
- 5 different CSS files = 5 different designs
- All 5 CSS files use EXACTLY the same class names
- Only the visual design (colors, fonts, spacing, shapes) differs
- Theme is selected per charity from admin panel (dropdown 1-5)
- Blade templates never change — only CSS changes

### How Theme Loads
In master layout head:
```
<link href="/themes/theme-{{ $tenant->theme_id }}/style.css" rel="stylesheet">
```

That one line loads the entire design for that charity.

### How Colors Work (Primary/Secondary from DB)
Also in master layout, after the theme CSS:
```
<style>
    :root {
        --primary: {{ $tenant->primary_color }};
        --secondary: {{ $tenant->secondary_color }};
    }
</style>
```

Each theme CSS uses var(--primary) and var(--secondary) for buttons, navbar, highlights etc.
So the theme handles the layout and typography, the DB colors handle the brand colors.
This means infinite color combinations per theme.

### Theme Descriptions

**Theme 1 — Modern Corporate**
Clean, professional, sharp corners, solid navbar, business-like typography (Inter or Roboto).
Good for well-established charities.

**Theme 2 — Warm and Friendly**
Rounded corners, soft shadows, warm tones, playful but trustworthy feel (Nunito font).
Good for community charities, children charities.

**Theme 3 — Minimal Clean**
Lots of whitespace, simple typography, thin borders, black/white base with accent color only.
Good for modern charities that want elegant simplicity.

**Theme 4 — Bold and Impactful**
Large bold headings, strong contrast, full-width sections, powerful imagery areas.
Good for charities that want to make a statement.

**Theme 5 — Elegant and Premium**
Serif fonts, dark sections mixed with light, gold/cream accents, refined feel.
Good for established fundraising organisations.

### CSS Classes All Themes Must Style (shared class names)
```
.navbar-tenant
.hero-section
.hero-heading
.hero-subheading
.section-light
.section-dark
.section-heading
.section-subheading
.card-service
.card-team
.card-blog
.card-testimonial
.stat-item
.gallery-grid
.gallery-item
.cta-section
.btn-primary-tenant
.btn-secondary-tenant
.btn-outline-tenant
.footer-tenant
.page-header
.contact-form-wrapper
.social-icons
```

### How to Generate Themes with AI
Give any AI this prompt per theme:

```
Create a complete CSS file for a charity website.
Theme style: [describe the theme from the descriptions above]
Must use Bootstrap 5 as base.
Must define :root variables --primary and --secondary and use var(--primary) and var(--secondary) throughout — do not hardcode these colors.
Must style these exact class names: .navbar-tenant, .hero-section, .hero-heading, .hero-subheading, .section-light, .section-dark, .section-heading, .section-subheading, .card-service, .card-team, .card-blog, .card-testimonial, .stat-item, .gallery-grid, .gallery-item, .cta-section, .btn-primary-tenant, .btn-secondary-tenant, .btn-outline-tenant, .footer-tenant, .page-header, .contact-form-wrapper, .social-icons
Must be fully responsive mobile-first.
Do not use any JavaScript or frontend framework.
Output only the CSS file content.
```

---

## FOLDER STRUCTURE

```
app/
  Http/
    Controllers/
      Admin/
        TenantController.php         (list, add, delete charities)
        CharityManageController.php  (charity details, theme, colors)
        CharityServiceController.php
        CharityPostController.php
        CharityTeamController.php
        CharityTestimonialController.php
        CharityGalleryController.php
        CharityContactController.php
      TenantSiteController.php       (public charity pages)
    Middleware/
      IdentifyTenant.php
  Models/
    Tenant.php
    TenantService.php
    TenantPost.php
    TenantTeam.php
    TenantTestimonial.php
    TenantGallery.php
    TenantContact.php

resources/views/
  admin/
    charities/
      index.blade.php
      manage/
        layout.blade.php
        details.blade.php
        theme.blade.php
        services/index.blade.php
        services/form.blade.php
        posts/index.blade.php
        posts/form.blade.php
        team/index.blade.php
        testimonials/index.blade.php
        gallery/index.blade.php
        contacts/index.blade.php
  tenant/
    layouts/
      master.blade.php
    partials/
      navbar.blade.php
      footer.blade.php
      cta.blade.php
    home.blade.php
    about.blade.php
    services/
      index.blade.php
      detail.blade.php
    get-involved.blade.php
    blog/
      index.blade.php
      detail.blade.php
    contact.blade.php
    donate.blade.php

public/
  themes/
    theme-1/style.css
    theme-2/style.css
    theme-3/style.css
    theme-4/style.css
    theme-5/style.css
  uploads/
    tenants/
    services/
    posts/
    team/
    gallery/
```

---

## ROUTES STRUCTURE

### Public Routes (tenant websites)
```
GET  /                    home page
GET  /about               about page
GET  /services            services list
GET  /services/{slug}     service detail
GET  /get-involved        get involved page
GET  /blog                blog list
GET  /blog/{slug}         blog post detail
GET  /contact             contact page
POST /contact             contact form submit
GET  /donate              donate page
```

### Admin Routes (your panel)
```
GET/POST  /admin/charities                        list + add
DELETE    /admin/charities/{id}                   delete
POST      /admin/charities/{id}/status            toggle status

GET/POST  /admin/charities/{id}/details           company details
GET/POST  /admin/charities/{id}/theme             theme + colors

GET/POST  /admin/charities/{id}/services          services CRUD
GET/POST  /admin/charities/{id}/posts             blog CRUD
GET/POST  /admin/charities/{id}/team              team CRUD
GET/POST  /admin/charities/{id}/testimonials      testimonials CRUD
GET/POST  /admin/charities/{id}/gallery           gallery CRUD
GET       /admin/charities/{id}/contacts          view form submissions
```

---

## MIDDLEWARE LOGIC

IdentifyTenant middleware runs on every request.
- Strips www from host
- Gets main domain from APP_URL in .env
- If host matches main domain — skip, load admin panel normally
- If host is IP — skip (local testing)
- Otherwise — query tenants table by domain
- If found and active — bind to app() and share with all views
- If not found — continue normally
- Block /login and /register on tenant domains (abort 404)
- Cache tenant lookup by domain for 1 hour (important for scale)

---

## PERFORMANCE FOR 500+ SITES

- Cache tenant DB lookup by domain using Laravel Cache — prevents DB hit on every page load
- Cache services, posts, team per tenant — clear cache when admin updates content
- Use Hostinger Parked Domains for all charity domains pointing to same public_html
- Single DB, all tenants share it with tenant_id isolation
- Lazy load images in gallery
- Set APP_DEBUG=false in production
- Run config:cache, route:cache, view:cache on deploy

---

## WHAT MAKES THIS SCALABLE

- Adding new charity = 1 row in tenants table + park domain on Hostinger + charity updates their DNS
- No new files, no new code, no new server
- All 500 sites run from same codebase, same server, same DB
- Theme change = update one number in DB
- Color change = update hex value in DB
- New blog post = add row to tenant_posts with that charity's tenant_id

---

## EXTRA THINGS TO CONSIDER

- Email notification when contact form submitted (Laravel Mail + queue)
- SSL for each parked domain (Hostinger handles automatically)
- Image optimization on upload (intervention/image package)
- Slugs auto-generated from title on save
- Soft deletes on all content tables
- order column on services, team, gallery for reordering
- is_read flag on contacts with unread count badge in admin sidebar
- Preview button in admin — opens charity domain in new tab
- Clone charity feature — copy one charity setup to new one
- favicon per charity loaded in master layout head

---

## TECH STACK

- Backend: Laravel 11
- Frontend: Bootstrap 5
- Templates: Blade only
- Database: MySQL
- Icons: RemixIcon
- DataTables: Yajra Laravel DataTables
- Image Upload: Laravel storage + intervention/image
- Cache: File cache (upgrade to Redis for heavy traffic)
- No Vue, No React, No Livewire — pure Blade and jQuery Ajax

---

## HOW TO USE THIS FILE WITH AI TOOLS

Give this entire file to Claude, ChatGPT, Cursor, or any AI and say:
"Based on this idea.md, implement [specific part]. We are using Laravel 11, Bootstrap 5, Blade only. The IdentifyTenant middleware already works and injects currentTenant into every request. Every DB query for tenant content must include ->where('tenant_id', $tenant->id)."

### Recommended Build Order
1. Update tenants migration and model with new fields
2. Create new migration tables (services, posts, team, testimonials, gallery, contacts)
3. Build admin charity list page with DataTable
4. Build charity management sidebar layout
5. Build company details form
6. Build theme selector with preview thumbnails
7. Create 5 theme CSS files one at a time using the AI prompt above
8. Build public tenant Blade master layout loading theme CSS and CSS variables
9. Build all public pages (home, about, services, blog, contact, donate, get-involved)
10. Build services CRUD in admin
11. Build blog/posts CRUD in admin
12. Build team, testimonials, gallery CRUD in admin
13. Build contact submissions viewer in admin
14. Add caching to IdentifyTenant middleware
15. Test with multiple parked domains on Hostinger