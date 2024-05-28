@extends('layouts.master_home')

@section('title')
    404 Not Found - Home Lab
@endsection

@section('home')
<div class="row">
    <div class="em-col-main col-sm-24">
        <div class="std">
            <div class="text-center">
                <div class="not-pound-content">
                    <p><img class="img-responsive" alt="" src="{{asset('images/icons/img-404.png')}}" />
                    </p>
                    <div>
                        <p>Rất tiếc... Trang bạn yêu cầu không được tìm thấy và chúng tôi có một phỏng đoán tại sao:</p>
                        <ul class="none-style">
                            <li>Nếu bạn nhập URL trực tiếp, vui lòng đảm bảo chính tả.</li>
                            <li>Nếu bạn nhấp vào một liên kết để đến đây, liên kết đã không còn hiệu lực.</li>
                        </ul>
                        <p>Vậy bạn sẽ phải làm gì? Đã có chúng tôi giúp bạn!</p>
                        <ul class="none-style group-button">
                            <li><a class="button-link" onclick="history.go(-1);" href="javascript:avoid(0)"><span><span>Quay lại</span></span></a>
                            </li>
                            <li><a class="button-link" href="{{ url('/') }}"><span><span>Về cửa hàng</span></span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection