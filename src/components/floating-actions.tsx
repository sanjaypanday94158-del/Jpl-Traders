"use client";

import Link from "next/link";
import { useState } from "react";
import { Facebook, Instagram, Share2, X, Youtube } from "lucide-react";

function WhatsAppIcon({ size = 24 }: { size?: number }) {
  return (
    <svg
      width={size}
      height={size}
      viewBox="0 0 24 24"
      fill="none"
      aria-hidden="true"
    >
      <path
        d="M20.52 3.48A11.84 11.84 0 0 0 12.06 0C5.49 0 .16 5.33.16 11.9c0 2.1.55 4.15 1.59 5.96L.06 24l6.28-1.65a11.9 11.9 0 0 0 5.71 1.45h.01c6.57 0 11.91-5.34 11.91-11.91 0-3.18-1.24-6.17-3.45-8.41Z"
        fill="currentColor"
      />
      <path
        d="M12.06 21.82h-.01a9.9 9.9 0 0 1-5.05-1.38l-.36-.21-3.72.98 1-3.63-.24-.37a9.88 9.88 0 0 1-1.52-5.31A9.94 9.94 0 0 1 12.06 2c2.65 0 5.15 1.03 7.02 2.91a9.86 9.86 0 0 1 2.92 7.03c0 5.48-4.46 9.88-9.94 9.88Zm5.46-7.41c-.3-.15-1.77-.87-2.04-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.48-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.14-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.61-.92-2.21-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48 0 1.46 1.07 2.87 1.22 3.07.15.2 2.1 3.21 5.09 4.5.71.31 1.27.49 1.7.63.71.23 1.36.2 1.87.12.57-.08 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.13-.27-.2-.57-.35Z"
        fill="#25D366"
      />
    </svg>
  );
}

const socials = [
  {
    title: "Instagram",
    href: "https://www.instagram.com/",
    icon: Instagram,
    className: "bg-gradient-to-br from-[#833ab4] via-[#fd1d1d] to-[#fcb045]",
  },
  {
    title: "Facebook",
    href: "https://www.facebook.com/",
    icon: Facebook,
    className: "bg-[#1877F2]",
  },
  {
    title: "YouTube",
    href: "https://www.youtube.com/",
    icon: Youtube,
    className: "bg-[#FF0033]",
  },
];

export function FloatingActions() {
  const [socialOpen, setSocialOpen] = useState(false);

  return (
    <aside
      aria-label="Quick contact and social links"
      className="fixed bottom-5 right-3 z-[55] flex flex-col items-end gap-3 pb-[env(safe-area-inset-bottom)] sm:right-5"
    >
      {socialOpen && (
        <div className="flex flex-col items-end gap-3" role="menu">
          {socials.map(({ title, href, icon: Icon, className }, index) => (
            <Link
              key={title}
              href={href}
              target="_blank"
              rel="noopener noreferrer"
              role="menuitem"
              aria-label={title}
              title={title}
              className={`flex h-12 w-12 items-center justify-center rounded-full text-white shadow-[0_8px_24px_rgba(8,38,83,0.24)] transition-transform hover:-translate-x-1 ${className}`}
              style={{
                animation: `floating-action-in 180ms ease-out ${index * 45}ms both`,
              }}
            >
              <Icon size={21} strokeWidth={2} />
            </Link>
          ))}
        </div>
      )}

      <button
        type="button"
        onClick={() => setSocialOpen((open) => !open)}
        aria-label={socialOpen ? "Hide social links" : "Show social links"}
        aria-expanded={socialOpen}
        title={socialOpen ? "Hide social links" : "Show social links"}
        className={`flex h-12 w-12 items-center justify-center rounded-full border border-blue-100 text-[#08285a] shadow-[0_8px_24px_rgba(8,38,83,0.20)] transition-all ${
          socialOpen
            ? "rotate-90 bg-[#08285a] text-white"
            : "bg-white hover:-translate-y-0.5 hover:text-[#0757c8]"
        }`}
      >
        {socialOpen ? <X size={22} /> : <Share2 size={22} />}
      </button>

      <Link
        href="https://wa.me/?text=Hello%20JPL%20TRADERS"
        target="_blank"
        rel="noopener noreferrer"
        aria-label="Chat on WhatsApp"
        title="Chat on WhatsApp"
        className="flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] text-white shadow-[0_10px_28px_rgba(37,211,102,0.38)] ring-4 ring-white transition-transform hover:scale-105"
      >
        <WhatsAppIcon size={29} />
      </Link>
    </aside>
  );
}
