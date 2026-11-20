"use client";

import Image from "next/image";
import Link from "next/link";
import { usePathname } from "next/navigation";
import { useState } from "react";
import {
  Bell,
  Building2,
  ChartNoAxesCombined,
  ExternalLink,
  LayoutDashboard,
  LogOut,
  Menu,
  MessageSquare,
  Package,
  Search,
  Settings,
  ShoppingBag,
  Tags,
  Users,
  Wrench,
  X,
} from "lucide-react";

const nav = [
  ["Dashboard", "/admin", LayoutDashboard],
  ["Products", "/admin/products", Package],
  ["Orders", "/admin/orders", ShoppingBag],
  ["Customers", "/admin/customers", Users],
  ["Enquiries", "/admin/enquiries", MessageSquare],
  ["Services / AMC", "/admin/services", Wrench],
  ["Tenders", "/admin/tenders", Building2],
  ["Categories", "/admin/categories", Tags],
  ["Reports", "/admin/reports", ChartNoAxesCombined],
  ["Settings", "/admin/settings", Settings],
] as const;

export function AdminShell({ children }: { children: React.ReactNode }) {
  const path = usePathname();
  const [open, setOpen] = useState(false);

  if (path === "/admin/login") return <>{children}</>;

  return (
    <div className="min-h-screen bg-[#f4f7fb] md:flex">
      <aside
        className={`${open ? "block" : "hidden"} fixed inset-y-0 left-0 z-50 w-64 bg-[#061e45] text-white md:sticky md:top-0 md:block md:h-screen md:shrink-0`}
      >
        <div className="flex items-center justify-between border-b border-white/10 px-6 py-6">
          <Link
            href="/admin"
            className="inline-block rounded-lg bg-white px-2 py-1"
            aria-label="JPL Traders admin home"
          >
            <Image
              src="/jpl-traders-logo.png"
              alt="JPL Traders"
              width={190}
              height={64}
              className="h-auto w-[175px]"
            />
          </Link>
          <button
            className="md:hidden"
            onClick={() => setOpen(false)}
            aria-label="Close admin menu"
          >
            <X />
          </button>
        </div>
        <nav className="space-y-1 px-3 py-5">
          {nav.map(([name, href, Icon]) => (
            <Link
              key={href}
              href={href}
              onClick={() => setOpen(false)}
              className={`admin-link ${path === href ? "active" : ""}`}
            >
              <Icon size={18} />
              {name}
            </Link>
          ))}
        </nav>
        <div className="mx-4 mt-3 border-t border-white/10 pt-5">
          <Link href="/" className="admin-link">
            <ExternalLink size={17} /> View Storefront
          </Link>
          <Link href="/admin/login" className="admin-link">
            <LogOut size={17} /> Admin Login UI
          </Link>
        </div>
      </aside>
      <div className="min-w-0 flex-1">
        <header className="sticky top-0 z-20 flex h-19 items-center justify-between border-b border-slate-200 bg-white px-5 md:px-9">
          <div className="flex items-center gap-4">
            <button
              className="md:hidden"
              onClick={() => setOpen(true)}
              aria-label="Open admin menu"
            >
              <Menu />
            </button>
            <div>
              <p className="text-xs font-bold text-slate-400">ADMIN PANEL</p>
              <h1 className="text-lg font-black">
                {nav.find((item) => item[1] === path)?.[0] || "Dashboard"}
              </h1>
            </div>
          </div>
          <div className="flex items-center gap-5">
            <Search size={18} className="text-slate-400" />
            <Bell size={19} className="text-slate-500" />
            <div className="flex items-center gap-2 border-l pl-4">
              <span className="flex h-9 w-9 items-center justify-center rounded-full bg-blue-100 text-sm font-black text-blue-700">
                A
              </span>
              <span className="hidden text-xs font-bold sm:block">Admin</span>
            </div>
          </div>
        </header>
        <main className="p-5 md:p-9">{children}</main>
      </div>
    </div>
  );
}
