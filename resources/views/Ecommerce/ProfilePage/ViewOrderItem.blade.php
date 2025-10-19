@extends('Ecommerce.Layout.ecommerce')

@section('content')


<div class="min-h-screen bg-base-200 p-6 flex justify-center">
  <div class="w-full max-w-7xl">

    <!-- Header with Go Back and Search -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-4 space-y-2 md:space-y-0">
      <a href="{{ route('customer.profile') }}" onclick="history.back()" class="flex items-center text-gray-700 bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded-lg shadow-sm mb-2 md:mb-0">
        <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Go Back
    </a>

      <div class="relative flex items-center">
        <input id="searchInput" type="text" placeholder="Search for users"
          class="block w-80 ps-10 pr-20 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
        <svg class="absolute left-3 w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M9 17a7 7 0 1 1 0-14 7 7 0 0 1 0 14z"/>
        </svg>
        <button onclick="clearSearch()" 
          class="absolute right-1 top-1 px-3 py-1 text-sm bg-red-500 text-white rounded-lg hover:bg-red-600">Cancel</button>
      </div>
    </div>


    <!-- Action Dropdown -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-900 mb-4">
      <div class="flex items-center justify-start flex-wrap space-y-4 md:space-y-0 py-4 px-4 border-b border-gray-200 dark:border-gray-700">
        <div>
          <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction"
            class="inline-flex items-center text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
            Action
            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
          </button>


          <!-- Dropdown menu -->
          <div id="dropdownAction" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
              <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reward</a></li>
              <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Promote</a></li>
              <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Activate account</a></li>
            </ul>
            <div class="py-1">
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete User</a>
            </div>
          </div>
        </div>
      </div>



      <!-- Table -->
      <table id="userTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="p-4">
              <div class="flex items-center">
                <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
                <label for="checkbox-all-search" class="sr-only">checkbox</label>
              </div>
            </th>
            <th scope="col" class="px-6 py-3">Image</th>
            <th scope="col" class="px-6 py-3">Product Name</th>
            <th scope="col" class="px-6 py-3">Quantity</th>
            <th scope="col" class="px-6 py-3">Product Code</th>
            <th scope="col" class="px-6 py-3">Price</th>
            <th scope="col" class="px-6 py-3">Action</th>
          </tr>
        </thead>
        <tbody>


       
        @foreach ($order->orderdetails as $item)
                
          
          <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="w-4 p-4">
              <div class="flex items-center">
                <input type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
              </div>
            </td>
            <th scope="row" class="flex items-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
           
                <img class="w-10 h-10 rounded-full" src="{{ asset($item->product->product_image) }}" alt="Jese image">
            
  
            </th>


            <td class="px-6 py-4">{{ $item->product->product_name }}</td>

            <td class="px-6 py-4">{{ $item->quantity }}</td>



            <td class="px-6 py-4"></td>




            <td class="px-6 py-4">
              <div class="flex items-center">
                <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div> {{ $item->product->selling_price }}
              </div>
            </td>



            <td class="px-6 py-4">
              <a href="#" class="font-medium text-orange-600 dark:text-blue-500 hover:underline">Cancel Item</a>
            </td>
          </tr>


            @endforeach





        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  const searchInput = document.getElementById('searchInput');
  const table = document.getElementById('userTable').getElementsByTagName('tbody')[0];

  searchInput.addEventListener('input', function() {
    const filter = searchInput.value.toLowerCase();
    const rows = table.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
      const nameCell = rows[i].querySelector('th div div.text-base');
      const positionCell = rows[i].querySelector('td:nth-child(3)');
      const textValue = (nameCell?.textContent + ' ' + positionCell?.textContent).toLowerCase();

      rows[i].style.display = textValue.indexOf(filter) > -1 ? '' : 'none';
    }
  });

  function clearSearch() {
    searchInput.value = '';
    searchInput.dispatchEvent(new Event('input'));
  }
</script>




@endsection