@extends('layouts.master_admin') 

@section('controll')
Sinh nhật khách hàng
@endsection

@section('content')
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Sinh nhật khách hàng</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					@csrf
					<table id="list-customers" class="table table-bordered table-striped" style="margin-top : 10px;">
						<thead>
							<tr>
								<th class="col-sm-1" style="text-align: center;">Tên tài khoản</th>
								<th class="col-sm-1" style="text-align: center;">Số điện thoại</th>
								<th class="col-sm-1" style="text-align: center;">Ngày sinh</th>
								<th class="col-sm-1" style="text-align: center;">Nhóm khách hàng</th>
								<th class="col-sm-1" style="text-align: center;">Tổng tiền giao dịch</th>
								<th class="col-sm-1" style="text-align: center;">Điểm tích lũy</th>
							</tr>
						</thead>
						<tbody>
						    @php Carbon\Carbon::setLocale('vi'); @endphp
							@foreach ($customers as $value)
							<tr>
								<td class="col-sm-1">{{$value->name}}</td>
								<td class="col-sm-1" style="text-align: center;">{{$value->phone_number}}</td>
								<td class="col-sm-1" style="text-align: center;">
									{{Carbon\Carbon::parse($value->birthday)->format('d-m-Y')}}
								</td>
								@if ($value->money_payment_transactions > 5000)
									<td class="col-sm-1">Khách hàng trung thành</td>
								@elseif ($value->money_payment_transactions > 0 && $value->money_payment_transactions <= 5000)
									<td class="col-sm-1">Khách hàng tiềm năng</td>
								@else
									<td class="col-sm-1">Khách hàng mới</td>
								@endif
								<td class="col-sm-1" style="text-align: right;">{{number_format(($value->money_payment_transactions*1000) ,0 ,'.' ,'.')}} VND</td>
								<td class="col-sm-1" style="text-align: right;">{{$value->score_awards}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>

					{{-- {{$customers->links()}} --}}
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->

	<script>
		$(document).ready(function() {
			$('#list-customers').DataTable( {
				"lengthMenu": [[25, 50, 100, 500, 1000, 5000, -1], [25, 50, 100, 500, 1000, 5000, "All"]]
			} );
		} );
	</script>
</section>

@endsection
