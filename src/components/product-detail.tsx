"use client";

import { useState } from "react";
import Link from "next/link";
import {
  CheckCircle2,
  Minus,
  Plus,
  ShieldCheck,
  ShoppingCart,
  Star,
  Truck,
} from "lucide-react";
import type { Product } from "@/lib/data";
import { money } from "@/lib/utils";

export function ProductDetail({ p }: { p: Product }) {
  const [quantity, setQuantity] = useState(1);

  return (
    <main className="shell py-6 sm:py-8">
      <nav
        aria-label="Breadcrumb"
        className="mb-4 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs leading-5 text-slate-500 sm:mb-6"
      >
        <Link href="/" className="hover:text-[#0757c8]">
          Home
        </Link>
        <span aria-hidden="true">/</span>
        <Link href="/products" className="hover:text-[#0757c8]">
          Products
        </Link>
        <span aria-hidden="true">/</span>
        <span className="min-w-0 break-words text-slate-700">{p.name}</span>
      </nav>

      <div className="surface grid gap-5 p-4 sm:gap-8 sm:p-6 md:grid-cols-2 md:gap-9">
        <div className="flex min-h-[250px] items-center justify-center rounded-2xl bg-slate-50 p-4 sm:min-h-80 sm:p-6">
          <img
            src={p.image}
            alt={p.name}
            className="max-h-[400px] w-full object-contain"
          />
        </div>

        <div className="min-w-0 py-1 sm:py-2">
          <p className="text-[10px] font-bold uppercase tracking-[0.14em] text-blue-700 sm:text-xs sm:tracking-widest">
            {p.brand} · {p.category}
          </p>
          <h1 className="mt-2 text-2xl font-black leading-tight text-[#082653] sm:mt-3 sm:text-3xl">
            {p.name}
          </h1>
          <p className="mt-3 flex flex-wrap items-center gap-2 text-sm text-amber-500">
            <Star size={16} fill="currentColor" />
            {p.rating}
            <span className="text-slate-400">Customer rating (demo)</span>
          </p>

          <div className="mt-5 flex flex-wrap items-baseline gap-x-3 gap-y-1 sm:mt-6">
            <strong className="text-2xl text-red-600 sm:text-3xl">
              {money(p.price)}
            </strong>
            <del className="text-sm text-slate-400">{money(p.oldPrice)}</del>
          </div>
          <p className="mt-4 text-sm leading-6 text-slate-600 sm:mt-5">
            {p.description}
          </p>

          <div className="mt-5 space-y-2 text-xs leading-5 text-slate-700 sm:text-sm">
            {[
              "Product information and specifications",
              "Availability to be confirmed with store",
              "Warranty details on enquiry",
            ].map((item) => (
              <p className="flex items-start gap-2" key={item}>
                <CheckCircle2
                  size={17}
                  className="mt-0.5 shrink-0 text-green-600"
                />
                <span>{item}</span>
              </p>
            ))}
          </div>

          <div className="mt-6 flex flex-wrap items-center gap-3 sm:mt-7">
            <div className="flex h-11 items-center gap-3 rounded-lg border px-3">
              <button
                type="button"
                aria-label="Decrease quantity"
                onClick={() => setQuantity((current) => Math.max(1, current - 1))}
                className="flex h-8 w-8 items-center justify-center rounded-md text-slate-600 hover:bg-slate-100"
              >
                <Minus size={16} />
              </button>
              <span className="min-w-4 text-center text-sm font-bold">
                {quantity}
              </span>
              <button
                type="button"
                aria-label="Increase quantity"
                onClick={() => setQuantity((current) => current + 1)}
                className="flex h-8 w-8 items-center justify-center rounded-md text-slate-600 hover:bg-slate-100"
              >
                <Plus size={16} />
              </button>
            </div>
            <button
              type="button"
              className="secondary min-h-11 flex-1 sm:flex-none"
            >
              <ShoppingCart size={17} /> Add to Cart
            </button>
            <Link
              href="/quote"
              className="primary min-h-11 flex-1 sm:flex-none"
            >
              Buy / Enquire
            </Link>
          </div>

          <div className="mt-6 grid grid-cols-2 gap-3 border-t pt-4 text-[11px] text-slate-600 sm:mt-7 sm:flex sm:gap-5 sm:pt-5 sm:text-xs">
            <span className="flex items-center gap-2">
              <Truck size={18} className="shrink-0" /> Supply support
            </span>
            <span className="flex items-center gap-2">
              <ShieldCheck size={18} className="shrink-0" /> Product guidance
            </span>
          </div>
        </div>
      </div>
    </main>
  );
}
