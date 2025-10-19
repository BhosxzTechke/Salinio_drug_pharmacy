            <div class="left-side-menu">

                <div class="h-100" data-simplebar>

                    <!-- User box -->
                    <div class="user-box text-center">
                        <img src="assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme"
                            class="rounded-circle avatar-md">
                        <div class="dropdown">
                            <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                                data-bs-toggle="dropdown">Geneva Kennedy</a>
                            <div class="dropdown-menu user-pro-dropdown">

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-user me-1"></i>
                                    <span>My Account</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-settings me-1"></i>
                                    <span>Settings</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-lock me-1"></i>
                                    <span>Lock Screen</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-log-out me-1"></i>
                                    <span>Logout</span>
                                </a>

                            </div>
                        </div>
                        <p class="text-muted">Admin Head</p>
                    </div>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul id="side-menu">

                            <li class="menu-title">Main</li>
                
                            <li>
                                <a href="{{ route('admin.dashboard') }}" >
                                    <i class="mdi mdi-view-dashboard-outline"></i>
                                    <span class="badge bg-success rounded-pill float-end">4</span>
                                    <span> Dashboards </span>
                                </a>

                            </li>



                            @if(Auth::user()->can('view-pos-page')) 
                            <li>
                                <a href="{{ route('pos') }}" >
                                    <i class="fa-solid fa-cash-register"></i>
                                        <span class="badge bg-pink float-end">Hot</span>
                                    <span> POS </span>
                                </a>

                            </li>
                            @endif




                            
                            {{-- <li>
                                <a href="#sidebarEcommerce" data-bs-toggle="collapse">
                                    <i class="mdi mdi-cart-outline"></i>
                                    <span> Staff Manage </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarEcommerce">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('all.employee')}}">All Staff</a>
                                        </li>

                        @if(Auth::user()->can('Add Staff'))
                                        <li>
                                            <a href="{{ route('employee.create')}}">Add Staff</a>
                                        </li>

                                        @endif

                                        
                                    </ul>
                                </div>
                            </li> --}}



                            
                        @if(Auth::user()->can('customer-menu')) 
                            <li>
                                <a href="#sidebarCrm" data-bs-toggle="collapse">
                                    <i class="mdi mdi-account-multiple-outline"></i>
                                    <span> Manage Customer </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarCrm">
                                    <ul class="nav-second-level">

                                    @if(Auth::user()->can('view-all-customers'))
                                        <li>
                                            <a href="{{ route('all.customer') }}">All Customer</a>
                                        </li>
                                        @endif

                                @if(Auth::user()->can('add-customer'))

                                        <li>
                                            <a href="{{ route('create.customer')}}">Add Customer</a>
                                        </li>
                                    @endif

                                    </ul>
                                </div>
                            </li>
                            @endif







                        @if(Auth::user()->can('supplier-menu')) 
                            <li>    
                                <a href="#sidebarEmail" data-bs-toggle="collapse">
                                    <i class="fa-solid fa-truck-field"></i>
                                    <span> Manage Supplier </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarEmail">
                                    <ul class="nav-second-level">

                                    @if(Auth::user()->can('view-all-suppliers')) 
                                        <li>
                                            <a href="{{ route('all.supplier') }}">All Supplier</a>
                                        </li>
                                        @endif

                                        
                                        
                                        @if(Auth::user()->can('add-supplier'))
                                        <li>
                                            <a href="{{ route('supplier.create') }}">Add Supplier</a>
                                        </li>
                                        @endif


                                    </ul>
                                </div>
                            </li>
                            @endif




                        {{-- <li>
                            <a href="#sidebarSalary" data-bs-toggle="collapse">
                                <i class="mdi mdi-email-multiple-outline"></i>
                                <span> Employee Salary </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarSalary">
                                <ul class="nav-second-level">
                                    <li><a href="{{ route('pay.salary') }}">Pay Salary</a></li>
                                    <li><a href="{{ route('salary.create') }}">Add Advance Salary</a></li>
                                    <li><a href="{{ route('all.salary') }}">All Advance Salary</a></li>
                                    <li><a href="{{ route('table.month.salary') }}">Last Month Salary</a></li>

                                    
                                </ul>
                            </div>
                        </li> --}}


                        @if(Auth::user()->can('attendance-menu'))
                        <li>
                            <a href="#attendance" data-bs-toggle="collapse">
                                <i class="fa-solid fa-clipboard-user"></i>
                                <span> Staff Attendance </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="attendance">
                                <ul class="nav-second-level">
                                    @if(Auth::user()->can('view-all-attendance'))
                                    <li><a href="{{ route('employee.attendance.list') }}">All Staff attendance</a></li>
                                    @endif
                                    @if(Auth::user()->can('add-attendance'))
                                    <li><a href="{{ route('employee.add.attendance')  }}">Add Attendance</a></li>
                                    @endif

                                    
                                </ul>
                            </div>
                        </li>
                        @endif  




                        {{-- @if(Auth::user()->can('category-menu')) --}}
                        <li>
                            <a href="#cat" data-bs-toggle="collapse">
                                <i class="fas fa-store"></i>
                                <span> Manage Category </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="cat">
                            @if(Auth::user()->can('view-all-categories'))
                                <ul class="nav-second-level">
                                    <li><a href="{{ route('category.list') }}">All Category</a></li>
                                </ul>
                            @endif

                            </div>  
                        </li>
                        {{-- @endif --}}


                        
                    @if(Auth::user()->can('sub-category-menu'))
                        <li>
                            <a href="#sub-Category" data-bs-toggle="collapse">
                                <i class="fas fa-store"></i>
                                <span> Manage Sub-Category </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sub-Category">
                                <ul class="nav-second-level">

                                    @if(Auth::user()->can('view-all-subcategories'))
                                    <li><a href="{{ route('sub-category.list') }}">All Sub-Category</a></li>
                                    @endif


                                    @if(Auth::user()->can('add-subcategory'))
                                    <li><a href="{{ route('sub-category.create') }}">Add Sub-Category</a></li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                        @endif




                            @if(Auth::user()->can('brand-menu'))
                        <li>
                            <a href="#brands" data-bs-toggle="collapse">
                                <i class="fas fa-store"></i>
                                <span> Manage Brand </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="brands">
                                <ul class="nav-second-level">

                                    @if(Auth::user()->can('view-all-brands'))
                                    <li><a href="{{ route('brand.list') }}">All Brand</a></li>
                                    @endif

                                    @if(Auth::user()->can('add-brand'))
                                    <li><a href="{{ route('brand.create') }}">Add Brand</a></li>
                                    @endif
                                    
                                </ul>
                            </div>
                        </li>
                        @endif


    {{-- @if(Auth::user()->can('Product Menu'))
            <li>
            <a href="#delivery" data-bs-toggle="collapse">
                <i class="mdi mdi-email-multiple-outline"></i>
                <span> Manage Inventory </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="delivery">
                <ul class="nav-second-level">
                    <li><a href="">All Movement</a></li>

                    <li><a href="">Add Purchase Order</a></li>
                    <li><a href="">Received Movement</a></li>

                </ul>
            </div>
        </li>
        @endif
--}}





