import Link from "next/link";
import { ArrowRight, Mail, MapPin, Phone } from "lucide-react";
import { FormUI } from "@/components/info-pages";
import { PageHero } from "@/components/page-hero";

const locationQuery = "Sidhari, Azamgarh, Uttar Pradesh";
const mapUrl = `https://maps.google.com/maps?q=${encodeURIComponent(locationQuery)}&z=14&output=embed`;
const directionsUrl = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(locationQuery)}`;

export function ContactPage() {
  return (
    <>
      <PageHero
        title="Contact Us"
        subtitle="Get in touch with JPL TRADERS for products, service and institutional requirements."
        image="/banners/contact-banner.png"
      />

      <main className="bg-[linear-gradient(180deg,#f4f8fd_0%,#ffffff_72%)]">
        <div className="shell py-10 sm:py-14">
          <div className="grid items-stretch gap-6 lg:grid-cols-[0.85fr_1.15fr]">
            <section className="relative isolate overflow-hidden rounded-3xl bg-[#082653] p-6 text-white shadow-[0_22px_55px_rgba(8,38,83,0.2)] sm:p-8">
              <div
                aria-hidden="true"
                className="absolute -right-16 -top-20 -z-10 h-64 w-64 rounded-full border-[28px] border-white/[0.06]"
              />
              <div
                aria-hidden="true"
                className="absolute bottom-0 left-0 h-1 w-32 bg-[linear-gradient(90deg,#0757c8_0%,#0757c8_65%,#ff7915_65%,#ff7915_100%)]"
              />
              <p className="text-[10px] font-black uppercase tracking-[0.2em] text-orange-300">
                Contact JPL TRADERS
              </p>
              <h3 className="mt-3 max-w-sm text-2xl font-black leading-tight sm:text-3xl">
                Let’s find the right solution together.
              </h3>
              <p className="mt-3 max-w-md text-sm leading-6 text-blue-100/80">
                Our team can help with computers, office equipment, repairs and
                institutional enquiries.
              </p>

              <div className="mt-7 space-y-3">
                <div className="flex items-start gap-3 rounded-xl border border-white/10 bg-white/[0.06] p-4">
                  <MapPin className="mt-0.5 shrink-0 text-orange-300" size={18} />
                  <div>
                    <p className="text-xs font-extrabold">Visit our store</p>
                    <p className="mt-1 text-xs leading-5 text-blue-100/75">
                      Sidhari, Azamgarh, Uttar Pradesh
                    </p>
                  </div>
                </div>
                <div className="flex items-start gap-3 rounded-xl border border-white/10 bg-white/[0.06] p-4">
                  <Phone className="mt-0.5 shrink-0 text-orange-300" size={18} />
                  <div>
                    <p className="text-xs font-extrabold">Call our team</p>
                    <p className="mt-1 text-xs leading-5 text-blue-100/75">
                      Contact number to be confirmed
                    </p>
                  </div>
                </div>
                <div className="flex items-start gap-3 rounded-xl border border-white/10 bg-white/[0.06] p-4">
                  <Mail className="mt-0.5 shrink-0 text-orange-300" size={18} />
                  <div>
                    <p className="text-xs font-extrabold">Email us</p>
                    <p className="mt-1 text-xs leading-5 text-blue-100/75">
                      Email address to be confirmed
                    </p>
                  </div>
                </div>
              </div>

              <Link
                href="/quote"
                className="mt-6 inline-flex items-center gap-2 rounded-lg bg-[#ff7915] px-4 py-3 text-xs font-extrabold !text-white shadow-[0_8px_20px_rgba(255,121,21,0.22)] transition-colors hover:bg-[#e85f0b]"
              >
                Request a quotation <ArrowRight size={15} />
              </Link>
            </section>

            <FormUI kind="contact" />
          </div>

          <section className="mt-8 overflow-hidden rounded-3xl border border-[#dce6f2] bg-white shadow-[0_16px_44px_rgba(8,38,83,0.1)]">
            <div className="flex flex-col gap-4 border-b border-slate-100 p-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
              <div>
                <p className="text-[10px] font-black uppercase tracking-[0.18em] text-[#0757c8]">
                  Find us
                </p>
                <h3 className="mt-1 text-lg font-black text-[#082653]">
                  Visit JPL TRADERS in Sidhari
                </h3>
                <p className="mt-1 text-xs text-slate-500">
                  {locationQuery}
                </p>
              </div>
              <a
                href={directionsUrl}
                target="_blank"
                rel="noreferrer"
                className="inline-flex w-fit items-center gap-2 rounded-lg border border-[#d8e4f2] bg-[#f7faff] px-4 py-2.5 text-xs font-extrabold text-[#0757c8] transition-colors hover:bg-blue-50"
              >
                Get directions <ArrowRight size={14} />
              </a>
            </div>
            <iframe
              title="Google Map showing Sidhari, Azamgarh"
              src={mapUrl}
              className="block h-[280px] w-full border-0 sm:h-[360px]"
              loading="lazy"
              referrerPolicy="no-referrer-when-downgrade"
            />
          </section>
        </div>
      </main>
    </>
  );
}
