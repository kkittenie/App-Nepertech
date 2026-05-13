@extends('layouts.app')

@section('title', 'Reports')

@section('content')

<div class="container-fluid">

    <h1 class="fs-3 mb-1">Reports</h1>
    <p class="mb-4">View your inventory analytics</p>

    <div id="salesChart"></div>

</div>

@endsection

@push('scripts')
<script>
    var options = {
        chart: {
            type: 'line',
            height: 350
        },
        series: [{
            name: 'Sales',
            data: [10, 40, 25, 60, 30, 80]
        }]
    };

    var chart = new ApexCharts(document.querySelector("#salesChart"), options);
    chart.render();
</script>
@endpush