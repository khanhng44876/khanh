<x-mail::message>

# Đơn hàng # {{ $order->id }} đã được tiếp nhận

Xin chào **{{ $order->user->name }}**,

Cảm ơn bạn đã đặt hàng 
Dưới đây là chi tiết đơn hàng của bạn:

| Sản phẩm          | Số lượng | Đơn giá       | Thành tiền    |
|-------------------|----------|---------------|---------------|
@foreach($order->detail as $item)
| {{ $item->product->name }} | {{ $item->quantity }}      | {{ number_format($item->product->price) }}₫ | {{ number_format($item->total) }}₫ |
@endforeach
| **Tổng cộng**     |          |               | **{{ number_format($order->total) }}₫** |


<x-mail::button :url="route('order.follow',$order->id)">
Xem chi tiết đơn hàng
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
