<style>
</style>

<!-- Modal Item -->
<div class="modal" id="modal-item" aria-hidden="true"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="flex-start gap-2"><i class='bx bx-package'></i><span>Barang</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/item" id="form-item" method="POST">
            @csrf
            <input type="hidden" name="_method" id="item-method" value="">
            <div class="modal-body">
                <div class="mb-3">    
                    <label for="item-name" class="form-label">Nama</label>
                    <input type="text" id="item-name" name="name" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="item-category" class="form-label">Kategori</label>
                    <select name="category_id" id="item-category" class="form-control" required>
                        @forelse($categories as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @empty
                        <option value="" disabled>Silahkan buat kategori terlebih dahulu</option>
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
<!-- Modal Item end -->

<!-- Modal Category -->
<div class="modal" id="modal-category" aria-hidden="true"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="flex-start gap-2"><i class='bx bx-category'></i><span>Kategori</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/category" id="form-category" method="POST">
            @csrf
            <input type="hidden" name="_method" id="category-method" value="">
            <div class="modal-body">
                <label for="category-name" class="form-label">Nama</label>
                <input type="text" id="category-name" name="name" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary flex-start gap-2">Submit<i class='bx bxs-chevron-right'></i></button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Category end -->

@push('scripts')
<script type="text/javascript">

// item
const modalItem = (action, order_id, item_id) => {
    let form = $('#form-item');
    let category_id = $('#item-category-'+order_id).attr('data-category-id');
    form.trigger('reset');
    if(action == 'create') {
        form.attr('action', '/item');
        $('#item-method').val('post');
    } else {
        form.attr('action', '/item/'+item_id);
        $('#item-method').val('put');
        $('#item-name').val($('#item-name-'+order_id).html());
        $('#item-category option[value="'+category_id+'"]').prop('selected', true);
    }
    $('#modal-item').modal('show');
};

// category 
const modalCategory = (action, item_id, category_id) => {
    let form = $('#form-category');
    form.trigger('reset');
    if(action == 'create') {
        form.attr('action', '/category');
        $('#category-method').val('post');
    } else {
        form.attr('action', '/category/'+category_id);
        $('#category-method').val('put');
        $('#category-name').val($('#category-name-'+item_id).html());
    }
    $('#modal-category').modal('show');
};

</script>
@endpush