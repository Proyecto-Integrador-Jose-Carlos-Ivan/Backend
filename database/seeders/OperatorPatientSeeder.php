<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;

class OperatorPatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $operators = User::where('role', 'operador')->get();
        $patients = Patient::all();

        foreach ($operators as $operator) {
            // Assign a random number of patients to each operator
            $randomPatients = $patients->random(rand(1, min(10, $patients->count())));

            foreach ($randomPatients as $patient) {
                DB::table('operator_patients')->insert([
                    'operator_id' => $operator->id,
                    'patient_id' => $patient->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
