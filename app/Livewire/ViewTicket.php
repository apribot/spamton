<?php

namespace App\Livewire;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Rule;

class ViewTicket extends Component
{
    public ?Ticket $ticket = null;

    #[Rule('required|min:3|max:255')]
    public string $name = '';

    #[Rule('required|min:10')]
    public string $description = '';

    #[Rule('required|in:low,medium,high')]
    public string $importance = 'medium';

    #[Rule('required|in:open,in progress,blocked,done')]
    public string $status = 'open';

    #[Rule('nullable|exists:users,id')]
    public ?int $user_id = null;

    public function mount($id)
    {
        $this->ticket = Ticket::findOrFail($id);
        $this->name = $this->ticket->name;
        $this->description = $this->ticket->description;
        $this->importance = $this->ticket->importance;
        $this->status = $this->ticket->status;
        $this->user_id = $this->ticket->user_id;
    }

    public function save()
    {
        $this->validate();

        $this->ticket->update([
            'name' => $this->name,
            'description' => $this->description,
            'importance' => $this->importance,
            'status' => $this->status,
            'user_id' => $this->user_id,
        ]);

        session()->flash('message', 'Ticket updated successfully!');

        return redirect()->route('dashboard');
    }

    public function render()
    {
        $users = User::all();

        return view('livewire.view-ticket', [
            'users' => $users,
        ]);
    }
}
