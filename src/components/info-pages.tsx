"use client";

import Link from "next/link";
import { useState } from "react";
import {
  ArrowRight,
  Building2,
  CheckCircle2,
  ChevronDown,
  CreditCard,
  HardDrive,
  Headphones,
  Mail,
  MapPin,
  Minus,
  Monitor,
  Phone,
  Plus,
  Printer,
  ShieldCheck,
  Wifi,
  Wrench,
} from "lucide-react";
import { PageHero } from "@/components/page-hero";
import { products, services } from "@/lib/data";
import { money } from "@/lib/utils";

const pageMeta: Record<string, [string, string, string]> = {
  services: [
    "Professional IT Services",
    "Repair, maintenance, software installation and office IT support.",
    "/banners/services-banner.png",
  ],
  institutional: [
    "Government & Institutional Supply",
    "Computers, office equipment, networking and bulk supply enquiries.",
    "/banners/institutional-banner.png",
  ],
  about: [
    "About JPL TRADERS",
    "Discover our Sidhari store and our computer and electronics solutions.",
    "/banners/hero-store.jpg",
  ],
  contact: [
    "Contact Us",
    "Get in touch with JPL TRADERS for products, service and institutional requirements.",
    "/banners/hero-store.jpg",
  ],
  faq: [
    "Frequently Asked Questions",
    "Find answers about our products, repairs, payments and institutional enquiries.",
    "/banners/gadgets.jpg",
  ],
  payment: [
    "Payment Options",
    "Explore payment methods and checkout information.",
    "/banners/printers.jpg",
  ],
  quote: [
    "Request a Quotation",
    "Tell us about your products, service or bulk purchase requirements.",
    "/banners/institutional.jpg",
  ],
  cart: [
    "Shopping Cart",
    "Review your items and continue to checkout.",
    "/banners/gadgets.jpg",
  ],
  login: [
    "Login to JPL TRADERS",
    "Access your orders and account details.",
    "/banners/gadgets.jpg",
  ],
  register: [
    "Create Your Account",
    "Join JPL TRADERS and enjoy an easier shopping experience.",
    "/banners/gadgets.jpg",
  ],
  orders: [
    "Track Your Order",
    "Check the status of your order using your order information.",
    "/banners/hero-office.jpg",
  ],
  checkout: [
    "Checkout & Payment",
    "Review delivery information and payment options.",
    "/banners/printers.jpg",
  ],
};

const serviceIcons = [
  Wrench,
  Printer,
  Headphones,
  Monitor,
  HardDrive,
  Wifi,
  Building2,
  Headphones,
];

export function FormUI({ kind }: { kind: string }) {
  const [done, setDone] = useState(false);

  return (
    <div className="surface mx-auto w-full max-w-3xl p-4 sm:p-6 md:p-8">
      <h2 className="mb-5 text-xl font-black">
        {kind === "quote" ? "Tell us your requirements" : "Send us a message"}
      </h2>
      {done ? (
        <div className="rounded-xl bg-blue-50 p-5 text-center sm:p-7">
          <CheckCircle2
            className="mx-auto mb-3 text-green-600"
            size={36}
          />
          <h3 className="font-black">Demo form submitted</h3>
          <p className="mt-2 text-sm text-slate-600">
            Connect this UI to your own Next.js backend to receive submissions.
          </p>
          <button
            className="secondary mt-4"
            onClick={() => setDone(false)}
          >
            Send another
          </button>
        </div>
      ) : (
        <form
          onSubmit={(event) => {
            event.preventDefault();
            setDone(true);
          }}
          className="grid gap-4 md:grid-cols-2"
        >
          <label className="text-xs font-bold">
            Full Name
            <input required className="input mt-2" placeholder="Your name" />
          </label>
          <label className="text-xs font-bold">
            Phone Number
            <input required className="input mt-2" placeholder="Mobile number" />
          </label>
          <label className="text-xs font-bold">
            Email Address
            <input
              type="email"
              className="input mt-2"
              placeholder="Email"
            />
          </label>
          <label className="text-xs font-bold">
            Enquiry Type
            <select className="input mt-2">
              <option>Product enquiry</option>
              <option>Repair / AMC</option>
              <option>Institutional supply</option>
              <option>Bulk quotation</option>
            </select>
          </label>
          <label className="text-xs font-bold md:col-span-2">
            Your Message
            <textarea
              required
              className="input mt-2 min-h-32"
              placeholder="Describe your requirement"
            />
          </label>
          <button type="submit" className="primary w-fit">
            Submit Enquiry <ArrowRight size={16} />
          </button>
        </form>
      )}
    </div>
  );
}

