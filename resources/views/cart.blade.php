@extends('layout')
@section('title', 'Cart')
@section('content')
    <table id="cart" class="table table-hover table-condensed">
        <thead>
        <tr>
            <th style="width:50%">Product</th>
            <th style="width:10%">Price</th>
            <th style="width:8%">Quantity</th>
            <th style="width:22%" class="text-center">Subtotal</th>
            <th style="width:10%"></th>
        </tr>
        </thead>
        <tbody>
        <?php $total = 0 ?>
        @if(session('cart'))
            @foreach(session('cart') as $id => $details)
                <?php $total += $details['price'] * $details['quantity'] ?>
                <tr>
                    <td data-th="Product">
                        <div class="row">
                            <div class="col-sm-3 hidden-xs"><img src="{{ $details['photo'] }}" width="100" height="100" class="img-responsive"/></div>
                            <div class="col-sm-9">
                                <h4 class="nomargin">{{ $details['name'] }}</h4>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price" id="price{{ $id }}" data-value="{{ $details['price'] }}">${{ $details['price'] }}</td>
                    <td data-th="Quantity">
                        <input type="number" id="quantity{{ $id }}" value="{{ $details['quantity'] }}" data-id="{{ $id }}" class="form-control quantity update-quantity" max="5001" min="0" onchange="prueba({{ $id }});"/>
                    </td>
                    <td data-th="Subtotal" class="text-center" id="subtotal{{ $id }}">${{ $details['price'] * $details['quantity'] }}</td>
                    <td class="actions" data-th="">
                        <!-- <button class="btn btn-info btn-sm update-cart" data-id="{{ $id }}"><i class="fa fa-refresh"></i></button> -->
                        <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}" data-name="{{ $details['name'] }}" data-quantity="{{ $details['quantity'] }}"><i class="fa fa-trash-o"></i></button>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
        <tfoot>
        <tr class="visible-xs">
            <td class="text-center"><strong>Total {{ $total }}</strong></td>
        </tr>
        <tr>
            <td><a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
            <td colspan="2" class="hidden-xs"></td>
            <td class="hidden-xs text-center"><strong>Total ${{ $total }}</strong></td>
        </tr>
        </tfoot>
    </table>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(".update-cart").click(function (e) {
           e.preventDefault();
           var ele = $(this);
            $.ajax({
               url: '{{ url('update-cart') }}',
               method: "patch",
               data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.parents("tr").find(".quantity").val()},
               success: function (response) {
                   window.location.reload();
               }
            });
        });
        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            if(confirm("Quieres eliminar "+ ele.attr("data-quantity")+" " +ele.attr("data-name") + " del carrito")) {
                $.ajax({
                    url: '{{ url('remove-from-cart') }}',
                    method: "DELETE",
                    data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });
        
        $(".update-quantity").change(function (e) {
            e.preventDefault();
           var ele = $(this);
           var var1= $(this).val()
            $.ajax({
               url: '{{ url('update-cart') }}',
               method: "patch",
               data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: var1},
               success: function (response) {
                   window.location.reload();
               }
            });
            
        });
        
        /*
        function prueba(id) {
            var var1 = $("#price"+id).attr('data-value');
            var var2 = document.getElementById("quantity"+id).value
            var1=parseInt(var1);
            var1=var1*var2
            $("#subtotal"+id).text("$"+var1);
            //$("#cart-dropmenu").text(var2);
            //$("#cart-dropmenu-i").text(var2);
            $("#layout-quantity"+id).text("Quantity: "+var2);
        }
        */
    </script>
@endsection