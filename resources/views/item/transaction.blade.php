@extends('layouts.master')

@push('css-styles')
<link href="https://cdn.datatables.net/v/bs4/dt-1.13.6/b-2.4.2/b-html5-2.4.2/datatables.min.css" rel="stylesheet">
<style>
table tr td { vertical-align: middle !important; }
</style>
@endpush

@section('content')

<!-- row start -->
<div class="row">

    <!-- transaction start -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>Transaksi Stok Barang</h4>
            </div>
            <form action="/transaction" method="post" class="m-0">
            @csrf
            <div class="card-body">
                <div class="flex-start gap-2 mb-3">
                    <div class="col mb-2">
                        <label for="transaction-item_id" class="form-label">Jenis barang</label>
                        <select name="item_id" id="transaction-item_id" class="form-control" required>
                            @forelse($items as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @empty
                            <option value="" disabled>Data barang kosong</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col mb-2">
                        <label for="transaction-storage_id" class="form-label">Gudang</label>
                        <select name="storage_id" id="transaction-storage_id" class="form-control" required>
                            @forelse($storages as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @empty
                            <option value="" disabled>Data gudang kosong</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="flex-start gap-2">
                    <div class="col mb-2">
                        <label for="transaction-count" class="form-label">Jumlah barang</label>
                        <input type="number" name="count" id="transaction-count" class="form-control" value="0" min="0">
                    </div>
                    <div class="col mb-2">
                        <label for="transaction-type" class="form-label">Jenis transaksi</label>
                        <select name="type" id="transaction-type" class="form-control" required>
                            <option value="in">Masuk</option>
                            <option value="out">Keluar</option>
                        </select>
                    </div>
                </div>
                <div class="m-3">    
                    <label for="transaction-description" class="form-label">Keterangan tambahan</label>
                    <textarea name="description" id="transaction-description" style="min-height:120px" class="form-control"></textarea>
                </div>
            </div>
            <div class="card-footer flex-end">
                <button type="submit" class="btn btn-success px-3 rounded-pill">Transaksi</button>
            </div>
            </form>
        </div>
    </div>
    <!-- transaction end -->
    
    <!-- pie chart start -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 class="flex-start gap-2">Diagram transaksi</h4>
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
<!-- row end -->

<!-- row start -->
<div class="row">
    <!-- item in storage end -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="text-white flex-start gap-2"><i class="bx bx-history"></i>Riwayat transaksi</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-transaction" class="table table-striped">
                        <thead>
                            <th>Waktu</th>
                            <th>Nama barang</th>
                            <th>Jumlah barang</th>
                            <th>Gudang</th>
                            <th>Jenis transaksi</th>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @forelse($transactions as $item)
                            <tr>
                                <td>{{date('Y/m/d', strtotime($item->created_at))}}</td>
                                <td>{{$item->item->name}}</td>
                                <td>{{$item->count}}</td>
                                <td>{{$item->storage->name}}</td>
                                <td class="font-weight-bolder">
                                    {!! ($item->type == 'in') ? '<span class="text-primary">Masuk</span>':'<span class="text-danger">Keluar</span>' !!}
                                </td>
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
    <!-- item in storage end -->
</div>
<!-- row end -->

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
    $('.link-transaction').addClass('active');
    new DataTable('#table-transaction', {
        pageLength: 50,
        ordering: true,
        searching: true,
    });
})
</script>
@endpush