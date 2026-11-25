@php
$size = $size ?? 20;
$icon = $name ?? '';
$paths = [
    'laptop' => '<rect x="3" y="5" width="18" height="12" rx="1.5"/><path d="M2 19h20M5 17h14"/>',
    'desktop' => '<rect x="2" y="3" width="14" height="12" rx="1.5"/><path d="M7 20h4m-2-5v5"/><rect x="18" y="5" width="4" height="15" rx="1"/><circle cx="20" cy="17" r=".5"/>',
    'monitor' => '<rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>',
    'mouse' => '<rect x="6" y="2" width="12" height="20" rx="6"/><path d="M12 2v7m-6 0h12"/>',
    'keyboard' => '<rect x="2" y="5" width="20" height="14" rx="2"/><path d="M6 9h.01M9 9h.01M12 9h.01M15 9h.01M18 9h.01M6 12h.01M9 12h.01M12 12h.01M15 12h.01M18 12h.01M6 15h12"/>',
    'pendrive' => '<path d="M9 3h6v4H9zM8 7h8v8a4 4 0 0 1-8 0V7Z"/><path d="M12 11v4m-1-2h2"/>',
    'usb' => '<path d="M9 3h6v4H9zM8 7h8v8a4 4 0 0 1-8 0V7Z"/><path d="M12 11v4m-1-2h2"/>',
    'server' => '<rect x="3" y="3" width="18" height="8" rx="2"/><rect x="3" y="13" width="18" height="8" rx="2"/><path d="M7 7h.01M7 17h.01M11 7h6m-6 10h6"/>',
    'router' => '<rect x="3" y="11" width="18" height="9" rx="2"/><path d="M7 11V7m10 4V7M5 7a7 7 0 0 1 14 0M8 16h.01M12 16h.01M16 16h.01"/>',
    'tablet' => '<rect x="4" y="2" width="16" height="20" rx="2"/><path d="M11 18h2"/>',
    'smartphone' => '<rect x="6" y="2" width="12" height="20" rx="2"/><path d="M11 18h2"/>',
    'hard-drive' => '<rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="8" cy="14" r="3"/><path d="m10.2 11.8 4.3-4.3M16 16h.01"/>',
    'printer' => '<path d="M6 9V3h12v6M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="7"/>',
    'copy' => '<rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>',
    'headphones' => '<path d="M3 14a9 9 0 0 1 18 0"/><path d="M21 14v5a2 2 0 0 1-2 2h-1v-7h1a2 2 0 0 1 2 2ZM3 14v5a2 2 0 0 0 2 2h1v-7H5a2 2 0 0 0-2 2Z"/>',
    'wifi' => '<path d="M5 12.5a10 10 0 0 1 14 0M8.5 16a5 5 0 0 1 7 0M12 19h.01"/>',
    'cpu' => '<rect x="7" y="7" width="10" height="10" rx="1"/><path d="M9 1v3m6-3v3m-6 19v-3m6 3v-3M1 9h3m-3 6h3m16-6h3m-3 6h3"/>',
    'building' => '<path d="M3 21h18M5 21V7l7-4v18m7 0V9l-7-4M8 10h1m3 0h1m-5 4h1m3 0h1m-5 4h1m3 0h1"/>',
    'wrench' => '<path d="M14.7 6.3a4 4 0 0 0-5.4-5.4l2.1 2.1-3.1 3.1-2.1-2.1a4 4 0 0 0 5.4 5.4L21 19.8a1.6 1.6 0 0 1-2.2 2.2l-9.4-9.4"/>',
    'map-pin' => '<path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/>',
    'phone' => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 2 .7 3a2 2 0 0 1-.5 2.1L8 10.1a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.5c1 .3 2 .6 3 .7a2 2 0 0 1 1.6 1.9Z"/>',
    'mail' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
    'arrow-right' => '<path d="M5 12h14M13 6l6 6-6 6"/>',
    'shield' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/><path d="m9 12 2 2 4-4"/>',
    'database' => '<ellipse cx="12" cy="5" rx="8" ry="3"/><path d="M4 5v7c0 1.7 3.6 3 8 3s8-1.3 8-3V5M4 12v7c0 1.7 3.6 3 8 3s8-1.3 8-3v-7"/>',
    'gear' => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1-1.8 1.8-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.6v.2h-2.6V20a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1L7.6 17l.1-.1a1.7 1.7 0 0 0 .3-1.9A1.7 1.7 0 0 0 6.4 14H6v-2.6h.4A1.7 1.7 0 0 0 8 10.4a1.7 1.7 0 0 0-.3-1.9L7.6 8l1.8-1.8.1.1A1.7 1.7 0 0 0 11.4 6a1.7 1.7 0 0 0 1-1.6v-.2H15v.2A1.7 1.7 0 0 0 16 6a1.7 1.7 0 0 0 1.9-.3l.1-.1L19.8 8l-.1.1a1.7 1.7 0 0 0-.3 1.9 1.7 1.7 0 0 0 1.6 1h.2V14H21a1.7 1.7 0 0 0-1.6 1Z"/>',
    'network' => '<rect x="9" y="3" width="6" height="5" rx="1"/><rect x="3" y="16" width="6" height="5" rx="1"/><rect x="15" y="16" width="6" height="5" rx="1"/><path d="M12 8v4M6 16v-4h12v4"/>',
    'laptop-gear' => '<rect x="3" y="5" width="18" height="12" rx="1.5"/><path d="M2 19h20M17 10l1.5 1.5M17 13l1.5-1.5M15 11.5h5"/>',
    'message' => '<path d="M21 15a2 2 0 0 1-2 2H8l-5 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
    'truck' => '<path d="M3 6h11v11H3zM14 10h4l3 3v4h-7z"/><circle cx="7" cy="19" r="2"/><circle cx="18" cy="19" r="2"/>',
    'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/>',
    'headphone' => '<path d="M4 14v-2a8 8 0 0 1 16 0v2M4 14a2 2 0 0 1 2-2h1v7H6a2 2 0 0 1-2-2v-3Zm16 0a2 2 0 0 0-2-2h-1v7h1a2 2 0 0 0 2-2v-3Z"/>',
    'heart' => '<path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21.3l7.8-7.8 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z"/>',
    'cart' => '<circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/><path d="M3 4h2l2.4 11.2a2 2 0 0 0 2 1.6h7.7a2 2 0 0 0 2-1.6L21 8H6"/>',
    'search' => '<circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>',
    'star' => '<path d="m12 2.5 2.9 5.9 6.5.9-4.7 4.6 1.1 6.5-5.8-3.1-5.8 3.1 1.1-6.5-4.7-4.6 6.5-.9Z"/>',
];
@endphp
<svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    {!! $paths[$icon] ?? '' !!}
</svg>