function CartUI() {
  const [quantities, setQuantities] = useState([1, 1]);
  const total =
    products[0].price * quantities[0] + products[4].price * quantities[1];

  function updateQuantity(index: number, change: number) {
    setQuantities((current) =>
      current.map((quantity, currentIndex) =>
        currentIndex === index
          ? Math.max(1, quantity + change)
          : quantity,
      ),
    );
  }

  return (
    <div className="grid gap-4 sm:gap-6 md:grid-cols-[1fr_320px]">
      <div className="surface p-4 sm:p-5">
        {[products[0], products[4]].map((product, index) => (
          <div
            key={product.id}
            className="flex flex-wrap items-center gap-3 border-b py-4 last:border-b-0 sm:flex-nowrap sm:gap-4"
          >
            <img
              src={product.image}
              alt={product.name}
              className="h-16 w-20 shrink-0 object-contain sm:h-20 sm:w-24"
            />
            <div className="min-w-0 flex-1 basis-[calc(100%-6rem)] sm:basis-auto">
              <b className="line-clamp-2 text-sm leading-5">{product.name}</b>
              <p className="mt-2 text-sm font-black text-red-600">
                {money(product.price)}
              </p>
            </div>
            <div className="ml-auto flex h-10 items-center gap-2 rounded-lg border px-2.5">
              <button
                type="button"
                aria-label={`Decrease ${product.name} quantity`}
                onClick={() => updateQuantity(index, -1)}
              >
                <Minus size={14} />
              </button>
              <b className="min-w-4 text-center text-sm">
                {quantities[index]}
              </b>
              <button
                type="button"
                aria-label={`Increase ${product.name} quantity`}
                onClick={() => updateQuantity(index, 1)}
              >
                <Plus size={14} />
              </button>
            </div>
          </div>
        ))}
      </div>

      <div className="surface h-fit p-4 sm:p-5">
        <h3 className="text-lg font-black">Order Summary</h3>
        <div className="mt-5 flex justify-between text-sm">
          <span>Subtotal</span>
          <b>{money(total)}</b>
        </div>
        <div className="mt-3 flex justify-between text-sm">
          <span>Delivery</span>
          <b className="text-green-600">Calculated later</b>
        </div>
        <div className="mt-5 flex justify-between border-t pt-4 font-black">
          <span>Total</span>
          <span>{money(total)}</span>
        </div>
        <Link className="primary mt-5 w-full" href="/checkout">
          Proceed to Checkout
        </Link>
      </div>
    </div>
  );
}

