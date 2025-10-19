<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // CUSTOMERS TABLE
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('password')->nullable();
            $table->string('phone');
            $table->text('address')->nullable();
            $table->string('image')->nullable();
            $table->string('city')->nullable();
            $table->boolean('added_by_staff')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });

        // SUPPLIERS TABLE
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('address')->nullable();
            $table->string('image');
            $table->string('city')->nullable();
            $table->timestamps();
        });

        // CATEGORIES TABLE
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->string('slug')->index();
            $table->timestamps();
        });

        // SUBCATEGORIES TABLE
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->timestamps();
        });

        // PRODUCTS TABLE
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('product_code')->index();
            $table->string('product_image')->nullable();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained('subcategories')->onDelete('set null');
            $table->foreignId('brand_id')->nullable()->constrained('categories')->onDelete('set null'); // adjust if you have a brands table
            $table->text('description')->nullable();
            $table->enum('dosage_form', ['Tablet', 'Capsule', 'Syrup', 'Cream', 'Ointment'])->default('Tablet');
            $table->enum('target_gender', ['Unisex', 'Male', 'Female'])->default('Unisex');
            $table->enum('age_group', ['All', 'Kids', 'Adults', 'Seniors'])->default('All');
            $table->string('health_concern')->nullable();
            $table->decimal('selling_price', 10, 2);
            $table->boolean('has_expiration')->default(1);
            $table->boolean('prescription_required')->default(0);
            $table->timestamps();
        });

        // ORDERS TABLE
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('order_source', ['POS', 'ECOM'])->default('POS');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('order_date');
            $table->string('order_status');
            $table->string('order_type')->default('In-Store');
            $table->dateTime('shipped_at')->nullable();
            $table->foreignId('shipped_by')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('cancelled_at')->nullable();
            $table->foreignId('cancelled_by')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('cancelled_by_role', ['customer', 'admin'])->nullable();
            $table->text('cancel_reason')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->integer('total_products');
            $table->decimal('sub_total', 10, 2)->nullable();
            $table->decimal('vat', 10, 2)->nullable();
            $table->string('vat_status')->default('taxable');
            $table->decimal('discount', 10, 2)->nullable();
            $table->string('invoice_no')->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('transaction_id')->nullable();
            $table->decimal('pay', 10, 2)->nullable();
            $table->decimal('change_amount', 10, 2)->nullable();
            $table->decimal('due', 10, 2)->nullable();
            $table->foreignId('shipping_address_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->timestamps();
        });

        // ORDERDETAILS TABLE
        Schema::create('orderdetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('batch_number')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('unitcost', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->decimal('profit', 10, 2)->nullable();
            $table->timestamps();
        });

        // INVENTORIES TABLE
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('set null');
            $table->string('batch_number')->nullable()->index();
            $table->date('expiry_date')->nullable()->index();
            $table->date('received_date')->nullable();
            $table->integer('quantity')->default(0);
            $table->decimal('cost_price', 10, 2)->nullable()->index();
            $table->decimal('selling_price', 10, 2)->nullable();
            $table->timestamps();
        });

        // ADDRESSES TABLE
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('full_address');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        // PURCHASE ORDERS TABLE
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->unique();
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->date('expected_delivery_date')->nullable();
            $table->enum('status', ['draft', 'sent', 'partially_received', 'received'])->default('draft');
            $table->timestamps();
        });

        // DELIVERIES TABLE
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained()->cascadeOnDelete();
            $table->date('delivery_date')->nullable();
            $table->string('reference_number')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        // DELIVERY ITEMS TABLE
        Schema::create('delivery_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('batch_number')->nullable();
            $table->date('expiry_date')->nullable();
            $table->integer('quantity_received')->default(0);
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down(): void
    {
        Schema::dropIfExists('delivery_items');
        Schema::dropIfExists('deliveries');
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('inventories');
        Schema::dropIfExists('orderdetails');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
        Schema::dropIfExists('subcategories');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('customers');
    }
};
