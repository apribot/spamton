<?php

namespace App\Livewire;

use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MyTickets extends Component
{
    use WithPagination;

    public string $search = '';
    public string $priority = '';
    public bool $showDone = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'priority' => ['except' => ''],
        'showDone' => ['except' => false],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPriority(): void
    {
        $this->resetPage();
    }

    public function updatingShowDone(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $tickets = Ticket::query()
            ->where('user_id', Auth::id())
            ->when($this->search, fn($query) => $query->where('title', 'like', "%{$this->search}%"))
            ->when($this->priority, fn($query) => $query->where('priority', $this->priority))
            ->when(!$this->showDone, fn($query) => $query->where('status', '!=', 'done'))
            ->latest()
            ->paginate(10);

        return view('livewire.my-tickets', [
            'tickets' => $tickets,
        ]);
    }
}
