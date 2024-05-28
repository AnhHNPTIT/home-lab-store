@extends('layouts.master_home')

@section('title')
Lịch sử đặt hàng - Home Lab
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
                    <div class="col-sm-18 col-sm-push-6 em-col-main clearfix">
                        @if(isset($transactions))
                        <div>
                            <form id="wishlist-view-form">
                                @csrf
                                <fieldset>
                                    <table id="tbl_orders" class="data-table" style="font-size : 13.5px;">
                                        <thead>
                                            <tr>
                                                <td class="col-sm-3" style="text-align : center;">
                                                    Mã đơn hàng
                                                </td>
                                                <td class="col-sm-3" style="text-align : center;">
                                                    Ngày đặt mua
                                                </td>
                                                <td class="col-sm-3" style="text-align : center;">
                                                    Tổng tiền
                                                </td>
                                                <td class="col-sm-4" style="text-align : center;">
                                                    Thanh toán điểm
                                                </td>
                                                <td class="col-sm-5" style="text-align : center;">
                                                    Thanh toán tiền mặt
                                                </td>
                                                <td class="col-sm-3" style="text-align : center;">
                                                    Trạng thái
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transactions as $transaction)
                                            <tr>
                                                <td class="col-sm-3" style="text-align : center;">
                                                    <a href="{{ url('/transaction/detail/'.$transaction->order_id) }}">
                                                        {{$transaction->order_id}}
                                                    </a>
                                                </td>

                                                <td class="col-sm-3" style="text-align : center;">
                                                    {{$transaction->created_at}}
                                                </td>

                                                <td class="col-sm-3" style="text-align : center;">
                                                    {{number_format($transaction->amount*1000 ,0 ,'.' ,'.')}} VND
                                                </td>

                                                <td class="col-sm-4" style="text-align : center;">
                                                    <span style="color : #03A9F4;">
                                                        {{$transaction->score_awards}}
                                                        <img src="{{asset('/images/icons/diem-thuong.svg')}}" style="width : 15px; height : 15px;">
                                                        = {{number_format($transaction->score_awards*1000 ,0 ,'.' ,'.')}} VND
                                                    </span>
                                                </td>

                                                <td class="col-sm-5" style="text-align : center; color : #03A9F4;">
                                                    {{number_format($transaction->amount*1000 ,0 ,'.' ,'.')}} VND
                                                </td>

                                                <td class="col-sm-3" style="text-align : center;">
                                                    @if($transaction->status == 0)
                                                    <span style="background-color: #ffc800 !important; color : #fff; padding: 4px 5px; font-size : 12px; font-weight: bold;">Đang chờ</span>
                                                    @else
                                                    @if($transaction->status == 1)
                                                    <span style="background-color: #00c0ef !important; color : #fff; padding: 4px 5px; font-size : 12px; font-weight: bold;">Đang giao</span>
                                                    @else
                                                    @if($transaction->status == 2)
                                                    <span style="background-color: #00a65a !important; color : #fff; padding: 4px 5px; font-size : 12px; font-weight: bold;">Đã giao</span>
                                                    @else
                                                    @if($transaction->status == 3)
                                                    <span style="background-color: #dd4b39 !important; color : #fff; padding: 4px 5px; font-size : 12px; font-weight: bold;">Đã hủy</span>
                                                    @endif
                                                    @endif
                                                    @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </fieldset>
                            </form>
                        </div>
                        <div style="text-align: center;">
                            {!! urldecode($transactions->appends(request()->query())->links('vendor.pagination.default')); !!}
                        </div>
                        @endif
                        <div class="buttons-set right" style="margin-top : 20px; margin-bottom : 20px;">
                            <p class="back-link"><a href="{{ url('/') }}"><small>&laquo; </small>Quay lại cửa hàng</a>
                            </p>
                        </div>
                    </div><!-- /.em-col-main -->

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
                                                <a class="em-menu-link" href="{{ url('/my_account/'.Auth::user()->id) }}" id="link-my-account"> <span> Thông tin tài khoản </span> </a>
                                            </li><!-- /.menu-item-link -->

                                            <li class="menu-item-link menu-item-depth-0 fa fa-shopping-cart">
                                                <a class="em-menu-link" href="{{ url('/transaction/history/'.Auth::user()->id) }}" id="link-transaction-history">
                                                    <span style="color : #ffffff; btransaction-color: #fdbd8d; background-color: #E67E22CC;"> Lịch sử đặt hàng </span> </a>
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
            </div>
        </div><!-- /.em-main-container -->
    </div>
</div>
</div><!-- /.em-wrapper-main -->
@endsection