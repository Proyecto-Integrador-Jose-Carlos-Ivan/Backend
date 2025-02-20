<?php


use App\Models\Call;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Alert;
use App\Models\Zone;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can list calls', function () {
    Call::factory()->count(3)->create();

    $response = $this->getJson('/api/calls');

    $response->assertStatus(200);
});

it('can show a call', function () {
    $call = Call::factory()->create();

    $response = $this->getJson("/api/calls/{$call->id}");

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                'id',
                'fecha_hora',
                'paciente_id',
                'operador_id',
                'categoria',
                'descripcion',
                'created_at',
                'updated_at',
            ],
            'message',
        ]);
});

it('can create a call', function () {
    $data = [
        'fecha_hora' => '2025-02-14 14:45:30',
        'operador_id' => User::factory()->create()->id,
        'paciente_id' => Patient::factory()->create()->id,
        'descripcion' => 'Paciente refiere dolor en el pecho y dificultad para respirar.  Se coordina ambulancia.',
        'sentido' => 'entrante',
        'categoria' => 'atencion_emergencias',
        'subtipo' => 'emergencias_sanitarias',
        'aviso_id' => Alert::factory()->create()->id,
    ];

    $response = $this->postJson('/api/calls', $data);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'success',
            'data' => [
                'id',
                'fecha_hora',
                'paciente_id',
                'operador_id',
                'categoria',
                'descripcion',
                'created_at',
                'updated_at',
            ],
            'message',
        ]);

    $this->assertDatabaseHas('llamadas', $data);
});

it('can update a call', function () {
    $call = Call::factory()->create();

    $data = [
        'descripcion' => 'updated description',
    ];

    $response = $this->putJson("/api/calls/{$call->id}", $data);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                'id',
                'fecha_hora',
                'paciente_id',
                'operador_id',
                'categoria',
                'descripcion',
                'created_at',
                'updated_at',
            ],
            'message',
        ]);

    $this->assertDatabaseHas('llamadas', ['id' => $call->id, 'descripcion' => $data['descripcion']]);
});

it('can delete a call', function () {
    $call = Call::factory()->create();

    $response = $this->deleteJson("/api/calls/{$call->id}");

    $response->assertStatus(204);

    $this->assertDatabaseMissing('llamadas', ['id' => $call->id]);
});
