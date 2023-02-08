<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.3/css/bootstrap.min.css" integrity="sha512-SbiR/eusphKoMVVXysTKG/7VseWii+Y3FdHrt0EpKgpToZeemhqHeZeLWLhJutz/2ut2Vw1uQEj2MbRF+TVBUA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="container mt-4">
            <form method="POST" id="form" action="{{route('products.save')}}">
                <h3>Add Product</h3>
               @csrf
               <div class="row">
                    <div class="col-md-12 col-sm-12 mb-2">
                       <input type="text" name="name" class="form-control" placeholder="Product name" />
                    </div>
                    <div class="col-md-12 col-sm-12 mb-2">
                        <input type="number" name="qty" class="form-control" placeholder="Product Qty" />
                    </div>
                    <div class="col-md-12 col-sm-12 mb-2">
                       <input type="number" name="price" class="form-control" placeholder="Price" />
                    </div>
                    <div class="col-md-12 col-sm-12 mb-2">
                        <button id="addBtn" type="submit" class="btn btn-primary" value="Add" >
                            <i class="fa fa-spinner fa-spin" style="display:none"></i>
                            Add
                        </button>
                    </div>
                    
               </div>
            </form>
            <form method="POST" id="editForm" action="{{route('products.update')}}" style="display:none">
               @csrf
               <h3>Edit Product</h3>

               <input type="hidden" id="index" name="index"/>

               <div class="row">
                    <div class="col-md-12 col-sm-12 mb-2">
                       <input type="text" id="name" name="name" class="form-control" placeholder="Product name" />
                    </div>
                    <div class="col-md-12 col-sm-12 mb-2">
                        <input type="number" id="qty" name="qty" class="form-control" placeholder="Product Qty" />
                    </div>
                    <div class="col-md-12 col-sm-12 mb-2">
                       <input type="number" id="price" name="price" class="form-control" placeholder="Price" />
                    </div>
                    <div class="col-md-12 col-sm-12 mb-2">
                        <button type="submit" class="btn btn-primary" id="editBtn">
                            <i class="fa fa-spinner fa-spin" style="display:none"></i>
                            Save
                        </button>
                        <input id="cancel" type="button" class="btn btn-primary" value="Cancel" />
                    </div>
                    
               </div>
            </form>
           <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th scope="col">Name</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Price</th>
                        <th scope="col">Submitted At</th>
                        <th scope="col">Total Value</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody id="product-list">
                       
                    </tbody>
                </table>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.3/js/bootstrap.min.js" integrity="sha512-1/RvZTcCDEUjY/CypiMz+iqqtaoQfAITmNSJY17Myp4Ms5mdxPS5UV7iOfdZoxcGhzFbOm6sntTKJppjvuhg4g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(document).ready(function() {
                var allProducts = ""
                function showProduct(data)
                {
                    products = "";
                    total = 0;
                    allProducts= data.products;
                    data.products.forEach( (product,index) => {
                        var item = `<tr>
                            <td>${product.name}</td>
                            <td>${product.qty}</td>
                            <td>${product.price}</td>
                            <td>${new Date(Date.parse(product.submitted_at))}</td>
                            <td>${product.total_value}</td>
                            <td><a href="#!" index="${index}" >Edit</a></td>
                        </tr>`;
                        products+=item;
                        total+=product.total_value;
                       });
                       var totalRow = `<tr>
                            <td>Total:</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>${total}</td>

                        </tr>`;
                        products+=totalRow;
                       $('#product-list').html(products);
                }

                $.get( "{{route('products.load')}}")
                    .done(function( data ) {
                        showProduct(data);
                    }
                );

                $("#form").on('submit', (function(e) {
                    e.preventDefault();
                    $('#addBtn>i').show();
                    $.ajax({
                        url: $(this).attr('action'),
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(response) {
                            $("#form").trigger("reset");
                            showProduct(response);
                            $('#addBtn>i').hide();

                             // to reset form input fields
                        },
                        error: function(e) {
                            console.log(e);
                        }
                    });
                }));

                $("#editForm").on('submit', (function(e) {
                    e.preventDefault();
                    $('#editBtn>i').show();

                    $.ajax({
                        url: $(this).attr('action'),
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(response) {
                            $("#editForm").trigger("reset");
                            $('#editForm').hide();
                            $('#form').show();
                            showProduct(response);
                            $('#editBtn>i').hide();

                             // to reset form input fields
                        },
                        error: function(e) {
                            console.log(e);
                        }
                    });
                }));

                $('#product-list').on('click', "tr>td>a",function(){
                    $('#form').hide();
                    $('#editForm').show();
                    var index = $(this).attr("index");
                    var product = allProducts[index];
                    $('#name').val(product.name);
                    $('#qty').val(product.qty);
                    $('#price').val(product.price);
                    $('#index').val(index);
                    
                });

                $('#cancel').on('click', function(){
                    $("#editForm").trigger("reset");
                    $('#editForm').hide();
                    $('#form').show();

                })


            });
        </script>
    </body>
</html>
