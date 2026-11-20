import Link from "next/link";
import {
  ArrowRight,
  Building2,
  Laptop,
  MapPin,
  Printer,
  Wrench,
} from "lucide-react";
import { ScrollReveal } from "@/components/scroll-reveal";

const offerings = [
  {
    title: "Computers & accessories",
    accent: "border-blue-300/30 bg-blue-400/15 text-blue-200",
    description:
      "Explore laptops, desktops, components and everyday computer essentials.",
    icon: Laptop,
    href: "/products",
    action: "Explore products",
  },
  {
    title: "Printers & office equipment",
    accent: "border-orange-300/30 bg-orange-400/15 text-orange-200",
    description:
      "Find equipment for home, office and institutional requirements.",
    icon: Printer,
    href: "/products",
    action: "View equipment",
  },
  {
    title: "Repair & maintenance",
    accent: "border-emerald-300/30 bg-emerald-400/15 text-emerald-200",
    description:
      "Talk to our team about computer, printer and related support needs.",
    icon: Wrench,
    href: "/services",
    action: "See our services",
  },
  {
    title: "Business & bulk enquiries",
    accent: "border-violet-300/30 bg-violet-400/15 text-violet-200",
    description:
      "Share your organisation’s requirements and ask us about a quotation.",
    icon: Building2,
    href: "/quote",
    action: "Discuss a requirement",
  },
];