@if(Auth::user()->can('product-menu'))
<li>
    <a href="#product" data-bs-toggle="collapse">
        <i class="mdi mdi-cart-outline"></i>
        <span> Manage Product </span>
        <span class="menu-arrow"></span>
    </a>

    <div class="collapse" id="product">
        <ul class="nav-second-level">

            @if(Auth::user()->can('view-all-products'))
                <li><a href="{{ route('product.list') }}">All Product</a></li>
            @endif

            @if(Auth::user()->can('add-products'))
                <li><a href="{{ route('add.product') }}">Add Product</a></li>
            @endif

            @if(Auth::user()->can('import-products'))
                <li><a href="{{ route('import.product') }}">Import Product</a></li>
            @endif


            @if(Auth::user()->can('purchase-menu'))
                <li>
                    <a href="#purchaseOrder" data-bs-toggle="collapse">
                        <span> Purchase Order </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse" id="purchaseOrder">
                        <ul class="nav-second-level">

                            @if(Auth::user()->can('view-all-purchase-order'))
                                <li><a href="{{ route('all.purchase.order') }}">All POs</a></li>
                            @endif

                            @if(Auth::user()->can('create-purchase-order'))
                                <li><a href="{{ route('purchase.order') }}">Create PO</a></li>
                            @endif

                            @if(Auth::user()->can('view-all-pending-order'))
                                <li><a href="{{ route('all.pending.order') }}">Pending Deliveries</a></li>
                            @endif

                            @if(Auth::user()->can('view-all-received-order'))
                                <li><a href="{{ route('deliveries.index') }}">All Deliveries</a></li>
                            @endif

                        </ul>
                    </div>
                </li>
            @endif

        </ul>
    </div>
