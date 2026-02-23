<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function index()
    {

    }

    public function verifyBadge($hash) {

        $credential = Credential::where('token', $hash)->first();

        if($credential) {
            $courseData = Course::find($credential->course_id);
            $studentData = Student::find($credential->student_id);

            return response()->json([
                'messsage' => "Aluno credenciado",
                'Student_information' => $studentData,
                'course_information' => $courseData
            ], 200);
        }

        return response()->json([
            'message' => 'Badge não encontrado ou inválido'
        ], 404);
    }


    public function credentials(Request $request)
    {
        $validatedData = $request->validate([
            "name" => "required|string|max:255|exists:students,name",
            "email" => "required|string|email|max:255|exists:students,email",
            "course" => "required|integer|exists:courses,id"
            ],
            [
                'name.exists' => 'O aluno informado não foi encontrado na base de dados.',
                'email.exists' => 'O e-mail informado não pertence a nenhum aluno cadastrado.',
                'course.exists' => 'O ID do curso informado não existe no sistema.',
                'required' => 'O campo :attribute é obrigatório.'
            ]
        );

   

        $student = Student::where('email', $validatedData['email'])->firstOrFail();
        $course = Course::findOrFail($validatedData['course']);

    
        
        $userId = Auth::id();

        $badgeCode = Str::uuid()->toString();

        $credential = Credential::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'user_id' => $userId,
            'token' => $badgeCode,
        ]);

        return response()->json([
            'message' => 'Credencial criada com sucesso!',
            'token' => $badgeCode
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
                'token' => $createUser->createToken('auth_token')->plainTextToken
            ], 201);


        }

        return response()->json([
            'message' => 'failed to create a user',
        ], 400);

    }


    public function login(Request $request) {
        $data = $request->validate([
            "email" => "required|string|email|max:255",
            "password" => "required|string|min:8",
        ]);

        if(Auth::attempt($data)) {
        $user = Auth::user();

            return response()->json([
                'message' => "authenticable",
                'data' => Auth::user(),
                'token' =>  $user->createToken('auth_token')->plainTextToken
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
