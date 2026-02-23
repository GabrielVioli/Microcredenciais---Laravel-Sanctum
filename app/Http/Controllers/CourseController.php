<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CourseController;
use App\Models\Course;
use App\Models\Credential;

use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
 
    public function index()
    {
        $courses = Course::where('user_id', Auth::id())->get();
        return response()->json($courses, 200);
        
    }

  
    public function credentials($id) {
    $course = Course::findOrFail($id);

    $studentsWithBadges = Credential::where('course_id', $id)
        ->whereNotNull('token')
        ->with('student')
        ->get()
        ->pluck('student');

        return response()->json([
            'course' => $course->name,
            'students' => $studentsWithBadges
        ], 200);
    }
    

    public function show(string $id)
    {
        $course = Course::findOrFail($id);

        if($course) {
            return response()->json($course, 200);
        }

        return response()->json(['message' => "erro"], 400);

    }

  
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'workload' => 'required|integer|min:1',
        ]);

        $course = Course::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$course) {
            return response()->json(['message' => 'Curso não encontrado ou acesso negado.'], 404);
        }

        $course->update($validatedData);

        return response()->json([
            'message' => 'Curso atualizado com sucesso!',
            'data' => $course
        ], 200);
    }
 
}
