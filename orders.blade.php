<style>
    :root {
        --red: #ff1a00;
        --red-dark: #cc1500;
        --red-soft: #fff0ef;
        --ink: #0f172a;
        --ink-mid: #475569;
        --ink-light: #94a3b8;
        --surface: #f8fafc;
        --card: #ffffff;
        --border: #e2e8f0;
    }

    /* ── KPI GRID ───────────────────────────────────── */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }

    @media (max-width: 991px) {
        .kpi-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .kpi-grid {
            gap: 10px;
        }
    }

    .kpi-tile {
        border-radius: 20px;
        padding: 20px 18px 16px;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .kpi-tile:hover {
        transform: translateY(-3px);
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.12);
    }

    .kpi-tile::before {
        content: '';
        position: absolute;
        top: -30px;
        right: -30px;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        opacity: 0.12;
        background: currentColor;
    }

    .kpi-tile .tile-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        margin-bottom: 12px;
    }

    .kpi-tile .tile-val {
        font-size: clamp(1.15rem, 2.5vw, 1.75rem);
        font-weight: 900;
        line-height: 1;
        letter-spacing: -0.5px;
        margin-bottom: 4px;
    }

    .kpi-tile .tile-lbl {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        opacity: 0.62;
    }

    .kpi-tile .tile-sub {
        font-size: 0.74rem;
        margin-top: 7px;
        opacity: 0.55;
        font-weight: 500;
    }

    .tile-dark {
        background: var(--ink);
        color: #fff;
        box-shadow: 0 6px 24px rgba(15, 23, 42, 0.22);
    }

    .tile-dark .tile-icon {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .tile-dark .tile-val,
    .tile-dark .tile-lbl,
    .tile-dark .tile-sub {
        color: #fff;
    }

    .tile-green {
        background: #f0fdf4;
        color: #14532d;
        border: 1.5px solid #bbf7d0;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.10);
    }

    .tile-green .tile-icon {
        background: #dcfce7;
        color: #16a34a;
    }

    .tile-green .tile-val,
    .tile-green .tile-lbl,
    .tile-green .tile-sub {
        color: #14532d;
    }

    .tile-indigo {
        background: #eef2ff;
        color: #312e81;
        border: 1.5px solid #c7d2fe;
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.10);
    }

    .tile-indigo .tile-icon {
        background: #e0e7ff;
        color: #4338ca;
    }

    .tile-indigo .tile-val,
    .tile-indigo .tile-lbl,
    .tile-indigo .tile-sub {
        color: #312e81;
    }

    .tile-orange {
        background: #fff7ed;
        color: #7c2d12;
        border: 1.5px solid #fed7aa;
        box-shadow: 0 4px 16px rgba(249, 115, 22, 0.10);
    }

    .tile-orange .tile-icon {
        background: #ffedd5;
        color: #ea580c;
    }

    .tile-orange .tile-val,
    .tile-orange .tile-lbl,
    .tile-orange .tile-sub {
        color: #7c2d12;
    }

    /* ── EARNINGS BANNER ────────────────────────────── */
    .earnings-banner {
        background: linear-gradient(135deg, var(--ink) 0%, #1e293b 100%);
        border-radius: 20px;
        padding: 22px 24px;
        color: white;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }

    .earnings-banner::after {
        content: '';
        position: absolute;
        right: -40px;
        top: -40px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(255, 26, 0, 0.12);
    }

    .earnings-banner::before {
        content: '';
        position: absolute;
        right: 60px;
        bottom: -60px;
        width: 130px;
        height: 130px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.04);
    }

    /* ── FILTER BAR ─────────────────────────────────── */
    .filter-bar {
        background: white;
        border-radius: 16px;
        padding: 16px 18px;
        border: 1px solid var(--border);
        margin-bottom: 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: flex-end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
        flex: 1;
        min-width: 130px;
    }

    .filter-group label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--ink-light);
    }

    .filter-select {
        appearance: none;
        background: var(--surface) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") no-repeat right 10px center;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 8px 32px 8px 10px;
        font-size: 0.84rem;
        font-weight: 600;
        color: var(--ink);
        cursor: pointer;
        transition: border-color 0.15s;
        width: 100%;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--red);
    }

    .filter-select.has-value {
        border-color: var(--red);
        background-color: var(--red-soft);
        color: var(--red);
    }

    .search-wrap {
        flex: 2;
        min-width: 180px;
    }

    .search-input {
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 8px 10px 8px 36px;
        font-size: 0.85rem;
        width: 100%;
        color: var(--ink);
        transition: border-color 0.15s;
        background: var(--surface);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--red);
    }

    .btn-clear {
        padding: 8px 14px;
        border-radius: 10px;
        background: #fee2e2;
        border: 1.5px solid #fecaca;
        color: #dc2626;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s;
        white-space: nowrap;
        align-self: flex-end;
    }

    .btn-clear:hover {
        background: #fecaca;
    }

    /* ── ANALYTICS ROW ──────────────────────────────── */
    .analytics-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 24px;
    }

    @media (max-width: 767px) {
        .analytics-row {
            grid-template-columns: 1fr;
        }
    }

    .chart-card {
        background: white;
        border-radius: 18px;
        padding: 20px;
        border: 1px solid var(--border);
    }

    .chart-card h6 {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        color: var(--ink-light);
        margin-bottom: 14px;
    }

    /* ── ORDER CARD ─────────────────────────────────── */
    .o-card {
        background: white;
        border-radius: 18px;
        border: 1px solid var(--border);
        margin-bottom: 12px;
        overflow: visible;
        transition: box-shadow 0.18s, transform 0.18s, border-color 0.18s;
        cursor: pointer;
        position: relative;
    }

    .o-card:hover {
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
        border-color: #cbd5e1;
    }

    .o-card.is-active {
        border-left: 4px solid var(--red);
    }

    /* Body — right padding reserves space for the 3-dot button */
    .o-card-body {
        padding: 14px 50px 12px 14px;
    }

    /* Main row: always horizontal — image left, content right */
    .o-row {
        display: flex;
        flex-direction: row;
        gap: 12px;
        align-items: flex-start;
    }

    /* Image thumbnail */
    .o-img,
    .o-img-ph {
        width: 60px;
        height: 60px;
        min-width: 60px;
        /* never shrinks */
        border-radius: 12px;
        flex-shrink: 0;
    }

    .o-img {
        object-fit: cover;
        border: 1px solid var(--border);
    }

    .o-img-ph {
        background: var(--surface);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #cbd5e1;
        font-size: 1.35rem;
    }

    @media (min-width: 480px) {

        .o-img,
        .o-img-ph {
            width: 70px;
            height: 70px;
            min-width: 70px;
        }
    }

    @media (min-width: 768px) {

        .o-img,
        .o-img-ph {
            width: 76px;
            height: 76px;
            min-width: 76px;
            font-size: 1.6rem;
        }
    }

    /* Info column — fills remaining space, clips overflow */
    .o-info {
        flex: 1;
        min-width: 0;
    }

    /* Title row: name + badge, name truncates */
    .o-title-row {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        margin-bottom: 7px;
    }

    .o-name {
        flex: 1;
        min-width: 0;
        font-size: clamp(0.88rem, 2vw, 1rem);
        font-weight: 700;
        color: var(--ink);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Status pill — never squishes or wraps */
    .s-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 9px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        white-space: nowrap;
        flex-shrink: 0;
    }

    /* Meta: tracking + date */
    .o-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 6px;
        margin-bottom: 9px;
        font-size: 0.76rem;
        color: var(--ink-mid);
    }

    .o-tracking {
        background: #f8fafc;
        padding: 2px 7px;
        border-radius: 6px;
        border: 1px solid var(--border);
        font-family: monospace;
        font-size: 0.72rem;
        white-space: nowrap;
    }

    /* Route */
    .o-route {
        display: flex;
        gap: 8px;
        align-items: flex-start;
        font-size: 0.76rem;
    }

    .r-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
        margin-top: 4px;
    }

    .r-line {
        width: 2px;
        height: 28px;
        background: var(--border);
        margin: 4px auto;
    }

    .o-route-text {
        flex: 1;
        min-width: 0;
        color: var(--ink-mid);
    }

    .o-route-addr {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
        margin-bottom: 8px;
        font-size: 0.88rem;
        font-weight: 600;
    }

    .o-route-addr:last-child {
        margin-bottom: 0;
    }

    /* Earn badge */
    .earn-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        font-size: 0.74rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 20px;
        margin-top: 8px;
    }

    .earn-badge.pending {
        background: #fffbeb;
        border-color: #fde68a;
        color: #92400e;
    }

    .earn-badge.rejected {
        background: #fef2f2;
        border-color: #fecaca;
        color: #991b1b;
    }

    /* Bottom strip */
    .o-strip {
        background: var(--surface);
        border-top: 1px solid var(--border);
        padding: 9px 14px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        font-size: 0.8rem;
        border-radius: 0 0 18px 18px;
    }

    .o-strip-left,
    .o-strip-right {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        min-width: 0;
    }

    .o-strip-left {
        flex: 1 1 auto;
    }

    .o-strip-right {
        justify-content: flex-end;
        margin-left: auto;
    }

    .o-strip-price {
        font-weight: 800;
        color: var(--ink);
        white-space: nowrap;
    }

    .o-strip-price--tbc {
        color: #dc2626;
        font-weight: 700;
    }

    .o-strip-outstanding {
        color: #dc2626;
        font-weight: 600;
        white-space: nowrap;
        font-size: 0.78rem;
    }

    .o-strip-pill {
        flex-shrink: 0;
    }

    /* Three-dot menu button */
    .o-menu-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 20;
        width: 32px;
        height: 32px;
        border-radius: 9px;
        border: 1.5px solid var(--border);
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s;
        font-size: 0.95rem;
        color: var(--ink-mid);
    }

    .o-menu-btn:hover {
        background: var(--surface);
        border-color: #94a3b8;
        color: var(--ink);
    }

    /* Dropdown — flips left on tiny phones */
    .o-menu-dd {
        position: absolute;
        top: 50px;
        right: 12px;
        z-index: 100;
        min-width: 190px;
        background: white;
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 8px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        display: none;
    }

    .o-menu-dd.open {
        display: block;
    }

    @media (max-width: 380px) {
        .o-menu-dd {
            right: auto;
            left: 12px;
        }
    }

    .btn-a {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 9px 12px;
        border-radius: 9px;
        font-size: 0.86rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.15s;
        white-space: nowrap;
        width: 100%;
        text-decoration: none;
    }

    .btn-pickup {
        background: #f0f9ff;
        color: #0369a1;
    }

    .btn-pickup:hover {
        background: #e0f2fe;
    }

    .btn-transit {
        background: #eef2ff;
        color: #4338ca;
    }

    .btn-transit:hover {
        background: #e0e7ff;
    }

    .btn-deliver {
        background: #f0fdf4;
        color: #166534;
    }

    .btn-deliver:hover {
        background: #dcfce7;
    }

    .btn-return {
        background: #fff7ed;
        color: #9a3412;
    }

    .btn-return:hover {
        background: #ffedd5;
    }

    .btn-reject {
        background: #fef2f2;
        color: #991b1b;
    }

    .btn-reject:hover {
        background: #fee2e2;
    }

    .menu-div {
        height: 1px;
        background: var(--border);
        margin: 6px 0;
    }

    /* ── MODALS ─────────────────────────────────────── */
    .m-back {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.55);
        backdrop-filter: blur(4px);
        z-index: 1050;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    .m-box {
        background: white;
        border-radius: 20px;
        width: 100%;
        max-width: 460px;
        padding: 28px;
        box-shadow: 0 24px 64px rgba(0, 0, 0, 0.22);
    }

    .m-box h5 {
        font-size: 1.1rem;
        font-weight: 800;
        margin: 0 0 6px;
    }

    .m-box p {
        font-size: 0.88rem;
        color: var(--ink-mid);
        margin: 0 0 20px;
    }

    /* ── LIGHTBOX ────────────────────────────────────── */
    .lightbox {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.88);
        z-index: 2000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .lightbox img {
        max-width: 100%;
        max-height: 90vh;
        border-radius: 12px;
    }

    .lb-close {
        position: absolute;
        top: 16px;
        right: 20px;
        background: white;
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 1rem;
    }

    /* ── GLOBAL SMALL-SCREEN TWEAKS ─────────────────── */
    @media (max-width: 575px) {
        .earnings-banner {
            padding: 18px 16px;
        }

        .filter-bar {
            padding: 14px;
            gap: 10px;
        }

        .filter-group {
            min-width: 110px;
        }

        .kpi-tile {
            padding: 16px 14px 12px;
        }

        .kpi-tile .tile-icon {
            width: 36px;
            height: 36px;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .o-card-body {
            padding: 12px 46px 10px 12px;
        }

        .o-strip {
            padding: 10px 12px;
            font-size: 0.75rem;
            gap: 8px;
            align-items: flex-start;
        }

        .o-strip-left,
        .o-strip-right {
            width: 100%;
        }

        .o-strip-left {
            flex-wrap: wrap;
            align-items: center;
        }

        .o-strip-right {
            justify-content: flex-start;
            margin-left: 0;
        }

        .o-strip-price,
        .o-strip-pill {
            flex-shrink: 0;
        }

        .o-strip-outstanding {
            flex-basis: 100%;
        }
    }

    .contact-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 20px;
        text-decoration: none;
        white-space: nowrap;
        line-height: 1.4;
        transition: opacity 0.15s;
    }

    .contact-pill:hover {
        opacity: 0.8;
    }

    .contact-pill i {
        font-size: 0.78rem;
    }

    .contact-pill--call {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .contact-pill--wa {
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
    }
</style>
