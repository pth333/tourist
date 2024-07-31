<!-- Edit Modal -->
<div class="modal fade" id="edit-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="BlogModal"></h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('setting.update')}}" id="add-blog-form" name="add-blog-form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="settingId" id="settingId">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Config_key</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control @error('config_key') is-invalid @enderror" id="config_key" name="config_key" placeholder="Config_key">
                            @error('config_key')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Config_value</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control @error('config_value') is-invalid @enderror" id="config_value" name="config_value" placeholder="Config_value">
                            @error('config_value')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save">Submit
                        </button>
                    </div>
                </form>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Edit Modal -->
