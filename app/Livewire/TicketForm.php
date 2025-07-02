<?php

namespace App\Livewire;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\Attributes\Rule;

class TicketForm extends Component
{
    public ?Ticket $ticket = null;

    #[Rule('required|min:3|max:255')]
    public string $title = '';

    #[Rule('nullable|max:1000')]
    public ?string $description = null;

    #[Rule('required|in:low,medium,high')]
    public string $priority = 'medium';

    #[Rule('required|in:open,in progress,blocked,done')]
    public string $status = 'open';

    #[Rule('nullable|exists:users,id')]
    public ?int $user_id = null;

    public function mount(?Ticket $ticket = null): void
    {
        if ($ticket && $ticket->exists) {
            $this->ticket = $ticket;
            $this->title = $ticket->title;
            $this->description = $ticket->description;
            $this->priority = $ticket->priority;
            $this->status = $ticket->status;
            $this->user_id = $ticket->user_id;
        }
    }

    public function save(): void
    {
        $this->validate();

        if ($this->ticket) {
            $this->ticket->update([
                'title' => $this->title,
                'description' => $this->description,
                'priority' => $this->priority,
                'status' => $this->status,
                'user_id' => $this->user_id,
            ]);

            session()->flash('message', 'Ticket updated successfully.');
            $this->redirect(route('tickets.show', $this->ticket));
        } else {
            $ticket = Ticket::create([
                'title' => $this->title,
                'description' => $this->description,
                'priority' => $this->priority,
                'status' => $this->status,
                'user_id' => $this->user_id,
            ]);

            session()->flash('message', 'Ticket created successfully.');
            $this->redirect(route('tickets.index'));
        }
    }

    public function render(): View
    {
        $users = User::all();

        return view('livewire.ticket-form', [
            'users' => $users,
        ]);
    }
}
