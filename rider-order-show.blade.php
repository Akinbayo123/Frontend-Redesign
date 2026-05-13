<div>
    @section('page_title', 'Orders')
    @section('title', 'Order Details')
    @push('styles')
        <x-rider.styles.order-show />
    @endpush

    <div class="container-fluid pb-5">

        {{-- ── BACK LINK ── --}}
        <a href="{{ route('rider.orders') }}" wire:navigate
            class="d-inline-flex align-items-center gap-2 mb-3 text-decoration-none fw-semibold"
            style="font-size:0.85rem;color:#6b7280;">
            <i class="ti ti-arrow-left"></i> Back to Orders
        </a>

        {{-- ── FLASH ── --}}
        @if (session('success'))
            <div class="flash-ok d-flex align-items-center gap-2">
                <i class="ti ti-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="flash-err d-flex align-items-center gap-2">
                <i class="ti ti-alert-circle"></i> {{ session('error') }}
            </div>
        @endif

        {{-- ── STATUS HEADER ── --}}
        @php
            $sv = $order->status->value;
            $fee = (float) $order->delivery_fee;
            $amtPaid = (float) ($order->amount_paid ?? 0);
            $outstanding = max(0, $fee - $amtPaid);
            $payBy = is_object($order->payment_by) ? $order->payment_by->value : $order->payment_by;
            $payMethod = is_object($order->payment_method) ? $order->payment_method->value : $order->payment_method;
            $payStatus = is_object($order->payment_status) ? $order->payment_status->value : $order->payment_status;
            $isCustom = (bool) ($order->is_custom_price ?? false);
            $isReceiverPay = $payMethod === 'receiver' || $payBy === 'receiver';

            $badge = match ($sv) {
                'pending' => ['bg' => '#f3f4f6', 'color' => '#374151', 'icon' => 'ti-clock'],
                'accepted' => ['bg' => '#eff6ff', 'color' => '#1d4ed8', 'icon' => 'ti-check'],
                'rider_assigned' => ['bg' => '#fffbeb', 'color' => '#92400e', 'icon' => 'ti-user-check'],
                'pickup_confirmed' => ['bg' => '#eff6ff', 'color' => '#1e40af', 'icon' => 'ti-clipboard-check'],
                'in_transit' => ['bg' => '#eef2ff', 'color' => '#4338ca', 'icon' => 'ti-truck'],
                'delivered' => ['bg' => '#f0fdf4', 'color' => '#166534', 'icon' => 'ti-circle-check'],
                'returned' => ['bg' => '#fff7ed', 'color' => '#9a3412', 'icon' => 'ti-arrow-back'],
                'cancelled' => ['bg' => '#fef2f2', 'color' => '#991b1b', 'icon' => 'ti-circle-x'],
                default => ['bg' => '#f3f4f6', 'color' => '#374151', 'icon' => 'ti-circle'],
            };

            $headerBg = match ($sv) {
                'pickup_confirmed' => 'linear-gradient(135deg,#1e3a5f 0%,#1e40af 100%)',
                'in_transit' => 'linear-gradient(135deg,#312e81 0%,#4338ca 100%)',
                'delivered' => 'linear-gradient(135deg,#14532d 0%,#15803d 100%)',
                'returned' => 'linear-gradient(135deg,#7c2d12 0%,#c2410c 100%)',
                'cancelled' => 'linear-gradient(135deg,#7f1d1d 0%,#b91c1c 100%)',
                default => 'linear-gradient(135deg,#111827 0%,#1f2937 100%)',
            };
        @endphp

        <div class="status-header" style="background:{{ $headerBg }};">
            <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-3">
                <div>
                    <div class="text-white-50 small mb-1">Delivery Order</div>
                    <h4 class="fw-bold text-white mb-1">{{ $order->orderDetails?->item_name ?? 'Package' }}</h4>
                    <span class="mono text-white-50">{{ $order->tracking_number }}</span>
                </div>
                <div class="text-end">
                    <span class="s-pill" style="background:{{ $badge['bg'] }};color:{{ $badge['color'] }};">
                        <i class="ti {{ $badge['icon'] }}" style="font-size:0.65rem;"></i>
                        {{ ucfirst(str_replace('_', ' ', $sv)) }}
                    </span>
                    <div class="text-white-50 small mt-2">{{ $order->created_at->format('d M Y, g:ia') }}</div>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-4">
                <div>
                    <div class="text-white-50" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.5px;">
                        Fee</div>
                    <div class="text-white fw-bold">
                        @if ($isCustom && $fee == 0)
                            TBC
                        @else
                            ₦{{ number_format($fee, 2) }}
                        @endif
                    </div>
                </div>
                @if ($order->parcel_weight)
                    <div>
                        <div class="text-white-50"
                            style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.5px;">Weight</div>
                        <div class="text-white fw-bold">{{ $order->parcel_weight }}kg</div>
                    </div>
                @endif
                @if ($order->distance_km)
                    <div>
                        <div class="text-white-50"
                            style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.5px;">Distance</div>
                        <div class="text-white fw-bold">{{ $order->distance_km }} km</div>
                    </div>
                @endif
                @if ($isReceiverPay)
                    <div>
                        <div class="text-white-50"
                            style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.5px;">Payment</div>
                        <div class="text-white fw-bold">Receiver Pays</div>
                    </div>
                @endif
                @if ($order->rating)
                    <div>
                        <div class="text-white-50"
                            style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.5px;">Customer Rating
                        </div>
                        <div class="text-white fw-bold d-flex align-items-center gap-2">
                            <div class="d-flex align-items-center" style="line-height:1;">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span
                                        style="font-size:1.5rem;color:{{ $i <= $order->rating->rating ? '#f59e0b' : '#ffffff33' }};">★</span>
                                @endfor
                            </div>
                            @if ($order->rating->comment)
                                <div class="text-white small"
                                    style="max-width:260px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    "{{ \Illuminate\Support\Str::limit($order->rating->comment, 80) }}"
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- ══ MAIN LAYOUT ══ --}}
        <div class="row g-3">

            {{-- ── LEFT ── --}}
            <div class="col-lg-8">

                {{-- MAP --}}
                <div class="det-card">
                    @php
                        $mapOrigin = urlencode(
                            $order->sender_street .
                                ', ' .
                                $order->sender_city .
                                ', ' .
                                $order->sender_state .
                                ', Nigeria',
                        );
                        $mapDestination = urlencode(
                            $order->receiver_street .
                                ', ' .
                                $order->receiver_city .
                                ', ' .
                                $order->receiver_state .
                                ', Nigeria',
                        );
                        $mapsApiKey = config('services.google_maps.key');
                    @endphp
                    <div class="det-head">
                        <div class="ico" style="background:#eff6ff;color:#2563eb;">
                            <i class="ti ti-map-pin"></i>
                        </div>
                        <h6>Route Map</h6>
                        <small class="text-muted ms-auto" style="font-size:0.73rem;">Sender → Receiver</small>
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $mapDestination }}&travelmode=driving"
                            target="_blank" class="btn btn-sm fw-semibold d-flex align-items-center gap-1 ms-2"
                            style="background:#1d4ed8;color:white;border-radius:8px;font-size:0.75rem;padding:5px 12px;text-decoration:none;">
                            <i class="ti ti-navigation" style="font-size:0.85rem;"></i>
                            Navigate
                        </a>
                    </div>
                    <div class="map-wrap">
                        <iframe
                            src="https://www.google.com/maps/embed/v1/directions?key={{ $mapsApiKey }}&origin={{ $mapOrigin }}&destination={{ $mapDestination }}&mode=driving"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

                {{-- SENDER & RECEIVER --}}
                <div class="det-card">
                    <div class="det-head">
                        <div class="ico" style="background:#f0fdf4;color:#16a34a;">
                            <i class="ti ti-users"></i>
                        </div>
                        <h6>Sender & Receiver</h6>
                    </div>
                    <div class="det-body">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="contact-card">
                                    <div class="role-tag mb-2" style="color:#f59e0b;">
                                        <i class="ti ti-arrow-up me-1"></i>Sender (Pickup)
                                    </div>
                                    <div class="fw-bold" style="font-size:0.9rem;">
                                        {{ $order->user?->first_name }} {{ $order->user?->last_name }}
                                    </div>
                                    <div class="text-muted small mt-1">
                                        {{ $order->sender_street }}, {{ $order->sender_city }}
                                        @if ($order->sender_state)
                                            , {{ $order->sender_state }}
                                        @endif
                                    </div>
                                    <div class="d-flex flex-column gap-2 mt-2">
                                        @if ($order->user?->phone)
                                            <a href="tel:{{ $order->user->phone }}" class="btn-call btn-call-s">
                                                <i class="ti ti-phone"></i>{{ $order->user->phone }}
                                            </a>
                                        @endif
                                        @if ($order->user?->whatsapp_number)
                                            <a href="https://wa.me/{{ str_replace([' ', '-', '+', '(', ')'], '', $order->user->whatsapp_number) }}"
                                                target="_blank" class="btn-call btn-call-s"
                                                style="background:#f0fdf4;color:#16a34a;">
                                                <i class="ti ti-brand-whatsapp"></i>Whatsapp
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="contact-card">
                                    <div class="role-tag mb-2" style="color:#10b981;">
                                        <i class="ti ti-arrow-down me-1"></i>Receiver (Delivery)
                                    </div>
                                    <div class="fw-bold" style="font-size:0.9rem;">
                                        {{ $order->receiver_first_name }} {{ $order->receiver_last_name }}
                                    </div>
                                    <div class="text-muted small mt-1">
                                        {{ $order->receiver_street }}, {{ $order->receiver_city }}
                                        @if ($order->receiver_state)
                                            , {{ $order->receiver_state }}
                                        @endif
                                    </div>
                                    <div class="d-flex flex-column gap-2 mt-2">
                                        @if ($order->receiver_phone)
                                            <a href="tel:{{ $order->receiver_phone }}" class="btn-call btn-call-r">
                                                <i class="ti ti-phone"></i>{{ $order->receiver_phone }}
                                            </a>
                                        @endif
                                        @if ($order->receiver_whatsapp_number)
                                            <a href="https://wa.me/{{ str_replace([' ', '-', '+', '(', ')'], '', $order->receiver_whatsapp_number) }}"
                                                target="_blank" class="btn-call btn-call-r"
                                                style="background:#f0fdf4;color:#16a34a;">
                                                <i class="ti ti-brand-whatsapp"></i>Whatsapp
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($order->orderDetails?->item_description)
                            <div class="mt-3 p-3 rounded-3" style="background:#fffbeb;border:1px solid #fef3c7;">
                                <div class="fw-semibold small mb-1" style="color:#92400e;">
                                    <i class="ti ti-notes me-1"></i>Special Instructions
                                </div>
                                <p class="mb-0 small" style="color:#374151;line-height:1.6;">
                                    {{ $order->orderDetails->item_description }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- TRACKING TIMELINE --}}
                <div class="det-card">
                    <div class="det-head">
                        <div class="ico" style="background:#eef2ff;color:#4338ca;">
                            <i class="ti ti-timeline"></i>
                        </div>
                        <h6>Tracking History</h6>
                    </div>
                    <div class="det-body">
                        @php
                            $stepKeys = array_keys($steps);
                            $currentIndex = array_search($sv, $stepKeys) ?? 0;
                        @endphp

                        @foreach ($steps as $key => $step)
                            @php
                                $idx = array_search($key, $stepKeys);
                                $state =
                                    $idx < $currentIndex ? 'done' : ($idx === $currentIndex ? 'active' : 'upcoming');
                                $sc = match ($key) {
                                    'pending' => '#9ca3af',
                                    'accepted' => '#3b82f6',
                                    'rider_assigned' => '#f59e0b',
                                    'pickup_confirmed' => '#1e40af',
                                    'in_transit' => '#4338ca',
                                    'delivered' => '#16a34a',
                                    'returned' => '#f97316',
                                    'cancelled' => '#ef4444',
                                    default => '#9ca3af',
                                };
                                $ts = null;
                                if ($step['time_field'] === 'created_at') {
                                    $ts = $order->created_at;
                                } elseif ($step['time_field'] && $order->orderDetails?->{$step['time_field']}) {
                                    $ts = \Carbon\Carbon::parse($order->orderDetails->{$step['time_field']});
                                }
                            @endphp

                            <div class="tl-item">
                                <div class="tl-col">
                                    <div class="tl-dot"
                                        style="background:{{ $state === 'upcoming' ? '#f9fafb' : $sc . '18' }};border-color:{{ $state === 'upcoming' ? '#e5e7eb' : $sc }};color:{{ $state === 'upcoming' ? '#d1d5db' : $sc }};">
                                        @if ($state === 'done')
                                            <i class="ti ti-check"></i>
                                        @elseif ($state === 'active')
                                            <i class="ti {{ $step['icon'] }}"></i>
                                        @else
                                            <i class="ti ti-point" style="font-size:10px;"></i>
                                        @endif
                                    </div>
                                    @if (!$loop->last)
                                        <div class="tl-line"
                                            style="background:{{ $state === 'done' ? $sc . '35' : '#f1f5f9' }};">
                                        </div>
                                    @endif
                                </div>
                                <div class="pb-{{ $loop->last ? '0' : '4' }} pt-1">
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <span class="fw-semibold"
                                            style="font-size:0.875rem;color:{{ $state === 'upcoming' ? '#9ca3af' : 'var(--brand-black)' }};">
                                            {{ $step['label'] }}
                                        </span>
                                        @if ($state === 'active')
                                            <span class="s-pill"
                                                style="background:{{ $sc }}18;color:{{ $sc }};font-size:0.65rem;">Current</span>
                                        @endif
                                    </div>
                                    <div class="text-muted" style="font-size:0.75rem;margin-top:2px;">
                                        {{ $ts ? $ts->format('d M Y, g:ia') : ($state === 'active' ? 'Just now' : 'Pending') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- ── RIGHT ── --}}
            <div class="col-lg-4">

                {{-- ACTIONS --}}
                @if (in_array($sv, ['rider_assigned', 'pickup_confirmed', 'in_transit', 'accepted']))
                    <div class="det-card">
                        <div class="det-head">
                            <div class="ico" style="background:#fff0ef;color:var(--brand-red);">
                                <i class="ti ti-bolt"></i>
                            </div>
                            <h6>Actions</h6>
                        </div>
                        <div class="det-body d-flex flex-column gap-2">

                            @if ($sv === 'rider_assigned')
                                <button wire:click="openPickupModal" class="btn-act btn-pickup">
                                    <span wire:loading.remove wire:target="openPickupModal">
                                        <i class="ti ti-clipboard-check"></i> Confirm Pickup
                                    </span>
                                </button>
                            @endif

                            @if (in_array($sv, ['rider_assigned', 'pickup_confirmed']))
                                <button wire:click="openTransitModal" class="btn-act btn-transit">
                                    <span wire:loading.remove wire:target="openTransitModal">
                                        <i class="ti ti-truck"></i> Start Delivery
                                    </span>
                                </button>
                            @endif

                            @if (in_array($sv, ['rider_assigned', 'pickup_confirmed', 'in_transit']))
                                <button wire:click="openDeliverModal" class="btn-act btn-deliver">
                                    <i class="ti ti-circle-check"></i> Mark as Delivered
                                </button>
                            @endif

                            @if ($sv === 'in_transit')
                                <button wire:click="openReturnModal" class="btn-act btn-return">
                                    <i class="ti ti-arrow-back"></i> Mark as Returned
                                </button>
                            @endif

                            @if (in_array($sv, ['rider_assigned', 'accepted']))
                                <button wire:click="openRejectModal" class="btn-act btn-reject">
                                    <i class="ti ti-x"></i> Reject This Order
                                </button>
                            @endif

                        </div>
                    </div>
                @endif

                {{-- PAYMENT INFO --}}
                <div class="det-card p-2">
                    <div class="det-head">
                        <div class="ico" style="background:#f0fdf4;color:#16a34a;">
                            <i class="ti ti-currency-naira"></i>
                        </div>
                        <h6>Payment</h6>
                        @if ($isReceiverPay && $payStatus !== 'paid')
                            <span class="ms-auto s-pill" style="background:#fef2f2;color:#dc2626;font-size:0.68rem;">
                                <i class="ti ti-alert-circle" style="font-size:0.65rem;"></i> Receiver Pays
                            </span>
                        @endif
                    </div>
                    <div class="det-body" style="padding-top:0;padding-bottom:0;">
                        <div class="irow">
                            <span class="lbl">Delivery Fee</span>
                            <span class="val" style="color:var(--brand-red);font-size:0.95rem;font-weight:800;">
                                @if ($isCustom && $fee == 0)
                                    TBC
                                @else
                                    ₦{{ number_format($fee, 2) }}
                                @endif
                            </span>
                        </div>
                        @if ($isReceiverPay)
                            <div class="irow">
                                <span class="lbl">Method</span>
                                <span class="val">
                                    <span class="d-flex align-items-center gap-1 justify-content-end">
                                        <i class="ti ti-cash" style="color:#dc2626;"></i>
                                        <span style="color:#dc2626;">Receiver Pays</span>
                                    </span>
                                </span>
                            </div>
                            <div class="irow">
                                <span class="lbl">Status</span>
                                <span class="val">
                                    <span class="s-pill"
                                        style="background:{{ $payStatus === 'paid' ? '#f0fdf4' : '#fef2f2' }};color:{{ $payStatus === 'paid' ? '#166534' : '#991b1b' }};">
                                        <i class="ti {{ $payStatus === 'paid' ? 'ti-check' : 'ti-clock' }}"
                                            style="font-size:0.6rem;"></i>
                                        {{ $payStatus === 'paid' ? 'Paid' : 'Unpaid' }}
                                    </span>
                                </span>
                            </div>
                        @endif
                        @if ($isReceiverPay && $outstanding > 0)
                            <div class="irow">
                                <span class="lbl">Amount to Collect</span>
                                <span class="val fw-bold" style="color:#dc2626;font-size:0.95rem;">
                                    ₦{{ number_format($outstanding, 2) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- EARNING CARD --}}
                @if ($sv === 'delivered')
                    <div class="det-card p-2">
                        <div class="det-head">
                            <div class="ico" style="background:#f0fdf4;color:#16a34a;">
                                <i class="ti ti-wallet"></i>
                            </div>
                            <h6>Your Earning</h6>
                        </div>
                        <div class="det-body" style="padding-top:0;padding-bottom:0;">
                            @if ($earning)
                                @php
                                    $earnStatus =
                                        $earning->status instanceof \BackedEnum
                                            ? $earning->status->value
                                            : (string) $earning->status;
                                    $earnConfig = match ($earnStatus) {
                                        'success' => [
                                            'bg' => '#f0fdf4',
                                            'border' => '#bbf7d0',
                                            'color' => '#166534',
                                            'icon' => 'ti-check-circle',
                                            'label' => 'Credited to Wallet',
                                        ],
                                        'pending' => [
                                            'bg' => '#fffbeb',
                                            'border' => '#fde68a',
                                            'color' => '#92400e',
                                            'icon' => 'ti-clock',
                                            'label' => 'Pending Approval',
                                        ],
                                        'failed' => [
                                            'bg' => '#fef2f2',
                                            'border' => '#fecaca',
                                            'color' => '#991b1b',
                                            'icon' => 'ti-x-circle',
                                            'label' => 'Rejected',
                                        ],
                                        default => [
                                            'bg' => '#f9fafb',
                                            'border' => '#e5e7eb',
                                            'color' => '#374151',
                                            'icon' => 'ti-circle',
                                            'label' => ucfirst($earnStatus),
                                        ],
                                    };
                                @endphp
                                <div class="irow">
                                    <span class="lbl">Commission</span>
                                    <span class="val" style="color:#16a34a;font-size:0.95rem;font-weight:800;">
                                        ₦{{ number_format($earning->amount, 2) }}
                                    </span>
                                </div>
                                <div class="irow" style="border-bottom:none;padding-bottom:12px;">
                                    <span class="lbl">Status</span>
                                    <span class="val">
                                        <span class="s-pill"
                                            style="background:{{ $earnConfig['bg'] }};color:{{ $earnConfig['color'] }};border:1px solid {{ $earnConfig['border'] }};">
                                            <i class="ti {{ $earnConfig['icon'] }}" style="font-size:0.65rem;"></i>
                                            {{ $earnConfig['label'] }}
                                        </span>
                                    </span>
                                </div>
                                @if ($earnStatus === 'pending')
                                    <div class="px-0 pb-3">
                                        <div class="rounded-3 p-3"
                                            style="background:#fffbeb;border:1px solid #fde68a;">
                                            <p class="small mb-0" style="color:#92400e;line-height:1.6;">
                                                <i class="ti ti-info-circle me-1"></i>
                                                Your earning is awaiting admin approval. Once approved it will be
                                                credited to your wallet automatically.
                                            </p>
                                        </div>
                                    </div>
                                @elseif ($earnStatus === 'success')
                                    <div class="px-0 pb-3">
                                        <div class="rounded-3 p-3"
                                            style="background:#f0fdf4;border:1px solid #bbf7d0;">
                                            <p class="small mb-0" style="color:#166534;line-height:1.6;">
                                                <i class="ti ti-circle-check me-1"></i>
                                                ₦{{ number_format($earning->amount, 2) }} has been added to your
                                                wallet.
                                            </p>
                                        </div>
                                    </div>
                                @elseif ($earnStatus === 'failed')
                                    <div class="px-0 pb-3">
                                        <div class="rounded-3 p-3"
                                            style="background:#fef2f2;border:1px solid #fecaca;">
                                            <p class="small mb-0" style="color:#991b1b;line-height:1.6;">
                                                <i class="ti ti-alert-circle me-1"></i>
                                                This earning was not approved. Contact your supervisor for more
                                                information.
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="irow" style="border-bottom:none;">
                                    <span class="lbl">Status</span>
                                    <span class="val text-muted">Not yet calculated</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- ITEM PHOTO --}}
                <div class="det-card">
                    <div class="det-head">
                        <div class="ico" style="background:#f0fdf4;color:#16a34a;">
                            <i class="ti ti-photo"></i>
                        </div>
                        <h6>Item Photo</h6>
                        @if ($order->orderDetails?->item_image)
                            <small class="text-muted ms-auto" style="font-size:0.72rem;">Tap to enlarge</small>
                        @endif
                    </div>
                    <div class="det-body" style="padding:12px;">
                        @if ($order->orderDetails?->item_image)
                            <div class="img-wrap" onclick="openLb('{{ $order->orderDetails->image_url }}')">
                                <img src="{{ $order->orderDetails->image_url }}"
                                    alt="{{ $order->orderDetails->item_name }}">
                            </div>
                        @else
                            <div class="img-empty"><i class="ti ti-package"></i></div>
                        @endif
                    </div>
                </div>

                {{-- ORDER INFO --}}
                <div class="det-card p-2">
                    <div class="det-head">
                        <div class="ico" style="background:#f9fafb;color:#374151;">
                            <i class="ti ti-clipboard-list"></i>
                        </div>
                        <h6>Order Info</h6>
                    </div>
                    <div class="det-body" style="padding-top:0;padding-bottom:0;">
                        <div class="irow">
                            <span class="lbl">Item</span>
                            <span class="val">{{ $order->orderDetails?->item_name ?? 'N/A' }}</span>
                        </div>
                        @if ($order->orderDetails?->category)
                            <div class="irow">
                                <span class="lbl">Category</span>
                                <span class="val">{{ $order->orderDetails->category->name }}</span>
                            </div>
                        @endif
                        @if ($order->parcel_weight)
                            <div class="irow">
                                <span class="lbl">Weight</span>
                                <span class="val">{{ $order->parcel_weight }}kg</span>
                            </div>
                        @endif
                        <div class="irow">
                            <span class="lbl">Vehicle</span>
                            <span class="val">
                                {{ ucfirst(is_object($order->vehicle_type) ? $order->vehicle_type->value : $order->vehicle_type ?? 'N/A') }}
                            </span>
                        </div>
                        @if ($order->distance_km)
                            <div class="irow">
                                <span class="lbl">Distance</span>
                                <span class="val">{{ $order->distance_km }} km</span>
                            </div>
                        @endif
                        <div class="irow">
                            <span class="lbl">Date</span>
                            <span class="val">{{ $order->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- LIGHTBOX --}}
    <div id="lightbox" class="lightbox" onclick="closeLb()">
        <button class="lb-x" onclick="closeLb()"><i class="ti ti-x"></i></button>
        <img id="lb-img" src="" alt="">
    </div>

    {{-- PICKUP CONFIRM MODAL --}}
    @if ($showPickupModal)
        <div class="m-bg" wire:click.self="closePickupModal">
            <div class="m-box">
                <h5>Confirm Pickup</h5>
                <p>Confirm you have picked up this order from the sender.</p>
                <div class="d-flex gap-2 justify-content-end">
                    <button wire:click="closePickupModal"
                        class="btn btn-sm btn-outline-secondary rounded-3 px-4">Cancel</button>
                    <button wire:click="markPickupConfirmed" class="btn btn-sm rounded-3 px-4 fw-bold"
                        style="background:#0369a1;color:white;" wire:loading.attr="disabled"
                        wire:target="markPickupConfirmed">
                        <span wire:loading.remove wire:target="markPickupConfirmed">
                            <i class="ti ti-clipboard-check me-1"></i>Yes, Picked Up
                        </span>
                        <span wire:loading wire:target="markPickupConfirmed">
                            <span class="spinner-border spinner-border-sm me-1"></span>Confirming...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- IN TRANSIT CONFIRM MODAL --}}
    @if ($showTransitModal)
        <div class="m-bg" wire:click.self="closeTransitModal">
            <div class="m-box">
                <h5>Start Transit</h5>
                <p>Mark this order as <strong>In Transit</strong> now?</p>
                <div class="d-flex gap-2 justify-content-end">
                    <button wire:click="closeTransitModal"
                        class="btn btn-sm btn-outline-secondary rounded-3 px-4">Cancel</button>
                    <button wire:click="markInTransit" class="btn btn-sm rounded-3 px-4 fw-bold"
                        style="background:#4338ca;color:white;" wire:loading.attr="disabled"
                        wire:target="markInTransit">
                        <span wire:loading.remove wire:target="markInTransit">
                            <i class="ti ti-truck me-1"></i>Yes, In Transit
                        </span>
                        <span wire:loading wire:target="markInTransit">
                            <span class="spinner-border spinner-border-sm me-1"></span>Starting...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- DELIVER MODAL --}}
    @if ($showDeliverModal)
        <div class="m-bg" wire:click.self="closeDeliverModal">
            <div class="m-box">
                <h5>Confirm Delivery</h5>
                <p>Mark this order as <strong>Delivered</strong>? This cannot be undone.</p>
                @if ($isReceiverPay && $outstanding > 0)
                    <div class="mb-3 p-3 rounded-3" style="background:#fef2f2;border:1px solid #fecaca;">
                        <div class="fw-semibold small mb-1" style="color:#dc2626;">
                            <i class="ti ti-alert-circle me-1"></i>Receiver Pays Reminder
                        </div>
                        <p class="mb-0 small" style="color:#374151;">
                            Confirm you have collected <strong
                                style="color:#dc2626;">₦{{ number_format($outstanding, 2) }}</strong> from the
                            receiver before marking as delivered.
                        </p>
                    </div>
                @endif
                <div class="d-flex gap-2 justify-content-end">
                    <button wire:click="closeDeliverModal"
                        class="btn btn-sm btn-outline-secondary rounded-3 px-4">Cancel</button>
                    <button wire:click="confirmDelivery" class="btn btn-sm rounded-3 px-4 fw-bold"
                        style="background:#16a34a;color:white;" wire:loading.attr="disabled"
                        wire:target="confirmDelivery">
                        <span wire:loading.remove wire:target="confirmDelivery">
                            <i class="ti ti-circle-check me-1"></i>Yes, Delivered
                        </span>
                        <span wire:loading wire:target="confirmDelivery">
                            <span class="spinner-border spinner-border-sm me-1"></span>Saving...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- REJECT MODAL --}}
    @if ($showRejectModal)
        <div class="m-bg" wire:click.self="closeRejectModal">
            <div class="m-box">
                <h5>Reject Order</h5>
                <p>This unassigns you from the order. Admin will reassign to another rider.</p>
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Reason <span class="text-danger">*</span></label>
                    <textarea wire:model="rejectReason" class="form-control rounded-3" rows="3"
                        placeholder="e.g. Vehicle breakdown, outside delivery area..."></textarea>
                    @error('rejectReason')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex gap-2 justify-content-end">
                    <button wire:click="closeRejectModal"
                        class="btn btn-sm btn-outline-secondary rounded-3 px-4">Cancel</button>
                    <button wire:click="rejectOrder" class="btn btn-sm rounded-3 px-4 fw-bold"
                        style="background:#991b1b;color:white;" wire:loading.attr="disabled"
                        wire:target="rejectOrder">
                        <span wire:loading.remove wire:target="rejectOrder">
                            <i class="ti ti-x me-1"></i>Reject Order
                        </span>
                        <span wire:loading wire:target="rejectOrder">
                            <span class="spinner-border spinner-border-sm me-1"></span>Rejecting...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- RETURN MODAL --}}
    @if ($showReturnModal)
        <div class="m-bg" wire:click.self="closeReturnModal">
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
                    <button wire:click="closeReturnModal"
                        class="btn btn-sm btn-outline-secondary rounded-3 px-4">Cancel</button>
                    <button wire:click="confirmReturn" class="btn btn-sm rounded-3 px-4 fw-bold"
                        style="background:#9a3412;color:white;" wire:loading.attr="disabled"
                        wire:target="confirmReturn">
                        <span wire:loading.remove wire:target="confirmReturn">
                            <i class="ti ti-arrow-back me-1"></i>Mark Returned
                        </span>
                        <span wire:loading wire:target="confirmReturn">
                            <span class="spinner-border spinner-border-sm me-1"></span>Saving...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @push('scripts')
        <script>
            function openLb(src) {
                document.getElementById('lb-img').src = src;
                document.getElementById('lightbox').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }

            function closeLb() {
                document.getElementById('lightbox').style.display = 'none';
                document.body.style.overflow = '';
            }
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') {
                    closeLb();
                    document.body.style.overflow = '';
                }
            });
        </script>
    @endpush
</div>
