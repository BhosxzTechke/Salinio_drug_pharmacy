@extends('Ecommerce.Layout.ecommerce')

@section('content')

<!-- Alpine (needed) -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


<div class="min-h-screen bg-base-200 p-6 flex justify-center">
  <div class="w-full max-w-5xl">
    <!-- Profile Header -->
    <div class="card bg-base-100 shadow-xl mb-6">
      <div class="card-body flex flex-col md:flex-row items-center gap-6">



          <div class="card-body space-y-4">


            

    <form method="POST" action="{{ route('update.customer.profile')}}" enctype="multipart/form-data" >
      @csrf
      @method('PUT')


              <input type="hidden" name="id"  value="{{ Auth::guard('customer')->user()->id }}">
            <div>
              <label class="label">Name</label>
              <input type="text" name="name" value="{{ Auth::guard('customer')->user()->name }}" class="input input-bordered w-full" />
            </div>
            <div>
              <label class="label">Email</label>
              <input type="email" name="email" value="{{ Auth::guard('customer')->user()->email }}" class="input input-bordered w-full" />
            </div>
            <div>
              <label class="label">Phone</label>
              <input type="tel" name="tel" value="{{ Auth::guard('customer')->user()->phone }}" class="input input-bordered w-full" />
            </div>


            
            {{--  DRAG AND DROP FILE IMAGE  --}}

<div class="mb-6" x-data="imageUploader()" x-cloak>
  <label class="block text-sm font-medium text-gray-700 mb-2">Customer Image</label>

  <div
    class="flex items-center justify-center w-full"
    x-on:dragover.prevent="dragging = true"
    x-on:dragleave.prevent="dragging = false"
    x-on:drop.prevent="handleDrop($event)"
  >
    <label
      for="image"
      class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed rounded-xl cursor-pointer transition p-4"
      :class="dragging ? 'border-indigo-400 bg-indigo-50' : 'border-gray-300 bg-gray-50 hover:bg-gray-100'"
    >
      <div class="flex flex-col items-center justify-center">
        <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M7 16V4m0 0l-4 4m4-4l4 4m6 4h4M3 16h18M4 20h16" />
        </svg>
        <p class="mb-2 text-sm text-gray-500">
          <span class="font-semibold">Click to upload</span> or drag & drop
        </p>
        <p class="text-xs text-gray-400">PNG, JPG, JPEG (max 2MB)</p>
      </div>
      <input
        id="image"
        name="image"
        type="file"
        class="hidden"
        accept="image/*"
        x-ref="fileInput"
        x-on:change="previewFile($event)"
      >
    </label>
  </div>

  <!-- Preview -->
  <div x-show="previewUrl" class="mt-4">
    <img :src="previewUrl" alt="Preview" class="max-h-48 rounded-lg shadow-md">
    <button type="button" class="mt-2 px-3 py-1 rounded bg-gray-200" x-on:click="clear()">Remove</button>
  </div>
</div>






            <button class="btn btn-primary mt-4 w-full md:w-auto">Update Changes</button>


                 </form>
          </div>


     
          




      </div>
    </div>




    </div>
  </div>
</div>





<script>
function imageUploader() {
  return {
    dragging: false,
    previewUrl: null,
    objectUrl: null,

    previewFile(event) {
      const file = event.target.files[0];
      this.setPreview(file);
    },

    handleDrop(event) {
      this.dragging = false;
      const file = event.dataTransfer.files[0];
      if (!file) return;

      // put file into hidden input so form submission works
      const dt = new DataTransfer();
      dt.items.add(file);
      this.$refs.fileInput.files = dt.files;

      this.setPreview(file);
    },

    setPreview(file) {
      if (this.objectUrl) URL.revokeObjectURL(this.objectUrl);
      if (!file) {
        this.previewUrl = null;
        return;
      }
      this.objectUrl = URL.createObjectURL(file);
      this.previewUrl = this.objectUrl;
    },

    clear() {
      if (this.objectUrl) URL.revokeObjectURL(this.objectUrl);
      this.previewUrl = null;
      this.$refs.fileInput.value = '';
    }
  }
}
</script>


@endsection