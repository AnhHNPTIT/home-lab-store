@extends('layouts.master_admin')

{{-- thay đổi nội dung phần controll --}}
@section('controll')
Tags List
@endsection

{{-- thay đổi nội dung phần content --}}
@section('content')
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Danh sách các thẻ</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div style="margin-bottom: 30px;">
						<a href="/admin/new/tag" data-toggle="modal" class="btn btn-success btn-add">Tạo thẻ</a>
					</div>
					<table id="list-tags" class="table table-bordered table-striped" style="margin-top : 10px;">
						<thead>
							<tr>
								<th class="col-sm-3" style="text-align: center;">ID</th>
								<th class="col-sm-3" style="text-align: center;">Tên thẻ</th>
								<th class="col-sm-3" style="text-align: center;">Đường dẫn</th>
								<th class="col-sm-3" style="text-align: center;">Hành động</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($tags as $value)
							<tr>
								<td class="col-sm-3" style="text-align: center;">{{$value->id}}</td>
								<td class="col-sm-3">{{$value->name}}</td>
								<td class="col-sm-3">{{$value->slug}}</td>
								<td class="col-sm-3" style="text-align: center;">
									<button data-id="{{$value->id}}" type="button" class="btn btn-primary btn-show">
										<i class="glyphicon glyphicon-eye-open"></i>
									</button>

									<button data-id="{{$value->id}}" type="button" class="btn btn-warning btn-edit">
										<i class="glyphicon glyphicon-edit"></i>
									</button>

									<button data-id="{{$value->id}}" type="button" class="btn btn-danger btn-delete">
										<i class="glyphicon glyphicon-trash"></i>
									</button>
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

	<!-- modal view -->
	<div class="col-xs-12">
		<div class="modal fade" id="showTag" tabindex="-1" role="dialog" aria-labelledby="formTag" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content" style="border-radius : 10px;">
					<div class="modal-header">
						<h4 class="modal-title">Thông tin thẻ </h4>
					</div>
					<form action="" id="">
						@csrf
						<div class="modal-body">
							<input name="id" type="text" class="form-control" id="showId" placeholder="Id" disabled><br>

							<input name="name" type="text" class="form-control" id="showName" placeholder="Name" disabled><br>

							<input name="slug" type="text" class="form-control" id="showSlug" placeholder="Slug" disabled><br>

							<input name="created_at" type="text" class="form-control" id="showCreatedAt" placeholder="Created At" disabled><br>

							<input name="updated_at" type="text" class="form-control" id="showUpdatedAt" placeholder="Updated At" disabled><br>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- modal edit -->
	<div class="col-xs-12">
		<div class="modal fade" id="editTag" tabindex="-1" role="dialog" aria-labelledby="formTag" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content" style="border-radius : 10px;">
					<div class="modal-header">
						<h4 class="modal-title">Cập nhật thông tin thẻ</h4>
					</div>
					<form action="" id="formEditTag">
						@csrf
						<div class="alert alert-danger error-msg" style="display:none">
							<ul></ul>
						</div>

						<div class="alert alert-success success-msg" style="display:none">
							<ul></ul>
						</div>

						<div class="alert alert-warning unsuccess-msg" style="display:none">
							<ul></ul>
						</div>
						<div class="modal-body">
							<input name="id" type="text" class="form-control" id="editID" placeholder="ID" disabled><br>

							<input name="name" type="text" class="form-control" id="editName" placeholder="Name"><br>

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
			$('#list-tags').DataTable({
				"lengthMenu": [
					[25, 50, 100, 500, -1],
					[25, 50, 100, 500, "All"]
				]
			});
		});
	</script>

	<script type="text/javascript">
		// show
		$('.btn-show').click(function() {
			var id = $(this).attr('data-id');
			$.ajax({
				type: "get",
				url: "/admin/tag/" + id,
				data: {
					_token: $('[name="_token"]').val(),
				},
				success: function(response) {
					$('#showId').val(response.id),
						$('#showName').val(response.name),
						$('#showSlug').val(response.slug),
						$('#showCreatedAt').val(response.created_at),
						$('#showUpdatedAt').val(response.updated_at)
				}
			});

			$('#showTag').modal('show');
		});

		$('.btn-edit').click(function() {
			var id = $(this).attr('data-id');
			$.ajax({
				type: "get",
				url: "/admin/tag/" + id,
				data: {
					_token: $('[name="_token"]').val(),
				},
				success: function(response) {
					$('#editID').val(response.id),
						$('#editName').val(response.name),
						$('#editSlug').val(response.slug)
				}
			});

			$('#editTag').modal('show');
		});

		$('.btn-update').click(function() {
			var id = $('#editID').val();
			$.ajax({
				type: 'put',
				url: '/admin/tag/' + id,
				data: {
					_token: $('[name="_token"]').val(),
					id: $('#editID').val(),
					name: $('#editName').val()
				},
				success: function(response) {
					if (response.is === 'failed') {
						$.each(response.error, function(key, value) {
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
							window.location.href = "/admin/tag/";
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
		$('.btn-delete').click(function() {
			if (confirm('Bạn có muốn xóa không?')) {
				var _this = $(this);
				var id = $(this).attr('data-id');
				$.ajax({
					type: 'delete',
					url: '/admin/tag/' + id,
					data: {
						_token: $('[name="_token"]').val(),
					},
					success: function(response) {
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
								window.location.href = "/admin/tag/";
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