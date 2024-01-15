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

    <!-- items start -->
    <div class="col-lg-8">
        <div class="card">
        <div class="card-header">
            <h4>Daftar barang</h4>
            <div class="card-header-action">
            <span role="button" class="btn btn-primary hover-pointer" onclick="modalItem('create')">Tambahkan <i class="fas fa-plus-circle"></i></span>
            </div>
        </div>
        <div class="card-body">
            @if(count($errors) > 0)
            <div class="alert alert-danger">
                @error('name')
                <p class="m-0">{{$message}}</p>
                @enderror
            </div>
            @endif
            <div class="table-responsive">
                <table id="table-items" class="table table-striped">
                    <thead>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Menu</th>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        @forelse($items as $item)
                        <tr>
                            <td id="item-name-{{$i}}">{{$item->name}}</td>
                            <td id="item-category-{{$i}}" data-category-id="{{$item->category->id}}">{{$item->category->name}}</td>
                            <td>{{$item->amount}}</td>
                            <td>
                                <span data-toggle="dropdown" class=""><i class="fas fa-bars hover-pointer hover-grow"></i></span>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <span class="dropdown-item text-primary fw-600 fs-9">{{$item->name}}</span>
                                    <div class="dropdown-divider"></div>
                                    <a href="/item/{{$item->id}}" class="dropdown-item flex-start gap-2"><i class="bx bx-show"></i>Rincian</a>
                                    <a href="#" class="dropdown-item flex-start gap-2" onclick="modalItem('edit', '{{$i}}', '{{$item->id}}')"><i class="bx bx-edit-alt"></i>Ubah</a>
                                    <a href="/item/{{$item->id}}/delete" class="dropdown-item flex-start gap-2 btn-warn" data-warning="Anda yakin ingin menghapus barang ini?"><i class="bx bx-trash-alt"></i>Hapus</a>
                                </div>
                            </td>
                        </tr>
                        <?php $i++; ?>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
            <p class="font-italic fs-9 m-0">*) jumlah yang tertera di sini adalah jumlah stok barang dari keseluruhan gudang</p>
        </div>
        <div class="card-footer flex-end gap-3">
            <button class="btn btn-success px-3 rounded-pill flex-start gap-2" onclick="modalImport('item')"><i class="fas fa-file-import"></i>Import</button>
            <a href="/export/item" class="btn btn-success px-3 rounded-pill flex-start gap-2"><i class="fas fa-file-export"></i>Eksport</a>
        </div>
        </div>
    </div>
    <!-- items end -->

    <!-- categories start -->
    <div class="col-lg-4">
        <div class="card">
        <div class="card-header">
            <h4>Kategori barang</h4>
            <div class="card-header-action">
                <span role="button" class="btn btn-primary hover-pointer" onclick="modalCategory('create')"><i class="fas fa-plus"></i></span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <th>Nama kategori</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        @forelse($categories as $item)
                        <tr>
                            <td id="category-name-{{$i}}">{{$item->name}}</td>
                            <td>
                                <div class="flex-start gap-2">
                                    <button class="btn btn-sm btn-outline-success" onclick="modalCategory('edit', '{{$i}}', '{{$item->id}}')">Ubah</button>
                                    <form action="/category/{{$item->id}}" method="post" class="m-0">
                                        @csrf
                                        <input type="hidden" name="_method" value="delete">
                                        <button class="btn btn-sm btn-outline-danger" role="button" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php $i++; ?>
                        @empty
                        <tr><td colspan="100%">Belum ada kategori barang yang dibuat</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer flex-end gap-3">
            <button class="btn btn-success px-3 rounded-pill flex-start gap-2" onclick="modalImport('category')"><i class="fas fa-file-import"></i>Import</button>
        </div>
    </div>
    <!-- categories end -->

</div>
<!-- row end -->

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/v/bs4/dt-1.13.6/b-2.4.2/b-html5-2.4.2/datatables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.link-item').addClass('active');
    new DataTable('#table-items', {
        pageLength: 25,
        fixedColumns: true,
        ordering: true,
        searching: true,
    });
})
</script>
@endpush