@foreach ($prod as $i => $product)
<tr>
    <td>{{ $i + 1 }}</td>
    <td><img src="{{ $product->image }}" style="height:3rem"></td>
    <td>{{ $product->name }}</td>
    <td>{{ $product->code }}</td>
    <td>{{ $product->qty }}</td>
    <td>{{ $product->price }}</td>
    <td>{{ $product->total }}</td>
</tr>
@endforeach
