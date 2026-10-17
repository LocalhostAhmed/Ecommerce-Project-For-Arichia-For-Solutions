<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Brands | ElectroHub</title>

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
       SECTION 02 — BRANDS HERO BANNER (3D)
       ============================================================ */
    .brands-hero {
      display: grid;
      grid-template-columns: 1.1fr 0.9fr;
      gap: 2.5rem;
      align-items: center;
      padding: 2.5rem 0.5rem 3.5rem;
      transform-style: preserve-3d;
    }
    .hero-text { transform: translateZ(50px); }
    .hero-tag {
      display: inline-flex; align-items: center; gap: 0.5rem;
      padding: 0.45rem 1.1rem;
      border-radius: 100px;
      background: rgba(245, 158, 11, 0.12);
      border: 1px solid rgba(245, 158, 11, 0.35);
      color: var(--amber);
      font-size: 0.78rem; font-weight: 600; letter-spacing: 0.4px;
      margin-bottom: 1.3rem;
      box-shadow: 0 8px 20px -8px var(--amber-glow);
    }
    .hero-text h1 {
      font-size: clamp(2.2rem, 5.5vw, 3.5rem);
      font-weight: 900; line-height: 1.08;
      letter-spacing: -0.03em; margin-bottom: 1.1rem;
      text-shadow: 0 20px 35px rgba(0,0,0,0.6);
    }
    .hero-text h1 span {
      background: linear-gradient(135deg, var(--amber), #fbbf24, #fde68a);
      -webkit-background-clip: text; background-clip: text; color: transparent;
    }
    .hero-text p { color: var(--muted); font-size: 1.02rem; max-width: 520px; margin-bottom: 1.6rem; }
    .hero-cta { display: flex; gap: 1rem; flex-wrap: wrap; }

    /* 3D floating brand logos orbit */
    .brand-orbit {
      position: relative;
      width: 100%;
      max-width: 420px;
      aspect-ratio: 1 / 1;
      margin: 0 auto;
      transform-style: preserve-3d;
      transform: rotateY(-10deg) rotateX(4deg) translateZ(30px);
      transition: transform 0.6s var(--ease);
      animation: riseUp 1s var(--ease) both;
    }
    .brand-orbit:hover { transform: rotateY(-3deg) rotateX(2deg) translateZ(55px); }

    .orbit-center {
      position: absolute;
      top: 50%; left: 50%;
      transform: translate(-50%, -50%) translateZ(45px);
      width: 130px; height: 130px;
      border-radius: 50%;
      background: linear-gradient(145deg, #fbbf24, #b45309);
      display: grid; place-items: center;
      color: #1a1206;
      font-size: 3.2rem;
      box-shadow: 0 30px 60px -15px var(--amber-glow), inset 0 2px 0 rgba(255,255,255,0.4);
      z-index: 5;
      animation: floaty 4s ease-in-out infinite;
    }

    .orbit-ring {
      position: absolute;
      inset: 0;
      border-radius: 50%;
      border: 2px dashed rgba(245,158,11,0.25);
      animation: rotate 30s linear infinite;
    }
    .orbit-ring.inner {
      inset: 60px;
      animation-duration: 22s;
      animation-direction: reverse;
      border-color: rgba(245,158,11,0.15);
    }

    .orbit-item {
      position: absolute;
      width: 68px; height: 68px;
      border-radius: 20px;
      background: var(--card);
      backdrop-filter: blur(12px);
      border: 1px solid var(--line);
      display: grid; place-items: center;
      color: var(--white);
      font-size: 1.5rem;
      box-shadow: 0 18px 35px -12px rgba(0,0,0,0.8), 0 0 0 1px rgba(255,255,255,0.05);
      transition: all 0.4s var(--ease);
      transform-style: preserve-3d;
    }
    .orbit-item:hover {
      border-color: var(--amber);
      color: var(--amber);
      transform: scale(1.15) translateZ(30px);
      box-shadow: 0 25px 45px -10px var(--amber-glow), 0 0 0 2px var(--amber-glow);
    }
    .orbit-item:hover i { filter: drop-shadow(0 0 12px var(--amber-glow)); }

    /* Position the orbit items around */
    .orbit-item.pos-1 { top: -5%; left: 40%; animation: floaty 5s ease-in-out infinite 0s; }
    .orbit-item.pos-2 { top: 22%; right: -8%; animation: floaty 5.5s ease-in-out infinite 0.3s; }
    .orbit-item.pos-3 { top: 65%; right: 0%; animation: floaty 6s ease-in-out infinite 0.5s; }
    .orbit-item.pos-4 { bottom: -6%; left: 45%; animation: floaty 5.2s ease-in-out infinite 0.8s; }
    .orbit-item.pos-5 { top: 65%; left: 0%; animation: floaty 5.8s ease-in-out infinite 1s; }
    .orbit-item.pos-6 { top: 22%; left: -8%; animation: floaty 6.2s ease-in-out infinite 1.3s; }

    /* ============================================================
       SECTION 03 — BRAND SEARCH & ALPHABET FILTER
       ============================================================ */
    .brand-search-box {
      background: var(--card);
      backdrop-filter: blur(14px);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      padding: 1.6rem;
      margin: 0.5rem 0 2rem;
      transform: translateZ(20px);
      box-shadow: 0 18px 35px -18px rgba(0,0,0,0.8);
    }

    .brand-search-input {
      display: flex; align-items: center; gap: 0.7rem;
      background: rgba(15,23,42,0.7);
      border: 1px solid var(--line);
      border-radius: 60px;
      padding: 0.7rem 1.3rem;
      margin-bottom: 1.4rem;
      transition: all 0.3s var(--ease);
      transform: translateZ(15px);
    }
    .brand-search-input:focus-within { border-color: var(--amber); box-shadow: 0 0 0 4px var(--amber-glow); }
    .brand-search-input i { color: var(--amber); }
    .brand-search-input input {
      flex: 1; background: transparent; border: none; outline: none;
      color: var(--white); font-family: inherit; font-size: 0.95rem;
    }
    .brand-search-input input::placeholder { color: var(--muted); }

    .alphabet-filter {
      display: flex; flex-wrap: wrap; gap: 0.4rem;
      justify-content: center;
    }
    .alpha-btn {
      min-width: 38px; height: 38px;
      padding: 0 0.5rem;
      display: grid; place-items: center;
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--line);
      border-radius: 10px;
      color: var(--muted);
      font-weight: 700; font-size: 0.85rem;
      cursor: pointer;
      transition: all 0.3s var(--ease);
    }
    .alpha-btn:hover {
      border-color: var(--amber); color: var(--amber);
      transform: translateY(-3px) translateZ(15px);
    }
    .alpha-btn.active {
      background: linear-gradient(145deg, #fbbf24, #f59e0b);
      color: #1a1206; border-color: var(--amber);
      box-shadow: 0 10px 20px -8px var(--amber-glow);
      transform: translateZ(10px);
    }
    .alpha-btn.disabled { opacity: 0.3; pointer-events: none; }

    /* ============================================================
       SECTION 04 — FEATURED / TOP BRANDS
       ============================================================ */
    .featured-brands {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 1.5rem;
      transform-style: preserve-3d;
    }
    .featured-card {
      position: relative;
      background: var(--card);
      backdrop-filter: blur(14px);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      padding: 2rem 1.5rem;
      text-align: center;
      overflow: hidden;
      box-shadow: 0 20px 40px -18px rgba(0,0,0,0.85);
      transition: all 0.5s var(--ease);
      transform-style: preserve-3d;
      cursor: pointer;
    }
    .featured-card::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at 50% 0%, rgba(245,158,11,0.15), transparent 70%);
      opacity: 0;
      transition: opacity 0.4s var(--ease);
    }
    .featured-card:hover::before { opacity: 1; }
    .featured-card:hover {
      transform: translateY(-12px) translateZ(50px) rotateX(4deg);
      border-color: rgba(245,158,11,0.4);
      box-shadow: 0 40px 70px -20px rgba(0,0,0,0.95), 0 0 0 1px var(--amber-glow);
    }

    .featured-logo-wrap {
      position: relative;
      width: 100px; height: 100px;
      margin: 0 auto 1.2rem;
      border-radius: 26px;
      background: rgba(15,23,42,0.8);
      border: 1px solid var(--line);
      display: grid; place-items: center;
      color: var(--white);
      font-size: 2.6rem;
      transform: translateZ(25px);
      transition: all 0.4s var(--ease);
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.06);
    }
    .featured-card:hover .featured-logo-wrap {
      color: var(--amber);
      transform: translateZ(45px) scale(1.08);
      border-color: var(--amber);
      box-shadow: 0 20px 40px -15px var(--amber-glow), inset 0 1px 0 rgba(255,255,255,0.1);
    }

    .featured-card h3 {
      font-size: 1.3rem; font-weight: 800;
      margin-bottom: 0.3rem;
      transform: translateZ(15px);
    }
    .featured-card .cat-label {
      display: inline-block;
      padding: 0.25rem 0.7rem;
      background: rgba(245,158,11,0.12);
      border: 1px solid rgba(245,158,11,0.3);
      border-radius: 60px;
      color: var(--amber);
      font-size: 0.72rem; font-weight: 700;
      letter-spacing: 0.5px;
      margin-bottom: 0.9rem;
      transform: translateZ(12px);
    }
    .featured-card .prod-count {
      color: var(--muted);
      font-size: 0.85rem;
      margin-bottom: 1.2rem;
      transform: translateZ(10px);
    }
    .featured-card .prod-count b { color: var(--white); font-weight: 800; }
    .featured-card .brand-arrow {
      display: inline-flex; align-items: center; gap: 0.4rem;
      color: var(--amber);
      font-size: 0.85rem; font-weight: 700;
      transition: all 0.3s var(--ease);
      transform: translateZ(15px);
    }
    .featured-card:hover .brand-arrow { transform: translateZ(25px) translateX(5px); }

    /* ============================================================
       SECTION 05 — ALL BRANDS GRID
       ============================================================ */
    .brands-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
      gap: 1.2rem;
      transform-style: preserve-3d;
    }
    .brand-card {
      position: relative;
      background: var(--card);
      backdrop-filter: blur(12px);
      border: 1px solid var(--line);
      border-radius: var(--radius-sm);
      padding: 1.6rem 1rem;
      text-align: center;
      transition: all 0.4s var(--ease);
      transform-style: preserve-3d;
      box-shadow: 0 15px 30px -15px rgba(0,0,0,0.7);
      cursor: pointer;
    }
    .brand-card:hover {
      transform: translateY(-8px) translateZ(35px) rotateX(4deg);
      border-color: rgba(245,158,11,0.4);
      box-shadow: 0 30px 50px -15px rgba(0,0,0,0.9), 0 0 0 1px var(--amber-glow);
    }

    .brand-logo {
      width: 64px; height: 64px;
      margin: 0 auto 1rem;
      display: grid; place-items: center;
      border-radius: 18px;
      background: rgba(15,23,42,0.7);
      border: 1px solid var(--line);
      color: var(--white);
      font-size: 1.7rem;
      transition: all 0.4s var(--ease);
      transform: translateZ(20px);
    }
    .brand-card:hover .brand-logo {
      color: var(--amber);
      border-color: var(--amber);
      transform: translateZ(35px) scale(1.08);
      box-shadow: 0 15px 30px -10px var(--amber-glow);
    }

    .brand-card h4 {
      font-size: 1rem; font-weight: 700;
      margin-bottom: 0.25rem;
      transform: translateZ(10px);
    }
    .brand-card small {
      color: var(--muted); font-size: 0.76rem;
      transform: translateZ(8px);
    }
    .brand-card small b { color: var(--amber); font-weight: 700; }

    /* ============================================================
       SECTION 06 — SHOP BY BRAND CATEGORY
       ============================================================ */
    .category-tabs {
      display: flex; gap: 0.7rem; flex-wrap: wrap;
      justify-content: center;
      padding: 0.5rem 0 2rem;
      transform: translateZ(20px);
    }
    .cat-tab {
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
    .cat-tab:hover {
      color: var(--amber); border-color: var(--amber);
      transform: translateY(-3px) translateZ(15px);
    }
    .cat-tab:active { transform: translateY(-1px) translateZ(5px); }
    .cat-tab.active {
      background: linear-gradient(145deg, #fbbf24, #f59e0b);
      color: #1a1206; border-color: var(--amber);
      box-shadow: 0 12px 25px -8px var(--amber-glow);
      transform: translateZ(15px);
    }
    .cat-tab i { font-size: 0.9rem; }

    /* ============================================================
       SECTION 07 — WHY BUY FROM OFFICIAL BRANDS?
       ============================================================ */
    .why-brands {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1.5rem;
      transform-style: preserve-3d;
    }
    .why-card {
      background: var(--card);
      backdrop-filter: blur(12px);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      padding: 2rem 1.5rem;
      text-align: center;
      transition: all 0.4s var(--ease);
      transform-style: preserve-3d;
      box-shadow: 0 18px 35px -18px rgba(0,0,0,0.8);
    }
    .why-card:hover {
      transform: translateY(-10px) translateZ(40px) rotateX(5deg);
      border-color: rgba(245,158,11,0.4);
    }
    .why-icon {
      width: 68px; height: 68px;
      margin: 0 auto 1.2rem;
      display: grid; place-items: center;
      border-radius: 20px;
      background: linear-gradient(145deg, rgba(245,158,11,0.2), rgba(245,158,11,0.05));
      border: 1px solid rgba(245,158,11,0.3);
      color: var(--amber);
      font-size: 1.6rem;
      transform: translateZ(25px);
      transition: transform 0.4s var(--ease);
    }
    .why-card:hover .why-icon { transform: translateZ(45px) scale(1.1); }
    .why-card h4 { font-size: 1.05rem; font-weight: 700; margin-bottom: 0.5rem; }
    .why-card p { color: var(--muted); font-size: 0.86rem; line-height: 1.6; }

    /* ============================================================
       SECTION 08 — POPULAR BRAND PRODUCTS CAROUSEL
       ============================================================ */
    .carousel-wrap {
      position: relative;
      transform-style: preserve-3d;
      perspective: 1400px;
      padding: 1rem 0 2rem;
    }
    .carousel-track {
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

    .brand-badge {
      position: absolute; top: 0.6rem; left: 0.6rem;
      padding: 0.25rem 0.65rem;
      font-size: 0.65rem; font-weight: 800;
      border-radius: 100px; letter-spacing: 0.5px; z-index: 2;
      background: rgba(15,23,42,0.9);
      backdrop-filter: blur(6px);
      border: 1px solid rgba(245,158,11,0.4);
      color: var(--amber);
      text-transform: uppercase;
    }
    .tag {
      position: absolute; top: 0.6rem; right: 2.8rem;
      padding: 0.25rem 0.65rem;
      font-size: 0.65rem; font-weight: 800;
      border-radius: 100px; letter-spacing: 0.5px; z-index: 2;
    }
    .tag-sale { background: #ef4444; color: #fff; }
    .tag-new { background: var(--amber); color: #1a1206; }

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
       SECTION 09 — NEWSLETTER
       ============================================================ */
    .newsletter {
      margin: 4rem 0 4rem;
      background: linear-gradient(135deg, rgba(245,158,11,0.16), rgba(30,41,59,0.7));
      border: 1px solid rgba(245,158,11,0.3);
      border-radius: 2rem;
      padding: 3rem 2rem;
      text-align: center;
      transform: translateZ(30px);
      box-shadow: 0 30px 60px -25px rgba(0,0,0,0.9);
    }
    .newsletter h2 { font-size: clamp(1.5rem, 3.2vw, 2.1rem); font-weight: 800; margin-bottom: 0.7rem; }
    .newsletter p { color: var(--muted); max-width: 520px; margin: 0 auto 1.8rem; font-size: 0.94rem; }
    .newsletter-form {
      display: flex; gap: 0.7rem; max-width: 520px;
      margin: 0 auto; flex-wrap: wrap; justify-content: center;
    }
    .newsletter-form input {
      flex: 1 1 260px; padding: 0.9rem 1.3rem;
      border-radius: 60px;
      border: 1px solid var(--line);
      background: rgba(15,23,42,0.7);
      color: var(--white); font-size: 0.9rem;
      outline: none; transition: all 0.3s var(--ease);
    }
    .newsletter-form input:focus { border-color: var(--amber); box-shadow: 0 0 0 4px var(--amber-glow); }

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
    @keyframes rotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    /* ============================================================
       RESPONSIVE
       ============================================================ */
    @media (max-width: 1024px) {
      .brands-hero { grid-template-columns: 1fr; text-align: center; padding: 1.5rem 0.5rem 2.5rem; }
      .hero-text p { margin-left: auto; margin-right: auto; }
      .hero-cta { justify-content: center; }
      .brand-orbit { transform: rotateY(0) rotateX(0) translateZ(20px); max-width: 340px; }
      .footer-grid { grid-template-columns: 1fr 1fr; gap: 2rem; }
    }

    @media (max-width: 640px) {
      body { padding: 0 0.7rem; }
      .announcement-inner { gap: 1rem; font-size: 0.72rem; }
      .search-bar { order: 3; flex: 1 1 100%; }
      .main-nav ul { gap: 1.2rem; font-size: 0.84rem; }
      .brands-hero { padding: 1.5rem 0.5rem 2rem; }
      .brand-orbit { max-width: 260px; }
      .orbit-center { width: 90px; height: 90px; font-size: 2.2rem; }
      .orbit-item { width: 48px; height: 48px; font-size: 1.05rem; border-radius: 14px; }
      .orbit-item.pos-2 { right: -3%; }
      .orbit-item.pos-6 { left: -3%; }
      .featured-card { padding: 1.5rem 1rem; }
      .featured-logo-wrap { width: 78px; height: 78px; font-size: 2rem; border-radius: 20px; }
      .brands-grid { grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 0.9rem; }
      .brand-card { padding: 1.2rem 0.8rem; }
      .brand-logo { width: 50px; height: 50px; font-size: 1.3rem; }
      .brand-card h4 { font-size: 0.88rem; }
      .brand-card small { font-size: 0.7rem; }
      .alpha-btn { min-width: 32px; height: 32px; font-size: 0.78rem; }
      .brand-search-input { padding: 0.6rem 1rem; }
      .brand-search-input input { font-size: 0.85rem; }
      .carousel-track { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem; }
      .product-card { padding: 0.9rem; }
      .product-card h3 { font-size: 0.88rem; }
      .price-now { font-size: 1.05rem; }
      .newsletter { padding: 2rem 1.2rem; }
      .footer-grid { grid-template-columns: 1fr; gap: 1.8rem; text-align: center; }
      .footer-brand p { margin-left: auto; margin-right: auto; }
      .social-row { justify-content: center; }
      .footer-bottom { flex-direction: column; text-align: center; }
      .cat-tab { padding: 0.6rem 1.1rem; font-size: 0.82rem; }
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
      <span class="current">Brands</span>
    </div>
  </nav>

  <!-- ============================================================
       SECTION 02 — BRANDS HERO BANNER (3D)
       ============================================================ -->
  <section class="brands-hero container">
    <div class="hero-text">
      <span class="hero-tag"><i class="fas fa-award"></i> 40+ official brands</span>
      <h1>Shop by <span>Brand</span></h1>
      <p>Explore the world's leading technology brands — all verified, all authentic, all in one place. Find your next device from the brands you trust.</p>
      <div class="hero-cta">
        <a href="#all-brands" class="btn btn-amber"><i class="fas fa-compass"></i> Browse Brands</a>
        <a href="#featured" class="btn btn-ghost"><i class="fas fa-star"></i> Top Picks</a>
      </div>
    </div>

    <!-- 3D floating brand orbit -->
    <div class="brand-orbit">
      <div class="orbit-ring"></div>
      <div class="orbit-ring inner"></div>

      <div class="orbit-center"><i class="fas fa-bolt"></i></div>

      <div class="orbit-item pos-1" title="Apple"><i class="fab fa-apple"></i></div>
      <div class="orbit-item pos-2" title="Samsung"><i class="fas fa-mobile-screen-button"></i></div>
      <div class="orbit-item pos-3" title="Dell"><i class="fas fa-laptop"></i></div>
      <div class="orbit-item pos-4" title="Sony"><i class="fas fa-headphones"></i></div>
      <div class="orbit-item pos-5" title="Xiaomi"><i class="fas fa-microchip"></i></div>
      <div class="orbit-item pos-6" title="HP"><i class="fas fa-desktop"></i></div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 03 — BRAND SEARCH & ALPHABET FILTER
       ============================================================ -->
  <div class="container">
    <div class="brand-search-box">
      <div class="brand-search-input">
        <i class="fas fa-magnifying-glass"></i>
        <input type="text" placeholder="Search for a brand... e.g. Apple, Samsung, Dell">
      </div>

      <div class="alphabet-filter">
        <button class="alpha-btn active">All</button>
        <button class="alpha-btn">A</button>
        <button class="alpha-btn">B</button>
        <button class="alpha-btn">C</button>
        <button class="alpha-btn">D</button>
        <button class="alpha-btn">E</button>
        <button class="alpha-btn">F</button>
        <button class="alpha-btn disabled">G</button>
        <button class="alpha-btn">H</button>
        <button class="alpha-btn">I</button>
        <button class="alpha-btn disabled">J</button>
        <button class="alpha-btn disabled">K</button>
        <button class="alpha-btn">L</button>
        <button class="alpha-btn">M</button>
        <button class="alpha-btn">N</button>
        <button class="alpha-btn disabled">O</button>
        <button class="alpha-btn">P</button>
        <button class="alpha-btn disabled">Q</button>
        <button class="alpha-btn">R</button>
        <button class="alpha-btn">S</button>
        <button class="alpha-btn">T</button>
        <button class="alpha-btn disabled">U</button>
        <button class="alpha-btn">V</button>
        <button class="alpha-btn">W</button>
        <button class="alpha-btn disabled">X</button>
        <button class="alpha-btn disabled">Y</button>
        <button class="alpha-btn">Z</button>
      </div>
    </div>
  </div>

  <!-- ============================================================
       SECTION 04 — FEATURED / TOP BRANDS
       ============================================================ -->
  <section class="container" id="featured">
    <div class="section-head">
      <h2>Featured Brands</h2>
      <p>Top manufacturers trusted by millions worldwide</p>
    </div>

    <div class="featured-brands">
      <div class="featured-card">
        <div class="featured-logo-wrap"><i class="fab fa-apple"></i></div>
        <h3>Apple</h3>
        <span class="cat-label">SMARTPHONES</span>
        <div class="prod-count"><b>320</b> products available</div>
        <span class="brand-arrow">Explore Brand <i class="fas fa-arrow-right"></i></span>
      </div>

      <div class="featured-card">
        <div class="featured-logo-wrap"><i class="fas fa-mobile-screen-button"></i></div>
        <h3>Samsung</h3>
        <span class="cat-label">SMARTPHONES</span>
        <div class="prod-count"><b>280</b> products available</div>
        <span class="brand-arrow">Explore Brand <i class="fas fa-arrow-right"></i></span>
      </div>

      <div class="featured-card">
        <div class="featured-logo-wrap"><i class="fas fa-laptop"></i></div>
        <h3>Dell</h3>
        <span class="cat-label">LAPTOPS</span>
        <div class="prod-count"><b>190</b> products available</div>
        <span class="brand-arrow">Explore Brand <i class="fas fa-arrow-right"></i></span>
      </div>

      <div class="featured-card">
        <div class="featured-logo-wrap"><i class="fas fa-desktop"></i></div>
        <h3>HP</h3>
        <span class="cat-label">LAPTOPS</span>
        <div class="prod-count"><b>160</b> products available</div>
        <span class="brand-arrow">Explore Brand <i class="fas fa-arrow-right"></i></span>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 05 — ALL BRANDS GRID
       ============================================================ -->
  <section class="container" id="all-brands">
    <div class="section-head">
      <h2>All Brands</h2>
      <p>Every manufacturer we carry — 40+ and growing</p>
    </div>

    <div class="brands-grid">
      <div class="brand-card">
        <div class="brand-logo"><i class="fab fa-apple"></i></div>
        <h4>Apple</h4>
        <small><b>320</b> products</small>
      </div>
      <div class="brand-card">
        <div class="brand-logo"><i class="fas fa-mobile-screen-button"></i></div>
        <h4>Samsung</h4>
        <small><b>280</b> products</small>
      </div>
      <div class="brand-card">
        <div class="brand-logo"><i class="fas fa-laptop"></i></div>
        <h4>Dell</h4>
        <small><b>190</b> products</small>
      </div>
      <div class="brand-card">
        <div class="brand-logo"><i class="fas fa-desktop"></i></div>
        <h4>HP</h4>
        <small><b>160</b> products</small>
      </div>
      <div class="brand-card">
        <div class="brand-logo"><i class="fas fa-laptop-code"></i></div>
        <h4>Lenovo</h4>
        <small><b>145</b> products</small>
      </div>
      <div class="brand-card">
        <div class="brand-logo"><i class="fas fa-microchip"></i></div>
        <h4>Xiaomi</h4>
        <small><b>210</b> products</small>
      </div>
      <div class="brand-card">
        <div class="brand-logo"><i class="fas fa-headphones"></i></div>
        <h4>Sony</h4>
        <small><b>180</b> products</small>
      </div>
      <div class="brand-card">
        <div class="brand-logo"><i class="fas fa-mobile-alt"></i></div>
        <h4>Google</h4>
        <small><b>75</b> products</small>
      </div>
      <div class="brand-card">
        <div class="brand-logo"><i class="fas fa-bolt"></i></div>
        <h4>OnePlus</h4>
        <small><b>60</b> products</small>
      </div>
      <div class="brand-card">
        <div class="brand-logo"><i class="fas fa-tablet-screen-button"></i></div>
        <h4>Huawei</h4>
        <small><b>85</b> products</small>
      </div>
      <div class="brand-card">
        <div class="brand-logo"><i class="fas fa-gamepad"></i></div>
        <h4>Asus</h4>
        <small><b>110</b> products</small>
      </div>
      <div class="brand-card">
        <div class="brand-logo"><i class="fas fa-laptop-medical"></i></div>
        <h4>Acer</h4>
        <small><b>95</b> products</small>
      </div>
      <div class="brand-card">
        <div class="brand-logo"><i class="fas fa-camera"></i></div>
        <h4>Canon</h4>
        <small><b>65</b> products</small>
      </div>
      <div class="brand-card">
        <div class="brand-logo"><i class="fas fa-camera-retro"></i></div>
        <h4>Nikon</h4>
        <small><b>55</b> products</small>
      </div>
      <div class="brand-card">
        <div class="brand-logo"><i class="fas fa-music"></i></div>
        <h4>JBL</h4>
        <small><b>140</b> products</small>
      </div>
      <div class="brand-card">
        <div class="brand-logo"><i class="fas fa-wifi"></i></div>
        <h4>TP-Link</h4>
        <small><b>70</b> products</small>
      </div>
      <div class="brand-card">
        <div class="brand-logo"><i class="fas fa-tv"></i></div>
        <h4>LG</h4>
        <small><b>120</b> products</small>
      </div>
      <div class="brand-card">
        <div class="brand-logo"><i class="fas fa-robot"></i></div>
        <h4>Nothing</h4>
        <small><b>25</b> products</small>
      </div>
      <div class="brand-card">
        <div class="brand-logo"><i class="fas fa-microchip"></i></div>
        <h4>Intel</h4>
        <small><b>45</b> products</small>
      </div>
      <div class="brand-card">
        <div class="brand-logo"><i class="fas fa-microchip"></i></div>
        <h4>AMD</h4>
        <small><b>40</b> products</small>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 06 — SHOP BY BRAND CATEGORY
       ============================================================ -->
  <section class="container">
    <div class="section-head">
      <h2>Shop by Brand Category</h2>
      <p>Filter brands by the type of device you need</p>
    </div>

    <div class="category-tabs">
      <button class="cat-tab active"><i class="fas fa-border-all"></i> All</button>
      <button class="cat-tab"><i class="fas fa-mobile-screen-button"></i> Smartphones</button>
      <button class="cat-tab"><i class="fas fa-laptop"></i> Laptops</button>
      <button class="cat-tab"><i class="fas fa-tablet-screen-button"></i> Tablets</button>
      <button class="cat-tab"><i class="fas fa-headphones"></i> Audio</button>
      <button class="cat-tab"><i class="fas fa-plug"></i> Accessories</button>
      <button class="cat-tab"><i class="fas fa-camera"></i> Cameras</button>
      <button class="cat-tab"><i class="fas fa-tv"></i> Displays</button>
    </div>
  </section>

  <!-- ============================================================
       SECTION 07 — WHY BUY FROM OFFICIAL BRANDS?
       ============================================================ -->
  <section class="container">
    <div class="section-head">
      <h2>Why Buy From Official Brands?</h2>
      <p>Every brand we carry is 100% authentic and verified</p>
    </div>

    <div class="why-brands">
      <div class="why-card">
        <div class="why-icon"><i class="fas fa-certificate"></i></div>
        <h4>100% Genuine</h4>
        <p>Every product is sourced directly from authorized distributors with official packaging.</p>
      </div>
      <div class="why-card">
        <div class="why-icon"><i class="fas fa-shield-halved"></i></div>
        <h4>Official Warranty</h4>
        <p>Full manufacturer warranty valid nationwide, plus our own additional 1-year protection.</p>
      </div>
      <div class="why-card">
        <div class="why-icon"><i class="fas fa-handshake"></i></div>
        <h4>Authorized Reseller</h4>
        <p>We're an officially recognized reseller for every brand listed on this page.</p>
      </div>
      <div class="why-card">
        <div class="why-icon"><i class="fas fa-headset"></i></div>
        <h4>Brand Support</h4>
        <p>Direct access to manufacturer support channels for warranty claims and updates.</p>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 08 — POPULAR BRAND PRODUCTS CAROUSEL
       ============================================================ -->
  <section class="container">
    <div class="section-head">
      <h2>Popular Brand Products</h2>
      <p>Top-selling devices from our featured manufacturers</p>
    </div>

    <div class="carousel-wrap">
      <div class="carousel-track">

        <!-- Apple iPhone -->
        <article class="product-card">
          <div class="product-img">
            <span class="brand-badge">Apple</span>
            <span class="tag tag-new">NEW</span>
            <button class="wishlist"><i class="far fa-heart"></i></button>
            <img src="https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=500&auto=format&fit=crop&q=80" alt="iPhone 16 Pro Max">
          </div>
          <h3>iPhone 16 Pro Max</h3>
          <div class="product-cat">Smartphone</div>
          <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(5.0)</span></div>
          <div class="price-row"><span class="price-now">$1,199</span></div>
          <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
        </article>

        <!-- Samsung Galaxy -->
        <article class="product-card">
          <div class="product-img">
            <span class="brand-badge">Samsung</span>
            <span class="tag tag-sale">-12%</span>
            <button class="wishlist"><i class="far fa-heart"></i></button>
            <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=500&auto=format&fit=crop&q=80" alt="Galaxy S25 Ultra">
          </div>
          <h3>Galaxy S25 Ultra</h3>
          <div class="product-cat">Smartphone</div>
          <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.9)</span></div>
          <div class="price-row"><span class="price-now">$1,299</span><span class="price-old">$1,479</span></div>
          <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
        </article>

        <!-- Dell Laptop -->
        <article class="product-card">
          <div class="product-img">
            <span class="brand-badge">Dell</span>
            <button class="wishlist"><i class="far fa-heart"></i></button>
            <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500&auto=format&fit=crop&q=80" alt="Dell XPS">
          </div>
          <h3>Dell XPS 15</h3>
          <div class="product-cat">Laptop</div>
          <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.7)</span></div>
          <div class="price-row"><span class="price-now">$1,799</span></div>
          <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
        </article>

        <!-- Sony Headphones -->
        <article class="product-card">
          <div class="product-img">
            <span class="brand-badge">Sony</span>
            <span class="tag tag-sale">-20%</span>
            <button class="wishlist"><i class="far fa-heart"></i></button>
            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&auto=format&fit=crop&q=80" alt="Sony WH-1000XM5">
          </div>
          <h3>Sony WH-1000XM5</h3>
          <div class="product-cat">Headphones</div>
          <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.9)</span></div>
          <div class="price-row"><span class="price-now">$319</span><span class="price-old">$399</span></div>
          <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
        </article>

        <!-- Xiaomi -->
        <article class="product-card">
          <div class="product-img">
            <span class="brand-badge">Xiaomi</span>
            <button class="wishlist"><i class="far fa-heart"></i></button>
            <img src="https://images.unsplash.com/photo-1567581935884-3349723552ca?w=500&auto=format&fit=crop&q=80" alt="Xiaomi 15">
          </div>
          <h3>Xiaomi 15 Ultra</h3>
          <div class="product-cat">Smartphone</div>
          <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.9)</span></div>
          <div class="price-row"><span class="price-now">$1,099</span></div>
          <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
        </article>

        <!-- Google Pixel -->
        <article class="product-card">
          <div class="product-img">
            <span class="brand-badge">Google</span>
            <span class="tag tag-new">NEW</span>
            <button class="wishlist"><i class="far fa-heart"></i></button>
            <img src="https://images.unsplash.com/photo-1601784551446-20c9e07cdbdb?w=500&auto=format&fit=crop&q=80" alt="Pixel 9 Pro">
          </div>
          <h3>Pixel 9 Pro</h3>
          <div class="product-cat">Smartphone</div>
          <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.8)</span></div>
          <div class="price-row"><span class="price-now">$999</span></div>
          <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
        </article>

        <!-- HP -->
        <article class="product-card">
          <div class="product-img">
            <span class="brand-badge">HP</span>
            <button class="wishlist"><i class="far fa-heart"></i></button>
            <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500&auto=format&fit=crop&q=80" alt="HP Spectre">
          </div>
          <h3>HP Spectre x360</h3>
          <div class="product-cat">Laptop</div>
          <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.6)</span></div>
          <div class="price-row"><span class="price-now">$1,449</span></div>
          <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
        </article>

        <!-- Lenovo -->
        <article class="product-card">
          <div class="product-img">
            <span class="brand-badge">Lenovo</span>
            <button class="wishlist"><i class="far fa-heart"></i></button>
            <img src="https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=500&auto=format&fit=crop&q=80" alt="Lenovo ThinkPad">
          </div>
          <h3>ThinkPad X1 Carbon</h3>
          <div class="product-cat">Laptop</div>
          <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.8)</span></div>
          <div class="price-row"><span class="price-now">$1,599</span></div>
          <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
        </article>

      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 09 — NEWSLETTER & BRAND UPDATES
       ============================================================ -->
  <section class="container">
    <div class="newsletter">
      <h2>Get Brand Updates</h2>
      <p>Subscribe to receive notifications about new brand arrivals, exclusive brand-specific deals, and early access to launches.</p>
      <form class="newsletter-form" onsubmit="return false;">
        <input type="email" placeholder="Enter your email address" required>
        <button type="submit" class="btn btn-amber"><i class="fas fa-paper-plane"></i> Subscribe</button>
      </form>
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
