<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index()
    {
        $gudangs = Gudang::all();

        return view('gudang.index', compact('gudangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->vaidate([
            'nama_gudang' => 'required|string|max:225',
            'alamat' => 'nullable|string|max:255',
        ]);

        Gudang::create($validated);
        return redirect()->route('gudang.index')->with('success', 'Gudang Berhasil Ditambahkan.');
    }

    public function edit(string $id)
    {
        
    }
}
