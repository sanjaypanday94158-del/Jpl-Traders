"use client";

import Link from "next/link";
import Image from "next/image";
import { Fragment } from "react";
import { usePathname } from "next/navigation";
import { useEffect, useState } from "react";
import { motion } from "motion/react";
import {
  Clock,
  MapPin,
  Menu,
  Search,
  ShoppingCart,
  X,
} from "lucide-react";
import { Button } from "@/components/ui/button";

const navigation = [
  ["Home", "/"],
  ["Products", "/products"],
  ["About Us", "/about"],
  ["Services", "/services"],
  ["Government Tenders", "/institutional"],
  ["Contact Us", "/contact"],
];

export function SiteHeader() {
  const [now, setNow] = useState<Date | null>(null);
  const [menuOpen, setMenuOpen] = useState(false);
  const pathname = usePathname();

  useEffect(() => {
    const updateTime = () => setNow(new Date());
    updateTime();
    const intervalId = window.setInterval(updateTime, 1_000);
    return () => window.clearInterval(intervalId);
  }, []);

  useEffect(() => {
    setMenuOpen(false);
  }, [pathname]);

  useEffect(() => {
    if (!menuOpen) return;

    const handleKeyDown = (event: KeyboardEvent) => {
      if (event.key === "Escape") setMenuOpen(false);
    };

    document.body.style.overflow = "hidden";
    window.addEventListener("keydown", handleKeyDown);

    return () => {
      document.body.style.overflow = "";
      window.removeEventListener("keydown", handleKeyDown);
    };
  }, [menuOpen]);

  return (
    <>
      <div className="hidden md:block">
        <div className="bg-[#061e45] text-white">
          <div className="shell grid grid-cols-2 items-center gap-x-3 gap-y-1 py-2 text-[11px] md:grid-cols-[1fr_auto_1fr]">
            <span className="flex items-center justify-start gap-2">
              <MapPin size={13} /> Sidhari, Azamgarh, Uttar Pradesh
              <span className="hidden md:inline">
                &nbsp; | &nbsp; Computer & IT Solutions
              </span>
            </span>
            <span className="col-span-2 row-start-2 flex flex-col items-center justify-self-center rounded-lg border border-white/10 bg-white/5 px-3 py-1.5 sm:flex-row md:col-span-1 md:col-start-2 md:row-start-1">
              <span className="flex items-center gap-1.5 font-bold tabular-nums text-white">
                <Clock size={13} className="text-orange-300" />
                {now
                  ? now.toLocaleTimeString("en-IN", {
                      hour: "2-digit",
                      minute: "2-digit",
                      second: "2-digit",
                      hour12: false,
                      timeZone: "Asia/Kolkata",
                    })
                  : "--:--:--"}
              </span>
              <span
                aria-hidden="true"
                className="my-1 h-px w-16 bg-gradient-to-r from-transparent via-orange-200/70 to-transparent sm:mx-3 sm:my-0 sm:h-4 sm:w-px sm:bg-gradient-to-b"
              />
              <span className="whitespace-nowrap text-[10px] font-medium text-blue-100 sm:text-[11px]">
                {now
                  ? now.toLocaleDateString("en-IN", {
                      weekday: "short",
                      day: "numeric",
                      month: "short",
                      year: "numeric",
                      timeZone: "Asia/Kolkata",
                    })
                  : "Loading date"}
              </span>
            </span>
            <span className="col-start-2 row-start-1 flex w-full justify-end text-right md:col-start-3">
              <Link href="/contact" className="ml-auto">
                Help & Support
              </Link>
            </span>
          </div>
        </div>
        <header className="sticky top-0 z-50 bg-white shadow-sm">
          <div className="shell relative flex items-center gap-4 border-b border-blue-50 py-4 md:gap-6 md:py-5">
            <Link
              href="/"
              className="flex shrink-0 items-center gap-3"
              aria-label="JPL Traders home"
            >
              <Image
                src="/jpl-traders-logo.png"
                alt="JPL Traders"
                width={190}
                height={64}
                priority
                className="h-auto w-[150px] sm:w-[170px] xl:w-[190px]"
              />
            </Link>
            <div className="hidden flex-1 md:flex xl:absolute xl:left-1/2 xl:top-1/2 xl:w-[min(45vw,560px)] xl:-translate-x-1/2 xl:-translate-y-1/2">
              <label className="flex w-full max-w-xl items-center overflow-hidden rounded-xl border border-blue-100 bg-slate-50 shadow-sm transition focus-within:border-blue-300 focus-within:bg-white focus-within:shadow-[0_8px_24px_rgba(8,40,90,0.10)]">
                <Search className="ml-4 shrink-0 text-slate-400" size={17} />
                <input
                  className="w-full bg-transparent px-3 py-3.5 text-xs outline-none placeholder:text-slate-400"
                  placeholder="Search laptops, computers, printers, accessories..."
                />
                <button
                  className="m-1.5 rounded-lg bg-gradient-to-r from-[#0a4ca3] to-[#1768c7] px-4 py-2.5 text-white shadow-sm transition hover:from-[#083b7d] hover:to-[#0a4ca3]"
                  aria-label="Search"
                >
                  <Search size={16} />
                </button>
              </label>
            </div>
            <div className="ml-auto flex items-center gap-3 md:gap-4">
              <Link
                href="/cart"
                aria-label="Shopping cart, 2 items"
                className="relative flex h-11 w-11 items-center justify-center rounded-xl border border-blue-100 bg-white text-[#08285a] shadow-sm transition hover:border-orange-200 hover:bg-orange-50"
              >
                <ShoppingCart size={23} />
                <span className="absolute -right-1.5 -top-1.5 rounded-full border-2 border-white bg-orange-500 px-1.5 text-[9px] font-bold text-white">
                  2
                </span>
              </Link>
              <Button
                asChild
                size="sm"
                className="hidden shadow-md shadow-orange-500/20 transition hover:-translate-y-0.5 lg:inline-flex"
              >
                <Link href="/quote">Get a Quote</Link>
              </Button>
            </div>
          </div>
          <nav className="store-nav border-t border-orange-400/30 bg-gradient-to-r from-[#08285a] via-[#0a3c83] to-[#08285a] text-white">
            <div className="shell flex flex-col gap-1 py-0 md:flex-row md:items-center md:justify-center md:gap-2">
              {navigation.map(([title, href], index) => {
                const isActive =
                  pathname === href ||
                  (href !== "/" && pathname.startsWith(href));
                return (
                  <Fragment key={href}>
                    <motion.div
                      className="w-full md:w-auto"
                      whileHover={{ y: -2 }}
                      whileTap={{ scale: 0.97 }}
                      transition={{ type: "spring", stiffness: 420, damping: 26 }}
                    >
                      <Link
                        href={href}
                        aria-current={isActive ? "page" : undefined}
                        className={`relative block w-full rounded-lg px-4 py-3 text-xs font-extrabold transition-colors after:absolute after:bottom-1.5 after:left-1/2 after:h-0.5 after:-translate-x-1/2 after:rounded-full after:bg-gradient-to-r after:from-orange-300 after:via-orange-400 after:to-amber-200 after:shadow-[0_0_10px_rgba(251,146,60,0.75)] after:transition-all md:w-auto ${
                          isActive
                            ? "bg-white/10 text-orange-300 after:w-7"
                            : "text-blue-50 after:w-0 hover:bg-white/10 hover:text-orange-200 hover:after:w-5"
                        }`}
                      >
                        {title}
                      </Link>
                    </motion.div>
                    {index < navigation.length - 1 && (
                      <span
                        aria-hidden="true"
                        className="nav-pipe hidden md:block"
                      />
                    )}
                  </Fragment>
                );
              })}
            </div>
          </nav>
        </header>
      </div>
      <header className="sticky top-0 z-[70] border-b border-slate-200 bg-white/95 shadow-[0_4px_16px_rgba(8,38,83,0.08)] backdrop-blur-xl md:hidden">
        <div className="flex h-16 items-center justify-between px-3 sm:px-4">
          <Link
            href="/"
            className="flex min-w-0 items-center"
            aria-label="JPL Traders home"
          >
            <Image
              src="/jpl-traders-logo.png"
              alt="JPL Traders"
              width={190}
              height={64}
              priority
              className="h-auto w-[132px]"
            />
          </Link>
          <button
            type="button"
            onClick={() => setMenuOpen((open) => !open)}
            className="flex h-11 w-11 items-center justify-center rounded-xl border border-blue-100 bg-white text-[#08285a] shadow-sm"
            aria-label={menuOpen ? "Close menu" : "Open menu"}
            aria-expanded={menuOpen}
            aria-controls="mobile-menu"
          >
            {menuOpen ? <X size={24} /> : <Menu size={24} />}
          </button>
        </div>
      </header>

      {menuOpen && (
        <div className="fixed inset-0 z-[65] md:hidden">
          <button
            type="button"
            className="absolute inset-0 bg-[#061e45]/45 backdrop-blur-[2px]"
            aria-label="Close menu"
            onClick={() => setMenuOpen(false)}
          />
          <nav
            id="mobile-menu"
            aria-label="Mobile navigation"
            className="absolute right-0 top-0 h-full w-[min(86vw,340px)] bg-white pt-[calc(env(safe-area-inset-top)+4.75rem)] shadow-[-12px_0_32px_rgba(8,38,83,0.18)]"
          >
            <div className="border-t border-slate-100 px-3 py-4">
              {navigation.map(([title, href]) => {
                const isActive =
                  pathname === href ||
                  (href !== "/" && pathname.startsWith(href));
                return (
                  <Link
                    key={href}
                    href={href}
                    aria-current={isActive ? "page" : undefined}
                    className={`mb-1 flex min-h-12 items-center rounded-xl px-4 text-sm font-extrabold ${
                      isActive
                        ? "bg-[#0757c8] text-white"
                        : "text-[#08285a] hover:bg-blue-50"
                    }`}
                  >
                    {title}
                  </Link>
                );
              })}
            </div>
          </nav>
        </div>
      )}
    </>
  );
}

