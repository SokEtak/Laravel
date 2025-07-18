<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;

        $coursesQuery = Course::query();
        $coursesQuery->with('subject:id,name', 'teacher:id,first_name,last_name');

        $selectFields = [
            'id',
            'tenant_id',
            'teacher_id',
            'subject_id',
            'name',
            'description',
            'level',
        ];

        if ($isNormalAdmin) {
            $coursesQuery->where('tenant_id', $user->tenant_id);
            $coursesQuery->with('tenant:id,name');
        } else {
            $coursesQuery->with('tenant:id,name');
        }

        $courses = $coursesQuery->select($selectFields)->get();

        $availableTenants = collect();
        if (!$isNormalAdmin) {
            $availableTenants = Tenant::select('id', 'name')->get();
        }

        $availableTeachers = Teacher::select('id', 'first_name', 'last_name')->get();
        $availableSubjects = Subject::select('id', 'name')->orderBy('name')->get();

        return Inertia::render('Courses/Index', [
            'courses' => $courses,
            'availableTenants' => $availableTenants,
            'availableTeachers' => $availableTeachers,
            'availableSubjects' => $availableSubjects,
            'isSuperAdmin' => !$isNormalAdmin,
        ]);
    }

    public function create()
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;

        $availableTenants = Tenant::select('id', 'name')->get();
        $availableTeachers = Teacher::select('id', 'first_name', 'last_name')->get();
        $availableSubjects = Subject::select('id', 'name')->get();

        return Inertia::render('Courses/Create', [
            'availableTenants' => $availableTenants,
            'availableTeachers' => $availableTeachers,
            'availableSubjects' => $availableSubjects,
            'isNormalAdmin' => $isNormalAdmin,
        ]);
    }

    public function store(StoreCourseRequest $request)
    {
        $user = Auth::user();

        $tenantId = $user->tenant_id ?? $request->input('tenant_id');

        $validated = $request->validated();
        $validated['tenant_id'] = $tenantId;

        Course::create($validated);

        return Redirect::route('courses.index')->with('message', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;

        $course->load(['subject:id,name', 'teacher:id,first_name,last_name']);

        if (!$isNormalAdmin) {
            $course->load(['tenant:id,name']);
        } else {
            $course->setRelation('tenant', null);
        }

        return Inertia::render('Courses/Show', [
            'course' => $course,
            'isNormalAdmin' => $isNormalAdmin,
        ]);
    }

    public function edit(Course $course)
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;

        $availableTenants = Tenant::select('id', 'name')->get();
        $availableTeachers = Teacher::select('id', 'first_name', 'last_name')->get();
        $availableSubjects = Subject::select('id', 'name')->get();

        return Inertia::render('Courses/Edit', [
            'course' => $course->toArray(),
            'availableTenants' => $availableTenants->toArray(),
            'availableTeachers' => $availableTeachers->toArray(),
            'availableSubjects' => $availableSubjects->toArray(),
            'isNormalAdmin' => $isNormalAdmin,
        ]);
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->validated());

        return Redirect::route('courses.index')->with('message', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return Redirect::route('courses.index')->with('message', 'Course deleted successfully.');
    }
}
