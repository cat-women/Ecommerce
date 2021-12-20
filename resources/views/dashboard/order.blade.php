@extends('dashboard.header')
@section('content')

<h1>order table </h1>
<div class="row text-white">
    <div class="col">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.N</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Product Name</th>
                    {{--
                    <th scope="col">Price</th>
                    <th scope="col">Payment Type</th>
                    <th scope="col">Emai </th>
                    <th scope="col">Phone </th>
                    --}}
                    <th scope="col">Payment Status </th>
                    <th scope="col">Delivery Status </th>
                    <th scope="col">Delivery By </th>
                    <th scope="col">Delivery At </th>
                    

                </tr>
            </thead>
            <tbody>
                @foreach($orders as $index => $order)
                <tr>
                    <th scope="row">{{ $index+1 }}</th>
                    <td> {{ $order->name }} </td>
                    <td>{{ $order->p_name }}</td>
                    {{--
                    <td>{{ $order->p_price}}</td>
                    <td> {{ $order->payment_type }} </td>
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->phone }}</td>
                    --}}
                    <td>
                        @if($order->status == 1 ) Paid
                        @else  <h6  style="color: red;"> Not Paid </h6>
                        <button type="button" class="btn btn-primary">Update</button>
                        @endif
                    </td>
                    <td> 
                        @if($order->delivery_status == 1 ) Delivered
                        @else  <h6  style="color: red;"> Pending</h6>
                        <button type="button" class="btn btn-primary">Update</button>
                        @endif
                    </td>
                    
                    <td> 
                        @if($order->delivery_status == 1 ) {{ $order->deliver_by }} 
                        @endif                      
                    </td>
                    
                    <td> 
                        @if($order->delivery_status == 1 ) {{ $order->updated_at }}  
                        @endif                      
                    </td>

                     
                    <td> 
                       <button type="button" class="btn btn-secondary">View Details</button>                      
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection