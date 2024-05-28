@extends('layouts.master_home')

@section('title')
Thanh toán - Home Lab
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('home/css/upload.css')}}">
@endsection

@section('js')
<script type="text/javascript" src="{{asset('home/js/sweetalert.min.js')}}"></script>
@endsection

@section('home')
@if(isset($orders))
<?php $subtotal = 0; ?>
@foreach($orders as $order)
<?php
$subtotal += $order->price_sale * $order->quantity;
?>
@endforeach
@endif
<div class="em-wrapper-main">
    <div class="container container-main">
        <div class="em-inner-main">
            <div class="em-main-container em-col2-left-layout">
                @if(isset($orders) && isset($order_id))
                <div class="row">
                    <div class="col-sm-14 em-col-main">
                        <ol class="opc" id="checkoutSteps">
                            <li id="opc-billing" class="section allow">
                                <div class="em-box-02 step-title" data-toggle="collapse" data-target="#checkout-step-billing">
                                    <div class="title-box" style="background : #fff;"> <span class="number">1</span>
                                        <h2 style="color : black; text-transform: uppercase;">Thông tin thanh toán</h2>
                                    </div>
                                </div>
                                <div id="checkout-step-billing" class="step a-item collapse in">
                                    @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                    <div class="alert" style="background-color: #FF9800; border-color: #fb052d;color: #fffefe;">
                                        <ul><i class="fa fa-exclamation-triangle"></i> {{$error}}</ul>
                                    </div>
                                    @endforeach
                                    @endif
                                    @if(Auth::check())
                                    <form id="co-billing-form" action="{{ url('/checkout/payment') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <fieldset>
                                            <ul class="form-list">
                                                <li id="billing-new-address-form">
                                                    <fieldset>
                                                        <ul>
                                                            <li class="wide">
                                                                <label for="name" class="required"><em>*</em>Tên khách hàng</label>
                                                                <div class="input-box">
                                                                    <input type="text" name="name" id="getName" class="input-text form-control" value="{{Auth::user()->name}}" disabled />
                                                                    <input type="hidden" name="name" id="getName" class="input-text form-control" value="{{Auth::user()->name}}" />
                                                                    <input type="hidden" name="score_awards_payment" id="score_awards_payment" class="input-text form-control" value="0" />
                                                                </div>
                                                            </li>
                                                            <li class="wide">
                                                                <label for="name" class="required"><em>*</em>Số điện thoại</label>
                                                                <div class="input-box">
                                                                    <input type="text" name="phone_number" id="getPhone" class="input-text form-control" value="{{Auth::user()->phone_number}}" disabled />
                                                                    <input type="hidden" name="phone_number" id="getPhone" class="input-text form-control" value="{{Auth::user()->phone_number}}" />
                                                                </div>
                                                            </li>
                                                            <li class="wide">
                                                                <label for="address" class="required"><em>*</em>Địa chỉ nhận hàng</label>
                                                                <div class="input-box">
                                                                    <textarea name="address" class="form-control" id="getAddress" style="width: 100%; height : 80px; color: #111; font-size: 16px; line-height : 30px;">{{Auth::user()->address}}</textarea><br>
                                                                </div>
                                                            </li>
                                                            <li class="wide">
                                                                <label for="note" class="required">Ghi chú cho đơn hàng (Không bắt buộc)</label>
                                                                <div class="input-box">
                                                                    <textarea name="note" class="form-control" id="getNote" style="width: 100%; height : 100px; color: #111; font-size: 16px; line-height : 30px;"></textarea><br>
                                                                </div>
                                                            </li>

                                                            <input id="getUserId" type="hidden" name="customer_id" value="{{Auth::user()->id}}" class="form-control">
                                                            <input id="getAmount" type="hidden" name="amount" value="{{$subtotal}}" class="form-control">
                                                            <input id="getOrderId" type="hidden" name="order_id" value="{{$order_id}}" class="form-control">
                                                            <input id="getScoreAwards" type="hidden" name="score_awards" value="0" class="form-control">
                                                        </ul>
                                                    </fieldset>
                                                </li>
                                            </ul>
                                            <div class="buttons-set" id="billing-buttons-container">
                                                <button type="submit" class="button btn-checkout" style="width: 100%; height: 50px; font-size: 14px;" id="btn_checkout" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Đang xử lý">
                                                    Đặt mua
                                                </button>
                                                <p class="required" style="font-size : 12px;">(Xin vui lòng kiểm tra lại đơn hàng trước khi Đặt Mua)</p>
                                            </div>

                                        </fieldset>
                                    </form>
                                    @else
                                    <form id="co-billing-form" action="{{ url('/checkout/payment') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <fieldset>
                                            <ul class="form-list">
                                                <li id="billing-new-address-form">
                                                    <fieldset>
                                                        <ul>
                                                            <li class="wide">
                                                                <label for="name" class="required"><em>*</em>Tên khách hàng</label>
                                                                <div class="input-box">
                                                                    <input type="text" name="name" id="getName" class="input-text" value="{{ old('name') }}" />
                                                                </div>
                                                            </li>
                                                            <li class="wide">
                                                                <label for="phone_number" class="required"><em>*</em>Số điện thoại</label>
                                                                <div class="input-box">
                                                                    <input type="text" name="phone_number" id="getPhone" class="input-text" value="{{ old('phone_number') }}" />
                                                                </div>
                                                            </li>
                                                            <li class="wide">
                                                                <label for="address" class="required"><em>*</em>Địa chỉ nhận hàng</label>
                                                                <div class="input-box">
                                                                    <textarea name="address" class="form-control" id="getAddress" style="width: 100%; height : 60px;" value="{{ old('address') }}"></textarea><br>
                                                                </div>
                                                            </li>
                                                            <li class="wide">
                                                                <label for="email" class="required">Ghi chú cho đơn hàng (Không bắt buộc)</label>
                                                                <div class="input-box">
                                                                    <textarea name="note" class="form-control" id="getNote" style="width: 100%; height : 100px;" value="{{ old('note') }}"></textarea><br>
                                                                </div>
                                                            </li>

                                                            <input id="getAmount" type="hidden" name="amount" value="{{$subtotal}}" class="form-control">
                                                            <input id="getOrderId" type="hidden" name="order_id" value="{{$order_id}}" class="form-control">
                                                        </ul>
                                                    </fieldset>
                                                </li>
                                            </ul>
                                            <div class="buttons-set" id="billing-buttons-container">
                                                <button type="submit" class="button btn-checkout" style="width: 100%; height: 50px; font-size: 14px;" id="btn_checkout" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Đang xử lý">
                                                    Đặt mua
                                                </button>
                                                <p class="required" style="font-size : 12px;">(Xin vui lòng kiểm tra lại đơn hàng trước khi Đặt Mua)</p>
                                            </div>
                                        </fieldset>
                                    </form>
                                    @endif
                                </div><!-- /#checkout-step-billing -->
                            </li><!-- /#opc-billing -->
                        </ol>
                    </div>
                    <div class="col-sm-10 em-sidebar">
                        <div id="checkout-progress-wrapper">
                            <div class="block block-progress opc-block-progress em-line-01">
                                <div class="em-block-title block-title" style="background-color : #f9f9f9;">
                                    <strong><span>Đơn hàng của bạn</span></strong>
                                </div>
                                <div class="block-content" style="border-bottom: 1px solid #ececec;">
                                    <div class="col-sm-16">
                                        <strong><span style="text-transform : uppercase;">Sản phẩm</span></strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong><span style="text-transform : uppercase;">Tổng tiền</span></strong>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <?php $subtotal = 0; ?>
                                    @foreach($orders as $order)
                                    <?php
                                    $subtotal += $order->price_sale * $order->quantity;
                                    ?>
                                    <div class="row" style="padding-top : 15px; padding-bottom : 15px; border-bottom: 1px solid #ececec;">
                                        <div class="col-sm-16">
                                            <p style="font-size : 14px; color:#666;">{{$order->name}}<strong><span> x {{$order->quantity}}</span></strong></p>
                                        </div>
                                        <div class="col-sm-8">
                                            <p style="font-size : 14px; color:#666;">{{number_format($order->price_sale*$order->quantity*1000 ,0 ,'.' ,'.')}} VND</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="block-content" style="border-bottom: 1px solid #ececec;">
                                    <div class="col-sm-16">
                                        <span>Tạm tính :</span>
                                    </div>
                                    <div class="col-sm-8">
                                        <span>{{number_format($subtotal*1000 ,0 ,'.' ,'.')}} VND</span>
                                    </div>
                                </div>

                                <div class="block-content" style="margin-top: 20px; border-bottom: 1px solid #ececec;">
                                    <div class="col-sm-16">
                                        <strong><span>Tổng tiền :</span></strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong><span style="color : #ff0202;">{{number_format($subtotal*1000 ,0 ,'.' ,'.')}} VND</span></strong>
                                        <p style="color : #333; font-size: 12px;">(Đã bao gồm VAT)</p>
                                    </div>
                                    <br>
                                    <div class="col-sm-24">
                                        <p style="font-size: 13.5px; text-align:center;">(Chưa bao gồm phí vận chuyển. Xem thông tin <a target="_blank" href="{{url('/phuong-thuc-van-chuyen')}}" style="color: #3E6807 !important; font-weight:600 !important;">chi phí vận chuyển</a> )</p>
                                    </div>
                                </div>
                            </div>

                            <div class="block block-progress opc-block-progress em-line-01">
                                @if(Auth::check())
                                <div class="block-content" style="border-bottom: 1px solid #ececec;">
                                    <div class="col-sm-15" style="padding-top:18px !important;">
                                        <strong style="font-weight:400 !important; color: #000 !important; font-size: 14px;"><span>Điểm thưởng của bạn :</span></strong>
                                    </div>
                                    <div class="col-sm-9" style="padding-top:18px !important;">
                                        <strong>
                                            <span style="color : #ff0202; font-size:14px;">{{Auth::user()->score_awards}}
                                                <img src="{{asset('/images/icons/diem-thuong.svg')}}" style="width : 15px; height : 15px;">
                                            </span>
                                        </strong>
                                        <p style="color : #8e8e8e; font-size: 12px; padding-top:3px;">(1 điểm = 1000 VND)</p>
                                    </div>
                                </div>
                                @if(Auth::user()->score_awards > 0)
                                <div class="block-content" style="border-bottom: 1px solid #ececec;">
                                    <div class="col-sm-16">
                                        <br><label class="check-sty" style="margin-bottom: 20px;">
                                            <input type="checkbox" name="check_score_awards" class="check-use-score-awards" id="check_score_awards">
                                            <span class="checkmark"></span>
                                            Sử dụng điểm thưởng thanh toán
                                        </label>

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
                                                top: 0;
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
                                                background-color: #f3212b;
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
                                    </div>
                                </div>
                                <div id="score_payment" class="block-content" style="border-bottom: 1px solid #ececec; padding-bottom:20px; display:none;">
                                    <div class="col-sm-15" style="padding-top:22px !important;">
                                        <strong style="font-weight:400 !important; color: #000 !important; font-size: 14px;"><span>Số điểm cần thanh toán :</span></strong>
                                    </div>
                                    <div class="col-sm-9" style="padding-top:15px !important;">
                                        <strong>
                                            <span style="color : #ff0202; font-size:14px;">
                                                <input id="input-score-payment" type="number" name="qty" id="qty" value="0" min="0" max="{{number_format(Auth::user()->score_awards ,0 ,'.' ,'.')}}" class="input-text qty" style="width: 100px !important;">
                                                <img src="{{asset('/images/icons/diem-thuong.svg')}}" style="width : 20px; height : 20px;">
                                            </span>
                                        </strong>
                                    </div>
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div><!-- /.em-sidebar -->
                </div>
                @else
                <div style="text-align: center; margin-bottom: 50px; box-sizing : border-box;">
                    <img src="{{url('/images/shopping-cart/checkout-is-not-available.gif')}}" style="max-width : 300px;">
                </div>
                <div class="page-title" style="text-align: center; margin-top: 10px;">
                    <p style="font-size: 13px; color : #9c9c9c; font-weight: bold;">
                        Đặt hàng không thành công trong khi giỏ hàng của bạn trống.
                    </p>
                </div>
                <div style="text-align: center; margin-bottom: 20px;">
                    <a href="{{ url('/') }}" class="button-continue">
                        <span><span>Quay lại cửa hàng</span></span>
                    </a>
                </div>
                @endif
            </div><!-- /.em-main-container -->
        </div>
    </div>
