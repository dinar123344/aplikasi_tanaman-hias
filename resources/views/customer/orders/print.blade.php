<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f7f7f7; color: #222; margin: 0; padding: 0; }
        .invoice-page { max-width: 800px; margin: 24px auto; background: #fff; padding: 32px; border-radius: 24px; box-shadow: 0 18px 50px rgba(0,0,0,0.06); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
        .brand { color: #1b4332; font-size: 1.35rem; font-weight: 800; }
        .invoice-meta { text-align: right; }
        .invoice-meta div { margin-bottom: 6px; }
        .invoice-title { font-size: 1.8rem; margin-bottom: 24px; color: #1b4332; }
        .details, .summary { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .details th, .details td, .summary th, .summary td { padding: 14px 16px; border: 1px solid #e9ecef; }
        .details th { background: #f8faf9; text-align: left; color: #495057; }
        .details td { background: #fff; }
        .summary td { border: none; padding: 10px 16px; }
        .text-right { text-align: right; }
        .total { font-size: 1.15rem; font-weight: 700; color: #1b4332; }
        .status { display: inline-flex; align-items: center; padding: 8px 14px; border-radius: 999px; font-weight: 700; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-paid { background: #d1e7dd; color: #0f5132; }
        .status-canceled { background: #f8d7da; color: #842029; }
        .print-note { margin-top: 32px; color: #6c757d; font-size: 0.95rem; }
    </style>
</head>
<body>
    <div class="invoice-page">
        <div class="header">
            <div class="brand">Tanaman Hias</div>
            <div class="invoice-meta">
                <div>Struk Pesanan: <strong>#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong></div>
                <div>Tanggal: {{ $order->order_date->format('d M Y, H:i') }}</div>
                <div>Status: 
                    @if($order->status == 'pending')
                        <span class="status status-pending">Menunggu</span>
                    @elseif($order->status == 'paid')
                        <span class="status status-paid">Lunas</span>
                    @else
                        <span class="status status-canceled">Dibatalkan</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="invoice-title">Rincian Pesanan</div>

        <table class="details">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table class="summary">
            <tr>
                <td>Total Item</td>
                <td class="text-right">{{ $order->orderItems->sum('quantity') }}</td>
            </tr>
            <tr>
                <td>Total Pembayaran</td>
                <td class="text-right total">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
            </tr>
        </table>

        <table class="summary" style="margin-top:8px;">
            <tr>
                <td>Alamat Pengiriman</td>
                <td class="text-right">{{ $order->shipping_address ?? '-' }}</td>
            </tr>
            <tr>
                <td>Kurir</td>
                <td class="text-right">{{ $order->courier_name ?? '-' }} {{ $order->courier_service ? '(' . $order->courier_service . ')' : '' }}</td>
            </tr>
            <tr>
                <td>Nomor Resi</td>
                <td class="text-right">{{ $order->tracking_number ?? '-' }}</td>
            </tr>
            <tr>
                <td>Metode Pembayaran</td>
                <td class="text-right">{{ $order->payment_method ? ucfirst($order->payment_method) : '-' }}</td>
            </tr>
        </table>

        <div class="print-note">Cetak struk ini untuk kebutuhan bukti transaksi dan referensi pesanan.</div>
    </div>

    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>
</html>