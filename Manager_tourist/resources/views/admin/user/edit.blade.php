<!-- Edit Modal -->
<div class="modal fade" id="edit-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="BlogModal"></h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.update')}}" id="add-blog-form" name="add-blog-form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="userId" id="userId">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nhập tên</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nhập tên nhân viên">
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Nhập Email</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Nhập Email">
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="role_id" class="col-sm-2 control-label">Chọn vai trò</label>
                        <div class="col-sm-12">
                            <select name="role_id[]" id="role_id" class="form-control tags_select_choose" multiple>

                            </select>
                        </div>
                    </div>


                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save">Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Edit Modal -->
<style>
    .select2-container {
        z-index: 9999;
        /* Hoặc bất kỳ giá trị nào cao hơn các phần tử khác */
    }
</style>
