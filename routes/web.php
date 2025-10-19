<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\backend\EmployeesController;
use App\Http\Controllers\backend\CustomerController;
use App\Http\Controllers\backend\SupplierController;
use App\Http\Controllers\backend\SalaryController;
use App\Http\Controllers\backend\AttendanceController;
use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\CommerceController;
use App\Http\Controllers\backend\DeliveryController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\ExpenseController;
use App\Http\Controllers\backend\HeroSliderController;
use App\Http\Controllers\backend\InventoryController;
use App\Http\Controllers\backend\OnlinePaymentController;
use App\Http\Controllers\backend\PosController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\PurchaseOrderController;
use App\Http\Controllers\backend\RoleController;
use App\Http\Controllers\backend\SubCategoryController;
use App\Http\Controllers\backend\AuditController;
use App\Http\Controllers\backend\ReportController;
use App\Http\Controllers\frontend\AboutController;
use App\Http\Controllers\frontend\AuthCustomerController;
use App\Http\Controllers\frontend\BrandController as FrontendBrandController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\FrontendController;
use App\Http\Controllers\frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\frontend\ContactController;
use App\Http\Controllers\frontend\CustomerRegisteredController;
use App\Http\Controllers\frontend\OrderController as FrontendOrderController;
use App\Models\HeroSlider;  
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ---------------- PUBLIC ROUTES ----------------

            // Ecommerce home page (guest or logged in)
            Route::get('/', function () {
                return view('Ecommerce.home');
            })->name('home');

            // ---------------- CUSTOMER AUTH ----------------

            // Customer login + register pages
            Route::controller(AuthCustomerController::class)->group(function () {

                //// Open Login Form
                Route::get('/customer/login', 'create')
                    ->middleware('guest:customer')
                    ->name('customer.login');

                    ///  Login customer 
                Route::post('/customer/login', 'store')
                    ->middleware('guest:customer')
                    ->name('customer.login.store');


                    // logout customer
                Route::post('/customer/logout', 'destroyCustomer')
                    ->middleware('auth:customer')
                    ->name('customer.logout');
            });



            // ---------------- CUSTOMER DASHBOARD ----------------

            Route::middleware(['auth:customer', 'guard.session'])->group(function () {
                Route::get('/customer/dashboard', [FrontendController::class, 'index'])
                    ->name('customer.dashboard');
            });


            

            // ---------------- ADMIN AUTH + DASHBOARD ----------------

            // Admin dashboard (default Breeze users table)


        // Route::middleware(['auth:web'])->group(function () {
        //     Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        //         ->name('admin.dashboard');


        //                                         //// if si user is first time login
        // Route::get('/password/change', [AdminController::class, 'showChangeForm'])->name('password.change');

        // Route::put('/password/update', [AdminController::class, 'updateFirstTimeUser'])->name('password.update');


            
        // });








                    ///////////////////////////// REGISTER CUSTOMER /////////////////////////
        
         Route::controller(CustomerRegisteredController::class)->group(function () {


            route::get('/customer/register', 'create')->name('customer.register.form');

                // REGISTER CUSTOMER
            Route::post('/customer/Register', 'customerRegister')->name('customer.register');            

        });



        Route::controller(AdminController::class)->group(function () {

            // Only authenticated admins can logout
            Route::middleware('auth:web')->group(function () {
                Route::post('/admin/logout', 'destroy')->name('admin.logout');
            });

            // Public logout confirmation page
            Route::get('/logout', [AdminController::class, 'Logout'])->name('logout.page');

        });








// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// });  



        




            // TO PROTECT THE URL BY MANIPULATING IT IN DASHBOARD MAIN

     Route::middleware('auth')->group(function () {
        Route::get('/profile/view', [AdminController::class, 'Viewprofile'])->name('view.profile');
        Route::post('/profile/view/store', [AdminController::class, 'StoreProfile'])->name('admin.profile.store');
        Route::get('/profile/changePassword', [AdminController::class, 'ChangePassword'])->name('admin.change.password');
        Route::post('/profile/changePassword/store', [AdminController::class, 'UpdatePassword'])->name('password.change.store');    



});





        /////////////////     MANAGE EMPLOYEE       ////////////////////

        //  Route::controller(EmployeesController::class)->group(function () {
        //     //Showing Data in table
        //     Route::get('/employee', 'EmployeeTable')->name('all.employee')->middleware('permission:All Staff');


        //     //Add Employee Form 
        //     Route::get('/employee/create', 'AddFormEmployee')->name('employee.create')->middleware('permission:Add Staff');

        //     //Add Employee Form 
        //     Route::post('/employee/store', 'StoreFormEmployee')->name('employee.store');


        //     //Edit Employee Form 
        //     Route::get('/employee/edit/{id}', 'EditEmployee')->name('employee.edit');

            
        //    //Delete Employee Form 
        //     Route::get('/employee/delete/{id}', 'DeleteEmployee')->name('employee.delete');


        //      //Update Employee Form 
        //     Route::put('/employee/update', 'UpdateEmployee')->name('employee.update');

   
        // });



        //////////////////     MANAGE CUSTOMER       ////////////////////

            Route::controller(CustomerController::class)->group(function () {
            //Showing Data in table
            Route::get('/customer/all', 'CustomerTable')->name('all.customer')->middleware('permission:view-all-customers');



                // form customer
             Route::get('/customer/create', 'AddFormCustomer')->name('create.customer')->middleware('permission:add-customer');


             
                // store customer
             Route::post('/customer/store', 'StoreFormCustomer')->name('store.customer');


                // Editing customer
             Route::get('/customer/edit{id}', 'EditFormCustomer')->name('edit.customer')->middleware('permission:edit-customer');


              // Editing customer
             Route::put('/customer/update', 'UpdateFormCustomer')->name('update.customer');


             Route::get('/customer/delete/{id}', 'DeleteCustomer')->name('delete.customer')->middleware('permission:delete-customer');

   
        });


            //////////////////     MANAGE SUPPLIER       ////////////////////

        Route::controller(SupplierController::class)->group(function () {

            //Showing Data in table
            Route::get('/supplier', 'SupplierTable')->name('all.supplier')->middleware('permission:view-all-suppliers');

             //Showing AddSupplier Form 
            Route::get('/supplier/create', 'AddFormSupplier')->name('supplier.create')->middleware('permission:add-supplier');

             //Store Supplier fORM 
            Route::post('/supplier/store', 'StoreFormSupplier')->name('store.supplier');


                       //Edit Supplier Form 
            Route::get('/supplier/edit/{id}', 'EditFormSupplier')->name('edit.supplier')->middleware('permission:edit-supplier');



                                 //Dekete Supplier Form 
            Route::get('/supplier/delete/{id}', 'DeleteFormSupplier')->name('delete.supplier')->middleware('permission:delete-supplier');



         //Update Supplier fORM 
            Route::put('/supplier/update', 'UpdateSupplier')->name('update.supplier');


         //View Supplier fORM 
            Route::get('/supplier/details/{id}', 'DetailsSupplier')->name('details.supplier')->middleware('permission:view-supplier-details');

            

   
        });



////////////////////////////////////////       ADVANCED SALARY         /////////////////////////////


        //     Route::controller(SalaryController::class)->group(function () {

        //     //Showing Data in table
        //     Route::get('/salary', 'SalaryTable')->name('all.salary');

        //      //Showing AddSupplier Form 
        //     Route::get('/salary/create', 'AddFormSalary')->name('salary.create');


        //                  //Showing AddSALARY Form 
        //     Route::post('/salary/store', 'StoreFormSalary')->name('salary.store');


        //                  //Showing EDITSALARY Form 
        //     Route::get('/salary/edit/{id}', 'EditFormSalary')->name('salary.edit');


        //                              //Showing EDITSALARY Form 
        //     Route::put('/salary/update', 'UpdateFormSalary')->name('salary.update');


        //     //Showing EDITSALARY Form 
        //     Route::get('/salary/delete/{id}', 'DeleteSalary')->name('salary.delete');

            
        // });


////////////////////////////////////////       PAY SALARY         /////////////////////////////



        //    Route::controller(SalaryController::class)->group(function () {

        //     //Showing Data in table
        //     Route::get('/paysalary', 'PaySalaryTable')->name('pay.salary');


        //     //Showing form pay
        //     Route::get('/paysalary/paynow/{id}', 'ShowPayForm')->name('pay.salary.form');



        //       //Store form pay
        //     Route::post('/paysalary/paynow', 'PayNow')->name('store.payform');

            
        //     Route::get('/paysalary/MonthSalary', 'TableMonthSalary')->name('table.month.salary');


        //     Route::get('/paysalary/History/{id}', 'ShowPaidHistory')->name('show.History');

           
            
            
        // });





