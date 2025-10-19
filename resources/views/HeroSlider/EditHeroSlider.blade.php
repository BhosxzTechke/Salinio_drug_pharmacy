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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Profile</li>
                                        </ol>
                                    </div>
                                    
                                    <h4 class="page-title">Profile</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->


  <div class="row">

                        <div class="col-lg-8 col-xl-12">
                                <div class="card">
                                    <div class="card-body">
    
                                            <div class="tab-pane" id="settings">



<form method="POST" action="{{ route('update.heroslider')}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

        <input type="hidden" name="id" value="{{ $editData->id }}">

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="title">Title</label>
            <input type="text" name="title" value="{{ $editData->title }}" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Enter title">
            @error('title')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="subtitle">Subtitle</label>
            <input type="text" name="subtitle" value="{{ $editData->subtitle }}"  class="form-control @error('subtitle') is-invalid @enderror" id="subtitle" placeholder="Enter subtitle">
            @error('subtitle')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="link">Link</label>
            <input type="url" name="link" value="{{ $editData->link }}" class="form-control @error('link') is-invalid @enderror" id="link" placeholder="Enter link">
            @error('link')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>


        @php
            $totalSlides = \App\Models\HeroSlider::count();
        @endphp

        <div class="col-md-6 mb-3">
            <label for="position">Position</label>
            <input type="number" value="{{ $editData->position }}"  name="position" class="form-control @error('position') is-invalid @enderror" 
                id="position" placeholder="Enter position" min="0" max="{{ $totalSlides }}">
            <small class="text-muted">Enter a number between 0 and {{ $totalSlides }} (0 = first slide)</small>
            @error('position')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>




<div class="col-md-6 mb-3">
    <label for="is_active">Active</label>
    <select name="is_active" value="{{ $editData->is_active }}"  id="is_active" class="form-control @error('is_active') is-invalid @enderror">
        <option value="1" selected>Yes</option>
        <option value="0">No</option>
    </select>
    @error('is_active')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>




        <div class="col-md-6 mb-3">
            <label for="image" class="form-label">Hero Image</label>
            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
            @error('image')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

<div class="col-md-12 mb-3 d-flex align-items-start">
    <div class="me-3">
        <img id="showImage" 
             src="{{ !empty($editData->image) ? asset($editData->image) : asset('uploads/noimage.png') }}" 
             class="img-fluid rounded shadow-lg" 
             style="max-width: 300px; height: auto;" 
             alt="Hero Image Preview">
    </div>
    <div class="flex-grow-1">
        <!-- You can add text, form fields, or instructions here next to the image -->
    </div>
</div>



    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-success waves-effect waves-light mt-2">
            <i class="mdi mdi-content-save"></i> Save Changes
        </button>
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
                            




@endsection