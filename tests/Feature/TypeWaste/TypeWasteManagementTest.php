<?php

namespace Tests\Feature\TypeWaste;

use App\Http\Middleware\AuthenticateJwt;
use App\Http\Middleware\CheckRole;
use App\Models\TypeWaste;
use Tests\TestCase;

class TypeWasteManagementTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpWasteMsSchema();
        $this->withoutMiddleware([AuthenticateJwt::class, CheckRole::class]);
    }

    public function test_admin_can_create_waste_type(): void
    {
        $response = $this->postJson('/api/type-wastes', [
            'name' => 'Plástico PET',
            'points' => 15,
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('message', 'Tipo de residuo creado correctamente')
            ->assertJsonPath('typeWaste.name', 'Plástico PET')
            ->assertJsonPath('typeWaste.points', 15)
            ->assertJsonPath('typeWaste.is_active', true);

        $this->assertDatabaseHas('type_wastes', [
            'name' => 'Plástico PET',
            'points' => 15,
            'is_active' => 1,
        ]);
    }

    public function test_create_waste_type_rejects_duplicate_name_or_missing_name(): void
    {
        TypeWaste::create([
            'name' => 'Cartón',
            'points' => 10,
            'is_active' => true,
        ]);

        $duplicateResponse = $this->postJson('/api/type-wastes', [
            'name' => 'Cartón',
            'points' => 20,
        ]);

        $duplicateResponse->assertStatus(422)
            ->assertJsonPath('message', 'Error de validación')
            ->assertJsonValidationErrors(['name']);

        $emptyResponse = $this->postJson('/api/type-wastes', [
            'name' => '',
            'points' => -5,
        ]);

        $emptyResponse->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'points']);
    }

    public function test_admin_can_update_waste_type_and_points(): void
    {
        $typeWaste = TypeWaste::create([
            'name' => 'Vidrio',
            'points' => 12,
            'is_active' => true,
        ]);

        $response = $this->putJson("/api/type-wastes/{$typeWaste->id}", [
            'name' => 'Vidrio Templado',
            'points' => 25,
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('message', 'Tipo de residuo actualizado correctamente')
            ->assertJsonPath('typeWaste.name', 'Vidrio Templado')
            ->assertJsonPath('typeWaste.points', 25);

        $this->assertDatabaseHas('type_wastes', [
            'id' => $typeWaste->id,
            'name' => 'Vidrio Templado',
            'points' => 25,
        ]);
    }

    public function test_admin_can_toggle_waste_type_status_and_list_wastes(): void
    {
        $activeWaste = TypeWaste::create([
            'name' => 'Aluminio',
            'points' => 30,
            'is_active' => true,
        ]);

        $toToggleWaste = TypeWaste::create([
            'name' => 'Papel Archivo',
            'points' => 10,
            'is_active' => true,
        ]);

        $toggleResponse = $this->patchJson("/api/type-wastes/{$toToggleWaste->id}/toggle-status");

        $toggleResponse->assertStatus(200)
            ->assertJsonPath('message', 'Estado actualizado correctamente')
            ->assertJsonPath('typeWaste.is_active', false);

        $activeListResponse = $this->getJson('/api/type-wastes/active');
        $activeListResponse->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $activeWaste->id);

        $allListResponse = $this->getJson('/api/type-wastes');
        $allListResponse->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    public function test_admin_can_delete_waste_type(): void
    {
        $typeWaste = TypeWaste::create([
            'name' => 'Chatarra Electrónica',
            'points' => 50,
            'is_active' => true,
        ]);

        $response = $this->deleteJson("/api/type-wastes/{$typeWaste->id}");

        $response->assertStatus(200)
            ->assertJsonPath('message', 'Tipo de residuo eliminado correctamente')
            ->assertJsonPath('id', $typeWaste->id);

        $this->assertDatabaseMissing('type_wastes', [
            'id' => $typeWaste->id,
        ]);
    }
}

