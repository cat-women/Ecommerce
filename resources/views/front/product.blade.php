@extends('front.layout')
@section('content')
<style>
    input[type='number'] {
        font-size: 24px;
    }

    ul#tag li {
        display: inline;
    }
</style>

<div class="container border border-dark">
    <div class="row m-3 ">
        <div class="col ">
            <img class="img" src="/storage/productImage/{{$product->image}}" alt="Medusa" style="width: 80%; height:80%;">
        </div>
        <div class="col">
            <div class="row">
                <div class="col  m-3 text-decoration-underline">
                    <h3>{{$product->p_name}}</h3>

                </div>
            </div>
            <div class="row">
                <div class="col border border-bottom m-3">
                    <p>{{$product->p_desc}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col  border border-bottom m-3">
                    <h6>Price : Rs. {{$product->p_price}}</h6>
                    @if($product->is_avail == 1)
                    <i>Abailability : Yes</i>
                    @else
                    <i>Abailability : Comming Soon</i>
                    @endif

                    <h4 style="color: red;">Discount: 50%</h4>
                </div>
            </div>
            <div class="row p-3">
                <div class="col  m-3">
                    <form method="POST" action="/carts" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group m-3">
                            <div class="input-group-append m-3">
                                <label> Quantity</label>
                            </div>
                            <input type="number" name="quantity" min=0 size="40" style="height: 40px; width:40px;" class="form-control m-3" id="quantity">
                            <input type="hidden" name="product_id" value="{{ $product->id }}" class="form-control">
                            <div class="input-group-append">
                            <span id="error" style="color: red; display:inline;"></span>

                                <button type="submit" class="btn btn-primary m-3" id="add_cart" value=" Add to card">Add to card
                                        
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div>
                    <button type="button" class="btn bg-gray text-light">
                        <a href="/orders/{{ $product->id}}">Buy Now</a>
                    </button>

                </div>

            </div>
            <div class="row p-3">
                <div class="col border border-bottom m-3">
                    <p>Highlight</p>
                    <ul type="none">
                        <li>Featurs </li>
                        <li>Featurs </li>
                        <li>Featurs </li>
                        <li>Featurs </li>

                    </ul>
                </div>
            </div>
            <div class="row p-3">
                <div class="col border border-bottom m-3">
                    <i>Tags</i>
                    <ul type="none" id="tag" class="list-inline">
                        @foreach($product->p_tag as $tag)
                        <li class="m-4 list-inline-item">{{$tag}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        {{$product->p_cat}}
    </div>
</div>

<div style="height: 400px;">

</div>

<script>
    $(document).ready(function() {
        $("#add_cart").click(function(event) {
            event.preventDefault();
            $qty = $("#quantity").val();
            if( $qty == '')
            {
                $("#error").text("Can't submit empty form ");                
                $('#quantity').focus();
                return false;
            }
            
            
        });
    });
</script>
@endsection

