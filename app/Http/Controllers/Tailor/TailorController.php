<?php

namespace App\Http\Controllers\Tailor;

use App\Http\Controllers\Controller;
use App\Models\Stitch;
use App\Models\Tailor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TailorController extends Controller
{
    public function tailorDashboard() {
        $user = Auth::guard('tailor')->user();
        $pendingStitches = Stitch::where('tailor_id', $user->id)->where('status', 'Not Started')->count();
        $inProgressStitches = Stitch::where('tailor_id', $user->id)->where('status', 'In Progress')->count();
        $completedStitches = Stitch::where('tailor_id', $user->id)->where('status', 'Completed')->count();
        $recentStitches = Stitch::where('tailor_id', $user->id)->latest()->take(5)->get();
        return view('tailor.tailor-dashboard', compact('pendingStitches', 'inProgressStitches', 'completedStitches', 'recentStitches'));
    }


    public function stitchIndex() {
        $user = Auth::guard('tailor')->user();
        $stitches = Stitch::with('customer')->where('tailor_id', $user->id)->get();
        return view('tailor.tailor-stitch', compact('stitches'));
    }


    public function tailorStore(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:tailors,email',
            'phone' => 'required',
            'password' => 'required',
        ]);


        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        try {
            $validated['password'] = Hash::make($validated['password']);
            Tailor::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => $validated['password']
            ]);

            return redirect()->route('admin-tailor')->with('success', 'Tailor Created Successfully!');

        } catch(\Exception $e) {
            return redirect()->back()->with('error', "Message: ". $e->getMessage());
        }

    }

    public function stitchUpdate(Request $request, $id) {
        $stitch = Stitch::findorFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);

        $validated = $validator->validated();

        $stitch->status = $validated['status'];

        if ($stitch->status == 'Completed') {
            $stitch->completed_time = now();
        } else {
            $stitch->completed_time = null;
        }

        $stitch->save();

        return redirect()->route('tailor-stitch')->with('success', 'Stitch Updated Successfully!');
    }

}
