@extends('layouts.master_admin') 

@section('controll')
Customers List
@endsection

@section('content')
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Danh sách khách hàng </h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					@csrf
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

									<!-- <button data-id="{{$value->id}}" type="button" title="Xóa" class="btn btn-danger btn-delete">
										<i class="fa fa-user-times"></i>
									</button> -->
								</td>
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
	
	<script type="text/javascript">
		// block or unblock
		$('.btn-edit').click(function(){
			var id = $(this).attr('data-id');
			$.ajax({
				type: 'put',
				url: '/admin/user/customer/' + id,
				data:{
					_token :$('[name="_token"]').val(),
					id : id,
				},
				success: function(response){
					if (response.is === 'success') {
						swal({
							title: "Hoàn thành!",
							text: response.complete,
							icon: "success",
							buttons: true,
							buttons: ["Ok"],
							timer: 1000
						});

						setTimeout(function() {
							window.location.href = "/admin/user/customer/";
						}, 1000);
					}
					if (response.is === 'unsuccess') {
						swal({
							title: "Thất bại!",
							text: response.uncomplete,
							icon: "error",
							buttons: true,
							buttons: ["Ok"],
							timer: 5000
						});
					}
				}
			});
		});

		// delete
		$('.btn-delete').click(function(){
			if(confirm('Bạn có muốn xóa không?')){
				var _this = $(this);
				var id = $(this).attr('data-id');
				$.ajax({
					type: 'delete',
					url: '/admin/user/customer/' + id,
					data:{
						_token : $('[name="_token"]').val(),
					},
					success: function(response){
						_this.parent().parent().remove();
						if (response.is === 'success') {
							_this.parent().parent().remove();
							swal({
								title: "Hoàn thành!",
								text: response.complete,
								icon: "success",
								buttons: true,
								buttons: ["Ok"],
								timer: 1000
							});

							setTimeout(function() {
								window.location.href = "/admin/user/customer/";
							}, 1000);
						}
						if (response.is === 'unsuccess') {
							swal({
								title: "Thất bại!",
								text: response.uncomplete,
								icon: "error",
								buttons: true,
								buttons: ["Ok"],
								timer: 5000
							});
						}
					}
				})
			}
		});
	</script>
	<script type="text/javascript" src="{{asset('home/js/sweetalert.min.js')}}"></script>
</section>

@endsection