////////////////////////////////////////       ATTENDANCE         /////////////////////////////


            Route::controller(AttendanceController::class)->group(function () {

            //Showing Data in table
            Route::get('/employee/attendance/list', 'AttendanceTable')->name('employee.attendance.list')->middleware('permission:view-all-attendance');

             //Showing Data in table
            Route::get('/employee/attendance/create', 'AddEmployeeAttendance')->name('employee.add.attendance')->middleware('permission:add-attendance');;

            
            Route::post('/employee/attendance/store', 'EmployeeAttendanceStore')->name('employee.store.attendance');


            // EDIT ATTENDANCE FORM
            Route::get('/employee/attendance/edit/{date}', 'EmployeeAttendanceEdit')->name('employee.attendance.edit')->middleware('permission:edit-attendance');


            // VIEW ATTENDANCE FORM
            Route::get('/employee/attendance/view/{date}', 'EmployeeAttendanceView')->name('employee.attendance.view')->middleware('permission:view-attendance');

            
    });






            ////////////////////// MANAGE CATEGORY ///////////////////////
        
            Route::controller(CategoryController::class)->group(function () {

            //Showing Data in table
            Route::get('/category/list', 'CategoryTable')->name('category.list')->middleware('permission:view-all-categories');


             //Showing Data in table
            Route::post('/category/store', 'CategoryStore')->name('store.category');

            
            //Edit Data in table
            Route::get('/category/edit/{id}', 'CategoryEdit')->name('edit.category')->middleware('permission:edit-category');


            //Update Data in table
            Route::put('/category/update', 'CategoryUpdate')->name('update.category');

            

            //Delete Data in table
            Route::get('/category/delete/{id}', 'CategoryDelete')->name('delete.category')->middleware('permission:delete-category');

            
        });






                    ////////////////////// MANAGE SUB CATEGORY ///////////////////////

        Route::controller(SubCategoryController::class)->group(function () {

            //Showing Data in table
            Route::get('/sub-category/list', 'SubCategoryTable')->name('sub-category.list')->middleware('permission:view-all-subcategories');


            //Showing form
            Route::get('/sub-category/create', 'SubCategoryCreate')->name('sub-category.create')->middleware('permission:add-subcategory');


            //Store Data in table
            Route::post('/sub-category/store', 'SubCategoryStore')->name('sub-category.store');
            

            //Edit Data in table
            Route::get('/sub-category/edit/{id}', 'EditSubCategory')->name('edit.sub-category')->middleware('permission:edit-subcategory');


            //Update Data in table
            Route::put('/sub-category/update', 'SubCategoryUpdate')->name('update.sub-category');


            //Delete Data in table
            Route::get('/sub-category/delete/{id}', 'DeleteSubCategory')->name('delete.sub-category')->middleware('permission:delete-subcategory');
      });






                    ////////////////////// MANAGE BRAND ///////////////////////
        
            Route::controller(BrandController::class)->group(function () {

            //Showing Data in table
            Route::get('/brand/list', 'BrandTable')->name('brand.list')->middleware('permission:view-all-brands');


            //Showing form
            Route::get('/brand/create', 'CreateBrand')->name('brand.create')->middleware('permission:add-brand');

            //Store Data in table
            Route::post('/brand/store', 'StoreBrand')->name('brand.store');

            //Edit Data in table
            Route::get('/brand/edit/{id}', 'EditBrand')->name('edit.brand')->middleware('permission:edit-brand');

                
            //Update Data in table
            Route::put('/brand/update', 'UpdateBrand')->name('update.brand');


            //Delete Data in table
            Route::get('/brand/delete/{id}', 'DeleteBrand')->name('delete.brand')->middleware('permission:delete-brand');
            

 });



            // routes/web.php

            // FOR AJAX IF SINELECT NATIN SI CATEGORIES IS LALABAS UNG MGA SUBCATEGORIES
           Route::get('/get-subcategories/{category_id}', [ProductController::class, 'getSubcategories']);
        
        
            Route::controller(ProductController::class)->group(function () {

            //Showing Data in table
            Route::get('/product/list', 'ProductTable')->name('product.list')->middleware('permission:view-all-products');

             //Showing form 
            Route::get('/product/create', 'FormDropdownProduct')->name('add.product')->middleware('permission:add-products');


            //Store Data in table
            Route::post('/product/store', 'StoreProduct')->name('store.product');


            //Edit Data in Form
                            
            Route::get('/product/edit/{id}', 'EditProduct')->name('edit.product')->middleware('permission:edit-products');

            //Update Data in table
            Route::put('/product/update', 'UpdateProduct')->name('update.product');



            //Delete Data in table
            Route::get('/product/delete/{id}', 'DeleteProduct')->name('delete.product')->middleware('permission:delete-products');

                



            ////////////////////////////// IMPORT EXPORT EXCELL ///////////////////////////////////////////
            //BARCODE
            Route::get('/barcode/product/{id}','BarcodeProduct')->name('barcode.product')->middleware('permission:barcode-products');


            //Import product in excel
            Route::get('/Import/product','ImportProduct')->name('import.product')->middleware('permission:import-products');


           ///// EXPORT
            Route::get('product/export', [ProductController::class, 'Export'])->name('download.export')->middleware('permission:export-products');


                      ///// EXPORT
            Route::post('product/import', [ProductController::class, 'Import'])->name('download.import');



            
        });




    Route::controller(PurchaseOrderController::class)->group(function () {


    //Showing form for purchase order
    Route::get('/Purchase/Order', 'ShowPurchaseOrder')->name('purchase.order')->middleware('permission:create-purchase-order');

    Route::get('/Purchase/test', 'TestPurchaseCart');


    // Submit purchase order

    Route::post('/Purchase/Order', 'SavePurchaseOrder')->name('save.purchaseOrder');


    /// get all and put in the table for viewing only
    Route::get('all/Purchase/Order', 'AllPurchaseOrder')->name('all.purchase.order')->middleware('permission:view-all-purchase-order');


    /// get all and Have a received button IN TABLE
    Route::get('all/Pending/Order', 'AllPendingOrder')->name('all.pending.order')->middleware('permission:view-all-pending-order');


    ///////// SHOWING FORM DETAILS

    Route::get('Received/Order/{id}', 'ReceivedOrderDetails')->name('Received.Order')->middleware('permission:view-received-form');



        ///// SAVING IN DELIVERIES
    Route::post('/Save/Order/Deliveries', 'SaveOrderdeliveries')->name('save.deliveries');


    Route::get('All/deliveries', 'CompleteDeliveries')->name('deliveries.index')->middleware('permission:view-all-received-order');


});




                ///  FOR MODAL WHEN INSERT IT GOES ON HIS BACK TABLE  /// 
        Route::get('/cart/content', function () {
            $cart = Cart::instance('purchaseOrder')->content();

            if ($cart->isEmpty()) {
                return '<tr><td colspan="6" class="text-center">Cart is empty</td></tr>';
            }

            $html = '';
            $counter = 1; // 

            

    foreach ($cart as $item) {
        $costPrice = $item->options->cost_price ?? 0;
        $totalCost = $costPrice * $item->qty;

        $html .= '<tr data-rowid="'.$item->rowId.'" class="cart-row">';
        $html .= '<td>'.$counter++.'</td>';
        $html .= '<td class="product-name">'.$item->name.'</td>';
        $html .= '<td class="product-code">'.($item->options->code ?? '-').'</td>';
        $html .= '<td class="selling-price">'.$item->price.'</td>';

        $html .= '<td>
            <input type="number" 
                class="form-control form-control-sm cart-qty-input validate-qty" 
                data-rowid="'.$item->rowId.'" 
                value="'.$item->qty.'" 
                min="1" style="width: 70px;">
        </td>';

        $html .= '<td>
            <input type="number" 
                class="form-control form-control-sm cart-cost-input validate-cost" 
                data-rowid="'.$item->rowId.'" 
                value="'.$costPrice.'" 
                step="0.01" min="0" style="width: 90px;">
        </td>';

        $html .= '<td class="total-cost">'.number_format($totalCost, 2).'</td>';

        $html .= '<td>
            <button type="button" class="btn btn-success btn-sm update-cart-item" data-rowid="'.$item->rowId.'">
                <i class="fas fa-check"></i>
            </button>
            <button type="button" class="btn btn-danger btn-sm remove-cart-item" data-rowid="'.$item->rowId.'">X</button>
        </td>';

        $html .= '</tr>';
    }

    return $html;
})->name('cart.content');



                    ///////// TABLE MAIN



    Route::post('/cart/add', function (Illuminate\Http\Request $request) {
        Cart::instance('purchaseOrder')->add([
            'id'      => $request->id,
            'name'    => $request->name,
            'qty' => $request->qty ?? 1, // fallback to 1 if null
            'price'   => $request->price,  // selling price
            'weight'  => 0,  // ✅ Add this line
                'options' => [
                    'code' => $request->code,
                    'cost_price' => $request->cost_price ?? 0, // store cost price separately
                ]

        ]);
        return response()->json(['success' => true]);
    })->name('cart.add');



                ////////// MODAL


        /// REMOVE
        Route::delete('/cart/remove', function (Illuminate\Http\Request $request) {
            Cart::instance('purchaseOrder')->remove($request->rowId);
            return response()->json(['success' => true]);
        })->name('cart.remove');



        Route::patch('/cart/update-item', function (Illuminate\Http\Request $request) {
            $item = Cart::instance('purchaseOrder')->get($request->rowId);

            // Preserve existing options but update cost price
            $options = $item->options->toArray();
            $options['cost_price'] = $request->cost_price;

            Cart::instance('purchaseOrder')->update($request->rowId, [
                'qty' => $request->qty,
                'options' => $options,
            ]);

            return response()->json(['success' => true]);
        })->name('cart.updateItem');







                        


        

        ///////////////////// DOWNLOAD EXCELLLLL ///////////////////////////////////
            Route::get('/product/template', function () {
            $path = public_path('templates/product_import_template.xlsx');
            
            if (!file_exists($path)) {
                abort(404);
            }

            return response()->download($path, 'product_import_template.xlsx');
        })->name('product.template');





            /// EXPENSES
        
            Route::controller(ExpenseController::class)->group(function () {

            //Showing Data in table
            Route::get('/add//expense', 'AddExpense')->name('add.expense')->middleware('permission:add-expense');

            Route::post('/store//expense', 'StoreExpense')->name('store.expense');

            Route::get('/today/expense', 'TodayExpense')->name('todays.expense')->middleware('permission:view-today-expense');


            Route::get('/month/expense', 'MonthExpense')->name('month.expense')->middleware('permission:view-monthly-expense');


            Route::get('/year/expense', 'YearExpense' )->name('year.expense')->middleware('permission:view-yearly-expense');
            
        });

        


        //////////////////////////////// vat discount SYSTEM ///////////////////////
        Route::controller(CommerceController::class)->group(function () {

        //Showing vat discount settings
        Route::get('/Commerce/Settings', 'VatDiscountPage')->name('commerce.settings')->middleware('permission:manage-commerce-settings');

        Route::post('/update/vat', 'UpdateVat')->name('update.vat');
        

        Route::post('/Add/ajax/discount', 'AddAjaxDiscount')->name('add.ajax.discount');

        Route::post('/Update/ajax/discount', [CommerceController::class, 'UpdateAjaxDiscount'])->name('update.ajax.discount');

        
        Route::delete('/Delete/ajax/discount', [CommerceController::class, 'DeleteAjaxDiscount'])->name('delete.ajax.discount');



        });

        



        //////////////////////////////// POS SYSTEM ///////////////////////
            Route::controller(PosController::class)->group(function () {

            //Showing Data in TABLE
            Route::get('/pos', 'ViewPos')->name('pos')->middleware('permission:view-pos-page');

            
            //Add Data in CART Content
            Route::post('/pos/add', 'AddPos');
            
           //Get Data in CART Content
            Route::get('/pos/cart', 'CartContent');

           //ChangeQty in CART Content
            Route::post('/pos/ChangeQty/{rowId}', 'ChangeQty');

            
            //Remove Product in CART Content
            Route::delete('/pos-RemovePrd/{rowId}', 'RemoveProduct');


            //ADD Invoice Customer Opening other page
            Route::post('/create-invoice', 'CreateInvoiceCustomer');
            



        });



        Route::get('/invoice/print/{order_id}', [OrderController::class, 'ShowPickupInvoice'])->name('invoice.print');



                //////////////////////////////// POS CASHIER SYSTEM ///////////////////////
            Route::controller(PosController::class)->group(function () {

            // Submit Walkin Payment
            Route::post('/pos/Payment', 'PaymentWalkin')->name('payment.walkin');


        });

                Route::get('/pos/confirm/{id}', [PosController::class, 'confirm'])->name('pos.confirm');


                Route::get('/pos/receipt/{id}', [PosController::class, 'Receipt'])->name('POS.receipt');



            ///////////////////// ONLINE PAYMENT POS /////////////////////////////

            //  Route::controller(OnlinePaymentController::class)->group(function () {

            //     // Submit Walkin Payment
            //     Route::post('/pos/{id}/Payment', 'PaypalPayment')->name('paypal.submit');
            //     Route::get('/pos/Payment/success', 'PaypalSucess')->name('paypal.payment.success');
            //     Route::get('/pos/Payment/cancel', 'PaypalCancel')->name('paypal.payment.cancel');

            // });
            
        




        ////////////////////////////////  INVENTORY /////////////////////
            Route::controller(InventoryController::class)->group(function () {

        Route::get('/All/Inventory', 'Inventory')->name('show.inventory')->middleware('permission:view-all-inventory');


        });





         //////////////////////////////// ORDER SYSTEM ///////////////////////
            Route::controller(OrderController::class)->group(function () {

            //Insert Data in Order and OrderDetails
            Route::post('/final-invoice', 'FinalInvoice');



            Route::get('/pos/receipt/{id}', [OrderController::class, 'Receipt'])->name('POS.receipt');

        
                ////////////////////////////// PICK UP ORDER
            // Pending Orders TABLE
            Route::get('/Pending/Pickup', 'PendingPickup')->name('pending.pickup');


            // Pending Orders TABLE
            Route::post('/pickup/ajax/mark-complete', 'ajaxPickupComplete')->name('ajax.pickup.complete');


                       // Pending Orders TABLE
            Route::get('/Complete/Pickup', 'CompletePickup')->name('complete.pickup');




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





            // Pending Orders TABLE
            Route::get('/Order/Pending', 'PendingOrders')->name('pending.order')->middleware('permission:view-pending-orders');



        
            // AJAX for Mark as Shipped and Cancelled
            Route::post('/orders/ajax/mark-shipped', [OrderController::class, 'ajaxMarkAsShipped'])->name('orders.ajax.shipped');
            Route::post('/orders/ajax/mark-cancelled', [OrderController::class, 'ajaxMarkAsCancelled'])->name('orders.ajax.cancelled');

                ///////////////////////////////////////////////


            // Shipped Orders TABLE
            Route::get('/Order/Shipped', 'AllShippedOrders')->name('all.ship.order')->middleware('permission:view-all-shipping-orders');



            // Cancel Orders TABLE
            Route::get('/Order/Cancel', 'AllCancelOrders')->name('all.cancel.order')->middleware('permission:view-all-cancel-orders');
                


            // Complete Orders TABLE
            Route::get('/Order/complete', 'CompleteOrders')->name('complete.order')->middleware('permission:view-all-complete-orders');


            //Show Order Details Form
            Route::get('/Order/Details/{order_id}', 'Details')->name('details');


            //Show Order Details Form with complete order button  Complete Table
            Route::get('/Complet/Details/{order_id}', 'CompleteDetailsOrder')->name('complete.order.details');



            //Update Order Status
            Route::put('/update/status', 'StatusUpdate')->name('status.update');

            
            //Show Stock
            Route::get('/product/Stocks', 'ShowStock')->name('show.stock')->middleware('permission:Show Stock');



             //Create Order PDF
            Route::get('/product/pdf/{pdfId}', 'CreatePDF');

            
        });

        //////////////////////////////// PERMISSIONS ///////////////////////
            Route::controller(RoleController::class)->group(function () {

            //Show All Permissions AND SHOW ROLES TABLE
            Route::get('/roles', 'AllRoles')->name('all.roles')->middleware('permission:view-all-roles');


            //Add Permissions
            Route::get('/create/permission', 'AddPermission')->name('add.permission');
            
            //Store Permissions
            Route::post('/store/permission', 'StorePermission')->name('permission.store');



            //Show Edit Permissions
            Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission');


            //Show Edit Permissions
            Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission');

            //Update Permissions
            Route::put('/update/permission/{id}', 'UpdatePermission')->name('permission.update');



            

            ///////////////////////// Roles ///////////////////////////

                        //Show All Permissions AND SHOW ROLES TABLE
            Route::get('/permission', 'AllPermission')->name('all.permission')->middleware('permission:view-all-permissions');


                         //Add Roles Form
            Route::get('/create/roles', 'AddRoles')->name('add.roles');


                        //Store Permissions
            Route::post('/roles/permission', 'StoreRoles')->name('roles.store');


            //Show Edit Roles
            Route::get('/edit/roles/{id}', 'EditRoles')->name('edit.roles');

            //Update Roles
            Route::put('/update/roles', 'UpdateRoles')->name('update.roles');


            //Delete Roles
            Route::get('/delete/roles/{id}', 'DeleteRoles')->name('delete.roles');


            ////////////////// END ROLES    ////////////////////////////////////////////////


            /////////////////////// Roles in Permission ///////////////////////////
            Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission');


            //Store Roles in Permission
            Route::post('/store/roles/permission', 'StoreRolesPermission')->name('role.permission.store');


            //View Roles in Permission
            Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission')->middleware('permission:view-all-roles-in-permissions');



            //Edit Roles in Permission form
            Route::get('/edit/roles/permission/{id}', 'EditRolesPermission')->name('edit.roles.permission');

            

            //update Roles in Permission
            Route::post('/update/roles/permission/{id}', 'UpdateRolesPermission')->name('role.permission.update');
            

             //Delete Roles in Permission
            Route::get('/delete/roles/permission/{id}', 'DeleteRolesPermission')->name('role.permission.delete');
        });







                 //////////////////////////////// Admin User SYSTEM ///////////////////////
            Route::controller(AdminController::class)->group(function () {

            //All Admin User Table
            Route::get('/admin/all', 'AllAdmin')->name('all.admin')->middleware('permission:view-all-admin-accounts');


            Route::get('/admin/Create', 'CreateAdmin')->name('create.admin')->middleware('permission:add-admin-account');
            
            Route::post('/admin/Store', 'StoreAdmin')->name('Store.admin');

            
            // EDIT ADMIN
            Route::get('/admin/edit/{id}', 'EditAdmin')->name('edit.admin')->middleware('permission:edit-admin-account');


            // Update ADMIN
            Route::post('/admin/update', 'UpdateAdmin')->name('update.admin');
            

            
            // Update ADMIN
            Route::get('/admin/delete/{id}', 'DeleteAdmin')->name('delete.admin')->middleware('permission:delete-admin-account');


        });



        /////////////// Change Business Name 

        Route::controller(AdminController::class)->group(function () {

            Route::get('/BusinessName', 'BusinessName')->name('business.name')->middleware('permission:change-business-name');

                // update business name without table
            Route::post('/BusinessName/update', 'StoreBusinessName')->name('businesstitle.update');

        });



        ////////////////////// BACKUP DATABASE ///////////////////////
    Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/admin/backup', [AdminController::class, 'BackupDatabase'])->name('backup.database')->middleware('permission:backup-database');
    Route::post('/backup/now', [AdminController::class, 'BackupNow'])->name('backup.now');
    Route::get('/backup/{getFilename}', [AdminController::class, 'DownloadDatabase'])->name('backup.download');
    Route::delete('/backup/{getFilename}', [AdminController::class, 'DeleteDatabase'])->name('backup.delete');
});



    
        Route::controller(AuditController::class)->group(function () {

            Route::get('/audit-trail', 'AuditTrail')->name('audit.trail');

            Route::get('/audit-log', 'AuditLog')->name('audit.log');

            
        });


            Route::controller(ReportController::class)->group(function () {

            Route::get('/Reports-Daily', 'dailyReport')->name('daily.reports');


            Route::get('/Reports-Weekly', 'weeklyReport')->name('weekly.reports');

            
            Route::get('/Reports-Monthly', 'monthlyReport')->name('monthly.reports');

            Route::get('/Top-Selling-Products', 'TopSelling')->name('top.sellings');


            
        });


        


















            /////////////////////////// Frontend ////////////////////////////////////////////

            ////////////////////// HERO SLIDER ///////////////////////
        Route::controller(HeroSliderController::class)->group(function () {

            Route::get('/HeroSlider', 'HeroSlider')->name('heroslider.show');

            Route::get('/HeroSlider/Add', 'AddHeroSlider')->name('add.heroslider');

            Route::post('/HeroSlider/Store', 'StoreHeroSlider')->name('store.heroslider');


            Route::get('/HeroSlider/Edit/{id}', 'EditHeroSlider')->name('edit.heroslider');

            Route::put('/HeroSlider/Update', 'UpdateHeroSlider')->name('update.heroslider');

            Route::get('/HeroSlider/Delete/{id}', 'DeleteHeroSlider')->name('delete.heroslider');
        });




        





        Route::controller(FrontendController::class)->group(function () {

          Route::get('/', 'index')->name('home');

            


        });


          //////////////////    CATEGORY WISE PRODUCT SHOW ///////////////////////
         Route::controller(FrontendCategoryController::class)->group(function () {

            Route::get('/category/{slug}', 'CategoryProduct')->name('category.show');


        });








                  //////////////////    CHECKOUT PAGE ///////////////////////


     Route::controller(FrontendController::class)->group(function () {

    Route::get('/cart', 'CartShow')->name('cart.show');


    route::get('/wishlist', 'WishlistShow')->name('wishlist.show');


    Route::get('/product/{product_id}', 'ProductDetails')->name('product.show');

   });



   
     Route::controller(ContactController::class)->group(function () {

     Route::get('/Contact/page', 'ContactShow')->name('contact.show');


     Route::post('/Contact/message', 'ContactMessage')->name('contact.submit');
   });


     Route::controller(AboutController::class)->group(function () {

     Route::get('/About/page', 'AboutShow')->name('about.show');



   });



        Route::controller(FrontendBrandController::class)->group(function () {

     Route::get('/Brand/page/{id}', 'BrandShow')->name('brand.show');



   });

   


   


    // Route::middleware(['auth', 'customer'])->group(function () {

    // ///// PROFILE PAGE /////
    // Route::get('/customer/profile', [FrontendController::class, 'ProfileShow'])->name('customer.profile');


    // Route::get('/customer/profile/edit', [FrontendController::class, 'ProfileEdit'])->name('customer.profile.edit');
     

    //     });







    /////////////////// PROFILE CUSTOMER ////////////////////////
