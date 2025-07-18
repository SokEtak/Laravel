<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Models\Student;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;

        $studentsQuery = Student::query();
        $commonSelectFields = ['id', 'first_name', 'last_name', 'gender', 'grade', 'dob', 'tenant_id'];

        if ($isNormalAdmin) {
            $studentsQuery->where('tenant_id', $user->tenant_id);
        }
        $studentsQuery->with(['tenant:id,name']);
        $students = $studentsQuery->select($commonSelectFields)->get();

        $availableTenants = $isNormalAdmin
            ? collect($user->tenant()->select('id', 'name')->first())->filter()
            : Tenant::select('id', 'name')->get();

        return Inertia::render('Students/Index', [
            'students' => $students,
            'availableTenants' => $availableTenants,
            'isSuperAdmin' => !$isNormalAdmin,
        ]);
    }

    public function create()
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;
        $availableTenants = $isNormalAdmin ? collect() : Tenant::select('id', 'name')->get();

        return Inertia::render('Students/Create', [
            'availableTenants' => $availableTenants,
            'isSuperAdmin' => !$isNormalAdmin,
        ]);
    }

    public function store(StoreStudentRequest $request)
    {
        $user = Auth::user();
        $validatedData = $request->validated();

        if ($user->role_id === 1) {
            $validatedData['tenant_id'] = $user->tenant_id;
        }

        Student::create($validatedData);

        return redirect()->route('students.index')->with('message', 'Student created successfully!');
    }

    public function show(Student $student)
    {
        $user = Auth::user();
        $student->load('tenant:id,name');

        return Inertia::render('Students/Show', [
            'student' => $student,
            'isSuperAdmin' => $user->role_id !== 1,
            'auth' => ['user' => $user->only('id', 'name', 'role_id')],
        ]);
    }

    public function edit(Student $student)
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;

        if ($isNormalAdmin && $student->tenant_id !== $user->tenant_id) {
            abort(403, 'Unauthorized action.');
        }

        $student->load('tenant:id,name');
        $availableTenants = $isNormalAdmin ? collect() : Tenant::select('id', 'name')->get();

        return Inertia::render('Students/Edit', [
            'student' => $student,
            'availableTenants' => $availableTenants,
            'isSuperAdmin' => !$isNormalAdmin,
        ]);
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;

        if ($isNormalAdmin && $student->tenant_id !== $user->tenant_id) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validated();
        if ($isNormalAdmin) {
            unset($validatedData['tenant_id']);
        }

        $student->update($validatedData);

        return redirect()->route('students.index')->with('message', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return Redirect::route('students.index')->with('message', 'Student deleted successfully.');
    }
}
