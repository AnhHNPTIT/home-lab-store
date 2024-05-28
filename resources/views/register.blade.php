@extends('layouts.master_home')


@section('title')
Đăng ký - Home Lab
@endsection


@section('home')
<div class="row">
    <div class="em-col-main col-sm-24">
        <div class="account-create">
            <div class="page-title">
                <h2>Đăng ký tài khoản</h2>
            </div>
            <form id="form-validate">
                @csrf
                <div class="error-mesage" style="display:none; width: 100%; font-size: 13px; color:#ff0000;">
                    <ul></ul>
                </div>

                <div class="success-mesage" style="display:none; width: 100%; font-size: 13px; color:#12f403;">
                    <ul></ul>
                </div>

                <div class="unsuccess-mesage" style="display:none; width: 100%; font-size: 13px; color:#ff9800;">
                    <ul></ul>
                </div>

                <div class="fieldset">
                    
                    <ul class="form-list">
                        <li class="fields">
                            <div class="field">
                                <label for="phone" class="required"><em>*</em>Số điện thoại</label>
                                <div class="input-box">
                                    <input type="text" name="phone_number" id="phone_number" class="input-text" />
                                </div>
                            </div>
                        </li>
                    </ul>

                </div>
                <div class="fieldset">
                    <div class="buttons-set">
                        <p style="font-size:13px;">Tôi đồng ý với các <a href="{{ url('/quy-dinh-su-dung') }}" style="color:#03A9F4;">điều khoản sử dụng</a> của Home Lab và cho phép Home Lab sử dụng thông tin của tôi khi hoàn tất thao tác này.</p>
                       
                        <button type="button" id="btn_register" class="button btn-register" style="font-size:14px; font-weight:600;"><span><span>ĐĂNG KÝ</span></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.btn-register').click(function(){
        var form_data = new FormData();
        form_data.append("_token", '{{csrf_token()}}');
        form_data.append("phone_number", $('#phone_number').val());

        $.ajax({
            type : 'post',
            url : '/register',
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

					window.location.href="/fulfill/information";
				}
				if(response.is === 'unsuccess'){
					$(".unsuccess-mesage").find("ul").html('');
					$(".unsuccess-mesage").css('display','block');
					$(".error-mesage").css('display','none');
					$(".success-mesage").css('display','none');

					$(".unsuccess-mesage").find("ul").append('<li><i class="fa fa-exclamation-triangle"></i> '+response.uncomplete+'</li>');

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