@extends('Ecommerce.Layout.ecommerce')

@section('content')


<br><br>


<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
  href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
  rel="stylesheet"
/>

<style>
  .body {
    font-family: "Plus Jakarta Sans", sans-serif;
  }
</style>

<div class="relative w-full h-screen">
  <iframe
    class="top-0 left-0 w-full md:absolute h-1/2 md:h-full"
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3711.5626750659862!2d121.04740244306522!3d14.516851918477837!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397cf34a5fbf4b5%3A0x89bb9c10fe82bfc3!2sSalinio%20Drug%20and%20General%20Merchandise!5e1!3m2!1sen!2sph!4v1761389129904!5m2!1sen!2sph" 
    frameborder="0"
    style="border: 0"
    allowfullscreen=""
    aria-hidden="false"
    tabindex="0"
  >

  
  </iframe>
  <div
    class="flex flex-col items-end justify-start mt-4 md:flex-row md:justify-around md:pt-32 md:mt-0"
  >
    <div
      class="relative flex-wrap hidden py-2 m-1 bg-slate-200  rounded shadow-md md:flex"
    >
      <div class="px-3">
        <img
          src="{{ url('uploads/salinio.png') }}"
          alt=""
        />
        <p class="mt-1 font-medium">Salinio Drug, Taguig, Metro Manila, Philippines</p>
      </div>
    </div>



    <div class="container flex px-5 mx-auto md:py-8">
      <div
        class="relative z-10 flex flex-col w-full p-8 mt-10 bg-white rounded-lg shadow-md md:w-1/2 md:ml-auto md:mt-0"
      >
        <h2 class="mb-1 text-lg font-medium text-gray-900 title-font">
          Contact Us
        </h2>

        <div class="relative mb-4">
          <label for="email" class="text-sm leading-7 text-gray-600"
            >Email</label
          >
          <input
            type="email"
            id="email"
            name="email"
            class="w-full px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-white border border-gray-300 rounded outline-none focus:border-red-500 focus:ring-2 focus:ring-red-200"
          />
        </div>
        <div class="relative mb-4">
          <label for="message" class="text-sm leading-7 text-gray-600"
            >Message</label
          >
          <textarea
            id="message"
            name="message"
            class="w-full h-32 px-3 py-1 text-base leading-6 text-gray-700 transition-colors duration-200 ease-in-out bg-white border border-gray-300 rounded outline-none resize-none focus:border-red-500 focus:ring-2 focus:ring-red-200"
          ></textarea>
        </div>
        <button
          class="px-6 py-2 text-lg text-white bg-red-500 border-0 rounded focus:outline-none hover:bg-red-600"
        >
          Send
        </button>
      </div>
    </div>
  </div>
</div>

{{-- 
<section class="bg-white dark:bg-gray-900">

    



<div class="max-w-4xl mx-auto flex flex-col md:flex-row items-center justify-center gap-8 px-4 md:px-0 py-10">


  <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
      <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">Contact Us</h2>
      <p class="mb-8 lg:mb-16 font-light text-center text-gray-500 dark:text-gray-400 sm:text-xl">Got a technical issue? Want to send feedback about a beta feature? Need details about our Business plan? Let us know.</p>
      <form action="{{ route('contact.submit') }}" method="POST" class="space-y-8">
        @csrf
          <div>
              <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Your email</label>
              <input type="email" id="email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light" placeholder="name@flowbite.com" required>
          </div>
          <div>
              <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Subject</label>
              <input type="text" id="subject" class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light" placeholder="Let us know how we can help you" required>
          </div>
          <div class="sm:col-span-2">
              <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Your message</label>
              <textarea id="message" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Leave a comment..."></textarea>
          </div>

<div class="flex justify-center overflow-hidden bg-white/20 p-0.5 h-9 w-20 rounded-md active:scale-100 hover:scale-105 transition-all duration-300">
    <button class="text-white text-sm bg-gradient-to-t from-black/50 to-black h-full w-full rounded">
        Submit
    </button>
</div>

</form>
</div>








</section>

 --}}





        {{--                 MAP                  --}}



@endsection