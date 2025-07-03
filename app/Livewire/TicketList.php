<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;

class TicketList extends Component
{
    public function render()
    {
        $activeTickets = Ticket::where('status', '!=', 'done')
            ->orderBy('created_at', 'desc')
            ->get();

        $completedTickets = Ticket::where('status', 'done')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.ticket-list', [
            'activeTickets' => $activeTickets,
            'completedTickets' => $completedTickets,
        ]);
    }
}
