import Link from "next/link";
import {
  ArrowRight,
  Building2,
  Database,
  HardDrive,
  Laptop,
  MessageSquareText,
  ListChecks,
  BadgeCheck,
  MapPin,
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
      "Ask about troubleshooting and servicing for printers, photocopiers and other office equipment.",
    icon: Printer,
    category: "Office equipment",
  },
  "AMC & Maintenance": {
    description:
      "Discuss ongoing maintenance for your computers and office equipment, with a scope suited to your setup.",
    icon: ShieldCheck,
    category: "Ongoing support",
  },
  "Software Installation": {
    description:
      "Get assistance installing and setting up software for your computer or workplace.",
    icon: HardDrive,
    category: "Setup",
  },
  "Data Recovery": {
    description:
      "Talk to the team about data access or recovery concerns and understand the available next steps.",
    icon: Database,
    category: "Data assistance",
  },
  "Network Setup": {
    description:
      "Plan connectivity and network equipment for your home, office or institution.",
    icon: Network,
    category: "Connectivity",
  },
  "Bulk IT Supply": {
    description:
      "Share your organisation’s product list or quantity needs to discuss an IT supply enquiry.",
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

const servicePalettes = [
  {
    card: "border-blue-200/80 from-blue-50 via-white to-sky-50/70",
    glow: "bg-blue-300/25",
    icon: "from-blue-600 to-sky-500 ring-blue-200",
    tag: "bg-blue-100 text-blue-800",
    link: "text-blue-700",
    bar: "from-blue-600 via-sky-400 to-cyan-300",
  },
  {
    card: "border-violet-200/80 from-violet-50 via-white to-fuchsia-50/70",
    glow: "bg-violet-300/25",
    icon: "from-violet-600 to-fuchsia-500 ring-violet-200",
    tag: "bg-violet-100 text-violet-800",
    link: "text-violet-700",
    bar: "from-violet-600 via-fuchsia-400 to-pink-300",
  },
  {
    card: "border-emerald-200/80 from-emerald-50 via-white to-teal-50/70",
    glow: "bg-emerald-300/25",
    icon: "from-emerald-600 to-teal-500 ring-emerald-200",
    tag: "bg-emerald-100 text-emerald-800",
    link: "text-emerald-700",
    bar: "from-emerald-600 via-teal-400 to-lime-300",
  },
  {
    card: "border-amber-200/80 from-amber-50 via-white to-orange-50/70",
    glow: "bg-amber-300/25",
    icon: "from-amber-500 to-orange-500 ring-amber-200",
    tag: "bg-amber-100 text-amber-800",
    link: "text-amber-700",
    bar: "from-amber-500 via-orange-400 to-yellow-300",
  },
  {
    card: "border-cyan-200/80 from-cyan-50 via-white to-blue-50/70",
    glow: "bg-cyan-300/25",
    icon: "from-cyan-600 to-blue-500 ring-cyan-200",
    tag: "bg-cyan-100 text-cyan-800",
    link: "text-cyan-700",
    bar: "from-cyan-600 via-blue-400 to-sky-300",
  },
  {
    card: "border-indigo-200/80 from-indigo-50 via-white to-purple-50/70",
    glow: "bg-indigo-300/25",
    icon: "from-indigo-600 to-purple-500 ring-indigo-200",
    tag: "bg-indigo-100 text-indigo-800",
    link: "text-indigo-700",
    bar: "from-indigo-600 via-purple-400 to-fuchsia-300",
  },
  {
    card: "border-orange-200/80 from-orange-50 via-white to-rose-50/70",
    glow: "bg-orange-300/25",
    icon: "from-orange-600 to-rose-500 ring-orange-200",
    tag: "bg-orange-100 text-orange-800",
    link: "text-orange-700",
    bar: "from-orange-600 via-rose-400 to-pink-300",
  },
  {
    card: "border-rose-200/80 from-rose-50 via-white to-pink-50/70",
    glow: "bg-rose-300/25",
    icon: "from-rose-600 to-pink-500 ring-rose-200",
    tag: "bg-rose-100 text-rose-800",
    link: "text-rose-700",
    bar: "from-rose-600 via-pink-400 to-fuchsia-300",
  },
];

const supportTypes = [
  {
    label: "Home",
    detail: "Personal devices",
    icon: Laptop,
    tone: "bg-orange-400/15 text-orange-200",
    accent: "bg-[#ff7915]",
  },
  {
    label: "Business",
    detail: "Office equipment",
    icon: Printer,
    tone: "bg-sky-400/15 text-sky-200",
    accent: "bg-sky-400",
  },
  {
    label: "Institution",
    detail: "IT supply needs",
    icon: Building2,
    tone: "bg-emerald-400/15 text-emerald-200",
    accent: "bg-emerald-400",
  },
];

const steps = [
  {
    icon: MessageSquareText,
    tone: "bg-[#ff7915]",
    title: "Tell us what you need",
    description:
      "Share the device, equipment or IT setup you need help with.",
  },
  {
    icon: ListChecks,
    tone: "bg-[#0757c8]",
    title: "Talk through the options",
    description:
      "Our team will discuss suitable products or support for your enquiry.",
  },
  {
    icon: BadgeCheck,
    tone: "bg-[#13835e]",
    title: "Confirm the details",
    description:
      "Check availability, service scope and pricing directly with the store.",
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

      <main className="overflow-hidden bg-[#f5f7fb]">
        <section className="shell pb-14 pt-10 sm:pb-20 sm:pt-14">
          <div className="relative overflow-hidden rounded-[28px] bg-[linear-gradient(115deg,#061d43_0%,#082653_56%,#0757c8_100%)] px-6 py-8 text-white shadow-[0_24px_65px_rgba(8,38,83,0.2)] sm:rounded-[34px] sm:px-10 sm:py-11 lg:px-12">
            <div
              aria-hidden="true"
              className="absolute -right-20 -top-32 h-72 w-72 rounded-full border-[34px] border-white/[0.06]"
            />
            <div
              aria-hidden="true"
              className="absolute -bottom-28 right-[27%] h-56 w-56 rounded-full bg-[#ff7915]/10 blur-3xl"
            />
            <div className="absolute bottom-0 left-0 h-1 w-36 bg-[linear-gradient(90deg,#ff7915,#ffb347,transparent)]" />

            <div className="relative grid gap-9 lg:grid-cols-[1.05fr_0.95fr] lg:items-center lg:gap-14">
              <div>
                <p className="inline-flex items-center gap-2 rounded-full border border-orange-200/20 bg-orange-300/10 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-[0.17em] text-orange-200">
                  <span className="h-1.5 w-1.5 rounded-full bg-[#ff7915]" />
                  Technology support, close to home
                </p>
                <h2 className="mt-5 max-w-xl text-3xl font-black leading-[1.12] tracking-[-0.035em] sm:text-4xl lg:text-[2.8rem]">
                  Practical help for the tech you rely on.
                </h2>
                <p className="mt-4 max-w-lg text-sm leading-6 text-blue-100/80 sm:text-base sm:leading-7">
                  From everyday devices to workplace equipment, find the right
                  kind of support for your requirements.
                </p>
                <Link
                  href="/contact"
                  className="mt-6 inline-flex items-center gap-2 rounded-lg bg-[#ff7915] px-5 py-3 text-sm font-extrabold text-white shadow-[0_10px_24px_rgba(255,121,21,0.25)] transition-all hover:-translate-y-0.5 hover:bg-[#e85f0b]"
                >
                  Tell us what you need <ArrowRight size={16} />
                </Link>
              </div>

              <div className="grid gap-3 sm:grid-cols-3 lg:grid-cols-1">
                {supportTypes.map(
                  ({ label, detail, icon: Icon, tone, accent }) => (
                    <div
                      key={label}
                      className="group/support relative flex items-center gap-4 overflow-hidden rounded-2xl border border-white/10 bg-white/[0.07] p-4 backdrop-blur-sm transition-all hover:-translate-y-0.5 hover:border-white/20 hover:bg-white/[0.12] sm:flex-col sm:items-start lg:flex-row lg:items-center lg:p-4"
                    >
                      <span
                        aria-hidden="true"
                        className={`absolute inset-y-3 left-0 w-1 rounded-r-full ${accent}`}
                      />
                      <span
                        className={`flex h-11 w-11 shrink-0 items-center justify-center rounded-xl ring-1 ring-white/10 ${tone}`}
                      >
                        <Icon size={20} strokeWidth={1.8} />
                      </span>
                      <span className="min-w-0">
                        <span className="block text-sm font-extrabold text-white">
                          {label}
                        </span>
                        <span className="mt-1 block text-xs text-blue-100/65">
                          {detail}
                        </span>
                      </span>
                    </div>
                  ),
                )}
              </div>
            </div>
          </div>

          <div className="mb-7 mt-14 flex flex-col gap-4 sm:mb-9 sm:mt-16 sm:flex-row sm:items-end sm:justify-between">
            <div>
              <h2 className="text-2xl font-black tracking-[-0.03em] text-[#082653] sm:text-3xl">
                Services for your setup.
              </h2>
              <span
                aria-hidden="true"
                className="mt-3 block h-[3px] w-20 rounded-full bg-[linear-gradient(90deg,#0757c8_0%,#0757c8_68%,#ff7915_68%,#ff7915_100%)]"
              />
            </div>
          </div>

          <div className="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            {services.map((title, index) => {
              const { description, icon: Icon, category } =
                serviceDetails[title];
              const palette = servicePalettes[index % servicePalettes.length];
              return (
                <article
                  key={title}
                  className={`group relative flex min-h-[256px] flex-col overflow-hidden rounded-2xl border bg-gradient-to-br p-5 shadow-[0_8px_24px_rgba(8,38,83,0.06)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(8,38,83,0.14)] sm:p-6 ${palette.card}`}
                >
                  <div
                    aria-hidden="true"
                    className={`absolute -right-10 -top-12 h-32 w-32 rounded-full blur-2xl transition-transform duration-500 group-hover:scale-125 ${palette.glow}`}
                  />
                  <div
                    aria-hidden="true"
                    className={`absolute inset-x-0 top-0 h-1 bg-gradient-to-r opacity-80 transition-opacity group-hover:opacity-100 ${palette.bar}`}
                  />
                  <div className="relative flex items-center justify-between gap-2">
                    <span
                      className={`flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br text-white shadow-[0_10px_20px_rgba(8,38,83,0.16)] ring-4 transition-all duration-300 group-hover:-rotate-3 group-hover:scale-110 group-hover:shadow-[0_14px_26px_rgba(8,38,83,0.22)] ${palette.icon}`}
                    >
                      <Icon size={24} strokeWidth={2} />
                    </span>
                    <span
                      className={`rounded-full px-2.5 py-1 text-[9px] font-extrabold uppercase tracking-wide ${palette.tag}`}
                    >
                      {category}
                    </span>
                  </div>

                  <h3 className="relative mt-5 text-base font-black leading-snug text-[#082653]">
                    {title}
                  </h3>
                  <p className="relative mt-2 text-xs leading-5 text-slate-600">
                    {description}
                  </p>
                  <Link
                    href="/contact"
                    className={`relative mt-auto inline-flex w-fit items-center gap-2 pt-5 text-xs font-extrabold ${palette.link}`}
                  >
                    Ask about this service
                    <ArrowRight
                      size={14}
                      className="transition-transform group-hover:translate-x-1"
                    />
                  </Link>
                </article>
              );
            })}
          </div>
        </section>

        <section className="relative overflow-hidden border-y border-[#dce7f5] bg-[#edf4ff] py-12 sm:py-[68px]">
          <div
            aria-hidden="true"
            className="absolute -right-24 -top-32 h-80 w-80 rounded-full border-[34px] border-white/60 sm:-right-16 sm:-top-40 sm:h-[440px] sm:w-[440px]"
          />
          <div
            aria-hidden="true"
            className="absolute bottom-0 left-0 h-1.5 w-28 bg-[#ff7915]"
          />
          <div className="shell relative grid gap-5 lg:grid-cols-[1fr_1fr] lg:items-stretch lg:gap-7">
            <div className="group relative min-h-[330px] overflow-hidden rounded-[24px] bg-[#082653] shadow-[0_22px_50px_rgba(8,38,83,0.2)] sm:min-h-[430px]">
              <img
                src="/banners/repair.jpg"
                alt="Technician carefully repairing computer hardware"
                className="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
              />
              <div className="absolute inset-0 bg-[linear-gradient(180deg,rgba(8,38,83,0.06)_15%,rgba(8,38,83,0.05)_40%,rgba(8,38,83,0.94)_100%)]" />
              <div className="absolute left-5 top-5 flex items-center gap-2 rounded-full border border-white/35 bg-[#082653]/80 px-4 py-2.5 text-[9px] font-extrabold uppercase tracking-[0.15em] text-white shadow-lg backdrop-blur-sm sm:left-7 sm:top-7">
                <span className="h-2 w-2 rounded-full bg-[#ff7915] ring-2 ring-orange-200/50" />
                JPL service desk
              </div>
              <div className="absolute bottom-0 left-0 right-0 p-6 text-white sm:p-8">
                <p className="inline-flex items-center gap-2 rounded-md bg-[#ff7915] px-3 py-1.5 text-[9px] font-extrabold uppercase tracking-[0.13em] text-white">
                  Local expertise
                </p>
                <p className="mt-2 max-w-md text-[26px] font-bold leading-[1.15] tracking-[-0.025em] sm:text-[34px]">
                  We’ll help get your tech back on track.
                </p>
                <div className="mt-5 inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/10 px-3 py-2 text-[11px] font-semibold text-white backdrop-blur-sm">
                  <MapPin size={14} className="text-orange-300" />
                  Sidhari, Azamgarh
                </div>
              </div>
            </div>

            <div className="relative flex flex-col justify-center overflow-hidden rounded-[24px] border border-white bg-white p-6 shadow-[0_18px_46px_rgba(8,38,83,0.09)] sm:p-8 lg:p-9">
              <span
                aria-hidden="true"
                className="absolute right-0 top-0 h-2 w-28 rounded-bl-full bg-[#ff7915]"
              />
              <div
                aria-hidden="true"
                className="absolute -right-9 top-14 h-28 w-28 rounded-full bg-[#fff3e8]"
              />
              <div className="relative">
                <p className="inline-flex items-center gap-2 rounded-full bg-[#eaf2ff] px-3 py-2 text-[9px] font-extrabold uppercase tracking-[0.14em] text-[#0757c8]">
                  <span className="h-1.5 w-1.5 rounded-full bg-[#ff7915]" />
                  Support for every setup
                </p>
                <h2 className="mt-5 max-w-[540px] text-[32px] font-black leading-[1.08] tracking-[-0.04em] text-[#082653] sm:text-[40px]">
                  Good support starts with{" "}
                  <span className="relative inline-block text-[#0757c8] after:absolute after:inset-x-0 after:-bottom-1 after:h-2 after:rounded-full after:bg-[#ff7915]/20">
                    the right conversation.
                  </span>
                </h2>
                <p className="mt-4 max-w-[510px] text-sm leading-6 text-slate-600 sm:text-[15px] sm:leading-7">
                  Tell us what you’re working with and what you need. We’ll help
                  you understand the available options, one step at a time.
                </p>

                <div className="mt-6 grid grid-cols-3 gap-2.5 sm:gap-3">
                  {[
                    {
                      icon: Wrench,
                      title: "Repair",
                      detail: "Devices & equipment",
                      tone: "bg-[#fff1e5] text-[#d75b00]",
                    },
                    {
                      icon: Laptop,
                      title: "Workplace",
                      detail: "Office IT support",
                      tone: "bg-[#eaf2ff] text-[#0757c8]",
                    },
                    {
                      icon: Building2,
                      title: "Supply",
                      detail: "Bulk enquiries",
                      tone: "bg-[#e8f7f1] text-[#13835e]",
                    },
                  ].map(({ icon: Icon, title, detail, tone }) => (
                    <div
                      key={title}
                      className="min-w-0 rounded-xl border border-slate-100 bg-[#fbfcfe] p-3 transition-all duration-200 hover:-translate-y-1 hover:border-slate-200 hover:shadow-md sm:p-3.5"
                    >
                      <span
                        className={`flex h-8 w-8 items-center justify-center rounded-lg ${tone}`}
                      >
                        <Icon size={16} strokeWidth={2} />
                      </span>
                      <p className="mt-2 text-[11px] font-extrabold text-[#082653] sm:text-xs">
                        {title}
                      </p>
                      <p className="mt-1 text-[9px] leading-4 text-slate-500 sm:text-[10px]">
                        {detail}
                      </p>
                    </div>
                  ))}
                </div>

                <div className="mt-6 flex flex-wrap items-center gap-x-4 gap-y-3">
                  <Link
                    href="/contact"
                    className="inline-flex items-center gap-3 rounded-lg bg-[#0757c8] px-5 py-3.5 text-sm font-extrabold text-white shadow-[0_8px_18px_rgba(7,87,200,0.25)] transition-all hover:-translate-y-0.5 hover:bg-[#082653] hover:shadow-[0_12px_24px_rgba(7,87,200,0.3)] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0757c8]"
                  >
                    Talk to our team
                    <ArrowRight size={16} />
                  </Link>
                  <span className="text-[11px] font-medium text-slate-500">
                    We’ll help plan your next step.
                  </span>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section className="shell py-12 sm:py-16">
          <div className="relative overflow-hidden rounded-[28px] border border-slate-200 bg-[linear-gradient(135deg,#fff_0%,#fff_68%,#f2f7ff_100%)] px-6 py-8 text-[#082653] shadow-[0_18px_48px_rgba(8,38,83,0.08)] sm:rounded-[32px] sm:px-9 sm:py-10 lg:px-11">
            <div
              aria-hidden="true"
              className="absolute -right-20 -top-36 h-72 w-72 rounded-full border-[30px] border-blue-50"
            />
            <div className="relative">
              <div className="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                  <p className="inline-flex items-center gap-2 rounded-full bg-orange-50 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.16em] text-[#e9670c]">
                    <span className="h-1.5 w-1.5 rounded-full bg-[#ff7915]" />
                    How it works
                  </p>
                  <h2 className="mt-3 text-2xl font-black tracking-[-0.03em] sm:text-3xl">
                    From first question to next step.
                  </h2>
                </div>
                <p className="max-w-sm text-xs leading-5 text-slate-600 sm:text-right">
                  A straightforward way to discuss your service or supply
                  enquiry.
                </p>
              </div>

              <div className="mt-8 grid gap-3 md:grid-cols-3">
                {steps.map(
                  ({ icon: StepIcon, tone, title, description }, index) => (
                    <article
                      key={title}
                      className="rounded-2xl border border-slate-200 bg-white p-5 shadow-[0_3px_12px_rgba(8,38,83,0.04)] transition-all duration-200 hover:-translate-y-1 hover:border-blue-200 hover:shadow-[0_12px_28px_rgba(8,38,83,0.09)] sm:p-6"
                    >
                      <div className="flex items-center justify-between">
                        <span
                          className={`flex h-11 w-11 items-center justify-center rounded-xl text-white shadow-sm ${tone}`}
                        >
                          <StepIcon size={19} strokeWidth={2} />
                        </span>
                        <span className="text-[10px] font-black tracking-[0.16em] text-slate-300">
                          STEP 0{index + 1}
                        </span>
                      </div>
                      <h3 className="mt-5 text-base font-extrabold text-[#082653]">
                        {title}
                      </h3>
                      <p className="mt-2 text-xs leading-5 text-slate-600">
                        {description}
                      </p>
                    </article>
                  ),
                )}
              </div>

              <div className="mt-6 flex flex-col gap-4 rounded-2xl border border-slate-200 bg-[#f7f9fc] p-5 sm:flex-row sm:items-center sm:justify-between sm:px-7 sm:py-6">
                <div>
                  <h3 className="text-lg font-black text-[#082653]">
                    Ready to discuss your requirement?
                  </h3>
                  <p className="mt-1 text-xs leading-5 text-slate-600">
                    Get in touch or share the details for a quotation.
                  </p>
                </div>
                <div className="flex flex-wrap gap-3">
                  <Link
                    href="/contact"
                    className="inline-flex items-center gap-2 rounded-lg bg-[#ff7915] px-4 py-3 text-xs font-extrabold text-white transition-colors hover:bg-[#e85f0b]"
                  >
                    Contact us <ArrowRight size={15} />
                  </Link>
                  <Link
                    href="/quote"
                    className="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-3 text-xs font-extrabold text-[#082653] transition-colors hover:border-blue-300 hover:bg-blue-50"
                  >
                    Request a quote <ArrowRight size={15} />
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>
    </>
  );
}
