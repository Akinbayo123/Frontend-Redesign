<div>
    @push('styles')
        <x-rider.styles.orders />
    @endpush

    <div wire:key="rider-orders-v2">
        <div class="container-fluid pb-5">
            @if (session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 rounded-3 mb-3 py-2 px-3"
                    style="font-size:0.88rem;">
                    <i class="ti ti-circle-check"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger d-flex align-items-center gap-2 rounded-3 mb-3 py-2 px-3"
                    style="font-size:0.88rem;">
                    <i class="ti ti-alert-circle"></i> {{ session('error') }}
                </div>
            @endif

            {{-- ══ EARNINGS BANNER ════════════════════════════ --}}
            <div class="earnings-banner mb-4">
                <div class="d-flex align-items-start justify-content-between flex-wrap gap-3"
                    style="position:relative;z-index:1;">
                    <div>
                        <div
                            style="font-size:0.7rem;font-weight:700;letter-spacing:0.8px;text-transform:uppercase;opacity:0.5;margin-bottom:6px;">
                            Total Earnings</div>
                        <div
                            style="font-size:clamp(1.6rem,5vw,2.6rem);font-weight:900;line-height:1;letter-spacing:-1px;margin-bottom:8px;">
                            ₦{{ number_format($stats['total_earnings'], 2) }}
                        </div>
                        <div class="d-flex flex-wrap gap-2 align-items-center" style="font-size:0.81rem;opacity:0.75;">
                            <span><span
                                    style="color:#4ade80;font-weight:700;">₦{{ number_format($stats['paid_earnings'], 2) }}</span>
                                paid out</span>
                            <span>·</span>
                            <span><span
                                    style="color:#fbbf24;font-weight:700;">₦{{ number_format($stats['pending_earnings'], 2) }}</span>
                                pending</span>
                            @if (isset($ratingSummary) && $ratingSummary['total'] > 0)
                                <span>·</span>
                                <span class="d-flex align-items-center gap-1">
                                    <span style="color:#fbbf24;font-weight:700;">★</span>
                                    <span style="font-weight:700;">{{ $ratingSummary['average'] }}</span>
                                    <span style="opacity:0.7;">· {{ $ratingSummary['total'] }}
                                        {{ Str::plural('rating', $ratingSummary['total']) }}</span>
                                </span>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('rider.earnings') }}" class="d-flex align-items-center gap-2 fw-bold"
                        style="background:var(--red);color:white;padding:10px 18px;border-radius:12px;font-size:0.86rem;text-decoration:none;white-space:nowrap;align-self:center;transition:background 0.15s;"
                        onmouseover="this.style.background='#e61700'" onmouseout="this.style.background='var(--red)'">
                        <i class="ti ti-wallet"></i> View Earnings
                    </a>
                </div>
            </div>

            {{-- ══ KPI TILES ══════════════════════════════════ --}}
            <div class="kpi-grid">
                <div class="kpi-tile tile-dark">
                    <div class="tile-icon"><i class="ti ti-package"></i></div>
                    <div class="tile-val">{{ number_format($stats['total']) }}</div>
                    <div class="tile-lbl">Total Orders</div>
                    <div class="tile-sub">{{ $statusFilter || $dateFilter || $search ? 'filtered' : 'all time' }}</div>
                </div>
                <div class="kpi-tile tile-indigo">
                    <div class="tile-icon"><i class="ti ti-rocket"></i></div>
                    <div class="tile-val">{{ number_format($stats['active']) }}</div>
                    <div class="tile-lbl">Active</div>
                    <div class="tile-sub">in progress now</div>
                </div>
                <div class="kpi-tile tile-green">
                    <div class="tile-icon"><i class="ti ti-circle-check"></i></div>
                    <div class="tile-val">{{ number_format($stats['delivered']) }}</div>
                    <div class="tile-lbl">Delivered</div>
                    <div class="tile-sub">
                        @if ($stats['total'] > 0)
                            {{ round(($stats['delivered'] / max(1, $stats['total'])) * 100, 1) }}% success
                        @else
                            all time
                        @endif
                    </div>
                </div>
                <div class="kpi-tile tile-orange">
                    <div class="tile-icon"><i class="ti ti-arrow-back"></i></div>
                    <div class="tile-val">{{ number_format($stats['returned']) }}</div>
                    <div class="tile-lbl">Returned</div>
                    <div class="tile-sub">{{ $stats['cancelled'] }} cancelled</div>
                </div>
            </div>

            {{-- ══ MY RATINGS ════════════════════════════════ --}}
            @if (isset($ratingSummary) && $ratingSummary['total'] > 0)
                <div class="chart-card mb-4" style="padding: 20px 24px;">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0"><i class="ti ti-star me-1"></i>My Ratings</h6>
                        <span style="font-size:0.78rem;color:#64748b;">{{ $ratingSummary['total'] }}
                            {{ Str::plural('rating', $ratingSummary['total']) }} total</span>
                    </div>

                    <div class="d-flex flex-wrap gap-4">

                        {{-- Average Score --}}
                        <div class="d-flex flex-column align-items-center justify-content-center"
                            style="min-width:90px;">
                            <div
                                style="font-size:3rem;font-weight:900;line-height:1;color:#0f172a;letter-spacing:-2px;">
                                {{ $ratingSummary['average'] }}
                            </div>
                            <div class="d-flex gap-1 my-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span
                                        style="font-size:1.1rem;color:{{ $i <= round($ratingSummary['average']) ? '#f59e0b' : '#e2e8f0' }};">★</span>
                                @endfor
                            </div>
                            <div style="font-size:0.75rem;color:#94a3b8;font-weight:600;">out of 5</div>
                        </div>

                        {{-- Star Distribution --}}
                        <div class="flex-grow-1 d-flex flex-column justify-content-center gap-2">
                            @foreach ([5 => $ratingSummary['five'], 4 => $ratingSummary['four'], 3 => $ratingSummary['three'], 2 => $ratingSummary['two'], 1 => $ratingSummary['one']] as $star => $count)
                                @php $pct = $ratingSummary['total'] > 0 ? round(($count / $ratingSummary['total']) * 100) : 0; @endphp
                                <div class="d-flex align-items-center gap-2">
                                    <span
                                        style="font-size:0.75rem;font-weight:600;color:#64748b;width:14px;text-align:right;flex-shrink:0;">{{ $star }}</span>
                                    <span style="font-size:0.72rem;color:#f59e0b;flex-shrink:0;">★</span>
                                    <div
                                        style="flex:1;height:7px;background:#f1f5f9;border-radius:99px;overflow:hidden;">
                                        <div
                                            style="height:100%;width:{{ $pct }}%;background:{{ $star >= 4 ? '#f59e0b' : ($star === 3 ? '#94a3b8' : '#ef4444') }};border-radius:99px;transition:width 0.4s;">
                                        </div>
                                    </div>
                                    <span
                                        style="font-size:0.75rem;color:#94a3b8;width:24px;flex-shrink:0;">{{ $count }}</span>
                                </div>
                            @endforeach
                        </div>

                        {{-- Recent Comments --}}
                        @if ($ratingSummary['recent']->filter(fn($r) => $r->comment)->count() > 0)
                            <div class="d-flex flex-column gap-2" style="min-width:200px;max-width:280px;flex:1;">
                                <div
                                    style="font-size:0.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:2px;">
                                    Recent Comments
                                </div>
                                @foreach ($ratingSummary['recent']->filter(fn($r) => $r->comment)->take(3) as $recent)
                                    <div
                                        style="background:#f8fafc;border-radius:10px;padding:10px 12px;border:1px solid #f1f5f9;">
                                        <div class="d-flex align-items-center gap-1 mb-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span
                                                    style="font-size:0.7rem;color:{{ $i <= $recent->rating ? '#f59e0b' : '#e2e8f0' }};">★</span>
                                            @endfor
                                            <span style="font-size:0.7rem;color:#94a3b8;margin-left:4px;">
                                                {{ $recent->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <p
                                            style="margin:0;font-size:0.78rem;color:#475569;line-height:1.5;font-style:italic;">
                                            "{{ Str::limit($recent->comment, 80) }}"
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            @endif

            {{-- ══ ANALYTICS ══════════════════════════════════ --}}
            <div class="analytics-row">
                <div class="chart-card">
                    <h6><i class="ti ti-chart-donut me-1"></i>Order Breakdown</h6>
                    <div id="riderDonutChart"></div>
                    <div class="mt-3 d-flex flex-column gap-1">
                        @foreach ([['label' => 'Active', 'val' => $stats['active'], 'color' => '#6366f1'], ['label' => 'Delivered', 'val' => $stats['delivered'], 'color' => '#10b981'], ['label' => 'Returned', 'val' => $stats['returned'], 'color' => '#f97316'], ['label' => 'Cancelled', 'val' => $stats['cancelled'], 'color' => '#ef4444']] as $row)
                            @if ($row['val'] > 0)
                                <div class="d-flex align-items-center justify-content-between py-1"
                                    style="font-size:0.82rem;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div
                                            style="width:9px;height:9px;border-radius:50%;background:{{ $row['color'] }};flex-shrink:0;">
                                        </div>
                                        <span style="color:#64748b;">{{ $row['label'] }}</span>
                                    </div>
                                    <span
                                        style="font-weight:700;color:{{ $row['color'] }};">{{ $row['val'] }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="chart-card">
                    <h6><i class="ti ti-currency-naira me-1"></i>Earnings Overview</h6>
                    @php
                        $totalE = max(1, $stats['total_earnings']);
                        $paidPct = $totalE > 0 ? round(($stats['paid_earnings'] / $totalE) * 100) : 0;
                        $pendPct = $totalE > 0 ? round(($stats['pending_earnings'] / $totalE) * 100) : 0;
                    @endphp
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2" style="font-size:0.82rem;">
                            <span style="color:#64748b;font-weight:600;">Total Earned</span>
                            <span
                                style="font-weight:800;font-size:1.05rem;color:var(--ink);">₦{{ number_format($stats['total_earnings'], 2) }}</span>
                        </div>
                        <div style="height:10px;background:#f1f5f9;border-radius:99px;overflow:hidden;">
                            <div
                                style="height:100%;width:{{ $paidPct }}%;background:linear-gradient(90deg,#10b981,#34d399);border-radius:99px;">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3"
                            style="background:#f0fdf4;border:1px solid #bbf7d0;">
                            <div class="d-flex align-items-center gap-2">
                                <i class="ti ti-circle-check" style="color:#16a34a;font-size:1.1rem;"></i>
                                <div>
                                    <div
                                        style="font-size:0.68rem;font-weight:700;color:#166534;text-transform:uppercase;letter-spacing:0.5px;">
                                        Paid Out</div>
                                    <div style="font-size:0.95rem;font-weight:800;color:#14532d;">
                                        ₦{{ number_format($stats['paid_earnings'], 2) }}</div>
                                </div>
                            </div>
                            <span
                                style="font-size:0.74rem;font-weight:700;color:#16a34a;background:#dcfce7;padding:3px 9px;border-radius:20px;">{{ $paidPct }}%</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3"
                            style="background:#fffbeb;border:1px solid #fde68a;">
                            <div class="d-flex align-items-center gap-2">
                                <i class="ti ti-clock" style="color:#d97706;font-size:1.1rem;"></i>
                                <div>
                                    <div
                                        style="font-size:0.68rem;font-weight:700;color:#92400e;text-transform:uppercase;letter-spacing:0.5px;">
                                        Pending</div>
                                    <div style="font-size:0.95rem;font-weight:800;color:#78350f;">
                                        ₦{{ number_format($stats['pending_earnings'], 2) }}</div>
                                </div>
                            </div>
                            <span
                                style="font-size:0.74rem;font-weight:700;color:#d97706;background:#fef3c7;padding:3px 9px;border-radius:20px;">{{ $pendPct }}%</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-3" style="border-top:1px solid var(--border);">
                        <a href="{{ route('rider.earnings') }}"
                            style="display:flex;align-items:center;justify-content:center;gap:6px;background:var(--ink);color:white;border-radius:12px;padding:11px;font-size:0.86rem;font-weight:700;text-decoration:none;transition:background 0.15s;"
                            onmouseover="this.style.background='#1e293b'"
                            onmouseout="this.style.background='var(--ink)'">
                            <i class="ti ti-arrow-right"></i> Go to Earnings
                        </a>
                    </div>
                </div>
            </div>

            {{-- ══ FILTER BAR ═════════════════════════════════ --}}
            <div class="filter-bar">
                <div class="filter-group search-wrap">
                    <label>Search</label>
                    <div class="position-relative">
                        <i class="ti ti-search position-absolute"
                            style="left:10px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:0.88rem;"></i>
                        <input wire:model.live.debounce.400ms="search" type="text" class="search-input"
                            placeholder="Tracking, item name, customer...">
                        <div wire:loading wire:target="search" class="position-absolute"
                            style="right:10px;top:50%;transform:translateY(-50%);">
                            <span class="spinner-border spinner-border-sm text-muted"
                                style="width:13px;height:13px;"></span>
                        </div>
                    </div>
                </div>
                <div class="filter-group">
                    <label>Status</label>
                    <select wire:model.live="statusFilter"
                        class="filter-select {{ $statusFilter ? 'has-value' : '' }}">
                        <option value="">All Statuses</option>
                        <option value="rider_assigned">Rider Assigned</option>
                        <option value="pickup_confirmed">Pickup Confirmed</option>
                        <option value="in_transit">In Transit</option>
                        <option value="delivered">Delivered</option>
                        <option value="returned">Returned</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Period</label>
                    <select wire:model.live="dateFilter" class="filter-select {{ $dateFilter ? 'has-value' : '' }}">
                        <option value="">All Time</option>
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="this_week">This Week</option>
                        <option value="this_month">This Month</option>
                        <option value="this_year">This Year</option>
                        <option value="custom">Custom Range</option>
                    </select>
                </div>
                @if ($dateFilter === 'custom')
                    <div class="filter-group">
                        <label>From</label>
                        <input type="date" wire:model.live="dateFrom" class="filter-select"
                            style="padding-right:10px;">
                    </div>
                    <div class="filter-group">
                        <label>To</label>
                        <input type="date" wire:model.live="dateTo" class="filter-select"
                            style="padding-right:10px;">
                    </div>
                @endif
                @if ($search || $statusFilter || $dateFilter)
                    <button wire:click="clearFilters" class="btn-clear">
                        <i class="ti ti-x me-1"></i>Clear
                    </button>
                @endif
            </div>

            @if ($search || $statusFilter || $dateFilter)
                <div class="d-flex align-items-center gap-2 mb-3 px-1"
                    style="font-size:0.83rem;color:var(--ink-mid);">
                    <i class="ti ti-filter" style="color:var(--red);"></i>
                    Showing <strong class="mx-1">{{ $orders->total() }}</strong> filtered result(s)
                </div>
            @endif

            {{-- ══ ORDERS LIST ════════════════════════════════ --}}
            <div wire:loading.class="opacity-50" wire:target="statusFilter,dateFilter,search,clearFilters">
                @forelse($orders as $order)
                    @php
                        $sv = $order->status->value;
                        $isActive = in_array($sv, ['rider_assigned', 'pickup_confirmed', 'in_transit']);
                        $badge = match ($sv) {
                            'pending' => ['bg' => '#f3f4f6', 'color' => '#374151', 'icon' => 'ti-clock'],
                            'accepted' => ['bg' => '#eff6ff', 'color' => '#1d4ed8', 'icon' => 'ti-check'],
                            'rider_assigned' => ['bg' => '#fffbeb', 'color' => '#92400e', 'icon' => 'ti-user-check'],
                            'pickup_confirmed' => [
                                'bg' => '#eff6ff',
                                'color' => '#1e40af',
                                'icon' => 'ti-clipboard-check',
                            ],
                            'in_transit' => ['bg' => '#eef2ff', 'color' => '#4338ca', 'icon' => 'ti-truck'],
                            'delivered' => ['bg' => '#f0fdf4', 'color' => '#166534', 'icon' => 'ti-circle-check'],
                            'returned' => ['bg' => '#fff7ed', 'color' => '#9a3412', 'icon' => 'ti-arrow-back'],
                            'cancelled' => ['bg' => '#fef2f2', 'color' => '#991b1b', 'icon' => 'ti-circle-x'],
                            default => ['bg' => '#f3f4f6', 'color' => '#374151', 'icon' => 'ti-circle'],
                        };
                        $fee = (float) $order->delivery_fee;
                        $amountPaid = (float) ($order->amount_paid ?? 0);
                        $outstanding = max(0, $fee - $amountPaid);
                        $payMethod = is_object($order->payment_method)
                            ? $order->payment_method->value
                            : $order->payment_method;
                        $payStatus = is_object($order->payment_status)
                            ? $order->payment_status->value
                            : $order->payment_status;
                        $isReceiverPay = $payMethod === 'receiver';
                        $isCustom = (bool) ($order->is_custom_price ?? false);
                        $img = $order->orderDetails?->item_image;
                        $showUrl = route('rider.order.show', ['trackingNumber' => $order->tracking_number]);
                        $menuId = 'menu-' . $order->id;
                        $earning = $order->earning ?? null;
                        $earningAmt = $earning?->amount ?? 0;
                        $earningStatus = $earning
                            ? (is_object($earning->status)
                                ? $earning->status->value
                                : (string) $earning->status)
                            : null;
                    @endphp

                    <div class="o-card {{ $isActive ? 'is-active' : '' }}"
                        onclick="window.location='{{ $showUrl }}'" data-card-id="{{ $order->id }}">

                        <button class="o-menu-btn" onclick="toggleMenu(event,'{{ $menuId }}')"
                            title="Actions">
                            <i class="ti ti-dots-vertical"></i>
                        </button>
                        <div id="{{ $menuId }}" class="o-menu-dd">
                            @if ($sv === 'rider_assigned')
                                <button wire:click.stop="confirmPickup({{ $order->id }})"
                                    onclick="event.stopPropagation();closeAllMenus()" class="btn-a btn-pickup mb-1">
                                    <i class="ti ti-clipboard-check"></i> Confirm Pickup
                                </button>
                            @endif
                            @if (in_array($sv, ['rider_assigned', 'pickup_confirmed']))
                                <button wire:click.stop="confirmInTransit({{ $order->id }})"
                                    onclick="event.stopPropagation();closeAllMenus()" class="btn-a btn-transit mb-1">
                                    <i class="ti ti-truck"></i> Start Transit
                                </button>
                            @endif
                            @if (in_array($sv, ['rider_assigned', 'pickup_confirmed', 'in_transit']))
                                <button wire:click.stop="confirmDelivery({{ $order->id }})"
                                    onclick="event.stopPropagation();closeAllMenus()" class="btn-a btn-deliver mb-1">
                                    <i class="ti ti-circle-check"></i> Mark Delivered
                                </button>
                            @endif
                            @if ($sv === 'in_transit')
                                <button wire:click.stop="confirmReturn({{ $order->id }})"
                                    onclick="event.stopPropagation();closeAllMenus()" class="btn-a btn-return mb-1">
                                    <i class="ti ti-arrow-back"></i> Mark Returned
                                </button>
                            @endif
                            @if (in_array($sv, ['rider_assigned', 'accepted']))
                                <div class="menu-div"></div>
                                <button wire:click.stop="confirmReject({{ $order->id }})"
                                    onclick="event.stopPropagation();closeAllMenus()" class="btn-a btn-reject">
                                    <i class="ti ti-x"></i> Reject Order
                                </button>
                            @endif
                        </div>

                        <div class="o-card-body">
                            <div class="o-row">

                                @if ($img)
                                    <img src="{{ $order->orderDetails->image_url }}" alt="Item" class="o-img"
                                        onclick="openLightbox(event,'{{ $order->orderDetails->image_url }}')"
                                        title="Enlarge">
                                @else
                                    <div class="o-img-ph"><i class="ti ti-package"></i></div>
                                @endif

                                <div class="o-info">

                                    <div class="o-title-row">
                                        <div class="o-name">{{ $order->orderDetails?->item_name ?? 'Package' }}</div>
                                        <span class="s-pill"
                                            style="background:{{ $badge['bg'] }};color:{{ $badge['color'] }};">
                                            <i class="ti {{ $badge['icon'] }}" style="font-size:0.62rem;"></i>
                                            {{ ucfirst(str_replace('_', ' ', $sv)) }}
                                        </span>
                                    </div>

                                    <div class="o-meta">
                                        <span class="o-tracking">{{ $order->tracking_number }}</span>
                                        <span>{{ $order->created_at->format('d M Y') }}</span>
                                        @if ($order->parcel_weight)
                                            <span><i class="ti ti-weight"
                                                    style="font-size:0.78rem;"></i>{{ $order->parcel_weight }}kg</span>
                                        @endif
                                    </div>

                                    <div class="o-route">
                                        <div class="d-flex flex-column align-items-center"
                                            style="flex-shrink:0;padding-top:3px;">
                                            <div class="r-dot" style="background:#f59e0b;"></div>
                                            <div class="r-line"></div>
                                            <div class="r-dot" style="background:#10b981;"></div>
                                        </div>
                                        <div class="o-route-text">

                                            {{-- SENDER ADDRESS --}}
                                            <div class="o-route-addr">{{ $order->sender_street }},
                                                {{ $order->sender_city }}</div>
                                            @if ($order->user?->phone || $order->user?->whatsapp_number)
                                                <div class="d-flex flex-wrap gap-1 mt-1">
                                                    @if ($order->user?->phone)
                                                        <a href="tel:{{ $order->user->phone }}"
                                                            onclick="event.stopPropagation();"
                                                            class="contact-pill contact-pill--call">
                                                            <i class="ti ti-phone"></i> {{ $order->user->phone }}
                                                        </a>
                                                    @endif
                                                    @if ($order->user?->whatsapp_number)
                                                        <a href="https://wa.me/{{ str_replace([' ', '-', '+', '(', ')'], '', $order->user->whatsapp_number) }}"
                                                            target="_blank" onclick="event.stopPropagation();"
                                                            class="contact-pill contact-pill--wa">
                                                            <i class="ti ti-brand-whatsapp"></i> WhatsApp
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif

                                            {{-- RECEIVER ADDRESS --}}
                                            <div class="o-route-addr">{{ $order->receiver_street }},
                                                {{ $order->receiver_city }}</div>
                                            @if ($order->receiver_phone || $order->receiver_whatsapp_number)
                                                <div class="d-flex flex-wrap gap-1 mt-1">
                                                    @if ($order->receiver_phone)
                                                        <a href="tel:{{ $order->receiver_phone }}"
                                                            onclick="event.stopPropagation();"
                                                            class="contact-pill contact-pill--call">
                                                            <i class="ti ti-phone"></i> {{ $order->receiver_phone }}
                                                        </a>
                                                    @endif
                                                    @if ($order->receiver_whatsapp_number)
                                                        <a href="https://wa.me/{{ str_replace([' ', '-', '+', '(', ')'], '', $order->receiver_whatsapp_number) }}"
                                                            target="_blank" onclick="event.stopPropagation();"
                                                            class="contact-pill contact-pill--wa">
                                                            <i class="ti ti-brand-whatsapp"></i> WhatsApp
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif

                                        </div>
                                    </div>

                                    @if ($sv === 'delivered' && $earningAmt > 0)
                                        <div>
                                            <span
                                                class="earn-badge {{ $earningStatus === 'success' ? '' : ($earningStatus === 'failed' ? 'rejected' : 'pending') }}">
                                                <i class="ti ti-{{ $earningStatus === 'success' ? 'circle-check' : ($earningStatus === 'failed' ? 'x-circle' : 'clock') }}"
                                                    style="font-size:0.72rem;"></i>
                                                Earned ₦{{ number_format($earningAmt, 2) }} ·
                                                {{ $earningStatus === 'success' ? 'Paid' : ($earningStatus === 'failed' ? 'Rejected' : 'Pending') }}
                                            </span>
                                        </div>
                                    @elseif($sv === 'delivered' && !$earning)
                                        <div>
                                            <span class="earn-badge pending">
                                                <i class="ti ti-clock" style="font-size:0.72rem;"></i>
                                                Earning not yet processed
                                            </span>
                                        </div>
                                    @endif

                                    @if ($sv === 'delivered' && $order->rating)
                                        <div class="mt-1 d-flex align-items-center gap-2 flex-wrap">
                                            <div class="d-flex align-items-center gap-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span
                                                        style="font-size:0.82rem;color:{{ $i <= $order->rating->rating ? '#f59e0b' : '#e2e8f0' }};">★</span>
                                                @endfor
                                            </div>
                                            @if ($order->rating->comment)
                                                <span
                                                    style="font-size:0.75rem;color:#64748b;font-style:italic;max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                                    "{{ $order->rating->comment }}"
                                                </span>
                                            @endif
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <div class="o-strip">
                            <div class="o-strip-left">
                                @if ($isCustom && $fee == 0)
                                    <span class="o-strip-price o-strip-price--tbc">Price TBC</span>
                                @else
                                    <span class="o-strip-price">₦{{ number_format($fee, 2) }}</span>
                                    @if ($isReceiverPay)
                                        <span class="s-pill o-strip-pill o-strip-pill--meta">
                                            <i class="ti ti-user-check" style="font-size:0.62rem;"></i>
                                            Receiver Pays
                                        </span>
                                        @if ($payStatus === 'paid')
                                            <span class="s-pill o-strip-pill o-strip-pill--paid"><i
                                                    class="ti ti-check" style="font-size:0.62rem;"></i>Paid</span>
                                        @else
                                            <span class="s-pill o-strip-pill o-strip-pill--unpaid"><i
                                                    class="ti ti-clock" style="font-size:0.62rem;"></i>Unpaid</span>
                                        @endif
                                        @if ($outstanding > 0)
                                            <span class="o-strip-outstanding">₦{{ number_format($outstanding, 2) }}
                                                outstanding</span>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="text-center py-5">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-4 mb-3"
                            style="width:72px;height:72px;background:#f8fafc;">
                            <i class="ti ti-package-off" style="font-size:2rem;color:#cbd5e1;"></i>
                        </div>
                        <h6 class="fw-bold mb-1" style="font-size:1rem;">No orders found</h6>
                        <p class="text-muted mb-0" style="font-size:0.88rem;">
                            @if ($search || $statusFilter || $dateFilter)
                                No orders match your current filters.
                            @else
                                You have no assigned orders yet.
                            @endif
                        </p>
                        @if ($search || $statusFilter || $dateFilter)
                            <button wire:click="clearFilters" class="btn btn-sm btn-outline-secondary mt-3 rounded-3">
                                <i class="ti ti-x me-1"></i>Clear Filters
                            </button>
                        @endif
                    </div>
                @endforelse
            </div>

            @if ($orders->hasPages())
                <div class="mt-4">
                    {!! $orders->withQueryString()->links('pagination::custom') !!}
                </div>
            @endif
        </div>
    </div>

    {{-- LIGHTBOX --}}
    <div id="lightbox" class="lightbox" style="display:none;" onclick="closeLightbox()">
        <button class="lb-close" onclick="closeLightbox()"><i class="ti ti-x"></i></button>
        <img id="lightbox-img" src="" alt="Item Image">
    </div>

    {{-- PICKUP MODAL --}}
    @if ($pickupOrderId)
        <div class="m-back" wire:click.self="cancelPickup">
            <div class="m-box">
                <h5>Confirm Pickup</h5>
                <p>Confirm you have physically picked up this parcel from the sender.</p>
                <div class="d-flex gap-2 justify-content-end">
                    <button wire:click="cancelPickup"
                        class="btn btn-sm btn-outline-secondary rounded-3 px-4">Cancel</button>
                    <button wire:click="markPickupConfirmedFromModal" class="btn btn-sm rounded-3 px-4 fw-bold"
                        style="background:#0369a1;color:white;">
                        <i class="ti ti-clipboard-check me-1"></i>Yes, Picked Up
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- IN TRANSIT MODAL --}}
    @if ($transitOrderId)
        <div class="m-back" wire:click.self="cancelInTransit">
            <div class="m-box">
                <h5>Start Transit</h5>
                <p>Mark this order as <strong>In Transit</strong>? The customer will be notified.</p>
                <div class="d-flex gap-2 justify-content-end">
                    <button wire:click="cancelInTransit"
                        class="btn btn-sm btn-outline-secondary rounded-3 px-4">Cancel</button>
                    <button wire:click="markInTransitFromModal" class="btn btn-sm rounded-3 px-4 fw-bold"
                        style="background:#4338ca;color:white;">
                        <i class="ti ti-truck me-1"></i>Yes, In Transit
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- DELIVER MODAL --}}
    @if ($confirmingOrderId)
        <div class="m-back" wire:click.self="cancelConfirm">
            <div class="m-box">
                <h5>Confirm Delivery</h5>
                <p>Mark this order as <strong>Delivered</strong>? This action cannot be undone.</p>
                <div class="d-flex gap-2 justify-content-end">
                    <button wire:click="cancelConfirm"
                        class="btn btn-sm btn-outline-secondary rounded-3 px-4">Cancel</button>
                    <button wire:click="markDelivered" class="btn btn-sm rounded-3 px-4 fw-bold"
                        style="background:#16a34a;color:white;">
                        <i class="ti ti-circle-check me-1"></i>Yes, Delivered
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- REJECT MODAL --}}
    @if ($rejectingOrderId)
        <div class="m-back" wire:click.self="cancelReject">
            <div class="m-box">
                <h5>Reject Order</h5>
                <p>This removes you from the order and returns it to the admin for reassignment.</p>
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Reason <span class="text-danger">*</span></label>
                    <textarea wire:model="rejectReason" class="form-control rounded-3" rows="3"
                        placeholder="e.g. Vehicle breakdown, outside my delivery area..."></textarea>
                    @error('rejectReason')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex gap-2 justify-content-end">
                    <button wire:click="cancelReject"
                        class="btn btn-sm btn-outline-secondary rounded-3 px-4">Cancel</button>
                    <button wire:click="rejectOrder" class="btn btn-sm rounded-3 px-4 fw-bold"
                        style="background:#991b1b;color:white;">
                        <i class="ti ti-x me-1"></i>Reject Order
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- RETURN MODAL --}}
    @if ($returningOrderId)
        <div class="m-back" wire:click.self="cancelReturn">
            <div class="m-box">
                <h5>Mark as Returned</h5>
                <p>Explain why this order is being returned to the sender.</p>
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Reason <span class="text-danger">*</span></label>
                    <textarea wire:model="returnReason" class="form-control rounded-3" rows="3"
                        placeholder="e.g. Receiver not available, refused delivery..."></textarea>
                    @error('returnReason')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex gap-2 justify-content-end">
                    <button wire:click="cancelReturn"
                        class="btn btn-sm btn-outline-secondary rounded-3 px-4">Cancel</button>
                    <button wire:click="markReturned" class="btn btn-sm rounded-3 px-4 fw-bold"
                        style="background:#9a3412;color:white;">
                        <i class="ti ti-arrow-back me-1"></i>Mark Returned
                    </button>
                </div>
            </div>
        </div>
    @endif

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const active = {{ $stats['active'] }},
                    delivered = {{ $stats['delivered'] }},
                    returned = {{ $stats['returned'] }},
                    cancelled = {{ $stats['cancelled'] }};
                const total = active + delivered + returned + cancelled;
                const el = document.querySelector('#riderDonutChart');
                if (!el) return;
                if (total === 0) {
                    el.innerHTML =
                        `<div class="text-center py-3"><i class="ti ti-chart-donut" style="font-size:2.5rem;color:#e2e8f0;"></i><p class="text-muted small mt-2 mb-0">No data yet</p></div>`;
                    return;
                }
                const series = [],
                    labels = [],
                    colors = [];
                [{
                        label: 'Active',
                        val: active,
                        color: '#6366f1'
                    }, {
                        label: 'Delivered',
                        val: delivered,
                        color: '#10b981'
                    },
                    {
                        label: 'Returned',
                        val: returned,
                        color: '#f97316'
                    }, {
                        label: 'Cancelled',
                        val: cancelled,
                        color: '#ef4444'
                    }
                ]
                .forEach(s => {
                    if (s.val > 0) {
                        series.push(s.val);
                        labels.push(s.label);
                        colors.push(s.color);
                    }
                });
                new ApexCharts(el, {
                    series,
                    labels,
                    colors,
                    chart: {
                        type: 'donut',
                        height: 180,
                        fontFamily: 'inherit',
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '72%',
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        label: 'Orders',
                                        fontSize: '11px',
                                        color: '#94a3b8',
                                        formatter: () => total
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '20px',
                                        fontWeight: 800,
                                        color: '#0f172a'
                                    }
                                }
                            }
                        }
                    },
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 0
                    },
                    tooltip: {
                        y: {
                            formatter: val => val + ' orders (' + ((val / total) * 100).toFixed(1) + '%)'
                        }
                    },
                }).render();
            });

            function openLightbox(event, src) {
                event.stopPropagation();
                document.getElementById('lightbox-img').src = src;
                document.getElementById('lightbox').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }

            function closeLightbox() {
                document.getElementById('lightbox').style.display = 'none';
                document.body.style.overflow = '';
            }

            function toggleMenu(event, menuId) {
                event.stopPropagation();
                const menu = document.getElementById(menuId);
                const isOpen = menu.classList.contains('open');
                closeAllMenus();
                if (!isOpen) menu.classList.add('open');
            }

            function closeAllMenus() {
                document.querySelectorAll('.o-menu-dd.open').forEach(m => m.classList.remove('open'));
            }
            document.addEventListener('click', e => {
                if (!e.target.closest('.o-menu-btn') && !e.target.closest('.o-menu-dd')) closeAllMenus();
            });
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') {
                    closeLightbox();
                    closeAllMenus();
                }
            });
            document.addEventListener('livewire:updated', closeAllMenus);
        </script>
    @endpush
</div>
