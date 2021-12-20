@extends('front.layout')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container m-3 p-3">
    <div class="row justify-content-md-center">
        <div class="col col-md-6">
            <form action="/order" method="POST">
                @csrf
                <input type="text" class="form-control" id="cart_id" name="cart_id" value="{{ $product->id }}" hidden>
                <input type="text" class="form-control" id="pro_id" name="pro_id" value="{{ $product->pro_id }}" hidden>

                <h6 class="text-center " style="font-size: 30px; color: red">User detail</h6>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" value="{{auth()->user()->name}}" readonly>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{auth()->user()->email}}">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{auth()->user()->phone_no}}">
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address">
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" min="1" class="form-control" id="quantity" name="quantity" class="inputValue">
                </div>

                <div class="mb-3">
                    <label for="payment_type" class="form-label">Payment Type</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="cod" id="cod" name="payment_type" onchange="change_cod()">
                        <label class="form-check-label" for="flexCheckDefault" onclick="cod_change()">
                            Cash on Delivery
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="gateway" id="gateway" checked name="payment_type">
                        <button class="form-check-label" for="gateway" onclick="show_paypal()">
                            Gateway
                        </button>
                    </div>

                    {{-- Paypal Button --}}
                    <div id="paypal-button-container" class="paypal_btn"> </div>

                </div>
                <button type="submit" class="btn btn-primary" id="order_button">Submit</button>
            </form>
        </div>
        <div class="col col-md-6">
            <table class="table">
                <h6 class="text-center " style="font-size: 30px; color: red">Order Details </h6>
                <thead>
                    <tr>
                        <th scope="col">Product</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="Pname">{{ $product->p_name }}</td>
                        <td class="qty">1</td>
                        <td class="price">{{ $product->p_price }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Delivery Charge</td>
                        <td class="font-italic"> 0 </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td> Tax </td>
                        <td class="tax"> 13% </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="font-weight-bold"> Total </td>
                        <td class="total font-weight-bold">{{ $product->p_price }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
<h5>testing some thhng </h5>
<button id="test123">
press to test
</button>
<div style="height: 150px;">
</div>

{{-- Paypal js --}}
<script src="https://www.paypal.com/sdk/js?client-id=AWt9jQuR5BHNyk0xNyPGLt2NJm4mbSTL3SnzzeRL7rBJf9MkkU2hnIot7uq0mgmGhOkkoM8sXkXZnzt4"></script>

<script>
     
    var $price = '{{ $product->p_price}}';
    var $qty = $('#quantity').val();
    var $total = $qty * $price;
        
  paypal.Buttons({
    createOrder: function(data, actions) {
      // This function sets up the details of the transaction, including the amount and line item details.
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: $total
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      // This function captures the funds from the transaction.
      return actions.order.capture().then(function(details) {          
        $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                dataType:'json',
                method: 'POST',
                url: "{{ route('payment.store') }}",
                data: {
                    cart_id:'{{ $product->id }}',                        
                    pro_id: '{{ $product->pro_id }}',
                    payment_id:details.id,
                    amount: $total,
                    payment_mode: 'paypal',
                    email: 'test@gmail.com',
                    status:1                        
                },
                success: function(response) {
                    console.log(response.status);
                    alert('payment successful');
                    window.location.href = '/carts' 
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                 },
            });


        //alert('Transaction completed by ' + details.payer.name.given_name);
      });
    }
  }).render('#paypal-button-container');
  //This function displays Smart Payment Buttons on your web page.
  
</script>


<script>
    $('input[name="quantity"]').keyup(function() {
        $n = $(this).val();
        $p = $('.price').text();
        $('.qty').text($n);
        $total = Number($n) * Number($p);
        $total += $total * 0.13;
        $('.total').text($total);

    });

    // COD
    function cod_change(){
        $('.paypal_btn').toggle();   
    }
    function show_paypal()
    {
        $('.paypal_btn').show();
    }
    $(document).ready(function(){
        $('#order_button').on('click',function(){
            var ran = Math.floor(Math.random() * (1000 - 100) ) + 100;
            var c_id = '{{ $product->id}}';
            var pay_id = ran.toString() + c_id.toString();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                    dataType:'json',
                    method: 'POST',                    
                    url: "{{ route('payment.store') }}",
                    data: {
                        cart_id:'{{ $product->id }}',                        
                        pro_id: '{{ $product->pro_id }}',
                        payment_id: Number(pay_id),
                        amount: $total,
                        payment_mode: 'cod',
                        email: 'test@gmail.com',
                        status:0                       
                    },
                    success: function(response) {
                       alert(response);
                        alert('payment successful');
                        window.location.href = '/carts' 
                    },
                    error: function (data, textStatus, errorThrown) {
                        console.log(data);
                    }
                });

        });
    });
</script>



@endsection


