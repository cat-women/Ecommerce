@extends('front.layout')
@section('content')


<div class="container">
    <div class="main-body">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">User Profile</li>
            </ol>
        </nav>
        <!-- /Breadcrumb -->

        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
                            <div class="mt-3">
                                <h4>{{auth()->user()->name}}</h4>
                                <p class="text-secondary mb-1">{{auth()->user()->address}}</p>
                                <button class="btn btn-primary">Follow</button>
                                <button class="btn btn-outline-primary">Message</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{auth()->user()->name}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{auth()->user()->email}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Phone</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{auth()->user()->phone_no}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Address</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{auth()->user()->address}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"> Edit </button>
                            </div>


                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit your Profile </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="name" class="form-control" id="name" value="{{auth()->user()->name}}" aria-describedby="emailHelp">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email address</label>
                                                    <input type="email" class="form-control" id="email" value="{{auth()->user()->email}}" aria-describedby="emailHelp">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input type="password" class="form-control" id="pwd" id="password">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Phone Number</label>
                                                    <input type="text" class="form-control" id="phone" value="{{auth()->user()->phone_no }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Address</label>
                                                    <input type="text" class="form-control" id="address" value="{{auth()->user()->address }}">
                                                </div>
                                               
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="savechange" value="{{auth()->user()->id }}">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end of modal -->

                        </div>
                    </div>
                </div>

            </div>

            <div class="col-sm-6 mb-3">
                <button type="button" class="btn btn-primary" id="cart_view">
                    <a href="/carts#carts" class="text-light"> Carts </a>
                </button>
            </div>

            <div class="col-sm-6 mb-3">
                <button class="btn btn-primary">
                    <a href="/carts#orderviewbody" class="text-light" id="orderview"> View Summary </a> </button>
            </div>

            {{-- carts view --}}
            <table class="table table-striped table-hover m-3 p-3" id="carts">
                <div class="row mt-3">
                    <div class="col-6">
                        <legend class="">Cart </legend>
                    </div>
                    <div class="col-6  justify-content-right">
                        <div class="input-group ">
                            <input type="text" class="form-control" placeholder="Search By Name" aria-label="Search By Name" aria-describedby="button-addon2" name="searchId" id="searchId">
                            <button class="btn btn-outline-primary" type="button" id="search">Search</button>
                        </div>
                    </div>
                </div>
                <thead>

                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody id="cartsbody">

                    @foreach($data as $index=>$item)
                    <tr>
                        <th scope="row">{{$index+1}}</th>
                        <td>{{ $item->p_name}}</td>
                        <td> {{ $item->quantity }}</td>
                        <td> {{ $item->p_price }}</td>
                        <td>
                            <button>
                                <a href="carts/{{ $item->id}}">Delete</a>
                            </button>
                        </td>
                        <td>
                            <button>
                                <a href="orders/{{ $item->id}}">Buy Now</a>
                            </button>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            <div class="d-flex justify-content-right">
                <a href="carts/clear">
                    <button class="btn btn-danger">clear cart</button>
                </a>
            </div>
            <hr class="m-3">
            {{-- orders view --}}
            {{--
            <table class="table table-striped table-hover m-3" id="orders">
            <div class="row mt-3">
                    <div class="col-6">
                        <legend class="">Orders </legend>
                    </div>
                    <div class="col-6  justify-content-right">
                        <div class="input-group ">
                            <input type="text" class="form-control" placeholder="Search By Name" aria-label="Search By Name" aria-describedby="button-addon2" name="searchOr" id="searchOr">
                            <button class="btn btn-outline-primary" type="button" id="search">Search</button>
                        </div>
                    </div>
                </div>                
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody class="ordersbody">
                   
                    @foreach( $data as $index=> $item)
                    <tr>
                        <th scope="row">{{$index+1}}</th>
            <td>{{ $item->p_name}}</td>
            <td> {{ $item->quantity }}</td>
            <td> {{ $item->p_price }}</td>
            <td>
                <button>
                    <a href="carts/{{ $item->id}}">Delete</a>
                </button>
            </td>
            <td>
                <button>
                    <a href="orders/{{ $item->pro_id}}">Buy Now</a>
                </button>
            </td>
            </tr>
            @endforeach
            --}}
            </tbody>


            </table>

            <div id="orderviewbody">

            </div>
        </div>
    </div>

    <div style="height: 400px;">

    </div>

    {{-- To show cart list --}}
    <script>
        // carts search 
        $(document).ready(function() {
            $('#searchId').on('keyup', function() {
                var query = $(this).val();
                $.ajax({
                    url: "{{ route('cart.search') }}",
                    method: 'GET',
                    data: {
                        query: query
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#cartsbody').html(data.table_data);
                        console.log(data.total_data);
                    },
                    error: function(x, y, z) {
                        alertify.error(genericErrorMessage);
                        //alert('error ako chha ')
                    }
                });
            });
        });


        // order table 

        $(document).ready(function() {
            $('#orderview').on('click', function() {
                $check = $('#orders').length;
                if ($check == 0) {
                    $html = `
                    <table class="table table-striped table-hover m-3" id="orders">
                    <div class="row mt-3">
                        <div class="col-6">
                            <legend class="">Orders </legend>
                        </div>
                        <div class="col-6  justify-content-right">
                            <div class="input-group ">
                                <input type="text" class="form-control" placeholder="Search By Name" name="input_search" id="input_search">
                                <button class="btn btn-outline-primary" type="button" id="search" onclick="showOrder()">Search</button>
                            </div>
                        </div>
                    </div>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Action</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody class="ordersbody">
                        <tr>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                    `;
                    $('#orderviewbody').append($html);
                }

                var query = $('#input_search').val();
                $.ajax({
                    url: "{{ route('order.search') }}",
                    method: 'GET',
                    data: {
                        query: query
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('.ordersbody').html(data.table_data);
                        //console.log(data.total_data);
                    },
                    error: function(x, y, z) {
                        alertify.error(genericErrorMessage);
                    }
                });
            });
        });


        // order table 

        function showOrder() {
            var query = $('#input_search').val();
            $.ajax({
                url: "{{ route('order.search') }}",
                method: 'GET',
                data: {
                    query: query
                },
                dataType: 'json',
                success: function(data) {
                    $('.ordersbody').html(data.table_data);
                    //console.log(data.total_data);
                },
                error: function(x, y, z) {
                    alertify.error(genericErrorMessage);
                }
            });
        }

                //Edit user data
                $(document).on("click", "#savechange", function() {
                    id = $(this).val();
                    var url = "../carts/updateUser/" + id;
                    $.ajax({
                        url: url,
                        type: "POST",
                        cache: false,
                        data: {
                            _token: '{{ csrf_token() }}',
                            
                            name: $('#name').val(),
                            email: $('#email').val(),
                            phone: $('#phone').val(),
                            pwd: $('#pwd').val(),
                            address: $('#address').val()
                            
                        },
                        success: function(dataResult) {

                            dataResult = JSON.parse(dataResult);
                            if (dataResult.statusCode) {
                                alert('Data updated successfully');
                                window.location = "/carts";
                            } else {
                                alert("Internal Server Error");
                            }

                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                            alert(error);
                        }
                    });
                });

                
    </script>


    @endsection