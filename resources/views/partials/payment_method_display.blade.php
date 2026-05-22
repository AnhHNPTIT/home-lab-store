@php
    use App\Support\PaymentMethod;
    $method = $transaction->payment_method ?? PaymentMethod::COD;
@endphp
<span class="label {{ $method === PaymentMethod::VNPAY ? 'label-primary' : 'label-default' }}">
    {{ PaymentMethod::label($method) }}
</span>
@if($method === PaymentMethod::VNPAY && !empty($transaction->payment_status))
    <br><small>{{ PaymentMethod::paymentStatusLabel($transaction->payment_status) }}</small>
@endif
