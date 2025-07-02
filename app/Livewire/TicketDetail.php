<?php

namespace App\Livewire;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TicketDetail extends Component
{
    public Ticket $ticket;

    public function mount(Ticket $ticket): void
    {
        $this->ticket = $ticket;
    }

    public function updateStatus(string $status): void
    {
        if (in_array($status, ['open', 'in progress', 'blocked', 'done'])) {
            $this->ticket->update(['status' => $status]);
            $this->ticket->refresh();
            session()->flash('message', 'Ticket status updated successfully.');
        }
    }

    public function updatePriority(string $priority): void
    {
        if (in_array($priority, ['low', 'medium', 'high'])) {
            $this->ticket->update(['priority' => $priority]);
            $this->ticket->refresh();
            session()->flash('message', 'Ticket priority updated successfully.');
        }
    }

    public function assignUser(?int $userId): void
    {
        $this->ticket->update(['user_id' => $userId]);
        $this->ticket->refresh();
        session()->flash('message', 'Ticket assignment updated successfully.');
    }

    public function render(): View
    {
        $users = User::all();

        return view('livewire.ticket-detail', [
            'users' => $users,
        ]);
    }
}
