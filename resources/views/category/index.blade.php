<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Category</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>

    <!-- Modal -->
    
    <div class="modal fade" id="addcategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <form id="addcategoryform" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
            <ul class="alert alert-warning d-none" id="error_list"></ul>
            <div class="form-group mt-3">
                <label>Category Name</label>
                <input type="text" name="category_name" class="form-control">
            </div> 

            <div class="form-group mt-3">
                <label>Category Image</label>
                <input type="file" name="category_image" class="form-control">
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
                       <h4>Category
                        <a class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addcategory" href="">Add Category</a>
                       </h4>
                   </div>
                   <div class="card-body">
                       <div class="table-responsive">
                           
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


    $(document).ready(function () {
        $(document).on('submit','#addcategoryform',function (e) {
            e.preventDefault();


            let formData = new FormData($('#addcategoryform')[0]);

            $.ajax({
                type: 'POST',
                url: '/add/category',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status == 400) {
                        $('#error_list').html('');
                        $('#error_list').removeClass('d-none');
                        $.each(response.errors,function (key, val) {
                           $('#error_list').append('<li>'+val+'<li/>')
                        })

                    }

                    $('#addcategoryform').find('input').val('');
                    $('#addcategory').modal('hide');

                    alert(response.message);
                }




            });
        });
    })
</script>







</body>
</html>