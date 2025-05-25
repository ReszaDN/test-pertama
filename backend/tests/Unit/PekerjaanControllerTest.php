<?php

namespace Tests\Unit;

use App\Models\ModelPekerjaan;
use Tests\TestCase;
use App\Models\User;

class PekerjaanControllerTest extends TestCase
{

    /**
     * Test disable pekerjaan.
     */
    public function test_disable_pekerjaan()
    {
        // Buat user untuk autentikasi
        $user = User::factory()->create();

        // Buat pekerjaan yang akan dinonaktifkan
        $pekerjaan = ModelPekerjaan::factory()->create(['is_active' => true]);

        // Lakukan request ke endpoint disable
        $response = $this->actingAs($user)->putJson("/api/pekerjaan/{$pekerjaan->id}/disable");

        // Assert status response 200 OK
        $response->assertStatus(200);

        // Ambil data pekerjaan dari database
        $pekerjaan->refresh();

        // Assert is_active menjadi false
        $this->assertFalse($pekerjaan->is_active);

        // Assert response JSON
        $response->assertJson([
            'success' => true,
            'message' => 'Data berhasil dinonaktifkan',
        ]);
    }

    /**
     * Test disable pekerjaan with invalid ID.
     */
    public function test_disable_pekerjaan_with_invalid_id()
    {
        // Buat user untuk autentikasi
        $user = User::factory()->create();

        // Lakukan request ke endpoint disable dengan ID yang tidak ada
        $response = $this->actingAs($user)->putJson('/api/pekerjaan/999/disable');

        // Assert status response 404 Not Found
        $response->assertStatus(404);

        // Assert response JSON
        $response->assertJson([
            'success' => false,
            'message' => 'Data yang dicari tidak ada',
        ]);
    }
}
