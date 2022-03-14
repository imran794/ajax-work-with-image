<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Brand</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>


  <!-- Modal -->
    
    <div class="modal fade" id="addbrand" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Brand</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <form id="addbrandform" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
            <ul class="alert alert-warning d-none" id="brand_error_list"></ul>
            <div class="form-group mt-3">
                <label>Brand Name</label>
                <input type="text" name="brand_name" class="form-control">
            </div> 

            <div class="form-group mt-3">
                <label>Brand Number</label>
                <input type="Number" name="brand_number" class="form-control">
            </div>
            <div class="form-group mt-3">
                <label>Brand Location</label>
                <input type="text" name="brand_location" class="form-control">
            </div><div class="form-group mt-3">
                <label>Brand Image</label>
                <input type="file" name="brand_image" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </div>
    </div>
    </form>   



    <!--Edit Modal -->
    
    <div class="modal fade" id="editbrand" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Brand</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <form id="addbrandform" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
            <ul class="alert alert-warning d-none" id="brand_error_list"></ul>
            <div class="form-group mt-3">
                <label>Brand Name</label>
                <input type="text" name="brand_name" id="edit_name" class="form-control">
            </div> 

            <div class="form-group mt-3">
                <label>Brand Number</label>
                <input type="Number" name="brand_number" id="edit_number" class="form-control">
            </div>
            <div class="form-group mt-3">
                <label>Brand Location</label>
                <input type="text" name="brand_location" id="edit_location" class="form-control">
            </div><div class="form-group mt-3">
                <label>Brand Image</label>
                <input type="file" name="brand_image" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </div>
    </div>
    </form> 



   <div style="margin-top: 50px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
               <div class="card">
                   <div class="card-header">
                       <h4>Brnad
                        <a class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addbrand" href="">Add Brand</a>
                       </h4>
                   </div>
                   <div class="card-body">
                       <div class="table-responsive">
                        <table class="table table-boadered">
                              <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Brand Name</th>
                                <th>Brand Number</th>
                                <th>Brand Location</th>
                                <th>Brand Image</th>
                                <th>Action</th>
                            </tr>
                           </thead>

                            <tbody>

                                
                          
                           </tbody>
                        </table>
                         
                       </div>
                   </div>
               </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('js/jquery-3.5.1.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>


<script>

     $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
     });


    function brandfetch(){

        $.ajax({
            type: 'GET',
            url: '/brand/fetch/data',
            datatype: 'json',
            success: function (response) {
                $('tbody').html('');
                $.each(response.brand, function (key, value) {
                    $('tbody').append('<tr>\
                                    <th>'+value.id+'</th>\
                                    <th>'+value.brand_name+'</th>\
                                    <th>'+value.brand_number+'</th>\
                                    <th>'+value.brand_location+'</th>\
                                    <th><img src="/uploads/brand/'+value.brand_image+'" width="50px;" height="50px;"></th>\
                                     <th class="">\
                                <button  class="btn btn-success edit_data" value="'+value.id+'">Edit</button>\
                                <button class="btn btn-danger delete_data" value="'+value.id+'">Delete</button>\
                            </th>\
                                </tr>');
                })
            }

        });
    }

    brandfetch();


     $(document).ready(function () {
         $(document).on('submit','#addbrandform',function (e) {
            e.preventDefault();

            let  formData = new FormData($('#addbrandform')[0]);

            $.ajax({

                type: 'POST',
                url: '/add/brand',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {

                    if (response.status == 400) {
                        $('#brand_error_list').html('');
                        $('#brand_error_list').removeClass('d-none');
                        $.each(response.errors,function (key, value) {
                            $('#brand_error_list').append('<li>'+value+'</li>')
                        })

                    }
                    else{
                        $('#addbrandform').find('input').val('');
                        $('#addbrand').modal('hide');
                        alert(response.messages);
                        brandfetch();

                    }
                }

            });


         });
     })


     $(document).on('click','.edit_data',function (e) {
         e.preventDefault();

         var edit_data = $(this).val();

         $('#editbrand').modal('show');

         $.ajax({
            type: 'GET',
            url: '/brand/edit/'+edit_data,
            success: function (response) {
                if (response.status == 404 ) {
                     $('#editbrand').modal('hide');
                 }else{
                    $('#edit_name').val(response.brand.brand_name);
                    $('#edit_number').val(response.brand.brand_number);
                    $('#edit_location').val(response.brand.brand_location);
                 }
            }
         });
     })







</script>


</body>
</html>