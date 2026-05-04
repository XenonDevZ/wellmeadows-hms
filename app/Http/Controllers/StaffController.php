<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffCategory;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the staff members.
     */
    public function index()
    {
        $staffMembers = Staff::with('category')->orderBy('staff_no')->paginate(10);
        return view('staff.index', compact('staffMembers'));
    }

    /**
     * Show the form for creating a new staff member.
     */
    public function create()
    {
        $categories = StaffCategory::all();
        return view('staff.create', compact('categories'));
    }

    /**
     * Store a newly created staff member in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_no' => 'required|string|unique:staff,staff_no',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'address' => 'required|string',
            'telephone_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'sex' => 'required|in:M,F',
            'nin' => 'required|string|unique:staff,nin|max:20',
            'position_category_id' => 'required|exists:staff_category,category_id',
            'current_salary' => 'required|numeric|min:0',
            'salary_scale' => 'required|string|max:50',
        ]);

        Staff::create($validated);

        return redirect()->route('staff.index')->with('success', 'Staff member added successfully.');
    }

    /**
     * Display the specified staff profile.
     */
    public function show($id)
    {
        $staff = Staff::with(['category', 'qualifications', 'workExperiences', 'managedWards'])->findOrFail($id);
        return view('staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified staff member.
     */
    public function edit($id)
    {
        $staff = Staff::findOrFail($id);
        $categories = StaffCategory::all();
        return view('staff.edit', compact('staff', 'categories'));
    }

    /**
     * Update the specified staff member in storage.
     */
    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'address' => 'required|string',
            'telephone_number' => 'required|string|max:20',
            'position_category_id' => 'required|exists:staff_category,category_id',
            'current_salary' => 'required|numeric|min:0',
            'salary_scale' => 'required|string|max:50',
        ]);

        $staff->update($validated);

        return redirect()->route('staff.show', $staff->staff_no)->with('success', 'Staff details updated.');
    }

    /**
     * Remove the specified staff member from storage.
     */
    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();

        return redirect()->route('staff.index')->with('success', 'Staff member deleted.');
    }
}
