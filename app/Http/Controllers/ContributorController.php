<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ContributorController extends Controller
{
    public function index()
    {
        $contributors = User::where('role', 'contributor')
            ->withCount('contributions')
            ->latest()
            ->paginate(20);

        return view('contributors.index', compact('contributors'));
    }

    public function show(User $contributor)
    {
        $contributions = $contributor->contributions()->latest()->paginate(10);
        return view('contributors.show', compact('contributor', 'contributions'));
    }

    public function create()
    {
        return view('contributors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone'     => ['required', 'string', 'max:20', 'unique:users,phone'],
            'email'     => ['nullable', 'email', 'max:255', 'unique:users,email'],
        ]);

        User::create([
            'full_name' => $validated['full_name'],
            'phone'     => $validated['phone'],
            'email'     => $validated['email'] ?? null,
            'role'      => 'contributor',
            'password'  => Hash::make(Str::random(16)),
        ]);

        return redirect()->route('contributors.index')->with('success', 'Contributor registered successfully!');
    }

    public function edit(User $contributor)
    {
        return view('contributors.edit', compact('contributor'));
    }

    public function update(Request $request, User $contributor)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone'     => ['required', 'string', 'max:20', 'unique:users,phone,' . $contributor->id],
            'email'     => ['nullable', 'email', 'max:255', 'unique:users,email,' . $contributor->id],
        ]);

        $contributor->update($validated);

        return redirect()->route('contributors.index')->with('success', 'Contributor updated successfully!');
    }

    public function destroy(User $contributor)
    {
        $contributor->delete();
        return back()->with('success', 'Contributor removed.');
    }
}
