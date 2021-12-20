@extends('front.layout')
@section('content')

<!-- Carousel -->
<div id="carouselId" class="carousel slide" data-ride="carousel" style="left: 50px; right:50px; top:20px; padding:20px;">

  <ol class="carousel-indicators">
    <li data-target="#carouselId" data-slide-to="0" class="active"></li>
    <li data-target="#carouselId" data-slide-to="1"></li>
    <li data-target="#carouselId" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner ">
    <div class="carousel-item active">
      <img class="" src="{{ URL::to('/images/logo1.png') }}" alt="First slide" style="width: 90%; height:50%; ">
    </div>
    <div class="carousel-item">
      <img class="" src="{{ URL::to('/images/carousel/c2.jfif') }}" alt="Second slide" style="width: 90%; height:70%;">
    </div>
    <div class="carousel-item">
      <img class="" src="{{ URL::to('/images/carousel/c3.jfif') }}" alt="Third slide" style="width: 90%; height:70%;">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

{{-- end of carousel --}}

<hr>

{{--From database --}}

@if(count($products)>0)

{{-- For man's clothes --}}

<div class="container">
<h5 class="card-title text-center m-3 p-3">Man's clothes </h5>

  <div class="row m-3 border border-dark justify-content-center" id="man">
    @for ($i = 0; $i < count($products); $i++) 
      @if($products[$i]->p_cat == "man's clothes")
        <div class="col-sm-3  border border-primary m-3 " style="background-color:#F5EAF5;">
          <img class="img" src="/storage/productImage/{{$products[$i]->image}}" alt="Medusa" style="width: 200px; height:250px;">
          <h6>Price Rs. {{$products[$i]->p_price}} </h6>
          <h6>{{$products[$i]->p_cat}}</h6>
          <button type="button" class="btn btn-primary ">
            <a href="/products/{{$products[$i]->id}}" class="text-light">Add to card</a>
          </button>          
          <button type="button" class="btn btn-primary">
            <a href="/products/{{$products[$i]->id}}" class="text-light">View Detail</a>
          </button>
        </div>
        @endif
      @endfor
  </div>
</div>

{{-- women clothes --}}
<div class="container">
<h5 class="card-title text-center m-3 p-3">Women's clothes </h5>

  <div class="row m-3 border border-dark justify-content-center" id="women">
    @for ($i = 0; $i < count($products); $i++) 
      @if($products[$i]->p_cat == "women's clothes")
        <div class="col-sm-3 border border-primary m-3 " style="background-color:#F5EAF5;">
          <img class="img" src="/storage/productImage/{{$products[$i]->image}}" alt="Medusa" style="width: 200px; height:250px;">
          <h6>Price Rs. {{$products[$i]->p_price}} </h6>
          <h6>{{$products[$i]->p_cat}}</h6>
          <button type="button" class="btn btn-primary ">
            <a href="/products/{{$products[$i]->id}}" class="text-light">Add to card</a>
          </button>          
          <button type="button" class="btn btn-primary">
            <a href="/products/{{$products[$i]->id}}" class="text-light">View Detail</a>
          </button>
        </div>
        @endif
      @endfor
  </div>
</div>

{{-- kid clothes --}}
<div class="container">
<h5 class="card-title text-center m-3 p-3">Kids's clothes </h5>

  <div class="row m-3 border border-dark justify-content-center" id="kid">
    @for ($i = 0; $i < count($products); $i++) 
      @if($products[$i]->p_cat == "kids clothes")
        <div class="col-sm-3 border border-primary m-3 " style="background-color:#F5EAF5;">
          <img class="img" src="/storage/productImage/{{$products[$i]->image}}" alt="Medusa" style="width: 200px; height:250px;">
          <h6>Price Rs. {{$products[$i]->p_price}} </h6>
          <h6>{{$products[$i]->p_cat}}</h6>
          <button type="button" class="btn btn-primary ">
            <a href="/products/{{$products[$i]->id}}" class="text-light">Add to card</a>
          </button>          
          <button type="button" class="btn btn-primary">
            <a href="/products/{{$products[$i]->id}}" class="text-light">View Detail</a>
          </button>
        </div>
        @endif
      @endfor
  </div>
</div>

{{-- others --}}
<div class="container">
<h5 class="card-title text-center m-3 p-3 ">Others </h5>

  <div class="row m-3 border border-dark justify-content-center" id="other">
    @for ($i = 0; $i < count($products); $i++) 
      @if($products[$i]->p_cat != "man's clothes" && $products[$i]->p_cat != "women's clothes" && $products[$i]->p_cat != "kids clothes" )
        <div class="col-sm-3 border border-primary m-3 " style="background-color:#F5EAF5;">
          <img class="img" src="/storage/productImage/{{$products[$i]->image}}" alt="Medusa" style="width: 200px; height:250px;">
          <h6>Price Rs. {{$products[$i]->p_price}} </h6>
          <h6>{{$products[$i]->p_cat}}</h6>
          <button type="button" class="btn btn-primary ">
            <a href="/products/{{$products[$i]->id}}" class="text-light">Add to card</a>
          </button>          
          <button type="button" class="btn btn-primary">
            <a href="/products/{{$products[$i]->id}}" class="text-light">View Detail</a>
          </button>
        </div>
        @endif
      @endfor
  </div>
</div>
@endif

<hr>
{{-- End of content --}}
<div style="height: 400px;">

</div>
@endsection