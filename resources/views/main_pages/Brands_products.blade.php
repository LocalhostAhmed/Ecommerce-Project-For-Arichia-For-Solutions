<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Apple Products | ElectroHub</title>

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
      margin: 3.5rem 0 2.2rem;
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
    .main-nav a:hover, .main-nav a.active { color: var(--amber); }
    .main-nav a:hover::after, .main-nav a.active::after { width: 100%; }

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
       SECTION 02 — BRAND HERO BANNER (3D)
       ============================================================ */
    .brand-hero {
      display: grid;
      grid-template-columns: 1.1fr 0.9fr;
      gap: 2.5rem;
      align-items: center;
      padding: 2.5rem 0.5rem 3rem;
      transform-style: preserve-3d;
    }
    .brand-hero-text { transform: translateZ(50px); }

    .brand-logo-wrap {
      display: inline-flex; align-items: center; gap: 0.9rem;
      padding: 0.6rem 1.2rem 0.6rem 0.6rem;
      background: rgba(245,158,11,0.1);
      border: 1px solid rgba(245,158,11,0.3);
      border-radius: 100px;
      margin-bottom: 1.4rem;
      transform: translateZ(20px);
      box-shadow: 0 12px 30px -10px var(--amber-glow);
    }
    .brand-logo-circle {
      width: 48px; height: 48px;
      display: grid; place-items: center;
      border-radius: 50%;
      background: linear-gradient(145deg, var(--amber), #b45309);
      color: #1a1206;
      font-size: 1.6rem;
      box-shadow: inset 0 2px 0 rgba(255,255,255,0.4);
      transform: translateZ(15px);
    }
    .brand-logo-wrap span {
      font-size: 0.8rem;
      font-weight: 700;
      letter-spacing: 0.6px;
      text-transform: uppercase;
      color: var(--amber);
    }

    .brand-hero-text h1 {
      font-size: clamp(2.2rem, 5.5vw, 3.4rem);
      font-weight: 900; line-height: 1.08;
      letter-spacing: -0.03em; margin-bottom: 1rem;
      text-shadow: 0 20px 35px rgba(0,0,0,0.6);
    }
    .brand-hero-text h1 span {
      background: linear-gradient(135deg, var(--amber), #fbbf24, #fde68a);
      -webkit-background-clip: text; background-clip: text; color: transparent;
    }
    .brand-hero-text p { color: var(--muted); font-size: 1.02rem; max-width: 520px; margin-bottom: 1.5rem; }

    .brand-stats {
      display: flex; gap: 2rem; flex-wrap: wrap; margin-bottom: 1.6rem;
    }
    .brand-stat b {
      display: block; font-size: 1.6rem; font-weight: 900;
      color: var(--amber);
      text-shadow: 0 0 20px var(--amber-glow);
      line-height: 1;
    }
    .brand-stat small {
      color: var(--muted); font-size: 0.75rem;
      letter-spacing: 0.6px; text-transform: uppercase;
      margin-top: 0.25rem; display: block;
    }

    .brand-hero-cta { display: flex; gap: 1rem; flex-wrap: wrap; }

    /* 3D floating device showcase */
    .brand-showcase {
      position: relative;
      display: flex; justify-content: center; align-items: center;
      min-height: 360px;
      transform-style: preserve-3d;
      transform: rotateY(-10deg) rotateX(4deg) translateZ(30px);
      transition: transform 0.6s var(--ease);
      animation: riseUp 1s var(--ease) both;
    }
    .brand-showcase:hover { transform: rotateY(-3deg) rotateX(2deg) translateZ(55px); }

    .showcase-device {
      position: absolute;
      border-radius: 1.4rem;
      background: var(--card);
      backdrop-filter: blur(14px);
      border: 1px solid var(--line);
      box-shadow: var(--shadow), 0 0 0 1px rgba(255,255,255,0.05);
      overflow: hidden;
      transition: transform 0.5s var(--ease);
    }
    .showcase-device img { width: 100%; height: 100%; object-fit: cover; }

    .showcase-device.main {
      width: 240px; height: 320px;
      transform: translateZ(45px);
      z-index: 3;
      border-color: rgba(245,158,11,0.4);
      box-shadow: 0 35px 65px -20px rgba(0,0,0,0.9), 0 0 0 1px var(--amber-glow);
    }
    .showcase-device.secondary {
      width: 150px; height: 190px;
      transform: translateX(-125px) translateY(35px) translateZ(15px);
      z-index: 2;
      opacity: 0.92;
    }
    .showcase-device.tertiary {
      width: 130px; height: 170px;
      transform: translateX(125px) translateY(-30px) translateZ(20px);
      z-index: 2;
      opacity: 0.92;
    }

    /* ============================================================
       SECTION 03 — BRAND STORY / ABOUT STRIP
       ============================================================ */
    .brand-story {
      background: linear-gradient(135deg, rgba(245,158,11,0.08), rgba(30,41,59,0.6));
      border: 1px solid rgba(245,158,11,0.22);
      border-radius: var(--radius);
      padding: 2.2rem 2rem;
      margin: 1rem 0 2.5rem;
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 2rem;
      align-items: center;
      transform: translateZ(25px);
      box-shadow: 0 20px 40px -20px rgba(0,0,0,0.8);
    }
    .brand-story-icon {
      width: 100px; height: 100px;
      border-radius: 28px;
      background: rgba(15,23,42,0.7);
      border: 1px solid var(--amber);
      display: grid; place-items: center;
      color: var(--amber);
      font-size: 3rem;
      box-shadow: 0 0 0 6px rgba(245,158,11,0.08), 0 20px 40px -15px var(--amber-glow);
      transform: translateZ(30px);
    }
    .brand-story-content h3 {
      font-size: 1.2rem; font-weight: 800;
      margin-bottom: 0.6rem;
      color: var(--amber);
      letter-spacing: -0.01em;
    }
    .brand-story-content p {
      color: var(--muted);
      font-size: 0.9rem;
      line-height: 1.7;
      margin-bottom: 0.9rem;
    }
    .brand-story-content p:last-child { margin-bottom: 0; }
    .brand-story-content b { color: var(--white); }

    /* ============================================================
       SECTION 04 — SUBCATEGORY TABS
       ============================================================ */
    .subcat-tabs {
      display: flex; gap: 0.7rem; flex-wrap: wrap;
      justify-content: center;
      padding: 0.5rem 0 1.8rem;
      transform: translateZ(20px);
    }
    .subcat-tab {
      padding: 0.7rem 1.4rem;
      border-radius: 60px;
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--line);
      color: var(--muted);
      font-size: 0.88rem; font-weight: 600;
      cursor: pointer;
      transition: all 0.3s var(--ease);
      display: inline-flex; align-items: center; gap: 0.5rem;
    }
    .subcat-tab:hover {
      color: var(--amber); border-color: var(--amber);
      transform: translateY(-3px) translateZ(15px);
    }
    .subcat-tab:active { transform: translateY(-1px) translateZ(5px); }
    .subcat-tab.active {
      background: linear-gradient(145deg, #fbbf24, #f59e0b);
      color: #1a1206; border-color: var(--amber);
      box-shadow: 0 12px 25px -8px var(--amber-glow);
      transform: translateZ(15px);
    }
    .subcat-tab i { font-size: 0.85rem; }

    /* ============================================================
       SECTION 05 — TOOLBAR (Sort & View)
       ============================================================ */
    .shop-toolbar {
      display: flex; justify-content: space-between; align-items: center;
      gap: 1rem; flex-wrap: wrap;
      background: var(--card);
      backdrop-filter: blur(14px);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      padding: 1rem 1.3rem; margin: 0.5rem 0 1rem;
      transform: translateZ(20px);
      box-shadow: 0 18px 35px -18px rgba(0,0,0,0.8);
    }
    .toolbar-left { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
    .results-count { color: var(--muted); font-size: 0.88rem; }
    .results-count b { color: var(--amber); }
    .filter-toggle {
      display: inline-flex; align-items: center; gap: 0.5rem;
      padding: 0.55rem 1.1rem; border-radius: 60px;
      background: rgba(245,158,11,0.12);
      border: 1px solid rgba(245,158,11,0.35);
      color: var(--amber); font-weight: 600; font-size: 0.85rem;
      cursor: pointer; transition: all 0.3s var(--ease);
    }
    .filter-toggle:hover { transform: translateY(-3px) translateZ(15px); box-shadow: 0 15px 25px -10px var(--amber-glow); }

    .toolbar-right { display: flex; align-items: center; gap: 0.7rem; flex-wrap: wrap; }
    .sort-select {
      display: flex; align-items: center; gap: 0.6rem;
      background: rgba(15,23,42,0.7);
      border: 1px solid var(--line);
      border-radius: 60px; padding: 0.5rem 1.1rem;
      font-size: 0.85rem;
    }
    .sort-select label { color: var(--muted); }
    .sort-select select {
      background: transparent; border: none; outline: none;
      color: var(--white); font-family: inherit; font-size: 0.85rem; cursor: pointer;
    }
    .sort-select select option { background: var(--navy); color: var(--white); }

    .view-toggle {
      display: flex; gap: 0.3rem;
      background: rgba(15,23,42,0.7);
      border: 1px solid var(--line);
      border-radius: 60px; padding: 0.3rem;
    }
    .view-btn {
      width: 36px; height: 34px;
      display: grid; place-items: center;
      border-radius: 60px; border: none;
      background: transparent; color: var(--muted);
      cursor: pointer; transition: all 0.3s var(--ease);
      font-size: 0.85rem;
    }
    .view-btn:hover { color: var(--amber); }
    .view-btn.active {
      background: linear-gradient(145deg, #fbbf24, #f59e0b);
      color: #1a1206;
      box-shadow: 0 6px 15px -4px var(--amber-glow);
    }

    /* ============================================================
       SECTION 06 + 07 + 08 — LAYOUT
       ============================================================ */
    .shop-layout {
      display: grid;
      grid-template-columns: 260px 1fr;
      gap: 2rem;
      transform-style: preserve-3d;
    }

    /* ---------- SECTION 06 — Filters Sidebar ---------- */
    .filters {
      background: var(--card);
      backdrop-filter: blur(14px);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      padding: 1.5rem;
      box-shadow: 0 18px 35px -18px rgba(0,0,0,0.8);
      height: fit-content;
      position: sticky; top: 140px;
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
    .price-range input[type="range"] { width: 100%; accent-color: var(--amber); cursor: pointer; }
    .price-values { display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--muted); }
    .price-values b { color: var(--amber); }

    .color-swatches { display: flex; gap: 0.55rem; flex-wrap: wrap; }
    .color-swatch {
      width: 30px; height: 30px;
      border-radius: 50%;
      border: 2px solid var(--line);
      cursor: pointer;
      transition: all 0.3s var(--ease);
      box-shadow: inset 0 2px 4px rgba(0,0,0,0.3);
    }
    .color-swatch:hover, .color-swatch.active {
      border-color: var(--amber);
      transform: scale(1.15) translateZ(10px);
      box-shadow: 0 0 15px var(--amber-glow);
    }

    /* ---------- SECTION 07 — Active Filters Bar ---------- */
    .active-filters {
      display: flex; align-items: center; gap: 0.6rem;
      flex-wrap: wrap;
      padding: 0.9rem 0 0.5rem;
      transform: translateZ(15px);
    }
    .active-filters .label {
      font-size: 0.78rem; color: var(--muted);
      text-transform: uppercase; letter-spacing: 0.6px;
      font-weight: 700;
    }
    .chip {
      display: inline-flex; align-items: center; gap: 0.5rem;
      padding: 0.4rem 0.85rem;
      border-radius: 60px;
      background: rgba(245,158,11,0.12);
      border: 1px solid rgba(245,158,11,0.3);
      color: var(--amber);
      font-size: 0.78rem; font-weight: 600;
      transition: all 0.3s var(--ease);
      cursor: pointer;
    }
    .chip:hover {
      background: rgba(245,158,11,0.22);
      transform: translateY(-2px) translateZ(10px);
    }
    .chip i { font-size: 0.65rem; opacity: 0.85; }
    .clear-all {
      margin-left: auto;
      background: transparent;
      border: none;
      color: var(--muted);
      font-size: 0.8rem;
      font-weight: 600;
      cursor: pointer;
      transition: color 0.3s var(--ease);
      display: inline-flex; align-items: center; gap: 0.4rem;
    }
    .clear-all:hover { color: #ef4444; }

    /* ---------- SECTION 08 — Product Grid ---------- */
    .results-area { transform-style: preserve-3d; }

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
    .price-now { font-size: 1.2rem; font-weight: 800; color: var(--amber); }
    .price-old { font-size: 0.82rem; color: var(--muted); text-decoration: line-through; }

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
       SECTION 09 — PAGINATION
       ============================================================ */
    .pagination {
      display: flex; justify-content: center; align-items: center;
      gap: 0.5rem; margin: 3.5rem 0 4rem; flex-wrap: wrap;
      transform: translateZ(25px);
    }
    .page-btn {
      min-width: 44px; height: 44px; padding: 0 0.7rem;
      display: grid; place-items: center;
      border-radius: 14px;
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--line);
      color: var(--white);
      font-weight: 600; font-size: 0.9rem;
      cursor: pointer; transition: all 0.3s var(--ease);
      text-decoration: none;
    }
    .page-btn:hover { border-color: var(--amber); color: var(--amber); transform: translateY(-3px) translateZ(15px); }
    .page-btn.active {
      background: linear-gradient(145deg, #fbbf24, #f59e0b);
      color: #1a1206; border-color: var(--amber);
      box-shadow: 0 12px 25px -8px var(--amber-glow);
    }
    .page-btn.disabled { opacity: 0.35; pointer-events: none; }
    .page-dots { color: var(--muted); padding: 0 0.3rem; }

    /* ============================================================
       SECTION 10 — OTHER BRANDS & RELATED PRODUCTS
       ============================================================ */
    .other-brands-row {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 1rem;
      transform-style: preserve-3d;
    }
    .other-brand-card {
      background: var(--card);
      backdrop-filter: blur(12px);
      border: 1px solid var(--line);
      border-radius: var(--radius-sm);
      padding: 1.5rem 1rem;
      text-align: center;
      transition: all 0.4s var(--ease);
      transform-style: preserve-3d;
      box-shadow: 0 15px 30px -15px rgba(0,0,0,0.7);
      cursor: pointer;
    }
    .other-brand-card:hover {
      transform: translateY(-8px) translateZ(35px);
      border-color: rgba(245,158,11,0.4);
      box-shadow: 0 25px 45px -15px rgba(0,0,0,0.9);
    }
    .other-brand-icon {
      width: 54px; height: 54px;
      margin: 0 auto 0.9rem;
      display: grid; place-items: center;
      border-radius: 16px;
      background: rgba(15,23,42,0.7);
      border: 1px solid var(--line);
      color: var(--white);
      font-size: 1.4rem;
      transition: all 0.4s var(--ease);
      transform: translateZ(20px);
    }
    .other-brand-card:hover .other-brand-icon {
      color: var(--amber);
      border-color: var(--amber);
      transform: translateZ(35px) scale(1.08);
    }
    .other-brand-card h4 { font-size: 0.92rem; font-weight: 700; }
    .other-brand-card small { color: var(--muted); font-size: 0.72rem; }
    .other-brand-card small b { color: var(--amber); }

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
    @keyframes floaty {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-12px); }
    }
    .showcase-device.secondary { animation: floaty 5s ease-in-out infinite; }
    .showcase-device.tertiary { animation: floaty 6.5s ease-in-out infinite reverse; }

    /* ============================================================
       RESPONSIVE
       ============================================================ */
    @media (max-width: 1024px) {
      .brand-hero { grid-template-columns: 1fr; text-align: center; padding: 1.5rem 0.5rem 2.5rem; }
      .brand-hero-text p { margin-left: auto; margin-right: auto; }
      .brand-stats { justify-content: center; }
      .brand-hero-cta { justify-content: center; }
      .brand-showcase { transform: rotateY(0) rotateX(0) translateZ(20px); min-height: 300px; }
      .brand-story { grid-template-columns: 1fr; text-align: center; }
      .brand-story-icon { margin: 0 auto; }
      .shop-layout { grid-template-columns: 1fr; }
      .filters { position: static; }
      .footer-grid { grid-template-columns: 1fr 1fr; gap: 2rem; }
    }

    @media (max-width: 640px) {
      body { padding: 0 0.7rem; }
      .announcement-inner { gap: 1rem; font-size: 0.72rem; }
      .search-bar { order: 3; flex: 1 1 100%; }
      .main-nav ul { gap: 1.2rem; font-size: 0.84rem; }
      .brand-hero { padding: 1.5rem 0.5rem 2rem; }
      .brand-showcase { min-height: 240px; }
      .showcase-device.main { width: 170px; height: 230px; }
      .showcase-device.secondary { width: 100px; height: 130px; transform: translateX(-90px) translateY(35px); }
      .showcase-device.tertiary { width: 90px; height: 115px; transform: translateX(90px) translateY(-25px); }
      .brand-story { padding: 1.6rem 1.2rem; }
      .brand-story-icon { width: 80px; height: 80px; font-size: 2.4rem; border-radius: 22px; }
      .shop-toolbar { flex-direction: column; align-items: stretch; }
      .toolbar-left { justify-content: space-between; }
      .toolbar-right { justify-content: space-between; }
      .products-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem; }
      .product-card { padding: 0.9rem; }
      .product-card h3 { font-size: 0.88rem; }
      .price-now { font-size: 1.05rem; }
      .footer-grid { grid-template-columns: 1fr; gap: 1.8rem; text-align: center; }
      .footer-brand p { margin-left: auto; margin-right: auto; }
      .social-row { justify-content: center; }
      .footer-bottom { flex-direction: column; text-align: center; }
      .pagination { gap: 0.35rem; }
      .page-btn { min-width: 38px; height: 38px; font-size: 0.82rem; border-radius: 12px; }
      .active-filters { justify-content: center; }
      .clear-all { margin-left: 0; }
      .subcat-tab { padding: 0.6rem 1.1rem; font-size: 0.82rem; }
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
        <input type="text" placeholder="Search brands, devices, categories...">
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
        <li><a href="#" class="active">Brands</a></li>
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
      <a href="#">Brands</a>
      <i class="fas fa-chevron-right"></i>
      <span class="current">Apple</span>
    </div>
  </nav>

  <!-- ============================================================
       SECTION 02 — BRAND HERO BANNER (3D)
       ============================================================ -->
  <section class="brand-hero container">
    <div class="brand-hero-text">
      <div class="brand-logo-wrap">
        <span class="brand-logo-circle"><i class="fab fa-apple"></i></span>
        <span>Official Brand</span>
      </div>

      <h1>Explore <span>Apple</span> Products</h1>
      <p>Discover the full range of Apple devices — iPhones, MacBooks, iPads, Apple Watches, AirPods, and accessories. All authentic, all with official Apple warranty.</p>

      <div class="brand-stats">
        <div class="brand-stat"><b>320+</b><small>Products</small></div>
        <div class="brand-stat"><b>4.9★</b><small>Avg Rating</small></div>
        <div class="brand-stat"><b>1976</b><small>Founded</small></div>
      </div>

      <div class="brand-hero-cta">
        <a href="#products" class="btn btn-amber"><i class="fas fa-bag-shopping"></i> Shop Apple</a>
        <a href="#" class="btn btn-ghost"><i class="fas fa-circle-info"></i> About Apple</a>
      </div>
    </div>

    <!-- 3D showcase: iPhone, MacBook, AirPods -->
    <div class="brand-showcase">
      <div class="showcase-device secondary">
        <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=300&auto=format&fit=crop&q=80" alt="MacBook">
      </div>
      <div class="showcase-device main">
        <img src="https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=600&auto=format&fit=crop&q=80" alt="iPhone 16 Pro Max">
      </div>
      <div class="showcase-device tertiary">
        <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=300&auto=format&fit=crop&q=80" alt="AirPods Max">
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 03 — BRAND STORY / ABOUT STRIP
       ============================================================ -->
  <section class="container">
    <div class="brand-story">
      <div class="brand-story-icon"><i class="fab fa-apple"></i></div>
      <div class="brand-story-content">
        <h3>About Apple</h3>
        <p>Founded in <b>1976</b> by Steve Jobs, Steve Wozniak, and Ronald Wayne, <b>Apple Inc.</b> is a California-based technology company that designs, develops, and sells consumer electronics, computer software, and online services. It's one of the world's most valuable brands and is renowned for its innovation, premium design, and seamless ecosystem of products.</p>
        <p>From the iPhone to the MacBook, iPad, Apple Watch, and AirPods — Apple products are celebrated for their <b>build quality, powerful performance, and industry-leading privacy</b>. ElectroHub is proud to be an authorized reseller of genuine Apple products with full official warranty.</p>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 04 — SUBCATEGORY TABS
       ============================================================ -->
  <div class="container">
    <div class="subcat-tabs">
      <button class="subcat-tab active"><i class="fas fa-border-all"></i> All Products</button>
      <button class="subcat-tab"><i class="fas fa-mobile-screen-button"></i> iPhones</button>
      <button class="subcat-tab"><i class="fas fa-laptop"></i> MacBooks</button>
      <button class="subcat-tab"><i class="fas fa-tablet-screen-button"></i> iPads</button>
      <button class="subcat-tab"><i class="fas fa-clock"></i> Apple Watch</button>
      <button class="subcat-tab"><i class="fas fa-headphones"></i> AirPods</button>
      <button class="subcat-tab"><i class="fas fa-plug"></i> Accessories</button>
    </div>
  </div>

  <!-- ============================================================
       SECTION 05 — TOOLBAR
       ============================================================ -->
  <div class="container">
    <div class="shop-toolbar">
      <div class="toolbar-left">
        <button class="filter-toggle"><i class="fas fa-filter"></i> Filters</button>
        <span class="results-count">Showing <b>1–12</b> of <b>320</b> Apple products</span>
      </div>

      <div class="toolbar-right">
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

        <div class="view-toggle">
          <button class="view-btn active" title="Grid view"><i class="fas fa-th"></i></button>
          <button class="view-btn" title="List view"><i class="fas fa-list"></i></button>
        </div>
      </div>
    </div>
  </div>

  <!-- ============================================================
       SECTION 06 + 07 + 08 — LAYOUT
       ============================================================ -->
  <div class="container">
    <div class="shop-layout">

      <!-- ---------- SECTION 06 — Filters Sidebar ---------- -->
      <aside class="filters">
        <h3><i class="fas fa-sliders"></i> Refine Apple Products</h3>

        <div class="filter-group">
          <h4>Category</h4>
          <label class="filter-option"><input type="checkbox" checked> iPhones <span class="count">(85)</span></label>
          <label class="filter-option"><input type="checkbox"> MacBooks <span class="count">(62)</span></label>
          <label class="filter-option"><input type="checkbox"> iPads <span class="count">(48)</span></label>
          <label class="filter-option"><input type="checkbox"> Apple Watch <span class="count">(40)</span></label>
          <label class="filter-option"><input type="checkbox"> AirPods <span class="count">(35)</span></label>
          <label class="filter-option"><input type="checkbox"> Accessories <span class="count">(50)</span></label>
        </div>

        <div class="filter-group">
          <h4>Price Range</h4>
          <div class="price-range">
            <input type="range" min="0" max="3000" value="1500">
            <div class="price-values"><span>Min: <b>$0</b></span><span>Max: <b>$3000</b></span></div>
          </div>
        </div>

        <div class="filter-group">
          <h4>RAM</h4>
          <label class="filter-option"><input type="checkbox"> 6 GB <span class="count">(24)</span></label>
          <label class="filter-option"><input type="checkbox" checked> 8 GB <span class="count">(58)</span></label>
          <label class="filter-option"><input type="checkbox"> 16 GB <span class="count">(32)</span></label>
          <label class="filter-option"><input type="checkbox"> 24 GB <span class="count">(18)</span></label>
        </div>

        <div class="filter-group">
          <h4>Storage</h4>
          <label class="filter-option"><input type="checkbox"> 128 GB <span class="count">(42)</span></label>
          <label class="filter-option"><input type="checkbox" checked> 256 GB <span class="count">(68)</span></label>
          <label class="filter-option"><input type="checkbox"> 512 GB <span class="count">(35)</span></label>
          <label class="filter-option"><input type="checkbox"> 1 TB <span class="count">(22)</span></label>
          <label class="filter-option"><input type="checkbox"> 2 TB <span class="count">(8)</span></label>
        </div>

        <div class="filter-group">
          <h4>Color</h4>
          <div class="color-swatches">
            <span class="color-swatch active" style="background:#1f2937;" title="Black"></span>
            <span class="color-swatch" style="background:#e5e7eb;" title="White"></span>
            <span class="color-swatch" style="background:#9ca3af;" title="Natural"></span>
            <span class="color-swatch" style="background:#c9b8a8;" title="Desert Titanium"></span>
            <span class="color-swatch" style="background:#3b82f6;" title="Blue"></span>
            <span class="color-swatch" style="background:#fda4af;" title="Pink"></span>
          </div>
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

      <!-- ---------- SECTION 07 + 08 — Active Filters + Grid ---------- -->
      <div class="results-area" id="products">

        <!-- SECTION 07 — Active Filters Bar -->
        <div class="active-filters">
          <span class="label">Active:</span>
          <span class="chip">iPhones <i class="fas fa-times"></i></span>
          <span class="chip">8 GB RAM <i class="fas fa-times"></i></span>
          <span class="chip">256 GB <i class="fas fa-times"></i></span>
          <span class="chip">Black Titanium <i class="fas fa-times"></i></span>
          <button class="clear-all"><i class="fas fa-trash-can"></i> Clear All</button>
        </div>

        <!-- SECTION 08 — Product Grid -->
        <div class="products-grid">

          <!-- 1. iPhone 16 Pro Max -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-new">NEW</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=500&auto=format&fit=crop&q=80" alt="iPhone 16 Pro Max">
            </div>
            <h3>iPhone 16 Pro Max</h3>
            <div class="product-cat">Smartphone • 8/256 GB</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(5.0)</span></div>
            <div class="price-row"><span class="price-now">$1,199</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 2. iPhone 16 -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-sale">-15%</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1591337676887-a217a6970a8a?w=500&auto=format&fit=crop&q=80" alt="iPhone 16">
            </div>
            <h3>iPhone 16</h3>
            <div class="product-cat">Smartphone • 8/128 GB</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.8)</span></div>
            <div class="price-row"><span class="price-now">$899</span><span class="price-old">$1,059</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 3. MacBook Pro 14 -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-hot">HOT</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500&auto=format&fit=crop&q=80" alt="MacBook Pro 14">
            </div>
            <h3>MacBook Pro 14"</h3>
            <div class="product-cat">Laptop • M4 Pro</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(5.0)</span></div>
            <div class="price-row"><span class="price-now">$1,999</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 4. MacBook Air 13 -->
          <article class="product-card">
            <div class="product-img">
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500&auto=format&fit=crop&q=80" alt="MacBook Air 13">
            </div>
            <h3>MacBook Air 13"</h3>
            <div class="product-cat">Laptop • M3</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.8)</span></div>
            <div class="price-row"><span class="price-now">$999</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 5. iPad Air -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-new">NEW</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1567581935884-3349723552ca?w=500&auto=format&fit=crop&q=80" alt="iPad Air">
            </div>
            <h3>iPad Air 11"</h3>
            <div class="product-cat">Tablet • 8/256 GB</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i> <span>(4.4)</span></div>
            <div class="price-row"><span class="price-now">$599</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 6. iPad Pro -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-hot">HOT</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=500&auto=format&fit=crop&q=80" alt="iPad Pro">
            </div>
            <h3>iPad Pro 13"</h3>
            <div class="product-cat">Tablet • M4</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.9)</span></div>
            <div class="price-row"><span class="price-now">$1,299</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 7. Apple Watch Ultra 2 -->
          <article class="product-card">
            <div class="product-img">
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=500&auto=format&fit=crop&q=80" alt="Apple Watch Ultra 2">
            </div>
            <h3>Apple Watch Ultra 2</h3>
            <div class="product-cat">Wearable • 49mm</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.9)</span></div>
            <div class="price-row"><span class="price-now">$799</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 8. AirPods Max -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-sale">-18%</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&auto=format&fit=crop&q=80" alt="AirPods Max">
            </div>
            <h3>AirPods Max</h3>
            <div class="product-cat">Headphones • ANC</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.8)</span></div>
            <div class="price-row"><span class="price-now">$449</span><span class="price-old">$549</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 9. AirPods Pro 2 -->
          <article class="product-card">
            <div class="product-img">
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?w=500&auto=format&fit=crop&q=80" alt="AirPods Pro 2">
            </div>
            <h3>AirPods Pro 2</h3>
            <div class="product-cat">Earbuds • USB-C</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.9)</span></div>
            <div class="price-row"><span class="price-now">$249</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 10. iPhone 15 Pro -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-sale">-12%</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?w=500&auto=format&fit=crop&q=80" alt="iPhone 15 Pro">
            </div>
            <h3>iPhone 15 Pro</h3>
            <div class="product-cat">Smartphone • 8/256 GB</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.9)</span></div>
            <div class="price-row"><span class="price-now">$999</span><span class="price-old">$1,139</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 11. Magic Keyboard -->
          <article class="product-card">
            <div class="product-img">
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=500&auto=format&fit=crop&q=80" alt="Magic Keyboard">
            </div>
            <h3>Magic Keyboard</h3>
            <div class="product-cat">Accessory • Wireless</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.7)</span></div>
            <div class="price-row"><span class="price-now">$99</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 12. MagSafe Charger -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-new">NEW</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1588423771073-b8903fbb85b5?w=500&auto=format&fit=crop&q=80" alt="MagSafe Charger">
            </div>
            <h3>MagSafe Charger</h3>
            <div class="product-cat">Accessory • 25W</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i> <span>(4.5)</span></div>
            <div class="price-row"><span class="price-now">$49</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

        </div>
      </div>
    </div>
  </div>

  <!-- ============================================================
       SECTION 09 — PAGINATION
       ============================================================ -->
  <nav class="pagination container" aria-label="Apple products pagination">
    <a href="#" class="page-btn disabled"><i class="fas fa-chevron-left"></i></a>
    <a href="#" class="page-btn active">1</a>
    <a href="#" class="page-btn">2</a>
    <a href="#" class="page-btn">3</a>
    <a href="#" class="page-btn">4</a>
    <span class="page-dots">…</span>
    <a href="#" class="page-btn">27</a>
    <a href="#" class="page-btn"><i class="fas fa-chevron-right"></i></a>
  </nav>

  <!-- ============================================================
       SECTION 10 — OTHER BRANDS & RELATED PRODUCTS
       ============================================================ -->
  <section class="container">
    <div class="section-head">
      <h2>Explore Other Brands</h2>
      <p>Discover products from more of our trusted manufacturers</p>
    </div>

    <div class="other-brands-row">
      <div class="other-brand-card">
        <div class="other-brand-icon"><i class="fas fa-mobile-screen-button"></i></div>
        <h4>Samsung</h4>
        <small><b>280</b> products</small>
      </div>
      <div class="other-brand-card">
        <div class="other-brand-icon"><i class="fas fa-laptop"></i></div>
        <h4>Dell</h4>
        <small><b>190</b> products</small>
      </div>
      <div class="other-brand-card">
        <div class="other-brand-icon"><i class="fas fa-desktop"></i></div>
        <h4>HP</h4>
        <small><b>160</b> products</small>
      </div>
      <div class="other-brand-card">
        <div class="other-brand-icon"><i class="fas fa-microchip"></i></div>
        <h4>Xiaomi</h4>
        <small><b>210</b> products</small>
      </div>
      <div class="other-brand-card">
        <div class="other-brand-icon"><i class="fas fa-headphones"></i></div>
        <h4>Sony</h4>
        <small><b>180</b> products</small>
      </div>
      <div class="other-brand-card">
        <div class="other-brand-icon"><i class="fas fa-mobile-alt"></i></div>
        <h4>Google</h4>
        <small><b>75</b> products</small>
      </div>
      <div class="other-brand-card">
        <div class="other-brand-icon"><i class="fas fa-laptop-code"></i></div>
        <h4>Lenovo</h4>
        <small><b>145</b> products</small>
      </div>
      <div class="other-brand-card">
        <div class="other-brand-icon"><i class="fas fa-bolt"></i></div>
        <h4>OnePlus</h4>
        <small><b>60</b> products</small>
      </div>
    </div>

    <!-- Related products -->
    <div class="section-head" style="margin-top: 3rem;">
      <h2>You May Also Like</h2>
      <p>Popular picks from the Apple ecosystem</p>
    </div>

    <div class="products-grid">
      <article class="product-card">
        <div class="product-img">
          <span class="tag tag-hot">HOT</span>
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=500&auto=format&fit=crop&q=80" alt="iPhone 16 Pro">
        </div>
        <h3>iPhone 16 Pro</h3>
        <div class="product-cat">Apple • Smartphone</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(5.0)</span></div>
        <div class="price-row"><span class="price-now">$999</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <article class="product-card">
        <div class="product-img">
          <span class="tag tag-sale">-22%</span>
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=500&auto=format&fit=crop&q=80" alt="Apple Watch SE">
        </div>
        <h3>Apple Watch SE</h3>
        <div class="product-cat">Apple • Wearable</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.7)</span></div>
        <div class="price-row"><span class="price-now">$219</span><span class="price-old">$279</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <article class="product-card">
        <div class="product-img">
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=500&auto=format&fit=crop&q=80" alt="Studio Display">
        </div>
        <h3>Studio Display 27"</h3>
        <div class="product-cat">Apple • Display</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.8)</span></div>
        <div class="price-row"><span class="price-now">$1,599</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <article class="product-card">
        <div class="product-img">
          <span class="tag tag-new">NEW</span>
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500&auto=format&fit=crop&q=80" alt="Mac mini">
        </div>
        <h3>Mac mini M4</h3>
        <div class="product-cat">Apple • Desktop</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.9)</span></div>
        <div class="price-row"><span class="price-now">$599</span></div>
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

</body>
</html>
