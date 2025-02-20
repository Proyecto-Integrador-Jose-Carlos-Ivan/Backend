<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Patient;
use Livewire\WithPagination;

class AssignPatientsToOperator extends Component
{
    use WithPagination;

    public $operatorId;
    public $selectedPatients = [];
    public $search = '';

    public function mount($operatorId)
    {
        $this->operatorId = $operatorId;
    }

    public function assignPatients()
    {
        $operator = User::find($this->operatorId);

        if ($operator) {
            $operator->patients()->sync($this->selectedPatients);
            session()->flash('message', 'Pacientes asignados correctamente.');
        } else {
            session()->flash('error', 'Operador no encontrado.');
        }

        $this->selectedPatients = [];
    }

    public function render()
    {
        $operator = User::find($this->operatorId);
        $patients = Patient::where('nombre', 'like', '%'.$this->search.'%')->paginate(10);

        return view('livewire.assign-patients-to-operator', [
            'operator' => $operator,
            'patients' => $patients,
        ]);
    }
}
