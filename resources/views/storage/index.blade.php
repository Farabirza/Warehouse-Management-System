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

    <!-- item in storage start -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>Daftar barang dalam gudang</h4>
                <div class="card-header-action">
                <span role="button" class="btn btn-primary hover-pointer" onclick="modalItemStorage()">Perbaharui <i class="bx bx-transfer"></i></span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-item-storage" class="table table-striped">
                        <thead>
                            <th>Nama barang</th>
                            <th>Jumlah barang</th>
                            <th>Gudang</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @forelse($itemInStorages as $item)
                            <tr>
                                <td id="itemStorage-item-{{$i}}" data-item-id="{{$item->item->id}}">{{$item->item->name}}</td>
                                <td>{{$item->count}}</td>
                                <td id="itemStorage-storage-{{$i}}" data-item-id="{{$item->storage->id}}">{{$item->storage->name}}</td>
                                <td>
                                    <div class="flex-start gap-2">
                                        <button class="btn btn-sm btn-success px-3 rounded-pill" onclick="modalTransfer('{{$i}}', '{{$item->id}}')">Transfer</button>
                                        <a href="/itemStorage/{{$item->id}}/delete" class="btn btn-sm btn-danger px-2 rounded-circle btn-warn" data-warning="Apakah anda yakin ingin menghapus stok barang di gudang ini?"><i class="bx bx-trash"></i></a>
                                    </div>
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

    <!-- storage start -->
    <div class="col-lg-4">
        <div class="card">
        <div class="card-header">
            <h4>Daftar gudang</h4>
            <div class="card-header-action">
            <span role="button" class="btn btn-primary hover-pointer" onclick="modalStorage('create')">Tambahkan <i class="fas fa-plus-circle"></i></span>
            </div>
        </div>
        <div class="card-body p-0">
            @if(count($errors) > 0)
            <div class="alert alert-danger">
                @error('name')
                <p class="m-0">{{$message}}</p>
                @enderror
            </div>
            @endif
            <div class="table-responsive">
                <table id="table-storages" class="table table-striped">
                    <thead>
                        <th>Nama</th>
                        <th>Jumlah barang</th>
                        <th>Menu</th>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        @forelse($storages as $item)
                        <tr>
                            <td id="storage-name-{{$i}}">{{$item->name}}</td>
                            <td>{{$item->amount}}</td>
                            <td>
                                <span data-toggle="dropdown" class=""><i class="fas fa-bars hover-pointer hover-grow"></i></span>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <span class="dropdown-item text-primary fw-600 fs-9">{{$item->name}}</span>
                                    <div class="dropdown-divider"></div>
                                    <a href="/storage/{{$item->id}}" class="dropdown-item flex-start gap-2"><i class="bx bx-show"></i>Rincian</a>
                                    <a href="#" class="dropdown-item flex-start gap-2" onclick="modalStorage('edit', '{{$i}}', '{{$item->id}}')"><i class="bx bx-edit-alt"></i>Ubah data</a>
                                    <a href="/storage/{{$item->id}}/delete" class="dropdown-item flex-start gap-2 btn-warn" data-warning="Anda yakin ingin menghapus data gudang ini? Data-data lainnya yang terkait akan ikut terhapus"><i class="bx bx-trash-alt"></i>Hapus</a>
                                </div>
                            </td>
                        </tr>
                        <p id="storage-description-{{$i}}" class="d-none">{{$item->description}}</p>
                        <?php $i++; ?>
                        @empty
                        <tr><td colspan="100%">Belum ada gudang didaftarkan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer flex-end gap-3">
            <button class="btn btn-success px-3 rounded-pill flex-start gap-2" onclick="modalImport('storage')"><i class="fas fa-file-import"></i>Import</button>
        </div>
        </div>
    </div>
    <!-- storage end -->

</div>
<!-- row end -->

<!-- row start -->
<div class="row">
    <!-- item in storage end -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="text-white flex-start gap-2"><i class="bx bx-history"></i>Riwayat perpindahan barang</h4>
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
            </div>
            <div class="card-footer flex-end gap-3">
                <a href="/export/transfer" class="btn btn-success px-3 rounded-pill flex-start gap-2"><i class="fas fa-file-export"></i>Eksport</a>
            </div>
        </div>
    </div>
    <!-- item in storage end -->
</div>
<!-- row end -->
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/v/bs4/dt-1.13.6/b-2.4.2/b-html5-2.4.2/datatables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.link-storage').addClass('active');
    new DataTable('#table-item-storage', {
        pageLength: 10,
        ordering: true,
        searching: true,
    });
    new DataTable('#table-record', {
        pageLength: 50,
        ordering: true,
        searching: true,
    });
})
</script>
@endpush