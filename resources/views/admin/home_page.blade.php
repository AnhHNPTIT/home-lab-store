@extends('layouts.master_admin')

@section('controll')
Trang chủ
@endsection

@section('content')
<!-- Info boxes -->
<div class="row">
	<div class="col-md-3 col-sm-6 col-xs-12">
		<!-- small box -->
		<div class="small-box" style="background: #2A8E0F; color: #fff;">
			<div class="inner">
				@if(isset($count_customer))
				<h3>{{$count_customer}}</h3>
				@endif

				<p>Khách hàng</p>
			</div>
			<div class="icon">
				<i class="fa fa-users" style="color: #fff;"></i>
			</div>
		</div>
	</div>
	<!-- ./col -->
	<div class="col-md-3 col-sm-6 col-xs-12">
		<!-- small box -->
		<div class="small-box" style="background: blue; color: #fff;">
			<div class="inner">
				@if(isset($count_collaborator))
				<h3>{{$count_collaborator}}</h3>
				@endif

				<p>Nhân viên</p>
			</div>
			<div class="icon">
				<i class="fa fa-user-plus" style="color: #fff;"></i>
			</div>
		</div>
	</div>
	<!-- ./col -->
	<div class="col-md-3 col-sm-6 col-xs-12">
		<!-- small box -->
		<div class="small-box" style="background: orange; color: #fff;">
			<div class="inner">
				@if(isset($count_admin))
				<h3>{{$count_admin}}</h3>
				@endif

				<p>Quản trị viên</p>
			</div>
			<div class="icon">
				<i class="fa fa-user" style="color: #fff;"></i>
			</div>
		</div>
	</div>
	<!-- ./col -->

	<div class="col-md-3 col-sm-6 col-xs-12">
		<!-- small box -->
		<div class="small-box" style="background: #009688; color: #fff;">
			<div class="inner">
				@if(isset($count_user_total))
				<h3>{{$count_user_total}}</h3>
				@endif

				<p>Tổng số người dùng</p>
			</div>
			<div class="icon">
				<i class="fa fa-user-circle-o" style="color: #fff;"></i>
			</div>
		</div>
	</div>
	<!-- ./col -->
</div>

<div class="row">
	<div class="col-md-3 col-sm-6 col-xs-12">
		<!-- small box -->
		<div class="small-box" style="background: yellow; color: #131312;">
			<div class="inner">
				@if(isset($total_vitamin_product))
				<h3>{{$total_vitamin_product}}</h3>
				@endif

				<p>Bổ sung vitamin & khoáng chất</p>
			</div>
			<div class="icon">
				<i class="fa fa-star-o" style="color: #fff;width: 70px;"></i>
			</div>
		</div>
	</div>
	<!-- ./col -->

	<div class="col-md-3 col-sm-6 col-xs-12">
		<!-- small box -->
		<div class="small-box" style="background: #C6009A; color: #fff;">
			<div class="inner">
				@if(isset($total_energy_product))
				<h3>{{$total_energy_product}}</h3>
				@endif

				<p>Nước tăng lực & giải khát</p>
			</div>
			<div class="icon">
				<i class="fa fa-star" style="color: #fff;width: 76px;"></i>
			</div>
		</div>
	</div>
	<!-- ./col -->

	<div class="col-md-3 col-sm-6 col-xs-12">
		<!-- small box -->
		<div class="small-box" style="background: #01FAE6; color: #011110;">
			<div class="inner">
				@if(isset($total_fiber_product))
				<h3>{{$total_fiber_product}}</h3>
				@endif

				<p>Giàu chất xơ tiêu hóa</p>
			</div>
			<div class="icon">
				<i class="fa fa-truck" style="color: #fff;width: 85px;"></i>
			</div>
		</div>
	</div>

	<div class="col-md-3 col-sm-6 col-xs-12">
		<!-- small box -->
		<div class="small-box" style="background: #1b00ff85; color: #fff;">
			<div class="inner">
				@if(isset($total_special_product))
				<h3>{{$total_special_product}}</h3>
				@endif

				<p>Chức năng đặc biệt</p>
			</div>
			<div class="icon">
				<i class="fa fa-medkit" style="color: #fff;"></i>
			</div>
		</div>
	</div>
	<!-- ./col -->
</div>

