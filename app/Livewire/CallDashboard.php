<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Call;
use App\Models\Zone;
use Carbon\Carbon;
use Illuminate\Support\Facades\Broadcast;
use Livewire\Attributes\On;

class CallDashboard extends Component
{
    public $date;
    public $zone;
    public $calls;


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

    public function updatedDate()
    {
        $this->calls = $this->getCalls();
    }

    public function updatedZone()
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

        return $query->get();
    }

    public function refreshCalls()
    {
        $this->calls = $this->getCalls();
    }

    public function render()
    {
        $zones = Zone::all();
        return view('livewire.call-dashboard', ['zones' => $zones , 'calls' => $this->calls]);
    }
}