@extends('layouts.master_home')

@section('title')
Home Lab
@endsection

@section('js')
<script type="text/javascript" src="{{asset('home/js/sweetalert.min.js')}}"></script>
@endsection

@section('introduction')
<div class="row em-wrapper-ads-13 hidden-xs">
    <div class="text-box col-sm-8">
        <a class="icon-banner-left pull-left" href="javascript:void(0)">
            <em class="fa fa-fw"><i class="fa fa-hospital-o"></i></em>
        </a>
        <div class="em-banner-right">
            <h5><a href="javascript:void(0)">Cam kết sản phẩm</a></h5>
            <p style="font-size : 13px;">Sản phẩm chính hãng, nguồn gốc rõ ràng</p>
        </div>
    </div>
    <div class="text-box col-sm-8">
        <a class="icon-banner-left pull-left" href="javascript:void(0)">
            <em class="fa fa-fw"><i class="fa fa-user-md"></i></em>
        </a>
        <div class="em-banner-right">
            <h5><a title="Free shipping all order" href="javascript:void(0)">Tư vấn</a></h5>
            <p style="font-size : 13px;">Đội ngũ nhân viên chuyên môn cao, tư vấn tận tình</p>
        </div>
    </div>
    <div class="text-box col-sm-8">
        <a class="icon-banner-left pull-left" href="javascript:void(0)">
            <em class="fa fa-fw"><i class="fa fa-tags"></i></em>
        </a>
        <div class="em-banner-right">
            <h5><a href="javascript:void(0)">Điểm thành viên</a></h5>
            <p style="font-size : 13px;">Mua sản phẩm để được thêm điểm tích lũy</p>
        </div>
    </div>
</div><!-- /.em-wrapper-ads-13-->
@endsection

@section('home')
<div class="row">    
    <div class="col-sm-24 em-col-main">
        <div class="em-wrapper-area03">
            <div class="em-slideshow">
                <div class="em-owlcarousel-slideshow">
                    <div id="em_owlcarousel_2_2484_sync1" class="owl-carousel">
                        <div class="item">
                            <a href=""> 
                                <img alt="" class="lazyOwl img-responsive" src="{{asset('images/slides/slide1.png')}}" /> 
                            </a>
                        </div>
                    </div><!-- /# em_owlcarousel_2_2484_sync1 -->

                    <div id="em_owlcarousel_2_2484_sync1" class="owl-carousel">
                        <div class="item">
                            <a href=""> 
                                <img alt="" class="lazyOwl img-responsive" src="{{asset('images/slides/slide2.png')}}" /> 
                            </a>
                        </div>
                    </div><!-- /# em_owlcarousel_2_2484_sync1 -->

                    <div id="em_owlcarousel_2_2484_sync1" class="owl-carousel">
                        <div class="item">
                            <a href=""> 
                                <img alt="" class="lazyOwl img-responsive" src="{{asset('images/slides/slide3.png')}}" /> 
                            </a>
                        </div>
                    </div><!-- /# em_owlcarousel_2_2484_sync1 -->
                </div><!-- /.em-owlcarousel-slideshow -->
            </div><!-- /.em-slideshow -->
        </div><!-- /.em-wrapper-area03 -->
        <div class="std"></div>
    </div><!-- /.em-col-main -->
</div>

