<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Student::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ], [
            'required' => "You need to fill :attribute,"
        ]);
        if ($validated->fails()) {
            return response()->json($validated->messages(), 422);
        } else {
            $student = Student::create($request->all());
            return response()->json($student, 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $student = Student::findOrFail($id);
            return response()->json([
                'data' => $student
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'student$student not found with id ' . $id
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ], [
            'required' => "You need to fill :attribute,"
        ]);
        if ($validated->fails()) {
            return response()->json($validated->messages(), 422);
        } else {
            try {
                $student = Student::findOrFail($id);
                $student->update($request->all());
                return response()->json($student, 200);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'error' => 'Student not found with id ' . $id
                ], 404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $student = Student::findOrFail($id);
            $student->delete();
            return response()->json(["message" => "Successfully deleted"]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Student not found with id ' . $id
            ], 404);
        }
    }
}
