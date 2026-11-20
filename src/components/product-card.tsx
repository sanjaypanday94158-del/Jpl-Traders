"use client";

import Link from "next/link";
import { Heart, ShoppingCart, Star } from "lucide-react";
import { money } from "@/lib/utils";
import type { Product } from "@/lib/data";

export function ProductCard({ p }: { p: Product }) {
  const discount = Math.round((1 - p.price / p.oldPrice) * 100);

  return (
    <article className="product-card group/card">
      <div className="product-card-media relative mb-2.5 flex aspect-[3/2] items-center justify-center overflow-hidden rounded-lg p-2.5">
        <Link
          href={`/products/${p.slug}`}
          className="absolute inset-0 flex items-center justify-center p-2.5"
          aria-label={`View ${p.name}`}
        >
          <img
            src={p.image}
            alt={p.name}
            className="transition-transform duration-300 group-hover/card:scale-105"
          />
        </Link>
        <span className="absolute left-2.5 top-2.5 rounded-full bg-white px-2.5 py-1 text-[10px] font-extrabold text-[#d94834] shadow-sm ring-1 ring-slate-200/70">
          {discount}% OFF
        </span>
        <button
          type="button"
          aria-label={`Add ${p.name} to wishlist`}
          className="absolute right-2.5 top-2.5 flex h-8 w-8 items-center justify-center rounded-full bg-white text-slate-500 shadow-sm ring-1 ring-slate-200/70 transition-colors hover:text-rose-500"
        >
          <Heart size={16} />
        </button>
      </div>

      <div className="flex flex-1 flex-col">
        <Link href={`/products/${p.slug}`} className="group/name">
          <p className="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400">
            {p.brand} <span className="px-1 text-orange-400">/</span>{" "}
            {p.category}
          </p>
          <h3 className="mt-1 min-h-9 text-xs font-extrabold leading-[18px] text-[#082653] transition-colors group-hover/name:text-[#0757c8]">
            {p.name}
          </h3>
        </Link>

        <div className="mt-0.5 flex items-center gap-1 text-[10px] text-amber-500">
          <Star size={12} fill="currentColor" />
          <span className="font-bold">{p.rating}</span>
          <span className="text-slate-400">(Reviews)</span>
        </div>

        <div className="mt-1.5 flex flex-wrap items-baseline gap-x-2 gap-y-1">
          <span className="price text-sm">{money(p.price)}</span>
          <del className="text-[10px] text-slate-400">{money(p.oldPrice)}</del>
        </div>

        <button
          type="button"
          className="mt-3 flex w-full items-center justify-center gap-2 rounded-md bg-[#0757c8] py-2 text-[11px] font-bold text-white transition-colors hover:bg-[#0648a7]"
        >
          <ShoppingCart size={14} />
          Add to Cart
        </button>
      </div>
    </article>
  );
}
