<?php

namespace App\Http\Controllers;

use App\Http\Requests\Enrollment\StoreEnrollmentRequest;
use App\Http\Requests\Enrollment\UpdateEnrollmentRequest;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class EnrollmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;
        $isSuperAdmin = $user->role_id === 2;

        $query = Enrollment::query()->with([
            'student:id,first_name,last_name',
            'course:id,name',
            'tenant:id,name'
        ]);

        $selectFields = ['id', 'tenant_id', 'student_id', 'course_id', 'fee'];

        if ($isNormalAdmin) {
            $query->where('tenant_id', $user->tenant_id);
        }

        $enrollments = $query->select($selectFields)->get();

        $availableTenants = $isSuperAdmin ? Tenant::select('id', 'name')->orderBy('name')->get() : collect();

        return Inertia::render('Enrollments/Index', [
            'flash' => ['message' => session('message')],
            'enrollments' => $enrollments ?: [],
            'availableTenants' => $availableTenants,
            'availableStudents' => Student::select('id', 'first_name', 'last_name')->orderBy('first_name')->get() ?: [],
            'availableCourses' => Course::select('id', 'name')->orderBy('name')->get() ?: [],
            'isSuperAdmin' => $isSuperAdmin,
        ]);
    }

    public function create()
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;

        $availableTenants = $isNormalAdmin ? collect() : Tenant::select('id', 'name')->orderBy('name')->get();
        $availableStudents = Student::select('id', 'first_name', 'last_name')->orderBy('first_name')->get();
        $availableCourses = Course::select('id', 'name')->orderBy('name')->get();

        return Inertia::render('Enrollments/Create', [
            'availableTenants' => $availableTenants,
            'availableStudents' => $availableStudents,
            'availableCourses' => $availableCourses,
            'isNormalAdmin' => $isNormalAdmin,
        ]);
    }

    public function store(StoreEnrollmentRequest $request)
    {
        $user = Auth::user();

        $tenantId = $user->tenant_id ?? $request->input('tenant_id');
        $request->merge(['tenant_id' => $tenantId]);
        Enrollment::create($request->all());

        return Redirect::route('enrollments.index')->with('message', 'Enrollment created successfully.');
    }

    public function show(Enrollment $enrollment)
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;

        $enrollment->load([
            'student:id,first_name,last_name',
            'course:id,name'
        ]);

        if ($isNormalAdmin) {
            $enrollment->setRelation('tenant', null);
        } else {
            $enrollment->load(['tenant:id,name']);
        }

        return Inertia::render('Enrollments/Show', [
            'enrollment' => $enrollment,
            'isNormalAdmin' => $isNormalAdmin,
        ]);
    }

    public function edit(Enrollment $enrollment)
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;

        $availableTenants = $isNormalAdmin ? collect() : Tenant::select('id', 'name')->orderBy('name')->get();
        $availableStudents = Student::select('id', 'first_name', 'last_name')->orderBy('first_name')->get();
        $availableCourses = Course::select('id', 'name')->orderBy('name')->get();

        return Inertia::render('Enrollments/Edit', [
            'enrollment' => $enrollment->toArray(),
            'availableTenants' => $availableTenants->toArray(),
            'availableStudents' => $availableStudents->toArray(),
            'availableCourses' => $availableCourses->toArray(),
            'isNormalAdmin' => $isNormalAdmin,
        ]);
    }

    public function update(UpdateEnrollmentRequest $request, Enrollment $enrollment)
    {
        $enrollment->update($request->validated());

        return Redirect::route('enrollments.index')->with('message', 'Enrollment updated successfully.');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return Redirect::route('enrollments.index')->with('message', 'Enrollment deleted successfully.');
    }
}
