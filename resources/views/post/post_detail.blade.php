@extends('layouts.master_admin') 

@section('controll')
Post Detail
@endsection

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<link rel="stylesheet" href="https://www.jqueryscript.net/demo/tags-selector-tagselect/jquery.tagselect.css">
<script src="https://www.jqueryscript.net/demo/tags-selector-tagselect/jquery.tagselect.js"></script>

<script src="{{ asset("layout_user/plugins/selectize.min.js") }}"></script>
<link rel="stylesheet" href="{{ asset("layout_user/plugins/selectize.bootstrap3.min.css") }}">
<div class="alert alert-danger error-msg" style="display:none">
	<ul></ul>
</div>

<div class="alert alert-success success-msg" style="display:none">
	<ul></ul>
</div>

<div class="alert alert-warning unsuccess-msg" style="display:none">
	<ul></ul>
</div>

@if(isset($post))
@csrf

<div class="form-group">
	<label for="">Tiêu đề</label>
	<input type="text" id="getTitle" class="form-control" required name="title" placeholder="Nhập tiêu đề" value="{{ $post->title }}">
</div>

<div class="form-group">
	<label for="">Thumbnail</label>
	<input name="thumbnail" type="file" class="form-control" id="getThumbnail" placeholder="Image">
</div>

<div class="form-group">
	<label for="">Cateogry</label>
	<div class="qtagselect isw360">
		<select id="getCategoryId" class="form-control select2">
			<option class="isblue" value="{{ $post->categories->id }}">{{ $post->categories->name }}</option>
		</select>
		<script>
			$('#select-state').selectize({
				maxItems: 3,
				closeAfterSelect:true,
				highlight:true,
				selectOnTab:true,
			});
		</script>
	</div>
</div>

<div class="form-group">
	<label>Tags</label>
	<div class="qtagselect isw360">
		<select name="tags[]" id="select-state" class="form-control" multiple>
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

<div class="form-group">
	<label for="">Description</label>
	<textarea name="description" type="text" class="form-control" id="getDescription" placeholder="Description" rows="2" cols="5">{!! $post->description !!} </textarea><br>
</div>

<div class="form-group">
	<label for="sel1">Content</label>
	<br>
	<textarea name="content" id="getContent" rows="20" cols="100">
		{!! $post->content !!} 
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

<br>
<button type="button" data-id={{$post->id}} class="btn btn-danger btn-update">Cập nhật thông tin</button>

<style>
	.qtagselect.isw360 .qtagselect__container{
		width:100%;
	}
</style>
<br>
@endif

<script type="text/javascript">
	$('.btn-update').click(function(){
		var _this = $(this);
		var id = $(this).attr('data-id');

		var form_data = new FormData();
		form_data.append("_token", '{{csrf_token()}}');
		form_data.append("id", id);
		form_data.append("title", $('#getTitle').val());
		form_data.append("content", editor.getData());
		form_data.append('thumbnail', $('input[type=file]')[0].files[0]); 
		form_data.append("description", $('#getDescription').val());
		form_data.append("category_id", $('#getCategoryId').val());

		form_data.append("tags", $('select[name="tags[]"]').val());

		$.ajax({
			type : 'post',
			url : '/admin/collaborator/post/approved',
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