<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Results | ElectroHub</title>

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

    /* Search bar in header (compact) */
    .header-search {
      flex: 1 1 320px;
      position: relative;
      transform: translateZ(10px);
    }
    .header-search .search-input-wrap {
      display: flex; align-items: center; gap: 0.6rem;
      background: rgba(255,255,255,0.05);
      border: 1px solid var(--amber);
      border-radius: 60px;
      padding: 0.55rem 1.1rem;
      box-shadow: 0 0 0 4px var(--amber-glow);
      transition: all 0.3s var(--ease);
    }
    .header-search .search-input-wrap i { color: var(--amber); }
    .header-search input {
      flex: 1; background: transparent; border: none; outline: none;
      color: var(--white); font-size: 0.9rem; font-family: inherit;
    }
    .header-search input::placeholder { color: var(--muted); }
    .header-search .voice-btn {
      background: transparent; border: none; color: var(--muted);
      font-size: 0.9rem; cursor: pointer; transition: color 0.3s var(--ease);
    }
    .header-search .voice-btn:hover { color: var(--amber); }

    /* Autocomplete dropdown */
    .autocomplete {
      position: absolute;
      top: calc(100% + 0.6rem);
      left: 0; right: 0;
      background: rgba(15,23,42,0.98);
      backdrop-filter: blur(20px);
      border: 1px solid var(--line);
      border-radius: 1.2rem;
      padding: 0.6rem;
      box-shadow: 0 25px 50px -15px rgba(0,0,0,0.9), 0 0 0 1px var(--amber-glow);
      transform: translateZ(30px);
      animation: slideDown 0.3s var(--ease);
    }
    .autocomplete-item {
      display: flex; align-items: center; gap: 0.7rem;
      padding: 0.65rem 0.9rem;
      border-radius: 0.7rem;
      font-size: 0.88rem;
      color: var(--muted);
      cursor: pointer;
      transition: all 0.25s var(--ease);
    }
    .autocomplete-item:hover {
      background: rgba(245,158,11,0.1);
      color: var(--white);
      transform: translateX(4px);
    }
    .autocomplete-item i { color: var(--amber); font-size: 0.75rem; }
    .autocomplete-item b { color: var(--amber); font-weight: 700; }
    .autocomplete-item .tag-count { margin-left: auto; font-size: 0.72rem; opacity: 0.7; }

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
       SECTION 03 — SEARCH SUMMARY HEADER
       ============================================================ */
    .search-summary {
      padding: 1.8rem 0.5rem 1rem;
      transform: translateZ(30px);
    }
    .search-summary h1 {
      font-size: clamp(1.5rem, 4vw, 2.2rem);
      font-weight: 800;
      letter-spacing: -0.02em;
      line-height: 1.2;
      margin-bottom: 0.6rem;
    }
    .search-summary h1 .keyword {
      color: var(--amber);
      position: relative;
      display: inline-block;
      text-shadow: 0 0 25px var(--amber-glow);
    }
    .search-summary h1 .keyword::after {
      content: '';
      position: absolute;
      left: 0; bottom: -4px; right: 0;
      height: 3px;
      background: linear-gradient(90deg, transparent, var(--amber), transparent);
      border-radius: 4px;
      opacity: 0.6;
    }
    .summary-meta {
      display: flex; align-items: center; gap: 1.2rem;
      flex-wrap: wrap;
      font-size: 0.85rem; color: var(--muted);
    }
    .summary-meta .time-taken {
      display: inline-flex; align-items: center; gap: 0.4rem;
      padding: 0.35rem 0.85rem;
      background: rgba(245,158,11,0.1);
      border: 1px solid rgba(245,158,11,0.25);
      border-radius: 60px;
      color: var(--amber);
      font-weight: 600;
      font-size: 0.78rem;
    }
    .related-keywords {
      display: flex; align-items: center; gap: 0.6rem;
      flex-wrap: wrap; margin-top: 1rem;
      font-size: 0.85rem;
    }
    .related-keywords .label {
      color: var(--muted); font-weight: 600;
      text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.72rem;
    }
    .related-keywords a {
      padding: 0.35rem 0.85rem;
      border-radius: 60px;
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--line);
      color: var(--white);
      font-size: 0.8rem;
      transition: all 0.3s var(--ease);
    }
    .related-keywords a:hover {
      border-color: var(--amber); color: var(--amber);
      transform: translateY(-2px) translateZ(10px);
    }

    /* ============================================================
       SECTION 04 — DID YOU MEAN? / SPELLING CORRECTION
       ============================================================ */
    .did-you-mean {
      display: flex; align-items: center; gap: 0.8rem;
      flex-wrap: wrap;
      padding: 1rem 1.4rem;
      background: linear-gradient(135deg, rgba(245,158,11,0.12), rgba(30,41,59,0.6));
      border: 1px solid rgba(245,158,11,0.3);
      border-radius: 1.2rem;
      margin: 0.5rem 0 1rem;
      transform: translateZ(20px);
      box-shadow: 0 15px 30px -15px rgba(0,0,0,0.7);
    }
    .did-you-mean i { color: var(--amber); font-size: 1.1rem; }
    .did-you-mean p { font-size: 0.9rem; color: var(--muted); }
    .did-you-mean p b { color: var(--white); font-weight: 700; }
    .did-you-mean a {
      color: var(--amber);
      font-weight: 700;
      text-decoration: underline;
      text-underline-offset: 3px;
      transition: all 0.3s var(--ease);
    }
    .did-you-mean a:hover { text-shadow: 0 0 15px var(--amber-glow); }

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
       SECTION 06 + 08 — LAYOUT (Filters + Results)
       ============================================================ */
    .search-layout {
      display: grid;
      grid-template-columns: 260px 1fr;
      gap: 2rem;
      transform-style: preserve-3d;
    }

    /* ---------- Filters Sidebar ---------- */
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

    /* ---------- Results Area ---------- */
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
    /* Highlighted keyword in product title */
    .product-card h3 mark {
      background: rgba(245,158,11,0.25);
      color: var(--amber);
      padding: 0 0.15rem;
      border-radius: 3px;
      font-weight: 800;
      text-shadow: 0 0 12px var(--amber-glow);
    }
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
       SECTION 07 — ACTIVE FILTERS BAR
       ============================================================ */
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

    /* ============================================================
       SECTION 09 — NO RESULTS / EMPTY STATE (3D)
       ============================================================ */
    .no-results {
      padding: 4rem 1rem;
      text-align: center;
      transform-style: preserve-3d;
      transform: translateZ(30px);
      display: none; /* toggle to show */
    }
    .no-results.visible { display: block; }

    .empty-visual {
      position: relative;
      width: 180px; height: 180px;
      margin: 0 auto 2rem;
      transform-style: preserve-3d;
      animation: floatSpin 6s ease-in-out infinite;
    }
    .empty-ring {
      position: absolute;
      inset: 0;
      border-radius: 50%;
      border: 2px dashed rgba(245,158,11,0.35);
      animation: rotate 20s linear infinite;
    }
    .empty-ring::after {
      content: '';
      position: absolute;
      inset: 20px;
      border-radius: 50%;
      border: 2px solid rgba(245,158,11,0.15);
    }
    .empty-icon {
      position: absolute;
      inset: 0;
      display: grid; place-items: center;
      font-size: 4.5rem;
      color: var(--amber);
      filter: drop-shadow(0 15px 30px var(--amber-glow));
    }
    .no-results h2 {
      font-size: clamp(1.5rem, 3.5vw, 2rem);
      font-weight: 800;
      margin-bottom: 0.7rem;
    }
    .no-results h2 span { color: var(--amber); }
    .no-results p {
      color: var(--muted);
      max-width: 520px;
      margin: 0 auto 1.8rem;
      font-size: 0.95rem;
    }
    .no-results-actions {
      display: flex; gap: 0.8rem; flex-wrap: wrap;
      justify-content: center;
    }
    .suggestion-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1rem;
      max-width: 780px;
      margin: 2.5rem auto 0;
      text-align: left;
    }
    .suggestion-item {
      background: var(--card);
      backdrop-filter: blur(12px);
      border: 1px solid var(--line);
      border-radius: var(--radius-sm);
      padding: 1.2rem 1.3rem;
      display: flex; gap: 0.9rem; align-items: flex-start;
      transition: all 0.35s var(--ease);
      transform-style: preserve-3d;
    }
    .suggestion-item:hover {
      transform: translateY(-6px) translateZ(25px);
      border-color: rgba(245,158,11,0.35);
      box-shadow: 0 25px 40px -15px rgba(0,0,0,0.8);
    }
    .suggestion-item i {
      color: var(--amber);
      font-size: 1.2rem;
      margin-top: 0.1rem;
      transform: translateZ(15px);
    }
    .suggestion-item b { display: block; font-size: 0.92rem; margin-bottom: 0.25rem; }
    .suggestion-item small { color: var(--muted); font-size: 0.8rem; line-height: 1.5; }

    /* ============================================================
       SECTION 10 — RELATED SEARCHES & TRENDING
       ============================================================ */
    .related-searches {
      display: flex; gap: 0.6rem; flex-wrap: wrap;
      justify-content: center;
      padding: 1rem 0 2rem;
      transform: translateZ(20px);
    }
    .search-pill {
      padding: 0.55rem 1.15rem;
      border-radius: 60px;
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--line);
      color: var(--muted);
      font-size: 0.83rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.35s var(--ease);
      display: inline-flex; align-items: center; gap: 0.45rem;
    }
    .search-pill:hover {
      color: var(--amber); border-color: var(--amber);
      background: rgba(245,158,11,0.08);
      transform: translateY(-4px) translateZ(20px);
      box-shadow: 0 15px 25px -10px var(--amber-glow);
    }
    .search-pill i { font-size: 0.75rem; opacity: 0.7; }

    /* Trending products row (carousel-like) */
    .trending-row {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 1.3rem;
      transform-style: preserve-3d;
    }

    /* ============================================================
       PAGINATION
       ============================================================ */
    .pagination {
      display: flex; justify-content: center; align-items: center;
      gap: 0.5rem; margin: 3rem 0 4rem; flex-wrap: wrap;
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
    @keyframes slideDown {
      0% { opacity: 0; transform: translateY(-10px) translateZ(30px); }
      100% { opacity: 1; transform: translateY(0) translateZ(30px); }
    }
    @keyframes floatSpin {
      0%, 100% { transform: translateY(0) rotateY(0deg); }
      50% { transform: translateY(-15px) rotateY(10deg); }
    }
    @keyframes rotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    /* ============================================================
       RESPONSIVE
       ============================================================ */
    @media (max-width: 1024px) {
      .search-layout { grid-template-columns: 1fr; }
      .filters { position: static; }
      .footer-grid { grid-template-columns: 1fr 1fr; gap: 2rem; }
    }

    @media (max-width: 640px) {
      body { padding: 0 0.7rem; }
      .announcement-inner { gap: 1rem; font-size: 0.72rem; }
      .header-search { order: 3; flex: 1 1 100%; }
      .main-nav ul { gap: 1.2rem; font-size: 0.84rem; }
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
      .empty-visual { width: 140px; height: 140px; }
      .empty-icon { font-size: 3.5rem; }
      .trending-row { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem; }
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
       HEADER & NAVIGATION (with sticky search — Section 02)
       ============================================================ -->
  <header class="header">
    <div class="header-inner container">
      <a href="#" class="logo">
        <span class="logo-mark"><i class="fas fa-bolt"></i></span>
        <span>Electro<b>Hub</b></span>
      </a>

      <!-- SECTION 02 — SEARCH BAR WITH AUTOCOMPLETE -->
      <div class="header-search">
        <div class="search-input-wrap">
          <i class="fas fa-magnifying-glass"></i>
          <input type="text" value="iphone" placeholder="Search devices...">
          <button class="voice-btn" title="Voice search"><i class="fas fa-microphone"></i></button>
        </div>

        <!-- Autocomplete dropdown -->
        <div class="autocomplete">
          <div class="autocomplete-item"><i class="fas fa-magnifying-glass"></i> <span><b>iphone</b> 16 Pro</span> <span class="tag-count">24 results</span></div>
          <div class="autocomplete-item"><i class="fas fa-magnifying-glass"></i> <span><b>iphone</b> 16</span> <span class="tag-count">18 results</span></div>
          <div class="autocomplete-item"><i class="fas fa-magnifying-glass"></i> <span><b>iphone</b> 15 Pro Max</span> <span class="tag-count">12 results</span></div>
          <div class="autocomplete-item"><i class="fas fa-magnifying-glass"></i> <span><b>iphone</b> 14</span> <span class="tag-count">9 results</span></div>
          <div class="autocomplete-item"><i class="fas fa-magnifying-glass"></i> <span><b>iphone</b> cases &amp; accessories</span> <span class="tag-count">156 results</span></div>
        </div>
      </div>

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
      <span class="current">Search Results</span>
    </div>
  </nav>

  <!-- ============================================================
       SECTION 03 — SEARCH SUMMARY HEADER
       ============================================================ -->
  <section class="search-summary container">
    <h1>Search results for <span class="keyword">"iphone"</span></h1>
    <div class="summary-meta">
      <span><i class="fas fa-circle-info"></i> 47 products found</span>
      <span class="time-taken"><i class="fas fa-stopwatch"></i> 0.24s</span>
    </div>

    <div class="related-keywords">
      <span class="label">Related:</span>
      <a href="#">iPhone 16 Pro</a>
      <a href="#">iPhone 16</a>
      <a href="#">iPhone 15</a>
      <a href="#">iPhone accessories</a>
      <a href="#">Apple Watch</a>
    </div>
  </section>

  <!-- ============================================================
       SECTION 04 — DID YOU MEAN? (conditional — shown only in no-results state)
       ============================================================ -->
  <section class="container" style="display:none;">
    <!-- Hidden in the "results found" state. Uncomment to preview no-results state. -->
    <div class="did-you-mean">
      <i class="fas fa-wand-magic-sparkles"></i>
      <p>Did you mean <b>iPhone</b>? Or try <a href="#">Apple smartphones</a> instead.</p>
    </div>
  </section>

  <!-- ============================================================
       SECTION 05 — TOOLBAR (Sort & View)
       ============================================================ -->
  <div class="container">
    <div class="shop-toolbar">
      <div class="toolbar-left">
        <button class="filter-toggle"><i class="fas fa-filter"></i> Filters</button>
        <span class="results-count">Showing <b>1–12</b> of <b>47</b> results</span>
      </div>

      <div class="toolbar-right">
        <div class="sort-select">
          <label for="sort"><i class="fas fa-arrow-up-wide-short"></i> Sort:</label>
          <select id="sort">
            <option>Relevance</option>
            <option>Price: Low → High</option>
            <option>Price: High → Low</option>
            <option>Newest</option>
            <option>Top Rated</option>
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
       SECTION 06 + 07 + 08 — FILTERS + ACTIVE FILTERS + RESULTS GRID
       ============================================================ -->
  <div class="container">
    <div class="search-layout">

      <!-- ---------- SECTION 06 — Filters Sidebar ---------- -->
      <aside class="filters">
        <h3><i class="fas fa-sliders"></i> Refine Search</h3>

        <div class="filter-group">
          <h4>Category</h4>
          <label class="filter-option"><input type="checkbox" checked> Smartphones <span class="count">(24)</span></label>
          <label class="filter-option"><input type="checkbox"> Laptops <span class="count">(6)</span></label>
          <label class="filter-option"><input type="checkbox"> Tablets <span class="count">(8)</span></label>
          <label class="filter-option"><input type="checkbox"> Accessories <span class="count">(9)</span></label>
        </div>

        <div class="filter-group">
          <h4>Brand</h4>
          <label class="filter-option"><input type="checkbox" checked> Apple <span class="count">(38)</span></label>
          <label class="filter-option"><input type="checkbox"> Samsung <span class="count">(4)</span></label>
          <label class="filter-option"><input type="checkbox"> Google <span class="count">(3)</span></label>
          <label class="filter-option"><input type="checkbox"> Xiaomi <span class="count">(2)</span></label>
        </div>

        <div class="filter-group">
          <h4>Price Range</h4>
          <div class="price-range">
            <input type="range" min="0" max="2000" value="1200">
            <div class="price-values"><span>Min: <b>$0</b></span><span>Max: <b>$2000</b></span></div>
          </div>
        </div>

        <div class="filter-group">
          <h4>Storage</h4>
          <label class="filter-option"><input type="checkbox"> 128 GB <span class="count">(14)</span></label>
          <label class="filter-option"><input type="checkbox" checked> 256 GB <span class="count">(22)</span></label>
          <label class="filter-option"><input type="checkbox"> 512 GB <span class="count">(9)</span></label>
          <label class="filter-option"><input type="checkbox"> 1 TB <span class="count">(2)</span></label>
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

      <!-- ---------- SECTION 07 + 08 — Active Filters + Results Grid ---------- -->
      <div class="results-area">

        <!-- SECTION 07 — Active Filters Bar -->
        <div class="active-filters">
          <span class="label">Active:</span>
          <span class="chip">Apple <i class="fas fa-times"></i></span>
          <span class="chip">256 GB <i class="fas fa-times"></i></span>
          <span class="chip">Smartphones <i class="fas fa-times"></i></span>
          <button class="clear-all"><i class="fas fa-trash-can"></i> Clear All</button>
        </div>

        <!-- SECTION 08 — Results Grid -->
        <div class="products-grid">

          <!-- 1 -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-new">NEW</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1546054454-aa26e2b734c7?w=500&auto=format&fit=crop&q=80" alt="iPhone 16 Pro">
            </div>
            <h3><mark>iPhone</mark> 16 Pro</h3>
            <div class="product-cat">Apple • 8/256 GB</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(5.0)</span></div>
            <div class="price-row"><span class="price-now">$1,199</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 2 -->
          <article class="product-card">
            <div class="product-img">
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1591337676887-a217a6970a8a?w=500&auto=format&fit=crop&q=80" alt="iPhone 16">
            </div>
            <h3><mark>iPhone</mark> 16</h3>
            <div class="product-cat">Apple • 8/128 GB</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.8)</span></div>
            <div class="price-row"><span class="price-now">$899</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 3 -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-sale">-12%</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?w=500&auto=format&fit=crop&q=80" alt="iPhone 15 Pro Max">
            </div>
            <h3><mark>iPhone</mark> 15 Pro Max</h3>
            <div class="product-cat">Apple • 8/512 GB</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.9)</span></div>
            <div class="price-row"><span class="price-now">$1,099</span><span class="price-old">$1,249</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 4 -->
          <article class="product-card">
            <div class="product-img">
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1510557880182-3d4d3cba35a5?w=500&auto=format&fit=crop&q=80" alt="iPhone 15">
            </div>
            <h3><mark>iPhone</mark> 15</h3>
            <div class="product-cat">Apple • 6/128 GB</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.7)</span></div>
            <div class="price-row"><span class="price-now">$749</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 5 -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-hot">HOT</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1580910051074-3eb694886505?w=500&auto=format&fit=crop&q=80" alt="iPhone 14">
            </div>
            <h3><mark>iPhone</mark> 14</h3>
            <div class="product-cat">Apple • 6/128 GB</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i> <span>(4.4)</span></div>
            <div class="price-row"><span class="price-now">$599</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 6 -->
          <article class="product-card">
            <div class="product-img">
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1603891128711-11b4b03bb138?w=500&auto=format&fit=crop&q=80" alt="iPhone SE">
            </div>
            <h3><mark>iPhone</mark> SE (2025)</h3>
            <div class="product-cat">Apple • 4/64 GB</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.6)</span></div>
            <div class="price-row"><span class="price-now">$429</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 7 -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-sale">-20%</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1512499617640-c74ae3a79d37?w=500&auto=format&fit=crop&q=80" alt="iPhone 13">
            </div>
            <h3><mark>iPhone</mark> 13</h3>
            <div class="product-cat">Apple • 4/128 GB</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i> <span>(4.3)</span></div>
            <div class="price-row"><span class="price-now">$479</span><span class="price-old">$599</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 8 -->
          <article class="product-card">
            <div class="product-img">
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1585060544812-6b45742d762f?w=500&auto=format&fit=crop&q=80" alt="iPhone 12">
            </div>
            <h3><mark>iPhone</mark> 12</h3>
            <div class="product-cat">Apple • 4/64 GB</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i> <span>(4.2)</span></div>
            <div class="price-row"><span class="price-now">$399</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 9 -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-new">NEW</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1591337676887-a217a6970a8a?w=500&auto=format&fit=crop&q=80" alt="iPhone 16 Plus">
            </div>
            <h3><mark>iPhone</mark> 16 Plus</h3>
            <div class="product-cat">Apple • 8/256 GB</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.8)</span></div>
            <div class="price-row"><span class="price-now">$999</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 10 -->
          <article class="product-card">
            <div class="product-img">
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=500&auto=format&fit=crop&q=80" alt="iPhone case">
            </div>
            <h3><mark>iPhone</mark> Silicone Case</h3>
            <div class="product-cat">Apple • Accessory</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.7)</span></div>
            <div class="price-row"><span class="price-now">$49</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 11 -->
          <article class="product-card">
            <div class="product-img">
              <span class="tag tag-sale">-15%</span>
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1588423771073-b8903fbb85b5?w=500&auto=format&fit=crop&q=80" alt="iPhone charger">
            </div>
            <h3><mark>iPhone</mark> MagSafe Charger</h3>
            <div class="product-cat">Apple • Accessory</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i> <span>(4.5)</span></div>
            <div class="price-row"><span class="price-now">$34</span><span class="price-old">$40</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

          <!-- 12 -->
          <article class="product-card">
            <div class="product-img">
              <button class="wishlist"><i class="far fa-heart"></i></button>
              <img src="https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?w=500&auto=format&fit=crop&q=80" alt="iPhone airpods">
            </div>
            <h3>AirPods for <mark>iPhone</mark></h3>
            <div class="product-cat">Apple • Audio</div>
            <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.9)</span></div>
            <div class="price-row"><span class="price-now">$249</span></div>
            <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          </article>

        </div>
      </div>
    </div>
  </div>

  <!-- ============================================================
       PAGINATION
       ============================================================ -->
  <nav class="pagination container" aria-label="Search pagination">
    <a href="#" class="page-btn disabled"><i class="fas fa-chevron-left"></i></a>
    <a href="#" class="page-btn active">1</a>
    <a href="#" class="page-btn">2</a>
    <a href="#" class="page-btn">3</a>
    <a href="#" class="page-btn">4</a>
    <a href="#" class="page-btn"><i class="fas fa-chevron-right"></i></a>
  </nav>

  <!-- ============================================================
       SECTION 09 — NO RESULTS / EMPTY STATE (3D) — HIDDEN BY DEFAULT
       Remove `style="display:none"` to preview the no-results state.
       ============================================================ -->
  <section class="no-results container" style="display:none;">
    <div class="empty-visual">
      <div class="empty-ring"></div>
      <div class="empty-icon"><i class="fas fa-magnifying-glass"></i></div>
    </div>
    <h2>No results for <span>"samsng galaxy"</span></h2>
    <p>We couldn't find any products matching your search. Try checking your spelling, using fewer keywords, or browsing a category instead.</p>
    <div class="no-results-actions">
      <a href="#" class="btn btn-amber"><i class="fas fa-mobile-screen-button"></i> Browse Smartphones</a>
      <a href="#" class="btn btn-ghost"><i class="fas fa-house"></i> Go to Homepage</a>
    </div>

    <div class="suggestion-list">
      <div class="suggestion-item">
        <i class="fas fa-spell-check"></i>
        <div><b>Check your spelling</b><small>Make sure each word is written correctly.</small></div>
      </div>
      <div class="suggestion-item">
        <i class="fas fa-eraser"></i>
        <div><b>Use fewer keywords</b><small>Try a shorter or more general search term.</small></div>
      </div>
      <div class="suggestion-item">
        <i class="fas fa-layer-group"></i>
        <div><b>Browse categories</b><small>Explore our full device catalog by category.</small></div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 10 — RELATED SEARCHES & TRENDING PRODUCTS
       ============================================================ -->
  <section class="container">
    <div class="section-head">
      <h2>Related Searches</h2>
      <p>Popular searches other customers made</p>
    </div>

    <div class="related-searches">
      <span class="search-pill"><i class="fas fa-magnifying-glass"></i> iPhone 16 Pro Max</span>
      <span class="search-pill"><i class="fas fa-magnifying-glass"></i> iPhone cases</span>
      <span class="search-pill"><i class="fas fa-magnifying-glass"></i> Samsung Galaxy S25</span>
      <span class="search-pill"><i class="fas fa-magnifying-glass"></i> AirPods Pro</span>
      <span class="search-pill"><i class="fas fa-magnifying-glass"></i> iPad Air</span>
      <span class="search-pill"><i class="fas fa-magnifying-glass"></i> MacBook Pro</span>
      <span class="search-pill"><i class="fas fa-magnifying-glass"></i> Apple Watch Ultra</span>
      <span class="search-pill"><i class="fas fa-magnifying-glass"></i> iPhone charger</span>
    </div>

    <div class="section-head" style="margin-top: 3rem;">
      <h2>Trending Now</h2>
      <p>You may also like these popular products</p>
    </div>

    <div class="trending-row">
      <article class="product-card">
        <div class="product-img">
          <span class="tag tag-hot">HOT</span>
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=500&auto=format&fit=crop&q=80" alt="Trending phone">
        </div>
        <h3>Galaxy S25 Ultra</h3>
        <div class="product-cat">Samsung</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.9)</span></div>
        <div class="price-row"><span class="price-now">$1,299</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <article class="product-card">
        <div class="product-img">
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500&auto=format&fit=crop&q=80" alt="Trending laptop">
        </div>
        <h3>MacBook Pro 14"</h3>
        <div class="product-cat">Apple • Laptop</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(5.0)</span></div>
        <div class="price-row"><span class="price-now">$1,999</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <article class="product-card">
        <div class="product-img">
          <span class="tag tag-sale">-18%</span>
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&auto=format&fit=crop&q=80" alt="Trending headphones">
        </div>
        <h3>AirPods Max</h3>
        <div class="product-cat">Apple • Audio</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.8)</span></div>
        <div class="price-row"><span class="price-now">$449</span><span class="price-old">$549</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <article class="product-card">
        <div class="product-img">
          <span class="tag tag-new">NEW</span>
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=500&auto=format&fit=crop&q=80" alt="Trending watch">
        </div>
        <h3>Apple Watch Ultra 2</h3>
        <div class="product-cat">Apple • Wearable</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.9)</span></div>
        <div class="price-row"><span class="price-now">$799</span></div>
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
