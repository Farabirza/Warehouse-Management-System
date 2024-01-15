<style>
</style>

<!-- Modal Import -->
<div class="modal" id="modal-import" aria-hidden="true"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="flex-start gap-2"><i class='bx bx-category'></i><span id="import-label">Import</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/import" id="form-import" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label for="import-file" class="form-label">Pilih file untuk diimport ke database</label>
                    <input type="file" name="file" id="import-file" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                </div>
                <p class="m-0 text-primary fs-10">Format spreadsheet :</p>
                <p id="import-note" class="form-note"></p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary flex-start gap-2">Submit<i class='bx bxs-chevron-right'></i></button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Import end -->

@push('scripts')
<script type="text/javascript">

const modalImport = (type) => {
    let form = $('#form-import');
    let label = $('#import-label');
    let note = $('#import-note');
    form.trigger('reset');
    switch(type) {
        case 'item':
            label.html('Import data barang');
            note.html('nama barang; nama kategori barang');
            form.attr('action', '/import/item');
        break;
        case 'category':
            label.html('Import data kategori');
            note.html('nama kategori; deskripsi singkat kategori;');
            form.attr('action', '/import/category');
        break;
        case 'storage':
            label.html('Import data gudang');
            note.html('nama gudang; deskripsi singkat gudang;');
            form.attr('action', '/import/storage');
        break;
    }
    $('#modal-import').modal('show');
};


</script>
@endpush