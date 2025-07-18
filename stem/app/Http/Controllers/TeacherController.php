<?php

namespace App\Http\Controllers;

use App\Http\Requests\Teacher\StoreTeacherRequest;
use App\Http\Requests\Teacher\UpdateTeacherRequest;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TeacherController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;
        $isSuperAdmin = $user->role_id === 2;

        $teachersQuery = Teacher::query();
        $teachersQuery->with('subject:id,name', 'tenant:id,name');

        $selectFields = [
            'id',
            'tenant_id',
            'subject_id',
            'first_name',
            'last_name',
            'gender',
            'hire_date',
        ];

        if ($isNormalAdmin) {
            $teachersQuery->where('tenant_id', $user->tenant_id);
        }

        $teachers = $teachersQuery->select($selectFields)->get();

        $availableTenants = collect();
        if ($isSuperAdmin) {
            $availableTenants = Tenant::select('id', 'name')->orderBy('name')->get();
        }

        $availableSubjects = Subject::select('id', 'name')->orderBy('name')->get();

        return Inertia::render('Teachers/Index', [
            'teachers' => $teachers,
            'availableTenants' => $availableTenants,
            'availableSubjects' => $availableSubjects,
            'isSuperAdmin' => $isSuperAdmin,
        ]);
    }

    public function create()
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;

        $availableTenants = $isNormalAdmin ? collect() : Tenant::select('id', 'name')->get();
        $availableSubjects = Subject::select('id', 'name')->get();

        return Inertia::render('Teachers/Create', [
            'availableTenants' => $availableTenants,
            'availableSubjects' => $availableSubjects,
            'isNormalAdmin' => $isNormalAdmin,
        ]);
    }

    public function store(StoreTeacherRequest $request)
    {
        $user = Auth::user();
        $tenantId = $user->role_id === 1 ? $user->tenant_id : $request->input('tenant_id');

        $request->merge(['tenant_id' => $tenantId]);

        $validated = $request->validated();
        Teacher::create($validated);

        return Redirect::route('teachers.index')->with('message', 'Teacher created successfully.');
    }

    public function show(Teacher $teacher)
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;

        $teacher->load(['subject:id,name']);

        if ($isNormalAdmin) {
            $teacher->setRelation('tenant', null);
        } else {
            $teacher->load(['tenant:id,name']);
        }

        return Inertia::render('Teachers/Show', [
            'teacher' => $teacher,
            'isNormalAdmin' => $isNormalAdmin,
        ]);
    }

    public function edit(Teacher $teacher)
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;

        $availableTenants = $isNormalAdmin ? collect() : Tenant::select('id', 'name')->get();
        $availableSubjects = Subject::select('id', 'name')->get();

        return Inertia::render('Teachers/Edit', [
            'teacher' => $teacher->toArray(),
            'availableTenants' => $availableTenants->toArray(),
            'availableSubjects' => $availableSubjects->toArray(),
            'isNormalAdmin' => $isNormalAdmin,
        ]);
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        $teacher->update($request->validated());

        return Redirect::route('teachers.index')->with('message', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return Redirect::route('teachers.index')->with('message', 'Teacher deleted successfully.');
    }
}
