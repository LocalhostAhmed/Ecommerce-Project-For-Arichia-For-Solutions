import * as THREE from 'three';

/* =========================================================
   Devices Store — Home page interactions
   ========================================================= */

/* ---------- Data ---------- */
const CATEGORIES = [{
        id: 'smartphones',
        name: 'Smartphones',
        icon: '📱',
        desc: 'Flagships & foldables',
        count: 42
    },
    {
        id: 'laptops',
        name: 'Laptops',
        icon: '💻',
        desc: 'Pro workstations',
        count: 28
    },
    {
        id: 'tablets',
        name: 'Tablets',
        icon: '📲',
        desc: 'Create anywhere',
        count: 19
    },
    {
        id: 'smartwatches',
        name: 'Smartwatches',
        icon: '⌚',
        desc: 'Health & style',
        count: 24
    },
    {
        id: 'gaming',
        name: 'Gaming',
        icon: '🎮',
        desc: 'Consoles & gear',
        count: 31
    },
    {
        id: 'accessories',
        name: 'Accessories',
        icon: '🎧',
        desc: 'Audio & power',
        count: 87
    },
];

const PRODUCTS = [{
        id: 'p01',
        name: 'Aurora Pro Max 512GB',
        cat: 'smartphones',
        price: 1199,
        old: 1299,
        rating: 4.8,
        reviews: 2413,
        badge: 'new',
        img: 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?auto=format&fit=crop&w=800&q=80',
        best: true,
        fresh: true
    },
    {
        id: 'p02',
        name: 'Nimbus Air 14" Ultrabook',
        cat: 'laptops',
        price: 1499,
        old: 1699,
        rating: 4.9,
        reviews: 1187,
        badge: 'sale',
        img: 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=800&q=80',
        best: true,
        fresh: false
    },
    {
        id: 'p03',
        name: 'Studio Buds Pro ANC',
        cat: 'accessories',
        price: 249,
        old: 299,
        rating: 4.7,
        reviews: 3204,
        badge: 'hot',
        img: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80',
        best: true,
        fresh: true
    },
    {
        id: 'p04',
        name: 'Pulse Watch Series 8',
        cat: 'smartwatches',
        price: 399,
        old: 449,
        rating: 4.8,
        reviews: 892,
        badge: '',
        img: 'https://images.unsplash.com/photo-1546868871-7041f2a55e12?auto=format&fit=crop&w=800&q=80',
        best: true,
        fresh: false
    },
    {
        id: 'p05',
        name: 'Slate Pad 11" WiFi',
        cat: 'tablets',
        price: 649,
        old: 0,
        rating: 4.6,
        reviews: 512,
        badge: 'new',
        img: 'https://images.unsplash.com/photo-1561154464-82e9adf32764?auto=format&fit=crop&w=800&q=80',
        best: false,
        fresh: true
    },
    {
        id: 'p06',
        name: 'Vertex Console X',
        cat: 'gaming',
        price: 499,
        old: 549,
        rating: 4.9,
        reviews: 4102,
        badge: 'hot',
        img: 'https://images.unsplash.com/photo-1606144042614-b2417e99c4e3?auto=format&fit=crop&w=800&q=80',
        best: true,
        fresh: true
    },
    {
        id: 'p07',
        name: 'Aurora Lite 256GB',
        cat: 'smartphones',
        price: 799,
        old: 899,
        rating: 4.6,
        reviews: 1508,
        badge: 'sale',
        img: 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=800&q=80',
        best: false,
        fresh: false
    },
    {
        id: 'p08',
        name: 'AeroBook 16" Pro',
        cat: 'laptops',
        price: 2199,
        old: 0,
        rating: 4.9,
        reviews: 405,
        badge: 'new',
        img: 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?auto=format&fit=crop&w=800&q=80',
        best: false,
        fresh: true
    },
    {
        id: 'p09',
        name: 'Over-Ear Studio H1',
        cat: 'accessories',
        price: 329,
        old: 379,
        rating: 4.8,
        reviews: 2210,
        badge: '',
        img: 'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=800&q=80',
        best: true,
        fresh: false
    },
    {
        id: 'p10',
        name: 'Nova Pad Air 13"',
        cat: 'tablets',
        price: 899,
        old: 999,
        rating: 4.7,
        reviews: 623,
        badge: 'sale',
        img: 'https://images.unsplash.com/photo-1585790050230-5dd28404ccb9?auto=format&fit=crop&w=800&q=80',
        best: false,
        fresh: true
    },
    {
        id: 'p11',
        name: 'Chrono Fit Active',
        cat: 'smartwatches',
        price: 229,
        old: 279,
        rating: 4.5,
        reviews: 1204,
        badge: '',
        img: 'https://images.unsplash.com/photo-1579586337278-3befd40fd17a?auto=format&fit=crop&w=800&q=80',
        best: false,
        fresh: true
    },
    {
        id: 'p12',
        name: 'Arcade Pad Elite',
        cat: 'gaming',
        price: 129,
        old: 159,
        rating: 4.7,
        reviews: 890,
        badge: 'sale',
        img: 'https://images.unsplash.com/photo-1580327344181-c1163234e5a0?auto=format&fit=crop&w=800&q=80',
        best: false,
        fresh: false
    },
];

