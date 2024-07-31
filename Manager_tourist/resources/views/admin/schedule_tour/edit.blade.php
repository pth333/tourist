<!-- Edit Modal -->
<div class="modal fade" id="edit-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="BlogModal"></h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('schedule.update')}}" id="add-blog-form" name="add-blog-form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="scheduleId" id="scheduleId">
                    <div class="form-group">
                        <label for="exampleFormControlSelect3">Chọn Tour</label>
                        <select class="form-control form-control-sm" name="tour_id">
                            @foreach($schedules as $schedule)
                            <option value="{{ $schedule->id}}">{{ $schedule->name_tour}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Ngày</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control @error('order_date') is-invalid @enderror" id="order_date" name="order_date" placeholder="Thứ tự ngày"  >
                            @error('order_date')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Hành trình</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control @error('schedule') is-invalid @enderror" id="schedule" name="schedule" placeholder="Nhập hành trình"  >
                            @error('schedule')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Hoạt động</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control @error('activity') is-invalid @enderror" id="activity" name="activity"  placeholder="Nhập hoạt động"  >
                            @error('activity')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Nhập nội dung chi tiết hành trình</label>
                        <textarea name="description" id="editor_edit" class="form-control @error('description') is-invalid @enderror" rows="5">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
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

