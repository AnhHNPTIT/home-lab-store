@extends('layouts.master_admin') 

@section('controll')
Manufacturers List
@endsection

@section('content')
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Danh sách nhà sản xuất</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div style="margin-bottom: 30px;">
						<a href="/admin/new/manufacturer" data-toggle="modal" class="btn btn-info btn-add">Thêm nhà sản xuất mới</a>
					</div>
					<table id="list-manufacturers" class="table table-bordered table-striped" style="margin-top : 10px;">
						<thead>
							<tr>
								<th class="col-sm-1" style="text-align: center;">ID</th>
								<th class="col-sm-4" style="text-align: center;">Tên nhà sản xuất</th>
								<th class="col-sm-3" style="text-align: center;">Liên kết</th>
								<th class="col-sm-2" style="text-align: center;">Hành động</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($manufacturers))
							@foreach ($manufacturers as $value)
							<tr>
								<td class="col-sm-1" style="text-align: center;">{{$value->id}}</td>
								<td class="col-sm-4">{{$value->name}}</td>
								<td class="col-sm-3">{{$value->link}}</td>
								<td class="col-sm-2" style="text-align: center;">
									<button data-id="{{$value->id}}" type="button" title="Chính sửa" class="btn btn-warning btn-edit" >
										<i class="glyphicon glyphicon-edit"></i>
									</button>

									<button data-id="{{$value->id}}" type="button" title="Xóa" class="btn btn-danger btn-delete">
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

	<!-- modal edit -->
	<div class="col-xs-12">
		<div class="modal fade" id="editManufacture" tabindex="-1" role="dialog" aria-labelledby="formManufacture" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content" style="border-radius : 10px;">
					<div class="modal-header">
						<h4 class="modal-title">Cập nhật thông tin</h4>
					</div>
					<form action="" id="formEditCategory">
						@csrf
						<div class="modal-body">
							<input name="id" type="text" class="form-control" id="editID" placeholder="ID" disabled><br>

							<input name="name" type="text" class="form-control" id="editName" placeholder="Tên nhà sản xuất"><br>

							<input name="link" type="text" class="form-control" id="editLink" placeholder="Liên kết"><br>

							<input name="slug" type="text" class="form-control" id="editSlug" placeholder="Slug" disabled><br>
						</div>

						<div class="modal-footer">
							<button type="submit" class="btn btn-success btn-update" data-dismiss="modal">Cập nhật</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$('#list-manufacturers').DataTable( {
				"lengthMenu": [[25, 50, 100, 500, -1], [25, 50, 100, 500, "All"]]
			} );
		} );
	</script>

	<script type="text/javascript">
		$('.btn-edit').click(function(){
			var id = $(this).attr('data-id');
			$.ajax({
				type : "get",
				url : "/admin/manufacturer/" + id,
				data : {
					_token :$('[name="_token"]').val(),
				},
				success : function(response){
					$('#editID').val(response.id),
					$('#editName').val(response.name),
					$('#editLink').val(response.link),
					$('#editSlug').val(response.slug)
				}
			});

			$('#editManufacture').modal('show');
		});
		
		$('.btn-update').click(function(){
			var id = $('#editID').val();
			$.ajax({
				type: 'put',
				url: '/admin/manufacturer/' + id,
				data:{
					_token :$('[name="_token"]').val(),
					id : $('#editID').val(),
					name : $('#editName').val(),
					link : $('#editLink').val()
				},
				success: function(response){
					if(response.is === 'failed'){
						$.each(response.error, function( key, value ) {
							message = value;
						});

						swal({
							title: "Thất bại!",
							text: message,
							icon: "error",
							buttons: true,
							buttons: ["Ok"],
							timer: 3000
						});
					}
					if(response.is === 'success'){
						swal({
							title: "Hoàn thành!",
							text: response.complete,
							icon: "success",
							buttons: true,
							buttons: ["Ok"],
							timer: 1000
						});

						setTimeout(function () {
							window.location.href="/admin/manufacturer/";
						},1000);
					}
					if(response.is === 'unsuccess'){
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
					url: '/admin/manufacturer/' + id,
					data:{
						_token : $('[name="_token"]').val(),
					},
					success: function(response){
						if(response.is === 'success'){
							_this.parent().parent().remove();
							swal({
								title: "Hoàn thành!",
								text: response.complete,
								icon: "success",
								buttons: true,
								buttons: ["Ok"],
								timer: 1000
							});

							setTimeout(function () {
								window.location.href="/admin/manufacturer/";
							},1000);
						}
						if(response.is === 'unsuccess'){
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