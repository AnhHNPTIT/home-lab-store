@extends('layouts.master_admin') 

@section('controll')
New Collaborator
@endsection

@section('content')

<div class="container box box-body pad">
	<div class="row">
		<div class="col-xs-12">
			<div class="alert alert-danger error-msg" style="display:none">
				<ul></ul>
			</div>

			<div class="alert alert-success success-msg" style="display:none">
				<ul></ul>
			</div>

			<div class="alert alert-warning unsuccess-msg" style="display:none">
				<ul></ul>
			</div>
		</div>

		<div class="col-xs-12">

			<div class="box-header">
				<h3 class="box-title">Tài khoản nhân viên</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				@csrf
				<div class="form-group">
					<label for="" style="margin-top: 10px;">Tên nhân viên</label>
					<input name="name" type="text" class="form-control" id="name" placeholder="Ví dụ : Phan Khánh Hưng"><br>

					<label for="" style="margin-top: 10px;">Ảnh nhân viên</label>
					<input name="image" type="file" class="form-control" id="getImage" placeholder="Image" onchange="readURL(this);"><br>
					<div style="text-align : center; margin-top : 10px; margin-botom : 10px;">
						<img id="thumbnail" src="#" alt=""/>
					</div>
					<script>
						function readURL(input) {
							if (input.files && input.files[0]) {
								var reader = new FileReader();

								reader.onload = function (e) {
									$('#thumbnail')
										.attr('src', e.target.result)
										.width(150)
										.height(200);
								};

								reader.readAsDataURL(input.files[0]);
							}
						}
					</script>
						
					<label for="" style="margin-top: 10px;">Ngày sinh</label>
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" class="form-control pull-right" id="datepicker">
					</div>       

					<label for="" style="margin-top: 30px;">Giới tính</label>
					<select name="gender" class="form-control" id="gender">
						<option value="0">Nữ</option>
						<option value="1">Nam</option>
					</select><br>
						
					<label for="" style="margin-top: 10px;">Số điện thoại</label>
					<input name="phone_number" type="text" class="form-control" id="phone_number" placeholder="Ví dụ : 0982668926"><br>

					<label for="" style="margin-top: 10px;">Email</label>
					<input name="email" type="text" class="form-control" id="email" placeholder="Ví dụ : hungpk@gmail.com"><br>

					<label for="" style="margin-top: 10px;">Địa chỉ</label>
					<input name="address" type="text" class="form-control" id="address" placeholder="Số 169 Trương Định - Hai Bà Trưng - Hà Nội"><br>

					<label for="" style="margin-top: 10px;">Mật khẩu</label>
					<input name="password" type="password" class="form-control" id="password" placeholder="Mật khẩu"><br>

					<button type="button" class="btn btn-success btn-save" >Đăng ký</button>

					<a href="/admin/user/collaborator" class="btn btn-danger">Hủy bỏ</a>
				</div>
			</div>

		</div>
	</div>
</div>

<script type="text/javascript">
    $(function () {
        //Date picker
        $('#datepicker').datepicker({
        autoclose: true
        });
    })
</script>

<script type="text/javascript">

	$('.btn-save').click(function(){
		var form_data = new FormData();
		form_data.append("_token", '{{csrf_token()}}');
		form_data.append("name", $('#name').val());
        form_data.append('avatar', $('input[type=file]')[0].files[0]);
        form_data.append("birthday", $('#datepicker').val());
        form_data.append("gender", $('#gender').val());
        form_data.append("phone_number", $('#phone_number').val());
        form_data.append("email", $('#email').val());
        form_data.append("address", $('#address').val());
        form_data.append("password", $('#password').val());

		$.ajax({
			type : 'post',
			url : '/admin/user/collaborator',
			data : form_data,
			dataType : 'json',
			contentType: false,
			processData: false,
			success : function(response){
				if(response.is === 'failed'){
					$(".error-msg").find("ul").html('');
					$(".error-msg").css('display','block');
					$(".success-msg").css('display','none');
					$(".unsuccess-msg").css('display','none');

					$.each(response.error, function( key, value ) {
						$(".error-msg").find("ul").append('<li>'+value+'</li>');
					});

                    window.scroll({
                        top: 100,
                        behavior: 'smooth'
                    });
				}
				if(response.is === 'success'){
					$(".success-msg").find("ul").html('');
					$(".success-msg").css('display','block');
					$(".error-msg").css('display','none');
					$(".unsuccess-msg").css('display','none');

					$(".success-msg").find("ul").append('<li>'+response.complete+'</li>');

                    window.scroll({
                        top: 100,
                        behavior: 'smooth'
                    });
				}
				if(response.is === 'unsuccess'){
					$(".unsuccess-msg").find("ul").html('');
					$(".unsuccess-msg").css('display','block');
					$(".error-msg").css('display','none');
					$(".success-msg").css('display','none');

					$(".unsuccess-msg").find("ul").append('<li>'+response.uncomplete+'</li>');

                    window.scroll({
                        top: 100,
                        behavior: 'smooth'
                    });
				}
			}
		});
	});
</script>
@endsection