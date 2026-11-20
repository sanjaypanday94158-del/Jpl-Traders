import Link from "next/link";
import { ArrowRight } from "lucide-react";

type PageHeroProps = {
  title: string;
  subtitle: string;
  image: string;
  tag?: string;
};

export function PageHero({
  title,
  subtitle,
  image,
  tag = "JPL TRADERS · AZAMGARH",
}: PageHeroProps) {
  if (image.endsWith("-banner.png")) {
    return (
      <section className="relative w-full overflow-hidden bg-[#082653]">
        <h1 className="sr-only">{title}</h1>
        <img src={image} alt={title} className="block h-auto w-full" />
        <div className="absolute bottom-2 right-2 flex max-w-[calc(100%-1rem)] items-center gap-2 rounded-xl border border-white/20 bg-[#082653]/90 px-2.5 py-2 text-white shadow-xl backdrop-blur sm:bottom-5 sm:right-[4%] sm:gap-5 sm:px-5 sm:py-3.5">
          <p className="hidden max-w-48 text-xs font-semibold leading-5 text-blue-50 sm:block">
            Have a requirement? Talk it through with our team.
          </p>
          <Link
            href="/contact"
            className="inline-flex shrink-0 items-center gap-2 rounded-lg bg-[#ff7915] px-3 py-2.5 text-[11px] font-extrabold !text-white shadow-[0_6px_16px_rgba(255,121,21,0.28)] transition-colors hover:bg-[#e85f0b] sm:px-4 sm:py-3 sm:text-xs"
          >
            Contact us <ArrowRight size={14} />
          </Link>
        </div>
      </section>
    );
  }

  return (
    <section className="page-hero min-h-[220px] sm:min-h-[260px]" style={{ backgroundImage: `url('${image}')` }}>
      <div className="shell relative z-10 py-9 sm:py-12">
        <p className="mb-2 text-[10px] font-black tracking-[.2em] text-orange-300 sm:mb-3 sm:text-xs">
          {tag}
        </p>
        <h1 className="max-w-2xl text-3xl font-black leading-tight sm:text-4xl md:text-5xl">
          {title}
        </h1>
        <p className="mt-3 max-w-xl text-sm leading-6 text-blue-100 sm:mt-4 sm:text-base">
          {subtitle}
        </p>
      </div>
    </section>
  );
}