Route::middleware(['auth:customer', 'customer'])->group(function () {
    Route::get('/customer/profile', [FrontendController::class, 'ProfileShow'])->name('customer.profile');
    Route::get('/customer/profile/edit', [FrontendController::class, 'ProfileEdit'])->name('customer.profile.edit');


    Route::put('/customer/profile/update', [FrontendController::class, 'ProfileUpdate'])->name('update.customer.profile');

    Route::get('/customer/view/item/{id}', [FrontendController::class, 'ViewItem'])->name('customer.view.item');



     
    // ORDER DETAILS VIEWING


});





        Route::controller(CartController::class)->group(function () {
                    
            ////// PRODUCT DETAILS CART /////////////////

            route::post('/ecommerce/add', 'EcommerceAddCart');

            Route::patch('/ecommerce/ChangeQty/{rowId}', 'EcommerceChangeQty');

            route::get('/ecommerce/carting', 'CartContent');


            route::DELETE('/ecommerce-RemovePrd/{rowId}', 'RemoveEcommProduct')->name('removeProd');

            /////////// CART CHECKOUT //////////////




        });


         Route::controller(FrontendOrderController::class)->group(function () {
                    
            ////// PRODUCT DETAILS CART /////////////////

            route::get('/ecommerce/payment', 'EcommercePayment')->name('cart.payment');


            route::post('/ecommerce/checkout', 'EcommerceCheckout')->name('cart.checkout');



            // Change addreess

             route::post('/ecommerce/change/address', 'updateAddress')->name('cart.updateAddress');


                ////////// Cash Payment success /////////////
            route::get('/ecommerce/{id}/success', 'SuccesfullyOrder')->name('success.order');


             ////////// AFTER PAYPAL PAYMENT /////////////

            


                Route::get('/Ecommerce/Payment/success', 'PaypalSuccess')->name('paypal.success');
                /// it update to complete 

                //// it will go you to success page
                 route::get('/ecommerce/{id}/Paypal', 'successPaypal')->name('successfully.paypal.order');

                Route::get('/pos/Payment/cancel', 'PaypalCancel')->name('paypal.cancel');




                //////////// order history /////////////
                Route::post('/Customer/Order/mark-cancelled', [OrderController::class, 'ajaxMarkAsCancelled'])->name('Customer.order.cancelled');

        });



        
            ///////////////////// ONLINE PAYMENT POS /////////////////////////////

            //  Route::controller(OnlinePaymentController::class)->group(function () {



            // });





        ////////////////// LAZY LOADING FOR USER TO GO IN CHECKOUT  ////////////////

        // Route::get('/checkout', [OrderController::class, 'payment'])->name('checkout');





require __DIR__.'/auth.php';