<div class="row">
    <div class="col-sm-24">
        <div class="em-wrapper-new-arrivals-tabs">
            <div class="em-new-arrivals-tabs em-line-01">
                <div class="emtabs-ajaxblock-loaded">
                    <div class="em-tabs-widget tabs-widget ">
                        <div class="widget-title em-widget-title" style="margin-top : 50px; margin-bottom : 50px; text-align: center;">
                            <h3 class="hidden-xs" style="color : #555;"><span>Sản phẩm nổi bật</span></h3>
                        </div>
                        <div id="emtabs_1" class="em-tabs emtabs r-tabs">
                            <div class="em-tabs-content tab-content">
                                <div id="tab_emtabs_1_1" class="tab-pane tab-item content_tab_emtabs_1_1 r-tabs-panel r-tabs-state-active">
                                    <div class="wrapper button-show01 button-hide-text em-wrapper-loaded">
                                        <div class="emfilter-ajaxblock-loaded">
                                            <div id="em_fashion_new_arrivals_tab01" class="em-grid-20 ">

                                                <div class="widget em-filterproducts-grid">
                                                    <div class="widget-products em-widget-products">
                                                        <div class="emcatalog-desktop-5">
                                                            <div class="products-grid">

                                                                @if(isset($new_products))
                                                                    @foreach($new_products as $item)
                                                                        <div class="item last" style="  ">

                                                                            @if($item->price_sale < $item->price)
                                                                                <div class="product-item" style="height : 400px; margin-top : 30px; box-sizing : border-box;">
                                                                                    <div class="product-shop-top">
                                                                                        <a href="{{ url('/san-pham/'.$item->slug) }}" title="" class="product-image">
                                                                                            <!--show label product - label extension is required-->
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

                                                                                            <img class="em-alt-hover img-responsive em-lazy-loaded" src="{{asset('images/products/'.$item->image)}}" alt="{{$item->name}}" style="width: 100%; height: 220px;">

                                                                                            <img class="img-responsive em-alt-org em-lazy-loaded" src="{{asset('images/products/'.$item->image)}}" alt="{{$item->name}}" style="width: 100%; height: 220px;">
                                                                                        </a>
                                                                                        <div class="em-element-display-hover bottom">
                                                                                            <div class="quickshop-link-container">
                                                                                                <a href="{{ url('/san-pham/'.$item->slug) }}" class="quickshop-link" title="Xem sản phẩm">Xem sản phẩm</a>
                                                                                            </div>

                                                                                            <div class="em-btn-addto">
                                                                                                <!--product add to cart-->
                                                                                                @csrf
                                                                                                @if($item->quantity > 0)
                                                                                                <button data-id="{{$item->id}}" type="button" title="Thêm vào giỏ hàng" class="button btn-cart btn-add-to-cart" >
                                                                                                </button>
                                                                                                @endif

                                                                                                <!--product add to compare-wishlist-->
                                                                                                <ul class="add-to-links">
                                                                                                    <li>
                                                                                                        <button data-id="{{$item->id}}" type="button" class="link-wishlist btn-add-to-wishlist" title="Yêu thích">
                                                                                                        </button>
                                                                                                    </li>
                                                                                                </ul>
                                                                                            </div>
                                                                                            
                                                                                        </div>
                                                                                    </div><!-- /.product-shop-top -->
                                                                                    

                                                                                    <div class="product-shop">
                                                                                        <div class="f-fix">
                                                                                            <!--product name-->
                                                                                            <h3 style="min-height: 58px; height:58px;" class="product-name"><a href="/san-pham/{{$item->slug}}" style="text-transform: capitalize;"> {{$item->name}} </a></h3>

                                                                                            <div class="price-box">
                                                                                                @if($item->quantity > 0)
                                                                                                    <!-- <div style="background:#6df31a; height:30px; padding-top:6px; color:#fff; font-weight:bold; font-size:12px; text-align:center; text-transform:uppercase;">
                                                                                                        còn hàng
                                                                                                    </div> -->
                                                                                                @else
                                                                                                    <div style="background:#ff0000; height:30px; padding-top:6px; color:#fff; font-weight:bold; font-size:12px; text-align:center; text-transform:uppercase;">
                                                                                                        hết hàng
                                                                                                    </div>
                                                                                                @endif
                                                                                                <p class="old-price">
                                                                                                    <span class="price" id="old-price-182-emprice-e28d8be0787e9d8ae65c6afe74f8df0a">
                                                                                                    {{number_format($item->price*1000 ,0 ,'.' ,'.')}} VND
                                                                                                    </span>
                                                                                                </p>
                                                                                                <br>

                                                                                                <p class="special-price">
                                                                                                    <span class="price" content="60" id="product-price-182-emprice-e28d8be0787e9d8ae65c6afe74f8df0a" style="color: #00ab9f;">
                                                                                                    {{number_format($item->price_sale*1000 ,0 ,'.' ,'.')}} VND
                                                                                                    </span>
                                                                                                </p>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div><!-- /.product-shop -->
                                                                                </div>
                                                                            @else
                                                                            <div class="product-item" style="height : 380px; margin-top : 30px; box-sizing : border-box;">
                                                                                    <div class="product-shop-top">
                                                                                        <a href="{{ url('/san-pham/'.$item->slug) }}" class="product-image">
                                                                                            <!--show label product - label extension is required-->
                                                                                            <img class="em-alt-hover img-responsive em-lazy-loaded" src="{{asset('images/products/'.$item->image)}}" alt="{{$item->name}}" style="width: 100%;">

                                                                                            <img class="img-responsive em-alt-org em-lazy-loaded" src="{{asset('images/products/'.$item->image)}}" alt="{{$item->name}}" style="width: 100%;">
                                                                                        </a>
                                                                                        <div class="em-element-display-hover bottom">
                                                                                            <div class="quickshop-link-container">
                                                                                            <a href="{{ url('/san-pham/'.$item->slug) }}" class="quickshop-link" title="Xem sản phẩm">Xem sản phẩm</a>
                                                                                            </div>
                                                                                            <div class="em-btn-addto">
                                                                                                <!--product add to cart-->
                                                                                                @csrf
                                                                                                @if($item->quantity > 0)
                                                                                                <button data-id="{{$item->id}}" type="button" title="Thêm vào giỏ hàng" class="button btn-cart btn-add-to-cart">
                                                                                                </button>
                                                                                                @endif
                                                                                                <!--product add to compare-wishlist-->
                                                                                                <ul class="add-to-links">
                                                                                                    <li>
                                                                                                        <button data-id="{{$item->id}}" type="button" title="Yêu thích" class="link-wishlist btn-add-to-wishlist">
                                                                                                        </button>
                                                                                                    </li>
                                                                                                </ul>
                                                                                            </div>
                                                                                            
                                                                                        </div>
                                                                                    </div><!-- /.product-shop-top -->
                                                                                    
                                                                                    <div class="product-shop">
                                                                                        <div class="f-fix">
                                                                                            <!--product name-->
                                                                                            <h3 style="min-height: 58px; height:58px;" class="product-name"><a href="{{ url('/san-pham/'.$item->slug) }}" style="text-transform: capitalize;"> {{$item->name}} </a></h3>
                                                                                            
                                                                                            <!--product price-->
                                                                                            <div class="price-box">
                                                                                                @if($item->quantity > 0)
                                                                                                    <!-- <div style="background:#6df31a; height:30px; padding-top:6px; color:#fff; font-weight:bold; font-size:12px; text-align:center; text-transform:uppercase;">
                                                                                                        còn hàng
                                                                                                    </div> -->
                                                                                                @else
                                                                                                    <div style="background:#ff0000; height:30px; padding-top:6px; color:#fff; font-weight:bold; font-size:12px; text-align:center; text-transform:uppercase;">
                                                                                                        hết hàng
                                                                                                    </div>
                                                                                                @endif
                                                                                                <p class="special-price">
                                                                                                    <span class="price" content="60" id="product-price-182-emprice-e28d8be0787e9d8ae65c6afe74f8df0a" style="color: #00ab9f; padding-top:20px;">
                                                                                                        {{number_format($item->price_sale*1000 ,0 ,'.' ,'.')}} VND
                                                                                                    </span>
                                                                                                </p>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div><!-- /.product-shop -->
                                                                                </div>
                                                                            @endif
                                                                        </div><!-- item -->
                                                                    @endforeach
                                                                @endif
                                                            </div><!-- /.products-grid -->
                                                        </div><!-- /.emcatalog-desktop-4 -->
                                                    </div><!-- /.widget-products -->
                                                </div><!-- /.widget -->

                                            </div><!-- /#em_fashion_new_arrivals_tab01 -->
                                        </div>
                                    </div>
                                </div><!-- /#tab_emtabs_1_1 -->
                            </div><!-- /.tab-content -->
                        </div><!-- /#emtabs_1 -->
                    </div>
                </div>
            </div><!-- /.em-new-arrivals-tabs -->
        </div><!-- /.em-wrapper-new-arrivals-tabs -->
    </div><!-- /.em-col-main -->
