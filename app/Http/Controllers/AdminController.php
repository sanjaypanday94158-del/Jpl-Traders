<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\AdminUser;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Enquiry;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderCancellationService;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (session()->has('admin_id')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $admin = AdminUser::where('username', $data['username'])->first();

        if (!$admin || !Hash::check($data['password'], $admin->password)) {
            return back()->withErrors(['username' => 'Incorrect username or password.'])->withInput();
        }

        $request->session()->regenerate();
        session(['admin_id' => $admin->id]);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_id');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $activeOrders = Order::where('status', '!=', 'cancelled');

        return view('admin.dashboard', [
            'productCount' => Product::count(),
            'categoryCount' => Category::count(),
            'brandCount' => Brand::count(),
            'enquiryCount' => Enquiry::count(),
            'newEnquiries' => Enquiry::where('status', 'New')->count(),
            'orderCount' => Order::count(),
            'ordersToday' => Order::whereDate('created_at', today())->count(),
            'customerCount' => User::count(),
            'orderedAmount' => (clone $activeOrders)->sum('total_amount'),
            'codPendingAmount' => (clone $activeOrders)->where('payment_status', 'pending')->sum('total_amount'),
            'codCollectedAmount' => Order::where('payment_status', 'collected')->sum('total_amount'),
        ]);
    }

    public function products()
    {
        $products = Product::with(['categoryRecord', 'brandRecord'])->latest()->paginate(20);
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $brands = Brand::where('is_active', true)->orderBy('name')->get();

        return view('admin.products', compact('products', 'categories', 'brands'));
    }

    public function storeProduct(Request $request)
    {
        $this->saveProduct($request);

        return redirect()->route('admin.products')->with('success', 'Product added successfully.');
    }

    public function updateProduct(Request $request, Product $product)
    {
        $this->saveProduct($request, $product);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
    }

    public function categories()
    {
        $categories = Category::withCount('products')->orderBy('name')->paginate(15);
        $iconNames = Category::ICONS;

        return view('admin.categories', compact('categories', 'iconNames'));
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name'],
            'icon' => ['nullable', 'string', Rule::in(Category::ICONS)],
        ]);

        Category::create([
            'name' => $data['name'],
            'slug' => $this->uniqueSlug($data['name'], 'categories'),
            'icon' => $data['icon'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.categories')->with('success', 'Category created successfully.');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('categories', 'name')->ignore($category->id)],
            'icon' => ['nullable', 'string', Rule::in(Category::ICONS)],
        ]);
        $name = $data['name'];

        DB::transaction(function () use ($category, $name, $data, $request): void {
            $category->update([
                'name' => $name,
                'slug' => $this->uniqueSlug($name, 'categories', $category->id),
                'icon' => $data['icon'] ?? null,
                'is_active' => $request->boolean('is_active'),
            ]);
            $category->products()->update(['category' => $name]);
        });

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully.');
    }

    public function destroyCategory(Category $category)
    {
        $deleted = DB::transaction(function () use ($category): bool {
            $category = Category::whereKey($category->id)->lockForUpdate()->firstOrFail();

            if ($category->products()->exists()) {
                return false;
            }

            $category->delete();

            return true;
        });

        if (!$deleted) {
            return back()->withErrors(['category' => 'Categories with linked products cannot be deleted.']);
        }

        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully.');
    }

    public function brands()
    {
        $brands = Brand::withCount('products')->orderBy('name')->paginate(15);

        return view('admin.brands', compact('brands'));
    }

    public function storeBrand(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:brands,name'],
        ]);

        Brand::create([
            'name' => $data['name'],
            'slug' => $this->uniqueSlug($data['name'], 'brands'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.brands')->with('success', 'Brand created successfully.');
    }

    public function updateBrand(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('brands', 'name')->ignore($brand->id)],
        ]);
        $name = $data['name'];

        DB::transaction(function () use ($brand, $name, $request): void {
            $brand->update([
                'name' => $name,
                'slug' => $this->uniqueSlug($name, 'brands', $brand->id),
                'is_active' => $request->boolean('is_active'),
            ]);
            $brand->products()->update(['brand' => $name]);
        });

        return redirect()->route('admin.brands')->with('success', 'Brand updated successfully.');
    }

    public function orders()
    {
        $orders = Order::withCount('items')->latest()->paginate(20);

        return view('admin.orders', compact('orders'));
    }

    public function order(string $orderNumber)
    {
        $order = Order::with(['items', 'events', 'customer', 'codCollector'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('admin.order', ['order' => $order, 'statuses' => Order::STATUSES]);
    }

    public function updateOrderStatus(Request $request, OrderCancellationService $cancellations, string $orderNumber)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(Order::STATUSES))],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($data['status'] === 'cancelled') {
            $orderId = Order::where('order_number', $orderNumber)->value('id');
            abort_if($orderId === null, 404);

            $result = $cancellations->cancelByAdmin(
                (int) $orderId,
                'Admin #'.session('admin_id'),
                $data['notes'] ?? null
            );

            if ($result === 'collected') {
                return back()->withErrors(['status' => 'An order with collected COD cannot be cancelled.']);
            }

            if ($result === 'not_allowed') {
                return back()->withErrors(['status' => 'Delivered or cancelled orders cannot be moved to another status.']);
            }

            if ($result === 'unchanged') {
                return back()->with('success', 'The order already has that status.');
            }

            return back()->with('success', 'Order status updated and added to tracking history.');
        }

        $result = DB::transaction(function () use ($orderNumber, $data): string {
            $order = Order::where('order_number', $orderNumber)->lockForUpdate()->firstOrFail();

            if (in_array($order->status, ['delivered', 'cancelled'], true) && $order->status !== $data['status']) {
                return 'terminal';
            }

            if ($order->status === $data['status']) {
                return 'unchanged';
            }

            $order->update(['status' => $data['status']]);
            OrderEvent::create([
                'order_id' => $order->id,
                'status' => $data['status'],
                'title' => Order::STATUSES[$data['status']],
                'notes' => $data['notes'] ?? null,
                'actor' => 'Admin #'.session('admin_id'),
            ]);

            return 'updated';
        });

        if ($result === 'terminal') {
            return back()->withErrors(['status' => 'Delivered or cancelled orders cannot be moved to another status.']);
        }

        if ($result === 'unchanged') {
            return back()->with('success', 'The order already has that status.');
        }

        return back()->with('success', 'Order status updated and added to tracking history.');
    }

    public function collectCod(string $orderNumber)
    {
        $result = DB::transaction(function () use ($orderNumber): string {
            $order = Order::where('order_number', $orderNumber)->lockForUpdate()->firstOrFail();

            if ($order->status !== 'delivered') {
                return 'not_delivered';
            }

            if ($order->payment_status === 'collected') {
                return 'already_collected';
            }

            $order->update([
                'payment_status' => 'collected',
                'cod_collected_at' => now(),
                'cod_collected_by' => session('admin_id'),
            ]);
            OrderEvent::create([
                'order_id' => $order->id,
                'status' => 'payment_collected',
                'title' => 'Cash on delivery collected',
                'notes' => 'Payment of ₹'.number_format((float) $order->total_amount, 2).' recorded as collected.',
                'actor' => 'Admin #'.session('admin_id'),
            ]);

            return 'collected';
        });

        if ($result === 'not_delivered') {
            return back()->withErrors(['payment' => 'COD can only be marked collected after delivery.']);
        }

        if ($result === 'already_collected') {
            return back()->with('success', 'COD has already been marked collected.');
        }

        return back()->with('success', 'COD collection recorded in the order timeline.');
    }

    public function customers()
    {
        $customers = User::withCount('orders')
            ->withSum(['orders as order_total' => fn ($query) => $query->where('status', '!=', 'cancelled')], 'total_amount')
            ->latest()
            ->paginate(20);

        return view('admin.customers', compact('customers'));
    }

    public function customer(int $customerId)
    {
        $customer = User::with(['orders' => fn ($query) => $query->with('items')->latest()])
            ->findOrFail($customerId);

        return view('admin.customer', compact('customer'));
    }

    public function enquiries()
    {
        $enquiries = Enquiry::latest()->paginate(20);
        return view('admin.enquiries', compact('enquiries'));
    }

    private function saveProduct(Request $request, ?Product $product = null): void
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')->where('is_active', true)],
            'brand_id' => ['required', 'integer', Rule::exists('brands', 'id')->where('is_active', true)],
            'stock_quantity' => [$product ? 'nullable' : 'required', 'integer', 'min:0', 'max:4294967295'],
            'price' => ['required', 'numeric', 'min:0'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'rating' => ['nullable', 'numeric', 'between:0,5'],
            'image' => [$product ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'description' => ['nullable', 'string', 'max:3000'],
        ]);

        $category = Category::findOrFail($data['category_id']);
        $brand = Brand::findOrFail($data['brand_id']);

        if (!$product || $product->name !== $data['name']) {
            $data['slug'] = $this->uniqueSlug($data['name'], 'products', $product?->id);
        }

        if (!$product || $product->name !== $data['name'] || !$product->sku) {
            $data['sku'] = $this->uniqueSku($data['name'], $product?->id);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->storePubliclyAs(
                'uploads/images',
                Str::uuid().'.'.$image->extension(),
                'uploads'
            );

            if ($path === false) {
                throw new \RuntimeException('Unable to store the uploaded product image.');
            }

            $data['image'] = $path;
        } elseif ($product) {
            unset($data['image']);
        }

        $data['category'] = $category->name;
        $data['brand'] = $brand->name;
        $data['is_active'] = $request->boolean('is_active');

        if ($product) {
            $product->update($data);
        } else {
            Product::create($data);
        }
    }

    private function uniqueSku(string $name, ?int $ignoreId = null): string
    {
        $base = substr(Str::upper(Str::slug($name) ?: 'PRODUCT'), 0, 76);
        $sku = 'JPL-'.$base;
        $suffix = 2;

        while (DB::table('products')->where('sku', $sku)->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))->exists()) {
            $suffixText = '-'.$suffix++;
            $sku = 'JPL-'.substr($base, 0, 80 - 4 - strlen($suffixText)).$suffixText;
        }

        return $sku;
    }

    private function uniqueSlug(string $name, string $table, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'catalog-item';
        $slug = $base;
        $suffix = 2;

        while (DB::table($table)->where('slug', $slug)->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
