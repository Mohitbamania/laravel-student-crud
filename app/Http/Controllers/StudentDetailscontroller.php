<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\student;
use Illuminate\Support\Facades\Validator;

class StudentDetailscontroller extends Controller
{
    public function index()
    {

        $students = student::all();

        return view('student_details.create', compact('students'));
    }

    public function store(Request $request)
    {

        try {

            $valiodator = Validator::make($request->all(), [

                'name' => 'required|string|max:255',
                'enrollement_no' => 'required|integer|unique:students,enrollement_no',
                'gender' => 'required|in:Male,Female,Other',
                'mobile_number' => 'required|digits:10|unique:students,mobile_number',
                'email_id' => 'required|email|unique:students,email_id',
                'password' => 'required|string|min:6',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($valiodator->fails()) {
                return redirect()->back()->withErrors($valiodator)->withInput();
            }

            $data['name'] = $request->name;
            $data['enrollement_no'] = $request->enrollement_no;
            $data['gender'] = $request->gender;
            $data['mobile_number'] = $request->mobile_number;
            $data['email_id'] = $request->email_id;
            $data['password'] = bcrypt($request->password);

            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $extension = $imageFile->getClientOriginalExtension();
                $time = Carbon::now()->timestamp;
                $imageName = $request->name . $time . '.' . $extension;

                $storagePath = public_path('storage/images/' . $imageName);

                file_put_contents($storagePath, file_get_contents($imageFile));


                $data['image'] = 'images/' . $imageName;
            } else {
                $data['image'] = null;
            }

            student::create($data);

            return redirect()->back()->with('success', 'Student Details Added Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {

        try {

            $valiodator = Validator::make($request->all(), [

                'id' => 'required|exists:students,id',
                'name' => 'required|string|max:255',
                'enrollement_no' => 'required|integer',
                'gender' => 'required|in:Male,Female,Other',
                'mobile_number' => 'required|digits:10',
                'email_id' => 'required|email',
                'password' => 'required|string|min:6',
                'image' => 'nullble|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($valiodator->fails()) {
                return redirect()->back()->withErrors($valiodator)->withInput();
            }

            $student = student::findOrFail($request->id);

            if (!$student) {
                return redirect()->back()->with('error', 'Student not found');
            }

            $data['name'] = $request->name;
            $data['enrollement_no'] = $request->enrollement_no;
            $data['gender'] = $request->gender;
            $data['mobile_number'] = $request->mobile_number;
            $data['email_id'] = $request->email_id;
            $data['password'] = bcrypt($request->password);

            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $extension = $imageFile->getClientOriginalExtension();
                $time = Carbon::now()->timestamp;
                $imageName = $request->name . $time . '.' . $extension;

                $storagePath = public_path('storage/images/' . $imageName);

                file_put_contents($storagePath, file_get_contents($imageFile));


                $data['image'] = 'images/' . $imageName;
            } else {
                $data['image'] = $student->image; // Keep the existing image if not updated 
            }

            $student->update($data);

            return redirect()->back()->with('success', 'Student Details Updated Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }

    }

    public function delete(Request $request)
    {

        try {

            $student = student::findOrFail($request->id);

            if (!$student) {
                return redirect()->back()->with('error', 'Student not found');
            }

            $student->delete();
            return redirect()->back()->with('success', 'Student Details Deleted Successfully');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', ' An Error Occured While deleting Student: ' . $e->getMessage());
        }
    }
}
