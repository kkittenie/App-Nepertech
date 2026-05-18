@extends('layouts.admin')
@section('title', 'Laporan')

@section('content')

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan & Analitik</h1>
            <p class="page-subtitle">Ringkasan data produk dan kategori</p>
        </div>
        <div class="page-header-actions">
            <span class="header-date">
                <i class="ti ti-calendar"></i>
                {{ now()->format('d M Y') }}
            </span>
        </div>
    </div>

    {{-- ── ROW 1: Quick Stats ── --}}
    <div class="stats-grid stats-grid--6">

        <div class="stat-card stat-card--primary stat-card--compact">
            <div class="stat-card-icon"><i class="ti ti-box"></i></div>
            <div class="stat-card-body">
                <span class="stat-card-label">Produk</span>
                <h3 class="stat-card-value">{{ number_format($totalProducts) }}</h3>
            </div>
        </div>

        <div class="stat-card stat-card--accent stat-card--compact">
            <div class="stat-card-icon"><i class="ti ti-category"></i></div>
            <div class="stat-card-body">
                <span class="stat-card-label">Kategori</span>
                <h3 class="stat-card-value">{{ number_format($totalCategories) }}</h3>
            </div>
        </div>

        <div class="stat-card stat-card--teal stat-card--compact">
            <div class="stat-card-icon"><i class="ti ti-users"></i></div>
            <div class="stat-card-body">
                <span class="stat-card-label">Users</span>
                <h3 class="stat-card-value">{{ number_format($totalUsers) }}</h3>
            </div>
        </div>

        <div class="stat-card stat-card--gold stat-card--compact">
            <div class="stat-card-icon"><i class="ti ti-currency-dollar"></i></div>
            <div class="stat-card-body">
                <span class="stat-card-label">Nilai Katalog</span>
                <h3 class="stat-card-value">Rp {{ number_format($catalogValue, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="stat-card stat-card--primary stat-card--compact">
            <div class="stat-card-icon"><i class="ti ti-arrow-bar-up"></i></div>
            <div class="stat-card-body">
                <span class="stat-card-label">Harga Tertinggi</span>
                <h3 class="stat-card-value">Rp {{ number_format($maxPrice, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="stat-card stat-card--accent stat-card--compact">
            <div class="stat-card-icon"><i class="ti ti-chart-line"></i></div>
            <div class="stat-card-body">
                <span class="stat-card-label">Rata-rata Harga</span>
                <h3 class="stat-card-value">Rp {{ number_format($avgPrice, 0, ',', '.') }}</h3>
            </div>
        </div>

    </div>

    {{-- ── ROW 2: Charts ── --}}
    <div class="charts-grid">

        {{-- Monthly Products --}}
        <div class="admin-card chart-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="ti ti-chart-area"></i>
                    Produk Ditambahkan per Bulan
                </h3>
                <span class="admin-card-badge">{{ date('Y') }}</span>
            </div>
            <div class="admin-card-body">
                <div id="reportMonthlyChart"></div>
            </div>
        </div>

        {{-- Monthly Value --}}
        <div class="admin-card chart-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="ti ti-chart-bar"></i>
                    Nilai Katalog per Bulan
                </h3>
                <span class="admin-card-badge">{{ date('Y') }}</span>
            </div>
            <div class="admin-card-body">
                <div id="reportValueChart"></div>
            </div>
        </div>

    </div>

    {{-- ── ROW 3: Category Breakdown + Product Table ── --}}
    <div class="report-detail-grid">

        {{-- Category Breakdown --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="ti ti-chart-donut-3"></i>
                    Breakdown Kategori
                </h3>
            </div>
            <div class="admin-card-body">
                @if($categoryBreakdown->count() > 0)
                    <div id="reportCategoryChart"></div>
                    <div class="category-stats-list">
                        @foreach($categoryBreakdown as $cat)
                        <div class="category-stat-row">
                            <div class="category-stat-left">
                                <span class="legend-dot" style="background: {{ ['#0a2540','#2c6b9e','#4a90c4','#14b8a6','#f59e0b','#ef4444','#8b5cf6','#ec4899'][$loop->index % 8] }}"></span>
                                <span class="category-stat-name">{{ $cat->name }}</span>
                            </div>
                            <div class="category-stat-right">
                                <span class="category-stat-count">{{ $cat->products_count }} produk</span>
                                @if($totalProducts > 0)
                                    <div class="category-stat-bar">
                                        <div class="category-stat-fill" style="width: {{ ($cat->products_count / $totalProducts) * 100 }}%; background: {{ ['#0a2540','#2c6b9e','#4a90c4','#14b8a6','#f59e0b','#ef4444','#8b5cf6','#ec4899'][$loop->index % 8] }}"></div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-chart">
                        <i class="ti ti-chart-pie-off"></i>
                        <p>Belum ada data kategori</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- All Products Table --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="ti ti-list"></i>
                    Semua Produk
                </h3>
                <span class="admin-card-badge">{{ $products->count() }} items</span>
            </div>
            <div class="admin-card-body p-0">
                <div class="table-responsive">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $idx => $product)
                            <tr class="report-row">
                                <td class="text-muted">{{ $idx + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}" class="report-product-img" alt="">
                                        @else
                                            <div class="report-product-img-placeholder">
                                                <i class="ti ti-package"></i>
                                            </div>
                                        @endif
                                        <span class="fw-medium">{{ $product->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-category">{{ $product->category->name ?? '—' }}</span>
                                </td>
                                <td class="fw-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="text-muted" style="font-size:0.82rem">{{ $product->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="ti ti-package-off" style="font-size:32px; display:block; margin-bottom:8px; opacity:0.4;"></i>
                                    Belum ada data produk
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- Footer --}}
    <footer class="admin-footer">
        <p>Copyright &copy; {{ date('Y') }} <strong>Nepertech</strong> — BLUD SMKN 1 Cirebon</p>
    </footer>

@endsection

@push('scripts')
<script>
    // ── Monthly Products Area Chart ──
    var monthlyOpts = {
        series: [{
            name: 'Produk Ditambahkan',
            data: @json($monthlyProducts)
        }],
        chart: {
            type: 'area',
            height: 300,
            toolbar: { show: false },
            fontFamily: 'Inter, sans-serif',
        },
        colors: ['#2c6b9e'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [0, 100]
            }
        },
        stroke: { curve: 'smooth', width: 3 },
        dataLabels: { enabled: false },
        xaxis: {
            categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            labels: { style: { fontSize: '11px', colors: '#94a3b8' } },
            axisBorder: { show: false },
            axisTicks: { show: false },
        },
        yaxis: {
            labels: {
                style: { fontSize: '11px', colors: '#94a3b8' },
                formatter: val => Math.round(val)
            }
        },
        grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
        tooltip: {
            theme: 'dark',
            y: { formatter: val => val + ' produk' }
        }
    };
    new ApexCharts(document.querySelector("#reportMonthlyChart"), monthlyOpts).render();

    // ── Monthly Value Bar Chart ──
    var valueOpts = {
        series: [{
            name: 'Nilai Katalog',
            data: @json($monthlyValues)
        }],
        chart: {
            type: 'bar',
            height: 300,
            toolbar: { show: false },
            fontFamily: 'Inter, sans-serif',
        },
        colors: ['#0a2540'],
        plotOptions: {
            bar: { borderRadius: 8, columnWidth: '50%' }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'dark', type: 'vertical',
                gradientToColors: ['#2c6b9e'],
                opacityFrom: 1, opacityTo: 0.85,
            }
        },
        dataLabels: { enabled: false },
        xaxis: {
            categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            labels: { style: { fontSize: '11px', colors: '#94a3b8' } },
            axisBorder: { show: false },
            axisTicks: { show: false },
        },
        yaxis: {
            labels: {
                style: { fontSize: '11px', colors: '#94a3b8' },
                formatter: val => 'Rp ' + (val / 1000).toFixed(0) + 'K'
            }
        },
        grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
        tooltip: {
            theme: 'dark',
            y: { formatter: val => 'Rp ' + val.toLocaleString('id-ID') }
        }
    };
    new ApexCharts(document.querySelector("#reportValueChart"), valueOpts).render();

    // ── Category Donut ──
    @if($categoryBreakdown->count() > 0)
    var catOpts = {
        series: @json($categoryBreakdown->pluck('products_count')->values()),
        labels: @json($categoryBreakdown->pluck('name')->values()),
        chart: { type: 'donut', height: 240, fontFamily: 'Inter, sans-serif' },
        colors: ['#0a2540','#2c6b9e','#4a90c4','#14b8a6','#f59e0b','#ef4444','#8b5cf6','#ec4899'],
        plotOptions: {
            pie: {
                donut: {
                    size: '70%',
                    labels: {
                        show: true,
                        name: { fontSize: '13px' },
                        value: { fontSize: '18px', fontWeight: 700, color: '#0a2540' },
                        total: {
                            show: true, label: 'Total', color: '#94a3b8',
                            formatter: w => w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                        }
                    }
                }
            }
        },
        dataLabels: { enabled: false },
        legend: { show: false },
        stroke: { width: 3, colors: ['#fff'] },
    };
    new ApexCharts(document.querySelector("#reportCategoryChart"), catOpts).render();
    @endif
</script>
@endpush