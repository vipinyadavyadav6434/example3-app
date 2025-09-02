<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers|unique:vendors',
            'password' => 'required|string|min:8|confirmed',
            'user_type' => 'required|in:vendor,customer',
            'phone' => 'nullable|string|max:20',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->user_type === 'vendor') {
            $request->validate([
                'specialization' => 'nullable|string|max:255',
                'hourly_rate' => 'nullable|numeric|min:0',
            ]);

            $data['specialization'] = $request->specialization;
            $data['hourly_rate'] = $request->hourly_rate;
            $data['description'] = $request->description;

            $user = Vendor::create($data);
        } else {
            $data['address'] = $request->address;
            $user = Customer::create($data);
        }

        Session::put('user_id', $user->id);
        Session::put('user_type', $request->user_type);

        return redirect()->route('dashboard');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'user_type' => 'required|in:vendor,customer',
        ]);

        $model = $request->user_type === 'vendor' ? Vendor::class : Customer::class;
        $user = $model::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        Session::put('user_id', $user->id);
        Session::put('user_type', $request->user_type);

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        Session::forget(['user_id', 'user_type']);
        return redirect()->route('login');
    }
}
