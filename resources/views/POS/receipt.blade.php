<!DOCTYPE html>
<html>
<head>
    <title>Receipt - {{ $order->invoice_no }}</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 13px;
            background: #f9f9f9;
            padding: 20px;
        }
        .receipt-container {
            width: 300px;
            margin: auto;
            background: white;
            padding: 15px;
            border: 1px dashed #000;
        }
        h2, h4 {
            text-align: center;
            margin: 2px 0;
        }
        .small {
            font-size: 12px;
        }
        table {
            width: 100%;
            margin-top: 10px;
        }
        th, td {
            padding: 3px;
            font-size: 12px;
        }
        tfoot td {
            font-weight: bold;
        }
        .center { text-align: center; }
        .line {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }
    </style>
</head>
<body onload="window.print()">

<div class="receipt-container">
    <h2>My Pharmacy POS</h2>
    <h4>Official Receipt</h4>
    <p class="small">Date: {{ $order->order_date }}</p>
    <p class="small">Invoice No: {{ $order->invoice_no }}</p>

    <div class="line"></div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th class="center">Price</th>
                <th class="center">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderDetails as $detail)
                <tr>
                    <td>{{ $detail->product->product_name ?? '' }}</td>
                    <td>{{ $detail->quantity ?? '' }}</td>
                    <td class="center">{{ number_format($detail->unitcost, 2) }}</td>
                    <td class="center">{{ number_format($detail->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Subtotal</td>
                <td class="center">{{ number_format($order->sub_total, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3">VAT ({{$order->vat ?? '' }}%) {{ $order->vat_status}}</td>
                <td class="center">{{ number_format($order->vat, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3">Grand Total</td>
                <td class="center">{{ number_format($order->total, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3">Paid</td>
                <td class="center">{{ number_format($order->pay, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3">Change Amount</td>
                <td class="center">{{ number_format($order->change_amount, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="line"></div>

    <p class="center">Thank you! Please come again.</p>
</div>

<script>
    // After print dialog is closed, auto-redirect cashier back to POS
    window.onafterprint = function () {
        window.location.href = "{{ route('pos') }}";
    };
</script>

</body>
</html>
