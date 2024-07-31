<!-- Edit Modal -->
<div class="modal fade" id="edit-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="BlogModal"></h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('categories.update')}}" id="edit-blog-form" name="edit-blog-form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="categoryId" id="categoryId">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nhập danh mục</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập danh mục" maxlength="50" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect3">Chọn danh mục cha</label>
                        <select class="form-control form-control-sm" name="parent_id" id="parent_id">
                            <option value="0">Chọn danh mục cha</option>
                            {!! $htmlOption !!}
                        </select>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save">Submit
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!-- End Edit Modal -->
