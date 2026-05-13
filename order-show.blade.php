<style>
    :root {
        --brand-red: #ff1a00;
        --brand-black: #111827;
    }

    /* ── STATUS HEADER ──────────────────────────────────────── */
    .status-header {
        border-radius: 18px;
        padding: 24px 28px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }

    .status-header::after {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.04);
        border-radius: 50%;
    }

    .status-header .mono {
        font-family: 'Courier New', monospace;
        font-size: 0.78rem;
        letter-spacing: 0.5px;
        background: rgba(255, 255, 255, 0.12);
        padding: 3px 10px;
        border-radius: 6px;
        display: inline-block;
    }

    /* ── CARDS ──────────────────────────────────────────────── */
    .det-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        margin-bottom: 18px;
        overflow: hidden;
    }

    .det-head {
        padding: 14px 20px;
        border-bottom: 1px solid #f9fafb;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .det-head .ico {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    .det-head h6 {
        font-size: 0.875rem;
        font-weight: 700;
        margin: 0;
        color: var(--brand-black);
    }

    .det-body {
        padding: 16px 20px;
    }

    /* ── INFO ROWS ──────────────────────────────────────────── */
    .irow {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        padding: 9px 0;
        border-bottom: 1px solid #f9fafb;
        font-size: 0.85rem;
    }

    .irow:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .irow:first-child {
        padding-top: 0;
    }

    .irow .lbl {
        color: #6b7280;
        font-weight: 500;
        flex-shrink: 0;
    }

    .irow .val {
        font-weight: 600;
        color: var(--brand-black);
        text-align: right;
        word-break: break-word;
    }

    /* ── STATUS BADGE ───────────────────────────────────────── */
    .s-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        white-space: nowrap;
    }

    /* ── MAP ────────────────────────────────────────────────── */
    .map-wrap {
        width: 100%;
        height: 230px;
        overflow: hidden;
    }

    .map-wrap iframe {
        width: 100%;
        height: 100%;
        border: none;
        display: block;
    }

    /* ── TIMELINE ───────────────────────────────────────────── */
    .tl-item {
        display: flex;
        gap: 14px;
        align-items: flex-start;
    }

    .tl-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex-shrink: 0;
    }

    .tl-dot {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        border: 2px solid;
    }

    .tl-line {
        width: 2px;
        flex: 1;
        min-height: 20px;
        margin: 4px 0;
    }

    /* ── ITEM IMAGE ─────────────────────────────────────────── */
    .img-wrap {
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
        cursor: zoom-in;
        border: 1px solid #f1f5f9;
        background: #f9fafb;
    }

    .img-wrap img {
        width: 100%;
        max-height: 240px;
        object-fit: cover;
        display: block;
    }

    .img-empty {
        width: 100%;
        height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #d1d5db;
        font-size: 3rem;
        background: #f9fafb;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
    }

    /* ── CONTACT CARDS ──────────────────────────────────────── */
    .contact-card {
        padding: 14px;
        border-radius: 12px;
        background: #f9fafb;
        border: 1px solid #f3f4f6;
    }

    .contact-card .role-tag {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }

    .btn-call {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.15s;
        margin-top: 8px;
    }

    .btn-call-s {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-call-s:hover {
        background: #e5e7eb;
        color: #374151;
    }

    .btn-call-r {
        background: #fff0ef;
        color: var(--brand-red);
    }

    .btn-call-r:hover {
        background: #ffd5d0;
        color: var(--brand-red);
    }

    /* ── ACTION BUTTONS ─────────────────────────────────────── */
    .btn-act {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 18px;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        width: 100%;
        transition: all 0.15s;
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

    /* ── EARNING CARD ───────────────────────────────────────── */
    .earning-card {
        border-radius: 14px;
        padding: 16px 20px;
        border: 1.5px solid;
    }

    /* ── MODALS ─────────────────────────────────────────────── */
    .m-bg {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.55);
        backdrop-filter: blur(3px);
        z-index: 1050;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    .m-box {
        background: white;
        border-radius: 16px;
        width: 100%;
        max-width: 460px;
        padding: 28px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    }

    .m-box h5 {
        font-size: 1.05rem;
        font-weight: 800;
        margin: 0 0 6px;
    }

    .m-box p {
        font-size: 0.875rem;
        color: #6b7280;
        margin: 0 0 20px;
    }

    /* ── LIGHTBOX ───────────────────────────────────────────── */
    .lightbox {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.9);
        z-index: 2000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .lightbox img {
        max-width: 100%;
        max-height: 90vh;
        border-radius: 12px;
        object-fit: contain;
    }

    .lb-x {
        position: absolute;
        top: 16px;
        right: 20px;
        background: white;
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ── FLASH ──────────────────────────────────────────────── */
    .flash-ok {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 0.875rem;
        margin-bottom: 16px;
    }

    .flash-err {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 0.875rem;
        margin-bottom: 16px;
    }

    @media (max-width: 575px) {
        .status-header {
            padding: 18px 20px;
        }

        .det-body,
        .det-head {
            padding: 12px 16px;
        }
    }
</style>