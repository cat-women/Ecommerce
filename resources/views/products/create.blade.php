@extends('front.layout')
@section('content')
<style>
    form {
        width: fit-content;
        height: fit-content;
        align-self: center;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col border border-primary">
            <form method="POST" action="/products" enctype="multipart/form-data">
                @csrf
                <h1>Add new product</h1>

                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control-plaintext" id="name" name="name" placeholder="Name">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="description" class="col-sm-2 col-form-label">Description </label>
                    <div class="col-sm-10">
                        <input type="textarea" class="form-control-plaintext" id="description" name="description" placeholder="Describe this product in short ">
                    </div>

                    <div class="mb-3 row">
                        <label for="price" class="col-sm-2 col-form-label">Price</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control-plaintext" id="price" name="price" placeholder="Rs.400">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="cat" class="col-sm-2 col-form-label">Category</label>
                        <div class="col-sm-10">
                            <select class="custom-select" id="cat" name="cat">
                                <option selected value="">Choose...</option>
                                <option value="man's clothes">Man's clothes</option>
                                <option value="women's clothes ">Women's clothes</option>
                                <option value="kids clothes">Kids' clothes</option>
                                <option value="othes">Others</option>

                            </select>
                        </div>
                    </div>
                    {{--
                    <div class="mb-3 row">
                        <label for="tag" class="col-sm-2 col-form-label">Tag</label>
                        <div class="col-sm-10" id="tag_body">
                            <input type="text" class="form-control-plaintext" id="tag_input" name="tag_list[]" placeholder="tag">
                            <button type="button" class="btn btn-primary" id="add_tag">
                                <i class="glyphicon glyphicon-plus"></i> +
                            </button>
                            <ol class="list-group list-group-flush " id="taglist">
                                <li class="list-group-item" id="list">
                                </li>
                            </ol>
                        </div>
                    </div>
                    --}}

                    {{-- Tag list --}}
                    <div class="mb-3 row">
                        <label for="tag" class="col-sm-2 col-form-label">Tag</label>
                        <div class="col-sm-10" id="tagList">
                            @foreach(old('tags', isset($tag) ? $tag->tag : []) as $key => $item)                            
                                <input class="form-control" name="tagList[]" type="text" value="{{$item}}">                            
                            @endforeach
                            <button class="btn btn-link btn-sm addTag" type="button">+ Add</button>
                        </div>
                    </div>
                    {{--
                    <div class="row">
                        <label for="tag" class="col-sm-2 col-form-label">Tag</label>
                        <div class="tagList">
                            @foreach(old('tags', isset($tag) ? $tag->tag : []) as $key => $item)
                            <div class="form-group col-sm-2">
                                <input class="form-control" name="tagList[]" type="text" value="{{$item}}">
                            </div>
                            @endforeach
                        </div>
                        <div class="col-sm-12">
                            <button class="btn btn-link btn-sm addTag" type="button">+ Add</button>
                        </div>
                    </div>
                    --}}
                    <div class="mb-3 row">
                        <label for="image" class="col-sm-2 col-form-label">Upload a image</label>
                        <div class="col">
                            <input class="form-control" type="file" id="image" name="image" accept="image/*" onchange="loadFile(event)">
                        </div>
                        <div class="col-sm-2">
                            <span><img id="output" style="height: 250px; width: 200px;" /></span>

                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Is Available</label>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="isAvail" id="isAvail" value=1 checked>
                            <label class="form-check-label" for="true">
                                Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="isAvail" id="isAvail" value=0>
                            <label class="form-check-label" for="false">
                                No
                            </label>
                        </div>
                        <div class="form-check">
                            <button type="submit" class="btn btn-primary" value="submit">Submit</button>
                            <button type="button" class="btn btn-secondary" value="cancel">Cancel</button>

                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
<div style="height: 400px;">

</div>
<script>
    /*
    $(document).ready(function() {
        $('#add_tag').on('click', function() {
            var tagName = $('#tag_input').val();
            if (tagName != '') {
                var html = '<li><span>' + tagName;
                html += '<button type="button" class="btn btn-danger ml-3 mb-3" id="tag_remove"> <i class="glyphicon glyphicon-remove"></i> - </button>'
                html += '</span></li>'
                $('#list').append(html);
            } else {
                alert('Empty tag is not accepted');
            }

        });
    });

    $(document).on('click', '#tag_remove', function() {
        $(this).closest('li').remove();
    });
    */

    // Display image  
    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };


    //Tag list  
    $(document).ready(function() {
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button"); //Add button ID

        $('.addTag').click(function(e) { //on add input button click
            e.preventDefault();
            //add input box
            var template = '<div class="form-group col-sm-2">';
            template += '<span class="input-group-text" id="basic-addon1">';
            template += '<input class="form-control" name="tagList[]" type="text">';

            template += '<button type="button" class="btn btn-danger ml-3 mb-3" id="tag_remove"> <i class="glyphicon glyphicon-remove"></i> - </button> </span>';
            template += '</div>';
            $('#tagList').append(template);
        });
    });
    $(document).on('click', '#tag_remove', function() {
        $(this).closest('span').remove();
    });
</script>
@endsection