@extends('layouts.master_home')

@section('title')
   	Cập nhật thông tin - Home Lab
@endsection

@section('js')
<script type="text/javascript" src="{{asset('home/js/sweetalert.min.js')}}"></script>
@endsection

@section('home')
<div class="em-wrapper-main">
    <div class="container container-main">
        <div class="em-inner-main">
            <div class="em-main-container">

				<div class="col-sm-24 clearfix">
					<div class="error-mesage" style="display:none; width: 100%; font-size: 13px; color:#ff0000;">
						<ul></ul>
					</div>

					<div class="success-mesage" style="display:none; width: 100%; font-size: 13px; color:#12f403;">
						<ul></ul>
					</div>

					<div class="unsuccess-mesage" style="display:none; width: 100%; font-size: 13px; color:#ff9800;">
						<ul></ul>
					</div>
					<div class="account-create">
						<form>
						@csrf
							<div class="fieldset">
								<ul class="form-list">
                                    <li class="fields">
										<div class="page-title">
											<h2>Cập nhật thông tin</h2>
										</div>
                                    </li>
									<li class="fields">
										<label for="name" class="required"><em>*</em>Họ tên</label>
										<div class="input-box">
											<input type="text" id="name" class="input-text" value="">
										</div>
                                    </li>
                                    <br>
                                    <label for="birthday" class="required"><em>*</em>Ngày sinh</label>
                                    <br>
                                    <div class="input-group date" style="margin-top:15px;">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input class="input-text" id="birthday" type="date" data-date="" data-date-format="DD-YYYY-MM" value="1990-08-30">
                                    </div>  
                                   
                                    <br>
                                    <li class="fields">
										<label for="gender" class="required"><em>*</em>Giới tính</label>
										<div class="input-box">
                                        <select name="gender" id="gender">
                                            <option value="0">Nữ</option>
                                            <option value="1">Nam</option>
                                        </select><br>
										</div>
                                    </li>								
                                    <br>
									<li class="fields">
										<label for="phone_number" class="required"><em>*</em>Số điện thoại</label>
										<div class="input-box">
                                            @if(isset($phone_number))
											    <input id='phone_number' type="text" class="input-text" value="{{$phone_number}}" disabled>
                                            @endif
										</div>
                                    </li>
                                    <br>
                                    <li class="fields">
										<label for="address" class="required"><em>*</em>Địa chỉ nhận hàng</label>
										<div class="input-box">
											<input type="text" id="address" name="address" class="input-text">
										</div>
                                    </li>
									<br>
                                    <li class="fields">
										<label for="password" class="required"><em>*</em>Mật khẩu</label>
										<div class="input-box">
											<input type="password" id="password" name="password" class="input-text">
										</div>
                                    </li>
									<br>
                                    <li class="fields">
										<label for="re_password" class="required"><em>*</em>Nhập lại mật khẩu</label>
										<div class="input-box">
											<input type="password" id="re_password" name="re_password" class="input-text">
										</div>
                                    </li>
								</ul>
							</div>
							<div class="fieldset">
								<div class="buttons-set">
									<button type="button" id="btn_save" class="btn btn-info btn-save"><span><span>Cập nhật thông tin</span></span>
									</button>
								</div>
							</div>
                        </form>
					</div>
				</div>

            </div><!-- /.em-main-container -->
        </div>
    </div>
</div><!-- /.em-wrapper-main -->
<script src="{{asset('home/js/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript">
	$('.btn-save').click(function(){
		var form_data = new FormData();
		form_data.append("_token", '{{csrf_token()}}');
		form_data.append("name", $('#name').val());
		form_data.append("birthday", $('#birthday').val());
		form_data.append("gender", $('#gender').val());
		form_data.append("phone_number", $('#phone_number').val());
		form_data.append("address", $('#address').val());
		form_data.append("password", $('#password').val());
		form_data.append("re_password", $('#re_password').val());

		$.ajax({
			type : 'post',
			url : '/create/account',
			data : form_data,
			dataType : 'json',
			contentType: false,
			processData: false,
			success : function(response){
				if(response.is === 'failed'){
					$(".error-mesage").find("ul").html('');
					$(".error-mesage").css('display','block');
					$(".success-mesage").css('display','none');
					$(".unsuccess-mesage").css('display','none');

					$.each(response.error, function( key, value ) {
						$(".error-mesage").find("ul").append('<li><i class="fa fa-exclamation-triangle"></i> '+value+'</li>');
					});

					window.scroll({
						top: 0,
						behavior: 'smooth'
					});
				}
				if(response.is === 'success'){
					$(".success-mesage").find("ul").html('');
					$(".success-mesage").css('display','block');
					$(".error-mesage").css('display','none');
					$(".unsuccess-mesage").css('display','none');

					$(".success-mesage").find("ul").append('<li>'+response.complete+'</li>');

					window.scroll({
						top: 0,
						behavior: 'smooth'
					});

					setTimeout(function () {
						window.location.href="/";
					},2000);
				}
				if(response.is === 'unsuccess'){
					$(".unsuccess-mesage").find("ul").html('');
					$(".unsuccess-mesage").css('display','block');
					$(".error-mesage").css('display','none');
					$(".success-mesage").css('display','none');

					$(".unsuccess-mesage").find("ul").append('<li> <i class="fa fa-exclamation-triangle"></i> '+response.uncomplete+'</li>');

					window.scroll({
						top: 0,
						behavior: 'smooth'
					});
				}
			}
		});
	});
</script>            
@endsection



