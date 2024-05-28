@extends('layouts.master_detail')

@section('title')
@if(isset($product))
{{$product->name}}
@else
Chi tiết sản phẩm - Home Lab
@endif
@endsection

@section('js')
<script type="text/javascript" src="{{asset('home/js/sweetalert.min.js')}}"></script>
@endsection

@section('detail')
@if(isset($product))
@csrf
<div class="container-fluid container-main">
    <div class="em-inner-main">
        <div class="em-main-container em-col1-layout">
            <div class="row">
                <div class="em-col-main col-sm-22 col-sm-offset-1">
                    <div id="messages_product_view"></div>
                    <div class="product-view">
                        <div class="product-essential">
                            <form id="product_addtocart_form">
                                <div class="product-view-detail">
                                    <div class="em-product-view row">
                                        <div class="em-product-view-primary em-product-img-box col-sm-14">
                                            <div id="em-product-shop-pos-top"></div>
                                            <div class="product-img-box" style="text-align : center;">
                                                <div class="">
                                                    <p class="product-image" style="margin-top : 10px;">

                                                        <a class="cloud-zoom" id="image_zoom" rel="zoomWidth: 600, position : 'inside'" href="{{asset('images/'.$product->image)}}">
                                                            <img class="em-product-main-img" src="{{asset('images/'.$product->image)}}" style="width : 60%;" />
                                                        </a>
                                                    </p>
                                                </div><!-- /.media-left -->

                                            </div>
                                        </div><!-- /.em-product-view-primary -->
                                        <div class="em-product-shop col-sm-9" style="margin-top : 30px;">
                                            <div class="product-shop">
                                                <div id="em-product-info-basic">
                                                    <div class="product-name">
                                                        <h1 style="font-weight:bold; text-transform: uppercase;">{{strtoupper($product->name)}}</h1>
                                                    </div>

                                                    <div>
                                                        <p style="margin-top : 10px;">Mã sản phẩm : {{$product->code}}</p>
                                                    </div>

                                                    <div>
                                                        <p style="margin-top : 10px;">Nhà sản xuất : {{$product->manufacturer_name}}</p>
                                                    </div>

                                                    <div class="price-box" style="margin-top : 30px;">
                                                        @if($product->price > $product->price_sale)
                                                        <p class="old-price">
                                                            <span class="price" id="old-price-182-emprice-e28d8be0787e9d8ae65c6afe74f8df0a" style="font-weight:bold;">
                                                                {{number_format($product->price*1000 ,0 ,'.' ,'.')}} VND
                                                            </span>
                                                        </p>
                                                        @endif

                                                        <p class="special-price">
                                                            <span class="price" content="60" id="product-price-182-emprice-e28d8be0787e9d8ae65c6afe74f8df0a" style="color: #3E6807;">
                                                                {{number_format($product->price_sale*1000 ,0 ,'.' ,'.')}} VND
                                                            </span>
                                                            <span>
                                                                /{{$product->unit_name}}
                                                            </span>
                                                        </p>
                                                    </div>

                                                    <div class="short-description" style="margin-top : 20px;">
                                                        <div class="sku" style="color: #777; font-size: 16px;">
                                                            @if(strlen($product->description) > 500)
                                                            {!!substr($product->description, 0, 500)!!}...
                                                            @else
                                                            {!!$product->description!!}
                                                            @endif
                                                        </div>

                                                        @if($product->quantity > 0)
                                                        <div style="width:100px; padding : 3px 3px; background:#6df31a; color:#fff; font-weight:bold; font-size:12px; text-transform:uppercase; text-align:center;">
                                                            Còn hàng
                                                        </div>
                                                        @else
                                                        <div style="width:100px; padding : 3px 3px; background:#ff0000; color:#fff; font-weight:bold; font-size:12px; text-transform:uppercase; text-align:center;">
                                                            Hết hàng
                                                        </div>
                                                        @endif
                                                    </div>

                                                    @if($product->quantity > 0)
                                                    <div class="add-to-box" style="margin-top : 30px;">
                                                        <div class="">
                                                            <div class="qty_cart">
                                                                <div class="qty-ctl">
                                                                    <button onclick="changeQty(0); return false;" class="decrease"></button>
                                                                </div>
                                                                <input type="number" name="qty" id="qty" value="1" min="1" class="input-text qty" />
                                                                <div class="qty-ctl">
                                                                    <button onclick="changeQty(1); return false;" class="increase"></button>
                                                                </div>
                                                            </div>

                                                            <div class="">
                                                                <button data-id="{{$product->id}}" type="button" id="product-addtocart-button" class="button btn-cart btn-cart-detail btn-add-to-cart"><span><span>Thêm vào giỏ hàng</span></span>
                                                                </button>
                                                            </div>
                                                        </div><!-- /.add-to-cart -->
                                                    </div><!-- /.add-to-box -->
                                                    @endif
                                                </div><!-- /.em-product-info-basic -->
                                            </div>
                                        </div><!-- /.em-product-view-secondary -->
                                    </div>
                                    <div class="clearer"></div>
                                </div><!-- /.product-view-detail -->
                            </form>
                        </div><!-- /.product-essential -->

                        <div class="clearer"></div>
                        <div class="row">
                            <div class="em-product-view-primary col-sm-24 first">
                                <div class="em-product-info ">
                                    <div class="em-product-details ">
                                        <div class="em-details-tabs product-collateral">
                                            <div class="em-details-tabs-content">
                                                <div class="box-collateral em-line-01 box-description">
                                                    <div class="em-block-title">
                                                        <h2>Thông tin sản phẩm</h2>
                                                    </div>
                                                    <div class="box-collateral-content" style="text-align:justify; line-height:30px;">
                                                        <div class="std">
                                                            <strong>
                                                                <span>1. Mô tả sản phẩm: </span>
                                                            </strong>
                                                            <p>{!! $product->description !!}</p>
                                                        </div>
                                                        <div class="std">
                                                            <strong>
                                                                <span>2. Thành phần: </span>
                                                            </strong>
                                                            <p>{!! $product->active !!}</p>
                                                        </div>
                                                        <div class="std">
                                                            <strong>
                                                                <span>3. Công dụng: </span>
                                                            </strong>
                                                            <p>{!! $product->effect !!}</p>
                                                        </div>
                                                        <div class="std">
                                                            <strong>
                                                                <span>4. Đối tượng sử dụng: </span>
                                                            </strong>
                                                            <p>{!! $product->object !!}</p>
                                                            <br />
                                                        </div>
                                                        <div class="std">
                                                            <strong>
                                                                <span>5. Cách sử dụng: </span>
                                                            </strong>
                                                            <p>{!! $product->frequence !!}</p>
                                                        </div>
                                                        <div class="std">
                                                            <strong>
                                                                <span>6. Quy cách đóng gói: </span>
                                                            </strong>
                                                            <p>{!! $product->packed !!}</p>
                                                        </div>
                                                        <div class="std">
                                                            <strong>
                                                                <span>7. Bảo quản: </span>
                                                            </strong>
                                                            <p>{!! $product->maintain !!}</p>
                                                        </div>
                                                    </div>
                                                </div><!-- /.box-collateral -->

                                                <div class="box-collateral  em-line-01">
                                                    <div class="em-block-title">
                                                        <h2>Nhà sản xuất</h2>
                                                    </div>
                                                    <div class="box">
                                                        <div id="em-related" class="block-content">
                                                            <div class="std">
                                                                <strong>
                                                                    <span>1. Nhà sản xuất: {!! $product->manufacturer_name !!}</span>
                                                                </strong>
                                                            </div>
                                                            <div class="products-grid mini-products-list em-related-slider " id="block-related" style="margin-top : 20px;">
                                                                @if(isset($related_products) && !$related_products->isEmpty())
                                                                <div class="std">
                                                                    <strong>
                                                                        <span>2. Sản phẩm cùng nhà sản xuất:</span>
                                                                    </strong>
                                                                </div>

                                                                <div class="products-grid mini-products-list em-related-slider " id="block-related">
                                                                    @if(isset($related_products))
                                                                    @foreach($related_products as $item)
                                                                    <div class="item" style="min-height:350px; height : 350px; width:180px; margin-top : 30px;">
                                                                        <div class="product-item" style="height:100%;">
                                                                            <a href="{{ url('/san-pham/'.$item->slug) }}" class="product-image">
                                                                                @if($item->price_sale < $item->price)
                                                                                    <ul class="productlabels_icons">
                                                                                        @if(floor(($item->price - $item->price_sale)/($item->price)*100) >= 15)
                                                                                        <li class="label hot">
                                                                                            <p>
                                                                                                Hot
                                                                                            </p>
                                                                                        </li>
                                                                                        @else
                                                                                        <li class="label sale">
                                                                                            <p>
                                                                                                Sale
                                                                                            </p>
                                                                                        </li>
                                                                                        @endif
                                                                                        <li class="label special">
                                                                                            <p>
                                                                                                <span>{{floor(($item->price - $item->price_sale)/($item->price)*100)}}%</span> </p>
                                                                                        </li>
                                                                                    </ul>
                                                                                    @endif
                                                                                    <img class="em-img-lazy img-responsive" src="{{asset('images/'.$item->image)}}" alt="{{$item->name}}" style="width:100%; height:204px;" /> </a>
                                                                            <div class="product-details product-shop">
                                                                                <p class="product-name">
                                                                                    <a href="/san-pham/{{$item->slug}}"> {{$item->name}} </a>
                                                                                </p>

                                                                                <div class="price-box" itemscope>
                                                                                    <span class="regular-price" id="product-price-185-related">
                                                                                        <span class="price">{{number_format($item->price_sale*1000 ,0 ,'.' ,'.')}} VND</span>
                                                                                    </span>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div><!-- /.item -->
                                                                    @endforeach
                                                                    @endif
                                                                </div><!-- /.products-grid -->
                                                                @endif
                                                            </div><!-- /.products-grid -->
                                                        </div><!-- /#em-related -->
                                                    </div>
                                                </div><!-- /.box-collateral -->

                                            </div><!-- /.em-details-tabs-content -->
                                        </div><!-- /.em-details-tabs -->

                                    </div><!-- /.em-product-details -->
                                </div><!-- /.em-product-info -->
                                <div id="em-product-shop-pos-bottom" style="display:inline-block;"></div>
                            </div>
                        </div>

                    </div><!-- /.product-view -->
                </div>
            </div>
        </div><!-- /.em-main-container -->
    </div>

    <div class="em-inner-main">
        <div class="em-main-container em-col1-layout">
            <div class="row">
                <div class="em-col-main col-sm-22 col-sm-offset-1">
                    <div class="row">
                        <h3 class="section-title section-title-center" style="text-align: center; text-transform: uppercase; color : #555;">
                            <b></b>
                            <span class="section-title-main">Sản phẩm liên quan</span>
                            <b></b>

                            <style>
                                .section-title {
                                    position: relative;
                                    display: flex;
                                    flex-flow: row wrap;
                                    align-items: center;
                                    justify-content: space-between;
                                    width: 100%;
                                }

                                .section-title b {
                                    display: block;
                                    -ms-flex: 1;
                                    flex: 1;
                                    height: 2px;
                                    opacity: .1;
                                    background-color: currentColor;
                                }
                            </style>
                        </h3>
                        <div class="em-wrapper-banners">
                            <div class=" slider-style02">
                                <div class="em-slider em-slider-banners em-slider-navigation-icon" data-emslider-navigation="true" data-emslider-items="6" data-emslider-desktop="5" data-emslider-desktop-small="4" data-emslider-tablet="3" data-emslider-mobile="2">

                                    @if(isset($suggest_products))
                                    @foreach($suggest_products as $item)
                                    <div class="item" style="margin-top : 30px;">
                                        <a href="{{ url('/san-pham/'.$item->slug) }}">
                                            <img class="img-responsive em-alt-org em-lazy-loaded" src="{{asset('images/'.$item->image)}}" alt="{{$item->name}}" height="110" width="110">
                                        </a>
                                        <div class="product-shop">
                                            <div class="f-fix">
                                                <!--product name-->
                                                <h3 class="product-name" style="margin-top : 10px;"><a href="#" title="">{{$item->name}}</a></h3>
                                                <!--product price-->
                                                <div class="price-box">
                                                    @if($item->price_sale < $item->price)
                                                        <p class="old-price">
                                                            <span class="price-label">Regular Price:</span>
                                                            <span class="price">
                                                                {{number_format($item->price*1000 ,0 ,'.' ,'.')}} VND
                                                            </span>
                                                        </p>
                                                        @endif

                                                        <p class="special-price">
                                                            <span class="price-label">Special Price</span>
                                                            <span class="price" content="60" style="color: #3E6807;">
                                                                {{number_format($item->price_sale*1000 ,0 ,'.' ,'.')}} VND
                                                            </span>
                                                        </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.item -->
                                    @endforeach
                                    @endif
                                </div>
                            </div><!-- /.slider-style02 -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.btn-add-to-cart').click(function() {
        var id = $(this).attr('data-id');
        var qty = Number($('#qty').val());
        if (qty <= 0) {
            swal({
                title: "Thất bại",
                text: "Số lượng sản phẩm không hợp lệ",
                icon: "error",
                buttons: true,
                dangerMode: true,
                buttons: ["Ok"],
            })
        } else {
            var qty = parseInt(qty);
            var count = Number($(".em-topcart-qty").html());
            $.ajax({
                type: 'post',
                url: '/add/item',
                data: {
                    _token: $('[name="_token"]').val(),
                    id: id,
                    qty: qty,
                },
                success: function(response) {
                    count = count + qty;
                    $(".em-topcart-qty").html(count);
                    swal({
                            title: "Đã xong!",
                            text: "Sản phẩm của bạn đã được thêm vào giỏ hàng",
                            icon: "success",
                            buttons: true,
                            dangerMode: true,
                            buttons: ["Tiếp tục mua hàng ", "Gửi đơn hàng ngay!"],
                        })
                        .then(flag => {
                            if (flag) {
                                window.location.href = "/checkout/cart";
                            }
                        })
                }
            });
        }
    });

    $('.btn-add-to-wishlist').click(function() {
        var id = $(this).attr('data-id');
        $.ajax({
            type: 'post',
            url: '/wishlist',
            data: {
                _token: $('[name="_token"]').val(),
                id: id,
            },
            success: function(response) {
                if (response.is === 'success') {
                    swal({
                        title: "Hoàn thành!",
                        text: "Sản phẩm đã được thêm vào danh sách yêu thích",
                        icon: "success",
                        buttons: true,
                        buttons: ["Ok"],
                        timer: 1500
                    });
                }
                if (response.is === 'unsuccess') {
                    swal({
                        title: "Thất bại!",
                        text: "Sản phẩm đang được cập nhật!",
                        icon: "warning",
                        buttons: true,
                        buttons: ["Ok"],
                        timer: 1500
                    });
                }
                if (response.is === 'exist') {
                    swal({
                        text: "Sản phẩm đã tồn tại trong danh sách yêu thích của bạn!",
                        icon: "info",
                        buttons: true,
                        buttons: ["Ok"],
                        timer: 2000
                    });
                }
                if (response.is === 'notlogged') {
                    swal({
                            title: "Bạn chưa đăng nhập",
                            text: "Bạn cần đăng nhập để thực hiện chức năng này!",
                            icon: "info",
                            buttons: true,
                            dangerMode: true,
                            buttons: ["Đóng", "Đăng nhập"],

                        })
                        .then(flag => {
                            if (flag) {
                                window.location.href = "/login";
                            }
                        })
                }
            },
        });
    })
</script>
@endif
@endsection