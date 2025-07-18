<?php

namespace App\Http\Controllers;

use App\Http\Requests\Schedule\StoreScheduleRequest;
use App\Http\Requests\Schedule\UpdateScheduleRequest;
use App\Models\Schedule;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the schedules.
     */
    public function index()
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;
        $isSuperAdmin = $user->role_id === 2;

        $schedulesQuery = Schedule::query();
        $schedulesQuery->with('tenant:id,name');

        $selectFields = [
            'id',
            'tenant_id',
            'start_date',
            'end_date',
            'start_time',
            'end_time',
            'day_of_week',
        ];

        if ($isNormalAdmin) {
            $schedulesQuery->where('tenant_id', $user->tenant_id);
        }

        $schedules = $schedulesQuery->select($selectFields)->get();

        $availableTenants = collect();
        if ($isSuperAdmin) {
            $availableTenants = Tenant::select('id', 'name')->orderBy('name')->get();
        }

        return Inertia::render('Schedules/Index', [
            'schedules' => $schedules,
            'availableTenants' => $availableTenants,
            'isSuperAdmin' => $isSuperAdmin,
        ]);
    }

    /**
     * Show the form for creating a new schedule.
     */
    public function create()
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;

        $availableTenants = $isNormalAdmin ? collect() : Tenant::select('id', 'name')->get();

        return Inertia::render('Schedules/Create', [
            'availableTenants' => $availableTenants,
            'isNormalAdmin' => $isNormalAdmin,
        ]);
    }

    /**
     * Store a newly created schedule in storage.
     */
    public function store(StoreScheduleRequest $request)
    {
        $user = Auth::user();
        $tenantId = $user->role_id === 1 ? $user->tenant_id : $request->input('tenant_id');

        $request->merge(['tenant_id' => $tenantId]);

        $validated = $request->validated();
        Schedule::create($validated);

        return Redirect::route('schedules.index')->with('message', 'Schedule created successfully.');
    }

    /**
     * Display the specified schedule.
     */
    public function show(Schedule $schedule)
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;

        if ($isNormalAdmin) {
            $schedule->setRelation('tenant', null);
        } else {
            $schedule->load(['tenant:id,name']);
        }

        return Inertia::render('Schedules/Show', [
            'schedule' => $schedule,
            'isNormalAdmin' => $isNormalAdmin,
        ]);
    }

    /**
     * Show the form for editing the specified schedule.
     */
    public function edit(Schedule $schedule)
    {
        $user = Auth::user();
        $isNormalAdmin = $user->role_id === 1;

        $availableTenants = $isNormalAdmin ? collect() : Tenant::select('id', 'name')->get();

        return Inertia::render('Schedules/Edit', [
            'schedule' => $schedule->toArray(),
            'availableTenants' => $availableTenants->toArray(),
            'isNormalAdmin' => $isNormalAdmin,
        ]);
    }

    /**
     * Update the specified schedule in storage.
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $user = Auth::user();
        $tenantId = $user->role_id === 1 ? $user->tenant_id : $request->input('tenant_id');

        $request->merge(['tenant_id' => $tenantId]);

        $schedule->update($request->validated());

        return Redirect::route('schedules.index')->with('message', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified schedule from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return Redirect::route('schedules.index')->with('message', 'Schedule deleted successfully.');
    }
}
