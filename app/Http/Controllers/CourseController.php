<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CourseController;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
 
    public function index()
    {
        $courses = Course::where('user_id', Auth::id())->get();
        return response()->json($courses, 200);
        
    }

  
    public function store(Request $request)
    {
        
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
        //
    }

 
}
