<?php

namespace App\Livewire;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class TicketList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public string $priority = '';
    public ?int $assignedTo = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'priority' => ['except' => ''],
        'assignedTo' => ['except' => null],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingPriority(): void
    {
        $this->resetPage();
    }

    public function updatingAssignedTo(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $tickets = Ticket::query()
            ->when($this->search, fn($query) => $query->where('title', 'like', "%{$this->search}%"))
            ->when($this->status, fn($query) => $query->where('status', $this->status))
            ->when($this->priority, fn($query) => $query->where('priority', $this->priority))
            ->when($this->assignedTo, fn($query) => $query->where('user_id', $this->assignedTo))
            ->latest()
            ->paginate(10);

        $users = User::all();

        return view('livewire.ticket-list', [
            'tickets' => $tickets,
            'users' => $users,
        ]);
    }
}
