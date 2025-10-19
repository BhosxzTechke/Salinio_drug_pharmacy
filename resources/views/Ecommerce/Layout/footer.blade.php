    <footer class="relative z-10 bg-white pb-10 pt-20 lg:pb-20 lg:pt-[120px]">

        
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full sm:w-2/3 lg:w-3/12 px-4 mb-10">
                    


                    {{-- LOGO --}}
                    <a href="{{ url('/') }}" 
                    class="flex items-center gap-2 text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600 hover:scale-105 transition-transform duration-200">
                    <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                        <path d="M8 12l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                    @php $BusinessTitle = App\Models\BusinessTitle::find(1); @endphp
                    <span>{{ $BusinessTitle->business_name ?? 'Pharma' }}</span>
                    </a>



                    <p class="mb-7 text-base text-gray-700">
                        Your trusted pharmacy for health and wellness solutions.
                    </p>
                    <p class="flex items-center text-sm font-medium text-green-700">
                        <span class="mr-3 text-primary">
                            <!-- Phone SVG -->
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <!-- ...SVG paths... -->
                            </svg>
                        </span>
                        <span>+012 (345) 678 99</span>
                    </p>
                </div>
                <div class="w-1/2 sm:w-1/2 lg:w-2/12 px-4 mb-10">
                    <h4 class="mb-9 text-lg font-semibold text-green-900">
                        Pharmacy Services
                    </h4>
                    <ul class="space-y-3">
                        <li>
                            <p class="inline-block text-base leading-loose text-gray-700">
                                Prescription Refills
                            </p>
                        </li>
                        <li>
                            <p class="inline-block text-base leading-loose text-gray-700">
                                Health Consultations
                            </p>
                        </li>
                        <li>
                            <p class="inline-block text-base leading-loose text-gray-700 ">
                                Medication Delivery
                            </p>
                        </li>
                        <li>
                            <p class="inline-block text-base leading-loose text-gray-700 ">
                                Wellness Products
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="w-1/2 sm:w-1/2 lg:w-2/12 px-4 mb-10">
                    <h4 class="mb-9 text-lg font-semibold text-green-900">
                        Company
                    </h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('about.show') }}" class="inline-block text-base leading-loose text-gray-700 hover:text-green-600">
                                About Us
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact.show') }}" class="inline-block text-base leading-loose text-gray-700 hover:text-green-600">
                                Contact & Support
                            </a>
                        </li>
                        {{-- <li>
                            <a href="javascript:void(0)" class="inline-block text-base leading-loose text-gray-700 hover:text-green-600">
                                Careers
                            </a>
                        </li> --}}
                        <li>
                            <a href="javascript:void(0)" class="inline-block text-base leading-loose text-gray-700 hover:text-green-600">
                                Privacy Policy
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="w-1/2 sm:w-1/2 lg:w-2/12 px-4 mb-10">
                    <h4 class="mb-9 text-lg font-semibold text-green-900">
                        Quick Links
                    </h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="javascript:void(0)" class="inline-block text-base leading-loose text-gray-700 hover:text-green-600">
                                FAQs
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="inline-block text-base leading-loose text-gray-700 hover:text-green-600">
                                Health Blog
                            </a>
                        </li>
                        {{-- <li>
                            <a href="javascript:void(0)" class="inline-block text-base leading-loose text-gray-700 hover:text-green-600">
                                Promotions
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="inline-block text-base leading-loose text-gray-700 hover:text-green-600">
                                Download App
                            </a>
                        </li> --}}
                    </ul>
                </div>
                <div class="w-full sm:w-1/2 lg:w-3/12 px-4 mb-10">
                    <h4 class="mb-9 text-lg font-semibold text-green-900">
                        Follow Us On
                    </h4>
                    <div class="mb-6 flex items-center">
                        <!-- Social icons unchanged -->
                    </div>
                    <p class="text-base text-gray-700">
                        &copy; 2025 Pharmacy Inc.
                    </p>
                    <svg
                        width="75"
                        height="75"
                        viewBox="0 0 75 75"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M37.5 -1.63918e-06C58.2107 -2.54447e-06 75 16.7893 75 37.5C75 58.2107 58.2107 75 37.5 75C16.7893 75 -7.33885e-07 58.2107 -1.63918e-06 37.5C-2.54447e-06 16.7893 16.7893 -7.33885e-07 37.5 -1.63918e-06Z"
                            fill="url(#paint0_linear_1179_4)"
                        />
                        <defs>
                            <linearGradient
                                id="paint0_linear_1179_4"
                                x1="-1.63917e-06"
                                y1="37.5"
                                x2="75"
                                y2="37.5"
                                gradientUnits="userSpaceOnUse"
                            >
                                <stop stop-color="#13C296" stop-opacity="0.31" />
                                <stop offset="1" stop-color="#C4C4C4" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
            </div>
        </div>
    </footer>


    
