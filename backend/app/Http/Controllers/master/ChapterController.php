<?php

namespace App\Http\Controllers\master;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use App\Models\ModelChapter;
use App\Http\Controllers\Controller;

class ChapterController extends Controller
{
    public function index()
    {

        if (!Auth::check()) {
            return response()->json(['message' => 'You must be logged in'], Response::HTTP_UNAUTHORIZED);
        }

        $chapter = ModelChapter::all();
        $data = [
            "chapter" => $chapter,
            "message" => 'success'
        ];


        return response()->json([
            'success' => true,
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'You must be logged in'], Response::HTTP_UNAUTHORIZED);
        }

        // Ambil data pengguna yang login
        $user = Auth::user();

        $validated = $request->validate([

            'nama' => 'required|string|max:100',
            'kode_chapter' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'kota' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'email' => 'required|email|max:100',
        ]);
        // dd($validated);


        // Menambahkan UUID dan informasi pengguna yang membuat atau memperbarui chapter
        $chapter = ModelChapter::create([
            'uuid' => (string) Str::uuid(), // Membuat UUID baru untuk chapter
            'is_active' => $validated['is_active'] ?? true, // Jika tidak ada nilai, default ke true
            'kode_chapter' => $validated['kode_chapter'],
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'kota' => $validated['kota'],
            'kecamatan' => $validated['kecamatan'],
            'email' => $validated['email'],
            'created_by' => $user->uuid, // UUID pengguna yang sedang login
            'updated_by' => $user->uuid, // UUID pengguna yang sedang login
        ]);
        return response()->json([
            'success' => true,
            'data' => $chapter
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'You must be logged in'], Response::HTTP_UNAUTHORIZED);
        }

        $chapter = ModelChapter::find($id);

        if (!$chapter) {
            return response()->json(['message' => 'Data not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $chapter
        ], Response::HTTP_OK);
    }

    public function edit(string $id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'You must be logged in'], Response::HTTP_UNAUTHORIZED);
        }

        $chapter = ModelChapter::find($id);

        if (!$chapter) {
            return response()->json(['message' => 'Data not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $chapter
        ], Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'You must be logged in'], Response::HTTP_UNAUTHORIZED);
        }

        $chapter = ModelChapter::find($id);

        if (!$chapter) {
            return response()->json(['message' => 'Data not found'], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'is_active' => 'boolean',
            'nama' => 'required|string|max:12',
        ]);

        $chapter->update([
            'is_active' => $validated['is_active'] ?? $chapter->is_active,
            'nama' => $validated['nama'],
            'updated_by' => Auth::user()->id,
        ]);

        return response()->json([
            'success' => true,
            'data' => $chapter
        ], Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'You must be logged in'], Response::HTTP_UNAUTHORIZED);
        }

        $chapter = ModelChapter::find($id);

        if (!$chapter) {
            return response()->json(['message' => 'Data not found'], Response::HTTP_NOT_FOUND);
        }

        $chapter->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data deleted successfully'
        ], Response::HTTP_OK);
    }

    public function disable(string $id)
    {
        $chapter = ModelChapter::find($id);
        if (!$chapter) {
            return response()->json([
                'success' => false,
                'message' => 'Data yang dicari tidak ada',
            ], Response::HTTP_NOT_FOUND);
        }
        //update is aktive menjadi false
        $chapter->is_active = false;

        //simpan perubahan ke database
        $chapter->save();

        //kembalikan response sukses
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dinonaktifkan',
            'data' => $chapter,
        ], Response::HTTP_OK);
    }
}