</div>

<script type="text/javascript">
    $('.btn-add-to-cart').click(function(){
        var id = $(this).attr('data-id');
        var count = Number($(".em-topcart-qty").html());
        $.ajax({
            type : 'post',
            url : '/checkout/cart',
            data : {
                _token :$('[name="_token"]').val(),
                id : id,
            },
            success : function(response){
                count++;
                $(".em-topcart-qty").html(count);
                swal({
                    title: "Đã xong!",
                    text: "Sản phẩm của bạn đã được thêm vào giỏ hàng",
                    icon: "success",
                    buttons: true,
                    dangerMode: true,
                    buttons: ["Tiếp tục mua hàng ", "Gửi đơn hàng ngay!"],
                })
                .then(flag =>{
                    if(flag){
                        window.location.href="/checkout/cart";
                    }
                })
            }
        });
    });

    $('.btn-add-to-wishlist').click(function(){
        var id = $(this).attr('data-id');
        $.ajax({
            type : 'post',
            url : '/wishlist',
            data : {
                _token :$('[name="_token"]').val(),
                id : id,
            },
            success : function(response){
                if(response.is === 'success'){
                    swal({
                        title: "Hoàn thành!",
                        text: "Sản phẩm đã được thêm vào danh sách yêu thích",
                        icon: "success",
                        buttons: true,
                        buttons: ["Ok"],
                        timer: 1500
                    });
                }
                if(response.is === 'unsuccess'){
                    swal({
                        title: "Thất bại!",
                        text: "Sản phẩm đang được cập nhật!",
                        icon: "warning",
                        buttons: true,
                        buttons: ["Ok"],
                        timer: 1500
                    });
                }
                if(response.is === 'exist'){
                    swal({
                        text: "Sản phẩm đã tồn tại trong danh sách yêu thích của bạn!",
                        icon: "info",
                        buttons: true,
                        buttons: ["Ok"],
                        timer: 2000
                    });
                }
                if(response.is === 'notlogged'){
                    swal({
                        title: "Bạn chưa đăng nhập",
                        text: "Bạn cần đăng nhập để thực hiện chức năng này!",
                        icon: "info",
                        buttons: true,
                        dangerMode: true,
                        buttons: ["Đóng","Đăng nhập"],
                        
                    })
                    .then(flag => {
                        if(flag){
                            window.location.href="/login";
                        }
                    })
                }
            },
        });
    })
