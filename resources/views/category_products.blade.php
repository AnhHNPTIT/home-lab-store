@extends('layouts.master_home')

@section('title')
Danh mục sản phẩm - Home Lab
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('plugins/bootstrap-slider/slider.css')}}">
@endsection

@section('js')
<script type="text/javascript" src="{{asset('home/js/jquery-ui.min.js')}}"></script>

<script type="text/javascript" src="{{asset('home/js/sweetalert.min.js')}}"></script>

<script type="text/javascript">
    (function($) {
        //Ready Function
        $(document).ready(function() {
            setColumnCountGridMode();
        });

        if (typeof EM == 'undefined') EM = {};
        if (typeof EM.SETTING == 'undefined') EM.SETTING = {};

        function setColumnCountGridMode() {
            var wWin = $(window).width();
            if (EM.SETTING.DISABLE_RESPONSIVE == 1) {
                var sDesktop = 'emcatalog-desktop-';
                var sDesktopSmall = 'emcatalog-desktop-small-';
                var sTablet = 'emcatalog-tablet-';
                var sMobile = 'emcatalog-mobile-';
                var sGrid = $('#em-grid-mode');
                if (wWin > 1200) {
                    sGrid.removeClass().addClass(sDesktop + '4');
                } else {
                    if (wWin <= 1200 && wWin > 768) {
                        sGrid.removeClass().addClass(sDesktopSmall + '3');
                    } else {
                        if (wWin <= 768 && wWin > 480) {
                            sGrid.removeClass().addClass(sTablet + '3');
                        } else {
                            sGrid.removeClass().addClass(sMobile + '2');
                        }
                    }
                }
            } else {
                var sDesktop = 'emcatalog-desktop-';
                var sGrid = $('#em-grid-mode');
                sGrid.removeClass().addClass(sDesktop + '4');
            }
        };

        $(window).resize($.throttle(300, function() {
            setColumnCountGridMode();
        }));
    })(jQuery);
</script>
@endsection

