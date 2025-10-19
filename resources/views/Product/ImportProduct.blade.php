
@extends('admin_dashboard')
@section('admin')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>


                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">

              <a href="{{ route('download.export')}}"> <button type="button" class="btn btn-primary rounded-pill waves-effect waves-light me-2">Download Xlsx </button></a>   
               <a href="{{ route('product.template')}}"> <button type="button" class="btn btn-info rounded-pill waves-effect waves-light">Download Excel Template </button></a>   

                                        </ol> 
                                    </div>
                                    
                                    <h4 class="page-title">Import Product</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->


  <div class="row">

                        <div class="col-lg-8 col-xl-12">
                                <div class="card">
                                    <div class="card-body">
    
                                            <div class="tab-pane" id="settings">



                                                <form id="myForm" method="POST" action="{{ route('download.import')}}" enctype="multipart/form-data">
                                                  @csrf

                                                    <div class="row">
                                                        <div class="col-md-12">

                                                            <div class="form-group mb-3">
                                                                <label for="name" class="">Xlsx file Import</label>
                                                                <input type="file" name="import" class="form-control @error('import') is-invalid @enderror" id="import" placeholder="Enter Import File">
                                                        
                                                                @error('import')
                                                          <span class="text-danger"> {{ $message }} </span>
                                                          @enderror 
                                                            </div>
                                                        </div>



                                                    </div> <!-- end row -->
    

                                                    <div class="text-end">
                                                        <button type="submit" name="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Upload </button>
                                                    </div>
                                                    
                                                </form>
                                            </div>
                                            <!-- end settings content-->
    
                                    </div>
                                </div> <!-- end card-->

                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

                    </div> <!-- container -->

                </div> <!-- content -->








                  <script type="text/javascript">
                    
                    $(document).ready(function(){
                      $('#image').change(function(e){
                        var reader = new FileReader();
                        reader.onload =  function(e){
                          $('#showImage').attr('src',e.target.result);
                        }
                        reader.readAsDataURL(e.target.files['0']);
                      });
                    });

                  </script>
                            

<script type="text/javascript">
$(document).ready(function (){
$('#myForm').validate({
rules: {
import: {
required : true,
},
},
messages :{
product_name: {
required : 'Please Enter Import File',
},

  },
        errorElement : 'span',
        errorPlacement: function (error,element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight : function(element, errorClass, validClass){
            $(element).addClass('is-invalid');
        },
        unhighlight : function(element, errorClass, validClass){
            $(element).removeClass('is-invalid');
        },
    });
});


</script>



@endsection