</li>
@endif




                        @if(Auth::user()->can('inventory-menu'))
                            <li>
                                <a href="#inventory" data-bs-toggle="collapse">
                                    <i class="mdi mdi-warehouse"></i>
                                    <span> Manage Inventory </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="inventory">
                                    <ul class="nav-second-level">

                                        @if (Auth::user()->can('view-all-inventory'))
                                        <li><a href="{{ route('show.inventory') }}">Inventory</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                        @endif




                    @if(Auth::user()->can('order-menu'))
                        <li>
                        <a href="#orders" data-bs-toggle="collapse">
                            <i class="mdi mdi-package-variant"></i>
                            <span> Manage Orders </span>
                            <span class="menu-arrow"></span>
                        </a>


                        <div class="collapse" id="orders">
                            <ul class="nav-second-level">

                                @if(Auth::user()->can('view-pending-orders'))
                                <li><a href="{{ route('pending.order') }}">Pending Orders</a></li>
                                @endif


                        @if(Auth::user()->can('view-all-shipping-orders'))
                                <li><a href="{{ route('all.ship.order')}}">Shipping Orders</a></li>
                            @endif


                        @if(Auth::user()->can('view-all-cancel-orders'))
                                <li><a href="{{ route('all.cancel.order')}}">Cancel Orders</a></li>
                            @endif

                                    


                        @if(Auth::user()->can('view-complete-orders'))
                        <li><a href="{{ route('complete.order') }}">Complete Orders</a></li>
                        @endif
                        
                                </ul>
                            </div>
                        </li>
                    @endif



 @if(Auth::user()->can('order-menu'))
                        <li>
                        <a href="#pickup" data-bs-toggle="collapse">
                            <i class="mdi mdi-storefront-outline"></i>
                            <span> Manage Pickup </span>
                            <span class="menu-arrow"></span>
                        </a>


                        <div class="collapse" id="pickup">
                            <ul class="nav-second-level">

                                {{-- @if(Auth::user()->can('view-pending-orders')) --}}
                                <li><a href="{{ route('pending.pickup') }}">Pending Pickup</a></li>
                                {{-- @endif --}}


                        {{-- @if(Auth::user()->can('view-all-shipping-orders')) --}}
                                <li><a href="{{ route('complete.pickup') }}">Complete Pickup</a></li>
                            {{-- @endif --}}

                                </ul>
                            </div>
                        </li>
                    @endif




        @if(Auth::user()->can('expense-menu'))
            <li>
                <a href="#sidebarAuth" data-bs-toggle="collapse">
                    <i class="mdi mdi-cash-multiple"></i>
                    <span> Manage Expense </span>
                    <span class="menu-arrow"></span>
                </a>


                <div class="collapse" id="sidebarAuth">
                    <ul class="nav-second-level">

                        @if(Auth::user()->can('add-expense'))
                        <li>
                            <a href="{{ route('add.expense')}}">Add Expense</a>
                        </li>
                        @endif

                        @if(Auth::user()->can('view-today-expense'))
                        <li>
                            <a href="{{ route('todays.expense')}}">Today Expense</a>
                        </li>
                        @endif
                        
                        @if(Auth::user()->can('view-monthly-expense'))
                        <li>
                            <a href="{{ route('month.expense')}}">Monthly Expense</a>
                        </li>
                        @endif

                        @if(Auth::user()->can('view-yearly-expense'))
                        <li>
                            <a href="{{ route('year.expense')}}">Yearly Expense</a>
                        </li>
                        @endif

                        
                

                    </ul>
                </div>
        </li>
        @endif





                {{-- @if(Auth::user()->can('view-all-reports')) --}}
                <li>
                    <a href="#audit" data-bs-toggle="collapse">
                        <i class="mdi mdi-file-document-outline"></i>
                        <span>Audit Trail Report </span>
                        <span class="menu-arrow"></span>
                    </a>


                <div class="collapse" id="audit">
                    <ul class="nav-second-level">

                        @if(Auth::user()->can('view-audit-trail'))
                            <li>
                                <a href="{{ route('audit.trail')}}">Audit By Action</a>
                            </li>
                        @endif


                        {{-- @if(Auth::user()->can('view-weekly-sales-report')) --}}
                        <li>
                            <a href="{{ route('audit.log') }}">Audit By Log</a>
                        </li>
                        {{-- @endif --}}


                        </ul>
                    </div>
                </li>
            {{-- @endif --}}


          @if(Auth::user()->can('manage-commerce-settings'))
               <li><a href="{{ route('commerce.settings') }}"><i class="mdi mdi-cart-outline"></i><span> Commerce Settings</span></a>
            
        </li>
        @endif



        {{-- <li class="menu-title mt-2">GENERAL SETTINGS</li> --}}



        @if(Auth::user()->can('all-reports'))
            <li class="menu-title mt-2">Reports</li>


            @if(Auth::user()->can('view-all-reports'))
                <li>
                    <a href="#SalesReport" data-bs-toggle="collapse">
                        <i class="mdi mdi-chart-bar"></i>
                        <span>Sales Report </span>
                        <span class="menu-arrow"></span>
                    </a>


                <div class="collapse" id="SalesReport">
                    <ul class="nav-second-level">

                        @if(Auth::user()->can('view-daily-sales-report'))
                            <li>
                                <a href="{{ route('daily.reports')}}">Daily Sales Report</a>
                            </li>
                        @endif


                        @if(Auth::user()->can('view-weekly-sales-report'))
                        <li>
                            <a href="{{ route('weekly.reports') }}">Weekly Sales Report</a>
                        </li>
                        @endif


                        @if(Auth::user()->can('view-monthly-sales-report'))
                        <li>
                            <a href="{{ route('monthly.reports') }}">Monthly Sales Report</a>
                        </li>
                        @endif


                        
                        <li>
                            <a href="{{ route('top.sellings') }}">Top Selling Products</a>
                        </li>

                        </ul>
                    </div>
                </li>
            @endif






                {{-- @if(Auth::user()->can('inventory-reports-menu'))
                    <li>
                        <a href="#InventReports" data-bs-toggle="collapse">
                            <i class="mdi mdi-account-circle-outline"></i>
                            <span>Inventory Reports</span>
                            <span class="menu-arrow"></span>
                        </a>


                        <div class="collapse" id="InventReports">
                        <ul class="nav-second-level">

                            @if(Auth::user()->can('view-fast-slow-moving-products'))
                                <li>
                                    <a href="{{ route('heroslider.show')}}">Fast-Selling / Slow-Moving Products</a>
                                </li>
                            @endif

{{-- 
                            @if(Auth::user()->can('view-stock-in-out-history'))
                                <li>
                                    <a href="{{ route('add.heroslider') }}">Stock In / Stock Out History</a>
                                </li>
                            @endif --}}

{{-- 
                            @if(Auth::user()->can('view-inventory-evaluation-reports'))
                                <li>
                                    <a href="{{ route('add.heroslider') }}">Inventory Valuation Report</a>
                                </li>   
                            @endif

                        </ul>
                        </div>
                        </li>
                @endif


 --}}


            {{-- @if(Auth::user()->can('orders-menu'))

                        <li>
                            <a href="#OrderReports" data-bs-toggle="collapse">
                                <i class="mdi mdi-account-circle-outline"></i>
                                <span>Order Reports</span>
                                <span class="menu-arrow"></span>
                            </a>


                            <div class="collapse" id="OrderReports">
                                <ul class="nav-second-level">

                                    @if(Auth::user()->can('pos-order-report'))
                                    <li>
                                        <a href="{{ route('heroslider.show')}}">POS Orders Report</a>
                                    </li>
                                    @endif

                                    @if(Auth::user()->can('ecommerce-order-report'))
                                    <li>
                                        <a href="{{ route('add.heroslider') }}">eCommerce Orders Report</a>
                                    </li>
                                    @endif

                                </ul>
                            </div>
                        </li>
 --}}


        
                        {{-- @if(Auth::user()->can('financial-reports-menu'))
                                        <li>
                                                <a href="#Financial" data-bs-toggle="collapse">
                                                    <i class="mdi mdi-account-circle-outline"></i>
                                                    <span>Financial Reports</span>
                                                    <span class="menu-arrow"></span>
                                                </a>


                                        <div class="collapse" id="Financial">
                                        <ul class="nav-second-level">

                                            @if(Auth::user()->can('view-profit-loss-by-product'))
                                            <li>
                                                <a href="{{ route('heroslider.show')}}">Profit & Loss by Product / Category</a>
                                            </li>
                                            @endif


                                            @if(Auth::user()->can('view-tax-reports'))
                                            <li>
                                                <a href="{{ route('add.heroslider') }}">Tax Reports</a>
                                            </li>
                                            @endif

                                    </ul>
                                </div>

                                
                            </li> --}}



                        {{-- @endif --}}

                    @endif





    @if(Auth::user()->can('custom'))
        <li class="menu-title mt-2">Custom</li>


        @if(Auth::user()->can('carousel-banner-menu'))
                <li>
                    <a href="#HeroSlider" data-bs-toggle="collapse">
                        <i class="mdi mdi-image-multiple"></i>
                        <span>Hero ImageSlider </span>
                        <span class="menu-arrow"></span>
                    </a>


                <div class="collapse" id="HeroSlider">
                    <ul class="nav-second-level">
                        @if(Auth::user()->can('view-all-carousel-banner'))
                            <li>
                                <a href="{{ route('heroslider.show')}}">All ImageSLider</a>
                            </li>
                        @endif

                        @if(Auth::user()->can('add-carousel-banner'))
                            <li>
                                <a href="{{ route('add.heroslider') }}">Add ImageSLider</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif




        {{-- <li class="menu-title mt-2">GENERAL SETTINGS</li> --}}


        @if(Auth::user()->can('business-name-menu'))
            <li>
                <a href="#businessName" data-bs-toggle="collapse">
                    <i class="mdi mdi-rename-box"></i>
                    <span>Modify Business Name </span>
                    <span class="menu-arrow"></span>
                </a>


            <div class="collapse" id="businessName">
                <ul class="nav-second-level">

                    @if(Auth::user()->can('change-business-name'))
                    <li>
                        <a href="{{ route('business.name')}}">Change Business Name</a>
                    </li>
                    @endif
                    
                </ul>
            </div>
        </li>
        @endif


    @endif




    {{-- @if(Auth::user()->can('general-settings')) --}}

            {{-- @if(Auth::user()->can('roles-and-permission')) --}}
                    <li class="menu-title mt-2">GENERAL SETTINGS</li>

            <li>
                <a href="#sidebarExpages" data-bs-toggle="collapse">
                    <i class="mdi mdi-account-key"></i>
                    <span> Roles and Permission </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarExpages">
                    <ul class="nav-second-level">

                        {{-- @if(Auth::user()->can('view-all-permissions')) --}}
                        <li>
                            <a href="{{ route('all.permission') }}">All Permission</a>
                        </li>
                        {{-- @endif --}}

                        {{-- @if(Auth::user()->can('view-all-roles')) --}}
                        <li>
                            <a href="{{ route('all.roles') }}">All Roles</a>
                        </li>
                        {{-- @endif --}}

                        {{-- @if(Auth::user()->can('manage-roles-and-permissions')) --}}
                        <li>
                            <a href="{{ route('add.roles.permission') }}">Roles in Permission</a>
                        </li>
                        {{-- @endif --}}

                        {{-- @if(Auth::user()->can('view-all-roles-in-permissions')) --}}
                        <li>
                            <a href="{{ route('all.roles.permission') }}">All Roles in Permission</a>
                        </li>
                        {{-- @endif --}}
                    </ul>

                </div>
            </li>
                {{-- @endif --}}


                {{-- @if(Auth::user()->can('user-account-menu')) --}}
                    <li>
                            <a href="#admin" data-bs-toggle="collapse">
                                <i class="mdi mdi-account-circle"></i>
                                <span> User Account </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="admin">
                                <ul class="nav-second-level">

                                    {{-- @if(Auth::user()->can('view-all-admin-accounts')) --}}
                                    <li>
                                        <a href="{{ route('all.admin') }}">All Users</a>
                                    </li>
                                    {{-- @endif --}}

                                    {{-- @if(Auth::user()->can('add-admin-account')) --}}
                                    <li>
                                        <a href="{{ route('create.admin') }}">Add Users</a>
                                    </li>
                                    {{-- @endif --}}

                                </ul>


                            </div>
                        </li>
                {{-- @endif --}}





                @if(Auth::user()->can('manage-backup-menu'))
                        <li>
                            <a href="#backup" data-bs-toggle="collapse">
                                <i class="mdi mdi-backup-restore"></i>
                                <span class="badge bg-blue float-end">New</span>
                                <span> Manage Backup </span>
                            </a>

                            <div class="collapse" id="backup">
                                    <ul class="nav-second-level">

                                            @if(Auth::user()->can('backup-database'))
                                                    <li>
                                                        <a href="{{ route('backup.database')}}">Backup Database</a>
                                                    </li>
                                            @endif
                                        
                                    </ul>
                            </div>
                        </li>
                @endif

            {{-- @endif --}}
    {{-- @endif --}}

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>