@extends('layouts.master_home')

@section('title')
Phương thức vận chuyển - Home Lab
@endsection

@section('css')
<!-- Blog Style CSS -->
<link rel="stylesheet" type="text/css" href="{{asset('/home/css/blog-styles.css')}}" media="all" />
@endsection

@section('home')

<div class="em-wrapper-main">
    <div class="container container-main">
        <div class="em-inner-main">
            <div class="em-wrapper-area02"></div>
            <div class="em-main-container em-col2-left-layout">
                <div class="row">
                    <div class="col-sm-24 em-col-main">
                        <div class="em_post-item">
                            <div class="" style="text-align : justify; padding: 10px 10px; line-height : 30px;">
                                <p><strong>PHƯƠNG THỨC VẬN CHUYỂN</strong></p>

                                <p>Hiện nay, Home Lab chỉ hỗ trợ giao hàng các đơn hàng trong Hà Nội có giá trị từ 100.000đ trở lên và các đơn hàng ngoại tỉnh có giá trị từ 300.000đ trở lên.</p>

                                <p>1. Các đơn hàng của quý khách sẽ được nhân viên tư vấn liên hệ lại để tư vấn cho quý khách. Sau khi tư vấn và xác nhận, đơn hàng sẽ được nhân viên giao hàng giao đến nơi quý khách đặt hàng.</p>

                                <p>Với các đơn hàng được đặt trong thời gian làm việc từ 8h đến 5h chiều, đơn hàng sẽ được giao trong ngày. </p>

                                <p>Với các đơn hàng được đặt sau 5 giờ chiều, đơn hàng sẽ được giao trong ngày hôm sau.</p>

                                <p>2. Cước phí giao hàng được tính như sau:</p>

                                <p>- Phí giao hàng được tính theo khoảng cách địa lý và sẽ được nhân viên nhà thuốc báo lại sau khi nhận được đơn đặt hàng.</p>
                            </div>
                        </div>
                    </div><!-- /.em-col-main -->
                </div>
            </div><!-- /.em-main-container -->
        </div>
    </div>
</div>

@endsection