@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">Welcome back, {{ auth()->user()->name }} 👋</p>
        </div>
        <div class="page-header-actions">
            <span class="header-date">
                <i class="ti ti-calendar"></i>
                {{ now()->format('d M Y') }}
            </span>
        </div>
    </div>

    {{-- ── ROW 1: Stat Cards ── --}}
    <div class="stats-grid">

        <div class="stat-card stat-card--primary">
            <div class="stat-card-icon">
                <i class="ti ti-box"></i>
            </div>
            <div class="stat-card-body">
                <span class="stat-card-label">Total Produk</span>
                <h3 class="stat-card-value">{{ number_format($totalProducts) }}</h3>
            </div>
            <div class="stat-card-glow"></div>
        </div>

        <div class="stat-card stat-card--accent">
            <div class="stat-card-icon">
                <i class="ti ti-category"></i>
            </div>
            <div class="stat-card-body">
                <span class="stat-card-label">Kategori</span>
                <h3 class="stat-card-value">{{ number_format($totalCategories) }}</h3>
            </div>
            <div class="stat-card-glow"></div>
        </div>

        <div class="stat-card stat-card--teal">
            <div class="stat-card-icon">
                <i class="ti ti-users"></i>
            </div>
            <div class="stat-card-body">
                <span class="stat-card-label">Total Users</span>
                <h3 class="stat-card-value">{{ number_format($totalUsers) }}</h3>
            </div>
            <div class="stat-card-glow"></div>
        </div>

        <div class="stat-card stat-card--gold">
            <div class="stat-card-icon">
                <i class="ti ti-currency-dollar"></i>
            </div>
            <div class="stat-card-body">
                <span class="stat-card-label">Nilai Katalog</span>
                <h3 class="stat-card-value">Rp {{ number_format($catalogValue, 0, ',', '.') }}</h3>
            </div>
            <div class="stat-card-glow"></div>
        </div>

    </div>

    {{-- ── ROW 2: Charts ── --}}
    <div class="charts-grid">

        {{-- Monthly Products Chart --}}
        <div class="admin-card chart-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="ti ti-chart-bar"></i>
                    Produk per Bulan
                </h3>
                <span class="admin-card-badge">{{ date('Y') }}</span>
            </div>
            <div class="admin-card-body">
                <div id="monthlyChart"></div>
            </div>
        </div>

        {{-- Category Distribution --}}
        <div class="admin-card chart-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="ti ti-chart-donut-3"></i>
                    Distribusi Kategori
                </h3>
                <span class="admin-card-badge">{{ $categoryBreakdown->count() }} Kategori</span>
            </div>
            <div class="admin-card-body">
                @if($categoryBreakdown->count() > 0)
                    <div id="categoryChart"></div>
                    <div class="category-legend">
                        @foreach($categoryBreakdown as $cat)
                        <div class="legend-item">
                            <span class="legend-dot" style="background: {{ ['#0a2540','#2c6b9e','#4a90c4','#14b8a6','#f59e0b','#ef4444','#8b5cf6','#ec4899'][$loop->index % 8] }}"></span>
                            <span class="legend-name">{{ $cat->name }}</span>
                            <span class="legend-count">{{ $cat->products_count }}</span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-chart">
                        <i class="ti ti-chart-pie-off"></i>
                        <p>Belum ada kategori</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- ── ROW 3: Lists ── --}}
    <div class="lists-grid">

        {{-- Top Products --}}
        <div class="admin-card list-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="ti ti-trending-up"></i>
                    Produk Termahal
                </h3>
                <a href="{{ route('products.index') }}" class="admin-card-link">Lihat Semua</a>
            </div>
            <div class="admin-card-body p-0">
                <ul class="admin-list">
                    @forelse($topProducts as $product)
                    <li class="admin-list-item">
                        <div class="admin-list-img">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                            @else
                                <div class="img-placeholder">
                                    <i class="ti ti-package"></i>
                                </div>
                            @endif
                        </div>
                        <div class="admin-list-info">
                            <p class="admin-list-name">{{ $product->name }}</p>
                            <span class="admin-list-meta">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        </div>
                        <div class="admin-list-value">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    </li>
                    @empty
                    <li class="admin-list-empty">
                        <i class="ti ti-package-off"></i>
                        <span>Belum ada produk</span>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- Low Price Products --}}
        <div class="admin-card list-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="ti ti-tag"></i>
                    Produk Termurah
                </h3>
                <a href="{{ route('products.index') }}" class="admin-card-link">Lihat Semua</a>
            </div>
            <div class="admin-card-body p-0">
                <ul class="admin-list">
                    @forelse($lowPriceProducts as $product)
                    <li class="admin-list-item">
                        <div class="admin-list-img">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                            @else
                                <div class="img-placeholder">
                                    <i class="ti ti-package"></i>
                                </div>
                            @endif
                        </div>
                        <div class="admin-list-info">
                            <p class="admin-list-name">{{ $product->name }}</p>
                            <span class="admin-list-meta">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        </div>
                        <div class="admin-list-value admin-list-value--low">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    </li>
                    @empty
                    <li class="admin-list-empty">
                        <i class="ti ti-package-off"></i>
                        <span>Belum ada produk</span>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- Recent Products --}}
        <div class="admin-card list-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="ti ti-clock"></i>
                    Produk Terbaru
                </h3>
                <a href="{{ route('products.index') }}" class="admin-card-link">Lihat Semua</a>
            </div>
            <div class="admin-card-body p-0">
                <ul class="admin-list">
                    @forelse($recentProducts as $product)
                    <li class="admin-list-item">
                        <div class="admin-list-img">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                            @else
                                <div class="img-placeholder">
                                    <i class="ti ti-package"></i>
                                </div>
                            @endif
                        </div>
                        <div class="admin-list-info">
                            <p class="admin-list-name">{{ $product->name }}</p>
                            <span class="admin-list-meta">{{ $product->created_at->diffForHumans() }}</span>
                        </div>
                        <span class="admin-list-badge">
                            {{ $product->category->name ?? '—' }}
                        </span>
                    </li>
                    @empty
                    <li class="admin-list-empty">
                        <i class="ti ti-package-off"></i>
                        <span>Belum ada produk</span>
                    </li>
                    @endforelse
                </ul>
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
    // ── Monthly Products Bar Chart ──
    var monthlyOptions = {
        series: [{
            name: 'Products Added',
            data: @json($monthlyProducts)
        }],
        chart: {
            type: 'bar',
            height: 300,
            toolbar: { show: false },
            fontFamily: 'Inter, sans-serif',
        },
        colors: ['#0a2540'],
        plotOptions: {
            bar: {
                borderRadius: 8,
                columnWidth: '50%',
                distributed: false,
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'dark',
                type: 'vertical',
                shadeIntensity: 0.3,
                gradientToColors: ['#2c6b9e'],
                opacityFrom: 1,
                opacityTo: 0.85,
            }
        },
        dataLabels: { enabled: false },
        xaxis: {
            categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            labels: {
                style: { fontSize: '11px', fontFamily: 'Inter, sans-serif', colors: '#94a3b8' }
            },
            axisBorder: { show: false },
            axisTicks: { show: false },
        },
        yaxis: {
            labels: {
                style: { fontSize: '11px', fontFamily: 'Inter, sans-serif', colors: '#94a3b8' },
                formatter: val => Math.round(val)
            }
        },
        grid: {
            borderColor: '#f1f5f9',
            strokeDashArray: 4,
            padding: { left: 8, right: 8 }
        },
        tooltip: {
            theme: 'dark',
            style: { fontFamily: 'Inter, sans-serif' },
            y: { formatter: val => val + ' produk' }
        }
    };
    new ApexCharts(document.querySelector("#monthlyChart"), monthlyOptions).render();

    // ── Category Donut Chart ──
    @if($categoryBreakdown->count() > 0)
    var catOptions = {
        series: @json($categoryBreakdown->pluck('products_count')->values()),
        labels: @json($categoryBreakdown->pluck('name')->values()),
        chart: {
            type: 'donut',
            height: 260,
            fontFamily: 'Inter, sans-serif',
        },
        colors: ['#0a2540','#2c6b9e','#4a90c4','#14b8a6','#f59e0b','#ef4444','#8b5cf6','#ec4899'],
        plotOptions: {
            pie: {
                donut: {
                    size: '72%',
                    labels: {
                        show: true,
                        name: { fontSize: '13px', fontWeight: 600 },
                        value: { fontSize: '20px', fontWeight: 700, color: '#0a2540' },
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: '12px',
                            color: '#94a3b8',
                            formatter: w => w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                        }
                    }
                }
            }
        },
        dataLabels: { enabled: false },
        legend: { show: false },
        stroke: { width: 3, colors: ['#fff'] },
        tooltip: {
            style: { fontFamily: 'Inter, sans-serif' },
            y: { formatter: val => val + ' produk' }
        }
    };
    new ApexCharts(document.querySelector("#categoryChart"), catOptions).render();
    @endif
</script>
@endpush