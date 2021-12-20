@extends('dashboard.header')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />

<h1>Product table </h1>
<div class="row text-white">
    <div class="col">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.N</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Category</th>
                    <th scope="col">Availability</th>
                    <th scope="col">Image</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $index => $product)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $product->p_name}}</td>
                    <td>{{ $product->p_price}}</td>
                    <td> {{ $product->p_cat}} </td>

                    <td>
                        @if( $product->is_avail ) Yes @else No @endif
                    </td>
                    <td>
                        <img class="img" src="/storage/productImage/{{$product->image}}" alt="Medusa" style="width:20%; height:40%;  border-radius: 8px;">
                    </td>
                    <td>
                        <button class="btn btn-secondary m-3" value="{{ $product->id }}" id="product_edit">Edit</button>
                    </td>
                    <td>
                        <button class="btn btn-danger m-3" value="{{ $product->id }}" id="product_delete">Delete</button>
                    </td>
                    <input hidden value="{{ $product->id }}" id="idvalue">
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


{{-- Modal for edit --}}
<div class="modal" tabindex="-1" id="getCodeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  text-dark">Edit User Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-dark" id="getCode">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="savechange">Save changes</button>
            </div>
        </div>
    </div>
</div>



<script>
    $('body').on("click", "button[id=product_edit]", function() {
        id = $(this).attr("value");
        //alert(id);
        url = "../products/" + id + "/edit";
        //alert(url);
        $.ajax({
            url: url,

            type: "GET",
            data: {
                _token: '{{ csrf_token() }}'
            },
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                console.log(dataResult);
                //alert(dataResult.p_tag);
                imagesrc = '../storage/productImage/' + dataResult.image;

                bodydata = `
                <form method="PUT" enctype="multipart/form-data" id="updateForm" class="ajax">
                    @csrf

                    <input type='number' hidden value="` + dataResult.id + `" id="inputId" name="id">

                    <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="name" value="` + dataResult.p_name + `">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="desc" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                            <textarea  class="form-control" id="desc" name="desc" > ` + dataResult.p_desc + `</textarea>                            
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="price" class="col-sm-2 col-form-label">Price</label>
                            <div class="col-sm-10">
                            <input type="number"  class="form-control" name="price" id="price" value="` + dataResult.p_price + `" > 
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cat" class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                            <input type="text"  class="form-control" name="cat" id="cat" value="` + dataResult.p_cat + `" > 
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="image" class="col-sm-2 col-form-label">Image</label>
                            {{--
                            <img class="img m-3" src="` + imagesrc + `" alt="Medusa" style="width:50%; height:70%;  border-radius: 8px;">
--}}
                            <div class="col-sm-10">
                            <input class="form-control" type="file" id="image" name="image" accept="image/*" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-sm-2 col-form-label">Available</label>
                            <div class="col-sm-10">
                                <label class="switch">
                                <input type="checkbox" name="isAvail" id="isAvail" checked>
                                <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </form>
                    `;
                $("#getCodeModal").modal('show');
                $("#getCode").html(bodydata);

                //$('#bodydata').append(bodydata);

            },
            error: function(xhr, status, error) {
                console.log(error);
                alert(error);
            }
        });

    });

    //save ajax

    $(document).on("click", "#savechange", function() {
        id = $('#inputId').val();
        //alert(id)
        var url = "../products/" + id;
        var formData = $('form.ajax'),
            data = {};

        formData.find('[name]').each(function(index, val) {
            name = formData.attr('name');
            val = formData.val();
            data[name] = val;
        });
        data['_token',"{{ csrf_token() }}"];


        console.log(data);


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            method: 'put',
            url: url,
            data: data,
            dataType: 'json',
            success: function(dataResult) {

                dataResult = JSON.parse(dataResult);
                alert('Data updated successfully');
                window.location = "/dashboard/product";
                /*
                                if (dataResult.statusCode) {
                                    alert('Data updated successfully');
                                    window.location = "/dashboard/product";
                                } else {
                                    alert("Internal Server Error");
                                }



                                {

                _token: '{{ csrf_token() }}',
                name: $('#name').val(),
                desc: $('#desc').val(),
                price: $('#price').val(),
                cat: $('#cat').val(),
                isAvail: $('#isAvail').val(),
                image: $('#image').val()



            },
                */
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert(xhr.responseText);
                alert(error);
            }
        });
    });

    //delete
    /*
        $(document).on("click", "#deleteBtn", function() {
            var id = $(this).val();
            var Val = confirm("Do you want to continue ?");
            if (Val == true) {
                var url = "../admin/user/delete/" + id;
                $.ajax({
                    url: url,
                    type: "delete",
                    cache: false,
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(dataResult) {
                        var dataResult = JSON.parse(dataResult);
                        if (dataResult.statusCode == 200) {
                            alert('A user is deleted successfully');
                            location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                        alert(error);
                    }
                });
            }
            else{
                return false;
            }
        });


        */
</script>


@endsection