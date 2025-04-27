<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Stitch;
use App\Models\Tailor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function dashboard() {
        $activeStitches = Stitch::where('status', '!=', 'Completed')->count();
        $currentTailors = Tailor::count();
        $inProgressStitch = Stitch::where('status', '=', 'In Progress')->count();
        $customers = Customer::count();

        $stitches = Stitch::all();

        $stitchStatusCounts = [
            'Not Started' => $stitches->where('status', 'Not Started')->count(),
            'In Progress' => $stitches->where('status', 'In Progress')->count(),
            'Completed' => $stitches->where('status', 'Completed')->count(),
        ];

        $stitchesLastMonth = Stitch::
        where('created_at', '>=', now()->subDays(30))
        ->get()
        ->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('W');
        });

        $weeklyCounts = [];
        foreach (range(now()->subWeeks(3)->format('W'), now()->format('W')) as $week) {
            $weeklyCounts[] = $stitchesLastMonth->has($week) ? $stitchesLastMonth[$week]->count() : 0;
        }

        return view('admin.dashboard',compact('activeStitches', 'currentTailors', 'inProgressStitch', 'customers', 'stitchStatusCounts', 'weeklyCounts', 'stitches'));
    }



    public function indexStitch() {
        $tailors = Tailor::all();
        $stitches = Stitch::with('customer')->get();
        return view('admin.stitches.stitches-index', compact('stitches', 'tailors'));
    }



    public function stitchAssign(Request $request, $id)
    {
        $stitch = Stitch::findorFail($id);

        $validator = Validator::make($request->all(), [
            'tailor_id' => 'required',
        ]);

        $validated = $validator->validated();

        $stitch->tailor_id = $validated['tailor_id'];

        $stitch->save();

        return redirect()->route('admin-stitch')->with('success', 'Stitch updated.');
    }

    public function indexCustomer() {
        $customers = Customer::all();
        return view('admin.customer-index', compact('customers'));
    }

    public function indexTailor() {
        $tailors = Tailor::all();
        return view('admin.tailor-index', compact('tailors'));
    }

    public function delete($id) {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin-customer')->with('success', 'Customer Successfully Deleted!');
    }


    public function tailorDelete($id) {
        $tailor = Tailor::findOrFail($id);
        $tailor->delete();
        return redirect()->route('admin-tailor')->with('success', 'Tailor Succesfully Deleted!');
    }

    public function tailorUpdate(Request $request, $id) {
        $tailor = Tailor::findOrFail($id);

        $validator =  Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|exists:tailors,email',
            'phone' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $tailor->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone']
        ]);

        return redirect()->route('admin-tailor')->with('success', 'Tailor Updated Successfully!');
    }

}
