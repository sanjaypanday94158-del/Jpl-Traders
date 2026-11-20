# JPL TRADERS — Complete Frontend UI

Responsive multipage Next.js storefront and admin dashboard based on the supplied reference UI and real shop photographs from JPL TRADERS, Sidhari, Azamgarh.

## Tech stack

- Next.js App Router + TypeScript
- Tailwind CSS v4
- shadcn/ui-compatible components and `components.json` configuration
- Lucide React
- **UI only**: no API routes, database, Razorpay integration, or session authentication

## Setup

```bash
npm install
npm run dev
```

Visit http://localhost:3000 for the storefront and http://localhost:3000/admin for the admin UI.

## Project structure

```
JPL-Traders-NextJS-UI/
├── public/
│   ├── banners/       # Custom-made hero and page banners
│   └── shop/          # Three real user-supplied shop photos
├── src/
│   ├── app/
│   │   ├── (shop)/     # Public storefront routes
│   │   ├── (backoffice)/admin/ # Admin routes and UI-only login
│   │   ├── globals.css
│   │   └── layout.tsx
│   ├── components/     # Reusable components and UI primitives
│   │   └── ui/
│   └── lib/            # Demo products and helpers
├── components.json
└── package.json
```

## Storefront pages

Home (`/`), Products (`/products`), Product Detail (`/products/[slug]`), Cart (`/cart`), Checkout (`/checkout`), Services (`/services`), Institutional/Government Supply (`/institutional`), About (`/about`), Contact (`/contact`), FAQ (`/faq`), Payment (`/payment`), Quote (`/quote`), Login (`/login`), Register (`/register`), Order Tracking (`/orders`).

## Admin pages

`/admin`, `/admin/login`, `/admin/products`, `/admin/orders`, `/admin/customers`, `/admin/enquiries`, `/admin/services`, `/admin/tenders`, `/admin/categories`, `/admin/reports`, `/admin/settings`.

## Carousel

Three original shop photos have been redesigned as full-width promotional hero images under `public/banners/hero-*.jpg`, with automatic rotation, previous/next arrows and dot controls. Additional custom banners for gadgets, repair, office equipment and institutional supply are included.

## Frontend-only limitations

- All product prices, names, sales metrics, reviews and admin records are **sample data**.
- Cart, wishlist, search, forms, payment, order tracking and admin CRUD are **UI demonstrations**; some actions are placeholders and no data is persisted to a backend.
- Admin pages are **not protected**. Implement server-side session verification and authorization before deploying.
- Replace demo product images with licensed real product images and confirm business phone, email, hours, availability, pricing, tender claims and payment methods.
- Install any additional shadcn/ui primitives with the shadcn CLI as needed; included primitives are shadcn-compatible, not the entire component library.

