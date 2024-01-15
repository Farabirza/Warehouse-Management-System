
<!-- Modal storage -->
<div class="modal" id="modal-storage" aria-hidden="true"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="flex-start gap-2"><i class='bx bx-store'></i><span>Gudang</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/storage" id="form-storage" method="POST">
            @csrf
            <input type="hidden" name="_method" id="storage-method" value="">
            <div class="modal-body">
                <div class="mb-3">    
                    <label for="storage-name" class="form-label">Nama gudang</label>
                    <input type="text" id="storage-name" name="name" class="form-control">
                </div>
                <div class="mb-3">    
                    <label for="storage-description" class="form-label">Deskripsi gudang</label>
                    <textarea name="description" id="storage-description" style="min-height:120px" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary flex-start gap-2">Submit<i class='bx bxs-chevron-right'></i></button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal storage end -->

<!-- Modal item storage -->
<div class="modal" id="modal-item-storage" aria-hidden="true"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="flex-start gap-2"><i class='bx bx-transfer'></i><span>Perbaharui barang dalam gudang</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/itemStorage/update" id="form-item-storage" method="POST">
            @csrf
            <input type="hidden" name="_method" id="itemStorage-method" value="">
            <div class="modal-body">
                <div class="d-flex flex-remove-md align-items-center">
                    <div class="col mb-0">
                        <label for="itemStorage-item_id" class="form-label">Jenis barang</label>
                        <select name="item_id" id="itemStorage-item_id" class="form-control" required>
                            @forelse($items as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @empty
                            <option value="" disabled>Data barang kosong</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col mb-0">
                        <label for="itemStorage-count" class="form-label">Tambahan jumlah barang</label>
                        <input type="number" name="count" id="itemStorage-count" class="form-control" value="0">
                    </div>
                </div>
                <div class="m-3">
                    <p class="font-italic fs-9 m-0">*) gunakan tanda negatif untuk mengurangi jumlah barang</p>
                </div>
                <div class="m-3">
                    <label for="itemStorage-storage_id" class="form-label">Gudang</label>
                    <select name="storage_id" id="itemStorage-storage_id" class="form-control" required>
                        @forelse($storages as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @empty
                        <option value="" disabled>Data gudang kosong</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary flex-start gap-2">Submit<i class='bx bxs-chevron-right'></i></button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal item storage end -->

<!-- Modal transfer -->
<div class="modal" id="modal-transfer" aria-hidden="true"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="flex-start gap-2"><i class='bx bx-transfer'></i><span>Transfer barang</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/itemStorage/transfer" id="form-transfer" method="POST">
            @csrf
            <input type="hidden" name="itemStorage_id" id="transfer-itemStorage_id" value="">
            <div class="modal-body">
                <div class="flex-start gap-2">
                    <div class="col mb-3">
                        <label class="form-label">Nama barang</label>
                        <input type="text" id="transfer-item" class="form-control" value="" disabled>
                    </div>
                    <div class="col mb-3">
                        <label for="transfer-count" class="form-label">Jumlah barang</label>
                        <input type="number" name="count" id="transfer-count" class="form-control" value="0" min="0">
                    </div>
                </div>
                <div class="flex-start">
                    <div class="col mb-3">
                        <label class="form-label">Gudang asal</label>
                        <input type="text" id="transfer-storage" class="form-control" value="" disabled>
                    </div>
                    <i class='bx bx-right-arrow-alt'></i>
                    <div class="col mb-3">
                        <label class="form-label">Gudang tujuan</label>
                        <select name="storage_id" id="transfer-storage_id" class="form-control" required>
                            @forelse($storages as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @empty
                            <option value="" disabled>Data gudang kosong</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="m-3">    
                    <label for="transfer-description" class="form-label">Keterangan</label>
                    <input type="text" name="description" id="transfer-description" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary flex-start gap-2">Submit<i class='bx bxs-chevron-right'></i></button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal transfer end -->

@push('scripts')
<script type="text/javascript">

// transfer
const modalTransfer = (order_id, itemStorage_id) => {
    let storage_id = $('#itemStorage-storage-'+order_id).attr('data-storage-id');
    $('#form-transfer').trigger('reset');
    $('#transfer-itemStorage_id').val(itemStorage_id);
    $('#transfer-item').val($('#itemStorage-item-'+order_id).html());
    $('#transfer-storage').val($('#itemStorage-storage-'+order_id).html());
    $('#modal-transfer').modal('show');
};

// itemStorage
const modalItemStorage = () => {
    let form = $('#form-item-storage');
    form.trigger('reset');
    $('#modal-item-storage').modal('show');
};

// storage
const modalStorage = (action, order_id, storage_id) => {
    let form = $('#form-storage');
    form.trigger('reset');
    if(action == 'create') {
        form.attr('action', '/storage');
        $('#storage-method').val('post');
    } else {
        form.attr('action', '/storage/'+storage_id);
        $('#storage-method').val('put');
        $('#storage-name').val($('#storage-name-'+order_id).html());
        $('#storage-description').val($('#storage-description-'+order_id).html());
    }
    $('#modal-storage').modal('show');
};


</script>
@endpush