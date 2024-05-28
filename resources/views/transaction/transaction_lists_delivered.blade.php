@extends('layouts.master_admin')

@section('controll')
Delivered Transactions
@endsection

@section('content')
<!-- Main content -->
<section class="content">
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Đơn hàng đã giao</h3>

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
              <th class="col-sm-1" style="text-align : center;">Mã đơn hàng</th>
              <th class="col-sm-2" style="text-align : center;">Số điện thoại <br> (Thông tin chi tiết)</th>
              <th class="col-sm-2" style="text-align : center;">Thời gian đặt hàng</th>
              <th class="col-sm-2" style="text-align : center;">Tổng thanh toán</th>
              <th class="col-sm-2" style="text-align : center;">Xác nhận giao hàng thành công</th>
            </tr>
          </thead>
          <tbody>
            @if(isset($transactions))
            @foreach ($transactions as $value)
            <tr>
              <td class="col-sm-1" style="text-align : center;"><a href="/admin/transaction/{{$value->order_id}}">{{$value->order_id}}</a></td>
              <td class="col-sm-2" style="text-align : center;">
                <button data-id="{{$value->customer_id}}" type="button" class="btn btn-success btn-show">
                  {{$value->phone_number}}
                </button>
              </td>
              <td class="col-sm-2" style="text-align : center;">{{$value->created_at}}</td>

              <td class="col-sm-2" style="text-align : center;">{{number_format(($value->amount+$value->score_awards)*1000 ,0 ,'.' ,'.')}} VND</td>
              <td class="col-sm-2" style="text-align : center;">
                {{$value->manager}}
              </td>
            </tr>
            </tr>
            @endforeach
            @endif
          </tbody>
        </table>
      </div>
      <!-- /.table-responsive -->
    </div>

    <!-- modal view -->
    <div class="col-xs-12">
      <div class="modal fade" id="showMessage" tabindex="-1" role="dialog" aria-labelledby="formMessage" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content" style="border-radius : 10px;">
            <div class="modal-header">
              <h4 class="modal-title">Thông báo</h4>
            </div>
            <div class="modal-body text-center">
              <p style="font-size: 16px;">Khách vãng lai, chưa đăng kí tài khoản trên cửa hàng!</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- modal view -->
    <div class="col-xs-12">
      <div class="modal fade" id="showUser" tabindex="-1" role="dialog" aria-labelledby="formUser" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content" style="border-radius : 10px;">
            <div class="modal-header">
              <h4 class="modal-title">Thông tin khách hàng </h4>
            </div>
            <form action="" id="">
              @csrf
              <div class="modal-body">

                <input name="name" type="text" class="form-control" id="showName" placeholder="Tên tài khoản" disabled><br>

                <input name="phone" type="text" class="form-control" id="showPhone" placeholder="Phone" disabled><br>

                <input name="address" type="text" class="form-control" id="showAddress" placeholder="Địa chỉ" disabled><br>

                <input name="created_at" type="text" class="form-control" id="showCreatedAt" placeholder="Tham gia" disabled><br>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script>
      $(document).ready(function() {
        $('#list-transactions').DataTable({
          "lengthMenu": [
            [30, 50, 100, 500, -1],
            [30, 50, 100, 500, "All"]
          ],
          "order": [
            [2, 'desc']
          ]
        });
      });
    </script>

    <script type="text/javascript">
      // show
      $('.btn-show').click(function() {
        var id = $(this).attr('data-id');
        if (id != null && id != '') {
          $.ajax({
            type: "get",
            url: "/admin/user/customer/" + id,
            data: {
              _token: $('[name="_token"]').val(),
            },
            success: function(response) {
              $('#showName').val(response.name),
                $('#showPhone').val(response.phone_number),
                $('#showAddress').val(response.address),
                $('#showCreatedAt').val(response.created_at)
            }
          });

          $('#showUser').modal('show');
        } else {
          $('#showMessage').modal('show');
        }
      });   
    </script>
    <script type="text/javascript" src="{{asset('home/js/sweetalert.min.js')}}"></script>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
      <a href="/admin/transaction" class="btn btn-sm btn-default btn-flat pull-right">Xem toàn bộ giao dịch</a>
    </div>
    <!-- /.box-footer -->
  </div>
  @endsection