@section('home')
<div class="em-wrapper-main">
    <div class="container container-main">
        <div class="em-inner-main">
            <div class="em-wrapper-area02"></div>
            <div class="em-wrapper-area03"></div>
            <div class="em-wrapper-area04"></div>
            <div class="em-main-container em-col2-left-layout">
                <div class="row">
                    <div class="col-sm-18 col-sm-push-6 em-col-main">

                        <div class="category-products">
                            <div class="toolbar-top">
                                <div class="toolbar">
                                    <div class="sorter">
                                        @if(isset($title))
                                        <p class="view-mode" style="color : #3E6807; font-weight : 500; border : 1px solid #3E6807; margin-left : 20px;">
                                            {{$title}}
                                        </p>
                                        @endif

                                        <div class="sort-by toolbar-switch">
                                            <div class="toolbar-title">
                                                <form method="get" action="{{Route::current()->getName()}}" id="form-order">
                                                    <select class="sortby" name="sortby" style="height : 42px;">
                                                        <option value="price" selected="selected"> Sắp xếp theo giá từ thấp đến cao</option>
                                                        @if(isset($sortby))
                                                        @if($sortby == 'price-desc')
                                                        <option value="price-desc" selected="selected"> Sắp xếp theo giá từ cao đến thấp</option>
                                                        @else
                                                        <option value="price-desc"> Sắp xếp theo giá từ cao đến thấp</option>
                                                        @endif

                                                        @if($sortby == 'name')
                                                        <option value="name" selected="selected"> Sắp xếp theo tên</option>
                                                        @else
                                                        <option value="name"> Sắp xếp theo tên</option>
                                                        @endif

                                                        @if($sortby == 'date')
                                                        <option value="date" selected="selected"> Sắp xếp theo mới nhất</option>
                                                        @else
                                                        <option value="date"> Sắp xếp theo mới nhất</option>
                                                        @endif
                                                        @else
                                                        <option value="price-desc"> Sắp xếp theo giá từ cao đến thấp</option>
                                                        <option value="name"> Sắp xếp theo tên</option>
                                                        <option value="date"> Sắp xếp theo mới nhất</option>
                                                        @endif
                                                    </select>
                                                </form>
                                            </div>
                                        </div>

                                    </div><!-- /.sorter -->
                                </div>
                            </div><!-- /.toolbar-top -->
                            <div id="em-grid-mode">
                                <ul class="emcatalog-grid-mode products-grid emcatalog-disable-hover-below-mobile">
                                    @if(isset($products))
                                    @foreach($products as $item)
                                    <div class="item last" style="  ">

                                        @if($item->price_sale < $item->price)
                                            <div class="product-item" style="height : 380px; margin-top : 30px; box-sizing : border-box;">
                                                <div class="product-shop-top">
                                                    <a href="{{ url('/san-pham/'.$item->slug) }}" title="" class="product-image" id="link-product">
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

                                                        <img class="em-alt-hover img-responsive em-lazy-loaded" src="{{asset('images/'.$item->image)}}" alt="{{$item->name}}" style="width: 100%;">

                                                        <img class="img-responsive em-alt-org em-lazy-loaded" src="{{asset('images/'.$item->image)}}" alt="{{$item->name}}" style="width: 100%;">
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
                                                            <!-- <div style="background:#6df31a; height:22px; padding-top:3px; color:#fff; font-weight:bold; font-size:12px; text-align:center; text-transform:uppercase;">
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
                                                                <span class="price" content="60" id="product-price-182-emprice-e28d8be0787e9d8ae65c6afe74f8df0a" style="color: #3E6807;">
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
                                                        <img class="em-alt-hover img-responsive em-lazy-loaded" src="{{asset('images/'.$item->image)}}" alt="{{$item->name}}" style="width: 100%;">

                                                        <img class="img-responsive em-alt-org em-lazy-loaded" src="{{asset('images/'.$item->image)}}" alt="{{$item->name}}" style="width: 100%;">
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
                                                            <!-- <div style="background:#6df31a; height:22px; padding-top:3px; color:#fff; font-weight:bold; font-size:12px; text-align:center; text-transform:uppercase;">
                                                                        còn hàng
                                                                    </div> -->
                                                            @else
                                                            <div style="background:#ff0000; height:30px; padding-top:6px; color:#fff; font-weight:bold; font-size:12px; text-align:center; text-transform:uppercase;">
                                                                hết hàng
                                                            </div>
                                                            @endif
                                                            <p class="special-price">
                                                                <span class="price" content="60" id="product-price-182-emprice-e28d8be0787e9d8ae65c6afe74f8df0a" style="color: #3E6807; padding-top:10px;">
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
                                </ul>
                            </div><!-- /.em-grid-mode -->

                            <div style="text-align: center;">
                                {!! urldecode($products->appends(request()->query())->links('vendor.pagination.default')); !!}
                            </div>
                        </div><!-- /.category-products -->

                        <script type="text/javascript">
                            $('.btn-add-to-cart').click(function() {
                                var id = $(this).attr('data-id');
                                var count = Number($(".em-topcart-qty").html());
                                $.ajax({
                                    type: 'post',
                                    url: '/checkout/cart',
                                    data: {
                                        _token: $('[name="_token"]').val(),
                                        id: id,
                                    },
                                    success: function(response) {
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
                                            .then(flag => {
                                                if (flag) {
                                                    window.location.href = "/checkout/cart";
                                                }
                                            })
                                    }
                                });
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
                    </div><!-- /.em-col-main -->


                    <div class="col-sm-6 col-sm-pull-18 em-col-left em-sidebar">
                        <div id="menuleftText" class="all_categories">
                            <div class="menuleftText-title">
                                <div class="menuleftText" style="width: 300px;"><span class="em-text-upercase">Danh mục sản phẩm</span>
                                </div>
                            </div>
                        </div><!-- /.menuleftText -->

                        <div class="menuleft">
                            <div id="menu-default" class="mega-menu em-menu-icon">
                                <div class="megamenu-wrapper wrapper-5_4607">
                                    <div class="em_nav" id="toogle_menu_5_4607">
                                        <ul class="vnav em-menu-icon effect-menu em-menu-long">
                                            <li class="menu-item-link menu-item-depth-0 fa fa-dropbox menu-item-parent" style="width: 300px;">
                                                <a class="em-menu-link" href="{{ url('/cua-hang/bo-sung-vitamin-khoang-chat') }}"> <span style="text-transform: uppercase;"> Bổ sung vitamin & khoáng chất </span> </a>
                                                <ul class="menu-container">
                                                    <li class="menu-item-hbox menu-item-depth-1 col-menu menu_col10  fix-top menu-item-parent" style="">
                                                        <ul class="menu-container">
                                                            <li class="menu-item-vbox menu-item-depth-2 col-sm-12 alpha menu-item-parent" style="">
                                                                <ul class="menu-container">
                                                                    <li class="menu-item-text menu-item-depth-3  ">

                                                                        <div class="padding-top20">
                                                                            <ul class="em-catalog-navigation vertical">
                                                                                @if(isset($menu_vitamin_products_asc))
                                                                                @foreach($menu_vitamin_products_asc as $i => $item)
                                                                                @if(0 <= $i && $i < 8) <li class="level0 nav-1">
                                                                                    @if(strlen($item->name) < 30) <a href="{{url('san-pham/'.$item->slug)}}"> <span>{{$item->name}}</span> </a>
                                                                                        @else
                                                                                        <a href="{{url('san-pham/'.$item->slug)}}"> <span>{{substr($item->name, 0, 30)}}...</span> </a>
                                                                                        @endif
                                                                    </li>
                                                                    @endif
                                                                    @endforeach
                                                                    @endif
                                                                </ul>
                                    </div>
                                    </li>
                                    </ul>
                                    </li><!-- /.menu-item-vbox -->

                                    <li class="menu-item-vbox menu-item-depth-2 col-sm-12 menu-item-parent" style="">
                                        <ul class="menu-container">
                                            <li class="menu-item-text menu-item-depth-3  ">
                                                <div class="padding-top20">
                                                    <ul class="em-catalog-navigation vertical">
                                                        @if(isset($menu_vitamin_products_asc))
                                                        @foreach($menu_vitamin_products_asc as $i => $item)
                                                        @if(8 <= $i) <li class="level0 nav-1 first">
                                                            @if(strlen($item->name) < 30) <a href="{{url('san-pham/'.$item->slug)}}"> <span>{{$item->name}}</span> </a>
                                                                @else
                                                                <a href="{{url('san-pham/'.$item->slug)}}"> <span>{{substr($item->name, 0, 30)}}...</span> </a>
                                                                @endif
                                            </li>
                                            @endif
                                            @endforeach
                                            <li class="level0 nav-2">
                                                <a href="{{ url('/cua-hang/bo-sung-vitamin-khoang-chat') }}"> <span>Xem thêm...</span> </a>
                                            </li>
                                            @endif
                                        </ul>
                                </div>
                                </li>
                                </ul>
                                </li><!-- /.menu-item-vbox -->
                                </ul>
                                </li><!-- /.menu-item-hbox -->
                                </ul>
                                </li><!-- /.menu-item-link -->


                                <li class="menu-item-link menu-item-depth-0 fa fa-dropbox menu-item-parent" style="width: 300px;">
                                    <a class="em-menu-link" href="{{ url('/cua-hang/nuoc-tang-luc-giai-khat') }}"> <span style="text-transform: uppercase;"> Nước tăng lực & giải khát </span> </a>
                                    <ul class="menu-container">
                                        <li class="menu-item-hbox menu-item-depth-1 col-menu menu_col10  fix-top menu-item-parent" style="">
                                            <ul class="menu-container">
                                                <li class="menu-item-vbox menu-item-depth-2 col-sm-12 alpha menu-item-parent" style="">
                                                    <ul class="menu-container">
                                                        <li class="menu-item-text menu-item-depth-3  ">

                                                            <div class="padding-top20">
                                                                <ul class="em-catalog-navigation vertical">
                                                                    @if(isset($menu_energy_products_asc))
                                                                    @foreach($menu_energy_products_asc as $i => $item)
                                                                    @if(0 <= $i && $i < 8) <li class="level0 nav-1">
                                                                        @if(strlen($item->name) < 30) <a href="{{url('san-pham/'.$item->slug)}}"> <span>{{$item->name}}</span> </a>
                                                                            @else
                                                                            <a href="{{url('san-pham/'.$item->slug)}}"> <span>{{substr($item->name, 0, 30)}}...</span> </a>
                                                                            @endif
                                                        </li>
                                                        @endif
                                                        @endforeach
                                                        @endif
                                                    </ul>
                            </div>
                            </li>
                            </ul>
                            </li><!-- /.menu-item-vbox -->

                            <li class="menu-item-vbox menu-item-depth-2 col-sm-12 menu-item-parent" style="">
                                <ul class="menu-container">
                                    <li class="menu-item-text menu-item-depth-3  ">
                                        <div class="padding-top20">
                                            <ul class="em-catalog-navigation vertical">
                                                @if(isset($menu_energy_products_asc))
                                                @foreach($menu_energy_products_asc as $i => $item)
                                                @if(8 <= $i) <li class="level0 nav-1 first">
                                                    @if(strlen($item->name) < 30) <a href="{{url('san-pham/'.$item->slug)}}"> <span>{{$item->name}}</span> </a>
                                                        @else
                                                        <a href="{{url('san-pham/'.$item->slug)}}"> <span>{{substr($item->name, 0, 30)}}...</span> </a>
                                                        @endif
                                    </li>
                                    @endif
                                    @endforeach
                                    <li class="level0 nav-2">
                                        <a href="{{ url('/cua-hang/nuoc-tang-luc-giai-khat') }}"> <span>Xem thêm...</span> </a>
                                    </li>
                                    @endif
                                </ul>
                        </div>
                        </li>
                        </ul>
                        </li><!-- /.menu-item-vbox -->
                        </ul>
                        </li><!-- /.menu-item-hbox -->
                        </ul>
                        </li><!-- /.menu-item-link -->

                        <li class="menu-item-link menu-item-depth-0 fa fa-dropbox menu-item-parent" style="width: 300px;">
                            <a class="em-menu-link" href="{{ url('/cua-hang/giau-chat-xo-tieu-hoa') }}"> <span style="text-transform: uppercase;"> Giàu chất xơ tiêu hóa </span> </a>
                            <ul class="menu-container">
                                <li class="menu-item-hbox menu-item-depth-1 col-menu menu_col10  fix-top menu-item-parent" style="">
                                    <ul class="menu-container">
                                        <li class="menu-item-vbox menu-item-depth-2 col-sm-12 alpha menu-item-parent" style="">
                                            <ul class="menu-container">
                                                <li class="menu-item-text menu-item-depth-3  ">

                                                    <div class="padding-top20">
                                                        <ul class="em-catalog-navigation vertical">
                                                            @if(isset($menu_fiber_products_asc))
                                                            @foreach($menu_fiber_products_asc as $i => $item)
                                                            @if(0 <= $i && $i < 8) <li class="level0 nav-1">
                                                                @if(strlen($item->name) < 30) <a href="{{url('san-pham/'.$item->slug)}}"> <span>{{$item->name}}</span> </a>
                                                                    @else
                                                                    <a href="{{url('san-pham/'.$item->slug)}}"> <span>{{substr($item->name, 0, 30)}}...</span> </a>
                                                                    @endif
                                                </li>
                                                @endif
                                                @endforeach
                                                @endif
                                            </ul>
                    </div>
                    </li>
                    </ul>
                    </li><!-- /.menu-item-vbox -->

                    <li class="menu-item-vbox menu-item-depth-2 col-sm-12 menu-item-parent" style="">
                        <ul class="menu-container">
                            <li class="menu-item-text menu-item-depth-3  ">
                                <div class="padding-top20">
                                    <ul class="em-catalog-navigation vertical">
                                        @if(isset($menu_fiber_products_asc))
                                        @foreach($menu_fiber_products_asc as $i => $item)
                                        @if(8 <= $i) <li class="level0 nav-1 first">
                                            @if(strlen($item->name) < 30) <a href="{{url('san-pham/'.$item->slug)}}"> <span>{{$item->name}}</span> </a>
                                                @else
                                                <a href="{{url('san-pham/'.$item->slug)}}"> <span>{{substr($item->name, 0, 30)}}...</span> </a>
                                                @endif
                            </li>
                            @endif
                            @endforeach
                            <li class="level0 nav-2">
                                <a href="{{ url('/cua-hang/giau-chat-xo-tieu-hoa') }}"> <span>Xem thêm...</span> </a>
                            </li>
                            @endif
                        </ul>
                </div>
                </li>
                </ul>
                </li><!-- /.menu-item-vbox -->
                </ul>
                </li><!-- /.menu-item-hbox -->
                </ul>
                </li><!-- /.menu-item-link -->

                <li class="menu-item-link menu-item-depth-0 fa fa-dropbox menu-item-parent" style="width: 300px;">
                    <a class="em-menu-link" href="{{ url('/cua-hang/chuc-nang-dac-biet') }}"> <span style="text-transform: uppercase;"> Chức năng đặc biệt </span> </a>
                    <ul class="menu-container">
                        <li class="menu-item-hbox menu-item-depth-1 col-menu menu_col10  fix-top menu-item-parent" style="">
                            <ul class="menu-container">
                                <li class="menu-item-vbox menu-item-depth-2 col-sm-12 alpha menu-item-parent" style="">
                                    <ul class="menu-container">
                                        <li class="menu-item-text menu-item-depth-3  ">

                                            <div class="padding-top20">
                                                <ul class="em-catalog-navigation vertical">
                                                    @if(isset($menu_special_products_asc))
                                                    @foreach($menu_special_products_asc as $i => $item)
                                                    @if(0 <= $i && $i < 8) <li class="level0 nav-1">
                                                        @if(strlen($item->name) < 30) <a href="{{url('san-pham/'.$item->slug)}}"> <span>{{$item->name}}</span> </a>
                                                            @else
                                                            <a href="{{url('san-pham/'.$item->slug)}}"> <span>{{substr($item->name, 0, 30)}}...</span> </a>
                                                            @endif
                                        </li>
                                        @endif
                                        @endforeach
                                        @endif
                                    </ul>
            </div>
            </li>
            </ul>
            </li><!-- /.menu-item-vbox -->

            <li class="menu-item-vbox menu-item-depth-2 col-sm-12 menu-item-parent" style="">
                <ul class="menu-container">
                    <li class="menu-item-text menu-item-depth-3  ">
                        <div class="padding-top20">
                            <ul class="em-catalog-navigation vertical">
                                @if(isset($menu_special_products_asc))
                                @foreach($menu_special_products_asc as $i => $item)
                                @if(8 <= $i) <li class="level0 nav-1 first">
                                    @if(strlen($item->name) < 30) <a href="{{url('san-pham/'.$item->slug)}}"> <span>{{$item->name}}</span> </a>
                                        @else
                                        <a href="{{url('san-pham/'.$item->slug)}}"> <span>{{substr($item->name, 0, 30)}}...</span> </a>
                                        @endif
                    </li>
                    @endif
                    @endforeach
                    <li class="level0 nav-2">
                        <a href="{{ url('/cua-hang/chuc-nang-dac-biet') }}"> <span>Xem thêm...</span> </a>
                    </li>
                    @endif
                </ul>
        </div>
        </li>
        </ul>
        </li><!-- /.menu-item-vbox -->
        </ul>
        </li><!-- /.menu-item-hbox -->
        </ul>
        </li><!-- /.menu-item-link -->

        </ul><!-- /.vnav -->
    </div>
</div><!-- /.megamenu-wrapper -->
</div>
</div><!-- /.menuleft -->

<div class="em-line-01 block block-layered-nav">

    <div class="em-block-title" style="text-align : center;">
        <strong><span style="color : #fff;">Nhà sản xuất</span></strong>
    </div>
    <div class="block-content" id="brand-scroll" style="padding-bottom : 20px; margin-bottom : 10px;">
        <ul id="narrow-by-list">
            <form method="get" action="" class="form-filllter">
                @if(isset($manufacturers))
                @foreach($manufacturers as $value)
                <li style="line-height : 30px; margin-top : 10px;">
                    <label class="check-sty" style="line-height : 30px;">
                        <input type="checkbox" name="facturer" value="{{$value->slug}}" @if(isset($check_manufactures[$value->id])) {{'checked'}} @endif >
                        <span class="checkmark"></span>
                        {{$value->name}}
                    </label>
                </li>
                @endforeach
                @endif
            </form>
        </ul>
    </div>
    <!-- brand checkbox-->

    <style>
        /* The check-sty */
        .check-sty {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default checkbox */
        .check-sty input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        /* Create a custom checkbox */
        .checkmark {
            position: absolute;
            top: 4px;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #eee;
        }

        /* On mouse-over, add a grey background color */
        .check-sty:hover input~.checkmark {
            background-color: #ccc;
        }

        /* When the checkbox is checked, add a blue background */
        .check-sty input:checked~.checkmark {
            background-color: #E67E22CC;
        }

        /* Create the checkmark/indicator (hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the checkmark when checked */
        .check-sty input:checked~.checkmark:after {
            display: block;
        }

        /* Style the checkmark/indicator */
        .check-sty .checkmark:after {
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }
    </style>

    <!-- brand-scroll -->
    <style>
        #brand-scroll {
            overflow-y: scroll;
            height: 300px;
        }

        #brand-scroll::-webkit-scrollbar {
            width: 5px;
            background-color: #fff;
            border-radius: 15px;
            border: 1px solid #fff;
        }

        #brand-scroll::-webkit-scrollbar-thumb {
            background-color: #E67E22CC;
            border-radius: 15px;
        }
    </style>

    <div class="em-wrapper-area02" style="margin-top : 30px;"></div>


    <div class="em-block-title" style="text-align : center;">
        <strong><span style="color : #fff;">Giá bán (VND)</span></strong>
    </div>

    @if($title == "Bổ sung vitamin & khoáng chất")
    @if(isset($price_sale_min_vitamin_product) && isset($price_sale_max_vitamin_product))
    <div class="block-content" style="text-align : center;">
        <input id="price-slider-amount" type="text" value="" class="slider form-control" data-slider-min="{{ $price_sale_min_vitamin_product*1000 }}" data-slider-max="{{ $price_sale_max_vitamin_product*1000 }}" data-slider-step="1" <?php if (isset($min_price) && isset($max_price)) { ?> data-slider-value="[<?php echo $min_price * 1000; ?>,<?php echo $max_price * 1000; ?>]" <?php } else { ?> data-slider-value="[20000,30000]" <?php } ?> data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="aqua">
        <div class="" style="font-size : 12px;">
            Giá từ:
            <span class="from">{{number_format($price_sale_min_vitamin_product*1000 ,0 ,'.' ,'.')}} VND</span>
            —
            <span class="to">{{number_format($price_sale_max_vitamin_product*1000 ,0 ,'.' ,'.')}} VND</span>
        </div>
        <button type="button" class="button btn-price-slider" style="margin-top : 15px; font-size : 13px;">Lọc theo giá</button>
    </div>
    @endif
    @elseif($title == "Nước tăng lực & giải khát")
    @if(isset($price_sale_min_energy_product) && isset($price_sale_max_energy_product))
    <div class="block-content" style="text-align : center;">
        <input id="price-slider-amount" type="text" value="" class="slider form-control" data-slider-min="{{ $price_sale_min_energy_product*1000 }}" data-slider-max="{{ $price_sale_max_energy_product*1000 }}" data-slider-step="1" <?php if (isset($min_price) && isset($max_price)) { ?> data-slider-value="[<?php echo $min_price * 1000; ?>,<?php echo $max_price * 1000; ?>]" <?php } else { ?> data-slider-value="[20000,30000]" <?php } ?> data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="aqua">
        <div class="" style="font-size : 12px;">
            Giá từ:
            <span class="from">{{number_format($price_sale_min_energy_product*1000 ,0 ,'.' ,'.')}} VND</span>
            —
            <span class="to">{{number_format($price_sale_max_energy_product*1000 ,0 ,'.' ,'.')}} VND</span>
        </div>
        <button type="button" class="button btn-price-slider" style="margin-top : 15px; font-size : 13px;">Lọc theo giá</button>
    </div>
    @endif
    @elseif($title == "Giàu chất xơ tiêu hóa")
    @if(isset($price_sale_min_fiber_product) && isset($price_sale_max_fiber_product))
    <div class="block-content" style="text-align : center;">
        <input id="price-slider-amount" type="text" value="" class="slider form-control" data-slider-min="{{ $price_sale_min_fiber_product*1000 }}" data-slider-max="{{ $price_sale_max_fiber_product*1000 }}" data-slider-step="1" <?php if (isset($min_price) && isset($max_price)) { ?> data-slider-value="[<?php echo $min_price * 1000; ?>,<?php echo $max_price * 1000; ?>]" <?php } else { ?> data-slider-value="[20000,30000]" <?php } ?> data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="aqua">
        <div class="" style="font-size : 12px;">
            Giá từ:
            <span class="from">{{number_format($price_sale_min_fiber_product*1000 ,0 ,'.' ,'.')}} VND</span>
            —
            <span class="to">{{number_format($price_sale_max_fiber_product*1000 ,0 ,'.' ,'.')}} VND</span>
        </div>
        <button type="button" class="button btn-price-slider" style="margin-top : 15px; font-size : 13px;">Lọc theo giá</button>
    </div>
    @endif
    @elseif($title == "Chức năng đặc biệt")
    @if(isset($price_sale_min_special_product) && isset($price_sale_max_special_product))
    <div class="block-content" style="text-align : center;">
        <input id="price-slider-amount" type="text" value="" class="slider form-control" data-slider-min="{{ $price_sale_min_special_product*1000 }}" data-slider-max="{{ $price_sale_max_special_product*1000 }}" data-slider-step="1" <?php if (isset($min_price) && isset($max_price)) { ?> data-slider-value="[<?php echo $min_price * 1000; ?>,<?php echo $max_price * 1000; ?>]" <?php } else { ?> data-slider-value="[20000,30000]" <?php } ?> data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="aqua">
        <div class="" style="font-size : 12px;">
            Giá từ:
            <span class="from">{{number_format($price_sale_min_special_product*1000 ,0 ,'.' ,'.')}} VND</span>
            —
            <span class="to">{{number_format($price_sale_max_special_product*1000 ,0 ,'.' ,'.')}} VND</span>
        </div>
        <button type="button" class="button btn-price-slider" style="margin-top : 15px; font-size : 13px;">Lọc theo giá</button>
    </div>
    @endif
    @endif



