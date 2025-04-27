<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Stitch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function customerDashboard() {
        $user = Auth::guard('customer')->user();
        $stitches = Stitch::where('customer_id', $user->id)->get();
        return view('customer.customer-dashboard', compact('stitches', 'user'));
    }

    public function stitchStore(Request $request) {
        $customer = Auth::guard('customer')->user();
        $customerId = $customer->id;
        $validator = Validator::make($request->all(), [
            'garment_name' => 'required',
            'section' => 'required',
            'start_time' => 'required',
        ]);


        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        try {
            Stitch::create([
                'garment_name' => $validated['garment_name'],
                'section_name' => $validated['section'],
                'tailor_id' => null,
                'customer_id' => $customerId,
                'start_time' => $validated['start_time'],
                'status' => 'Not Started',
                'completed_time' => null,
            ]);

            return redirect()->route('customer-stitch')->with('success', 'Stitch Created Successfully!');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', "Message: .$e");
        }
    }

    public function stitchUpdate(Request $request, $id) {
        $stitch = Stitch::findorFail($id);

        $validator = Validator::make($request->all(), [
            'garment_name' => 'required',
            'section' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $stitch->update([
            'garment_name' => $validated['garment_name'],
            'section_name' => $validated['section'],
        ]);

        return redirect()->route('customer-stitch')->with('success', 'Stitches Updated Successfully!');
    }

    public function stitchIndex() {
        $customerId = Auth::guard('customer')->id();
        $stitches = Stitch::where('customer_id', $customerId)->get();
        return view('customer.stitch-order', compact('stitches'));
    }

    public function delete($id) {
        $stitch = Stitch::findorFail($id);
        $stitch->delete();
        return redirect()->route('customer-stitch')->with('success', 'Order Deleted Successfully!');
    }

}