export function SiteFooter() {
  return (
    <footer className="mt-12 bg-[#061e45] text-blue-100 md:mt-16">
      <div className="shell grid grid-cols-2 gap-x-5 gap-y-8 py-9 sm:gap-9 sm:py-12 md:grid-cols-4">
        <div className="col-span-2 md:col-span-1">
          <Link
            href="/"
            className="inline-block rounded-xl bg-white px-3 py-2"
            aria-label="JPL Traders home"
          >
            <Image
              src="/jpl-traders-logo.png"
              alt="JPL Traders"
              width={240}
              height={80}
              className="h-auto w-[210px]"
            />
          </Link>
          <p className="mt-3 text-sm leading-6">
            Computer sales, office equipment, accessories, repairing and
            institutional IT solutions.
          </p>
          <p className="mt-4 flex items-center gap-2 text-xs">
            <MapPin size={14} /> Sidhari, Azamgarh, UP
          </p>
        </div>
        {[
          ["Quick Links", ["Products", "Services", "About", "Contact"]],
          ["Customer Care", ["FAQ", "Payment", "Quote", "Orders"]],
        ].map(([heading, items]: any) => (
          <div key={heading}>
            <h3 className="mb-4 font-bold text-white">{heading}</h3>
            {items.map((item: string) => (
              <Link
                key={item}
                href={item === "Quote" ? "/quote" : `/${item.toLowerCase()}`}
                className="mb-3 block text-sm hover:text-orange-300"
              >
                {item}
              </Link>
            ))}
          </div>
        ))}
        <div className="col-span-2 sm:col-span-1">
          <h3 className="mb-4 font-bold text-white">Visit our shop</h3>
          <p className="text-sm leading-6">Sidhari, Azamgarh, Uttar Pradesh</p>
          <p className="mt-3 text-xs text-blue-300">
            Phone, email and operating hours should be confirmed before
            publishing.
          </p>
        </div>
      </div>
      <div className="border-t border-white/10 px-3 py-4 text-center text-[10px] sm:text-xs">
        © 2026 JPL TRADERS · Frontend UI demonstration
      </div>
    </footer>
  );
}
