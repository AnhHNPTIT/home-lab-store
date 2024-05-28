@extends('layouts.master_admin')

@section('controll')
Transaction Detail
@endsection

@section('content')
<!-- Main content -->
<section class="content">
  @if(isset($transaction) && isset($order))
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Thông tin đơn hàng</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-globe"></i> Home Lab
                <small class="pull-right">
                  Ngày đặt hàng:
                  @if(isset($transaction))
                  {{$transaction->created_at}}<br>
                  @endif
                </small>
              </h2>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              Từ
              <address>
                <strong>Home Lab</strong><br>
                225 Trần Đăng Ninh, p. Dịch Vọng, q. Cầu Giấy, Hà Nội<br>
                Điện thoại: 0978.478.178<br>
                Email:cskh.so@comem.vn
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              Đến
              <address>
                @if(isset($transaction))
                <strong>{{$transaction->name}}</strong><br>
                {{$transaction->address}}<br>
                Điện thoại: {{$transaction->phone_number}}<br>
                @endif
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <br>
              <b>Mã đơn hàng:</b> @if(isset($transaction)) {{$transaction->order_id}} @endif<br>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Sản phẩm</th>
                    <th>Mã sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá gốc (VNĐ)</th>
                    <th>Giá bán (VNĐ)</th>
                    <th>Giảm (%)</th>
                    <th>Tạm tính (VNĐ)</th>
                  </tr>
                </thead>
                <tbody>
                  @if(isset($order))
                  @foreach($order as $item)
                  <tr>
                    <td>{{$item->name}}</td>
                    <td>{{$item->code}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>{{number_format($item->price*1000 ,0 ,'.' ,'.')}}</td>
                    <td>{{number_format($item->price_sale*1000 ,0 ,'.' ,'.')}}</td>
                    <td>{{floor(($item->price - $item->price_sale)/($item->price)*100)}}%</td>
                    <td>{{number_format($item->price_sale*$item->quantity*1000 ,0 ,'.' ,'.')}}</td>
                  </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          @if(isset($transaction) && $transaction->image != null)
          <div class="row" style="margin-bottom:20px;">
            <div class="col-xs-4" style="box-sizing : btransaction-box">
              <p class="lead">Đơn thuốc đính kèm :</p>
              <div class="col-xs-12">
                <a target="_blank" href="{{ url('images/prescriptions/'.$transaction->image) }}" title="Xem đơn thuốc">
                  <img style="width: 100%;" src="{{url('images/prescriptions/'.$transaction->image)}}" alt="">
                </a>
              </div>
            </div>
            <!-- accepted payments column -->
            <div class="col-xs-4" style="box-sizing : btransaction-box">
              <p class="lead">Phương thức thanh toán (Hỗ trợ)</p>
              <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                Thanh toán bằng tiền mặt khi giao hàng
              </p>
              <p class="lead">Phương thức thanh toán (Chưa hỗ trợ)</p>
              <img src="../../dist/img/credit/visa.png" alt="Visa">
              <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
              <img src="../../dist/img/credit/american-express.png" alt="American Express">
              <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

              <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                Thanh toán điện tử qua cổng thanh toán Ngân lượng
              </p>

            </div>
            <!-- /.col -->
            <div class="col-xs-4">

              <div class="table-responsive">
                <table class="table">
                  @if($transaction->promotion > 0)
                  <tr>
                    <th style="width:50%">Khuyến mại đơn hàng:</th>
                    <td>{{$transaction->promotion}} %</td>
                  </tr>
                  @endif
                  <tr>
                    <th>Thành tiền (Đã bao gồm VAT):</th>
                    <td>
                      {{number_format(($transaction->amount+$transaction->score_awards)*1000 ,0 ,'.' ,'.')}} <span style="font-weight : 600;">VND</span>
                    </td>
                  </tr>
                  @if($transaction->score_awards > 0)
                  <tr>
                    <th style="width:50%">Thanh toán bằng điểm:</th>
                    <td>{{number_format($transaction->score_awards*1000 ,0 ,'.' ,'.')}} <span style="font-weight : 600;">VND</td>
                  </tr>
                  @endif
                  <tr>
                    <th>Số tiền phải thu:</th>
                    <td>
                      {{number_format(($transaction->amount)*1000 ,0 ,'.' ,'.')}} <span style="font-weight : 600;">VND</span>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          @else
          <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
              <p class="lead">Phương thức thanh toán (Hỗ trợ)</p>
              <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                Thanh toán bằng tiền mặt khi giao hàng
              </p>
              <p class="lead">Phương thức thanh toán (Chưa hỗ trợ)</p>
              <img src="../../dist/img/credit/visa.png" alt="Visa">
              <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
              <img src="../../dist/img/credit/american-express.png" alt="American Express">
              <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

              <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                Thanh toán điện tử qua cổng thanh toán Ngân lượng
              </p>
            </div>
            <!-- /.col -->
            <div class="col-xs-6">

              <div class="table-responsive">
                <table class="table">
                  @if($transaction->promotion > 0)
                  <tr>
                    <th style="width:50%">Khuyến mại đơn hàng:</th>
                    <td>{{$transaction->promotion}} %</td>
                  </tr>
                  @endif
                  <tr>
                    <th>Thành tiền (Đã bao gồm VAT):</th>
                    <td>
                      {{number_format(($transaction->amount+$transaction->score_awards)*1000 ,0 ,'.' ,'.')}} <span style="font-weight : 600;">VND</span>
                    </td>
                  </tr>
                  @if($transaction->score_awards > 0)
                  <tr>
                    <th style="width:50%">Thanh toán bằng điểm:</th>
                    <td>{{number_format($transaction->score_awards*1000 ,0 ,'.' ,'.')}} <span style="font-weight : 600;">VND</td>
                  </tr>
                  @endif
                  <tr>
                    <th>Số tiền phải thu:</th>
                    <td>
                      {{number_format(($transaction->amount)*1000 ,0 ,'.' ,'.')}} <span style="font-weight : 600;">VND</span>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          @endif
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  @endif
  <!-- /.row -->
  <script>
    $(document).ready(function() {
      $('#list-users').DataTable({
        "lengthMenu": [
          [25, 50, 100, 500, -1],
          [25, 50, 100, 500, "All"]
        ],
        "transaction": [
          [1, "asc"]
        ],
      });
    });
  </script>
  <script type="text/javascript" src="{{asset('home/js/sweetalert.min.js')}}"></script>
</section>

@endsection