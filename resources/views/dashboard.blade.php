@extends('layouts.master')

@push('css-styles')
<link href="https://cdn.datatables.net/v/bs4/dt-1.13.6/b-2.4.2/b-html5-2.4.2/datatables.min.css" rel="stylesheet">
<style>
table tr td { vertical-align: middle !important; }
</style>
@endpush

@section('content')

<!-- row counter start -->
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
            <i class="bx bx-user fs-16 text-white"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
            <h4>Users</h4>
            </div>
            <div class="card-body">
            {{count($users)}}
            </div>
        </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
        <div class="card-icon bg-danger">
            <i class="bx bx-package fs-16 text-white"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
            <h4>Total Stok</h4>
            </div>
            <div class="card-body">
            {{count($items)}}
            </div>
        </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
        <div class="card-icon bg-warning">
            <i class="bx bx-category fs-16 text-white"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
            <h4>Kategori</h4>
            </div>
            <div class="card-body">
            {{count($categories)}}
            </div>
        </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
        <div class="card-icon bg-success">
            <i class="bx bx-store fs-16 text-white"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
            <h4>Gudang</h4>
            </div>
            <div class="card-body">
            {{count($storages)}}
            </div>
        </div>
        </div>
    </div>
</div>
<!-- row counter end -->


<!-- row record pie chart -->
<div class="row">
    
    <!-- record start -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="flex-start gap-2"><i class="bx bx-history"></i>Riwayat perpindahan barang</h4>
                <div class="card-header-action">
                    <a href="/storage" class="btn btn-success">Rincian <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-record" class="table table-striped">
                        <thead>
                            <th>Waktu</th>
                            <th>Nama barang</th>
                            <th>Jumlah barang</th>
                            <th>Gudang asal</th>
                            <th>Gudang tujuan</th>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @forelse($records as $item)
                            <tr>
                                <td>{{date('Y/m/d', strtotime($item->created_at))}}</td>
                                <td>{{$item->item->name}}</td>
                                <td>{{$item->count}}</td>
                                <td>{{$item->fromStorage->name}}</td>
                                <td>{{$item->toStorage->name}}</td>
                            </tr>
                            <?php $i++; ?>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- record end -->

    <!-- pie chart start -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 class="flex-start gap-2"><i class="bx bx-pie-chart"></i>Diagram transaksi</h4>
                <div class="card-header-action">
                    <a href="/transaction" class="btn btn-success">Rincian <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="flex-center mb-3">
                    <canvas id="chart-transaction" style="max-height: 420px"></canvas>
                </div>
                <p class="mb-0 font-weight-bold">Total barang masuk : {{$itemIn}}</p>
                <p class="mb-0 font-weight-bold">Total barang keluar : {{$itemOut}}</p>
            </div>
        </div>
    </div>
    <!-- pie chart end -->

</div>
<!-- row record pie chart end -->

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/v/bs4/dt-1.13.6/b-2.4.2/b-html5-2.4.2/datatables.min.js"></script>
<script type="text/javascript" src="{{ asset('/vendor/chartjs/chartjs-4.3.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/vendor/chartjs/chartjs-plugin-datalabels-2.0.0.min.js') }}"></script>
<script type="text/javascript">
const ctx = document.getElementById('chart-transaction');
new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [
        'Barang masuk',
        'Barang keluar',
    ],
    datasets: [{
        label: ' ',
        data: ['{{$itemIn}}', '{{$itemOut}}'],
        backgroundColor: [
        'rgb(54, 162, 235)',
        'rgb(255, 99, 132)',
        ],
        hoverOffset: 4
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top',
            },
            datalabels: {
                color: 'blue',
            },
        }
    }
});
$(document).ready(function() {
    $('.link-dashboard').addClass('active');
    new DataTable('#table-record', {
        pageLength: 50,
        ordering: true,
        searching: true,
    });
})
</script>
@endpush