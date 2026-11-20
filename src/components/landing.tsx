import Link from "next/link";
import {
  ArrowRight,
  Building2,
  Copy,
  Cpu,
  HardDrive,
  Headphones,
  Laptop,
  MapPin,
  Monitor,
  Printer,
  Wifi,
  Wrench,
} from "lucide-react";
import {
  HeroCarousel,
  PromoMarquee,
  TrustStrip,
} from "@/components/hero-carousel";
import { ProductCard } from "@/components/product-card";
import { ScrollReveal } from "@/components/scroll-reveal";
import { categories, products } from "@/lib/data";

const icons = [Laptop, Monitor, Monitor, Printer, Copy, Headphones, Wifi, Cpu];

export function Landing() {
  return (
    <main>
      <HeroCarousel />
      <PromoMarquee />
      <ScrollReveal className="shell">
        <TrustStrip />
        <section className="mt-11" data-scroll-reveal>
          <div className="mb-5">
            <div>
              <h2 className="text-2xl font-bold tracking-tight text-[#08285a] md:text-[28px]">
                Shop by Category
              </h2>
              <div className="mt-2.5 h-[3px] w-24 rounded-full bg-gradient-to-r from-[#0757c8] via-[#3479d2] to-[#ff7915]" />
            </div>
          </div>
          <div className="grid grid-cols-2 gap-3 sm:grid-cols-4 lg:grid-cols-8">
            {categories.map((category, index) => {
              const Icon = icons[index];
              return (
                <Link
                  href="/products"
                  key={category}
                  className="surface group relative flex min-h-36 flex-col items-center justify-center gap-3 overflow-hidden rounded-2xl border-[#dbe4ef] p-3 text-xs font-semibold text-slate-700 shadow-[0_2px_5px_rgba(8,40,90,0.04),0_6px_14px_rgba(8,40,90,0.06)] transition duration-300 hover:-translate-y-1 hover:border-[#dbe4ef] hover:shadow-[0_8px_14px_-8px_rgba(8,40,90,0.16),0_16px_30px_-14px_rgba(7,87,200,0.24)]"
                >
                  <span aria-hidden="true" className="absolute inset-0 bg-gradient-to-br from-blue-50/0 via-white to-orange-50/0 opacity-0 transition-opacity duration-300 group-hover:opacity-100" />
                  <span aria-hidden="true" className="relative flex h-14 w-14 items-center justify-center rounded-2xl border border-blue-100 bg-gradient-to-br from-white via-blue-50 to-blue-100 text-[#0757c8] shadow-[inset_0_1px_0_rgba(255,255,255,0.9),0_5px_14px_rgba(7,87,200,0.12)] transition duration-300 group-hover:scale-110 group-hover:border-blue-200 group-hover:shadow-[0_8px_20px_rgba(7,87,200,0.2)]">
                    <Icon
                      size={27}
                      strokeWidth={1.8}
                      className="relative transition-transform duration-300 group-hover:-rotate-3"
                    />
                    <span className="absolute -right-1 -top-1 h-3 w-3 rounded-full border-2 border-white bg-orange-400 shadow-sm" />
                  </span>
                  <span className="relative text-center leading-tight transition-colors group-hover:text-[#0757c8]">{category}</span>
                </Link>
              );
            })}
          </div>
        </section>

        <section className="mt-7 grid gap-4 md:grid-cols-2" data-scroll-reveal>
          <Link
            href="/services"
            className="group relative flex min-h-64 flex-col justify-end overflow-hidden rounded-[26px] border border-blue-950/10 p-6 text-white shadow-[0_16px_40px_-20px_rgba(8,40,90,0.55)] sm:p-8"
          >
            <img src="/banners/repair.jpg" alt="" aria-hidden="true" className="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-105" />
            <span aria-hidden="true" className="absolute inset-0 bg-gradient-to-r from-[#061b42]/95 via-[#082d63]/75 to-[#082d63]/15" />
            <span aria-hidden="true" className="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-[#061b42]/55 to-transparent" />
            <div className="relative z-10 max-w-md">
              <span className="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl border border-white/25 bg-white/15 text-orange-300 shadow-lg backdrop-blur-md transition-transform duration-300 group-hover:-rotate-6 group-hover:scale-105">
                <Wrench size={23} strokeWidth={1.9} />
              </span>
              <p className="mb-2 text-[10px] font-extrabold tracking-[0.22em] text-orange-200">EXPERT CARE FOR YOUR TECH</p>
              <h3 className="text-2xl font-black leading-tight text-white drop-shadow-md sm:text-[28px]">
                Computer Repair &amp;<br className="hidden sm:block" /> Upgrade Services
              </h3>
              <p className="mt-2 max-w-sm text-sm leading-6 text-blue-50/90">
                Hardware · Software · Data Recovery · AMC
              </p>
              <span className="mt-5 inline-flex items-center gap-2 rounded-full border border-white/30 bg-[#08285a]/65 px-4 py-2.5 text-xs font-extrabold text-white shadow-lg backdrop-blur-md transition-all duration-300 group-hover:gap-3 group-hover:bg-white group-hover:text-[#08285a]">
                Book a Service <ArrowRight size={15} />
              </span>
            </div>
          </Link>
          <Link
            href="/institutional"
            className="group relative flex min-h-64 flex-col justify-end overflow-hidden rounded-[26px] border border-blue-950/10 p-6 text-white shadow-[0_16px_40px_-20px_rgba(8,40,90,0.55)] sm:p-8"
          >
            <img src="/banners/institutional.jpg" alt="" aria-hidden="true" className="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-105" />
            <span aria-hidden="true" className="absolute inset-0 bg-gradient-to-r from-[#061b42]/95 via-[#082d63]/75 to-[#082d63]/15" />
            <span aria-hidden="true" className="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-[#061b42]/55 to-transparent" />
            <div className="relative z-10 max-w-md">
              <span className="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-2xl border border-white/25 bg-white/15 text-orange-300 shadow-lg backdrop-blur-md transition-transform duration-300 group-hover:rotate-6 group-hover:scale-105">
                <Building2 size={23} strokeWidth={1.9} />
              </span>
              <p className="mb-2 text-[10px] font-extrabold tracking-[0.22em] text-orange-200">SOLUTIONS THAT SCALE WITH YOU</p>
              <h3 className="text-2xl font-black leading-tight text-white drop-shadow-md sm:text-[28px]">
                Bulk Supply &amp;<br className="hidden sm:block" /> Institutional Solutions
              </h3>
              <p className="mt-2 max-w-sm text-sm leading-6 text-blue-50/90">
                Computers · Printers · Office Equipment
              </p>
              <span className="mt-5 inline-flex items-center gap-2 rounded-full border border-white/30 bg-[#08285a]/65 px-4 py-2.5 text-xs font-extrabold text-white shadow-lg backdrop-blur-md transition-all duration-300 group-hover:gap-3 group-hover:bg-white group-hover:text-[#08285a]">
                Get a Quote <ArrowRight size={15} />
              </span>
            </div>
          </Link>
        </section>

        <section className="mt-11" data-scroll-reveal>
          <div className="mb-5 flex flex-wrap items-end justify-between gap-4">
            <div>
              <h2 className="text-2xl font-bold tracking-tight text-[#08285a] md:text-[28px]">
                Featured Products
              </h2>
              <div className="mt-2.5 h-[3px] w-24 rounded-full bg-gradient-to-r from-[#0757c8] via-[#3479d2] to-[#ff7915]" />
            </div>
            <Link
              href="/products"
              className="group inline-flex items-center gap-2 rounded-full border border-blue-100 bg-[#08285a] px-4 py-2.5 text-xs font-extrabold shadow-[0_6px_18px_rgba(8,40,90,0.2)] transition-all duration-200 hover:-translate-y-0.5 hover:border-blue-600 hover:bg-[#0757c8] hover:shadow-[0_9px_22px_rgba(7,87,200,0.28)]"
            >
              <span className="text-white">View all products</span>
              <ArrowRight
                size={15}
                className="text-white transition-transform duration-200 group-hover:translate-x-1"
              />
            </Link>
          </div>
          <div className="grid grid-cols-2 gap-3 lg:grid-cols-4">
            {products.map((product) => (
              <ProductCard key={product.id} p={product} />
            ))}
          </div>
        </section>

        <section
          className="group/store mt-11 grid overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-[0_12px_36px_-26px_rgba(8,40,90,0.4)] md:grid-cols-[1.12fr_1fr]"
          data-scroll-reveal
        >
          <div className="relative min-h-64 overflow-hidden md:min-h-[370px]">
            <img
              src="/shop/jpl-store-showcase.png"
              alt="JPL TRADERS store interior with computer equipment and customer counter"
              className="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover/store:scale-[1.03]"
            />
            <div aria-hidden="true" className="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-[#061b42]/55 to-transparent" />
            <span className="absolute bottom-5 left-5 text-xs font-semibold tracking-wide text-white drop-shadow-md">
              Inside JPL TRADERS
            </span>
          </div>
          <div className="flex flex-col justify-center p-7 sm:p-9 lg:p-12">
            <div>
              <p className="text-xs font-bold uppercase tracking-[0.14em] text-[#0757c8]">
                Visit us in Sidhari
              </p>
              <h2 className="mt-3 max-w-md text-3xl font-bold leading-tight tracking-tight text-[#082653] sm:text-[34px]">
                Find the right tech, in person.
              </h2>
              <p className="mt-4 max-w-lg text-[15px] leading-7 text-slate-600">
                Browse computers, printers and office equipment at JPL TRADERS.
                Our team can help you compare options and choose what works for
                you.
              </p>
              <div className="mt-5 flex items-center gap-2 border-t border-slate-100 pt-4 text-sm font-medium text-slate-600">
                <MapPin size={17} className="shrink-0 text-orange-500" />
                <span>Sidhari, Azamgarh, Uttar Pradesh</span>
              </div>
            </div>
            <div className="mt-7 flex flex-wrap items-center gap-x-5 gap-y-3">
              <Link href="/about" className="primary">
                About JPL TRADERS <ArrowRight size={16} />
              </Link>
              <Link
                href="/contact"
                className="text-sm font-bold text-[#0757c8] transition-colors hover:text-orange-600"
              >
                Contact us
              </Link>
            </div>
          </div>
        </section>

        <section
          className="relative mt-11 grid gap-6 overflow-hidden rounded-2xl border border-[#173f78] bg-gradient-to-r from-[#082653] via-[#0b3470] to-[#082653] p-6 text-white shadow-[0_18px_42px_-28px_rgba(8,38,83,0.65)] sm:p-8 md:grid-cols-[1fr_auto] md:items-center md:gap-10 md:p-10"
          data-scroll-reveal
        >
          <span
            aria-hidden="true"
            className="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-orange-300 via-[#ff7915] to-orange-500"
          />
          <div className="pl-2 sm:pl-3">
            <p className="text-[11px] font-bold uppercase tracking-[0.16em] text-orange-300">
              Business &amp; institutional supply
            </p>
            <h2 className="mt-2 text-2xl font-bold leading-tight tracking-tight text-white sm:text-[28px]">
              Need computers or office equipment in bulk?
            </h2>
            <p className="mt-2 max-w-2xl text-sm leading-6 text-blue-100">
              Tell us what you need and request a customised quotation for your
              business or institution.
            </p>
          </div>
          <Link
            href="/quote"
            className="primary group w-fit shrink-0"
          >
            Request a Quote
            <ArrowRight
              size={16}
              className="transition-transform group-hover:translate-x-1"
            />
          </Link>
        </section>
      </ScrollReveal>
    </main>
  );
}