export function InfoPage({ kind }: { kind: string }) {
  const [title, subtitle, image] = pageMeta[kind] || pageMeta.about;

  return (
    <>
      {kind === "contact" ? (
        <PageHero
          title={title}
          subtitle={subtitle}
          image="/banners/contact-banner.png"
        />
      ) : kind === "about" ? (
        <div className="w-full overflow-hidden bg-[#082653]">
          <img
            src="/banners/about-banner.png"
            alt="About JPL TRADERS"
            className="block h-auto w-full"
          />
        </div>
      ) : (
        <PageHero title={title} subtitle={subtitle} image={image} />
      )}

      <main className="shell py-7 sm:py-10">
        {kind === "services" && (
          <div className="grid gap-3 sm:grid-cols-2 sm:gap-4 lg:grid-cols-4">
            {services.map((service, index) => {
              const Icon = serviceIcons[index];
              return (
                <article className="surface p-5 sm:p-6" key={service}>
                  <div className="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                    <Icon size={25} />
                  </div>
                  <h3 className="font-extrabold">{service}</h3>
                  <p className="mt-2 text-xs leading-5 text-slate-500">
                    Professional solutions and product support for home,
                    office and institutional requirements.
                  </p>
                  <Link
                    href="/quote"
                    className="mt-5 inline-flex items-center gap-2 text-xs font-bold text-blue-700"
                  >
                    Request service <ArrowRight size={15} />
                  </Link>
                </article>
              );
            })}
          </div>
        )}

        {kind === "about" && (
          <div className="grid items-center gap-6 sm:gap-8 md:grid-cols-2">
            <div className="grid grid-cols-2 gap-3">
              <img
                className="col-span-2 aspect-[16/10] w-full rounded-2xl object-cover sm:aspect-[2/1]"
                src="/shop/jpl-shop-3.png"
                alt="JPL TRADERS storefront"
              />
              <img
                className="aspect-[4/3] w-full rounded-xl object-cover"
                src="/shop/jpl-shop-1.png"
                alt="JPL shop shelves"
              />
              <img
                className="aspect-[4/3] w-full rounded-xl object-cover"
                src="/shop/jpl-shop-2.png"
                alt="JPL shop interior"
              />
            </div>
            <div>
              <p className="text-xs font-bold tracking-widest text-orange-500">
                OUR REAL STORE
              </p>
              <h2 className="mt-3 text-2xl font-black text-[#082653] sm:text-3xl">
                Your local computer & electronics partner.
              </h2>
              <p className="mt-4 text-sm leading-7 text-slate-600 sm:mt-5">
                JPL TRADERS is an electronics and IT trading business in
                Sidhari, Azamgarh. Our business offers computer-related
                products, office equipment including photocopiers, hardware
                and repair-related services.
              </p>
              <p className="mt-4 text-sm leading-7 text-slate-600">
                We aim to help individuals, businesses and institutions source
                practical technology solutions. Contact the store to confirm
                current products, availability, service options and pricing.
              </p>
              <Link className="primary mt-6" href="/contact">
                Contact Our Team <ArrowRight size={16} />
              </Link>
            </div>
          </div>
        )}

        {kind === "institutional" && (
          <div className="grid items-center gap-6 sm:gap-7 md:grid-cols-2">
            <div>
              <h2 className="text-2xl font-black text-[#082653] sm:text-3xl">
                IT supply for offices & institutions
              </h2>
              <p className="mt-4 text-sm leading-7 text-slate-600">
                Enquire about bulk computers, laptops, office printers,
                photocopiers, networking equipment, setup and technical
                services. Government tender participation and credentials must
                be verified before publishing specific claims.
              </p>
              <div className="mt-5 space-y-3 sm:mt-6">
                {[
                  "Bulk desktop & laptop requirements",
                  "Office equipment and peripherals",
                  "Networking and installation",
                  "Customised institutional quotations",
                ].map((item) => (
                  <p key={item} className="flex items-start gap-2 text-sm">
                    <CheckCircle2
                      size={18}
                      className="mt-0.5 shrink-0 text-green-600"
                    />
                    {item}
                  </p>
                ))}
              </div>
              <Link href="/quote" className="primary mt-6 sm:mt-7">
                Request Institutional Quote <ArrowRight size={16} />
              </Link>
            </div>
            <img
              className="aspect-[16/10] w-full rounded-2xl object-cover sm:aspect-[4/3]"
              src="/banners/institutional.jpg"
              alt="Institutional computer setup"
            />
          </div>
        )}

        {kind === "faq" && (
          <div className="surface mx-auto max-w-4xl divide-y p-4 sm:p-6">
            {[
              "Do you sell laptops and desktops?",
              "Do you repair computers and printers?",
              "Can I enquire about photocopier machines?",
              "Do you support bulk or institutional supply?",
              "What payment methods are available?",
              "How do I request a quotation?",
            ].map((question) => (
              <details key={question} className="group py-4 sm:py-5">
                <summary className="flex cursor-pointer items-start justify-between gap-4 text-sm font-bold">
                  {question}
                  <ChevronDown
                    size={17}
                    className="mt-0.5 shrink-0 transition-transform group-open:rotate-180"
                  />
                </summary>
                <p className="mt-3 text-sm leading-6 text-slate-500">
                  Please contact JPL TRADERS with your specific requirement.
                  Our team can confirm availability, service coverage and
                  applicable terms.
                </p>
              </details>
            ))}
          </div>
        )}

        {(kind === "contact" || kind === "quote") && (
          <div className="grid gap-6 md:grid-cols-[1fr_2fr] md:gap-8">
            <div className="space-y-4 sm:space-y-5">
              <h2 className="text-2xl font-black text-[#082653]">
                We’re here to help
              </h2>
              <p className="flex items-start gap-3 text-sm">
                <MapPin className="mt-0.5 shrink-0 text-blue-700" />
                Sidhari, Azamgarh, Uttar Pradesh
              </p>
              <p className="flex items-start gap-3 text-sm">
                <Phone className="mt-0.5 shrink-0 text-blue-700" />
                Contact number to be confirmed
              </p>
              <p className="flex items-start gap-3 text-sm">
                <Mail className="mt-0.5 shrink-0 text-blue-700" />
                Email address to be confirmed
              </p>
              <img
                src="/shop/jpl-shop-3.png"
                alt="JPL shop front"
                className="aspect-[16/10] w-full rounded-xl object-cover"
              />
            </div>
            <FormUI kind={kind} />
          </div>
        )}

        {kind === "payment" && (
          <div className="grid gap-3 sm:grid-cols-2 sm:gap-4 lg:grid-cols-3">
            {[
              "UPI Payments",
              "Credit & Debit Cards",
              "Net Banking",
              "Bank Transfer",
              "EMI Options",
              "Cash on Delivery",
            ].map((method) => (
              <article className="surface p-5 sm:p-6" key={method}>
                <CreditCard className="mb-4 text-blue-700" size={27} />
                <h3 className="font-extrabold">{method}</h3>
                <p className="mt-2 text-xs leading-5 text-slate-500">
                  Payment availability and eligibility will be confirmed at
                  checkout after Razorpay integration.
                </p>
              </article>
            ))}
          </div>
        )}

        {kind === "cart" && <CartUI />}

        {(kind === "login" || kind === "register") && (
          <div className="surface mx-auto max-w-md p-5 sm:p-7">
            <h2 className="mb-5 text-xl font-black sm:mb-6">
              {kind === "login" ? "Welcome back!" : "Create your account"}
            </h2>
            <form onSubmit={(event) => event.preventDefault()} className="space-y-4">
              {kind === "register" && (
                <input className="input" placeholder="Full Name" />
              )}
              <input className="input" placeholder="Email or Mobile Number" />
              <input
                type="password"
                className="input"
                placeholder="Password"
              />
              <button className="secondary w-full">
                {kind === "login" ? "Login" : "Register"}
              </button>
            </form>
            <p className="mt-4 text-center text-xs text-slate-500">
              {kind === "login" ? (
                <>
                  New user?{" "}
                  <Link className="font-bold text-blue-700" href="/register">
                    Create account
                  </Link>
                </>
              ) : (
                <>
                  Already registered?{" "}
                  <Link className="font-bold text-blue-700" href="/login">
                    Login
                  </Link>
                </>
              )}
            </p>
            <p className="mt-4 text-center text-[11px] text-slate-400">
              Session authentication is not implemented (UI only).
            </p>
          </div>
        )}

        {kind === "checkout" && (
          <div className="grid gap-4 sm:gap-5 md:grid-cols-[2fr_1fr]">
            <FormUI kind="checkout" />
            <div className="surface h-fit p-5 sm:p-6">
              <h2 className="text-lg font-black">Payment Summary</h2>
              <p className="mt-4 text-sm">
                Review your order and choose payment after backend integration.
              </p>
              <div className="mt-5 flex items-center gap-2 text-xs text-slate-500">
                <ShieldCheck size={17} /> Razorpay UI placeholder
              </div>
            </div>
          </div>
        )}

        {kind === "orders" && (
          <div className="surface mx-auto max-w-xl p-5 sm:p-7">
            <h2 className="mb-5 text-xl font-black">Enter your order details</h2>
            <input className="input mb-4" placeholder="Order ID" />
            <input className="input mb-4" placeholder="Email or Mobile" />
            <button className="secondary w-full">Track Order</button>
          </div>
        )}
      </main>
    </>
  );
}
