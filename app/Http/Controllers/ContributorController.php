<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contribution;
use Illuminate\Http\Request;

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

    public function destroy(User $contributor)
    {
        $contributor->delete();
        return back()->with('success', 'Contributor removed.');
    }

    // Required by resource route
    public function create()  { return view('contributors.create'); }
    public function store(Request $request) { return redirect()->route('contributors.index'); }
    public function edit(User $contributor) { return view('contributors.edit', compact('contributor')); }
    public function update(Request $request, User $contributor) { return redirect()->route('contributors.index'); }
}
