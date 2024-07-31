@extends('layouts.admin')
@section('title', 'Manager Transaction')
@section('css')
<link rel="stylesheet" href="{{ asset('index/list.css')}}">
@endsection
@section('content')
<div class="content-wrapper">
    @include('partials.content-header', ['name' => 'Transaction', 'key' => 'Danh sách'])
    <div class="search-field d-none d-md-block">
        <form action="" method="GET" class="d-flex align-items-center h-100">
            <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                    <i class="input-group-text border-0 mdi mdi-magnify"></i>
                </div>
                <input type="text" class="form-control bg-transparent border-0" name="key" placeholder="Tìm Kiếm...">
            </div>
        </form>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Thông tin khách hàng</th>
                        <th>Tiền giao dịch</th>
                        <th>Tiền dặt cọc</th>
                        <th>Số lượng</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($transactions) > 0)
                    @foreach($transactions as $transaction)
                    <tr>
                        <td>{{$transaction->id}}</td>
                        <td>
                            Tên: {{ optional($transaction->user)->name }} <br> <br>
                            Email: {{ optional($transaction->user)->email }}
                        </td>
                        <td>{{number_format($transaction->total_tran)}} VNĐ</td>

                        <td>{{number_format(($transaction->order)->total_deposit)}} VNĐ</td>

                        <td>{{($transaction->order)->total_person}} người</td>
                        @if($transaction->total_tran > ($transaction->order)->total_deposit)
                        <td>
                            <label class="badge badge-gradient-success">Đã thanh toán</label>
                        </td>
                        @else
                        <td>
                            <label class="badge badge-gradient-warning">Chưa hoàn tất</label>
                        </td>
                        @endif
                        <td>
                            <button data-url="{{ route('transaction.cus.edit', ['id' => $transaction->id])}}" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-info edit">
                                Sửa
                            </button>
                            <button data-url="{{ route('transaction.cus.delete', ['id' => $transaction->id])}}" id="delete-compnay" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger action_delete">
                                Xóa
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="12" class="text-center">No Data Found</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $transactions->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

@include('admin.transaction.edit')

@endsection
@section('js')
<script src="{{ asset('ajax/transactionAjax.js')}}"></script>
@endsection
