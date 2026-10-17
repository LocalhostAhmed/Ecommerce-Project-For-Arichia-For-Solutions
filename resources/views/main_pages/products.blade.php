<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Products | ElectroHub</title>

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

    /* Section headings */
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

    /* Buttons */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      padding: 0.8rem 1.6rem;
      border-radius: 60px;
      font-weight: 600;
      font-size: 0.9rem;
      transition: all 0.35s var(--ease);
      border: 1px solid transparent;
      cursor: pointer;
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
    .btn-ghost {
      background: rgba(255,255,255,0.04);
      border-color: var(--line);
      color: var(--white);
      backdrop-filter: blur(6px);
    }
    .btn-ghost:hover {
      border-color: var(--amber);
      color: var(--amber);
      transform: translateY(-4px) translateZ(20px);
    }

    /* ============================================================
       SECTION 1 — ANNOUNCEMENT BAR
       ============================================================ */
    .announcement {
      background: linear-gradient(90deg, #1E293B, #0F172A 50%, #1E293B);
      border-bottom: 1px solid var(--line);
      font-size: 0.82rem;
      color: var(--muted);
      transform: translateZ(10px);
    }
    .announcement-inner {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 2.2rem;
      padding: 0.55rem 1rem;
      flex-wrap: wrap;
    }
    .announcement span { display: inline-flex; align-items: center; gap: 0.4rem; }
    .announcement i { color: var(--amber); }

    /* ============================================================
       SECTION 2 — HEADER & NAVIGATION (same as homepage)
       ============================================================ */
    .header {
      position: sticky;
      top: 0;
      z-index: 100;
      background: rgba(15, 23, 42, 0.8);
      backdrop-filter: blur(18px);
      border-bottom: 1px solid var(--line);
      transform: translateZ(20px);
    }
    .header-inner {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1.5rem;
      padding: 1rem 0.5rem;
      flex-wrap: wrap;
    }

    .logo { display: flex; align-items: center; gap: 0.6rem; font-size: 1.5rem; font-weight: 900; letter-spacing: -0.03em; }
    .logo-mark {
      width: 42px; height: 42px;
      display: grid; place-items: center;
      border-radius: 13px;
      background: linear-gradient(145deg, var(--amber), #b45309);
      color: #1a1206;
      font-size: 1.2rem;
      box-shadow: 0 10px 22px -6px var(--amber-glow), inset 0 1px 0 rgba(255,255,255,0.4);
      transform: translateZ(15px);
    }
    .logo b { color: var(--amber); }

    .search-bar {
      flex: 1 1 320px;
      display: flex;
      align-items: center;
      gap: 0.6rem;
      background: rgba(255,255,255,0.05);
      border: 1px solid var(--line);
      border-radius: 60px;
      padding: 0.55rem 1.1rem;
      transition: all 0.3s var(--ease);
      transform: translateZ(10px);
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
      position: relative;
      width: 42px; height: 42px;
      display: grid; place-items: center;
      border-radius: 50%;
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--line);
      color: var(--white);
      transition: all 0.3s var(--ease);
      cursor: pointer;
    }
    .icon-btn:hover {
      color: var(--amber);
      border-color: var(--amber);
      transform: translateY(-3px) translateZ(15px);
    }
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
    .main-nav a {
      position: relative; padding: 0.3rem 0;
      transition: color 0.3s var(--ease);
    }
    .main-nav a::after {
      content: ''; position: absolute; left: 0; bottom: -2px;
      width: 0; height: 2px; background: var(--amber);
      transition: width 0.3s var(--ease);
    }
    .main-nav a:hover, .main-nav a.active { color: var(--amber); }
    .main-nav a:hover::after, .main-nav a.active::after { width: 100%; }

    /* ============================================================
       SECTION 3 — PAGE HERO / BANNER
       ============================================================ */
    .page-hero {
      padding: 3.5rem 0.5rem 2rem;
      text-align: center;
      transform: translateZ(30px);
    }
    .page-hero h1 {
      font-size: clamp(2rem, 5vw, 3rem);
      font-weight: 900;
      letter-spacing: -0.03em;
      line-height: 1.1;
      text-shadow: 0 20px 35px rgba(0,0,0,0.6);
    }
    .page-hero h1 span {
      background: linear-gradient(135deg, var(--amber), #fbbf24, #fde68a);
      -webkit-background-clip: text; background-clip: text; color: transparent;
    }
    .page-hero p { color: var(--muted); max-width: 560px; margin: 0.8rem auto 0; font-size: 1rem; }

    /* Breadcrumb */
    .breadcrumb {
      display: flex; justify-content: center; align-items: center;
      gap: 0.6rem; margin-top: 1.2rem;
      font-size: 0.82rem; color: var(--muted);
      flex-wrap: wrap;
    }
    .breadcrumb a { color: var(--muted); transition: color 0.3s var(--ease); }
    .breadcrumb a:hover { color: var(--amber); }
    .breadcrumb i { font-size: 0.65rem; opacity: 0.6; }
    .breadcrumb .current { color: var(--amber); font-weight: 600; }

    /* ============================================================
       SECTION 4 — SHOP TOOLBAR (filter bar top)
       ============================================================ */
    .shop-toolbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 1rem;
      flex-wrap: wrap;
      background: var(--card);
      backdrop-filter: blur(14px);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      padding: 1rem 1.3rem;
      margin: 1.5rem 0;
      transform: translateZ(20px);
      box-shadow: 0 18px 35px -18px rgba(0,0,0,0.8);
    }
    .toolbar-left { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
    .results-count { color: var(--muted); font-size: 0.88rem; }
    .results-count b { color: var(--amber); }
    .filter-toggle {
      display: inline-flex; align-items: center; gap: 0.5rem;
      padding: 0.55rem 1.1rem;
      border-radius: 60px;
      background: rgba(245,158,11,0.12);
      border: 1px solid rgba(245,158,11,0.35);
      color: var(--amber);
      font-weight: 600; font-size: 0.85rem;
      cursor: pointer;
      transition: all 0.3s var(--ease);
    }
    .filter-toggle:hover { transform: translateY(-3px) translateZ(15px); box-shadow: 0 15px 25px -10px var(--amber-glow); }

    .sort-select {
      display: flex; align-items: center; gap: 0.6rem;
      background: rgba(15,23,42,0.7);
      border: 1px solid var(--line);
      border-radius: 60px;
      padding: 0.5rem 1.1rem;
      font-size: 0.85rem;
    }
    .sort-select label { color: var(--muted); }
    .sort-select select {
      background: transparent; border: none; outline: none;
      color: var(--white); font-family: inherit; font-size: 0.85rem;
      cursor: pointer;
    }
    .sort-select select option { background: var(--navy); color: var(--white); }

    /* ============================================================
       SECTION 5 — SIDEBAR FILTERS + PRODUCT GRID WRAPPER
       ============================================================ */
    .shop-layout {
      display: grid;
      grid-template-columns: 260px 1fr;
      gap: 2rem;
      transform-style: preserve-3d;
    }

    /* ---------- SIDEBAR FILTERS ---------- */
    .filters {
      background: var(--card);
      backdrop-filter: blur(14px);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      padding: 1.5rem;
      box-shadow: 0 18px 35px -18px rgba(0,0,0,0.8);
      height: fit-content;
      position: sticky;
      top: 140px;
      transform: translateZ(15px);
    }
    .filters h3 {
      font-size: 1rem; font-weight: 800;
      margin-bottom: 1.2rem;
      display: flex; align-items: center; gap: 0.5rem;
      color: var(--amber);
    }
    .filter-group { margin-bottom: 1.6rem; padding-bottom: 1.4rem; border-bottom: 1px solid var(--line); }
    .filter-group:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
    .filter-group h4 {
      font-size: 0.85rem; font-weight: 700;
      margin-bottom: 0.9rem; color: var(--white);
      text-transform: uppercase; letter-spacing: 0.5px;
    }
    .filter-option {
      display: flex; align-items: center; gap: 0.7rem;
      padding: 0.4rem 0; font-size: 0.85rem; color: var(--muted);
      cursor: pointer; transition: color 0.3s var(--ease);
    }
    .filter-option:hover { color: var(--amber); }
    .filter-option input { accent-color: var(--amber); cursor: pointer; }
    .filter-option .count { margin-left: auto; font-size: 0.72rem; opacity: 0.7; }

    .price-range { display: flex; flex-direction: column; gap: 0.7rem; }
    .price-range input[type="range"] {
      width: 100%; accent-color: var(--amber); cursor: pointer;
    }
    .price-values {
      display: flex; justify-content: space-between;
      font-size: 0.8rem; color: var(--muted);
    }
    .price-values b { color: var(--amber); }

    /* ---------- PRODUCTS AREA ---------- */
    .products-area { transform-style: preserve-3d; }

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
    .product-img img {
      width: 100%; height: 100%;
      object-fit: cover;
      transition: transform 0.5s var(--ease);
    }
    .product-card:hover .product-img img { transform: scale(1.08); }

    .tag {
      position: absolute; top: 0.6rem; left: 0.6rem;
      padding: 0.25rem 0.65rem;
      font-size: 0.65rem; font-weight: 800;
      border-radius: 100px;
      letter-spacing: 0.5px;
      z-index: 2;
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
    .price-now { font-size: 1.2rem; font-weight: 800; color: var(--amber); }
    .price-old { font-size: 0.82rem; color: var(--muted); text-decoration: line-through; }

    .add-cart {
      width: 100%;
      padding: 0.7rem;
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
       SECTION 6 — PAGINATION
       ============================================================ */
    .pagination {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 0.5rem;
      margin: 3.5rem 0 4rem;
      flex-wrap: wrap;
      transform: translateZ(25px);
    }
    .page-btn {
      min-width: 44px; height: 44px;
      padding: 0 0.7rem;
      display: grid; place-items: center;
      border-radius: 14px;
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--line);
      color: var(--white);
      font-weight: 600; font-size: 0.9rem;
      cursor: pointer;
      transition: all 0.3s var(--ease);
      text-decoration: none;
    }
    .page-btn:hover {
      border-color: var(--amber);
      color: var(--amber);
      transform: translateY(-3px) translateZ(15px);
    }
    .page-btn.active {
      background: linear-gradient(145deg, #fbbf24, #f59e0b);
      color: #1a1206;
      border-color: var(--amber);
      box-shadow: 0 12px 25px -8px var(--amber-glow);
    }
    .page-btn.disabled { opacity: 0.35; pointer-events: none; }
    .page-dots { color: var(--muted); padding: 0 0.3rem; }

    /* ============================================================
       SECTION 7 — NEWSLETTER (reused CTA)
       ============================================================ */
    .newsletter {
      margin: 3rem 0 4rem;
      background: linear-gradient(135deg, rgba(245,158,11,0.16), rgba(30,41,59,0.7));
      border: 1px solid rgba(245,158,11,0.3);
      border-radius: 2rem;
      padding: 2.5rem 2rem;
      text-align: center;
      transform: translateZ(30px);
      box-shadow: 0 30px 60px -25px rgba(0,0,0,0.9);
    }
    .newsletter h2 { font-size: clamp(1.4rem, 3vw, 2rem); font-weight: 800; margin-bottom: 0.6rem; }
    .newsletter p { color: var(--muted); max-width: 520px; margin: 0 auto 1.6rem; font-size: 0.92rem; }
    .newsletter-form {
      display: flex; gap: 0.7rem; max-width: 520px;
      margin: 0 auto; flex-wrap: wrap; justify-content: center;
    }
    .newsletter-form input {
      flex: 1 1 260px;
      padding: 0.85rem 1.3rem;
      border-radius: 60px;
      border: 1px solid var(--line);
      background: rgba(15,23,42,0.7);
      color: var(--white);
      font-size: 0.9rem;
      outline: none;
      transition: all 0.3s var(--ease);
    }
    .newsletter-form input:focus { border-color: var(--amber); box-shadow: 0 0 0 4px var(--amber-glow); }

    /* ============================================================
       SECTION 8 — FOOTER (reused)
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

    /* ============================================================
       RESPONSIVE
       ============================================================ */
    @media (max-width: 1024px) {
      .shop-layout { grid-template-columns: 1fr; }
      .filters { position: static; }
      .footer-grid { grid-template-columns: 1fr 1fr; gap: 2rem; }
    }

    @media (max-width: 640px) {
      body { padding: 0 0.7rem; }
      .announcement-inner { gap: 1rem; font-size: 0.72rem; }
      .search-bar { order: 3; flex: 1 1 100%; }
      .main-nav ul { gap: 1.2rem; font-size: 0.84rem; }
      .shop-toolbar { flex-direction: column; align-items: stretch; }
      .toolbar-left { justify-content: space-between; }
      .products-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem; }
      .product-card { padding: 0.9rem; }
      .product-card h3 { font-size: 0.88rem; }
      .price-now { font-size: 1.05rem; }
      .page-hero { padding: 2.5rem 0.5rem 1.5rem; }
      .newsletter { padding: 2rem 1.2rem; }
      .footer-grid { grid-template-columns: 1fr; gap: 1.8rem; text-align: center; }
      .footer-brand p { margin-left: auto; margin-right: auto; }
      .social-row { justify-content: center; }
      .footer-bottom { flex-direction: column; text-align: center; }
      .pagination { gap: 0.35rem; }
      .page-btn { min-width: 38px; height: 38px; font-size: 0.82rem; border-radius: 12px; }
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
       SECTION 1 — ANNOUNCEMENT BAR
       ============================================================ -->
  <div class="announcement">
    <div class="announcement-inner">
      <span><i class="fas fa-truck-fast"></i> Free shipping over $99</span>
      <span><i class="fas fa-tags"></i> Up to 40% off — Summer Sale</span>
      <span><i class="fas fa-shield-halved"></i> 2-year warranty</span>
    </div>
  </div>

  <!-- ============================================================
       SECTION 2 — HEADER & NAVIGATION
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
        <li><a href="#" class="active">Shop</a></li>
        <li><a href="#">Categories</a></li>
        <li><a href="#">Deals</a></li>
        <li><a href="#">Brands</a></li>
        <li><a href="#">Reviews</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </nav>
  </header>

  <!-- ============================================================
       SECTION 3 — PAGE HERO / BREADCRUMB
       ============================================================ -->
  <section class="page-hero container">
    <h1>All <span>Products</span></h1>
    <p>Browse the complete ElectroHub catalog — from smartphones to accessories, all in one place.</p>
    <nav class="breadcrumb">
      <a href="#">Home</a>
      <i class="fas fa-chevron-right"></i>
      <a href="#">Shop</a>
      <i class="fas fa-chevron-right"></i>
      <span class="current">All Products</span>
    </nav>
  </section>

  <!-- ============================================================
       SECTION 4 — SHOP TOOLBAR
       ============================================================ -->
  <div class="container">
    <div class="shop-toolbar">
      <div class="toolbar-left">
        <button class="filter-toggle"><i class="fas fa-filter"></i> Filters</button>
        <span class="results-count">Showing <b>1–12</b> of <b>48</b> products</span>
      </div>

      <div class="sort-select">
        <label for="sort"><i class="fas fa-arrow-up-wide-short"></i> Sort:</label>
        <select id="sort">
          <option>Featured</option>
          <option>Newest</option>
          <option>Price: Low → High</option>
          <option>Price: High → Low</option>
          <option>Top Rated</option>
          <option>Best Selling</option>
        </select>
      </div>
    </div>
  </div>

  <!-- ============================================================
       SECTION 5 — SIDEBAR FILTERS + PRODUCT GRID
       ============================================================ -->
  <div class="container">
    <div class="shop-layout">

      <!-- ---------- SIDEBAR FILTERS ---------- -->
      <aside class="filters">
        <h3><i class="fas fa-sliders"></i> Refine Results</h3>

        <div class="filter-group">
          <h4>Category</h4>
          <label class="filter-option"><input type="checkbox" checked> Smartphones <span class="count">(12)</span></label>
          <label class="filter-option"><input type="checkbox"> Laptops <span class="count">(9)</span></label>
          <label class="filter-option"><input type="checkbox"> Tablets <span class="count">(6)</span></label>
          <label class="filter-option"><input type="checkbox"> Headphones <span class="count">(8)</span></label>
          <label class="filter-option"><input type="checkbox"> Smartwatches <span class="count">(5)</span></label>
          <label class="filter-option"><input type="checkbox"> Accessories <span class="count">(8)</span></label>
        </div>

        <div class="filter-group">
          <h4>Price Range</h4>
          <div class="price-range">
            <input type="range" min="0" max="2000" value="1200">
            <div class="price-values"><span>Min: <b>$0</b></span><span>Max: <b>$2000</b></span></div>
          </div>
        </div>

        <div class="filter-group">
          <h4>Brand</h4>
          <label class="filter-option"><input type="checkbox"> Apple</label>
          <label class="filter-option"><input type="checkbox"> Samsung</label>
          <label class="filter-option"><input type="checkbox"> Lenovo</label>
          <label class="filter-option"><input type="checkbox"> Dell</label>
          <label class="filter-option"><input type="checkbox"> Sony</label>
        </div>

        <div class="filter-group">
          <h4>Rating</h4>
          <label class="filter-option"><input type="radio" name="rating"> ★★★★★ 5.0</label>
          <label class="filter-option"><input type="radio" name="rating"> ★★★★☆ & up</label>
          <label class="filter-option"><input type="radio" name="rating"> ★★★☆☆ & up</label>
        </div>

        <div class="filter-group">
          <h4>Availability</h4>
          <label class="filter-option"><input type="checkbox" checked> In Stock</label>
          <label class="filter-option"><input type="checkbox"> On Sale</label>
        </div>
      </aside>

      <!-- ---------- PRODUCTS GRID ---------- -->
      <div class="products-area">
        <div class="products-grid">

          <!-- 1 -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-sale">-15%</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?w=500&auto=format&fit=crop&q=80" alt="Nova Pro">
            </div>
            <h3>Nova Pro 5G</h3>
            <div class="product-cat">Smartphone</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.8)</span></div>
            <div class="price-row"><span class="price-now">$799</span><span class="price-old">$939</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 2 -->
          <article class="product-card">
            <div class="product-img">
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500&auto=format&fit=crop&q=80" alt="AeroBook">
            </div>
            <h3>AeroBook Pro 14</h3>
            <div class="product-cat">Laptop</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.9)</span></div>
            <div class="price-row"><span class="price-now">$1,299</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 3 -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-hot">HOT</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&auto=format&fit=crop&q=80" alt="EchoPods">
            </div>
            <h3>EchoPods Max</h3>
            <div class="product-cat">Headphones</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.7)</span></div>
            <div class="price-row"><span class="price-now">$359</span><span class="price-old">$449</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 4 -->
          <article class="product-card">
            <div class="product-img">
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=500&auto=format&fit=crop&q=80" alt="Pulse Watch">
            </div>
            <h3>Pulse Watch Ultra</h3>
            <div class="product-cat">Smartwatch</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.9)</span></div>
            <div class="price-row"><span class="price-now">$349</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 5 -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-new">NEW</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1567581935884-3349723552ca?w=500&auto=format&fit=crop&q=80" alt="Tab Air">
            </div>
            <h3>Tab Air 11"</h3>
            <div class="product-cat">Tablet</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i> <span>(4.4)</span></div>
            <div class="price-row"><span class="price-now">$419</span><span class="price-old">$599</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 6 -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-sale">-25%</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1606220945770-b5b6c2c55bf1?w=500&auto=format&fit=crop&q=80" alt="SoundSphere">
            </div>
            <h3>SoundSphere Mini</h3>
            <div class="product-cat">Smart Speaker</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.6)</span></div>
            <div class="price-row"><span class="price-now">$149</span><span class="price-old">$199</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 7 -->
          <article class="product-card">
            <div class="product-img">
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&auto=format&fit=crop&q=80" alt="Chrono">
            </div>
            <h3>Chrono Smart</h3>
            <div class="product-cat">Smartwatch</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i> <span>(4.3)</span></div>
            <div class="price-row"><span class="price-now">$229</span><span class="price-old">$279</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 8 -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-hot">HOT</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?w=500&auto=format&fit=crop&q=80" alt="AirBuds">
            </div>
            <h3>AirBuds Lite</h3>
            <div class="product-cat">Earbuds</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.5)</span></div>
            <div class="price-row"><span class="price-now">$84</span><span class="price-old">$129</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 9 -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-new">NEW</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1616348436168-de43ad0db179?w=500&auto=format&fit=crop&q=80" alt="Nova Fold">
            </div>
            <h3>Nova Fold 2</h3>
            <div class="product-cat">Foldable Phone</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(5.0)</span></div>
            <div class="price-row"><span class="price-now">$1,699</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 10 -->
          <article class="product-card">
            <div class="product-img">
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=500&auto=format&fit=crop&q=80" alt="Keyboard">
            </div>
            <h3>Mech Pro Keyboard</h3>
            <div class="product-cat">Accessory</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.8)</span></div>
            <div class="price-row"><span class="price-now">$149</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 11 -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-sale">-18%</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1585790050230-5dd28404ccb9?w=500&auto=format&fit=crop&q=80" alt="Camera">
            </div>
            <h3>SnapPro 4K Cam</h3>
            <div class="product-cat">Camera</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.7)</span></div>
            <div class="price-row"><span class="price-now">$529</span><span class="price-old">$649</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 12 -->
          <article class="product-card">
            <div class="product-img">
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=500&auto=format&fit=crop&q=80" alt="Monitor">
            </div>
            <h3>VisionCurve 32"</h3>
            <div class="product-cat">Monitor</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.9)</span></div>
            <div class="price-row"><span class="price-now">$449</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

        </div>
      </div>
    </div>
  </div>

  <!-- ============================================================
       SECTION 6 — PAGINATION
       ============================================================ -->
  <nav class="pagination container" aria-label="Product pagination">
    <a href="#" class="page-btn disabled"><i class="fas fa-chevron-left"></i></a>
    <a href="#" class="page-btn active">1</a>
    <a href="#" class="page-btn">2</a>
    <a href="#" class="page-btn">3</a>
    <a href="#" class="page-btn">4</a>
    <span class="page-dots">…</span>
    <a href="#" class="page-btn">8</a>
    <a href="#" class="page-btn"><i class="fas fa-chevron-right"></i></a>
  </nav>

  <!-- ============================================================
       SECTION 7 — NEWSLETTER
       ============================================================ -->
  <section class="container">
    <div class="newsletter">
      <h2>Never Miss a Drop</h2>
      <p>Subscribe for early access to new arrivals, exclusive discounts, and tech deals.</p>
      <form class="newsletter-form" onsubmit="return false;">
        <input type="email" placeholder="Enter your email address" required>
        <button type="submit" class="btn btn-amber"><i class="fas fa-paper-plane"></i> Subscribe</button>
      </form>
    </div>
  </section>

  <!-- ============================================================
       SECTION 8 — FOOTER
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

</body>
</html>
