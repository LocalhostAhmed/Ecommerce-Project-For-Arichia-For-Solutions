<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ElectroHub | Technology. Everything in one place.</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    /* ============================================================
       DESIGN TOKENS — ElectroHub Visual Identity
       ============================================================ */
    :root {
      --navy: #0F172A;          /* Midnight Navy   */
      --navy-soft: #1E293B;
      --amber: #F59E0B;         /* Electric Amber  */
      --amber-glow: rgba(245, 158, 11, 0.45);
      --white: #F8FAFC;         /* Cloud White     */
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

    /* ============================================================
       GLOBAL 3D SCENE
       ============================================================ */
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
      margin: 4.5rem 0 2.5rem;
      transform: translateZ(30px);
    }
    .section-head h2 {
      font-size: clamp(1.8rem, 4vw, 2.6rem);
      font-weight: 800;
      letter-spacing: -0.02em;
      background: linear-gradient(135deg, #ffffff 30%, #93c5fd 100%);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    .section-head p { color: var(--muted); margin-top: 0.5rem; font-size: 1rem; }

    /* Buttons */
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 0.6rem;
      padding: 0.9rem 1.9rem;
      border-radius: 60px;
      font-weight: 600;
      font-size: 0.95rem;
      transition: all 0.35s var(--ease);
      border: 1px solid transparent;
      cursor: pointer;
      transform-style: preserve-3d;
    }
    .btn-amber {
      background: linear-gradient(145deg, #fbbf24, #f59e0b);
      color: #1a1206;
      box-shadow: 0 12px 25px -8px var(--amber-glow), inset 0 1px 0 rgba(255,255,255,0.4);
    }
    .btn-amber:hover {
      transform: translateY(-5px) translateZ(25px);
      box-shadow: 0 25px 40px -10px var(--amber-glow);
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
      transform: translateY(-5px) translateZ(25px);
    }

    /* ============================================================
       SECTION 1 — ANNOUNCEMENT BAR
       ============================================================ */
    .announcement {
      background: linear-gradient(90deg, #1E293B, #0F172A 50%, #1E293B);
      border-bottom: 1px solid var(--line);
      font-size: 0.85rem;
      color: var(--muted);
      overflow: hidden;
      transform: translateZ(10px);
    }
    .announcement-inner {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 2.5rem;
      padding: 0.6rem 1rem;
      flex-wrap: wrap;
    }
    .announcement span { display: inline-flex; align-items: center; gap: 0.4rem; }
    .announcement i { color: var(--amber); }

    /* ============================================================
       SECTION 2 — MAIN HEADER & NAVIGATION
       ============================================================ */
    .header {
      position: sticky;
      top: 0;
      z-index: 100;
      background: rgba(15, 23, 42, 0.75);
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
    .header-icons .icon-btn {
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
    .header-icons .icon-btn:hover {
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

    /* Main nav links */
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
      width: 0; height: 2px;
      background: var(--amber);
      transition: width 0.3s var(--ease);
    }
    .main-nav a:hover { color: var(--amber); }
    .main-nav a:hover::after { width: 100%; }

    /* ============================================================
       SECTION 3 — HERO BANNER
       ============================================================ */
    .hero {
      display: grid;
      grid-template-columns: 1.1fr 0.9fr;
      gap: 2.5rem;
      align-items: center;
      padding: 4.5rem 0.5rem 5rem;
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
      font-size: 0.8rem; font-weight: 600; letter-spacing: 0.4px;
      margin-bottom: 1.4rem;
      box-shadow: 0 8px 20px -8px var(--amber-glow);
    }
    .hero h1 {
      font-size: clamp(2.2rem, 5.5vw, 3.9rem);
      font-weight: 900; line-height: 1.08;
      letter-spacing: -0.03em; margin-bottom: 1.2rem;
      text-shadow: 0 20px 35px rgba(0,0,0,0.6);
    }
    .hero h1 span {
      background: linear-gradient(135deg, var(--amber), #fbbf24, #fde68a);
      -webkit-background-clip: text; background-clip: text; color: transparent;
    }
    .hero p { color: var(--muted); font-size: 1.05rem; max-width: 520px; margin-bottom: 2rem; }
    .hero-cta { display: flex; gap: 1rem; flex-wrap: wrap; }

    .hero-visual {
      display: flex; justify-content: center;
      transform-style: preserve-3d;
      transform: rotateY(-12deg) rotateX(5deg) translateZ(30px);
      transition: transform 0.6s var(--ease);
      animation: riseUp 1s var(--ease) both;
    }
    .hero-visual:hover { transform: rotateY(-5deg) rotateX(2deg) translateZ(60px); }
    .hero-card {
      background: var(--card);
      backdrop-filter: blur(18px);
      border: 1px solid var(--line);
      border-radius: 2rem;
      padding: 1.4rem;
      box-shadow: var(--shadow), 0 0 0 1px rgba(255,255,255,0.05);
      transform-style: preserve-3d;
      max-width: 420px;
    }
    .hero-card img {
      border-radius: 1.4rem;
      filter: drop-shadow(0 25px 30px rgba(0,0,0,0.75));
      transform: translateZ(25px);
    }
    .hero-card-meta {
      display: flex; justify-content: space-between; align-items: center;
      margin-top: 1.2rem; padding: 0 0.4rem;
      transform: translateZ(15px);
    }
    .hero-card-meta h4 { font-size: 1.15rem; font-weight: 700; }
    .hero-card-meta span { color: var(--amber); font-weight: 800; font-size: 1.35rem; }

    /* ============================================================
       SECTION 4 — SHOP BY CATEGORIES
       ============================================================ */
    .categories-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
      gap: 1.2rem;
      transform-style: preserve-3d;
    }
    .cat-card {
      background: var(--card);
      backdrop-filter: blur(12px);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      padding: 1.8rem 1rem;
      text-align: center;
      transition: all 0.4s var(--ease);
      transform-style: preserve-3d;
      box-shadow: 0 15px 30px -15px rgba(0,0,0,0.7);
      cursor: pointer;
    }
    .cat-card:hover {
      transform: translateY(-10px) translateZ(40px) rotateX(6deg);
      border-color: rgba(245, 158, 11, 0.4);
      box-shadow: 0 30px 50px -15px rgba(0,0,0,0.9), 0 0 0 1px var(--amber-glow);
    }
    .cat-icon {
      width: 62px; height: 62px;
      margin: 0 auto 1rem;
      display: grid; place-items: center;
      border-radius: 50%;
      background: linear-gradient(145deg, rgba(245,158,11,0.18), rgba(245,158,11,0.05));
      border: 1px solid rgba(245,158,11,0.3);
      color: var(--amber);
      font-size: 1.5rem;
      transform: translateZ(20px);
      transition: transform 0.4s var(--ease);
    }
    .cat-card:hover .cat-icon { transform: translateZ(35px) scale(1.08); }
    .cat-card h4 { font-size: 0.98rem; font-weight: 600; }
    .cat-card small { color: var(--muted); font-size: 0.78rem; }

    /* ============================================================
       PRODUCT GRID (shared by Best Sellers / Deals / New Arrivals)
       ============================================================ */
    .products-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
      gap: 1.6rem;
      transform-style: preserve-3d;
    }
    .product-card {
      position: relative;
      background: var(--card);
      backdrop-filter: blur(14px);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      padding: 1.2rem;
      box-shadow: 0 18px 35px -18px rgba(0,0,0,0.8);
      transition: all 0.4s var(--ease);
      transform-style: preserve-3d;
      display: flex; flex-direction: column;
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
      margin-bottom: 1rem;
      transform: translateZ(15px);
    }
    .product-img img {
      width: 100%; height: 100%;
      object-fit: cover;
      transition: transform 0.5s var(--ease);
    }
    .product-card:hover .product-img img { transform: scale(1.08); }

    .tag {
      position: absolute; top: 0.7rem; left: 0.7rem;
      padding: 0.28rem 0.7rem;
      font-size: 0.68rem; font-weight: 800;
      border-radius: 100px;
      letter-spacing: 0.5px;
      z-index: 2;
    }
    .tag-sale { background: #ef4444; color: #fff; }
    .tag-new  { background: var(--amber); color: #1a1206; }

    .wishlist {
      position: absolute; top: 0.7rem; right: 0.7rem;
      width: 34px; height: 34px;
      display: grid; place-items: center;
      border-radius: 50%;
      background: rgba(15,23,42,0.75);
      border: 1px solid var(--line);
      color: var(--white); cursor: pointer; z-index: 2;
      transition: all 0.3s var(--ease);
    }
    .wishlist:hover { color: #ef4444; border-color: #ef4444; transform: scale(1.12); }

    .product-card h3 { font-size: 1.02rem; font-weight: 600; margin-bottom: 0.25rem; }
    .product-cat { font-size: 0.78rem; color: var(--muted); margin-bottom: 0.5rem; }

    .rating { display: flex; align-items: center; gap: 0.3rem; font-size: 0.78rem; color: var(--amber); margin-bottom: 0.7rem; }
    .rating span { color: var(--muted); }

    .price-row { display: flex; align-items: baseline; gap: 0.5rem; margin-top: auto; margin-bottom: 0.9rem; }
    .price-now { font-size: 1.25rem; font-weight: 800; color: var(--amber); }
    .price-old { font-size: 0.85rem; color: var(--muted); text-decoration: line-through; }

    .add-cart {
      width: 100%;
      padding: 0.75rem;
      border-radius: 60px;
      border: 1px solid rgba(245,158,11,0.4);
      background: rgba(245,158,11,0.1);
      color: var(--amber);
      font-weight: 600; font-size: 0.88rem;
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
       SECTION 6 — FLASH DEALS (with countdown)
       ============================================================ */
    .deals-banner {
      background: linear-gradient(135deg, rgba(245,158,11,0.14), rgba(30,41,59,0.6));
      border: 1px solid rgba(245,158,11,0.28);
      border-radius: var(--radius);
      padding: 1.5rem 1.8rem;
      margin-bottom: 2rem;
      display: flex; justify-content: space-between; align-items: center;
      flex-wrap: wrap; gap: 1.2rem;
      transform: translateZ(25px);
      box-shadow: 0 20px 40px -20px rgba(0,0,0,0.8);
    }
    .deals-banner h3 { font-size: 1.35rem; font-weight: 800; }
    .deals-banner h3 i { color: var(--amber); }
    .countdown { display: flex; gap: 0.7rem; }
    .countdown-box {
      background: rgba(15,23,42,0.85);
      border: 1px solid var(--line);
      border-radius: 0.9rem;
      padding: 0.6rem 0.9rem;
      text-align: center;
      min-width: 62px;
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.06);
    }
    .countdown-box b { display: block; font-size: 1.35rem; font-weight: 800; color: var(--amber); line-height: 1; }
    .countdown-box small { font-size: 0.65rem; color: var(--muted); text-transform: uppercase; letter-spacing: 0.6px; }

    /* ============================================================
       SECTION 8 — FEATURED BRANDS
       ============================================================ */
    .brands-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
      gap: 1.2rem;
      transform-style: preserve-3d;
    }
    .brand-card {
      background: var(--card);
      backdrop-filter: blur(10px);
      border: 1px solid var(--line);
      border-radius: var(--radius-sm);
      padding: 1.6rem 1rem;
      display: grid; place-items: center;
      transition: all 0.4s var(--ease);
      transform-style: preserve-3d;
      box-shadow: 0 12px 25px -15px rgba(0,0,0,0.7);
    }
    .brand-card:hover {
      transform: translateY(-8px) translateZ(35px);
      border-color: rgba(245,158,11,0.4);
      box-shadow: 0 25px 40px -15px rgba(0,0,0,0.9);
    }
    .brand-card span {
      font-weight: 800;
      letter-spacing: 0.5px;
      font-size: 1.05rem;
      color: var(--muted);
      transition: color 0.3s var(--ease);
    }
    .brand-card:hover span { color: var(--amber); }

    /* ============================================================
       SECTION 9 — WHY CHOOSE ELECTROHUB
       ============================================================ */
    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1.5rem;
      transform-style: preserve-3d;
    }
    .feature-card {
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
    .feature-card:hover {
      transform: translateY(-10px) translateZ(40px) rotateX(5deg);
      border-color: rgba(245,158,11,0.4);
    }
    .feature-icon {
      width: 68px; height: 68px;
      margin: 0 auto 1.2rem;
      display: grid; place-items: center;
      border-radius: 20px;
      background: linear-gradient(145deg, rgba(245,158,11,0.2), rgba(245,158,11,0.04));
      border: 1px solid rgba(245,158,11,0.3);
      color: var(--amber);
      font-size: 1.6rem;
      transform: translateZ(25px);
      transition: transform 0.4s var(--ease);
    }
    .feature-card:hover .feature-icon { transform: translateZ(45px) scale(1.1); }
    .feature-card h4 { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; }
    .feature-card p { color: var(--muted); font-size: 0.88rem; }

    /* ============================================================
       SECTION 10 — CUSTOMER REVIEWS
       ============================================================ */
    .reviews-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 1.5rem;
      transform-style: preserve-3d;
    }
    .review-card {
      background: var(--card);
      backdrop-filter: blur(12px);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      padding: 1.8rem;
      transition: all 0.4s var(--ease);
      transform-style: preserve-3d;
      box-shadow: 0 18px 35px -18px rgba(0,0,0,0.8);
    }
    .review-card:hover {
      transform: translateY(-8px) translateZ(35px);
      border-color: rgba(245,158,11,0.35);
    }
    .review-stars { color: var(--amber); margin-bottom: 0.8rem; font-size: 0.85rem; }
    .review-text { color: #cbd5e1; font-size: 0.92rem; font-style: italic; margin-bottom: 1.2rem; }
    .review-user { display: flex; align-items: center; gap: 0.8rem; }
    .review-avatar {
      width: 44px; height: 44px; border-radius: 50%;
      object-fit: cover; border: 2px solid var(--amber);
      transform: translateZ(15px);
    }
    .review-user b { display: block; font-size: 0.9rem; }
    .review-user small { color: var(--muted); font-size: 0.76rem; display: flex; align-items: center; gap: 0.3rem; }
    .review-user small i { color: #22c55e; }

    /* ============================================================
       SECTION 11 — NEWSLETTER
       ============================================================ */
    .newsletter {
      margin: 5rem 0;
      background: linear-gradient(135deg, rgba(245,158,11,0.16), rgba(30,41,59,0.7));
      border: 1px solid rgba(245,158,11,0.3);
      border-radius: 2rem;
      padding: 3rem 2rem;
      text-align: center;
      transform: translateZ(30px);
      box-shadow: 0 30px 60px -25px rgba(0,0,0,0.9);
    }
    .newsletter h2 { font-size: clamp(1.6rem, 3.5vw, 2.2rem); font-weight: 800; margin-bottom: 0.7rem; }
    .newsletter p { color: var(--muted); max-width: 540px; margin: 0 auto 1.8rem; font-size: 0.95rem; }
    .newsletter-form {
      display: flex; gap: 0.7rem; max-width: 540px;
      margin: 0 auto; flex-wrap: wrap; justify-content: center;
    }
    .newsletter-form input {
      flex: 1 1 260px;
      padding: 0.9rem 1.3rem;
      border-radius: 60px;
      border: 1px solid var(--line);
      background: rgba(15,23,42,0.7);
      color: var(--white);
      font-size: 0.92rem;
      outline: none;
      transition: all 0.3s var(--ease);
    }
    .newsletter-form input:focus { border-color: var(--amber); box-shadow: 0 0 0 4px var(--amber-glow); }

    /* ============================================================
       SECTION 12 — FOOTER
       ============================================================ */
    .footer {
      background: linear-gradient(180deg, rgba(15,23,42,0.4), rgba(6,10,18,0.9));
      border-top: 1px solid var(--line);
      padding: 3.5rem 0 1.5rem;
      margin-top: 2rem;
      transform: translateZ(15px);
    }
    .footer-grid {
      display: grid;
      grid-template-columns: 1.4fr repeat(3, 1fr);
      gap: 2.5rem;
      padding-bottom: 2.5rem;
      border-bottom: 1px solid var(--line);
    }
    .footer-brand .logo { margin-bottom: 1rem; }
    .footer-brand p { color: var(--muted); font-size: 0.88rem; max-width: 320px; margin-bottom: 1.2rem; }
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
    .social-row a:hover {
      color: var(--amber); border-color: var(--amber);
      transform: translateY(-4px) translateZ(15px);
    }
    .footer-col h5 {
      font-size: 0.95rem; font-weight: 700;
      margin-bottom: 1.1rem; color: var(--white);
    }
    .footer-col ul { display: flex; flex-direction: column; gap: 0.7rem; }
    .footer-col a { color: var(--muted); font-size: 0.88rem; transition: color 0.3s var(--ease); }
    .footer-col a:hover { color: var(--amber); }

    .footer-bottom {
      display: flex; justify-content: space-between; align-items: center;
      gap: 1rem; padding-top: 1.5rem; flex-wrap: wrap;
      color: var(--muted); font-size: 0.82rem;
    }
    .payment-methods { display: flex; gap: 0.9rem; font-size: 1.5rem; color: var(--muted); }
    .payment-methods i:hover { color: var(--amber); }

    /* ============================================================
       ANIMATIONS
       ============================================================ */
    @keyframes riseUp {
      0% { opacity: 0; transform: translateY(35px) scale(0.98); }
      100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ============================================================
       RESPONSIVE — TABLET
       ============================================================ */
    @media (max-width: 1024px) {
      .hero { grid-template-columns: 1fr; text-align: center; padding: 3rem 0.5rem 4rem; }
      .hero p { margin-left: auto; margin-right: auto; }
      .hero-cta { justify-content: center; }
      .hero-visual { transform: rotateY(0) rotateX(0) translateZ(20px); }
      .footer-grid { grid-template-columns: 1fr 1fr; gap: 2rem; }
    }

    /* ============================================================
       RESPONSIVE — MOBILE
       ============================================================ */
    @media (max-width: 640px) {
      body { padding: 0 0.7rem; }
      .announcement-inner { gap: 1rem; font-size: 0.75rem; }
      .header-inner { gap: 1rem; }
      .search-bar { order: 3; flex: 1 1 100%; }
      .main-nav ul { gap: 1.2rem; font-size: 0.85rem; }
      .hero h1 { font-size: 2.1rem; }
      .section-head { margin: 3rem 0 1.8rem; }
      .deals-banner { flex-direction: column; text-align: center; }
      .newsletter { padding: 2.2rem 1.2rem; }
      .footer-grid { grid-template-columns: 1fr; gap: 1.8rem; text-align: center; }
      .footer-brand p { margin-left: auto; margin-right: auto; }
      .social-row { justify-content: center; }
      .footer-bottom { flex-direction: column; text-align: center; }
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
      <span><i class="fas fa-truck-fast"></i> Free shipping on orders over $99</span>
      <span><i class="fas fa-tags"></i> Summer sale — up to 40% off</span>
      <span><i class="fas fa-shield-halved"></i> 2-year warranty on all devices</span>
    </div>
  </div>

  <!-- ============================================================
       SECTION 2 — MAIN HEADER & NAVIGATION
       ============================================================ -->
  <header class="header">
    <div class="header-inner container">
      <!-- Logo -->
      <a href="#" class="logo">
        <span class="logo-mark"><i class="fas fa-bolt"></i></span>
        <span class="logo-text">Electro<b>Hub</b></span>
      </a>

      <!-- Search -->
      <form class="search-bar" onsubmit="return false;">
        <i class="fas fa-magnifying-glass"></i>
        <input type="text" placeholder="Search for phones, laptops, headphones...">
      </form>

      <!-- Icons -->
      <div class="header-icons">
        <a href="#" class="icon-btn" title="Account"><i class="far fa-user"></i></a>
        <a href="#" class="icon-btn" title="Wishlist"><i class="far fa-heart"></i></a>
        <a href="#" class="icon-btn" title="Cart">
          <i class="fas fa-shopping-cart"></i>
          <span class="badge-count">3</span>
        </a>
      </div>
    </div>

    <!-- Main Nav -->
    <nav class="main-nav">
      <ul class="container">
        <li><a href="#">Home</a></li>
        <li><a href="#categories">Shop</a></li>
        <li><a href="#categories">Categories</a></li>
        <li><a href="#deals">Deals</a></li>
        <li><a href="#brands">Brands</a></li>
        <li><a href="#reviews">Reviews</a></li>
        <li><a href="#footer">Contact</a></li>
      </ul>
    </nav>
  </header>

  <!-- ============================================================
       SECTION 3 — HERO BANNER
       ============================================================ -->
  <section class="hero container">
    <div class="hero-text">
      <span class="hero-tag"><i class="fas fa-star"></i> New arrivals — 2025 collection</span>
      <h1>Technology.<br><span>Everything in one place.</span></h1>
      <p>Discover premium smartphones, laptops, headphones, and smart devices — all with genuine warranties, fast delivery, and unbeatable prices.</p>
      <div class="hero-cta">
        <a href="#best" class="btn btn-amber"><i class="fas fa-bag-shopping"></i> Shop Now</a>
        <a href="#deals" class="btn btn-ghost"><i class="fas fa-bolt"></i> View Deals</a>
      </div>
    </div>

    <div class="hero-visual">
      <div class="hero-card">
        <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&auto=format&fit=crop&q=80" alt="Featured smartphone">
        <div class="hero-card-meta">
          <h4>Nova X 5G Pro</h4>
          <span>$899</span>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 4 — SHOP BY CATEGORIES
       ============================================================ -->
  <section id="categories" class="container">
    <div class="section-head">
      <h2>Shop by Category</h2>
      <p>Find exactly what you need across our curated device collections</p>
    </div>

    <div class="categories-grid">
      <div class="cat-card"><div class="cat-icon"><i class="fas fa-mobile-screen-button"></i></div><h4>Smartphones</h4><small>320+ products</small></div>
      <div class="cat-card"><div class="cat-icon"><i class="fas fa-laptop"></i></div><h4>Laptops</h4><small>180+ products</small></div>
      <div class="cat-card"><div class="cat-icon"><i class="fas fa-tablet-screen-button"></i></div><h4>Tablets</h4><small>95+ products</small></div>
      <div class="cat-card"><div class="cat-icon"><i class="fas fa-headphones"></i></div><h4>Headphones</h4><small>210+ products</small></div>
      <div class="cat-card"><div class="cat-icon"><i class="fas fa-clock"></i></div><h4>Smartwatches</h4><small>140+ products</small></div>
      <div class="cat-card"><div class="cat-icon"><i class="fas fa-gamepad"></i></div><h4>Gaming</h4><small>260+ products</small></div>
      <div class="cat-card"><div class="cat-icon"><i class="fas fa-plug"></i></div><h4>Accessories</h4><small>500+ products</small></div>
      <div class="cat-card"><div class="cat-icon"><i class="fas fa-camera"></i></div><h4>Cameras</h4><small>75+ products</small></div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 5 — BEST SELLERS
       ============================================================ -->
  <section id="best" class="container">
    <div class="section-head">
      <h2>Best Sellers</h2>
      <p>Our most popular devices, loved by thousands of customers</p>
    </div>

    <div class="products-grid">
      <!-- Product 1 -->
      <article class="product-card">
        <div class="product-img">
          <span class="tag tag-sale">-15%</span>
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?w=500&auto=format&fit=crop&q=80" alt="Nova Pro phone">
        </div>
        <h3>Nova Pro 5G</h3>
        <div class="product-cat">Smartphone</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.8)</span></div>
        <div class="price-row"><span class="price-now">$799</span><span class="price-old">$939</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <!-- Product 2 -->
      <article class="product-card">
        <div class="product-img">
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500&auto=format&fit=crop&q=80" alt="AeroBook laptop">
        </div>
        <h3>AeroBook Pro 14</h3>
        <div class="product-cat">Laptop</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.9)</span></div>
        <div class="price-row"><span class="price-now">$1,299</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <!-- Product 3 -->
      <article class="product-card">
        <div class="product-img">
          <span class="tag tag-sale">-20%</span>
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&auto=format&fit=crop&q=80" alt="EchoPods headphones">
        </div>
        <h3>EchoPods Max</h3>
        <div class="product-cat">Headphones</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.7)</span></div>
        <div class="price-row"><span class="price-now">$359</span><span class="price-old">$449</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <!-- Product 4 -->
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
    </div>
  </section>

  <!-- ============================================================
       SECTION 6 — SPECIAL OFFERS & FLASH DEALS
       ============================================================ -->
  <section id="deals" class="container">
    <div class="section-head">
      <h2>Flash Deals</h2>
      <p>Limited-time offers — grab them before they're gone</p>
    </div>

    <div class="deals-banner">
      <h3><i class="fas fa-bolt"></i> Today's Special Offers</h3>
      <div class="countdown">
        <div class="countdown-box"><b>12</b><small>Hours</small></div>
        <div class="countdown-box"><b>45</b><small>Minutes</small></div>
        <div class="countdown-box"><b>30</b><small>Seconds</small></div>
      </div>
    </div>

    <div class="products-grid">
      <!-- Deal 1 -->
      <article class="product-card">
        <div class="product-img">
          <span class="tag tag-sale">-30%</span>
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1567581935884-3349723552ca?w=500&auto=format&fit=crop&q=80" alt="Tablet deal">
        </div>
        <h3>Tab Air 11"</h3>
        <div class="product-cat">Tablet</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i> <span>(4.4)</span></div>
        <div class="price-row"><span class="price-now">$419</span><span class="price-old">$599</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <!-- Deal 2 -->
      <article class="product-card">
        <div class="product-img">
          <span class="tag tag-sale">-25%</span>
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1606220945770-b5b6c2c55bf1?w=500&auto=format&fit=crop&q=80" alt="Smart speaker deal">
        </div>
        <h3>SoundSphere Mini</h3>
        <div class="product-cat">Smart Speaker</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.6)</span></div>
        <div class="price-row"><span class="price-now">$149</span><span class="price-old">$199</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <!-- Deal 3 -->
      <article class="product-card">
        <div class="product-img">
          <span class="tag tag-sale">-18%</span>
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&auto=format&fit=crop&q=80" alt="Watch deal">
        </div>
        <h3>Chrono Smart</h3>
        <div class="product-cat">Smartwatch</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i> <span>(4.3)</span></div>
        <div class="price-row"><span class="price-now">$229</span><span class="price-old">$279</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <!-- Deal 4 -->
      <article class="product-card">
        <div class="product-img">
          <span class="tag tag-sale">-35%</span>
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?w=500&auto=format&fit=crop&q=80" alt="Earbuds deal">
        </div>
        <h3>AirBuds Lite</h3>
        <div class="product-cat">Earbuds</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.5)</span></div>
        <div class="price-row"><span class="price-now">$84</span><span class="price-old">$129</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>
    </div>
  </section>

  <!-- ============================================================
       SECTION 7 — NEW ARRIVALS
       ============================================================ -->
  <section id="new" class="container">
    <div class="section-head">
      <h2>New Arrivals</h2>
      <p>Fresh devices, just landed in ElectroHub</p>
    </div>

    <div class="products-grid">
      <article class="product-card">
        <div class="product-img">
          <span class="tag tag-new">NEW</span>
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1616348436168-de43ad0db179?w=500&auto=format&fit=crop&q=80" alt="New phone">
        </div>
        <h3>Nova Fold 2</h3>
        <div class="product-cat">Foldable Phone</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(5.0)</span></div>
        <div class="price-row"><span class="price-now">$1,699</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <article class="product-card">
        <div class="product-img">
          <span class="tag tag-new">NEW</span>
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=500&auto=format&fit=crop&q=80" alt="New keyboard">
        </div>
        <h3>Mech Pro Keyboard</h3>
        <div class="product-cat">Accessory</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.8)</span></div>
        <div class="price-row"><span class="price-now">$149</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <article class="product-card">
        <div class="product-img">
          <span class="tag tag-new">NEW</span>
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1585790050230-5dd28404ccb9?w=500&auto=format&fit=crop&q=80" alt="New camera">
        </div>
        <h3>SnapPro 4K Cam</h3>
        <div class="product-cat">Camera</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i> <span>(4.7)</span></div>
        <div class="price-row"><span class="price-now">$529</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>

      <article class="product-card">
        <div class="product-img">
          <span class="tag tag-new">NEW</span>
          <button class="wishlist"><i class="far fa-heart"></i></button>
          <img src="https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=500&auto=format&fit=crop&q=80" alt="New monitor">
        </div>
        <h3>VisionCurve 32"</h3>
        <div class="product-cat">Monitor</div>
        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(4.9)</span></div>
        <div class="price-row"><span class="price-now">$449</span></div>
        <button class="add-cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
      </article>
    </div>
  </section>

  <!-- ============================================================
       SECTION 8 — FEATURED BRANDS
       ============================================================ -->
  <section id="brands" class="container">
    <div class="section-head">
      <h2>Featured Brands</h2>
      <p>We carry only authentic products from the world's leading tech brands</p>
    </div>

    <div class="brands-grid">
      <div class="brand-card"><span>APPLE</span></div>
      <div class="brand-card"><span>SAMSUNG</span></div>
      <div class="brand-card"><span>LENOVO</span></div>
      <div class="brand-card"><span>DELL</span></div>
      <div class="brand-card"><span>HP</span></div>
      <div class="brand-card"><span>XIAOMI</span></div>
      <div class="brand-card"><span>SONY</span></div>
      <div class="brand-card"><span>ASUS</span></div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 9 — WHY CHOOSE ELECTROHUB
       ============================================================ -->
  <section id="why" class="container">
    <div class="section-head">
      <h2>Why Choose ElectroHub?</h2>
      <p>Trusted by thousands of customers for a reason</p>
    </div>

    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-certificate"></i></div>
        <h4>100% Genuine</h4>
        <p>All products are sourced directly from authorized distributors with official warranties.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-lock"></i></div>
        <h4>Secure Payments</h4>
        <p>Encrypted checkout with support for cards, wallets, and cash on delivery.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-truck-fast"></i></div>
        <h4>Fast Delivery</h4>
        <p>Same-day dispatch and reliable courier partners to get your device quickly.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-headset"></i></div>
        <h4>24/7 Support</h4>
        <p>Our support team is always ready to help you before and after your purchase.</p>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 10 — CUSTOMER REVIEWS
       ============================================================ -->
  <section id="reviews" class="container">
    <div class="section-head">
      <h2>What Our Customers Say</h2>
      <p>Real feedback from verified purchases</p>
    </div>

    <div class="reviews-grid">
      <div class="review-card">
        <div class="review-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
        <p class="review-text">"Ordered the Nova Pro 5G and it arrived in just two days. Genuine product, sealed box, and the price was better than anywhere else."</p>
        <div class="review-user">
          <img class="review-avatar" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&auto=format&fit=crop&q=80" alt="Customer">
          <div><b>Ahmed R.</b><small><i class="fas fa-circle-check"></i> Verified Purchase</small></div>
        </div>
      </div>

      <div class="review-card">
        <div class="review-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-stroke"></i></div>
        <p class="review-text">"ElectroHub's customer service is excellent. They helped me pick the right laptop for my work and even matched a competitor's price."</p>
        <div class="review-user">
          <img class="review-avatar" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&auto=format&fit=crop&q=80" alt="Customer">
          <div><b>Sarah M.</b><small><i class="fas fa-circle-check"></i> Verified Purchase</small></div>
        </div>
      </div>

      <div class="review-card">
        <div class="review-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
        <p class="review-text">"The headphones I bought sound amazing and the packaging was premium. Definitely my go-to store for electronics now."</p>
        <div class="review-user">
          <img class="review-avatar" src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?w=100&auto=format&fit=crop&q=80" alt="Customer">
          <div><b>Omar K.</b><small><i class="fas fa-circle-check"></i> Verified Purchase</small></div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 11 — NEWSLETTER SUBSCRIPTION
       ============================================================ -->
  <section class="container">
    <div class="newsletter">
      <h2>Stay in the Loop</h2>
      <p>Subscribe to get early access to new products, exclusive discounts, and tech news — straight to your inbox.</p>
      <form class="newsletter-form" onsubmit="return false;">
        <input type="email" placeholder="Enter your email address" required>
        <button type="submit" class="btn btn-amber"><i class="fas fa-paper-plane"></i> Subscribe</button>
      </form>
    </div>
  </section>

  <!-- ============================================================
       SECTION 12 — FOOTER
       ============================================================ -->
  <footer id="footer" class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <a href="#" class="logo">
            <span class="logo-mark"><i class="fas fa-bolt"></i></span>
            <span class="logo-text">Electro<b>Hub</b></span>
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