const BRANDS = ['NOVA', 'Aurora', 'Vertex', 'Nimbus', 'Pulse', 'Chrono', 'Slate', 'Arcade', 'Lumen', 'Kairo'];

/* ---------- Utilities ---------- */
const $ = (sel, root = document) => root.querySelector(sel);
const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));
const money = n => `$${n.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
const debounce = (fn, wait = 150) => {
    let t;
    return (...a) => {
        clearTimeout(t);
        t = setTimeout(() => fn(...a), wait);
    };
};

const prefersReducedMotion = () =>
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/* ---------- State ---------- */
const state = {
    cart: new Map(), // id -> qty
    wishlist: new Set(), // id
    filter: 'all',
};

/* =========================================================
   Toast
   ========================================================= */
const toastEl = $('#toast');
let toastTimer;

function toast(msg, icon = '✓') {
    toastEl.innerHTML = `<span class="dot-check">${icon}</span><span>${msg}</span>`;
    toastEl.hidden = false;
    requestAnimationFrame(() => toastEl.classList.add('is-visible'));
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => {
        toastEl.classList.remove('is-visible');
        setTimeout(() => {
            toastEl.hidden = true;
        }, 260);
    }, 2200);
}

/* =========================================================
   Header behaviors
   ========================================================= */
const header = $('#siteHeader');
const onScroll = () => header.classList.toggle('is-scrolled', window.scrollY > 8);
window.addEventListener('scroll', onScroll, {
    passive: true
});
onScroll();

// Announcement close
$('#announcementClose') ? .addEventListener('click', () => {
    $('.announcement').classList.add('is-hidden');
});

// Mobile menu
const menuToggle = $('#menuToggle');
const primaryNav = $('#primaryNav');
menuToggle ? .addEventListener('click', () => {
    const open = primaryNav.classList.toggle('is-open');
    menuToggle.setAttribute('aria-expanded', String(open));
});

// Mega menu
const catsBtn = $('#catsBtn');
const megaMenu = $('#megaMenu');
if (catsBtn && megaMenu) {
    const openMega = () => {
        megaMenu.hidden = false;
        catsBtn.setAttribute('aria-expanded', 'true');
    };
    const closeMega = () => {
        megaMenu.hidden = true;
        catsBtn.setAttribute('aria-expanded', 'false');
    };
    catsBtn.addEventListener('click', e => {
        e.stopPropagation();
        megaMenu.hidden ? openMega() : closeMega();
    });
    catsBtn.addEventListener('mouseenter', openMega);
    $('.has-mega').addEventListener('mouseleave', closeMega);
    document.addEventListener('click', e => {
        if (!e.target.closest('.has-mega')) closeMega();
    });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeMega();
    });
}

// Search
const searchToggle = $('#searchToggle');
const searchPanel = $('#searchPanel');
const searchInput = $('#searchInput');
const searchResults = $('#searchResults');

searchToggle ? .addEventListener('click', () => {
    const willOpen = searchPanel.hidden;
    searchPanel.hidden = !willOpen;
    searchToggle.setAttribute('aria-expanded', String(willOpen));
    if (willOpen) setTimeout(() => searchInput.focus(), 30);
});

$('#searchClose') ? .addEventListener('click', () => {
    searchPanel.hidden = true;
    searchToggle.setAttribute('aria-expanded', 'false');
});

const renderSearchResults = (q) => {
    const term = q.trim().toLowerCase();
    if (!term) {
        searchResults.innerHTML = '';
        return;
    }
    const matches = PRODUCTS.filter(p =>
        p.name.toLowerCase().includes(term) || p.cat.toLowerCase().includes(term)
    ).slice(0, 6);

    if (!matches.length) {
        searchResults.innerHTML = `<p class="empty">No products match "${q}".</p>`;
        return;
    }
    searchResults.innerHTML = matches.map(p => `
    <button class="sr-item" data-goto="${p.id}" role="option">
      <span>${p.name}<br><small style="color:var(--text-3)">${p.cat}</small></span>
      <span class="sr-price">${money(p.price)}</span>
    </button>
  `).join('');
};

searchInput ? .addEventListener('input', debounce(e => renderSearchResults(e.target.value), 120));
searchResults ? .addEventListener('click', e => {
    const btn = e.target.closest('[data-goto]');
    if (!btn) return;
    const id = btn.dataset.goto;
    const card = document.querySelector(`[data-product-id="${id}"]`);
    if (card) {
        card.scrollIntoView({
            behavior: prefersReducedMotion() ? 'auto' : 'smooth',
            block: 'center'
        });
        card.animate(
            [{
                boxShadow: '0 0 0 0 rgba(245,158,11,.7)'
            }, {
                boxShadow: '0 0 0 16px rgba(245,158,11,0)'
            }], {
                duration: 900,
                easing: 'ease-out'
            }
        );
    }
    searchPanel.hidden = true;
    searchToggle.setAttribute('aria-expanded', 'false');
});

/* =========================================================
   Categories
   ========================================================= */
function renderCategories() {
    const grid = $('#categoryGrid');
    grid.innerHTML = CATEGORIES.map(c => `
    <a class="category-card" href="#products" data-cat="${c.id}" aria-label="Shop ${c.name}">
      <span class="cat-count">${c.count} items</span>
      <div class="cat-icon" aria-hidden="true">${c.icon}</div>
      <h3>${c.name}</h3>
      <p>${c.desc}</p>
      <span class="cat-more">Browse →</span>
    </a>
  `).join('');

    grid.addEventListener('click', e => {
        const card = e.target.closest('[data-cat]');
        if (card) setFilter(card.dataset.cat);
    });
}

/* =========================================================
   Product rendering
   ========================================================= */
function productCardHTML(p) {
    const discount = p.old ? Math.round((1 - p.price / p.old) * 100) : 0;
    const inWish = state.wishlist.has(p.id);
    const badges = [];
    if (p.badge === 'new') badges.push('<span class="pc-badge new">New</span>');
    if (p.badge === 'hot') badges.push('<span class="pc-badge hot">Hot</span>');
    if (p.badge === 'sale' && discount) badges.push(`<span class="pc-badge sale">-${discount}%</span>`);

    return `
    <article class="product-card" data-product-id="${p.id}" data-cat="${p.cat}" data-tilt>
      <div class="pc-media">
        <div class="pc-badges">${badges.join('')}</div>
        <button class="pc-wish ${inWish ? 'is-active' : ''}" data-wish="${p.id}" aria-label="${inWish ? 'Remove from wishlist' : 'Add to wishlist'}" aria-pressed="${inWish}">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20.8 5.6a5.2 5.2 0 0 0-7.4 0L12 7l-1.4-1.4a5.2 5.2 0 0 0-7.4 7.4l8.8 8.8 8.8-8.8a5.2 5.2 0 0 0 0-7.4Z"/>
          </svg>
        </button>
        <img src="${p.img}" alt="${p.name}" loading="lazy" />
      </div>
      <div class="pc-body">
        <span class="pc-cat">${p.cat}</span>
        <h3 class="pc-name">${p.name}</h3>
        <div class="pc-rating">
          <span class="stars" aria-hidden="true">★★★★★</span>
          <span>${p.rating.toFixed(1)} · ${p.reviews.toLocaleString()} reviews</span>
        </div>
        <div class="pc-foot">
          <div class="pc-price">
            <strong>${money(p.price)}</strong>
            ${p.old ? `<s>${money(p.old)}</s>` : ''}
          </div>
          <button class="pc-add" data-add="${p.id}">
            Add
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
          </button>
        </div>
      </div>
    </article>
  `;
}

function renderFeatured() {
    const grid = $('#featuredGrid');
    const items = state.filter === 'all' ?
        PRODUCTS :
        PRODUCTS.filter(p => p.cat === state.filter);
    grid.innerHTML = items.map(productCardHTML).join('');
    attachCardEvents(grid);
    attachTilt(grid);
}

function renderBestSellers() {
    const grid = $('#bestGrid');
    grid.innerHTML = PRODUCTS.filter(p => p.best).slice(0, 4).map(productCardHTML).join('');
    attachCardEvents(grid);
    attachTilt(grid);
}

function renderNewArrivals() {
    const grid = $('#newGrid');
    grid.innerHTML = PRODUCTS.filter(p => p.fresh).slice(0, 4).map(productCardHTML).join('');
    attachCardEvents(grid);
    attachTilt(grid);
}

/* =========================================================
   Card events (add to cart, wishlist)
   ========================================================= */
function attachCardEvents(root) {
    root.addEventListener('click', e => {
        const addBtn = e.target.closest('[data-add]');
        if (addBtn) {
            const id = addBtn.dataset.add;
            addToCart(id);
            addBtn.classList.add('is-added');
            addBtn.innerHTML = 'Added ✓';
            setTimeout(() => {
                addBtn.classList.remove('is-added');
                addBtn.innerHTML = `Add <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>`;
            }, 1400);
            return;
        }

        const wishBtn = e.target.closest('[data-wish]');
        if (wishBtn) {
            const id = wishBtn.dataset.wish;
            toggleWishlist(id, wishBtn);
        }
    });
}

/* =========================================================
   Tilt effect on product cards
   ========================================================= */
function attachTilt(root) {
    if (prefersReducedMotion()) return;
    if (window.matchMedia('(hover: none)').matches) return;

    $$('[data-tilt]', root).forEach(card => {
        if (card._tiltBound) return;
        card._tiltBound = true;

        const strength = 8;
        card.addEventListener('mousemove', e => {
            const r = card.getBoundingClientRect();
            const x = (e.clientX - r.left) / r.width - 0.5;
            const y = (e.clientY - r.top) / r.height - 0.5;
            card.style.transform =
                `perspective(1000px) rotateY(${x * strength}deg) rotateX(${-y * strength}deg) translateY(-4px)`;
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = '';
        });
    });
}

/* =========================================================
   Filter chips
   ========================================================= */
function setFilter(cat) {
    state.filter = cat;
    $$('.chip').forEach(c => {
        const active = c.dataset.filter === cat;
        c.classList.toggle('is-active', active);
        c.setAttribute('aria-selected', String(active));
    });
    renderFeatured();
}
$$('.chip').forEach(chip => chip.addEventListener('click', () => setFilter(chip.dataset.filter)));

/* =========================================================
   Wishlist
   ========================================================= */
function toggleWishlist(id, btn) {
    if (state.wishlist.has(id)) {
        state.wishlist.delete(id);
        btn.classList.remove('is-active');
        btn.setAttribute('aria-pressed', 'false');
        toast('Removed from wishlist');
    } else {
        state.wishlist.add(id);
        btn.classList.add('is-active');
        btn.setAttribute('aria-pressed', 'true');
        toast('Added to wishlist');
    }
    updateWishlistBadge();
}

function updateWishlistBadge() {
    const badge = $('#wishlistBadge');
    const n = state.wishlist.size;
    badge.textContent = n;
    badge.hidden = n === 0;
}

/* =========================================================
   Cart
   ========================================================= */
function addToCart(id, qty = 1) {
    const current = state.cart.get(id) || 0;
    state.cart.set(id, current + qty);
    updateCartUI();
    const p = PRODUCTS.find(x => x.id === id);
    if (p) toast(`Added "${p.name}" to cart`);
}

function setQty(id, qty) {
    if (qty <= 0) state.cart.delete(id);
    else state.cart.set(id, qty);
    updateCartUI();
}

function removeFromCart(id) {
    state.cart.delete(id);
    updateCartUI();
    toast('Item removed');
}

function cartTotal() {
    let total = 0;
    for (const [id, qty] of state.cart) {
        const p = PRODUCTS.find(x => x.id === id);
        if (p) total += p.price * qty;
    }
    return total;
}

function updateCartUI() {
    const items = $('#cartItems');
    const empty = $('#cartEmpty');
    const badge = $('#cartBadge');
    const totalEl = $('#cartTotal');
    const checkout = $('#checkoutBtn');

    let count = 0;
    for (const q of state.cart.values()) count += q;
    badge.textContent = count;
    badge.hidden = count === 0;

    if (state.cart.size === 0) {
        items.innerHTML = '';
        empty.hidden = false;
        checkout.disabled = true;
    } else {
        empty.hidden = true;
        items.innerHTML = Array.from(state.cart.entries()).map(([id, qty]) => {
            const p = PRODUCTS.find(x => x.id === id);
            if (!p) return '';
            return `
        <li class="cart-item" data-line="${id}">
          <img src="${p.img}" alt="" />
          <div>
            <p class="ci-name">${p.name}</p>
            <p class="ci-meta">${p.cat}</p>
            <div class="ci-qty">
              <button data-dec="${id}" aria-label="Decrease">−</button>
              <span>${qty}</span>
              <button data-inc="${id}" aria-label="Increase">+</button>
            </div>
            <button class="ci-remove" data-remove="${id}">Remove</button>
          </div>
          <div class="ci-price">${money(p.price * qty)}</div>
        </li>
      `;
        }).join('');
        checkout.disabled = false;
    }
    totalEl.textContent = money(cartTotal());
}

// Cart event delegation
$('#cartItems') ? .addEventListener('click', e => {
    const inc = e.target.closest('[data-inc]');
    const dec = e.target.closest('[data-dec]');
    const rem = e.target.closest('[data-remove]');
    if (inc) setQty(inc.dataset.inc, (state.cart.get(inc.dataset.inc) || 0) + 1);
    if (dec) setQty(dec.dataset.dec, (state.cart.get(dec.dataset.dec) || 0) - 1);
    if (rem) removeFromCart(rem.dataset.remove);
});

/* Cart drawer open/close */
const cartDrawer = $('#cartDrawer');
const overlay = $('#overlay');

function openCart() {
    cartDrawer.classList.add('is-open');
    cartDrawer.setAttribute('aria-hidden', 'false');
    overlay.hidden = false;
    requestAnimationFrame(() => overlay.classList.add('is-open'));
    document.body.style.overflow = 'hidden';
}

function closeCart() {
    cartDrawer.classList.remove('is-open');
    cartDrawer.setAttribute('aria-hidden', 'true');
    overlay.classList.remove('is-open');
    setTimeout(() => {
        overlay.hidden = true;
    }, 260);
    document.body.style.overflow = '';
}

$('#cartBtn') ? .addEventListener('click', openCart);
$('#cartClose') ? .addEventListener('click', closeCart);
$('#cartBrowse') ? .addEventListener('click', () => {
    closeCart();
    document.getElementById('products') ? .scrollIntoView({
        behavior: prefersReducedMotion() ? 'auto' : 'smooth'
    });
});
overlay ? .addEventListener('click', closeCart);
document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && cartDrawer.classList.contains('is-open')) closeCart();
});

$('#checkoutBtn') ? .addEventListener('click', () => {
    toast('Checkout is a demo — no backend wired up', 'ⓘ');
});

/* Wishlist header button opens cart-less feedback */
$('#wishlistBtn') ? .addEventListener('click', () => {
    toast(`Wishlist: ${state.wishlist.size} item${state.wishlist.size === 1 ? '' : 's'}`, '♥');
});

/* Account button */
$('#accountBtn') ? .addEventListener('click', () => toast('Account area is a demo', 'ⓘ'));

/* =========================================================
   Countdown
   ========================================================= */
function initCountdown() {
    const els = {
        days: $('[data-cd="days"]'),
        hours: $('[data-cd="hours"]'),
        minutes: $('[data-cd="minutes"]'),
        seconds: $('[data-cd="seconds"]'),
    };
    // Sale ends 3 days from first visit (persisted per session)
    const KEY = 'ds_sale_end';
    let end = Number(sessionStorage.getItem(KEY));
    if (!end || end < Date.now()) {
        end = Date.now() + 3 * 24 * 60 * 60 * 1000 + 45 * 60 * 1000;
        sessionStorage.setItem(KEY, String(end));
    }

    const pad = n => String(n).padStart(2, '0');
    const tick = () => {
        const diff = Math.max(0, end - Date.now());
        const s = Math.floor(diff / 1000);
        els.days.textContent = pad(Math.floor(s / 86400));
        els.hours.textContent = pad(Math.floor((s % 86400) / 3600));
        els.minutes.textContent = pad(Math.floor((s % 3600) / 60));
        els.seconds.textContent = pad(s % 60);
    };
    tick();
    setInterval(tick, 1000);
}

/* =========================================================
   Brands carousel
   ========================================================= */
function initBrands() {
    const track = $('#brandTrack');
    // Duplicate list for seamless loop feel
    const list = [...BRANDS, ...BRANDS];
    track.innerHTML = list.map(b => `
    <li class="brand-item"><span>${b.slice(0, 2)}<em>${b.slice(2)}</em></span></li>
  `).join('');

    let offset = 0;
    const step = () => {
        const item = track.querySelector('.brand-item');
        if (!item) return 200;
        const style = getComputedStyle(track);
        const gap = parseFloat(style.gap) || 16;
        return item.getBoundingClientRect().width + gap;
    };

    const move = dir => {
        const items = track.children.length;
        const half = items / 2;
        offset += dir;
        if (offset < 0) offset = half - 1;
        if (offset >= half) offset = 0;
        track.style.transform = `translateX(${-offset * step()}px)`;
    };

    $('#brandPrev') ? .addEventListener('click', () => move(-1));
    $('#brandNext') ? .addEventListener('click', () => move(1));

    // Auto-advance
    let auto = setInterval(() => move(1), 3800);
    track.parentElement.addEventListener('mouseenter', () => clearInterval(auto));
    track.parentElement.addEventListener('mouseleave', () => {
        auto = setInterval(() => move(1), 3800);
    });

    // Keyboard
    track.parentElement.setAttribute('tabindex', '0');
    track.parentElement.addEventListener('keydown', e => {
        if (e.key === 'ArrowLeft') move(-1);
        if (e.key === 'ArrowRight') move(1);
    });
}

/* =========================================================
   Newsletter
   ========================================================= */
function initNewsletter() {
    const form = $('#newsletterForm');
    const input = $('#emailInput');
    const msg = $('#formMsg');
    const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

    form.addEventListener('submit', e => {
        e.preventDefault();
        const value = input.value.trim();
        msg.classList.remove('success', 'error');
        input.classList.remove('is-invalid');

        if (!value) {
            msg.textContent = 'Please enter your email.';
            msg.classList.add('error');
            input.classList.add('is-invalid');
            input.focus();
            return;
        }
        if (!emailRe.test(value)) {
            msg.textContent = 'That email looks invalid.';
            msg.classList.add('error');
            input.classList.add('is-invalid');
            input.focus();
            return;
        }
        msg.textContent = '✓ Subscribed! Check your inbox for 10% off.';
        msg.classList.add('success');
        toast('Welcome to Devices Store 🎉');
        form.reset();
    });

    input.addEventListener('input', () => {
        input.classList.remove('is-invalid');
        if (msg.classList.contains('error')) {
            msg.textContent = '';
            msg.classList.remove('error');
        }
    });
}

/* =========================================================
   THREE.JS — Hero 3D scene
   ========================================================= */
function initHero3D() {
    const canvas = $('#heroCanvas');
    const fallback = $('#stageFallback');
    if (!canvas) return;

    // Capability check
    const gl = (() => {
        try {
            const c = document.createElement('canvas');
            return !!(window.WebGLRenderingContext && (c.getContext('webgl') || c.getContext('experimental-webgl')));
        } catch {
            return false;
        }
    })();

    if (!gl || prefersReducedMotion()) {
        canvas.style.display = 'none';
        fallback.hidden = false;
        return;
    }

    const stage = $('#heroStage');
    const scene = new THREE.Scene();
    scene.background = null;

    const camera = new THREE.PerspectiveCamera(38, 1, 0.1, 100);
    camera.position.set(0, 0.2, 7.4);

    const renderer = new THREE.WebGLRenderer({
        canvas,
        antialias: true,
        alpha: true,
        powerPreference: 'high-performance',
    });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.05;

    /* Lights */
    const key = new THREE.DirectionalLight(0xffffff, 2.4);
    key.position.set(4, 6, 5);
    scene.add(key);

    const rim = new THREE.DirectionalLight(0xF59E0B, 1.6);
    rim.position.set(-5, 2, -4);
    scene.add(rim);

    const fill = new THREE.HemisphereLight(0xF8FAFC, 0x0F172A, 1.1);
    scene.add(fill);

    const ambient = new THREE.AmbientLight(0xffffff, 0.35);
    scene.add(ambient);

    /* Group that we rotate on drag */
    const rig = new THREE.Group();
    scene.add(rig);

    /* ---- Build a "phone + headphone + laptop" composition ---- */

    // Materials
    const matBody = new THREE.MeshPhysicalMaterial({
        color: 0x0F172A,
        metalness: 0.75,
        roughness: 0.28,
        clearcoat: 0.6,
        clearcoatRoughness: 0.25,
    });
    const matScreen = new THREE.MeshPhysicalMaterial({
        color: 0x1E293B,
        metalness: 0.6,
        roughness: 0.12,
        clearcoat: 1,
        clearcoatRoughness: 0.08,
        emissive: 0x0a1424,
        emissiveIntensity: 0.4,
    });
    const matAccent = new THREE.MeshPhysicalMaterial({
        color: 0xF59E0B,
        metalness: 0.85,
        roughness: 0.2,
        clearcoat: 0.8,
    });
    const matChrome = new THREE.MeshPhysicalMaterial({
        color: 0xE2E8F0,
        metalness: 1,
        roughness: 0.15,
    });

    // --- Smartphone ---
    const phone = new THREE.Group();
    const phoneBody = new THREE.Mesh(new THREE.BoxGeometry(1.9, 3.9, 0.18), matBody);
    phoneBody.geometry.translate(0, 0, 0);
    phone.add(phoneBody);

    const phoneScreen = new THREE.Mesh(new THREE.BoxGeometry(1.74, 3.72, 0.02), matScreen);
    phoneScreen.position.z = 0.1;
    phone.add(phoneScreen);

    // Camera bump
    const bump = new THREE.Mesh(new THREE.BoxGeometry(0.55, 0.55, 0.06), matBody);
    bump.position.set(-0.55, 1.4, -0.12);
    phone.add(bump);

    const lens1 = new THREE.Mesh(new THREE.CylinderGeometry(0.11, 0.11, 0.06, 32), matChrome);
    lens1.rotation.x = Math.PI / 2;
    lens1.position.set(-0.7, 1.55, -0.16);
    phone.add(lens1);

    const lens2 = lens1.clone();
    lens2.position.set(-0.4, 1.55, -0.16);
    phone.add(lens2);

    const lens3 = lens1.clone();
    lens3.position.set(-0.7, 1.25, -0.16);
    phone.add(lens3);

    // Accent button
    const btn = new THREE.Mesh(new THREE.BoxGeometry(0.05, 0.5, 0.05), matAccent);
    btn.position.set(0.97, 0.6, 0);
    phone.add(btn);

    phone.position.set(0, 0.15, 0.35);
    phone.rotation.y = 0.35;
    rig.add(phone);

    // --- Headphone ring (torus) suggesting audio ---
    const ring = new THREE.Mesh(
        new THREE.TorusGeometry(1.55, 0.075, 24, 80),
        matAccent
    );
    ring.position.set(-0.6, -0.05, -1.1);
    ring.rotation.set(Math.PI / 2.4, -0.4, 0.6);
    rig.add(ring);

    // --- Watch face (torus knot-ish accent) ---
    const watch = new THREE.Mesh(
        new THREE.TorusGeometry(0.75, 0.11, 20, 64),
        matChrome
    );
    watch.position.set(1.7, -1.05, 0.9);
    watch.rotation.set(0.4, 0.6, 0.3);
    rig.add(watch);

    const watchFace = new THREE.Mesh(
        new THREE.CircleGeometry(0.68, 48),
        matScreen
    );
    watchFace.position.copy(watch.position);
    watchFace.rotation.copy(watch.rotation);
    watchFace.rotation.z += Math.PI / 2;
    rig.add(watchFace);

    // --- Floating accessory cubes ---
    const cubeGroup = new THREE.Group();
    rig.add(cubeGroup);
    for (let i = 0; i < 6; i++) {
        const size = 0.12 + Math.random() * 0.14;
        const cube = new THREE.Mesh(
            new THREE.BoxGeometry(size, size, size),
            i % 2 === 0 ? matAccent : matChrome
        );
        const angle = (i / 6) * Math.PI * 2;
        cube.position.set(Math.cos(angle) * 2.6, Math.sin(angle) * 1.9, -1.2 + Math.random() * 0.8);
        cube.userData.speed = 0.6 + Math.random() * 0.6;
        cube.userData.phase = Math.random() * Math.PI * 2;
        cubeGroup.add(cube);
    }

    /* Interaction: drag to rotate */
    let isDragging = false;
    let prevX = 0,
        prevY = 0;
    let targetRotY = 0.35,
        targetRotX = 0.05;
    let currentRotY = 0.35,
        currentRotX = 0.05;

    const pointerDown = e => {
        isDragging = true;
        prevX = e.clientX ? ? e.touches[0].clientX;
        prevY = e.clientY ? ? e.touches[0].clientY;
        canvas.style.cursor = 'grabbing';
    };
    const pointerMove = e => {
        if (!isDragging) return;
        const x = e.clientX ? ? e.touches[0].clientX;
        const y = e.clientY ? ? e.touches[0].clientY;
        const dx = x - prevX;
        const dy = y - prevY;
        prevX = x;
        prevY = y;
        targetRotY += dx * 0.008;
        targetRotX += dy * 0.006;
        targetRotX = Math.max(-0.6, Math.min(0.6, targetRotX));
    };
    const pointerUp = () => {
        isDragging = false;
        canvas.style.cursor = 'grab';
    };

    canvas.addEventListener('mousedown', pointerDown);
    window.addEventListener('mousemove', pointerMove);
    window.addEventListener('mouseup', pointerUp);
    canvas.addEventListener('touchstart', pointerDown, {
        passive: true
    });
    canvas.addEventListener('touchmove', pointerMove, {
        passive: true
    });
    canvas.addEventListener('touchend', pointerUp);

    /* Resize */
    const resize = () => {
        const rect = stage.getBoundingClientRect();
        const w = rect.width,
            h = rect.height;
        if (w === 0 || h === 0) return;
        renderer.setSize(w, h, false);
        camera.aspect = w / h;
        camera.updateProjectionMatrix();
    };
    const ro = new ResizeObserver(resize);
    ro.observe(stage);
    resize();

    /* Animate */
    const clock = new THREE.Clock();
    let running = true;

    const onVisibility = () => {
        running = !document.hidden;
        if (running) animate();
    };
    document.addEventListener('visibilitychange', onVisibility);

    const ambientTilt = {
        x: 0,
        y: 0
    };

    function animate() {
        if (!running) return;
        requestAnimationFrame(animate);

        const t = clock.getElapsedTime();

        // Smooth rotation toward target + subtle idle float
        currentRotY += (targetRotY - currentRotY) * 0.08;
        currentRotX += (targetRotX - currentRotX) * 0.08;

        rig.rotation.y = currentRotY + Math.sin(t * 0.4) * 0.05;
        rig.rotation.x = currentRotX + Math.cos(t * 0.5) * 0.03;

        phone.position.y = 0.15 + Math.sin(t * 0.9) * 0.06;
        phone.rotation.y = 0.35 + Math.sin(t * 0.6) * 0.05;

        ring.rotation.z += 0.002;
        watch.rotation.z += 0.004;
        watchFace.rotation.z += 0.004;

        cubeGroup.children.forEach((c, i) => {
            const p = t * c.userData.speed + c.userData.phase;
            c.position.y += Math.sin(p) * 0.0015;
            c.rotation.x += 0.004;
            c.rotation.y += 0.006;
        });

        renderer.render(scene, camera);
    }
    animate();
}

/* =========================================================
   Boot
   ========================================================= */
function boot() {
    renderCategories();
    renderFeatured();
    renderBestSellers();
    renderNewArrivals();
    updateCartUI();
    updateWishlistBadge();
    initCountdown();
    initBrands();
    initNewsletter();
    initHero3D();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
} else {
    boot();
}
