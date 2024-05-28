@extends('layouts.master_admin') 

@section('controll')
Collaborator Detail
@endsection

@section('content')

<script src="{{ asset("layout_user/plugins/selectize.min.js") }}"></script>
<link rel="stylesheet" href="{{ asset("layout_user/plugins/selectize.bootstrap3.min.css") }}">

<div class="container box pad">
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
		@if(isset($collaborator))
		<div class="col-xs-12">
				<div class="box-body">
					<legend></legend>
					<div class="form-group">
						@csrf
						<input type="hidden" class="form-control" id="getCollaboratorID" value="{{ $collaborator->id }}"><br>
						
						<label for="" style="margin-top: 10px;">Tên nhân viên</label>
						<input name="name" type="text" class="form-control" id="getName" placeholder="Ví dụ : Phan Khánh Hưng" value="{{$collaborator->name}}"><br>

						<label for="" style="margin-top: 10px;">Ảnh nhân viên</label>
						<input name="image" type="file" class="form-control" id="getAvatar" placeholder="Image" onchange="readURL(this);"><br>
						<div style="text-align : center; margin-top : 10px; margin-botom : 10px;">
							<img id="thumbnail" src="#" alt=""/>
						</div>
						<script>
							var collaborator_avatar = "<?php echo $collaborator->avatar ?>";
							$('#thumbnail').attr('src', '/images/admins/'+collaborator_avatar).width(150).height(200);
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
							<input class="form-control pull-right" id="getBirthday" type="date" data-date="" value="{{$collaborator->birthday}}">
						</div>

						<label for="" style="margin-top: 10px;">Giới tính</label>
						<div class="input-box">
							<select name="gender" id="getGender" class="form-control pull-right">
								@if($collaborator->gender==1){
								<option value="0">Nữ</option>
								<option value="1" selected>Nam</option>
								}
								@else{
								<option value="0" selected>Nữ</option>
								<option value="1">Nam</option>
								}
								@endif
							</select><br>
						</div><br>
							
						<label for="" style="margin-top: 10px;">Số điện thoại</label>
						<input name="phone_number" type="text" class="form-control" id="getPhoneNumber" placeholder="Ví dụ : 0982668926" value="{{$collaborator->phone_number}}"><br>

						<label for="" style="margin-top: 10px;">Email</label>
						<input name="email" type="text" class="form-control" id="getEmail" placeholder="Ví dụ : hungpk@gmail.com" value="{{$collaborator->email}}" disable><br>

						<label for="" style="margin-top: 10px;">Địa chỉ</label>
						<input name="address" type="text" class="form-control" id="getAddress" placeholder="Số 169 Trương Định - Hai Bà Trưng - Hà Nội" value="{{$collaborator->address}}"><br>
					</div>
					<button type="button" class="btn btn-primary btn-save">Cập nhật</button>
				</div>
		</div>
		@endif
	</div>

	<script type="text/javascript">
		$('.btn-save').click(function(){
			var form_data = new FormData();
			form_data.append("_token", '{{csrf_token()}}');
			form_data.append("id", $('#getCollaboratorID').val());
			form_data.append("name", $('#getName').val());
			form_data.append('avatar', $('input[type=file]')[0].files[0]);
			form_data.append("birthday", $('#getBirthday').val());
			form_data.append("gender", $('#getGender').val());
			form_data.append("phone_number", $('#getPhoneNumber').val());
			form_data.append("address", $('#getAddress').val());

			$.ajax({
				type : 'post',
				url : '/admin/user/collaborator/update',
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