<div class="row">
	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon" style="background: #15FC01; color: #fff;">
				<i class="glyphicon glyphicon-ok-circle"></i>
			</span>

			<div class="info-box-content">
				<span class="info-box-text">Đơn hàng hoàn thành</span>
				<span class="info-box-number">
					@if(isset($count_transaction_delivered))
					{{$count_transaction_delivered}}
					@endif
				</span>
			</div>
			<!-- /.info-box-content -->
		</div>
		<!-- /.info-box -->
	</div>
	<!-- /.col -->
	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon" style="background: #019FFA; color: #fff;">
				<i class="fa fa-cloud-upload"></i>
			</span>

			<div class="info-box-content">
				<span class="info-box-text">Nhà sản xuất</span>
				<span class="info-box-number">
					@if(isset($count_manufacture))
					{{$count_manufacture}}
					@endif
				</span>
			</div>
			<!-- /.info-bo	x-content -->
		</div>
		<!-- /.info-box -->
	</div>
	<!-- /.col -->

	<!-- fix for small devices only -->
	<div class="clearfix visible-sm-block"></div>

	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon" style="background: #953BE1; color: #fff;">
				<i class="fa fa-user-md"></i>
			</span>

			<div class="info-box-content">
				<span class="info-box-text">Đơn vị tính</span>
				<span class="info-box-number">
					@if(isset($count_unit))
					{{$count_unit}}
					@endif
				</span>
			</div>
			<!-- /.info-box-content -->
		</div>
		<!-- /.info-box -->
	</div>
	<!-- /.col -->
</div>

<div class="row">
	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-aqua"><i class="fa fa-list-alt"></i></span>

			<div class="info-box-content">
				<span class="info-box-text">Chủ đề bài viết</span>
				<span class="info-box-number">
					@if(isset($count_post_category))
					{{$count_post_category}}
					@endif
				</span>
			</div>
			<!-- /.info-box-content -->
		</div>
		<!-- /.info-box -->
	</div>
	<!-- /.col -->
	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon" style="background: orange; color: #fff;"><i class="fa fa-tags"></i></span>

			<div class="info-box-content">
				<span class="info-box-text">Thẻ bài viết</span>
				<span class="info-box-number">
					@if(isset($count_tag))
					{{$count_tag}}
					@endif
				</span>
			</div>
			<!-- /.info-box-content -->
		</div>
		<!-- /.info-box -->
	</div>
	<!-- /.col -->

	<!-- fix for small devices only -->
	<div class="clearfix visible-sm-block"></div>

	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon" style="background: #DE531F; color: #fff;"><i class="fa fa-file-text"></i></span>

			<div class="info-box-content">
				<span class="info-box-text">Số lượng bài viết</span>
				<span class="info-box-number">
					@if(isset($count_post))
					{{$count_post}}
					@endif
				</span>
			</div>
			<!-- /.info-box-content -->
		</div>
		<!-- /.info-box -->
	</div>
	<!-- /.col -->
</div>

<!-- firebase 15/7/2019-->
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/3.6.1/firebase.js"></script>
<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#config-web-app -->

<script src="{{asset('firebase/fb.js')}}"></script>

<script>
	var database = firebase.database();

	// get data
	var lastIndexOne = 0;

	var ref = firebase.database().ref('messages');

	ref.on("value", function(snapshot) {
		var value = snapshot.val();
		var htmls = [];
		$.each(value, function(index, value) {
			if (value) {
				htmls.push('<div class="item"><img src="/images/admins/' + value.avatar + '" class="offline"><p class="message"><a href="" class="name">' + value.name + '<small class="text-muted pull-right"><i class="fa fa-clock-o"></i> ' + moment(value.created_at, "YYYY-M-D H:m:s").fromNow() + '</small></a>' + value.message + '</p></div>');
			}
			lastIndexOne = index;
		});

		$('.online-messages').html(htmls);

		var objDiv = document.getElementById("chat-scroll");
		objDiv.scrollTop = objDiv.scrollHeight;

	}, function(error) {
		console.log("Error: " + error.code);
	});
</script>

<script>
	$("#getMessage").keypress(function(e) {
		var message = $('#getMessage').val().trim();
		if (e.keyCode == 13 && message.length > 0) {
			var user_id = $('#getUserId').val();
			var name = $('#getName').val();
			var avatar = $('#getAvatar').val();
			var now = new Date();
			var created_at = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate() + ' ' + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();

			$('#getMessage').val("");
			firebase.database().ref('messages').push({
				'user_id': user_id,
				'name': name,
				'avatar': avatar,
				'message': message,
				'created_at': created_at,
			});
		}
	});

	$('.btn-send-message').click(function() {
		var message = $('#getMessage').val().trim();
		if (message.length > 0) {
			var user_id = $('#getUserId').val();
			var name = $('#getName').val();
			var avatar = $('#getAvatar').val();
			var now = new Date();
			var created_at = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate() + ' ' + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();

			$('#getMessage').val("");
			firebase.database().ref('messages').push({
				'user_id': user_id,
				'name': name,
				'avatar': avatar,
				'message': message,
				'created_at': created_at,
			});
		}
	})
</script>

@endsection