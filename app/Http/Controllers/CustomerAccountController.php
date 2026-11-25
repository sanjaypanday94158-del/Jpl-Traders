<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Services\OrderCancellationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CustomerAccountController extends Controller
{
    public function loginForm()
    {
        if (Auth::check()) {
            return redirect()->route('account.index');
        }

        return view('shop.customer-login');
    }

    public function login(Request $request)
    {
        $request->merge(['email' => strtolower(trim((string) $request->input('email', '')))]);
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($data, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'The email or password is incorrect.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route($request->input('next') === 'checkout' ? 'checkout' : 'account.index');
    }

    public function registerForm()
    {
        if (Auth::check()) {
            return redirect()->route('account.index');
        }

        return view('shop.customer-register');
    }

    public function register(Request $request)
    {
        $request->merge(['email' => strtolower(trim((string) $request->input('email', '')))]);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:8', 'max:200', 'confirmed'],
        ]);

        $customer = User::create([
            'name' => $data['name'],
            'email' => strtolower($data['email']),
            'phone' => $data['phone'] ?? null,
            'password' => $data['password'],
        ]);
        Auth::login($customer);
        $request->session()->regenerate();

        return redirect()->route($request->input('next') === 'checkout' ? 'checkout' : 'account.index')
            ->with('success', 'Your account is ready.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function index(Request $request)
    {
        $orders = $request->user()->orders()->with('items')->latest()->paginate(10);

        return view('shop.account', compact('orders'));
    }

    public function order(Request $request, string $orderNumber)
    {
        $order = $request->user()->orders()
            ->with(['items', 'events'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('shop.account-order', compact('order'));
    }

    public function cancelOrder(Request $request, OrderCancellationService $cancellations, string $orderNumber)
    {
        $order = $request->user()->orders()
            ->where('order_number', $orderNumber)
            ->firstOrFail();
        $data = $request->validate([
            'reason' => ['required', 'string', 'max:1000'],
        ]);

        $result = $cancellations->cancelByCustomer(
            (int) $order->id,
            'Customer #'.$request->user()->id,
            $data['reason']
        );

        if ($result === 'cancelled') {
            return redirect()->route('account.orders.show', $orderNumber)
                ->with('success', 'Your order has been cancelled.');
        }

        return redirect()->route('account.orders.show', $orderNumber)
            ->withErrors(['cancellation' => 'This order can no longer be cancelled.']);
    }
}
