<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Credential;
use App\Models\Course;
use App\Models\User;


class StudentController extends Controller
{

  
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email:rfc,dns|unique:students,email',
            'phone'   => 'nullable|string|size:13',
            'address' => 'nullable|string|max:255',
            'gender'  => 'required|string|size:1'
        ]);

        $studentCreate = Student::create($validateData);

        if(!$studentCreate) {
            return response()->json([
                'message' => "nao foi possivel criar esse usuario",
            ], 400);
        }

        return response()->json([
            'message' => 'success',
            'data' => $studentCreate
        ]);
    }


    public function show(string $id)
    {
        $student = Student::findOrFail($id);

        return response()->json([
            'message' => "Sucess",
            'data' => $student
        ], 200);


    }

   
    public function update(Request $request, string $id)
    {
      $validatedData = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email:rfc,dns|unique:students,email,' . $id,
            'phone'   => 'nullable|string|size:13',
            'address' => 'nullable|string|max:255',
            'gender'  => 'required|string|size:1'
        ], [
            'email.unique' => 'Este email já está cadastrado.',
        ]);

        $studentId = Student::findOrFail($id);
        $studentId->update($validatedData);

        return response()->json([
            'message' => 'Cadastro do aluno atualizado com sucesso!',
            'data'    => $studentId
        ], 200);
    }


}
