@extends('layouts.master_admin')

@section('controll')
transactions List
@endsection

@section('content')
<!-- Main content -->
<section class="content">
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Danh sách đơn hàng</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="table-responsive">
        <table id="list-transactions" class="table table-bordered table-striped" style="margin-top : 10px;">
          <thead>
            <tr>
              <th class="col-sm-1" style="text-align: center;">Mã đơn hàng</th>
              <th class="col-sm-2" style="text-align: center;">Họ và tên</th>
              <th class="col-sm-2" style="text-align: center;">Số điện thoại</th>
              <th class="col-sm-2" style="text-align: center;">Thời gian đặt hàng</th>
              <th class="col-sm-2" style="text-align: center;">Tổng thanh toán</th>
              <th class="col-sm-2" style="text-align: center;">Trạng thái</th>
            </tr>
          </thead>
          <tbody>
            @if(isset($transactions))
            @foreach ($transactions as $value)
            <tr>
              <td class="col-sm-1"><a href="/admin/transaction/{{$value->order_id}}">{{$value->order_id}}</a></td>
              <td class="col-sm-2">{{$value->name}}</td>
              <td class="col-sm-2" style="text-align: right;">{{$value->phone_number}}</td>
              <td class="col-sm-2" style="text-align: right;">{{$value->created_at}}</td>
              <td class="col-sm-2" style="text-align: right;">{{number_format(($value->amount+$value->score_awards)*1000 ,0 ,'.' ,'.')}} VND</td>
              <td class="col-sm-2" style="text-align : center;">
                @if($value->status == 0)
                <span class="label label-warning">Đang chờ</span>
                @else
                @if($value->status == 1)
                <span class="label label-success">Đang giao</span>
                @else
                @if($value->status == 2)
                <span class="label label-info">Đã giao</span>
                @else
                @if($value->status == 3)
                <span class="label label-danger">Đã hủy</span>
                @endif
                @endif
                @endif
                @endif
              </td>
            </tr>
            @endforeach
            @endif
          </tbody>
        </table>
      </div>
      <!-- /.table-responsive -->
    </div>
    <script>
      $(document).ready(function() {
        $('#list-transactions').DataTable({
          "lengthMenu": [
            [30, 50, 100, 500, -1],
            [30, 50, 100, 500, "All"]
          ],
          "order": [
            [3, 'desc']
          ]
        });
      });
    </script>
    <!-- /.box-body -->
  </div>
  @endsection