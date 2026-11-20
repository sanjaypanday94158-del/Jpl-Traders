import Link from "next/link";
import { ArrowRight } from "lucide-react";
import { Catalog } from "@/components/catalog";

export default function Products() {
  return (
    <>
      <div className="relative w-full overflow-hidden bg-[#082653]">
        <img
          src="/banners/products-banner.png"
          alt="JPL Traders computers and IT products"
          className="product-banner opacity-90"
        />
        <div className="absolute bottom-3 right-3 flex max-w-[calc(100%-1.5rem)] items-center gap-3 rounded-xl border border-white/20 bg-[#082653]/90 px-4 py-3 text-white shadow-xl backdrop-blur sm:bottom-5 sm:right-[4%] sm:max-w-none sm:gap-5 sm:px-5 sm:py-3.5">
          <p className="max-w-40 text-[11px] font-semibold leading-4 text-blue-50 sm:max-w-48 sm:text-xs sm:leading-5">
            Have a requirement? Talk it through with our team.
          </p>
          <Link
            href="/contact"
            className="inline-flex shrink-0 items-center gap-2 rounded-lg bg-[#ff7915] px-3.5 py-2.5 text-xs font-extrabold text-white shadow-[0_6px_16px_rgba(255,121,21,0.28)] transition-colors hover:bg-[#e85f0b] sm:px-4 sm:py-3"
          >
            Contact us <ArrowRight size={14} />
          </Link>
        </div>
      </div>
      <Catalog />
    </>
  );
}