<?php


use App\Models\Patient;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'admin']); // Ensure the user has the 'admin' role
    $this->actingAs($this->user);
});

it('can list patients', function () {
    Patient::factory()->count(3)->create();

    $response = $this->getJson('/api/patients');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'fecha_nacimiento',
                    'direccion',
                    'telefono',
                    'email',
                    'zona_id',
                    'created_at',
                    'updated_at',
                ],
            ],
            'message',
        ]);
});

it('can show a patient', function () {
    $patient = Patient::factory()->create();

    $response = $this->getJson("/api/patients/{$patient->id}");

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                'id',
                'nombre',
                'fecha_nacimiento',
                'direccion',
                'telefono',
                'email',
                'zona_id',
                'created_at',
                'updated_at',
            ],
            'message',
        ]);
});

it('can create a patient', function () {
    $data = [
        'nombre' => 'John Doe',
        'fecha_nacimiento' => '1985-07-20',
        'direccion' => '789 Oak St',
        'dni' => '98765432B',
        'sip' => 987654321,
        'telefono' => 650123456,
        'email' => 'john.doe2@example.com',
        'zona_id' => Zone::factory()->create()->id,
        'situacion_personal' => 'Stable living situation, supportive family.',
        'situacion_sanitaria' => 'Generally healthy, occasional headaches.',
        'situacion_habitage' => 'Lives in a well-maintained apartment.',
        'autonomia' => 'Fully autonomous, able to manage daily tasks.',
        'situacion_economica' => 'Stable income, manages finances well.'
    ];

    $response = $this->postJson('/api/patients', $data);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'success',
            'data' => [
                'id',
                'nombre',
                'fecha_nacimiento',
                'direccion',
                'telefono',
                'email',
                'zona_id',
                'situacion_personal',
                'situacion_sanitaria',
                'situacion_habitage',
                'autonomia',
                'situacion_economica',
                'created_at',
                'updated_at',
            ],
            'message',
        ]);

    $this->assertDatabaseHas('pacientes', [
        'nombre' => 'John Doe',
        'fecha_nacimiento' => '1985-07-20',
        'direccion' => '789 Oak St',
        'dni' => '98765432B',
        'sip' => 987654321,
        'telefono' => 650123456,
        'email' => 'john.doe2@example.com',
        'zona_id' => 1,
    ]);
});

it('can update a patient', function () {
    $patient = Patient::factory()->create();

    $data = [
        'direccion' => '456 Elm St',
    ];

    $response = $this->putJson("/api/patients/{$patient->id}", $data);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                'id',
                'nombre',
                'fecha_nacimiento',
                'direccion',
                'telefono',
                'email',
                'zona_id',
                'created_at',
                'updated_at',
            ],
            'message',
        ]);

    $this->assertDatabaseHas('pacientes', ['id' => $patient->id, 'direccion' => $data['direccion']]);
});

it('can delete a patient', function () {
    $patient = Patient::factory()->create();

    $response = $this->deleteJson("/api/patients/{$patient->id}");

    $response->assertStatus(204);

    $this->assertDatabaseMissing('pacientes', ['id' => $patient->id]);
});