</script>
@endsection

@section('interesting')
<div class="row" style="margin-top : 15px;">
    <h3 class="section-title section-title-center" style="text-align: center; text-transform: uppercase; color : #555;">
        <b></b>
        <span class="section-title-main">Quan tâm nhiều nhất</span>
        <b></b>
    </h3>
    <div class="em-wrapper-banners">
        <div class=" slider-style02">
            <div class="em-slider em-slider-banners em-slider-navigation-icon" data-emslider-navigation="true" data-emslider-items="6" data-emslider-desktop="5" data-emslider-desktop-small="4" data-emslider-tablet="3" data-emslider-mobile="2">

                @if(isset($most_interesting_products))
                @foreach($most_interesting_products as $item)
                <div class="item" style="margin-top : 30px;">
                    <a href="{{ url('/san-pham/'.$item->slug) }}">
                        <img class="img-responsive em-alt-org em-lazy-loaded" src="{{asset('images/products/'.$item->image)}}" alt="{{$item->name}}" height="110" width="110">
                    </a>
                    <div class="product-shop">
                        <div class="f-fix">
                            <!--product name-->
                            <h3 class="product-name" style="margin-top : 10px;">
                                <a href="{{ url('/san-pham/'.$item->slug) }}" title="">{{$item->name}}</a></h3>
                            <!--product price-->
                            <div class="price-box">
                                @if($item->price_sale < $item->price)
                                    <p class="old-price">
                                        <span class="price">
                                            {{number_format($item->price*1000 ,0 ,'.' ,'.')}} VND
                                        </span>
                                    </p>
                                    @endif

                                    <p class="special-price">
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
<div class="row" style="margin-top : 30px;">
    <h3 class="section-title section-title-center" style="text-align: center; text-transform: uppercase; color : #555;">
        <b></b>
        <span class="section-title-main">Mua nhiều nhất</span>
        <b></b>
    </h3>
    <div class="em-wrapper-banners">
        <div class=" slider-style02">
            <div class="em-slider em-slider-banners em-slider-navigation-icon" data-emslider-navigation="true" data-emslider-items="6" data-emslider-desktop="5" data-emslider-desktop-small="4" data-emslider-tablet="3" data-emslider-mobile="2">

                @if(isset($most_sold_products))
                @foreach($most_sold_products as $item)
                <div class="item" style="margin-top : 30px;">
                    <a href="{{ url('/san-pham/'.$item->slug) }}">
                        <img class="img-responsive em-alt-org em-lazy-loaded" src="{{asset('images/products/'.$item->image)}}" alt="{{$item->name}}" height="110" width="110">
                    </a>
                    <div class="product-shop">
                        <div class="f-fix">
                            <!--product name-->
                            <h3 class="product-name" style="margin-top : 10px;"><a href="{{ url('/san-pham/'.$item->slug) }}" title="">{{$item->name}}</a></h3>
                            <!--product price-->
                            <div class="price-box">
                                @if($item->price_sale < $item->price)
                                    <p class="old-price">
                                        <span class="price">
                                            {{number_format($item->price*1000 ,0 ,'.' ,'.')}} VND
                                        </span>
                                    </p>
                                    @endif

                                    <p class="special-price">
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

