@extends('layouts.master_home')

@section('title')
Thông tin tài khoản - Home Lab
@endsection

@section('js')
<script type="text/javascript" src="{{asset('home/js/sweetalert.min.js')}}"></script>
@endsection

@section('home')
<div class="em-wrapper-main">
	<div class="container container-main">
		<div class="em-inner-main">
			<div class="em-main-container em-col2-left-layout">

				<div class="col-sm-18 col-sm-push-6 em-col-main clearfix">
					<div class="alert alert-danger error-mesage" style="display:none; width: 100%; font-size: 13px;">
						<ul></ul>
					</div>

					<div class="alert alert-success success-mesage" style="display:none; width: 100%; font-size: 13px;">
						<ul></ul>
					</div>

					<div class="alert alert-warning unsuccess-mesage" style="display:none; width: 100%; font-size: 13px;">
						<ul></ul>
					</div>
					<div class="account-create">
						@if(isset($customer))
						<form>
							<div class="fieldset">
								<ul class="form-list">
									<li class="fields">
										<div class="input-box">
											<label for="phone">Tài khoản : <i class="fa fa-user"></i> Khách hàng</label>
											<input hidden type="text" id="getID" class="input-text" value="{{$customer->id}}">
										</div>
									</li>
									<li class="fields">
										<label for="name">Điểm tích lũy :</label>
										<div class="input-box" style="text-align : center;">
											<span style="color : #f40303; font-size : 12px;">
												{{$customer->score_awards}}
												<img src="{{asset('/images/icons/diem-thuong.svg')}}" style="width : 15px; height : 15px;">
												= {{number_format($customer->score_awards*1000 ,0 ,'.' ,'.')}} VND
											</span>
										</div>
									</li>
									<li class="fields">
										<label for="name">Họ tên</label>
										<div class="input-box">
											<input type="text" id="getName" class="input-text" value="{{$customer->name}}">
										</div>
									</li>
									<label for="name" class="required"><em>*</em>Ngày sinh</label>
									<br>
									<div class="input-group date" style="margin-top:15px;">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										<input class="input-text" id="birthday" type="date" data-date="" data-date-format="DD-YYYY-MM" value="{{$customer->birthday}}">
									</div>

									<br>
									<li class="fields">
										<label for="name" class="required"><em>*</em>Giới tính</label>
										<div class="input-box">
											<select name="gender" id="gender">
												@if($customer->gender==1){
												<option value="0">Nữ</option>
												<option value="1" selected>Nam</option>
												}
												@else{
												<option value="0" selected>Nữ</option>
												<option value="1">Nam</option>
												}
												@endif
											</select><br>
										</div>
									</li>
									<li class="fields">
										<label for="phone">Số điện thoại</label>
										<div class="input-box">
											<input type="text" class="input-text" value="{{$customer->phone_number}}" disabled>
										</div>
									</li>
									<li class="fields">
										<label for="address">Địa chỉ nhận hàng</label>
										<div class="input-box">
											<input type="text" id="getAddress" class="input-text" value="{{$customer->address}}">
										</div>
									</li>
									<li class="fields">
										<label for="phone">Ngày đăng ký</label>
										<div class="input-box">
											<input type="text" class="input-text" value="{{$customer->created_at}}" disabled>
										</div>
									</li>
								</ul>
							</div>
							<div class="fieldset">
								<div class="buttons-set">
									<a onclick="history.go(-1);" href="javascript:avoid(0)" class="btn btn-danger">Trở về</a>
									<button type="button" id="btn_save" class="btn btn-info btn-save"><span><span>Lưu thay đổi</span></span>
									</button>
								</div>
							</div>
						</form>
						@endif
					</div>
				</div>

				<div class="col-sm-6 col-sm-pull-18 em-col-left em-sidebar">
					<div id="menuleftText" class="all_categories">
						<div class="menuleftText-title">
							<div class="menuleftPerson"><span class="em-text-upercase">Quản lý tài khoản</span>
							</div>
						</div>
					</div><!-- /.menuleftText -->

					<div class="menuleft">
						<div id="menu-default" class="mega-menu em-menu-icon">
							<div class="megamenu-wrapper wrapper-5_4607">
								<div class="em_nav" id="toogle_menu_5_4607">
									<ul class="vnav em-menu-icon effect-menu em-menu-long">
										<li class="menu-item-link menu-item-depth-0 fa fa-child">
											<a class="em-menu-link" href="{{ url('/my_account/'.Auth::user()->id) }}" id="link-my-account">
												<span style="color : #ffffff; border-color: #fdbd8d; background-color: #E67E22CC;"> Thông tin tài khoản </span> </a>
										</li><!-- /.menu-item-link -->

										<li class="menu-item-link menu-item-depth-0 fa fa-shopping-cart">
											<a class="em-menu-link" href="{{ url('/transaction/history/'.Auth::user()->id) }}" id="link-transaction-history"> <span> Lịch sử đặt hàng </span> </a>
										</li><!-- /.menu-item-link -->

										<li class="menu-item-link menu-item-depth-0 fa fa-heart">
											<a class="em-menu-link" href="{{ url('/wishlist') }}"> <span> Sản phẩm yêu thích </span> </a>
										</li><!-- /.menu-item-link -->

										<li class="menu-item-link menu-item-depth-0 fa fa-recycle">
											<a class="em-menu-link" href="{{ url('/change/password') }}" id="link-change-password"> <span> Đổi mật khẩu </span> </a>
										</li><!-- /.menu-item-link -->
									</ul><!-- /.vnav -->
								</div>
							</div><!-- /.megamenu-wrapper -->
						</div>
					</div><!-- /.menuleft -->

				</div><!-- /.block-layered-nav -->

			</div><!-- /.em-sidebar -->

		</div><!-- /.em-main-container -->
	</div>
</div>
</div><!-- /.em-wrapper-main -->
<script src="{{asset('home/js/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript">
	$('.btn-save').click(function() {
		var form_data = new FormData();
		form_data.append("_token", '{{csrf_token()}}');
		form_data.append("customer_id", $('#getID').val());
		form_data.append("name", $('#getName').val());
		form_data.append("birthday", $('#birthday').val());
		form_data.append("gender", $('#gender').val());
		form_data.append("address", $('#getAddress').val());

		$.ajax({
			type: 'post',
			url: '/my_account',
			data: form_data,
			dataType: 'json',
			contentType: false,
			processData: false,
			success: function(response) {
				if (response.is === 'failed') {
					$(".error-mesage").find("ul").html('');
					$(".error-mesage").css('display', 'block');
					$(".success-mesage").css('display', 'none');
					$(".unsuccess-mesage").css('display', 'none');

					$.each(response.error, function(key, value) {
						$(".error-mesage").find("ul").append('<li>' + value + '</li>');
					});

					window.scroll({
						top: 0,
						behavior: 'smooth'
					});
				}
				if (response.is === 'success') {
					$(".success-mesage").find("ul").html('');
					$(".success-mesage").css('display', 'block');
					$(".error-mesage").css('display', 'none');
					$(".unsuccess-mesage").css('display', 'none');

					$(".success-mesage").find("ul").append('<li>' + response.complete + '</li>');

					window.scroll({
						top: 0,
						behavior: 'smooth'
					});
				}
				if (response.is === 'unsuccess') {
					$(".unsuccess-mesage").find("ul").html('');
					$(".unsuccess-mesage").css('display', 'block');
					$(".error-mesage").css('display', 'none');
					$(".success-mesage").css('display', 'none');

					$(".unsuccess-mesage").find("ul").append('<li>' + response.uncomplete + '</li>');

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