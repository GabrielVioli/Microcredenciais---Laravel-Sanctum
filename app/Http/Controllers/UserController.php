<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    public function index()
    {

    }

    public function verifyBadge($hash) {

    }


    public function credentials(Request $request)
    {
        $validatedData = $request->validate([
            "Name" => "required|string|max:255",
            "email" => "required|string|email|max:255",
            "course" => "required|string|max:255",
        ]);

        $student = Student::where('email', $validatedData['email'])->firstOrFail();
        $course = Course::where('name', $validatedData['course'])->firstOrFail();

        $user = Auth::user()->id();

        $token = $user->createToken('auth_token')->plainTextToken;

        $credential = Credential::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'token' => $token,
            'user_id' => $user
        ]);

        return response()->json([
            'message' => 'Credencial criada com sucesso!',
            'token' => $token
        ], 201);
    }

    public function store(Request $request)
    {

        $userValidate = $request->validate([
            "name" => 'required|string|max:255',
            "email" => 'required|string|email|max:255|unique:users',
            "password" => 'required|string|min:8',
        ]);



        $userValidate['password'] = Hash::make($userValidate['password']);
        $createUser = User::create($userValidate);

        if($createUser) {
            return response()->json([
                'message' => 'success to create a user',
                'data' => $createUser,
            ], 201);
        }

        return response()->json([
            'message' => 'failed to create a user',
        ], 400);

    }


    public function login(Request $request) {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255",
            "password" => "required|string|min:8",
        ]);

        if(Auth::attempt($data)) {
            return response()->json([
                'message' => "authenticable",
                'data' => Auth::user(),
            ], 200);
        }

        return response()->json([
            'message' => 'failed to authenticable',
        ], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
