@extends('layouts.master_admin') 

@section('controll')
New Product
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
		<div class="col-xs-12">
				<div class="box-header">
					<h3 class="box-title">Thêm sản phẩm</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<legend></legend>
					<div class="form-group">
						<input type="hidden" class="form-control" id="getType" value="1" placeholder="Loại sản phẩm"><br>

						<label for="" style="margin-top: 10px;">Tên sản phẩm</label>
						<input type="text" class="form-control" id="getName" placeholder="Tên sản phẩm"><br>

						<label for="" style="margin-top: 10px;">Mã sản phẩm</label>
						<input name="code" type="text" class="form-control" id="getCode" placeholder="Mã sản phẩm"><br>

						<label for="" style="margin-top: 10px;">Nhóm sản phẩm</label>
						<select name="product_categories[]" id="select-state-product-category" class="form-control" multiple style="width: 100%; margin-top: 0px;">
								@if(isset($product_categories))
									@foreach($product_categories as $value)
										<option class="isblue" value="{{ $value->id }}">{{ $value->name }}</option>
									@endforeach
								@endif
						</select><br>
						<script>
							$('#select-state-product-category').selectize({
								maxItems: 1,
								closeAfterSelect:true,
								highlight:true,
								selectOnTab:true,
							});
						</script>
						
						<label for="" style="margin-top: 10px;">Nhà sản xuất</label>
						<select name="manufacturers[]" id="select-state-manufacturer" class="form-control" multiple style="width: 100%; margin-top: 0px;">
							@if(isset($manufacturers))
							@foreach($manufacturers as $value)
							<option class="isblue" value="{{ $value->id }}">{{ $value->name }}</option>
							@endforeach
							@endif
						</select><br>
						<script>
							$('#select-state-manufacturer').selectize({
								maxItems: 1,
								closeAfterSelect:true,
								highlight:true,
								selectOnTab:true,
							});
						</script>
						
						
						<label for="" style="margin-top: 10px;">Hình ảnh</label>
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

						<br><label for="" style="margin-top: 10px;">Mô tả sản phẩm</label>
						<textarea name="description" id="getDescription" rows="20" cols="100">
						</textarea>
						<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
						<script>
							var description = CKEDITOR.replace( 'description', {
								filebrowserBrowseUrl: '{{ asset('ckfinder/ckfinder.html') }}',
								filebrowserImageBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Images') }}',
								filebrowserFlashBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Flash') }}',
								filebrowserUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}',
								filebrowserImageUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}',
								filebrowserFlashUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}'
							} );
						</script>

						<label for="" style="margin-top: 10px;">Đơn vị tính</label>
						<select name="units[]" id="select-state-unit" class="form-control" multiple style="width: 100%; margin-top: 0px;">
							@if(isset($units))
							@foreach($units as $value)
							<option class="isblue" value="{{ $value->id }}">{{ $value->name }}</option>
							@endforeach
							@endif
						</select><br>
						<script>
							$('#select-state-unit').selectize({
								maxItems: 1,
								closeAfterSelect:true,
								highlight:true,
								selectOnTab:true,
							});
						</script>

						<br><label for="" style="margin-top: 10px;">Giá nhập (Nghìn đồng)</label>
						<input type="number" min="0" value="0" class="form-control" id="getPricePrime" placeholder="Giá nhập sản phẩm">

						<br><label for="" style="margin-top: 10px;">Giá niêm yết (Nghìn đồng)</label>
						<input type="number" min="0" value="0" class="form-control" id="getPrice" placeholder="Giá sản phẩm">
						
						<br><label for="" style="margin-top: 10px;">Giảm giá (Nghìn đồng)</label>
						<input type="number"  min="0" value="0" class="form-control" id="getSale" placeholder="Giảm giá">

						<br><label for="" style="margin-top: 10px;">Số lượng sản phẩm</label>
						<input type="number"  min="1" value="0" class="form-control" id="getQuantity" placeholder="Số lượng sản phẩm">
						
						<br><label for="" style="margin-top: 10px;">Chế độ</label>
						<select name="status" class="form-control" id="getStatus">
							<option value="1">Công khai</option>
							<option value="0">Riêng tư</option>
						</select><br>
					</div>
					<button type="button" class="btn btn-primary btn-save">Thêm sản phẩm</button>
				</div>
		</div>
	</div>

	<script type="text/javascript">
		$('.btn-save').click(function(){
			var form_data = new FormData();
			form_data.append("_token", '{{csrf_token()}}');
			form_data.append("name", $('#getName').val());
			form_data.append("code", $('#getCode').val());
			form_data.append("product_category_id", $('select[name="product_categories[]"]').val());
			form_data.append("manufacturer_id", $('select[name="manufacturers[]"]').val());
			form_data.append("description", description.getData());
			form_data.append('image', $('input[type=file]')[0].files[0]);
			form_data.append("price_prime", $('#getPricePrime').val());
			form_data.append("price", $('#getPrice').val());
			form_data.append("unit_id", $('select[name="units[]"]').val());
			form_data.append("price_sale", $('#getSale').val());
			form_data.append("quantity", $('#getQuantity').val());
			form_data.append("status", $('#getStatus').val());
			
			$.ajax({
				type : 'post',
				url : '/admin/product',
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