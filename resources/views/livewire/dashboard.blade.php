<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="flex justify-between items-center mb-4">
        <flux:heading size="xl" level="1">{{ 'My Tickets' }}</flux:heading>
        <button wire:click="toggleShowDone" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">
            {{ $showDone ? 'Hide Completed' : 'Show Completed' }}
        </button>
    </div>
    <flux:separator variant="subtle" class="mb-4" />

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md border border-green-200">
            {{ session('message') }}
        </div>
    @endif

    @if($tickets->isEmpty())
        <div class="flex justify-center items-center h-40 bg-gray-50 dark:bg-gray-800 rounded-xl border border-neutral-200 dark:border-neutral-700">
            <p class="text-gray-500 dark:text-gray-400">No tickets assigned to you{{ !$showDone ? ' (excluding completed tickets)' : '' }}.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($tickets as $ticket)
                <div class="flex flex-col h-full overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 hover:shadow-md transition">
                    <div class="p-4 flex-1">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white truncate">{{ $ticket->name }}</h3>
                            <div class="flex flex-col space-y-2">
                                <div class="flex flex-col">
                                    <label class="text-xs text-gray-500 dark:text-gray-400 mb-1">Status</label>
                                    <select wire:change="updateTicketStatus({{ $ticket->id }}, $event.target.value)"
                                            class="px-2 py-1 text-xs font-semibold rounded border-0 focus:ring-2 focus:ring-indigo-500
                                            @if($ticket->status === 'open') bg-yellow-100 text-yellow-800
                                            @elseif($ticket->status === 'in progress') bg-blue-100 text-blue-800
                                            @elseif($ticket->status === 'blocked') bg-red-100 text-red-800
                                            @elseif($ticket->status === 'done') bg-green-100 text-green-800
                                            @endif">
                                        <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                                        <option value="in progress" {{ $ticket->status === 'in progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="blocked" {{ $ticket->status === 'blocked' ? 'selected' : '' }}>Blocked</option>
                                        <option value="done" {{ $ticket->status === 'done' ? 'selected' : '' }}>Done</option>
                                    </select>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-xs text-gray-500 dark:text-gray-400 mb-1">Importance</label>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if($ticket->importance === 'low') bg-green-100 text-green-800
                                        @elseif($ticket->importance === 'medium') bg-yellow-100 text-yellow-800
                                        @elseif($ticket->importance === 'high') bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($ticket->importance) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                            {{ Str::limit($ticket->description, 40) }}
                        </p>
                    </div>
                    <div class="px-4 py-2 bg-gray-50 dark:bg-gray-800 border-t border-neutral-200 dark:border-neutral-700">
                        <a href="{{ route('view-ticket', $ticket->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm" wire:navigate>
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
