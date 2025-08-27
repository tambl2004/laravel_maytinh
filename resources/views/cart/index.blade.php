<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng của bạn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('products.index') }}">Tablet Shop</a>
        </div>
    </nav>

    <div class="container my-5">
        <h1>Giỏ hàng của bạn</h1>

        @if(!empty($cart))
            <table class="table table-hover mt-4">
                <thead>
                    <tr>
                        <th scope="col">Sản phẩm</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col" class="text-end">Tổng phụ</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $details)
                        @php $subtotal = $details['price'] * $details['quantity']; $total += $subtotal; @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $details['image'] }}" alt="{{ $details['name'] }}" style="width: 50px; height: 50px; object-fit: cover;">
                                    <span class="ms-3">{{ $details['name'] }}</span>
                                </div>
                            </td>
                            <td>{{ number_format($details['price'], 0, ',', '.') }} VNĐ</td>
                            <td>{{ $details['quantity'] }}</td>
                            <td class="text-end">{{ number_format($subtotal, 0, ',', '.') }} VNĐ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-end mt-4">
                <h3>Tổng cộng: <span class="text-danger">{{ number_format($total, 0, ',', '.') }} VNĐ</span></h3>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Tiếp tục mua sắm</a>
                <a href="#" class="btn btn-primary">Tiến hành thanh toán</a>
            </div>

        @else
            <div class="alert alert-info mt-4">
                Giỏ hàng của bạn đang trống.
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>