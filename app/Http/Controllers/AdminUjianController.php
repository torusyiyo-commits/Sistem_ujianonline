<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ujian;

class AdminUjianController extends Controller
{
    public function index()
    {
        $ujians = Ujian::withCount('soals')->get();
        return view('Admin.ujian.index', compact('ujians'));
    }

    public function create()
    {
        return view('Admin.ujian.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'mata_pelajaran' => 'required',
            'kelas' => 'required',
            'durasi' => 'required|integer',
        ]);
        Ujian::create($request->all());
        return redirect()->route('admin.ujian.index')->with('success', 'Ujian created successfully');
    }

    public function edit(Ujian $ujian)
    {
        return view('Admin.ujian.edit', compact('ujian'));
    }

    public function update(Request $request, Ujian $ujian)
    {
        $request->validate([
            'judul' => 'required',
            'mata_pelajaran' => 'required',
            'kelas' => 'required',
            'durasi' => 'required|integer',
        ]);
        $ujian->update($request->all());
        return redirect()->route('admin.ujian.index')->with('success', 'Ujian updated successfully');
    }

    public function destroy(Ujian $ujian)
    {
        $ujian->delete();
        return redirect()->route('admin.ujian.index')->with('success', 'Ujian deleted successfully');
    }
}