export function AboutPage() {
  return (
    <main className="overflow-hidden">
      <section className="relative w-full overflow-hidden bg-[#082653]">
        <h1 className="sr-only">
          About JPL TRADERS — your trusted computer and IT solutions partner
        </h1>
        <img
          src="/banners/about-banner.png"
          alt="JPL TRADERS: trusted technology and IT solutions, including computers, repair and maintenance, office equipment, and institutional supply"
          className="block h-auto w-full"
        />
        <div className="absolute bottom-5 right-[4%] hidden items-center gap-5 rounded-xl border border-white/20 bg-[#082653]/90 px-5 py-3.5 text-white shadow-xl backdrop-blur sm:flex">
          <p className="max-w-48 text-xs font-semibold leading-5 text-blue-50">
            Have a requirement? Talk it through with our team.
          </p>
          <Link href="/contact" className="primary shrink-0">
            Contact us <ArrowRight size={15} />
          </Link>
        </div>
      </section>

      <ScrollReveal className="shell">
        <section className="pt-12 sm:pt-14" data-scroll-reveal>
          <div className="mb-7 border-b border-slate-200 pb-5">
            <h2 className="max-w-2xl text-2xl font-black leading-[1.15] tracking-[-0.025em] text-[#082653] sm:text-3xl">
              Technology support. Made dependable.
            </h2>
            <span
              aria-hidden="true"
              className="mt-4 block h-[3px] w-24 rounded-full bg-[linear-gradient(90deg,#0757c8_0%,#0757c8_68%,#ff7915_68%,#ff7915_100%)]"
            />
          </div>

          <div className="relative overflow-hidden rounded-2xl border border-white/10 bg-[#082653] shadow-[0_18px_44px_rgba(8,38,83,0.14)]">
            <div
              aria-hidden="true"
              className="absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgba(147,197,253,0.22)_1px,transparent_1.5px)] [background-size:20px_20px]"
            />
            <div
              aria-hidden="true"
              className="absolute -right-24 -top-32 h-80 w-80 rounded-full bg-blue-400/10 blur-3xl"
            />
            <img
              src="/banners/jpl-about-store.png"
              alt="JPL TRADERS computer and electronics store"
              className="absolute inset-0 h-full w-full object-cover opacity-75"
            />
            <div className="absolute inset-0 bg-[linear-gradient(90deg,rgba(5,24,57,0.95)_0%,rgba(5,24,57,0.82)_62%,rgba(5,24,57,0.4)_100%)]" />
            <div
              aria-hidden="true"
              className="absolute inset-x-0 bottom-0 h-1 bg-[#ff7915]"
            />

            <div className="relative grid sm:grid-cols-2 lg:grid-cols-4">
              {offerings.map(
                ({ title, description, icon: Icon, href, action, accent }) => (
                  <article
                    key={title}
                    className="group relative flex min-h-[245px] flex-col border-b border-white/10 px-5 py-6 transition-colors duration-300 last:border-b-0 sm:border-r sm:px-6 lg:min-h-[260px]"
                  >
                    <div className="flex items-center justify-between">
                      <span
                        className={`flex h-11 w-11 items-center justify-center rounded-xl border shadow-[inset_0_1px_0_rgba(255,255,255,0.16)] ${accent}`}
                      >
                        <Icon size={19} strokeWidth={1.7} />
                      </span>
                    </div>
                    <h3 className="mt-6 max-w-[15rem] text-[15px] font-extrabold leading-snug text-white">
                      {title}
                    </h3>
                    <p className="mt-2 max-w-[15rem] text-[12px] leading-5 text-blue-100/70">
                      {description}
                    </p>
                    <Link
                      href={href}
                      className="mt-auto inline-flex w-fit items-center gap-2 rounded-lg border border-[#61a6ff]/50 bg-[linear-gradient(135deg,#0757c8_0%,#0c74df_72%,#0e84ef_100%)] px-4 py-3 text-xs font-extrabold !text-white shadow-[0_10px_24px_rgba(7,87,200,0.28),inset_0_1px_0_rgba(255,255,255,0.22)] transition-all hover:-translate-y-0.5 hover:border-[#a6cff8]"
                    >
                      <span className="!text-white" style={{ color: "#ffffff" }}>
                        {action}
                      </span>
                      <ArrowRight
                        size={14}
                        className="text-white transition-transform group-hover:translate-x-1"
                        style={{ color: "#ffffff" }}
                      />
                    </Link>
                  </article>
                ),
              )}
            </div>
          </div>
        </section>

        <section
          className="grid gap-8 border-slate-200 pb-10 pt-12 lg:grid-cols-[1.05fr_0.95fr] lg:items-stretch lg:gap-10 lg:pb-12 lg:pt-14"
          data-scroll-reveal
        >
          <div className="relative aspect-[3/4] overflow-hidden rounded-2xl border-[5px] border-white bg-[#082653] shadow-[0_24px_70px_rgba(8,38,83,0.2)] ring-1 ring-slate-200/80 sm:rounded-3xl">
            <img
              src="/shop/jpl-about-poster.png"
              alt="JPL TRADERS — trusted computer and IT solution partner"
              className="absolute inset-0 h-full w-full object-fill"
            />
          </div>

          <div className="relative flex min-h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-[#f8fafc] shadow-[0_18px_55px_rgba(8,38,83,0.11)] sm:rounded-3xl">
            <div
              aria-hidden="true"
              className="h-1.5 w-full bg-[linear-gradient(90deg,#082653_0%,#0757c8_72%,#f36c13_72%,#f36c13_100%)]"
            />
            <div className="flex flex-1 flex-col px-5 pb-5 pt-7 sm:px-8 sm:pb-7 sm:pt-8 lg:px-9">
              <div className="flex items-center justify-between border-b border-slate-200 pb-5">
                <p className="text-[10px] font-black uppercase tracking-[0.19em] text-[#0757c8]">
                  About JPL TRADERS
                </p>
              </div>

              <h2 className="mt-6 max-w-md text-2xl font-black leading-[1.16] tracking-[-0.025em] text-[#082653] sm:text-[1.75rem]">
                Computer and IT solutions,{" "}
                <span className="text-[#0757c8]">locally in Azamgarh.</span>
              </h2>

              <p className="mt-5 max-w-xl border-l-2 border-orange-500 pl-4 text-[13px] leading-6 text-slate-600 sm:text-sm sm:leading-7">
                JPL TRADERS is a computer and electronics store in Sidhari,
                serving individuals, businesses and institutions with product
                guidance and practical technology support.
              </p>

              <div className="mt-6 grid gap-px overflow-hidden rounded-xl border border-slate-200 bg-slate-200 sm:grid-cols-3">
                {[
                  ["Computers", "Laptops, desktops & accessories"],
                  ["Office", "Printers & workplace equipment"],
                  ["Support", "Repair & supply assistance"],
                ].map(([title, detail]) => (
                  <div key={title} className="bg-white px-4 py-4">
                    <p className="text-xs font-extrabold text-[#082653]">
                      {title}
                    </p>
                    <p className="mt-1 text-[11px] leading-5 text-slate-500">
                      {detail}
                    </p>
                  </div>
                ))}
              </div>

              <div className="mt-6 grid gap-5 border-t border-slate-200 pt-5 sm:grid-cols-2">
                <p className="text-[12px] leading-6 text-slate-600">
                  Whether you need a system for daily use, office equipment or
                  support for an existing device, our team helps you review the
                  available options.
                </p>
                <p className="text-[12px] leading-6 text-slate-600">
                  Stock and service availability may vary. We confirm the details
                  with the store so you can make an informed decision.
                </p>
              </div>

              <div className="pt-6">
                <Link
                  href="/contact"
                  className="flex w-full items-center justify-between rounded-lg bg-[#ff7915] px-5 py-3.5 text-sm font-extrabold !text-white shadow-[0_10px_24px_rgba(243,108,19,0.22)] transition-colors hover:bg-[#e85f0b]"
                >
                  <span className="text-sm font-extrabold !text-white">
                    Discuss your requirement
                  </span>
                  <span className="flex h-8 w-8 items-center justify-center rounded-lg bg-white/20 text-white">
                    <ArrowRight size={16} />
                  </span>
                </Link>
              </div>
              <div className="mt-5 flex items-center gap-2 border-t border-slate-200 pt-4 text-[11px] font-bold text-slate-500">
                <MapPin size={14} className="text-orange-500" />
                <span>Sidhari, Azamgarh</span>
              </div>
            </div>
          </div>
        </section>

        <section className="pb-16 sm:pb-20" data-scroll-reveal>
          <div className="relative overflow-hidden rounded-2xl border border-[#dce6f2] bg-[linear-gradient(135deg,#f8fbff_0%,#edf4fc_68%,#fff5eb_100%)] px-6 py-8 shadow-[0_16px_44px_rgba(8,38,83,0.08)] sm:px-9 sm:py-9 lg:px-11">
            <div
              aria-hidden="true"
              className="pointer-events-none absolute -right-14 -top-20 h-64 w-64 rounded-full border-[28px] border-white/80"
            />
            <div
              aria-hidden="true"
              className="pointer-events-none absolute bottom-0 left-0 h-1 w-28 bg-[linear-gradient(90deg,#0757c8_0%,#0757c8_68%,#ff7915_68%,#ff7915_100%)]"
            />
            <div className="relative flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
              <div className="max-w-2xl">
                <p className="text-[10px] font-black uppercase tracking-[0.2em] text-[#0757c8]">
                  Let’s find a good fit
                </p>
                <h2 className="mt-2 text-xl font-black tracking-[-0.025em] text-[#082653] sm:text-2xl">
                  Tell us what you’re looking for.
                </h2>
                <p className="mt-2 text-[13px] leading-6 text-slate-600">
                  Have a product question, service need or bulk requirement?
                  Start a conversation with our team.
                </p>
              </div>
              <Link
                href="/contact"
                className="inline-flex w-fit shrink-0 items-center gap-3 rounded-lg bg-[#0757c8] px-5 py-3.5 text-xs font-extrabold !text-white shadow-[0_10px_24px_rgba(7,87,200,0.22)] transition-all hover:-translate-y-0.5 hover:bg-[#082653]"
              >
                <span className="!text-white">Contact JPL TRADERS</span>
                <span className="flex h-7 w-7 items-center justify-center rounded-md bg-white/12">
                  <ArrowRight size={15} />
                </span>
              </Link>
            </div>
          </div>
        </section>
      </ScrollReveal>
    </main>
  );
}
