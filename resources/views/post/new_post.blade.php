@extends('layouts.master_admin') 

@section('controll')
New Post
@endsection

@section('content')

<script src="{{ asset("layout_user/plugins/selectize.min.js") }}"></script>
<link rel="stylesheet" href="{{ asset("layout_user/plugins/selectize.bootstrap3.min.css") }}">

<div class="container box box-body pad">
	<div class="row">
		<div class="col-xs-8">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Tạo nội dung bài viết</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<legend></legend>
					<div class="form-group">

						<label for="" style="margin-top: 10px;">Tiêu đề</label>
						<input type="text" class="form-control" id="getTitle" placeholder="Tiêu đề">

						<label for="" style="margin-top: 10px;">Mô tả</label>
						<textarea name="description" type="text" class="form-control" id="getDescription" placeholder="Mô tả" rows="5" cols="10"></textarea><br>

						<label for="" style="margin-top: 10px;">Nội dung bài viết</label>
						<textarea name="content" id="getContent" rows="20" cols="100">

						</textarea>
						<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
						<script>
							var editor = CKEDITOR.replace( 'content', {
								filebrowserBrowseUrl: '{{ asset('ckfinder/ckfinder.html') }}',
								filebrowserImageBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Images') }}',
								filebrowserFlashBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Flash') }}',
								filebrowserUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}',
								filebrowserImageUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}',
								filebrowserFlashUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}'
							} );

						</script>
						
					</div>
					<button type="button" class="btn btn-primary btn-save">Đăng bài viết</button>
				</div>
			</div>
		</div>
		<div class="col-xs-4"> 
			<div class="box">
				<div class="alert alert-danger error-msg" style="display:none">
					<ul></ul>
				</div>

				<div class="alert alert-success success-msg" style="display:none">
					<ul></ul>
				</div>

				<div class="alert alert-warning unsuccess-msg" style="display:none">
					<ul></ul>
				</div>
				
				<div class="box-header">
					<label for="" style="margin-top: 10px;">Chủ đề bài viết</label>
				</div>

				<!-- /.box-header -->
				<div class="box-body">
					<select id="getCategoryId" class="form-control select2" style="width: 100%; margin-top: 0px;">
						@if(isset($categories))
						@foreach($categories as $value)
						<option selected="selected" value="{{$value->id}}">{{$value->name}}</option>
						@endforeach
						@endif
					</select>
				</div>

				<div class="box" style="margin-top: 50px;">
					<div class="box-header">
						<label for="" style="margin-top: 10px;">Ảnh bìa</label>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<input name="thumbnail" type="file" class="form-control" id="getThumbnail" placeholder="Ảnh bìa"><br>
					</div>
				</div>

				<div class="box">
					<div class="box-header">
						<label for="" style="margin-top: 10px;">Gắn thẻ</label>
					</div>
					<div class="qtagselect isw360 box-body">
						<select name="tags[]" id="select-state" class="form-control" multiple style="width: 100%; margin-top: 0px;">
							@if(isset($tags))
							@foreach($tags as $value)
							<option class="isblue" value="{{ $value->id }}">{{ $value->name }}</option>
							@endforeach
							@endif
						</select>
						<script>
							$('#select-state').selectize({
								maxItems: 20,
								closeAfterSelect:true,
								highlight:true,
								selectOnTab:true,
							});
						</script>
					</div>
				</div>

			</div>
		</div>
	</div>

	<script type="text/javascript">
		$('.btn-save').click(function(){
			var form_data = new FormData();
			form_data.append("_token", '{{csrf_token()}}');
			form_data.append("title", $('#getTitle').val());
			form_data.append("content", editor.getData());
			form_data.append('thumbnail', $('input[type=file]')[0].files[0]); 
			form_data.append("description", $('#getDescription').val());

			form_data.append("post_category_id", $('#getCategoryId').val());

			form_data.append("tags", $('select[name="tags[]"]').val());

			$.ajax({
				type : 'post',
				url : '/admin/post',
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