<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //Login
    public function loginForm() {
        $route = "Sign up";
        return view('Auth.login', compact('route'));
    }

    public function authenticate(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ]);


        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                return redirect()->route('admin-dashboard')->with('success', "$user->name Successfully Logged in");
            }
            else if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::guard('customer')->user();
                return redirect()->route('customer-dashboard')->with('success', "$user->name Successfully Logged in");
            }
            elseif (Auth::guard('tailor')->attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::guard('tailor')->user();
                return redirect()->route('tailor-dashboard')->with('success', "$user->name Successfully Logged in");
            }
            else {
                return redirect()->back()->with('error', 'Invalid credentials');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Message: " . $e->getMessage());
        }
    }




    //Register
    public function registerForm() {
        $route = "Login";
        return view('Auth.register', compact('route'));
    }



    public function userStore(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'phone' => 'required',
            'address' => 'required',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $validated = $validator->validated();

        try {

            $validated['password'] = Hash::make($validated['password']);


            Customer::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
            ]);

            return redirect()->route('loginForm')->with('success', 'Customer Created Successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }



    public function logout() {
        if(Auth::guard('customer')->check()) {
            Auth::guard('customer')->logout();
            session()->invalidate();
            session()->regenerateToken();
        } elseif(Auth::guard('tailor')->check()) {
            Auth::guard('tailor')->logout();
            session()->invalidate();
            session()->regenerateToken();
        } else {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
        }


        return redirect()->route('loginForm');
    }
}
