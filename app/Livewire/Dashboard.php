<?php

namespace App\Livewire;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public bool $showDone = false;

    public function render()
    {
        $query = Ticket::where('user_id', Auth::id())
            ->orderByRaw("CASE
                WHEN importance = 'high' THEN 1
                WHEN importance = 'medium' THEN 2
                WHEN importance = 'low' THEN 3
                ELSE 4
            END")
            ->orderBy('created_at', 'desc');

        if (!$this->showDone) {
            $query->where('status', '!=', 'done');
        }

        $tickets = $query->get();

        return view('livewire.dashboard', [
            'tickets' => $tickets,
        ]);
    }

    public function toggleShowDone()
    {
        $this->showDone = !$this->showDone;
    }

    public function updateTicketStatus($ticketId, $status)
    {
        $ticket = Ticket::where('id', $ticketId)
            ->where('user_id', Auth::id())
            ->first();

        if ($ticket) {
            $ticket->update(['status' => $status]);
            session()->flash('message', 'Ticket status updated successfully!');
        }
    }
}
