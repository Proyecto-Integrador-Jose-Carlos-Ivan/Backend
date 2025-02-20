<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Call;
use App\Models\Zone;
use App\Models\User;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Broadcast;
use Livewire\Attributes\On;

class CallDashboard extends Component
{
    public $date;
    public $zone;
    public $operator;
    public $patient;
    public $calls;
    public $direction;


    #[On('CridadaNova')]
    public function handleCallCreated($call)
    {
        $this->refreshCalls();
        $this->dispatch('$refresh');

    }

    public function mount()
    {
        $this->date = now()->toDateString();
        $this->calls = Call::all();

    }

    public function applyFilters()
    {
        $this->calls = $this->getCalls();
    }

    public function getCalls()
    {
        $query = Call::query();

        if ($this->date) {
            $query->whereDate('created_at', $this->date);
        }

        if ($this->zone) {
            $query->where('zone_id', $this->zone);
        }

        if ($this->operator) {
            $query->where('operador_id', $this->operator);
        }

        if ($this->patient) {
            $query->where('paciente_id', $this->patient);
        }

        if ($this->direction) {
            $query->where('sentido', $this->direction);
        }

        return $query->get();
    }

    public function refreshCalls()
    {
        $this->calls = $this->getCalls();
    }

    public function render()
    {
        $zones = Zone::orderBy('name')->get();
        $operators = User::where('role', 'operador')->orderBy('name')->get();
        $patients = Patient::orderBy('nombre')->get();
        return view('livewire.call-dashboard', [
            'zones' => $zones ,
            'calls' => $this->calls,
            'operators' => $operators,
            'patients' => $patients,
            ]);
    }
}