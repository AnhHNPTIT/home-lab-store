@extends('layouts.master_admin') 

@section('controll')
Posts List
@endsection

@section('content')
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Danh sách bài viết</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div style="margin-bottom: 30px;">
						<a href="/admin/new/post" data-toggle="modal" class="btn btn-info btn-add">Thêm bài viết mới</a>
					</div>
					<table id="list-posts" class="table table-bordered table-striped" style="margin-top : 10px;">
						<thead>
							<tr>
								<th class="col-sm-3" style="text-align: center;">Tiêu đề </th>
								<th class="col-sm-2" style="text-align: center;">Ảnh bìa</th>
								<th class="col-sm-2" style="text-align: center;">Chủ đề</th>
								<th class="col-sm-2" style="text-align: center;">Người đăng</th>
								<th class="col-sm-1" style="text-align: center;">Lượt xem</th>
								<th class="col-sm-2" style="text-align: center;">Hành động</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($posts))
							@foreach ($posts as $value)
							<tr>
								<td class="col-sm-3">{{$value->title}}</td>
								<td class="col-sm-2" style="text-align: center;">
									<div style="text-align: center;">
										<img style="width: 100%; height: 100px;" src="{{url('images/'.$value->thumbnail)}}" alt="">
									</div>
								</td>
								<td class="col-sm-2">{{$value->name}}</td>
								<td class="col-sm-2">{{$value->admin_name}}</td>

								<td class="col-sm-1" style="text-align: right;">{{$value->view_count}}</td>
								<td class="col-sm-2" style="text-align: center;">
									<button data-id="{{$value->id}}" type="button" class="btn btn-primary btn-show">
										<i class="glyphicon glyphicon-eye-open"></i>
									</button>

									<a href="/admin/post/detail/{{$value->id}}" type="button" class="btn btn-warning btn-edit" >
										<i class="glyphicon glyphicon-edit"></i>
									</a>

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

	<!-- modal view -->
	<div class="col-xs-12">
		<div class="modal fade" id="showPost" tabindex="-1" role="dialog" aria-labelledby="formPost" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content" style="border-radius: 20px;">
					@csrf
					<div class="box box-widget">
						<div class="box-header with-border">
							<div class="user-block">
								@if(Auth::guard('admin')->check())
								<img class="img-circle" src="{{url('/images/admins/'.Auth::guard('admin')->user()->avatar)}}" alt="User Post" style="margin-right: 10px;">
								@endif
								<h4 class="attachment-heading" id="showTitle"></h4>
								<p class="description" id=showCreatedAt></p>
							</div>
							<!-- /.user-block -->
							<div class="box-tools">
                               {{--  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                               </button> --}}

                               <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i></button>
                           </div>
                           <!-- /.box-tools -->
                       </div>
                       <!-- /.box-header -->
                       <div class="box-body">
                       	<!-- Attachment -->
                            {{-- <img class="attachment-img" src="{{asset('')}}admin/dist/img/photo1.png" alt="Attachment Image">
                            --}}
                            <div class="attachment-pushed">
                            	<div class="attachment-text" style="height: 400px; overflow: scroll; box-sizing: border-box;">
                            		<p id="showDescription">

                            		</p>

                            		<p id="showContent">

                            		</p>
                            	</div>
                            	<!-- /.attachment-text -->
                            </div>
                            <!-- /.attachment-pushed -->

                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    	$(document).ready(function() {
    		$('#list-posts').DataTable( {
    			"lengthMenu": [[25, 50, 100, 500, -1], [25, 50, 100, 500, "All"]]
    		} );
    	} );
    </script>

    <script type="text/javascript">
		// show
		$('.btn-show').click(function(){
			var id = $(this).attr('data-id');
			$.ajax({
				type : "get",
				url : "/admin/post/" + id,
				data : {
					_token :$('[name="_token"]').val(),
				},
				success : function(response){
					$('#showTitle').html(response.title),
					$('#showDescription').html(response.description);
					$('#showContent').html(response.content);
					$('#showCreatedAt').text(response.created_at)
				}
			});

			$('#showPost').modal('show');
		});

		// delete
		$('.btn-delete').click(function(){
			if(confirm('Bạn có muốn xóa không?')){
				var _this = $(this);
				var id = $(this).attr('data-id');
				$.ajax({
					type: 'delete',
					url: '/admin/post/' + id,
					data:{
						_token : $('[name="_token"]').val(),
					},
					success: function(response){
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
								window.location.href = "/admin/post/";
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