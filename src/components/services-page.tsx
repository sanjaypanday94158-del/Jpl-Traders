import Link from "next/link";
import {
  ArrowDownRight,
  ArrowRight,
  Building2,
  Database,
  HardDrive,
  Laptop,
  Network,
  Printer,
  ShieldCheck,
  Wrench,
} from "lucide-react";
import { PageHero } from "@/components/page-hero";
import { services } from "@/lib/data";

const serviceDetails: Record<
  string,
  { description: string; icon: typeof Laptop; category: string }
> = {
  "Computer & Laptop Repair": {
    description:
      "Get help diagnosing computer and laptop issues, with repair options discussed around your device and requirements.",
    icon: Laptop,
    category: "Device care",
  },
  "Printer & Photocopier Service": {
    description:
      "Ask about printer and photocopier troubleshooting, servicing and support for your office equipment.",
    icon: Printer,
    category: "Office equipment",
  },
  "AMC & Maintenance": {
    description:
      "Discuss maintenance needs for your computers and office equipment, including the scope that suits your setup.",
    icon: ShieldCheck,
    category: "Ongoing support",
  },
  "Software Installation": {
    description:
      "Get assistance with software installation and setup for your computer or workplace.",
    icon: HardDrive,
    category: "Setup",
  },
  "Data Recovery": {
    description:
      "Talk to the team about data access or recovery concerns and understand available next steps.",
    icon: Database,
    category: "Data assistance",
  },
  "Network Setup": {
    description:
      "Plan connectivity and network equipment needs for your home, office or institution.",
    icon: Network,
    category: "Connectivity",
  },
  "Bulk IT Supply": {
    description:
      "Share your organisation’s product list or quantity needs to discuss a suitable IT supply enquiry.",
    icon: Building2,
    category: "Business & institutions",
  },
  "On-site Support": {
    description:
      "Ask whether on-site support is available for your location and the issue you need help with.",
    icon: Wrench,
    category: "Local assistance",
  },
};

const steps = [
  {
    number: "01",
    title: "Share your requirement",
    description:
      "Tell us about the device, equipment or IT setup you need help with.",
  },
  {
    number: "02",
    title: "Discuss the options",
    description:
      "Our team can discuss suitable products or support based on your enquiry.",
  },
  {
    number: "03",
    title: "Confirm the details",
    description:
      "Availability, service scope and pricing can be confirmed directly with the store.",
  },
];