<div class="row">
    <h3 class="section-title section-title-center" style="text-align: center; text-transform: uppercase; color : #555;">
        <b></b>
        <span class="section-title-main">Tin sức khỏe</span>
        <b></b>
    </h3>
    <div class="em-wrapper-banners">
        <div class=" slider-style02">
            <div class="em-slider em-slider-banners em-slider-navigation-icon" data-emslider-navigation="true" data-emslider-items="4" data-emslider-desktop="3" data-emslider-desktop-small="3" data-emslider-tablet="2" data-emslider-mobile="1">

                @if(isset($new_posts))
                @foreach($new_posts as $post)
                <div class="item" style="margin-top : 30px; padding: 0px 10px;">
                    <a href="{{ url('/tin-tuc-su-kien/'.$post->slug) }}">
                        <img class="img-responsive em-alt-org em-lazy-loaded" src="{{asset('/images/posts/'.$post->thumbnail)}}" alt="{{$post->name}}" style="height:160px; width:100%;">
                    </a>
                    <div>
                        <div style="padding: 5px 8px; text-align:center;">
                            <!--post title-->
                            <h1 style="margin-top : 10px; font-size: 17px; font-weight:600 !important; text-transform: capitalize !important;">
                                <a href="{{ url('/tin-tuc-su-kien/'.$post->slug) }}" title="" style="text-align: justify !important;">
                                    {{$post->title}}
                                </a>
                            </h1>
                            <p style="font-size: 16px !important;">
                                <span>
                                    @if(strlen($post->description) < 120) {!! $post->description !!}
                                        @else
                                        {!! substr($post->description, 0, 120) !!}...
                                        @endif
                                </span>
                            </p>
                        </div>
                    </div>
                </div><!-- /.item -->
                @endforeach
                @endif
            </div>
        </div><!-- /.slider-style02 -->
    </div>
</div>

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
@endsection


@section('feature')
<div class="col-sm-24  text-center">
    <h3 class="section-title section-title-center" style="text-align: center; text-transform: uppercase; color : #555;">
        <b></b>
        <span class="section-title-main">Chúng tôi có gì?</span>
        <b></b>
        <br>
</div>
<div class="em-wrapper-ads-09">
    <div class="row">
        <div class="col-sm-6 text-center em-wrapper-ads-item">
            <div class="em-ads-item">
                <p><em class="fa fa-fw"></em>
                </p>
                <div class="em-ads-content">
                    <h4 class="primary em-text-upercase">Đội ngũ nhân viên</h4>
                    <p>Home Lab tự hào khi sở hữu đội ngũ nhân viên hàng đầu tại Việt Nam</p>
                </div>
            </div>
        </div><!-- /.em-wrapper-ads-item -->
        <div class="col-sm-6 text-center em-wrapper-ads-item  line-left line-right">
            <div class="em-ads-item">
                <p><em class="fa fa-fw"></em>
                </p>
                <div class="em-ads-content">
                    <h4 class="primary em-text-upercase">Cửa hàng trực tuyến</h4>
                    <p>Dễ dàng đặt hàng online nhanh chóng trên Home Lab thông qua mọi thiết bị</p>
                </div>
            </div>
        </div><!-- /.em-wrapper-ads-item -->
        <div class="col-sm-6 text-center  em-wrapper-ads-item  line-left line-right">
            <div class="em-ads-item">
                <p><em class="fa fa-fw"></em>
                </p>
                <div class="em-ads-content">
                    <h4 class="primary em-text-upercase">Giao hàng cực nhanh</h4>
                    <p>Miễn phí giao hàng cho những đơn hàng đạt đủ điều kiện và nhận hàng nhanh chóng</p>
                </div>
            </div>
        </div><!-- /.em-wrapper-ads-item -->
        <div class="col-sm-6 text-center  em-wrapper-ads-item">
            <div class="em-ads-item">
                <p><em class="fa fa-fw"></em>
                </p>
                <div class="em-ads-content">
                    <h4 class="primary em-text-upercase">Hỗ trợ 24/7</h4>
                    <p>Dịch vụ tư vấn chuyên nghiệp luôn sẵn sàng giải đáp mọi thắc mắc của bạn</p>
                </div>
            </div>
        </div><!-- /.em-wrapper-ads-item -->
    </div>
</div>
@endsection