<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>


        <!-- Modal -->
    
    <div class="modal fade" id="addproduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <form id="addproductform" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
            <ul class="alert alert-warning d-none" id="product_error_list"></ul>
            <div class="form-group mt-3">
                <label>Brand Name</label>
              <select name="brand_id" id="" class="form-control">
                   <option value="">Select Brand Name</option>
                    @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                    @endforeach
               </select>
            </div>   

             <div class="form-group mt-3">
                <label>Category Name</label>
               <select name="category_id" id="" class="form-control">
                    <option value="">Select Category Name</option>
                   @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
               </select>
            </div> 
             <div class="form-group mt-3">
                <label>Product Name</label>
                <input type="text" name="product_name" class="form-control">
            </div>  

            <div class="form-group mt-3">
                <label>Product Price</label>
                <input type="text" name="product_price" class="form-control">
            </div> 

            <div class="form-group mt-3">
                <label>Product Qty</label>
                <input type="text" name="product_qty" class="form-control">
            </div> 
             <div class="form-group mt-3">
                <label>Product Description</label>
               <textarea name="product_description" class="form-control"></textarea>
            </div> 

            <div class="form-group mt-3">
                <label>Product Image</label>
                <input type="file" name="product_image" class="form-control">
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
                        <a class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addproduct" href="">Add Product</a>
                       </h4>
                   </div>
                   <div class="card-body">
                       <div class="table-responsive">
                        <table class="table table-boadered">
                              <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Category Name</th>
                                <th>Brand Name</th>
                                <th>Product Name</th>
                                <th>Product Price</th>
                                <th>Product Qty</th>
                                <th>Product Description</th>
                                <th>Product Image</th>
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



      function productfetch() {

      
        $.ajax({

            type: 'GET',
            url: '/product/fatch',
            dataType: 'json',
            success:function(response){
                $('tbody').html('');
                $.each(response.product,function (key, value) {
                    $('tbody').append('<tr>\
                                <th>'+value.id+'</th>\
                                <th>'+value.brand_id+'</th>\
                                <th>'+value.category_id+'</th>\
                                <th>'+value.product_name+'</th>\
                                <th>'+value.product_price+'</th>\
                                <th>'+value.product_qty+'</th>\
                                <th>'+value.product_description+'</th>\
                                <th><img src="/uploads/product/'+value.product_image+'" width="100px;" height="100px;" alt=""></th>\
                                <th>\
                                    <button type="submit" class="btn btn-primary btn_edit">Edit</button>\
                                    <button type="submit" class="btn btn-danger btn_delete">Delete</button>\
                                </th>\
                            </tr>');
                })

            }

          });
      }

      productfetch();

      $(document).ready(function () {
        $(document).on('submit','#addproductform',function (e) {
            e.preventDefault();

            let formData = new FormData($('#addproductform')[0]);

             console.log(formData);

            $.ajax({
                type: 'POST',
                url: '/add/product',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                   if (response.status == 400) {
                       $('#product_error_list').html('');
                       $('#product_error_list').removeClass('d-none');
                       $.each(response.errors,function (key, value) {
                           $('#product_error_list').append('<li>'+value+'</li>')
                       })
                   }
                   else{
                       $('#addproductform').find('input').val('');
                        $('#addproduct').modal('hide');
                        alert(response.messages);
                        productfetch();
                   }
                }
            });
        });
      })





</script>