export function ServicesPage() {
  return (
    <>
      <PageHero
        title="Professional IT Services"
        subtitle="Repair, maintenance, software installation and office IT support."
        image="/banners/services-banner.png"
      />

      <main className="overflow-hidden bg-[#f5f8fc]">
        <section className="shell pb-14 pt-10 sm:pb-20 sm:pt-14">
          <div className="relative mb-8 overflow-hidden rounded-[28px] border border-[#174477] bg-[linear-gradient(118deg,#061d43_0%,#082653_56%,#0757c8_100%)] px-6 py-7 text-white shadow-[0_20px_48px_rgba(8,38,83,0.2)] sm:mb-10 sm:px-9 sm:py-9">
            <div
              aria-hidden="true"
              className="absolute -right-12 -top-24 h-64 w-64 rounded-full border-[30px] border-white/[0.06]"
            />
            <div
              aria-hidden="true"
              className="absolute bottom-0 left-0 h-1 w-32 bg-[linear-gradient(90deg,#ff7915_0%,#ffb347_55%,transparent_100%)]"
            />
            <div className="relative grid gap-7 lg:grid-cols-[1fr_0.9fr] lg:items-end">
              <div className="max-w-2xl">
                <p className="inline-flex items-center gap-2 rounded-full border border-orange-200/20 bg-orange-300/10 px-3 py-1.5 text-[9px] font-black uppercase tracking-[0.2em] text-orange-200">
                  <span className="h-1.5 w-1.5 rounded-full bg-[#ff7915]" />
                  Support for your technology
                </p>
                <h2 className="mt-4 text-2xl font-black leading-tight tracking-[-0.03em] sm:text-3xl">
                  Practical help for devices, offices and IT needs.
                </h2>
                <p className="mt-3 max-w-xl text-sm leading-6 text-blue-100/75">
                  Explore the kinds of services you can enquire about. Contact
                  our team to confirm availability, service coverage and scope.
                </p>
              </div>
              <div className="grid gap-2 sm:grid-cols-3 lg:grid-cols-1">
                {[
                  { label: "Home", icon: Laptop },
                  { label: "Office", icon: Printer },
                  { label: "Institution", icon: Building2 },
                ].map(({ label, icon: Icon }) => (
                  <div
                    key={label}
                    className="flex items-center gap-3 rounded-xl border border-white/10 bg-white/[0.07] px-3.5 py-3 backdrop-blur-sm"
                  >
                    <span className="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10 text-orange-200">
                      <Icon size={16} />
                    </span>
                    <span className="text-[10px] font-extrabold uppercase tracking-[0.13em] text-blue-50">
                      {label} solutions
                    </span>
                    <ArrowRight size={13} className="ml-auto text-blue-200/60" />
                  </div>
                ))}
              </div>
            </div>
          </div>

          <section className="mb-9 grid overflow-hidden rounded-[30px] border border-[#dce6f2] bg-white shadow-[0_22px_55px_rgba(8,38,83,0.14)] lg:grid-cols-[1.08fr_0.92fr]">
            <div className="relative min-h-[310px] overflow-hidden bg-[#082653] p-3 sm:min-h-[390px] sm:p-4">
              <img
                src="/banners/repair.jpg"
                alt="Technician working on computer hardware"
                className="absolute inset-3 h-[calc(100%-1.5rem)] w-[calc(100%-1.5rem)] rounded-[22px] object-cover transition-transform duration-700 hover:scale-[1.03] sm:inset-4 sm:h-[calc(100%-2rem)] sm:w-[calc(100%-2rem)] sm:rounded-[24px]"
              />
              <div className="absolute inset-3 rounded-[22px] bg-[linear-gradient(180deg,rgba(8,38,83,0.02)_30%,rgba(8,38,83,0.84)_100%)] sm:inset-4 sm:rounded-[24px]" />
              <div
                aria-hidden="true"
                className="absolute left-0 top-10 h-24 w-1 rounded-r-full bg-[#ff7915] sm:top-14"
              />
              <div className="absolute bottom-8 left-8 right-32 text-white sm:bottom-10 sm:left-10">
                <span className="inline-flex rounded-full border border-white/25 bg-[#082653]/65 px-3 py-1.5 text-[9px] font-black uppercase tracking-[0.16em] backdrop-blur">
                  Care for your technology
                </span>
                <p className="mt-3 max-w-sm text-xl font-black leading-tight sm:text-2xl">
                  Thoughtful support, from setup to service.
                </p>
              </div>
              <div className="absolute bottom-5 right-5 h-[92px] w-[112px] rotate-3 overflow-hidden rounded-2xl border-4 border-white shadow-[0_12px_30px_rgba(0,0,0,0.3)] sm:bottom-7 sm:right-7 sm:h-[116px] sm:w-[142px]">
                <img
                  src="/shop/jpl-shop-3.png"
                  alt="JPL TRADERS storefront"
                  className="h-full w-full object-cover"
                />
              </div>
            </div>

            <div className="relative flex flex-col justify-center overflow-hidden bg-[linear-gradient(145deg,#ffffff_0%,#f7faff_70%,#fff5eb_100%)] p-6 sm:p-9 lg:p-10">
              <div
                aria-hidden="true"
                className="absolute -right-16 -top-16 h-48 w-48 rounded-full border-[24px] border-white"
              />
              <div
                aria-hidden="true"
                className="absolute bottom-0 right-0 h-1 w-24 bg-[#ff7915]"
              />
              <div className="relative">
                <p className="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-[#0757c8]">
                  <span className="h-px w-7 bg-[#ff7915]" />
                  Local service enquiries
                </p>
                <h3 className="mt-4 max-w-md text-2xl font-black leading-tight tracking-[-0.03em] text-[#082653] sm:text-3xl">
                  Get help that starts with your needs.
                </h3>
                <p className="mt-4 max-w-lg text-sm leading-6 text-slate-600">
                  From a device that needs attention to equipment for your
                  workplace, tell us what you’re looking for. Our team can
                  discuss the next steps and confirm what’s available.
                </p>
                <Link
                  href="/contact"
                  className="mt-6 inline-flex w-fit items-center gap-2 rounded-lg bg-[#0757c8] px-4 py-3 text-xs font-extrabold text-white shadow-[0_8px_20px_rgba(7,87,200,0.2)] transition-all hover:-translate-y-0.5 hover:bg-[#082653]"
                >
                  Talk to our team <ArrowRight size={15} />
                </Link>
              </div>
              <div className="relative mt-7 flex flex-wrap gap-2 border-t border-slate-100 pt-5">
                {["Repair & maintenance", "Office IT", "Supply enquiries"].map(
                  (label) => (
                    <span
                      key={label}
                      className="rounded-full bg-[#f3f7fc] px-3 py-1.5 text-[10px] font-bold text-[#365477]"
                    >
                      {label}
                    </span>
                  ),
                )}
              </div>
            </div>
          </section>

          <div className="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            {services.map((title, index) => {
              const { description, icon: Icon, category } =
                serviceDetails[title];
              return (
                <article
                  key={title}
                  className="group relative flex min-h-[260px] flex-col overflow-hidden rounded-2xl border border-[#dce6f2] bg-white p-5 shadow-[0_8px_24px_rgba(8,38,83,0.05)] transition-all duration-300 hover:-translate-y-1 hover:border-[#b8cdea] hover:shadow-[0_18px_36px_rgba(8,38,83,0.12)] sm:p-6"
                >
                  <span
                    aria-hidden="true"
                    className="absolute right-4 top-1 text-6xl font-black tracking-tighter text-[#f1f5fa] transition-colors group-hover:text-[#e8f0fb]"
                  >
                    {String(index + 1).padStart(2, "0")}
                  </span>
                  <div className="relative flex items-center justify-between">
                    <span className="flex h-12 w-12 items-center justify-center rounded-2xl bg-[linear-gradient(145deg,#eaf2ff,#f7faff)] text-[#0757c8] ring-1 ring-[#dce8f8] transition-colors group-hover:bg-[#0757c8] group-hover:text-white">
                      <Icon size={21} strokeWidth={1.8} />
                    </span>
                    <span className="rounded-full bg-[#fff4e9] px-2.5 py-1 text-[9px] font-extrabold uppercase tracking-wide text-[#c45b0b]">
                      {category}
                    </span>
                  </div>
                  <h3 className="mt-6 max-w-[15rem] text-base font-black leading-snug text-[#082653]">
                    {title}
                  </h3>
                  <p className="mt-2 text-xs leading-5 text-slate-600">
                    {description}
                  </p>
                  <Link
                    href="/contact"
                    className="mt-auto inline-flex w-fit items-center gap-2 pt-5 text-xs font-extrabold text-[#0757c8]"
                  >
                    Ask about this service
                    <ArrowDownRight
                      size={15}
                      className="transition-transform group-hover:translate-x-0.5 group-hover:translate-y-0.5"
                    />
                  </Link>
                  <span
                    aria-hidden="true"
                    className="absolute bottom-0 left-0 h-1 w-0 bg-[linear-gradient(90deg,#0757c8_0%,#0757c8_68%,#ff7915_68%,#ff7915_100%)] transition-all duration-300 group-hover:w-full"
                  />
                </article>
              );
            })}
          </div>
        </section>

        <section className="relative overflow-hidden bg-[#082653] py-12 text-white sm:py-16">
          <div
            aria-hidden="true"
            className="absolute -left-20 -top-36 h-80 w-80 rounded-full border-[36px] border-white/[0.04]"
          />
          <div className="shell relative">
            <div className="max-w-2xl">
              <p className="text-[10px] font-black uppercase tracking-[0.2em] text-orange-300">
                A simple way to get started
              </p>
              <h2 className="mt-2 text-2xl font-black tracking-tight sm:text-3xl">
                From first question to next step.
              </h2>
            </div>
            <div className="mt-8 grid gap-4 md:grid-cols-3">
              {steps.map(({ number, title, description }) => (
                <article
                  key={number}
                  className="rounded-2xl border border-white/10 bg-white/[0.06] p-5 sm:p-6"
                >
                  <p className="text-xs font-black tracking-[0.16em] text-orange-300">
                    STEP {number}
                  </p>
                  <h3 className="mt-4 text-base font-extrabold">{title}</h3>
                  <p className="mt-2 text-xs leading-5 text-blue-100/70">
                    {description}
                  </p>
                </article>
              ))}
            </div>
            <div className="mt-8 flex flex-col gap-4 rounded-2xl border border-white/10 bg-white/[0.07] p-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
              <div>
                <h3 className="text-lg font-black">
                  Need help choosing where to start?
                </h3>
                <p className="mt-1 text-xs leading-5 text-blue-100/70">
                  Send us your question or request a quotation from our team.
                </p>
              </div>
              <div className="flex flex-wrap gap-3">
                <Link
                  href="/contact"
                  className="inline-flex items-center gap-2 rounded-lg bg-[#ff7915] px-4 py-3 text-xs font-extrabold !text-white transition-colors hover:bg-[#e85f0b]"
                >
                  Contact us <ArrowRight size={15} />
                </Link>
                <Link
                  href="/quote"
                  className="inline-flex items-center gap-2 rounded-lg border border-white/20 px-4 py-3 text-xs font-extrabold text-white transition-colors hover:bg-white/10"
                >
                  Request a quote <ArrowRight size={15} />
                </Link>
              </div>
            </div>
          </div>
        </section>
      </main>
    </>
  );
}
