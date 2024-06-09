@extends('layouts.master_admin') 

@section('controll')
Danh sách khách hàng
@endsection

@section('content')
<!-- Main content -->
<section class="content">
	@csrf
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Danh sách khách hàng</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div style="margin-bottom: 30px;">
						@if(isset($parameter))
						@if($parameter == 'new_customer')
							<div class="col-xs-3">
								<input type="radio" id="new_customer" name="customer" value="new_customer" checked = "checked">
								<label for="new_customer">Khách hàng mới</label><br>
							</div>
							<div class="col-xs-3">
								<input type="radio" id="potential_customer" name="customer" value="potential_customer">
								<label for="potential_customer">Khách hàng tiềm năng</label><br>
							</div>
							<div class="col-xs-3">
								<input type="radio" id="loyal_customer" name="customer" value="loyal_customer">
								<label for="loyal_customer">Khách hàng trung thành</label>
							</div>
						@elseif($parameter == 'potential_customer')
							<div class="col-xs-3">
								<input type="radio" id="new_customer" name="customer" value="new_customer">
								<label for="new_customer">Khách hàng mới</label><br>
							</div>
							<div class="col-xs-3">
								<input type="radio" id="potential_customer" name="customer" value="potential_customer" checked = "checked">
								<label for="potential_customer">Khách hàng tiềm năng</label><br>
							</div>
							<div class="col-xs-3">
								<input type="radio" id="loyal_customer" name="customer" value="loyal_customer">
								<label for="loyal_customer">Khách hàng trung thành</label>
							</div>
						@elseif($parameter == 'loyal_customer')
							<div class="col-xs-3">
								<input type="radio" id="new_customer" name="customer" value="new_customer">
								<label for="new_customer">Khách hàng mới</label><br>
							</div>
							<div class="col-xs-3">
								<input type="radio" id="potential_customer" name="customer" value="potential_customer">
								<label for="potential_customer">Khách hàng tiềm năng</label><br>
							</div>
							<div class="col-xs-3">
								<input type="radio" id="loyal_customer" name="customer" value="loyal_customer" checked = "checked">
								<label for="loyal_customer">Khách hàng trung thành</label>
							</div>
						@endif
							<div class="col-xs-3">
								<button type="button" class="btn btn-info btn-search" >Tìm kiếm</button>
							</div>
						@else
							<div class="col-xs-3">
								<input type="radio" id="new_customer" name="customer" value="new_customer">
								<label for="new_customer">Khách hàng mới</label><br>
							</div>
							<div class="col-xs-3">
								<input type="radio" id="potential_customer" name="customer" value="potential_customer">
								<label for="potential_customer">Khách hàng tiềm năng</label><br>
							</div>
							<div class="col-xs-3">
								<input type="radio" id="loyal_customer" name="customer" value="loyal_customer">
								<label for="loyal_customer">Khách hàng trung thành</label>
							</div>
							<div class="col-xs-3">
								<button type="button" class="btn btn-info btn-search" >Tìm kiếm</button>
							</div>
						@endif


					</div>
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
									@if($value->status == 0)
									<button data-id="{{$value->id}}" type="button" title="Kích hoạt sử dụng" class="btn btn-warning btn-edit" >
										<i class="fa fa-unlock"></i>
									</button>
									@else
									<button data-id="{{$value->id}}" type="button" title="Tạm dừng hoạt động" class="btn btn-success btn-edit" >
										<i class="fa fa-stop-circle"></i>
									</button>
									@endif
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

	<script type="text/javascript">
		// search
		$('.btn-search').click(function(){
			var $radio = $('input[name=customer]:checked');
			var customer = $radio.val();
			var id = $radio.attr('id');
			$.ajax({
				type: 'post',
				url: '/admin/list_customers/' + id,
				data:{
					_token :$('[name="_token"]').val(),
					id : id,
				},
				success: function(response){
					setTimeout(function() {
						window.location.href = "/admin/list_customers/" + id;
					}, 1000);
				}
			});
		});
	</script>
	<script type="text/javascript" src="{{asset('home/js/sweetalert.min.js')}}"></script>
</section>
<!-- /.content -->
@endsection