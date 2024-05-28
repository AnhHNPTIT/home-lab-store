@extends('layouts.master_admin') 

@section('controll')
Product Detail
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
		@if(isset($product))
		<div class="col-xs-12">
				<div class="box-body">
					<legend></legend>
					<div class="form-group">
						@csrf
						<input type="hidden" class="form-control" id="getProductID" value="{{ $product->id }}"><br>
						
						<label for="" style="margin-top: 10px;">Tên sản phẩm</label>
						<input type="text" class="form-control" id="getName" placeholder="Tên sản phẩm" value="{{$product->name}}"><br>

						<label for="" style="margin-top: 10px;">Mã sản phẩm</label>
						<input name="code" type="text" class="form-control" id="getCode" placeholder="Mã sản phẩm" value="{{$product->code}}"><br>
					
						<label for="" style="margin-top: 10px;">Nhóm sản phẩm</label>
						<select name="product_categories[]" id="select-state-product-category" class="form-control" multiple style="width: 100%; margin-top: 0px;">
								@if(isset($product_categories))
									@foreach($product_categories as $value)
										@if($product->product_category_id == $value->id)
											<option selected class="isblue" value="{{ $value->id }}">{{ $value->name }}</option>
										@else
											<option class="isblue" value="{{ $value->id }}">{{ $value->name }}</option>
										@endif
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
										@if($product->manufacturer_id == $value->id)
											<option selected class="isblue" value="{{ $value->id }}">{{ $value->name }}</option>
										@else
											<option class="isblue" value="{{ $value->id }}">{{ $value->name }}</option>
										@endif
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
							var product_image = "<?php echo $product->image ?>";
							$('#thumbnail').attr('src', '/images/'+product_image).width(150).height(200);
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
						{{$product->description}}
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

						<br>
						<label for="" style="margin-top: 10px;">Thành phần</label>
						<textarea name="active" id="getActive" rows="20" cols="100">
						{{$product->active}}
						</textarea>
						<script>
							var active = CKEDITOR.replace( 'active', {
								filebrowserBrowseUrl: '{{ asset('ckfinder/ckfinder.html') }}',
								filebrowserImageBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Images') }}',
								filebrowserFlashBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Flash') }}',
								filebrowserUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}',
								filebrowserImageUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}',
								filebrowserFlashUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}'
							} );

						</script>

						<br><label for="" style="margin-top: 10px;">Cách sử dụng</label>
						<textarea name="frequence" id="getFrequence" rows="20" cols="100">
						{{$product->frequence}}
						</textarea>
						<script>
							var frequence = CKEDITOR.replace( 'frequence', {
								filebrowserBrowseUrl: '{{ asset('ckfinder/ckfinder.html') }}',
								filebrowserImageBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Images') }}',
								filebrowserFlashBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Flash') }}',
								filebrowserUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}',
								filebrowserImageUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}',
								filebrowserFlashUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}'
							} );
						</script>

						<br><label for="" style="margin-top: 10px;">Cách đóng gói</label>
						<input type="text" class="form-control" id="getPacked" placeholder="Cách đóng gói" value="{{$product->packed}}"><br>


						<br><label for="" style="margin-top: 10px;">Công dụng</label>
						<textarea name="effect" id="getEffect" rows="20" cols="100">
						{{$product->effect}}
						</textarea>
						<script>
							var effect = CKEDITOR.replace( 'effect', {
								filebrowserBrowseUrl: '{{ asset('ckfinder/ckfinder.html') }}',
								filebrowserImageBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Images') }}',
								filebrowserFlashBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Flash') }}',
								filebrowserUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}',
								filebrowserImageUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}',
								filebrowserFlashUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}'
							} );
						</script>

						<br><label for="" style="margin-top: 10px;">Bảo quản</label>
						<textarea name="maintain" id="getMaintain" rows="20" cols="100">
						{{$product->maintain}}
						</textarea>
						<script>
							var maintain = CKEDITOR.replace( 'maintain', {
								filebrowserBrowseUrl: '{{ asset('ckfinder/ckfinder.html') }}',
								filebrowserImageBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Images') }}',
								filebrowserFlashBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Flash') }}',
								filebrowserUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}',
								filebrowserImageUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}',
								filebrowserFlashUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}'
							} );
						</script>

						<br><label for="" style="margin-top: 10px;">Đối tượng sử dụng</label>
						<textarea name="object" type="text" class="form-control" id="getObject" placeholder="Đối tượng sử dụng" rows="5" cols="10">{{$product->object}}</textarea><br>
						
						<label for="" style="margin-top: 10px;">Đơn vị tính</label>
						<select name="units[]" id="select-state-unit" class="form-control" multiple style="width: 100%; margin-top: 0px;">
								@if(isset($units))
									@foreach($units as $value)
										@if($product->unit_id == $value->id)
											<option selected class="isblue" value="{{ $value->id }}">{{ $value->name }}</option>
										@else
											<option class="isblue" value="{{ $value->id }}">{{ $value->name }}</option>
										@endif
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

						<br><label for="" style="margin-top: 10px;">Giá nhập sản phẩm (Nghìn đồng)</label>
						<input type="number" min="0" class="form-control" id="getPricePrime" placeholder="Giá nhập sản phẩm" value="{{$product->price_prime}}">

						<br><label for="" style="margin-top: 10px;">Giá gốc sản phẩm (Nghìn đồng)</label>
						<input type="number" min="0" class="form-control" id="getPrice" placeholder="Giá sản phẩm" value="{{$product->price}}">
						
						<br><label for="" style="margin-top: 10px;">Giảm giá còn (Nghìn đồng)</label>
						<input type="number"  min="0" class="form-control" id="getSale" placeholder="Giá bán" value="{{$product->price_sale}}">

						<br><label for="" style="margin-top: 10px;">Số lượng sản phẩm</label>
						<input type="number"  min="1" class="form-control" id="getQuantity" placeholder="Số lượng sản phẩm" value="{{$product->quantity}}">
						
						<br><label for="" style="margin-top: 10px;">Chế độ</label>
						<select name="status" class="form-control" id="getStatus">
							@if($product->status == 1)
							<option value="1" selected>Công khai</option>
							<option value="0" >Riêng tư</option>
							@else
							<option value="0" selected>Riêng tư</option>
							<option value="1">Công khai</option>
							@endif
						</select><br>
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
			form_data.append("id", $('#getProductID').val());
			form_data.append("name", $('#getName').val());
			form_data.append("code", $('#getCode').val());
			form_data.append("product_category_id", $('select[name="product_categories[]"]').val());
			form_data.append("manufacturer_id", $('select[name="manufacturers[]"]').val());
			form_data.append("description", description.getData());
			form_data.append("active", active.getData());
			form_data.append("frequence", frequence.getData());
			form_data.append("packed", $('#getPacked').val());
			form_data.append("effect", effect.getData());
			form_data.append("maintain", maintain.getData());
			form_data.append("object", $('#getObject').val());
			form_data.append('image', $('input[type=file]')[0].files[0]);
			form_data.append("price_prime", $('#getPricePrime').val());
			form_data.append("price", $('#getPrice').val());
			form_data.append("unit_id", $('select[name="units[]"]').val());
			form_data.append("price_sale", $('#getSale').val());
			form_data.append("quantity", $('#getQuantity').val());
			form_data.append("status", $('#getStatus').val());
			
			$.ajax({
				type : 'post',
				url : '/admin/product/update',
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