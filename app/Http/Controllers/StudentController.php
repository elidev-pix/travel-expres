<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        // récupérer la ligne 'table_students' liée à l'utilisateur (peut être null)
        $student = $user->student ?? new Student();

        return view('studentDashboard', [
            'user' => Auth::user(),
            'student' => $student
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('studentDashboard');
    }

    public function getForm($type)
    {
        $forms = [
            'program' => 'profile.partials.register.program-form',
            'identity' => 'profile.partials.register.identity-form',
            'identification' => 'profile.partials.register.identification-form',
            'health' => 'profile.partials.register.health-form',
            'personal' => 'profile.partials.register.personal-form',
        ];

        if (!array_key_exists($type, $forms)) {
            return response()->json(['error' => 'Formulaire non trouvé'], 404);
        }

        return view($forms[$type], ['type' => $type]);
    }

    public function storeForm(Request $request, $type)
    {
        
        switch ($type) {
            case 'identity':
                $rules = [
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    // student_code is optional on identity form; keep uniqueness if provided
                    'student_code' => ['nullable', 'string', 'max:10', 'unique:table_students,student_code,' . (Auth::user()->student->id ?? 'null') . ',id,user_id,' . Auth::id()],
                ];
                break;
            case 'personal':
                $rules = [
                    'gender' => ['nullable', 'string'],
                    'dob' => ['nullable', 'date'],
                    'address' => ['nullable', 'string'],
                    'phone' => ['nullable', 'string'],
                ];
                break;
            case 'identification':
                $rules = [
                    'passport_number' => ['nullable', 'string'],
                    'cnib_number' => ['nullable', 'string'],
                    'nationality' => ['nullable', 'string'],
                    'phone' => ['nullable', 'string'],
                ];
                break;
            case 'health':
                $rules = [
                    'height' => ['nullable', 'string'],
                    'weight' => ['nullable', 'string'],
                    'medical_history' => ['nullable', 'string'],
                ];
                break;
            case 'program':
                $rules = [
                    'university' => ['nullable', 'string', 'max:255'],
                    'program' => ['nullable', 'string', 'max:255'],
                    'level' => ['nullable', 'string', 'max:255'],
                    'academic_year' => ['nullable', 'string', 'max:255'],
                    'city' => ['nullable', 'string', 'max:255'],
                ];
                break;
            default:
                return redirect()->back()->with('error', 'Type de formulaire invalide.');
        }

        $validated = $request->validate($rules);

        // create or update linked student row
        $student = Student::updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        // ensure user_id is set (harmless if already set via mass assignment)
        $student->user_id = Auth::id();
        $student->save();

        return redirect()->route('studentDashboard')->with('success', 'Formulaire enregistré avec succès.');
    }

    /* Store a newly created resource in storage.   
    public function store(Request $request)
*/
    
    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('studentUpdate', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {

        $student->update([
            'student_code' => $request->student_code,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'nationality' => $request->nationality,
            'address' => $request->address,
            'university' => $request->university,
            'program' => $request->program,
            'level' => $request->level,
            'academic_year' => $request->academic_year,
            'city' => $request->city,
            'passport_number' => $request->passport_number,
            'cnib_number' => $request->cnib_number
        ]);

        return redirect()->route('studentDashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('studentDashboard');
    }
}
