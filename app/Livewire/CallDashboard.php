<?php

namespace App\Livewire;

use Livewire\Component;

class CallDashboard extends Component
{
    public $date;
    public $zone;
    public $calls;

    public function mount()
    {
        $this->date = now()->toDateString();
        $this->calls = $this->getCalls();
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
        // Dummy data for demonstration
        $calls = [
            ['id' => 1, 'date' => '2024-01-01', 'zone' => 'Zone A', 'type' => 'incoming'],
            ['id' => 2, 'date' => '2024-01-01', 'zone' => 'Zone B', 'type' => 'outgoing'],
            ['id' => 3, 'date' => '2024-01-02', 'zone' => 'Zone A', 'type' => 'incoming'],
        ];

        // Apply filters
        $filteredCalls = collect($calls)
            ->when($this->date, function ($collection, $date) {
                return $collection->filter(function ($call) use ($date) {
                    return $call['date'] == $date;
                });
            })
            ->when($this->zone, function ($collection, $zone) {
                return $collection->filter(function ($call) use ($zone) {
                    return $call['zone'] == $zone;
                });
            })->toArray();

        return $filteredCalls;
    }

    public function render()
    {
        return view('livewire.call-dashboard');
    }
}