</div>

<script>
    $('.btn-checkout').on('click', function() {
        var $this = $(this);
        $this.button('loading');
        setTimeout(function() {
            $this.button('reset');
        }, 3000);
    });
</script>

<script type="text/javascript">
    $(document).on('change', '.check-use-score-awards', function() {
        if ($('#check_score_awards').is(":checked")) {
            $('#getScoreAwards').val(1);
            $('#score_payment').css({
                "display": "block"
            });
        } else {
            $('#getScoreAwards').val(0);
            $('#score_payment').css({
                "display": "none"
            });
        }
    })

    @if(Auth::check())
    $(document).on('change', '#input-score-payment', function() {
        var score = $("#input-score-payment").val();
        var max_score = {
            {
                Auth::user() - > score_awards
            }
        }
        if (score < 0 || score > max_score) {
            swal({
                title: "Chú ý!",
                text: "Số điểm thanh toán không hợp lệ",
                icon: "warning",
                buttons: true,
                buttons: ["Ok"],
                timer: 5000
            });
        } else {
            $('#score_awards_payment').val(score);
        }
    });
    @endif
</script>

<script>
    var flag = false;
    $(document).ready(function() {
        $('.btn-add-files').click(function() {
            $('.file-input').last().trigger('click');
        });
    });

    $(document).on('change', '.file-input', function() {
        if (this.files && this.files[0]) {
            flag = true;

            var reader = new FileReader();

            reader.onload = function(e) {
                $('#thumbnail')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            $('#preview .row .show').removeClass('hidden');

            reader.readAsDataURL(this.files[0]);
        }
    });

    $('.btn-remove-image').click(function() {
        flag = false;
        $(this).parents('.show').addClass("hidden");
    });
</script>
@endsection