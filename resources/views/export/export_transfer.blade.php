@extends('layouts.blank')

@push('css-styles')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" crossorigin="anonymous">

<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<!-- Vendor JS Files -->
<!-- <script src="{{ asset('/vendor/jquery/jquery-3.6.0.min.js') }}"></script> -->

<!-- Vendor CSS Files -->
<link href="{{ asset('/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">

<!-- Main CSS File -->
<link href="{{ asset('/css/style.css') }}?v=1" rel="stylesheet">
<style>
body { background: #f4f6f9; }
a { color: inherit; text-decoration: none; }
a:hover { color: #374785; text-decoration: none; }
</style>
@endpush

@section('content')
<div class="container pt-3 my-3">
    <!-- breadcrumb start -->
    <div class="col-md-12">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/storage">Gudang</a></li>
                <li class="breadcrumb-item active" aria-current="page">Eksport riwayat transfer</li>
            </ol>
        </nav>
    </div>
    <!-- breadcrumb end -->
</div>

<div class="container">
    <div class="row mb-4">
        <div class="col-md-12 bg-white p-4 shadow rounded">
            <h3 class="text-primary flex-start gap-3 mb-3"><i class='bx bx-export'></i>Eksport Riwayat Transfer</h3>
            <p class="mb-3">Eksport data di dalam tabel ke salah satu format di bawah ini</p>
            <!-- table start -->
            <div class="table-responsive">
                <table id="table-transfer" class="table table-striped">
                    <thead>
                        <th>Waktu</th>
                        <th>Nama barang</th>
                        <th>Jumlah barang</th>
                        <th>Gudang asal</th>
                        <th>Gudang tujuan</th>
                        <th>Keterangan</th>
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
                            <td>{{($item->description) ? $item->description : '-'}}</td>
                        </tr>
                        <?php $i++; ?>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- table end -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href="/storage" class="fs-11 flex-start gap-2 hover-primary"><i class="bx bx-chevron-left"></i>Kembali ke halaman gudang</a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
    $('#table-transfer').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
@endpush