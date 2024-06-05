@extends('layouts.master_admin') 

@section('controll')
Danh sách liên hệ
@endsection

@section('content')
<!-- Main content -->
<section class="content">
	@csrf
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Danh sách liên hệ</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table id="list-contacts" class="table table-bordered table-striped" style="margin-top : 10px;">
						<thead>
							<tr>
								<th class="col-sm-2" style="text-align: center;">Họ tên</th>
								<th class="col-sm-1" style="text-align: center;">Số điện thoại</th>
								<th class="col-sm-1" style="text-align: center;">Nội dung</th>
								<th class="col-sm-1" style="text-align: center;">Trạng thái</th>
								<th class="col-sm-3" style="text-align: center;">Hành động</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($contacts))
							@foreach ($contacts as $value)
							<tr>
								<td class="col-sm-2">{{$value->name}}</td>
								<td class="col-sm-1">{{$value->phone_number}}</td>
								<td class="col-sm-1">{{$value->content}}</td>
								@if($value->status == 0)
									<td class="col-sm-1">Chưa xử lý</td>
								@else
									<td class="col-sm-1">Đã xử lý</td>
								@endif
								<td class="col-sm-3" style="text-align: center;">
									@if($value->status == 0)
									<button data-id="{{$value->id}}" type="button" title="Đã xử lý" class="btn btn-info btn-status" >
										<i class="fa fa-unlock"></i>
									</button>
									@else
									<button data-id="{{$value->id}}" type="button" title="Chưa xử lý" class="btn btn-success btn-status" >
										<i class="fa fa-stop-circle"></i>
									</button>
									@endif
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
    		$('#list-contacts').DataTable( {
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
				url: '/admin/update-status-contact/' + id,
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
							window.location.href = "/admin/contact/";
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
	</script>
	<script type="text/javascript" src="{{asset('home/js/sweetalert.min.js')}}"></script>
</section>
<!-- /.content -->
@endsection