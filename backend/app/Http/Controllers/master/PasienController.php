<?php

namespace App\Http\Controllers\master;

use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use App\Models\Pasien;
use App\Models\PemeriksaanPasien;
use App\Http\Controllers\Controller;


class PasienController extends Controller
{
    public function index()
    {
        //
        if (!Auth::check()) {
            return response()->json(['message' => 'You must be logged in'], Response::HTTP_UNAUTHORIZED);
        }

        $pasien = Pasien::all();

        $data = $pasien->map(function ($item) {
        return [
            "id" => $item->uuid,
            "nama" => $item->nama,
            "jenis_kelamin" => $item->jenis_kelamin,
            "no_tlp" => $item->no_hp,
            "tgl_lahir" => $item->tgl_lahir,
            ];
        });

        return response()->json([
        "message" => "success",
        "data" => $data
        ]);
    }

    public function create()
    {
        //

    }

    public function store(Request $request)
    {
        //
        $user = Auth::user();
        
        if (!Auth::check()) {
            return response()->json(['message' => 'You must be logged in'], Response::HTTP_UNAUTHORIZED);
        }
        
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'no_hp' => 'required',
            
        ]);
        // dd($validated);

        $pasien = Pasien::create([
            'uuid' => (string) Str::uuid(),
            'is_active' => $validated['is_active'] ?? true,
            'nama' => $validated['nama'],
            'tgl_lahir' => $validated['tgl_lahir'],
            'no_hp' => $validated['no_hp'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
        ]);
        return response()->json([
            'success' => true,
            'data' => $pasien
        ], Response::HTTP_CREATED);
    }

    public function postPemeriksaanPerawat(Request $request)
    {
        $validatedData = $request->validate([
            "tekanan_darah"=>'required',
            "berat_badan"=>'required',
            "uuid_pasien"=>'required'
         ]);
          try{

            DB::beginTransaction();

            $cekData = PemeriksaanPasien::where('uuid_pasien', $validatedData['uuid_pasien'])->first();
            
            if ($cekData) {
                $cekData->update([
                    'td' => $validatedData['tekanan_darah'],
                    'bb' => $validatedData['berat_badan']
                ]);
                $data = $cekData;
            } else {
                $data = PemeriksaanPasien::create([
                    'uuid_pasien' => $validatedData['uuid_pasien'],
                    'td' => $validatedData['tekanan_darah'],
                    'bb' => $validatedData['berat_badan']
                ]);
            }

            DB::commit();
             return response()->json([
                 'success' => true,
                 'message' => 'Input Data Successfully!',
                 'data' => $data
             ], Response::HTTP_CREATED);
         } catch (\Exception $e) {

            DB::rollBack();
             return response()->json([
                 'success' => false,
                 'message' => 'Error',
                 'error' => $e->getMessage()
             ], Response::HTTP_INTERNAL_SERVER_ERROR);
         }
    }

    public function getPemeriksaan($uuid)
    {
        $data = PemeriksaanPasien::where('uuid_pasien', $uuid)->first();

        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => null
            ]);
        }
    }

    public function putPemeriksaanDokter(Request $request)
    {
        $validatedData = $request->validate([
            "keluhan"=>'required',
            "diagnosa"=>'required',
            "uuid_pasien"=>'required'
         ]);

        try{

        DB::beginTransaction();
        
        $data = PemeriksaanPasien::where('uuid_pasien', $validatedData['uuid_pasien'])->first();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Perawat Belum Melakukan Pemeriksaan'
            ], Response::HTTP_NOT_FOUND);
        }

        // update field yang dibutuhkan
        $data->update([
            'keluhan' => $validatedData['keluhan'],
            'diagnosa' => $validatedData['diagnosa']
        ]);

        DB::commit();
        return response()->json([
            'success' => true,
            'message' => 'Input Data Successfully!',
            'data' => $data
        ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
