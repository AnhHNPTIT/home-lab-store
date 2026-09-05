@extends('layouts.master_admin') 

@section('controll')
Danh sách khách hàng
@endsection

@section('content')
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Danh sách khách hàng</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					@if(session('success'))
						<div class="alert alert-success">{{ session('success') }}</div>
					@endif
					@if(session('error'))
						<div class="alert alert-danger">{{ session('error') }}</div>
					@endif

					<form method="GET" action="{{ route('admin.customers.index') }}" class="row" style="margin-bottom: 30px;">
						<div class="col-xs-2">
							<input type="radio" id="all_customers" name="group" value="" {{ empty($parameter) ? 'checked' : '' }}>
							<label for="all_customers">Tất cả</label>
						</div>
						<div class="col-xs-2">
							<input type="radio" id="new_customer" name="group" value="new_customer" {{ $parameter === 'new_customer' ? 'checked' : '' }}>
							<label for="new_customer">Khách hàng mới</label>
						</div>
						<div class="col-xs-3">
							<input type="radio" id="potential_customer" name="group" value="potential_customer" {{ $parameter === 'potential_customer' ? 'checked' : '' }}>
							<label for="potential_customer">Khách hàng tiềm năng</label>
						</div>
						<div class="col-xs-3">
							<input type="radio" id="loyal_customer" name="group" value="loyal_customer" {{ $parameter === 'loyal_customer' ? 'checked' : '' }}>
							<label for="loyal_customer">Khách hàng trung thành</label>
						</div>
						<div class="col-xs-2">
							<button type="submit" class="btn btn-info btn-search">Tìm kiếm</button>
						</div>
					</form>
					<br>
					<table id="list-customers" class="table table-bordered table-striped" style="margin-top : 10px;">
						<thead>
							<tr>
								<th class="col-sm-1" style="text-align: center;">Tên tài khoản</th>
								<th class="col-sm-1" style="text-align: center;">Số điện thoại</th>
								<th class="col-sm-1" style="text-align: center;">Nhóm khách hàng</th>
								<th class="col-sm-1" style="text-align: center;">Tổng tiền giao dịch</th>
								<th class="col-sm-1" style="text-align: center;">Điểm tích lũy</th>
								<!-- <th class="col-sm-1" style="text-align: center;">Tham gia</th> -->
								<th class="col-sm-1" style="text-align: center;"> Hành động</th>
							</tr>
						</thead>
						<tbody>
						    @php Carbon\Carbon::setLocale('vi'); @endphp
							@foreach ($customers as $value)
							<tr>
								<td class="col-sm-1">{{$value->name}}</td>
								<td class="col-sm-1" style="text-align: center;">{{$value->phone_number}}</td>
								@if ($value->money_payment_transactions > 5000)
									<td class="col-sm-1">Khách hàng trung thành</td>
								@elseif ($value->money_payment_transactions > 0 && $value->money_payment_transactions <= 5000)
									<td class="col-sm-1">Khách hàng tiềm năng</td>
								@else
									<td class="col-sm-1">Khách hàng mới</td>
								@endif
								<td class="col-sm-1" style="text-align: right;">{{number_format(($value->money_payment_transactions*1000) ,0 ,'.' ,'.')}} VND</td>
								<td class="col-sm-1" style="text-align: right;">{{$value->score_awards}}</td>
								<!-- <td class="col-sm-1" style="text-align: right;">
									{{Carbon\Carbon::parse($value->created_at)->diffForHumans()}}
								</td> -->
								<td class="col-sm-1" style="text-align: center;">
									<form method="POST" action="{{ route('admin.customers.update-status', $value->id) }}" style="display: inline;">
										@csrf
										@method('PUT')
									@if($value->status == 0)
									<button type="submit" title="Kích hoạt sử dụng" class="btn btn-warning btn-edit">
										<i class="fa fa-unlock"></i>
									</button>
									@else
									<button type="submit" title="Tạm dừng hoạt động" class="btn btn-success btn-edit">
										<i class="fa fa-stop-circle"></i>
									</button>
									@endif
									</form>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
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
    			"lengthMenu": [[15, 25, -1], [15, 25, "All"]],
				"ordering": false
    		} );
    	} );
    </script>
</section>
<!-- /.content -->
@endsection
