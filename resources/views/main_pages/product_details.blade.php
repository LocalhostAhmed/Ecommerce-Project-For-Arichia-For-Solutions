<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>iPhone 16 Pro Max | ElectroHub</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    /* ============================================================
       DESIGN TOKENS — ElectroHub Identity
       ============================================================ */
    :root {
      --navy: #0F172A;
      --navy-soft: #1E293B;
      --amber: #F59E0B;
      --amber-glow: rgba(245, 158, 11, 0.45);
      --white: #F8FAFC;
      --muted: #94A3B8;
      --line: rgba(255, 255, 255, 0.07);
      --card: rgba(30, 41, 59, 0.55);
      --shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.85);
      --radius: 1.5rem;
      --radius-sm: 1rem;
      --ease: cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    html { scroll-behavior: smooth; }

    body {
      font-family: 'Inter', sans-serif;
      background: radial-gradient(circle at 20% 0%, #1a2744 0%, var(--navy) 45%, #060a12 100%);
      color: var(--white);
      line-height: 1.6;
      overflow-x: hidden;
      padding: 0 1rem;
      -webkit-font-smoothing: antialiased;
    }

    img { max-width: 100%; display: block; }
    a { text-decoration: none; color: inherit; }
    ul { list-style: none; }
    button { font-family: inherit; }

    .scene {
      max-width: 1440px;
      margin: 0 auto;
      perspective: 1800px;
      perspective-origin: 50% 20%;
      transform-style: preserve-3d;
    }

    .container { max-width: 1320px; margin: 0 auto; padding: 0 0.5rem; }

    .section-head {
      text-align: center;
      margin: 3rem 0 2rem;
      transform: translateZ(25px);
    }
    .section-head h2 {
      font-size: clamp(1.6rem, 3.5vw, 2.2rem);
      font-weight: 800;
      letter-spacing: -0.02em;
      background: linear-gradient(135deg, #ffffff 30%, #93c5fd 100%);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    .section-head p { color: var(--muted); margin-top: 0.4rem; font-size: 0.95rem; }

    .btn {
      display: inline-flex; align-items: center; justify-content: center;
      gap: 0.5rem; padding: 0.8rem 1.6rem;
      border-radius: 60px; font-weight: 600; font-size: 0.9rem;
      transition: all 0.35s var(--ease);
      border: 1px solid transparent; cursor: pointer;
    }
    .btn-amber {
      background: linear-gradient(145deg, #fbbf24, #f59e0b);
      color: #1a1206;
      box-shadow: 0 12px 25px -8px var(--amber-glow), inset 0 1px 0 rgba(255,255,255,0.4);
    }
    .btn-amber:hover {
      transform: translateY(-4px) translateZ(20px);
      box-shadow: 0 22px 38px -10px var(--amber-glow);
    }
    .btn-amber:active { transform: translateY(-1px) translateZ(10px); }
    .btn-ghost {
      background: rgba(255,255,255,0.04);
      border-color: var(--line);
      color: var(--white);
      backdrop-filter: blur(6px);
    }
    .btn-ghost:hover {
      border-color: var(--amber); color: var(--amber);
      transform: translateY(-4px) translateZ(20px);
    }
    .btn-ghost:active { transform: translateY(-1px) translateZ(10px); }

    /* ============================================================
       ANNOUNCEMENT BAR
       ============================================================ */
    .announcement {
      background: linear-gradient(90deg, #1E293B, #0F172A 50%, #1E293B);
      border-bottom: 1px solid var(--line);
      font-size: 0.82rem; color: var(--muted);
      transform: translateZ(10px);
    }
    .announcement-inner {
      display: flex; justify-content: center; align-items: center;
      gap: 2.2rem; padding: 0.55rem 1rem; flex-wrap: wrap;
    }
    .announcement span { display: inline-flex; align-items: center; gap: 0.4rem; }
    .announcement i { color: var(--amber); }

    /* ============================================================
       HEADER & NAVIGATION
       ============================================================ */
    .header {
      position: sticky; top: 0; z-index: 100;
      background: rgba(15, 23, 42, 0.8);
      backdrop-filter: blur(18px);
      border-bottom: 1px solid var(--line);
      transform: translateZ(20px);
    }
    .header-inner {
      display: flex; align-items: center; justify-content: space-between;
      gap: 1.5rem; padding: 1rem 0.5rem; flex-wrap: wrap;
    }
    .logo { display: flex; align-items: center; gap: 0.6rem; font-size: 1.5rem; font-weight: 900; letter-spacing: -0.03em; }
    .logo-mark {
      width: 42px; height: 42px; display: grid; place-items: center;
      border-radius: 13px;
      background: linear-gradient(145deg, var(--amber), #b45309);
      color: #1a1206; font-size: 1.2rem;
      box-shadow: 0 10px 22px -6px var(--amber-glow), inset 0 1px 0 rgba(255,255,255,0.4);
      transform: translateZ(15px);
    }
    .logo b { color: var(--amber); }

    .search-bar {
      flex: 1 1 320px; display: flex; align-items: center; gap: 0.6rem;
      background: rgba(255,255,255,0.05);
      border: 1px solid var(--line);
      border-radius: 60px; padding: 0.55rem 1.1rem;
      transition: all 0.3s var(--ease); transform: translateZ(10px);
    }
    .search-bar:focus-within { border-color: var(--amber); box-shadow: 0 0 0 4px var(--amber-glow); }
    .search-bar i { color: var(--muted); }
    .search-bar input {
      flex: 1; background: transparent; border: none; outline: none;
      color: var(--white); font-size: 0.9rem; font-family: inherit;
    }
    .search-bar input::placeholder { color: var(--muted); }

    .header-icons { display: flex; align-items: center; gap: 1.1rem; font-size: 1.15rem; }
    .icon-btn {
      position: relative; width: 42px; height: 42px;
      display: grid; place-items: center; border-radius: 50%;
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--line); color: var(--white);
      transition: all 0.3s var(--ease); cursor: pointer;
    }
    .icon-btn:hover { color: var(--amber); border-color: var(--amber); transform: translateY(-3px) translateZ(15px); }
    .badge-count {
      position: absolute; top: -4px; right: -4px;
      background: var(--amber); color: #1a1206;
      font-size: 0.65rem; font-weight: 800;
      width: 18px; height: 18px; border-radius: 50%;
      display: grid; place-items: center;
    }

    .main-nav { border-top: 1px solid var(--line); }
    .main-nav ul {
      display: flex; justify-content: center; gap: 2.2rem;
      padding: 0.8rem 0.5rem; flex-wrap: wrap;
      font-weight: 500; font-size: 0.92rem;
    }
    .main-nav a { position: relative; padding: 0.3rem 0; transition: color 0.3s var(--ease); }
    .main-nav a::after {
      content: ''; position: absolute; left: 0; bottom: -2px;
      width: 0; height: 2px; background: var(--amber);
      transition: width 0.3s var(--ease);
    }
    .main-nav a:hover { color: var(--amber); }
    .main-nav a:hover::after { width: 100%; }

    /* ============================================================
       SECTION 01 — BREADCRUMB
       ============================================================ */
    .breadcrumb-bar {
      padding: 1.6rem 0.5rem 0.5rem;
      transform: translateZ(20px);
    }
    .breadcrumb {
      display: flex; align-items: center; gap: 0.6rem;
      font-size: 0.82rem; color: var(--muted); flex-wrap: wrap;
    }
    .breadcrumb a { color: var(--muted); transition: color 0.3s var(--ease); }
    .breadcrumb a:hover { color: var(--amber); }
    .breadcrumb i { font-size: 0.6rem; opacity: 0.6; }
    .breadcrumb .current { color: var(--amber); font-weight: 600; }

    /* ============================================================
       MAIN PRODUCT WRAPPER
       ============================================================ */
    .product-wrap {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 3rem;
      padding: 2rem 0.5rem 4rem;
      transform-style: preserve-3d;
      align-items: start;
    }

    /* ============================================================
       SECTION 02 — PRODUCT GALLERY (3D Viewer)
       ============================================================ */
    .gallery {
      position: sticky; top: 140px;
      transform-style: preserve-3d;
      transform: translateZ(30px);
    }

    .gallery-main {
      position: relative;
      aspect-ratio: 1 / 1;
      background: linear-gradient(145deg, rgba(30,41,59,0.9), rgba(15,23,42,0.6));
      border: 1px solid var(--line);
      border-radius: var(--radius);
      overflow: hidden;
      box-shadow: var(--shadow), 0 0 0 1px rgba(255,255,255,0.05);
      transform-style: preserve-3d;
      transition: transform 0.6s var(--ease);
    }
    .gallery-main:hover { transform: rotateY(-3deg) rotateX(2deg) translateZ(35px); }

    .gallery-main img {
      width: 100%; height: 100%;
      object-fit: contain;
      padding: 2rem;
      filter: drop-shadow(0 30px 40px rgba(0,0,0,0.8));
      transition: transform 0.5s var(--ease);
    }
    .gallery-main:hover img { transform: scale(1.05); }

    /* Floating badges on main image */
    .gallery-badge {
      position: absolute; top: 1.2rem; left: 1.2rem;
      padding: 0.35rem 0.85rem;
      background: #ef4444; color: #fff;
      font-size: 0.72rem; font-weight: 800;
      border-radius: 100px; letter-spacing: 0.5px;
      box-shadow: 0 10px 20px -8px rgba(239,68,68,0.6);
      z-index: 2;
    }
    .gallery-360 {
      position: absolute; bottom: 1.2rem; right: 1.2rem;
      display: inline-flex; align-items: center; gap: 0.4rem;
      padding: 0.5rem 0.95rem;
      background: rgba(15,23,42,0.9);
      backdrop-filter: blur(10px);
      border: 1px solid var(--amber);
      color: var(--amber);
      font-size: 0.75rem; font-weight: 700;
      border-radius: 100px;
      cursor: pointer;
      transition: all 0.3s var(--ease);
      z-index: 2;
    }
    .gallery-360:hover {
      transform: translateY(-3px) translateZ(15px);
      box-shadow: 0 15px 25px -10px var(--amber-glow);
    }

    /* Thumbnail strip */
    .gallery-thumbs {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 0.7rem;
      margin-top: 1rem;
    }
    .thumb {
      aspect-ratio: 1 / 1;
      background: var(--card);
      border: 1.5px solid var(--line);
      border-radius: 0.9rem;
      overflow: hidden;
      cursor: pointer;
      transition: all 0.3s var(--ease);
      transform-style: preserve-3d;
      padding: 0.4rem;
    }
    .thumb img {
      width: 100%; height: 100%;
      object-fit: contain;
    }
    .thumb:hover {
      border-color: var(--amber);
      transform: translateY(-4px) translateZ(20px);
      box-shadow: 0 15px 25px -10px var(--amber-glow);
    }
    .thumb.active {
      border-color: var(--amber);
      box-shadow: 0 0 0 2px var(--amber-glow), 0 10px 20px -8px var(--amber-glow);
      transform: translateZ(15px);
    }

    /* ============================================================
       PRODUCT INFO COLUMN
       ============================================================ */
    .product-info { transform-style: preserve-3d; transform: translateZ(40px); }

    /* ---------- SECTION 03 — Product Info Panel ---------- */
    .info-panel { margin-bottom: 1.6rem; }

    .brand-row {
      display: flex; align-items: center; gap: 0.7rem;
      margin-bottom: 0.8rem;
    }
    .brand-tag {
      display: inline-flex; align-items: center; gap: 0.4rem;
      padding: 0.3rem 0.8rem;
      background: rgba(245,158,11,0.12);
      border: 1px solid rgba(245,158,11,0.35);
      border-radius: 100px;
      color: var(--amber);
      font-size: 0.72rem; font-weight: 700;
      letter-spacing: 0.6px;
      text-transform: uppercase;
    }
    .sku { font-size: 0.75rem; color: var(--muted); margin-left: auto; }

    .info-panel h1 {
      font-size: clamp(1.6rem, 4vw, 2.4rem);
      font-weight: 900;
      line-height: 1.15;
      letter-spacing: -0.02em;
      margin-bottom: 0.9rem;
    }
    .info-panel h1 span { color: var(--amber); }

    .rating-row {
      display: flex; align-items: center; gap: 0.9rem;
      flex-wrap: wrap;
      margin-bottom: 1rem;
      font-size: 0.85rem;
    }
    .stars { color: var(--amber); display: flex; gap: 0.15rem; font-size: 0.9rem; }
    .rating-row b { color: var(--white); }
    .rating-row .sep { color: var(--muted); }
    .rating-row a { color: var(--amber); text-decoration: underline; text-underline-offset: 3px; }

    .short-desc {
      color: var(--muted);
      font-size: 0.95rem;
      line-height: 1.7;
      margin-bottom: 1.2rem;
    }

    .quick-features {
      display: flex; flex-wrap: wrap; gap: 0.6rem;
      margin-bottom: 0.5rem;
    }
    .quick-feature {
      display: inline-flex; align-items: center; gap: 0.4rem;
      padding: 0.4rem 0.85rem;
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--line);
      border-radius: 60px;
      font-size: 0.78rem;
      color: var(--muted);
      transition: all 0.3s var(--ease);
    }
    .quick-feature i { color: var(--amber); font-size: 0.75rem; }
    .quick-feature:hover { border-color: var(--amber); color: var(--white); }

    /* ---------- SECTION 04 — Price & Offers Box ---------- */
    .price-box {
      background: var(--card);
      backdrop-filter: blur(14px);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      padding: 1.5rem;
      margin-bottom: 1.6rem;
      box-shadow: 0 18px 35px -18px rgba(0,0,0,0.8);
      transform-style: preserve-3d;
    }
    .price-box:hover {
      transform: translateY(-4px) translateZ(20px);
      border-color: rgba(245,158,11,0.35);
    }

    .price-main {
      display: flex; align-items: baseline; gap: 0.9rem;
      flex-wrap: wrap;
      margin-bottom: 0.5rem;
    }
    .price-now {
      font-size: clamp(1.8rem, 4vw, 2.4rem);
      font-weight: 900;
      color: var(--amber);
      text-shadow: 0 0 25px var(--amber-glow);
      letter-spacing: -0.02em;
    }
    .price-old {
      font-size: 1.1rem;
      color: var(--muted);
      text-decoration: line-through;
    }
    .price-discount {
      padding: 0.3rem 0.75rem;
      background: rgba(239,68,68,0.15);
      border: 1px solid rgba(239,68,68,0.35);
      border-radius: 60px;
      color: #f87171;
      font-size: 0.78rem;
      font-weight: 800;
    }
    .price-savings {
      font-size: 0.82rem;
      color: var(--muted);
      margin-bottom: 1rem;
    }
    .price-savings b { color: #22c55e; }

    .offers-list {
      display: flex; flex-direction: column; gap: 0.7rem;
      padding-top: 1rem;
      border-top: 1px solid var(--line);
    }
    .offer-item {
      display: flex; align-items: flex-start; gap: 0.7rem;
      font-size: 0.85rem;
      color: var(--muted);
    }
    .offer-item i { color: var(--amber); margin-top: 0.15rem; }
    .offer-item b { color: var(--white); font-weight: 600; }

    /* ---------- SECTION 05 — Variants & Options ---------- */
    .variants { margin-bottom: 1.6rem; }
    .variant-group { margin-bottom: 1.3rem; }
    .variant-label {
      display: flex; align-items: center; justify-content: space-between;
      font-size: 0.85rem;
      font-weight: 700;
      margin-bottom: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.6px;
      color: var(--muted);
    }
    .variant-label span b { color: var(--white); font-weight: 700; text-transform: none; }

    .color-options {
      display: flex; gap: 0.75rem; flex-wrap: wrap;
    }
    .color-opt {
      width: 42px; height: 42px;
      border-radius: 50%;
      border: 2px solid var(--line);
      cursor: pointer;
      transition: all 0.3s var(--ease);
      box-shadow: inset 0 3px 6px rgba(0,0,0,0.3);
      position: relative;
    }
    .color-opt:hover {
      transform: scale(1.12) translateZ(15px);
      border-color: var(--amber);
    }
    .color-opt.active {
      border-color: var(--amber);
      box-shadow: 0 0 0 3px var(--amber-glow), inset 0 3px 6px rgba(0,0,0,0.3);
      transform: translateZ(10px);
    }
    .color-opt.active::after {
      content: '\f00c';
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      position: absolute;
      inset: 0;
      display: grid; place-items: center;
      color: #fff;
      text-shadow: 0 2px 4px rgba(0,0,0,0.8);
      font-size: 0.85rem;
    }

    .size-options { display: flex; gap: 0.6rem; flex-wrap: wrap; }
    .size-opt {
      padding: 0.65rem 1.15rem;
      border-radius: 0.9rem;
      background: rgba(255,255,255,0.04);
      border: 1.5px solid var(--line);
      color: var(--muted);
      font-size: 0.85rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s var(--ease);
      text-align: center;
    }
    .size-opt small { display: block; font-size: 0.68rem; opacity: 0.7; margin-top: 0.15rem; }
    .size-opt:hover {
      border-color: var(--amber); color: var(--amber);
      transform: translateY(-3px) translateZ(15px);
    }
    .size-opt.active {
      background: linear-gradient(145deg, rgba(245,158,11,0.2), rgba(245,158,11,0.05));
      border-color: var(--amber);
      color: var(--amber);
      box-shadow: 0 0 0 3px var(--amber-glow);
      transform: translateZ(10px);
    }

    /* ---------- SECTION 06 — Quantity & Stock Indicator ---------- */
    .stock-row {
      display: flex; align-items: center; justify-content: space-between;
      gap: 1rem; flex-wrap: wrap;
      margin-bottom: 1.2rem;
      padding: 1rem 1.2rem;
      background: var(--card);
      backdrop-filter: blur(12px);
      border: 1px solid var(--line);
      border-radius: var(--radius-sm);
      box-shadow: 0 12px 25px -12px rgba(0,0,0,0.7);
    }

    .stock-indicator {
      display: flex; align-items: center; gap: 0.6rem;
      font-size: 0.85rem;
      font-weight: 600;
    }
    .stock-dot {
      width: 10px; height: 10px;
      border-radius: 50%;
      background: #22c55e;
      box-shadow: 0 0 0 4px rgba(34,197,94,0.2);
      animation: pulseGreen 2s ease-in-out infinite;
    }
    .stock-indicator.low .stock-dot {
      background: #f59e0b;
      box-shadow: 0 0 0 4px rgba(245,158,11,0.2);
      animation: pulseAmber 2s ease-in-out infinite;
    }
    .stock-indicator.low { color: var(--amber); }
    .stock-indicator.out .stock-dot {
      background: #ef4444;
      box-shadow: 0 0 0 4px rgba(239,68,68,0.2);
      animation: none;
    }
    .stock-indicator.out { color: #f87171; }
    .stock-indicator.in-stock { color: #22c55e; }
    .stock-indicator small { color: var(--muted); font-weight: 400; }

    .qty-stepper {
      display: flex; align-items: center; gap: 0.5rem;
      background: rgba(15,23,42,0.7);
      border: 1px solid var(--line);
      border-radius: 60px;
      padding: 0.35rem;
    }
    .qty-btn {
      width: 36px; height: 36px;
      display: grid; place-items: center;
      border-radius: 50%;
      border: none;
      background: rgba(255,255,255,0.05);
      color: var(--white);
      cursor: pointer;
      transition: all 0.25s var(--ease);
      font-size: 0.85rem;
    }
    .qty-btn:hover {
      background: var(--amber); color: #1a1206;
      transform: translateZ(10px);
    }
    .qty-btn:active { transform: translateZ(5px) scale(0.95); }
    .qty-value {
      min-width: 42px; text-align: center;
      font-weight: 800; font-size: 1rem;
      color: var(--amber);
    }

    /* ---------- SECTION 07 — Add-to-Cart Actions ---------- */
    .action-buttons {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.8rem;
      margin-bottom: 1rem;
      transform-style: preserve-3d;
    }
    .action-buttons .btn { width: 100%; padding: 1rem 1.5rem; font-size: 0.95rem; }
    .btn-cart {
      background: linear-gradient(145deg, #2563eb, #1d4ed8);
      color: #fff;
      border: 1px solid rgba(255,255,255,0.1);
      box-shadow: 0 15px 30px -10px rgba(37,99,235,0.6), inset 0 1px 0 rgba(255,255,255,0.15);
      grid-column: 1 / -1;
    }
    .btn-cart:hover {
      transform: translateY(-4px) translateZ(25px);
      box-shadow: 0 25px 45px -12px rgba(37,99,235,0.8);
    }
    .btn-cart:active { transform: translateY(-1px) translateZ(10px); }

    .btn-buy {
      grid-column: 1 / -1;
      background: linear-gradient(145deg, #fbbf24, #f59e0b);
      color: #1a1206;
      box-shadow: 0 15px 30px -10px var(--amber-glow), inset 0 1px 0 rgba(255,255,255,0.4);
    }
    .btn-buy:hover {
      transform: translateY(-4px) translateZ(25px);
      box-shadow: 0 25px 45px -12px var(--amber-glow);
    }
    .btn-buy:active { transform: translateY(-1px) translateZ(10px); }

    .btn-icon {
      padding: 1rem;
      background: rgba(255,255,255,0.04);
      border: 1.5px solid var(--line);
      color: var(--white);
      border-radius: 60px;
      display: inline-flex;
      justify-content: center;
      align-items: center;
      gap: 0.5rem;
      cursor: pointer;
      font-size: 0.85rem;
      font-weight: 600;
      transition: all 0.3s var(--ease);
    }
    .btn-icon:hover {
      border-color: var(--amber); color: var(--amber);
      transform: translateY(-3px) translateZ(20px);
    }

    /* ---------- SECTION 08 — Trust & Delivery Info ---------- */
    .trust-box {
      background: var(--card);
      backdrop-filter: blur(12px);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      padding: 1.4rem;
      margin-bottom: 1.6rem;
      box-shadow: 0 18px 35px -18px rgba(0,0,0,0.8);
    }
    .trust-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1rem;
      margin-bottom: 1.2rem;
      padding-bottom: 1.2rem;
      border-bottom: 1px solid var(--line);
    }
    .trust-item {
      display: flex; gap: 0.7rem;
      align-items: flex-start;
    }
    .trust-item i {
      width: 36px; height: 36px;
      display: grid; place-items: center;
      background: linear-gradient(145deg, rgba(245,158,11,0.18), rgba(245,158,11,0.05));
      border: 1px solid rgba(245,158,11,0.3);
      border-radius: 10px;
      color: var(--amber);
      font-size: 0.9rem;
      flex-shrink: 0;
      transform: translateZ(15px);
    }
    .trust-item b { display: block; font-size: 0.82rem; margin-bottom: 0.15rem; }
    .trust-item small { color: var(--muted); font-size: 0.72rem; line-height: 1.4; }

    .delivery-row {
      display: flex; align-items: center; gap: 0.7rem;
      font-size: 0.85rem;
      color: var(--muted);
    }
    .delivery-row i { color: var(--amber); }
    .delivery-row b { color: var(--white); font-weight: 700; }

    .payment-row {
      display: flex; gap: 0.8rem; flex-wrap: wrap;
      align-items: center;
      padding-top: 1rem;
      border-top: 1px solid var(--line);
      font-size: 0.75rem;
      color: var(--muted);
    }
    .payment-row span { font-weight: 600; }
    .payment-row i { font-size: 1.35rem; color: var(--muted); transition: color 0.3s var(--ease); }
    .payment-row i:hover { color: var(--amber); }

    /* ============================================================
       SECTION 09 + 10 — SPECS + TABS
       ============================================================ */
    .tabs-wrap {
      background: var(--card);
      backdrop-filter: blur(14px);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      overflow: hidden;
      box-shadow: 0 18px 35px -18px rgba(0,0,0,0.8);
      transform: translateZ(20px);
      margin-bottom: 3rem;
    }

    .tabs-header {
      display: flex;
      border-bottom: 1px solid var(--line);
      overflow-x: auto;
      scrollbar-width: none;
      background: rgba(15,23,42,0.5);
    }
    .tabs-header::-webkit-scrollbar { display: none; }
    .tab-btn {
      padding: 1.1rem 1.6rem;
      background: transparent;
      border: none;
      color: var(--muted);
      font-family: inherit;
      font-size: 0.88rem;
      font-weight: 600;
      cursor: pointer;
      white-space: nowrap;
      position: relative;
      transition: color 0.3s var(--ease);
      display: inline-flex; align-items: center; gap: 0.5rem;
    }
    .tab-btn:hover { color: var(--white); }
    .tab-btn.active { color: var(--amber); }
    .tab-btn.active::after {
      content: '';
      position: absolute;
      left: 0; right: 0; bottom: 0;
      height: 3px;
      background: linear-gradient(90deg, transparent, var(--amber), transparent);
      border-radius: 4px;
    }
    .tab-btn .count {
      font-size: 0.7rem;
      padding: 0.15rem 0.5rem;
      background: rgba(245,158,11,0.15);
      border-radius: 100px;
      color: var(--amber);
    }

    .tab-panel {
      padding: 2rem;
      display: none;
      animation: fadeIn 0.4s var(--ease);
    }
    .tab-panel.active { display: block; }

    /* ---------- SECTION 09 — Specs Table ---------- */
    .specs-table {
      width: 100%;
      border-collapse: collapse;
    }
    .specs-table tr {
      border-bottom: 1px solid var(--line);
      transition: background 0.3s var(--ease);
    }
    .specs-table tr:last-child { border-bottom: none; }
    .specs-table tr:hover {
      background: rgba(245,158,11,0.04);
    }
    .specs-table th {
      text-align: left;
      padding: 1rem 1rem 1rem 0;
      font-weight: 600;
      font-size: 0.85rem;
      color: var(--muted);
      width: 35%;
      vertical-align: top;
      text-transform: uppercase;
      letter-spacing: 0.4px;
    }
    .specs-table td {
      padding: 1rem 0;
      font-size: 0.9rem;
      color: var(--white);
    }
    .specs-table td b { color: var(--amber); }

    /* ---------- SECTION 10 — Description Tab ---------- */
    .desc-content h3 {
      font-size: 1.1rem;
      font-weight: 700;
      margin-bottom: 0.8rem;
      color: var(--white);
    }
    .desc-content p {
      color: var(--muted);
      font-size: 0.92rem;
      line-height: 1.8;
      margin-bottom: 1rem;
    }
    .desc-content ul {
      display: flex; flex-direction: column; gap: 0.6rem;
      margin: 1rem 0;
    }
    .desc-content ul li {
      display: flex; gap: 0.7rem;
      font-size: 0.9rem;
      color: var(--muted);
    }
    .desc-content ul li i { color: var(--amber); margin-top: 0.3rem; }

    /* ---------- SECTION 10 — Reviews Tab (3D flip cards) ---------- */
    .reviews-summary {
      display: grid;
      grid-template-columns: 200px 1fr;
      gap: 2rem;
      padding: 1.5rem;
      background: rgba(15,23,42,0.5);
      border: 1px solid var(--line);
      border-radius: var(--radius-sm);
      margin-bottom: 2rem;
      align-items: center;
    }
    .reviews-score { text-align: center; }
    .reviews-score .big-num {
      font-size: 3.5rem;
      font-weight: 900;
      color: var(--amber);
      line-height: 1;
      text-shadow: 0 0 30px var(--amber-glow);
    }
    .reviews-score .stars { justify-content: center; font-size: 1.1rem; margin: 0.5rem 0; }
    .reviews-score small { color: var(--muted); font-size: 0.82rem; }

    .reviews-bars { display: flex; flex-direction: column; gap: 0.5rem; }
    .rating-bar {
      display: flex; align-items: center; gap: 0.7rem;
      font-size: 0.8rem; color: var(--muted);
    }
    .rating-bar .bar-label { min-width: 40px; }
    .rating-bar .bar-track {
      flex: 1;
      height: 6px;
      background: rgba(255,255,255,0.06);
      border-radius: 100px;
      overflow: hidden;
    }
    .rating-bar .bar-fill {
      height: 100%;
      background: linear-gradient(90deg, var(--amber), #fbbf24);
      border-radius: 100px;
      box-shadow: 0 0 10px var(--amber-glow);
    }
    .rating-bar .bar-count { min-width: 40px; text-align: right; }

    .review-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 1.2rem;
    }
    .review-item {
      background: rgba(15,23,42,0.6);
      border: 1px solid var(--line);
      border-radius: var(--radius-sm);
      padding: 1.3rem;
      transition: all 0.35s var(--ease);
      transform-style: preserve-3d;
    }
    .review-item:hover {
      transform: translateY(-6px) translateZ(25px);
      border-color: rgba(245,158,11,0.35);
      box-shadow: 0 25px 40px -15px rgba(0,0,0,0.8);
    }
    .review-head {
      display: flex; align-items: center; gap: 0.8rem;
      margin-bottom: 0.8rem;
    }
    .review-avatar {
      width: 42px; height: 42px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--amber);
    }
    .review-head b { font-size: 0.88rem; display: block; }
    .review-head small { font-size: 0.72rem; color: var(--muted); display: flex; align-items: center; gap: 0.3rem; }
    .review-head small i { color: #22c55e; }
    .review-item .stars { font-size: 0.75rem; margin-bottom: 0.6rem; }
    .review-item p { font-size: 0.85rem; color: var(--muted); line-height: 1.6; }

    /* ============================================================
       SECTION 11 — RELATED & RECENTLY VIEWED
       ============================================================ */
    .related-section { transform-style: preserve-3d; margin-bottom: 3rem; }

    .products-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
      gap: 1.5rem;
      transform-style: preserve-3d;
    }

    .product-card {
      position: relative;
      background: var(--card);
      backdrop-filter: blur(14px);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      padding: 1.1rem;
      box-shadow: 0 18px 35px -18px rgba(0,0,0,0.8);
      transition: all 0.4s var(--ease);
      transform-style: preserve-3d;
      display: flex; flex-direction: column;
      animation: riseUp 0.7s var(--ease) both;
    }
    .product-card:hover {
      transform: translateY(-10px) translateZ(45px) rotateY(3deg);
      border-color: rgba(245,158,11,0.35);
      box-shadow: 0 40px 60px -20px rgba(0,0,0,0.9), 0 0 0 1px var(--amber-glow);
    }
    .product-img {
      position: relative;
      aspect-ratio: 1 / 1;
      border-radius: var(--radius-sm);
      overflow: hidden;
      background: rgba(0,0,0,0.25);
      margin-bottom: 0.9rem;
      transform: translateZ(15px);
    }
    .product-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s var(--ease); }
    .product-card:hover .product-img img { transform: scale(1.08); }

    .tag {
      position: absolute; top: 0.6rem; left: 0.6rem;
      padding: 0.25rem 0.65rem;
      font-size: 0.65rem; font-weight: 800;
      border-radius: 100px; letter-spacing: 0.5px; z-index: 2;
    }
    .tag-sale { background: #ef4444; color: #fff; }
    .tag-new { background: var(--amber); color: #1a1206; }
    .tag-hot { background: #8b5cf6; color: #fff; }

    .wishlist {
      position: absolute; top: 0.6rem; right: 0.6rem;
      width: 32px; height: 32px;
      display: grid; place-items: center;
      border-radius: 50%;
      background: rgba(15,23,42,0.8);
      border: 1px solid var(--line);
      color: var(--white); cursor: pointer; z-index: 2;
      transition: all 0.3s var(--ease);
    }
    .wishlist:hover { color: #ef4444; border-color: #ef4444; transform: scale(1.12); }

    .product-card h3 { font-size: 0.98rem; font-weight: 600; margin-bottom: 0.2rem; }
    .product-cat { font-size: 0.74rem; color: var(--muted); margin-bottom: 0.5rem; }

    .rating { display: flex; align-items: center; gap: 0.3rem; font-size: 0.74rem; color: var(--amber); margin-bottom: 0.6rem; }
    .rating span { color: var(--muted); }

    .price-row { display: flex; align-items: baseline; gap: 0.5rem; margin-top: auto; margin-bottom: 0.8rem; }
    .price-now-sm { font-size: 1.2rem; font-weight: 800; color: var(--amber); }
    .price-old-sm { font-size: 0.82rem; color: var(--muted); text-decoration: line-through; }

    .add-cart {
      width: 100%; padding: 0.7rem;
      border-radius: 60px;
      border: 1px solid rgba(245,158,11,0.4);
      background: rgba(245,158,11,0.1);
      color: var(--amber);
      font-weight: 600; font-size: 0.85rem;
      cursor: pointer;
      transition: all 0.3s var(--ease);
      display: inline-flex; justify-content: center; align-items: center; gap: 0.5rem;
    }
    .add-cart:hover {
      background: var(--amber); color: #1a1206;
      transform: translateZ(20px);
      box-shadow: 0 15px 25px -10px var(--amber-glow);
    }

    /* ============================================================
       FOOTER
       ============================================================ */
    .footer {
      background: linear-gradient(180deg, rgba(15,23,42,0.4), rgba(6,10,18,0.9));
      border-top: 1px solid var(--line);
      padding: 3rem 0 1.5rem;
      margin-top: 2rem;
      transform: translateZ(15px);
    }
    .footer-grid {
      display: grid;
      grid-template-columns: 1.4fr repeat(3, 1fr);
      gap: 2.5rem;
      padding-bottom: 2.2rem;
      border-bottom: 1px solid var(--line);
    }
    .footer-brand p { color: var(--muted); font-size: 0.86rem; max-width: 320px; margin: 1rem 0 1.2rem; }
    .social-row { display: flex; gap: 0.7rem; }
    .social-row a {
      width: 40px; height: 40px;
      display: grid; place-items: center;
      border-radius: 50%;
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--line);
      color: var(--muted);
      transition: all 0.3s var(--ease);
    }
    .social-row a:hover { color: var(--amber); border-color: var(--amber); transform: translateY(-4px) translateZ(15px); }
    .footer-col h5 { font-size: 0.92rem; font-weight: 700; margin-bottom: 1rem; }
    .footer-col ul { display: flex; flex-direction: column; gap: 0.65rem; }
    .footer-col a { color: var(--muted); font-size: 0.85rem; transition: color 0.3s var(--ease); }
    .footer-col a:hover { color: var(--amber); }

    .footer-bottom {
      display: flex; justify-content: space-between; align-items: center;
      gap: 1rem; padding-top: 1.5rem; flex-wrap: wrap;
      color: var(--muted); font-size: 0.8rem;
    }
    .payment-methods { display: flex; gap: 0.9rem; font-size: 1.45rem; color: var(--muted); }
    .payment-methods i:hover { color: var(--amber); }

    /* ============================================================
       ANIMATIONS
       ============================================================ */
    @keyframes riseUp {
      0% { opacity: 0; transform: translateY(30px) scale(0.98); }
      100% { opacity: 1; transform: translateY(0) scale(1); }
    }
    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(6px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    @keyframes pulseGreen {
      0%, 100% { box-shadow: 0 0 0 4px rgba(34,197,94,0.2); }
      50% { box-shadow: 0 0 0 8px rgba(34,197,94,0.05); }
    }
    @keyframes pulseAmber {
      0%, 100% { box-shadow: 0 0 0 4px rgba(245,158,11,0.25); }
      50% { box-shadow: 0 0 0 8px rgba(245,158,11,0.05); }
    }

    /* ============================================================
       RESPONSIVE
       ============================================================ */
    @media (max-width: 1024px) {
      .product-wrap { grid-template-columns: 1fr; gap: 2rem; }
      .gallery { position: static; }
      .reviews-summary { grid-template-columns: 1fr; text-align: center; }
      .footer-grid { grid-template-columns: 1fr 1fr; gap: 2rem; }
    }

    @media (max-width: 640px) {
      body { padding: 0 0.7rem; }
      .announcement-inner { gap: 1rem; font-size: 0.72rem; }
      .search-bar { order: 3; flex: 1 1 100%; }
      .main-nav ul { gap: 1.2rem; font-size: 0.84rem; }
      .product-wrap { padding: 1rem 0.5rem 2.5rem; }
      .gallery-thumbs { grid-template-columns: repeat(4, 1fr); }
      .trust-grid { grid-template-columns: 1fr; }
      .action-buttons { grid-template-columns: 1fr; }
      .specs-table th { width: 45%; font-size: 0.78rem; }
      .specs-table td { font-size: 0.85rem; }
      .tab-panel { padding: 1.3rem; }
      .tab-btn { padding: 0.9rem 1.1rem; font-size: 0.82rem; }
      .products-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem; }
      .product-card { padding: 0.9rem; }
      .product-card h3 { font-size: 0.88rem; }
      .price-now-sm { font-size: 1.05rem; }
      .footer-grid { grid-template-columns: 1fr; gap: 1.8rem; text-align: center; }
      .footer-brand p { margin-left: auto; margin-right: auto; }
      .social-row { justify-content: center; }
      .footer-bottom { flex-direction: column; text-align: center; }
      .stock-row { flex-direction: column; align-items: stretch; }
      .stock-indicator { justify-content: center; }
      .qty-stepper { justify-content: center; }
    }

    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after {
        animation-duration: 0.01ms !important;
        transition-duration: 0.01ms !important;
      }
    }
  </style>
</head>
<body>

<div class="scene">

  <!-- ============================================================
       ANNOUNCEMENT BAR
       ============================================================ -->
  <div class="announcement">
    <div class="announcement-inner">
      <span><i class="fas fa-truck-fast"></i> Free shipping over $99</span>
      <span><i class="fas fa-tags"></i> Up to 40% off — Summer Sale</span>
      <span><i class="fas fa-shield-halved"></i> 2-year warranty</span>
    </div>
  </div>

  <!-- ============================================================
       HEADER & NAVIGATION
       ============================================================ -->
  <header class="header">
    <div class="header-inner container">
      <a href="#" class="logo">
        <span class="logo-mark"><i class="fas fa-bolt"></i></span>
        <span>Electro<b>Hub</b></span>
      </a>

      <form class="search-bar" onsubmit="return false;">
        <i class="fas fa-magnifying-glass"></i>
        <input type="text" placeholder="Search for phones, laptops, headphones...">
      </form>

      <div class="header-icons">
        <a href="#" class="icon-btn" title="Account"><i class="far fa-user"></i></a>
        <a href="#" class="icon-btn" title="Wishlist"><i class="far fa-heart"></i></a>
        <a href="#" class="icon-btn" title="Cart">
          <i class="fas fa-shopping-cart"></i>
          <span class="badge-count">3</span>
        </a>
      </div>
    </div>

    <nav class="main-nav">
      <ul class="container">
        <li><a href="#">Home</a></li>
        <li><a href="#">Shop</a></li>
        <li><a href="#">Categories</a></li>
        <li><a href="#">Deals</a></li>
        <li><a href="#">Brands</a></li>
        <li><a href="#">Reviews</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </nav>
  </header>

  <!-- ============================================================
       SECTION 01 — BREADCRUMB
       ============================================================ -->
  <nav class="breadcrumb-bar container">
    <div class="breadcrumb">
      <a href="#">Home</a>
      <i class="fas fa-chevron-right"></i>
      <a href="#">Smartphones</a>
      <i class="fas fa-chevron-right"></i>
      <a href="#">Apple</a>
      <i class="fas fa-chevron-right"></i>
      <span class="current">iPhone 16 Pro Max</span>
    </div>
  </nav>

  <!-- ============================================================
       PRODUCT MAIN (Gallery + Info)
       ============================================================ -->
  <div class="product-wrap container">

    <!-- ============================================================
         SECTION 02 — PRODUCT GALLERY (3D Viewer)
         ============================================================ -->
    <div class="gallery">
      <div class="gallery-main">
        <span class="gallery-badge">-11% OFF</span>
        <img src="https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=800&auto=format&fit=crop&q=80" alt="iPhone 16 Pro Max">
        <button class="gallery-360" title="360° view"><i class="fas fa-rotate"></i> 360° View</button>
      </div>

      <div class="gallery-thumbs">
        <div class="thumb active"><img src="https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=200&auto=format&fit=crop&q=80" alt="View 1"></div>
        <div class="thumb"><img src="https://images.unsplash.com/photo-1546054454-aa26e2b734c7?w=200&auto=format&fit=crop&q=80" alt="View 2"></div>
        <div class="thumb"><img src="https://images.unsplash.com/photo-1591337676887-a217a6970a8a?w=200&auto=format&fit=crop&q=80" alt="View 3"></div>
        <div class="thumb"><img src="https://images.unsplash.com/photo-1510557880182-3d4d3cba35a5?w=200&auto=format&fit=crop&q=80" alt="View 4"></div>
        <div class="thumb"><img src="https://images.unsplash.com/photo-1580910051074-3eb694886505?w=200&auto=format&fit=crop&q=80" alt="View 5"></div>
      </div>
    </div>

    <!-- ============================================================
         PRODUCT INFO COLUMN
         ============================================================ -->
    <div class="product-info">

      <!-- SECTION 03 — Product Info Panel -->
      <div class="info-panel">
        <div class="brand-row">
          <span class="brand-tag"><i class="fab fa-apple"></i> Apple</span>
          <span class="sku">SKU: EH-APL-16PM-256</span>
        </div>

        <h1>iPhone <span>16 Pro Max</span></h1>

        <div class="rating-row">
          <div class="stars">
            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
            <i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i>
          </div>
          <b>4.8</b>
          <span class="sep">•</span>
          <a href="#reviews">1,247 reviews</a>
          <span class="sep">•</span>
          <span style="color:#22c55e;"><i class="fas fa-circle-check"></i> In Stock</span>
        </div>

        <p class="short-desc">
          The most powerful iPhone ever. Titanium build, A18 Pro chip, 48MP Fusion camera system, and the longest battery life in an iPhone — all in a stunning 6.9" Super Retina XDR display.
        </p>

        <div class="quick-features">
          <span class="quick-feature"><i class="fas fa-microchip"></i> A18 Pro chip</span>
          <span class="quick-feature"><i class="fas fa-camera"></i> 48MP Triple cam</span>
          <span class="quick-feature"><i class="fas fa-battery-full"></i> 33h video</span>
          <span class="quick-feature"><i class="fas fa-mobile-screen"></i> 6.9" OLED</span>
        </div>
      </div>

      <!-- SECTION 04 — Price & Offers Box -->
      <div class="price-box">
        <div class="price-main">
          <span class="price-now">$1,199</span>
          <span class="price-old">$1,349</span>
          <span class="price-discount">-11%</span>
        </div>
        <div class="price-savings">You save <b>$150.00</b> — limited time offer</div>

        <div class="offers-list">
          <div class="offer-item"><i class="fas fa-tag"></i> <span><b>SUMMER10:</b> Extra 10% off at checkout</span></div>
          <div class="offer-item"><i class="fas fa-truck-fast"></i> <span><b>Free express shipping</b> on orders over $99</span></div>
          <div class="offer-item"><i class="fas fa-credit-card"></i> <span>0% installment plan for <b>12 months</b> available</span></div>
        </div>
      </div>

      <!-- SECTION 05 — Variants & Options Selector -->
      <div class="variants">
        <div class="variant-group">
          <div class="variant-label"><span>Color: <b>Desert Titanium</b></span></div>
          <div class="color-options">
            <span class="color-opt active" style="background:#c9b8a8;" title="Desert Titanium"></span>
            <span class="color-opt" style="background:#1f2937;" title="Black Titanium"></span>
            <span class="color-opt" style="background:#e5e7eb;" title="White Titanium"></span>
            <span class="color-opt" style="background:#9ca3af;" title="Natural Titanium"></span>
          </div>
        </div>

        <div class="variant-group">
          <div class="variant-label"><span>Storage: <b>256 GB</b></span></div>
          <div class="size-options">
            <div class="size-opt">128 GB<small>+$0</small></div>
            <div class="size-opt active">256 GB<small>+$100</small></div>
            <div class="size-opt">512 GB<small>+$300</small></div>
            <div class="size-opt">1 TB<small>+$500</small></div>
          </div>
        </div>

        <div class="variant-group">
          <div class="variant-label"><span>RAM: <b>8 GB</b></span></div>
          <div class="size-options">
            <div class="size-opt active">8 GB<small>Standard</small></div>
            <div class="size-opt">12 GB<small>Coming soon</small></div>
          </div>
        </div>
      </div>

      <!-- SECTION 06 — Quantity & Stock Indicator -->
      <div class="stock-row">
        <div class="stock-indicator in-stock">
          <span class="stock-dot"></span>
          <span>In Stock <small>· Ships within 24h</small></span>
        </div>

        <div class="qty-stepper">
          <button class="qty-btn" aria-label="Decrease"><i class="fas fa-minus"></i></button>
          <span class="qty-value">1</span>
          <button class="qty-btn" aria-label="Increase"><i class="fas fa-plus"></i></button>
        </div>
      </div>

      <!-- SECTION 07 — Add-to-Cart Actions -->
      <div class="action-buttons">
        <button class="btn btn-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
        <button class="btn btn-buy"><i class="fas fa-bolt"></i> Buy Now</button>
        <button class="btn-icon"><i class="far fa-heart"></i> Wishlist</button>
        <button class="btn-icon"><i class="fas fa-right-left"></i> Compare</button>
      </div>

      <!-- SECTION 08 — Trust & Delivery Info -->
      <div class="trust-box">
        <div class="trust-grid">
          <div class="trust-item">
            <i class="fas fa-truck-fast"></i>
            <div><b>Free Delivery</b><small>On orders over $99</small></div>
          </div>
          <div class="trust-item">
            <i class="fas fa-shield-halved"></i>
            <div><b>2-Year Warranty</b><small>Official Apple warranty</small></div>
          </div>
          <div class="trust-item">
            <i class="fas fa-rotate-left"></i>
            <div><b>30-Day Returns</b><small>Hassle-free returns</small></div>
          </div>
          <div class="trust-item">
            <i class="fas fa-lock"></i>
            <div><b>Secure Payment</b><small>100% encrypted</small></div>
          </div>
        </div>

        <div class="delivery-row">
          <i class="fas fa-calendar-check"></i>
          <span>Order today, get it by <b>Thursday, Oct 24</b></span>
        </div>

        <div class="payment-row">
          <span>We accept:</span>
          <i class="fab fa-cc-visa"></i>
          <i class="fab fa-cc-mastercard"></i>
          <i class="fab fa-cc-paypal"></i>
          <i class="fab fa-cc-apple-pay"></i>
          <i class="fas fa-money-bill-wave"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- ============================================================
       SECTION 09 + 10 — SPECS + DESCRIPTION + REVIEWS (Tabs)
       ============================================================ -->
  <section class="container" id="reviews">
    <div class="tabs-wrap">
      <div class="tabs-header">
        <button class="tab-btn active" data-tab="specs"><i class="fas fa-list-check"></i> Specifications</button>
        <button class="tab-btn" data-tab="description"><i class="fas fa-align-left"></i> Description</button>
        <button class="tab-btn" data-tab="reviews"><i class="fas fa-star"></i> Reviews <span class="count">1,247</span></button>
        <button class="tab-btn" data-tab="shipping"><i class="fas fa-truck"></i> Shipping</button>
      </div>

      <!-- SECTION 09 — Specifications Tab -->
      <div class="tab-panel active" data-panel="specs">
        <table class="specs-table">
          <tr><th>Display</th><td>6.9" Super Retina XDR OLED, 2868 x 1320 px, 120Hz ProMotion</td></tr>
          <tr><th>Processor</th><td><b>A18 Pro</b> chip, 6-core CPU, 6-core GPU, 16-core Neural Engine</td></tr>
          <tr><th>RAM</th><td>8 GB</td></tr>
          <tr><th>Storage</th><td>256 GB (128 GB / 512 GB / 1 TB variants available)</td></tr>
          <tr><th>Main Camera</th><td>48 MP Fusion + 48 MP Ultra Wide + 12 MP 5x Telephoto</td></tr>
          <tr><th>Front Camera</th><td>12 MP TrueDepth, autofocus, 4K Dolby Vision</td></tr>
          <tr><th>Battery</th><td>4,685 mAh, up to 33h video playback</td></tr>
          <tr><th>Charging</th><td>USB-C, 45W wired fast charge, 25W MagSafe wireless</td></tr>
          <tr><th>Operating System</th><td>iOS 18 (upgradeable)</td></tr>
          <tr><th>Connectivity</th><td>5G, Wi-Fi 7, Bluetooth 5.3, NFC, Ultra Wideband</td></tr>
          <tr><th>Water Resistance</th><td>IP68 — up to 6m for 30 minutes</td></tr>
          <tr><th>Dimensions</th><td>163.0 × 77.6 × 8.25 mm</td></tr>
          <tr><th>Weight</th><td>227 g</td></tr>
          <tr><th>Material</th><td>Titanium frame, Ceramic Shield front, textured matte glass back</td></tr>
        </table>
      </div>

      <!-- SECTION 10 — Description Tab -->
      <div class="tab-panel" data-panel="description">
        <div class="desc-content">
          <h3>About the iPhone 16 Pro Max</h3>
          <p>The iPhone 16 Pro Max is Apple's most advanced smartphone yet, featuring a stunning 6.9-inch Super Retina XDR display, an aerospace-grade titanium frame, and the blazing-fast A18 Pro chip. It delivers desktop-class performance, exceptional camera capabilities, and all-day battery life in one elegant device.</p>

          <h3>Key Highlights</h3>
          <ul>
            <li><i class="fas fa-check"></i> <span>6.9" ProMotion display with 120Hz adaptive refresh rate</span></li>
            <li><i class="fas fa-check"></i> <span>A18 Pro chip — up to 40% faster than previous generation</span></li>
            <li><i class="fas fa-check"></i> <span>48MP Fusion camera with 5x optical zoom telephoto lens</span></li>
            <li><i class="fas fa-check"></i> <span>USB-C with USB 3 speeds for pro workflows</span></li>
            <li><i class="fas fa-check"></i> <span>Action Button + Camera Control for instant shortcuts</span></li>
            <li><i class="fas fa-check"></i> <span>Up to 33 hours of video playback on a single charge</span></li>
            <li><i class="fas fa-check"></i> <span>iOS 18 with Apple Intelligence built-in</span></li>
          </ul>

          <h3>What's in the Box</h3>
          <p>iPhone 16 Pro Max, USB-C Charge Cable (1m), Documentation. (Note: no power adapter or EarPods included, as per Apple's environmental policy.)</p>
        </div>
      </div>

      <!-- SECTION 10 — Reviews Tab -->
      <div class="tab-panel" data-panel="reviews">
        <div class="reviews-summary">
          <div class="reviews-score">
            <div class="big-num">4.8</div>
            <div class="stars">
              <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
              <i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i>
            </div>
            <small>Based on 1,247 reviews</small>
          </div>

          <div class="reviews-bars">
            <div class="rating-bar">
              <span class="bar-label">5 ★</span>
              <span class="bar-track"><span class="bar-fill" style="width:78%;"></span></span>
              <span class="bar-count">973</span>
            </div>
            <div class="rating-bar">
              <span class="bar-label">4 ★</span>
              <span class="bar-track"><span class="bar-fill" style="width:15%;"></span></span>
              <span class="bar-count">187</span>
            </div>
            <div class="rating-bar">
              <span class="bar-label">3 ★</span>
              <span class="bar-track"><span class="bar-fill" style="width:5%;"></span></span>
              <span class="bar-count">62</span>
            </div>
            <div class="rating-bar">
              <span class="bar-label">2 ★</span>
              <span class="bar-track"><span class="bar-fill" style="width:1%;"></span></span>
              <span class="bar-count">15</span>
            </div>
            <div class="rating-bar">
              <span class="bar-label">1 ★</span>
              <span class="bar-track"><span class="bar-fill" style="width:1%;"></span></span>
              <span class="bar-count">10</span>
            </div>
          </div>
        </div>

        <div class="review-cards">
          <div class="review-item">
            <div class="review-head">
              <img class="review-avatar" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&auto=format&fit=crop&q=80" alt="Reviewer">
              <div><b>Ahmed R.</b><small><i class="fas fa-circle-check"></i> Verified Purchase</small></div>
            </div>
            <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
            <p>"Absolutely incredible phone. The camera is a huge upgrade from my old 13 Pro, and the battery easily lasts me a full day of heavy use. Worth every dollar."</p>
          </div>

          <div class="review-item">
            <div class="review-head">
              <img class="review-avatar" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&auto=format&fit=crop&q=80" alt="Reviewer">
              <div><b>Sarah M.</b><small><i class="fas fa-circle-check"></i> Verified Purchase</small></div>
            </div>
            <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i></div>
            <p>"Beautiful titanium finish and feels lighter than expected. The ProMotion display is buttery smooth. Only minor issue: it's a bit pricey."</p>
          </div>

          <div class="review-item">
            <div class="review-head">
              <img class="review-avatar" src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?w=100&auto=format&fit=crop&q=80" alt="Reviewer">
              <div><b>Omar K.</b><small><i class="fas fa-circle-check"></i> Verified Purchase</small></div>
            </div>
            <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
            <p>"ElectroHub delivered it next day in perfect condition. The 5x zoom is amazing, and Apple Intelligence is genuinely useful for daily tasks."</p>
          </div>
        </div>
      </div>

      <!-- Shipping Tab -->
      <div class="tab-panel" data-panel="shipping">
        <div class="desc-content">
          <h3>Shipping Information</h3>
          <p>We offer multiple shipping options to get your order to you as quickly as possible. All orders are processed within 24 hours and dispatched with tracking.</p>
          <ul>
            <li><i class="fas fa-truck-fast"></i> <span><b>Standard Shipping</b> — $9.99, 3–5 business days (Free on orders over $99)</span></li>
            <li><i class="fas fa-bolt"></i> <span><b>Express Shipping</b> — $19.99, 1–2 business days</span></li>
            <li><i class="fas fa-plane"></i> <span><b>International</b> — Calculated at checkout, 7–14 business days</span></li>
          </ul>

          <h3>Returns & Warranty</h3>
          <p>Not satisfied? Return your device within 30 days of delivery for a full refund — no questions asked. Every product includes the official manufacturer's 2-year warranty.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 11 — RELATED & RECENTLY VIEWED PRODUCTS
       ============================================================ -->
  <section class="related-section container">
    <div class="section-head">
      <h2>You May Also Like</h2>
      <p>Similar products picked just for you</p>
    </div>

    <div class="products-grid">
      <article class="product-card">
        <div class="product-img">
          <span class="tag tag-hot">HOT</span>
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=500&auto=format&fit=crop&q=80" alt="Galaxy S25">
        </div>
        <h3>Galaxy S25 Ultra</h3>
        <div class="product-cat">Samsung</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.9)</span></div>
        <div class="price-row"><span class="price-now-sm">$1,299</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <article class="product-card">
        <div class="product-img">
          <span class="tag tag-new">NEW</span>
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1601784551446-20c9e07cdbdb?w=500&auto=format&fit=crop&q=80" alt="Pixel 9 Pro">
        </div>
        <h3>Pixel 9 Pro</h3>
        <div class="product-cat">Google</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.8)</span></div>
        <div class="price-row"><span class="price-now-sm">$999</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <article class="product-card">
        <div class="product-img">
          <span class="tag tag-sale">-15%</span>
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?w=500&auto=format&fit=crop&q=80" alt="iPhone 16">
        </div>
        <h3>iPhone 16</h3>
        <div class="product-cat">Apple</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.8)</span></div>
        <div class="price-row"><span class="price-now-sm">$899</span><span class="price-old-sm">$1,059</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <article class="product-card">
        <div class="product-img">
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1585060544812-6b45742d762f?w=500&auto=format&fit=crop&q=80" alt="Xiaomi 15">
        </div>
        <h3>Xiaomi 15 Ultra</h3>
        <div class="product-cat">Xiaomi</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.9)</span></div>
        <div class="price-row"><span class="price-now-sm">$1,099</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>
    </div>
  </section>

  <!-- ============================================================
       RECENTLY VIEWED
       ============================================================ -->
  <section class="related-section container">
    <div class="section-head">
      <h2>Recently Viewed</h2>
      <p>Pick up where you left off</p>
    </div>

    <div class="products-grid">
      <article class="product-card">
        <div class="product-img">
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=500&auto=format&fit=crop&q=80" alt="Apple Watch">
        </div>
        <h3>Apple Watch Ultra 2</h3>
        <div class="product-cat">Apple • Wearable</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.9)</span></div>
        <div class="price-row"><span class="price-now-sm">$799</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <article class="product-card">
        <div class="product-img">
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&auto=format&fit=crop&q=80" alt="AirPods Max">
        </div>
        <h3>AirPods Max</h3>
        <div class="product-cat">Apple • Audio</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.8)</span></div>
        <div class="price-row"><span class="price-now-sm">$449</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <article class="product-card">
        <div class="product-img">
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500&auto=format&fit=crop&q=80" alt="MacBook">
        </div>
        <h3>MacBook Pro 14"</h3>
        <div class="product-cat">Apple • Laptop</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(5.0)</span></div>
        <div class="price-row"><span class="price-now-sm">$1,999</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <article class="product-card">
        <div class="product-img">
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1567581935884-3349723552ca?w=500&auto=format&fit=crop&q=80" alt="iPad Air">
        </div>
        <h3>iPad Air 11"</h3>
        <div class="product-cat">Apple • Tablet</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i> <span>(4.4)</span></div>
        <div class="price-row"><span class="price-now-sm">$419</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>
    </div>
  </section>

  <!-- ============================================================
       FOOTER
       ============================================================ -->
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <a href="#" class="logo">
            <span class="logo-mark"><i class="fas fa-bolt"></i></span>
            <span>Electro<b>Hub</b></span>
          </a>
          <p>Technology. Everything in one place. Your trusted destination for authentic electronics and premium service.</p>
          <div class="social-row">
            <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" title="Twitter"><i class="fab fa-x-twitter"></i></a>
            <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
          </div>
        </div>

        <div class="footer-col">
          <h5>Shop</h5>
          <ul>
            <li><a href="#">Smartphones</a></li>
            <li><a href="#">Laptops</a></li>
            <li><a href="#">Tablets</a></li>
            <li><a href="#">Headphones</a></li>
            <li><a href="#">Accessories</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h5>Customer Service</h5>
          <ul>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Shipping & Returns</a></li>
            <li><a href="#">Warranty</a></li>
            <li><a href="#">Track Order</a></li>
            <li><a href="#">FAQs</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h5>Company</h5>
          <ul>
            <li><a href="#">About ElectroHub</a></li>
            <li><a href="#">Careers</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms of Service</a></li>
            <li><a href="#">Blog</a></li>
          </ul>
        </div>
      </div>

      <div class="footer-bottom">
        <span>© 2025 ElectroHub. All rights reserved.</span>
        <div class="payment-methods">
          <i class="fab fa-cc-visa"></i>
          <i class="fab fa-cc-mastercard"></i>
          <i class="fab fa-cc-paypal"></i>
          <i class="fab fa-cc-apple-pay"></i>
          <i class="fas fa-money-bill-wave"></i>
        </div>
      </div>
    </div>
  </footer>

</div>

<script>
  // Simple tab switching (no framework needed)
  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const tab = btn.dataset.tab;
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
      btn.classList.add('active');
      document.querySelector(`.tab-panel[data-panel="${tab}"]`).classList.add('active');
    });
  });
</script>

</body>
</html>
