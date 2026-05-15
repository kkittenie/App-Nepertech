@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-1">Dashboard</h1>
                <p class="text-muted">Welcome back, {{ auth()->user()->name }}</p>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">

      
        <div class="col-lg-3 col-12">
            <div class="card p-4 bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-2">
                <div class="d-flex gap-3">
                    <div class="icon-shape icon-md bg-primary text-white rounded-2">
                        <i class="ti ti-report-analytics fs-4"></i>
                    </div>
                    <div>
                        <h2 class="mb-3 fs-6">Total Sales</h2>
                        <h3 class="fw-bold mb-0">${{ number_format($stats['total_sales'] ?? 25000) }}</h3>
                        <p class="text-primary mb-0 small">+5% since last month</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Purchase --}}
        <div class="col-lg-3 col-12">
            <div class="card p-4 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-2">
                <div class="d-flex gap-3">
                    <div class="icon-shape icon-md bg-success text-white rounded-2">
                        <i class="ti ti-repeat fs-4"></i>
                    </div>
                    <div>
                        <h2 class="mb-3 fs-6">Total Purchase</h2>
                        <h3 class="fw-bold mb-0">${{ number_format($stats['total_purchase'] ?? 18000) }}</h3>
                        <p class="text-success mb-0 small">+22% since last month</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Expenses --}}
        <div class="col-lg-3 col-12">
            <div class="card p-4 bg-info bg-opacity-10 border border-info border-opacity-25 rounded-2">
                <div class="d-flex gap-3">
                    <div class="icon-shape icon-md bg-info text-white rounded-2">
                        <i class="ti ti-currency-dollar fs-4"></i>
                    </div>
                    <div>
                        <h2 class="mb-3 fs-6">Total Expenses</h2>
                        <h3 class="fw-bold mb-0">${{ number_format($stats['total_expenses'] ?? 9000) }}</h3>
                        <p class="text-info mb-0 small">+10% since last month</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Invoice Due --}}
        <div class="col-lg-3 col-12">
            <div class="card p-4 bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded-2">
                <div class="d-flex gap-3">
                    <div class="icon-shape icon-md bg-warning text-white rounded-2">
                        <i class="ti ti-notes fs-4"></i>
                    </div>
                    <div>
                        <h2 class="mb-3 fs-6">Invoice Due</h2>
                        <h3 class="fw-bold mb-0">${{ number_format($stats['invoice_due'] ?? 25000) }}</h3>
                        <p class="text-warning mb-0 small">+35% since last month</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- =====================
         ROW 2 — Profit / Payment / Expenses summary cards
    ===================== --}}
    <div class="row g-3 mb-3">

        {{-- Total Profit --}}
        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between border-bottom pb-5 mb-3">
                        <div>
                            <h3 class="fw-bold h4">${{ number_format($stats['total_profit'] ?? 25458) }}</h3>
                            <span>Total Profit</span>
                        </div>
                        <div>
                            <i class="ti ti-layers-subtract fs-1 text-primary"></i>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center small">
                        <div class="text-muted">
                            <span class="text-success">+35%</span> vs Last Month
                        </div>
                        <div>
                            <a href="#" class="link-primary text-decoration-underline">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Payment Returns --}}
        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between border-bottom pb-5 mb-3">
                        <div>
                            <h3 class="fw-bold h4">${{ number_format($stats['total_payment_returns'] ?? 45458) }}</h3>
                            <span>Total Payment Returns</span>
                        </div>
                        <div>
                            <i class="ti ti-credit-card fs-1 text-danger"></i>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center small">
                        <div class="text-muted">
                            <span class="text-danger">-20%</span> vs Last Month
                        </div>
                        <div>
                            <a href="#" class="link-primary text-decoration-underline">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Expenses --}}
        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between border-bottom pb-5 mb-3">
                        <div>
                            <h3 class="fw-bold h4">${{ number_format($stats['total_expenses_detail'] ?? 34458) }}</h3>
                            <span>Total Expenses</span>
                        </div>
                        <div>
                            <i class="ti ti-cash-banknote fs-1 text-warning"></i>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center small">
                        <div class="text-muted">
                            <span class="text-warning">-20%</span> vs Last Month
                        </div>
                        <div>
                            <a href="#" class="link-primary text-decoration-underline">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- =====================
         ROW 3 — Charts
    ===================== --}}
    <div class="row g-3 mb-3">

        {{-- Sales vs Purchase Chart --}}
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent px-4 py-3">
                    <h3 class="h5 mb-0">Sales vs Purchase</h3>
                    <div>
                        <select class="form-select form-select-sm">
                            <option selected>This Year</option>
                            <option>This Month</option>
                            <option>This Week</option>
                        </select>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div id="salesPurchaseChart"></div>
                </div>
            </div>
        </div>

        {{-- Overall Information --}}
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent px-4 py-3">
                    <h3 class="h5 mb-0">Overall Information</h3>
                    <div>
                        <select class="form-select form-select-sm">
                            <option selected>Last 6 Months</option>
                            <option>This Month</option>
                            <option>This Week</option>
                        </select>
                    </div>
                </div>
                <div class="card-body p-4">
                    <h3 class="h6">Customers Overview</h3>
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div id="customerChart"></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-6 border-end">
                                    <div class="text-center">
                                        <h2 class="mb-1">5.5K</h2>
                                        <p class="text-success mb-2">First Time</p>
                                        <span class="badge bg-success">
                                            <i class="ti ti-arrow-up-left me-1"></i>25%
                                        </span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <h2 class="mb-1">3.5K</h2>
                                        <p class="text-warning mb-2">Return</p>
                                        <span class="badge bg-success d-inline-flex align-items-center">
                                            <i class="ti ti-arrow-up-left me-1"></i>21%
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center border-top mt-4 pt-4">
                        <div class="col-4 border-end">
                            <h3 class="fw-bold mb-2">6987</h3>
                            <small class="text-secondary">Suppliers</small>
                        </div>
                        <div class="col-4 border-end">
                            <h3 class="fw-bold mb-2">4896</h3>
                            <small class="text-secondary">Customers</small>
                        </div>
                        <div class="col-4">
                            <h3 class="fw-bold mb-2">487</h3>
                            <small class="text-secondary">Orders</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- =====================
         ROW 4 — Top Selling / Low Stock / Recent Sales
    ===================== --}}
    <div class="row g-3">

        {{-- Top Selling Products --}}
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center px-4 py-3">
                    <h4 class="mb-0 h5">Top Selling Products</h4>
                    <button class="btn btn-sm btn-outline-secondary">
                        <i class="ti ti-calendar"></i> Today
                    </button>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($topSellingProducts ?? [] as $product)
                    <li class="list-group-item d-flex align-items-center gap-3">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" class="rounded" width="48">
                        @else
                            <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                 style="width:48px;height:48px">
                                <i class="ti ti-package text-secondary"></i>
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <p class="mb-1">{{ $product->name }}</p>
                            <div class="d-flex align-items-center gap-2 text-muted">
                                <small class="fw-semibold">${{ number_format($product->price, 0) }}</small>
                                <small>•</small>
                                <small>{{ number_format($product->total_sold ?? 0) }} Units</small>
                            </div>
                        </div>
                        <span class="badge bg-{{ $product->badge_color ?? 'primary' }}-subtle text-{{ $product->badge_color ?? 'primary' }} border border-{{ $product->badge_color ?? 'primary' }}">
                            {{ $product->percentage ?? '0' }}%
                        </span>
                    </li>
                    @empty
                    {{-- Static fallback matching the template --}}
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <img src="{{ asset('assets/images/product-2.png') }}" class="rounded" width="48">
                        <div class="flex-grow-1">
                            <p class="mb-1">Wireless Earphones</p>
                            <div class="d-flex align-items-center gap-2 text-muted">
                                <small class="fw-semibold">$89</small>
                                <small>•</small>
                                <small>1,250 Units</small>
                            </div>
                        </div>
                        <span class="badge bg-danger-subtle text-danger border border-danger">18%</span>
                    </li>
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <img src="{{ asset('assets/images/product-1.png') }}" class="rounded" width="48">
                        <div class="flex-grow-1">
                            <p class="mb-1">Gaming Joy Stick</p>
                            <div class="d-flex align-items-center gap-2 text-muted">
                                <small class="fw-semibold">$49</small>
                                <small>•</small>
                                <small>5,420 Units</small>
                            </div>
                        </div>
                        <span class="badge bg-primary-subtle text-primary border border-primary">32%</span>
                    </li>
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <img src="{{ asset('assets/images/product-3.png') }}" class="rounded" width="48">
                        <div class="flex-grow-1">
                            <p class="mb-1">Smart Watch Pro</p>
                            <div class="d-flex align-items-center gap-2 text-muted">
                                <small class="fw-semibold">$98</small>
                                <small>•</small>
                                <small>862 Units</small>
                            </div>
                        </div>
                        <span class="badge bg-info-subtle text-info border border-info">22%</span>
                    </li>
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <img src="{{ asset('assets/images/product-4.png') }}" class="rounded" width="48">
                        <div class="flex-grow-1">
                            <p class="mb-1">USB-C Fast Charger</p>
                            <div class="d-flex align-items-center gap-2 text-muted">
                                <small class="fw-semibold">$35</small>
                                <small>•</small>
                                <small>3,200 Units</small>
                            </div>
                        </div>
                        <span class="badge bg-success-subtle text-success border border-success">28%</span>
                    </li>
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <img src="{{ asset('assets/images/product-5.png') }}" class="rounded" width="48">
                        <div class="flex-grow-1">
                            <p class="mb-1">Portable Bluetooth Speaker</p>
                            <div class="d-flex align-items-center gap-2 text-muted">
                                <small class="fw-semibold">$65</small>
                                <small>•</small>
                                <small>2,890 Units</small>
                            </div>
                        </div>
                        <span class="badge bg-warning-subtle text-warning border border-warning">25%</span>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- Low Stock Products --}}
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center px-4 py-3">
                    <h4 class="mb-0 h5">Low Stock Products</h4>
                    <a href="{{ route('products.index') }}"
                       class="small text-primary text-decoration-underline">View All</a>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($lowStockProducts ?? [] as $product)
                    <li class="list-group-item d-flex align-items-center gap-3">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" class="rounded" width="48">
                        @else
                            <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                 style="width:48px;height:48px">
                                <i class="ti ti-package text-secondary"></i>
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <p class="mb-1">{{ $product->name }}</p>
                            <small>ID: #{{ $product->sku }}</small>
                        </div>
                        <div class="d-flex flex-column gap-0 align-items-center">
                            <span class="fw-semibold text-primary">{{ str_pad($product->stock, 2, '0', STR_PAD_LEFT) }}</span>
                            <small class="text-muted">In Stock</small>
                        </div>
                    </li>
                    @empty
                    {{-- Static fallback --}}
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <img src="{{ asset('assets/images/product-8.png') }}" class="rounded" width="48">
                        <div class="flex-grow-1">
                            <p class="mb-1">Wireless Headphones</p>
                            <small>ID: #554433</small>
                        </div>
                        <div class="d-flex flex-column gap-0 align-items-center">
                            <span class="fw-semibold text-primary">06</span>
                            <small class="text-muted">In Stock</small>
                        </div>
                    </li>
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <img src="{{ asset('assets/images/product-4.png') }}" class="rounded" width="48">
                        <div class="flex-grow-1">
                            <p class="mb-1">USB-C Cable Pack</p>
                            <small>ID: #887766</small>
                        </div>
                        <div class="d-flex flex-column gap-0 align-items-center">
                            <span class="fw-semibold text-primary">09</span>
                            <small class="text-muted">In Stock</small>
                        </div>
                    </li>
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <img src="{{ asset('assets/images/product-10.png') }}" class="rounded" width="48">
                        <div class="flex-grow-1">
                            <p class="mb-1">Phone Screen Protector</p>
                            <small>ID: #332211</small>
                        </div>
                        <div class="d-flex flex-column gap-0 align-items-center">
                            <span class="fw-semibold text-primary">03</span>
                            <small class="text-muted">In Stock</small>
                        </div>
                    </li>
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <img src="{{ asset('assets/images/product-4.png') }}" class="rounded" width="48">
                        <div class="flex-grow-1">
                            <p class="mb-1">Portable Charger 20000mAh</p>
                            <small>ID: #998877</small>
                        </div>
                        <div class="d-flex flex-column gap-0 align-items-center">
                            <span class="fw-semibold text-primary">07</span>
                            <small class="text-muted">In Stock</small>
                        </div>
                    </li>
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <img src="{{ asset('assets/images/product-6.png') }}" class="rounded" width="48">
                        <div class="flex-grow-1">
                            <p class="mb-1">Mechanical Keyboard RGB</p>
                            <small>ID: #665544</small>
                        </div>
                        <div class="d-flex flex-column gap-0 align-items-center">
                            <span class="fw-semibold text-primary">02</span>
                            <small class="text-muted">In Stock</small>
                        </div>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- Recent Sales --}}
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center px-4 py-3">
                    <h4 class="mb-0 h5">Recent Sales</h4>
                    <button class="btn btn-sm btn-outline-secondary">
                        <i class="ti ti-calendar-event"></i> Weekly
                    </button>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($recentSales ?? [] as $sale)
                    <li class="list-group-item d-flex align-items-center gap-3">
                        @if($sale->product->image ?? false)
                            <img src="{{ Storage::url($sale->product->image) }}" class="rounded" width="48">
                        @else
                            <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                 style="width:48px;height:48px">
                                <i class="ti ti-package text-secondary"></i>
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <p class="mb-1">{{ $sale->product->name ?? '-' }}</p>
                            <div class="d-flex align-items-center gap-2 text-muted">
                                <small class="fw-semibold">{{ $sale->category ?? '-' }}</small>
                                <small>•</small>
                                <small>${{ number_format($sale->amount ?? 0) }}</small>
                            </div>
                        </div>
                        <span class="badge bg-{{ $sale->status_badge }}-subtle text-{{ $sale->status_badge }}">
                            {{ $sale->status_label }}
                        </span>
                    </li>
                    @empty
                    {{-- Static fallback --}}
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <img src="{{ asset('assets/images/product-7.png') }}" class="rounded" width="48">
                        <div class="flex-grow-1">
                            <p class="mb-1">MacBook Pro 16"</p>
                            <div class="d-flex align-items-center gap-2 text-muted">
                                <small class="fw-semibold">Computers</small>
                                <small>•</small>
                                <small>$2,499</small>
                            </div>
                        </div>
                        <span class="badge bg-success-subtle text-success">Completed</span>
                    </li>
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <img src="{{ asset('assets/images/product-9.png') }}" class="rounded" width="48">
                        <div class="flex-grow-1">
                            <p class="mb-1">AirPods Pro Max</p>
                            <div class="d-flex align-items-center gap-2 text-muted">
                                <small class="fw-semibold">Audio</small>
                                <small>•</small>
                                <small>$549</small>
                            </div>
                        </div>
                        <span class="badge bg-primary-subtle text-primary">Processing</span>
                    </li>
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <img src="{{ asset('assets/images/product-8.png') }}" class="rounded" width="48">
                        <div class="flex-grow-1">
                            <p class="mb-1">iPad Air 11"</p>
                            <div class="d-flex align-items-center gap-2 text-muted">
                                <small class="fw-semibold">Tablets</small>
                                <small>•</small>
                                <small>$799</small>
                            </div>
                        </div>
                        <span class="badge bg-success-subtle text-success">Completed</span>
                    </li>
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <img src="{{ asset('assets/images/product-3.png') }}" class="rounded" width="48">
                        <div class="flex-grow-1">
                            <p class="mb-1">Apple Watch Ultra</p>
                            <div class="d-flex align-items-center gap-2 text-muted">
                                <small class="fw-semibold">Wearables</small>
                                <small>•</small>
                                <small>$799</small>
                            </div>
                        </div>
                        <span class="badge bg-warning-subtle text-warning">Pending</span>
                    </li>
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <img src="{{ asset('assets/images/product-6.png') }}" class="rounded" width="48">
                        <div class="flex-grow-1">
                            <p class="mb-1">Magic Keyboard</p>
                            <div class="d-flex align-items-center gap-2 text-muted">
                                <small class="fw-semibold">Accessories</small>
                                <small>•</small>
                                <small>$299</small>
                            </div>
                        </div>
                        <span class="badge bg-danger-subtle text-danger">Cancelled</span>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>

    {{-- Footer --}}
    <div class="row">
        <div class="col-12">
            <footer class="text-center py-2 mt-6 text-secondary">
                <p class="mb-0">
                    Copyright &copy; {{ date('Y') }} InApp Inventory Dashboard.
                    Developed by <a href="https://codescandy.com/" target="_blank" class="text-primary">CodesCandy</a>
                    &bull;
                    Distributed by <a href="https://themewagon.com/" target="_blank" class="text-primary">ThemeWagon</a>
                </p>
            </footer>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // ── Sales vs Purchase Chart ──────────────────────────────
    var salesPurchaseOptions = {
        series: [
            { name: 'Sales',    data: [30, 45, 35, 50, 49, 60, 70, 91, 80, 65, 75, 85] },
            { name: 'Purchase', data: [20, 35, 25, 40, 38, 45, 55, 72, 65, 50, 60, 70] }
        ],
        colors: ['#E66239', '#3B82F6'],
        chart: {
            type: 'bar',
            height: 280,
            toolbar: { show: false }
        },
        plotOptions: {
            bar: { borderRadius: 4, columnWidth: '55%' }
        },
        dataLabels: { enabled: false },
        xaxis: {
            categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            labels: { style: { fontSize: '11px', fontFamily: 'Poppins, sans-serif' } },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: {
            labels: {
                style: { fontSize: '11px', fontFamily: 'Poppins, sans-serif' },
                formatter: val => '$' + val + 'K'
            }
        },
        legend: { position: 'top', fontFamily: 'Poppins, sans-serif', fontSize: '12px' },
        grid: { borderColor: '#f0f0f0', strokeDashArray: 4 },
        tooltip: {
            y: { formatter: val => '$' + val + 'K' },
            style: { fontFamily: 'Poppins, sans-serif' }
        }
    };
    new ApexCharts(document.querySelector("#salesPurchaseChart"), salesPurchaseOptions).render();

    // ── Customer Donut Chart ──────────────────────────────────
    var customerOptions = {
        series: [61, 39],
        colors: ['#22c55e', '#f59e0b'],
        chart: { type: 'donut', height: 160 },
        labels: ['First Time', 'Return'],
        dataLabels: { enabled: false },
        legend: { show: false },
        plotOptions: {
            pie: {
                donut: { size: '70%' }
            }
        }
    };
    new ApexCharts(document.querySelector("#customerChart"), customerOptions).render();
</script>
@endpush