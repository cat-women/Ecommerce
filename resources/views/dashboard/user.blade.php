@extends('dashboard.header')
@section('content')
<h1>User table </h1>
<div class="row text-white">
    <div class="col">
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

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.N</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Address</th>
                    <th scope="col">Role</th>
                    <th scope="col"> Action</th>

                </tr>
            </thead>
            <tbody>

                @foreach($users as $index => $user)
                <tr>
                    <th scope="row"> {{ $index+1 }} </th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone_no }}</td>
                    <td>{{ $user->address}}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <button class="btn btn-secondary" id="editBtn" value="{{ $user->id }}">
                            Edit
                        </button>
                        <button class="btn btn-danger" id="deleteBtn" value="{{ $user->id }}">
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $('body').on("click", "button[id=editBtn]", function() {
        id = $(this).attr("value");
        //alert(id);
        url = "../admin/user/edit/" + id;
        $.ajax({
            url: url,

            type: "POST",
            data: {
                _token: '{{ csrf_token() }}'
            },
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                console.log(dataResult);

                bodydata = `
                    <form>
                    @csrf

                    <input type='number' hidden value="` + dataResult.id + `" id="inputId">

                    <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="name" value="` + dataResult.name + `">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                            <input type="text"  class="form-control" id="email" name="email" value="` + dataResult.email + `" > 
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="phone" class="col-sm-2 col-form-label">Phone No.</label>
                            <div class="col-sm-10">
                            <input type="text"  class="form-control" name="phone" id="phone" value="` + dataResult.phone_no + `" > 
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="address" class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-10">
                            <input type="text"  class="form-control" name="address" id="address" value="` + dataResult.address + `" > 
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="role" class="col-sm-2 col-form-label">Role</label>
                            <div class="col-sm-10">
                            <input type="text"  class="form-control" name="role" id="role" value="` + dataResult.role + `" > 
                            </div>
                        </div>
                    </form>
                    `;
                $("#getCodeModal").modal('show');
                $("#getCode").html(bodydata);

                //$('#bodydata').append(bodydata);
            }
        });

    });

    //save ajax
    $(document).on("click", "#savechange", function() {
        id = $('#inputId').val();
        var url = "../admin/user/update/" + id;
        $.ajax({
            url: url,
            type: "POST",
            cache: false,
            data: {
                _token: '{{ csrf_token() }}',
                name: $('#name').val(),
                email: $('#email').val(),
                phone: $('#phone').val(),
                role: $('#role').val(),
                address: $('#address').val()
            },
            success: function(dataResult) {

                dataResult = JSON.parse(dataResult);
                if (dataResult.statusCode) {
                    alert('Data updated successfully');
                    window.location = "/dashboard/user";
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

    //delete

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
</script>

@endsection

