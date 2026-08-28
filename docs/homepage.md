# Homepage architecture

The `/` route (`routes/web.php`) renders `resources/views/welcome.blade.php`,
which extends a master layout and composes four Blade components. This
replaced the original single-file theme export at `public/theme/index.html`
(kept only as a reference copy, not served).

## File map

```
resources/
├── views/
│   ├── layouts/app.blade.php      # <html>/<head>/<body> shell, @yield('content')
│   ├── welcome.blade.php          # @extends('layouts.app'), assembles the page
│   └── components/
│       ├── navbar.blade.php       # <x-navbar />
│       ├── hero.blade.php         # <x-hero /> — headline + analyze form
│       ├── feature-cards.blade.php# <x-feature-cards /> — bento grid
│       └── footer.blade.php       # <x-footer />
├── css/
│   ├── app.css                    # Tailwind v4 entry + @theme design tokens
│   └── home.css                   # Google Fonts import, .glass-panel,
│                                   # .material-symbols-outlined, shimmer keyframes
└── js/
    ├── app.js                     # existing bootstrap import
    └── home.js                    # homepage-only JS (analyze form handler)
```

## Master layout

`layouts/app.blade.php` owns the `<head>` (title via `@yield('title', ...)`,
asset loading via `@vite(...)`) and the ambient background decoration. Any
new page follows the same pattern:

```blade
@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <x-navbar />
    ...
    <x-footer />
@endsection
```

## Components

Anonymous Blade components in `resources/views/components/` are auto-registered
by tag name — no manual registration needed. `<x-navbar />` resolves to
`components/navbar.blade.php`, etc. They currently take no props; the markup
is static, matching the original theme.

## Styling

Tailwind v4 is CSS-first (no `tailwind.config.js`). The theme's custom
design tokens (colors, spacing, font sizes, radii) that previously lived in
the CDN `<script id="tailwind-config">` block now live in the `@theme` block
in `resources/css/app.css`, using Tailwind v4's token syntax
(`--color-*`, `--spacing-*`, `--font-*`, `--text-*`/`--text-*--line-height`/etc).

Page-specific, non-utility CSS (glass panel effect, Material Symbols font
setup, shimmer animation, Google Fonts imports) lives in `resources/css/home.css`
so it doesn't bloat the shared `app.css`.

Both files are Vite entrypoints — registered in `vite.config.js` `input` —
and loaded together via `@vite([...])` in the layout.

## JS

`resources/js/home.js` intercepts the analyze form's submit event
(`#analyze-form`) to stop the default page reload until a real backend
endpoint exists.

## Extending

- New page → new `@extends('layouts.app')` view, reusing `<x-navbar />` / `<x-footer />`.
- New section on the homepage → new component in `components/`, add it to
  `welcome.blade.php`'s `@section('content')`.
- New homepage-only styles/behavior → `home.css` / `home.js` (already wired).
- Shared styles/behavior across pages → `app.css` / `app.js`.