</div><!-- /.block-layered-nav -->

</div><!-- /.em-sidebar -->
</div>
</div><!-- /.em-main-container -->
</div>
</div>
</div><!-- /.em-wrapper-main -->

<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>

<script src="{{asset('plugins/bootstrap-slider/bootstrap-slider.js')}}"></script>
<script>
    $(function() {
        /* BOOTSTRAP SLIDER */
        $('.slider').slider()
    })
</script>

<script>
    $(document).ready(function() {
        $('#form-order').change(function() {
            var facturers_slug = [];
            var sortby = $(".sortby").val();

            $("input[name='facturer']:checked").each(function() {
                facturers_slug.push($(this).val());
            });

            var url = window.location.href.split('?')[0] + '?sortby=' + sortby;

            if (facturers_slug.length > 0) {
                url += '&brand=';
                url += facturers_slug.join(',');
            }

            window.location.href = decodeURI(url);
        });
    });
</script>

<script>
    $('.form-filllter').change(function() {
        var facturers_slug = [];
        var sortby = $(".sortby").val();

        $("input[name='facturer']:checked").each(function() {
            facturers_slug.push($(this).val());
        });

        var url = window.location.href.split('?')[0] + '?sortby=' + sortby;

        if (facturers_slug.length > 0) {
            url += '&brand=';
            url += facturers_slug.join(',');
        }

        window.location.href = decodeURI(url);
    });
</script>

<script>
    $('.btn-price-slider').click(function() {
        var facturers_slug = [];
        var sortby = $(".sortby").val();
        var price_slider_amount = $("#price-slider-amount").val().split(",");
        $("input[name='facturer']:checked").each(function() {
            facturers_slug.push($(this).val());
        });
        if (price_slider_amount.length > 0) {
            var price_slider_amount = $("#price-slider-amount").val().split(",");
            var url = window.location.href.split('?')[0] + '?sortby=' + sortby;
            url += '&min_price=' + price_slider_amount[0];
            url += '&max_price=' + price_slider_amount[1];
        }
        if (facturers_slug.length > 0) {
            url += '&brand=';
            url += facturers_slug.join(',');
        }
        window.location.href = decodeURI(url);
    });
</script>
@endsection