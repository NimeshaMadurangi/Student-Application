<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Domain\Facades\StudentFacade;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class StudentController extends Controller
{
    public function create()
    {
        return Inertia::render('StudentForm');
    }

    public function store(Request $request)
    {
        {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'age' => 'required|integer',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'required|string|max:255',
            ]);
    
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time().'.'.$image->extension();
                $image->move(public_path('images'), $imageName);
                $validatedData['image'] = $imageName;
            }
    
            Student::create($validatedData);
    
            return redirect()->route('dashboard')->with('success', 'Student added successfully');
        }
    }

    public function view()
    {
        return Inertia::render('Index');
    }

    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return response()->json(['message' => 'Student deleted successfully']);
    }

    public function updateStatus(Request $request, $id)
    {
            $validatedData = $request->validate([
                'status' => 'required|in:active,inactive',
            ]);

            $student = Student::findOrFail($id);
            $student->status = $validatedData['status'];
            $student->save();

            return response()->json(['message' => 'Student status updated successfully']);
    }

    public function edit(Request $request)
    {
        $studentId = $request->query('id');
        $student = Student::findOrFail($studentId);
        return view('edit-student')->with('student', $student);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->update($request->all());
        return response()->json(['message' => 'Student updated successfully']);
    }

}
