@extends('layouts.master_admin') 

@section('controll')
products List
@endsection

@section('content')
<!-- Main content -->
<section class="content">
	@csrf
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Danh sách sản phẩm</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div style="margin-bottom: 30px;">
						<a href="/admin/new/product" data-toggle="modal" class="btn btn-info btn-add">Thêm sản phẩm</a>
					</div>
					<table id="list-products" class="table table-bordered table-striped" style="margin-top : 10px;">
						<thead>
							<tr>
								<th class="col-sm-2" style="text-align: center;">Tên Sản phẩm</th>
								<th class="col-sm-1" style="text-align: center;">Mã</th>
								<th class="col-sm-1" style="text-align: center;">Phân loại</th>
								<th class="col-sm-1" style="text-align: center;">Ảnh</th>
								<th class="col-sm-1" style="text-align: center;">Giá nhập</th>
								<th class="col-sm-1" style="text-align: center;">Giá bán</th>
								<th class="col-sm-1" style="text-align: center;">Số lượng còn</th>
								<th class="col-sm-1" style="text-align: center;">Số lượng đã bán</th>
								<th class="col-sm-1" style="text-align: center;">Lượt xem</th>
								<th class="col-sm-3" style="text-align: center;">Hành động</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($products))
							@foreach ($products as $value)
							<tr>
								<td class="col-sm-2">{{$value->name}}</td>
								<td class="col-sm-1">{{$value->code}}</td>
								<td class="col-sm-1">{{$value->product_category_name}}</td>
								<td class="col-sm-1">
									<div style="text-align: center;">
										<img style="width: 100%; height: 100px;" src="{{url('images/products/'.$value->image)}}" alt="">
									</div>
								</td>
								<td class="col-sm-1" style="text-align: right;">{{number_format($value->price_prime*1000 ,0 ,'.' ,'.')}} VND</td>
								<td class="col-sm-1" style="text-align: right;">{{number_format($value->price_sale*1000 ,0 ,'.' ,'.')}} VND</td>
								<td class="col-sm-1" style="text-align: right;">{{$value->quantity}}</td>
								<td class="col-sm-1" style="text-align: right;">{{$value->bought}}</td>
								<td class="col-sm-1" style="text-align: right;">{{$value->view_count}}</td>
								<td class="col-sm-3" style="text-align: center;">
									<a href="/admin/product/detail/{{$value->id}}" type="button" class="btn btn-warning btn-edit" >
										<i class="glyphicon glyphicon-edit"></i>
									</a>

									@if($value->status == 0)
									<button data-id="{{$value->id}}" type="button" title="Kích hoạt" class="btn btn-info btn-status" >
										<i class="fa fa-unlock"></i>
									</button>
									@else
									<button data-id="{{$value->id}}" type="button" title="Tạm ngưng" class="btn btn-success btn-status" >
										<i class="fa fa-stop-circle"></i>
									</button>
									@endif

									<button data-id="{{$value->id}}" type="button" class="btn btn-danger btn-delete">
										<i class="glyphicon glyphicon-trash"></i>
									</button>
								</td>
							</tr>
							@endforeach
							@endif
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
    		$('#list-products').DataTable( {
    			"lengthMenu": [[25, 50, 100, 500, -1], [25, 50, 100, 500, "All"]]
    		} );
    	} );
    </script>

	<script type="text/javascript">
		// block or unblock
		$('.btn-status').click(function(){
			var id = $(this).attr('data-id');
			$.ajax({
				type: 'put',
				url: '/admin/update-status-product/' + id,
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
							window.location.href = "/admin/product/";
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
					url: '/admin/product/' + id,
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
								window.location.href = "/admin/product/";
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
<!-- /.content -->
@endsection