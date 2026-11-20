"use client";
import { useEffect, useState } from "react";
import Image from "next/image";
import {
  ChevronLeft,
  ChevronRight,
  Building2,
  Headphones,
  MapPin,
  Wrench,
} from "lucide-react";
import { heroSlides } from "@/lib/data";

export function HeroCarousel() {
  const [i, setI] = useState(0);

  useEffect(() => {
    const carouselTimer = window.setInterval(
      () => setI((current) => (current + 1) % heroSlides.length),
      6000,
    );
    return () => window.clearInterval(carouselTimer);
  }, []);

  const slide = heroSlides[i];

  return (
    <section
      aria-label="Featured offers carousel"
      className="hero"
    >
      {heroSlides.map((item, index) => (
        <Image
          key={item.image}
          src={item.image}
          alt=""
          fill
          sizes="100vw"
          priority={index === 0}
          loading={index === 0 ? "eager" : "lazy"}
          className={`pointer-events-none z-0 object-fill transition-opacity duration-500 ${
            index === i ? "opacity-100" : "opacity-0"
          }`}
        />
      ))}
      <div className="absolute bottom-5 left-1/2 z-10 flex -translate-x-1/2 items-center gap-2 rounded-full border border-white/30 bg-slate-950/35 px-3 py-2 shadow-lg backdrop-blur-md md:bottom-7">
        {heroSlides.map((item, index) => (
          <button
            key={item.image}
            aria-label={`Show banner ${index + 1}`}
            onClick={() => setI(index)}
            className={`h-2.5 rounded-full border border-white/60 shadow-sm transition-all duration-300 ${
              index === i
                ? "w-9 bg-orange-500 shadow-[0_0_10px_rgba(249,115,22,0.85)]"
                : "w-2.5 bg-white/70 hover:bg-white"
            }`}
          />
        ))}
      </div>
      <button
        aria-label="Previous banner"
        onClick={() => setI((i + heroSlides.length - 1) % heroSlides.length)}
        className="absolute left-3 top-1/2 z-10 hidden -translate-y-1/2 rounded-full border border-white/50 bg-gradient-to-br from-blue-600 via-blue-700 to-orange-500 p-2 text-white shadow-lg shadow-blue-950/30 transition hover:scale-105 md:block"
      >
        <ChevronLeft />
      </button>
      <button
        aria-label="Next banner"
        onClick={() => setI((i + 1) % heroSlides.length)}
        className="absolute right-3 top-1/2 z-10 hidden -translate-y-1/2 rounded-full border border-white/50 bg-gradient-to-br from-orange-500 via-orange-600 to-blue-700 p-2 text-white shadow-lg shadow-blue-950/30 transition hover:scale-105 md:block"
      >
        <ChevronRight />
      </button>
    </section>
  );
}

const marqueeItems = [
  "Computers, Laptops & Accessories",
  "Printer & Photocopier Sales",
  "Repair & Servicing",
  "Office Equipment & IT Solutions",
  "Government & Institutional Supply",
];

export function PromoMarquee() {
  return (
    <section
      aria-label="JPL Traders products and services"
      className="promo-marquee"
    >
      <p className="sr-only">{marqueeItems.join(" • ")}</p>
      <div className="promo-marquee-track" aria-hidden="true">
        {[0, 1].map((copy) => (
          <div className="promo-marquee-group" key={copy}>
            {marqueeItems.map((item) => (
              <span className="promo-marquee-item" key={item}>
                <span className="promo-marquee-dot" />
                {item}
              </span>
            ))}
          </div>
        ))}
      </div>
    </section>
  );
}

const trustHighlights = [
  {
    icon: MapPin,
    title: "Your local IT store",
    description: "Visit JPL Traders in Sidhari, Azamgarh.",
  },
  {
    icon: Building2,
    title: "Office-ready solutions",
    description: "Computers, printers, photocopiers and more.",
  },
  {
    icon: Wrench,
    title: "Service that stays",
    description: "Repair, maintenance and on-site support.",
  },
  {
    icon: Headphones,
    title: "Made for your needs",
    description: "Talk to our team about business and bulk orders.",
  },
];

export function TrustStrip() {
  return (
    <section
      aria-label="Why choose JPL Traders"
      className="mt-5 grid gap-3 sm:grid-cols-2 lg:mt-6 lg:grid-cols-4"
    >
      {trustHighlights.map(({ icon: Icon, title, description }, index) => (
        <article
          key={title}
          className="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-blue-200 hover:shadow-lg"
        >
          <div className="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-blue-700 via-blue-500 to-orange-400" />
          <div className="flex items-center justify-between">
            <span className="relative flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-[#0a55b7] via-[#1768c7] to-[#ff7915] text-white shadow-[0_8px_18px_rgba(10,76,163,0.24)] ring-4 ring-blue-50 transition duration-300 group-hover:-rotate-3 group-hover:scale-110 group-hover:shadow-[0_10px_22px_rgba(255,121,21,0.32)] after:absolute after:-right-1 after:-top-1 after:h-3.5 after:w-3.5 after:rounded-full after:border-2 after:border-white after:bg-amber-300">
              <Icon size={23} strokeWidth={2.4} />
            </span>
            <span className="text-xs font-black tracking-widest text-slate-300">
              0{index + 1}
            </span>
          </div>
          <h2 className="mt-4 text-sm font-extrabold text-[#08285a]">
            {title}
          </h2>
          <p className="mt-1.5 text-xs leading-5 text-slate-500">
            {description}
          </p>
        </article>
      ))}
    </section>
  );
}
