<div>
    @if (session('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                    {{ $ticket->title }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                    Created {{ $ticket->created_at->diffForHumans() }}
                </p>
            </div>
            <div>
                <a href="{{ route('tickets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Back to Tickets') }}
                </a>
            </div>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700">
            <dl>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">
                        Description
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2">
                        {{ $ticket->description ?? 'No description provided.' }}
                    </dd>
                </div>
                <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">
                        Status
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2">
                        <div class="flex items-center space-x-2">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($ticket->status === 'open') bg-blue-100 text-blue-800
                                @elseif($ticket->status === 'in progress') bg-yellow-100 text-yellow-800
                                @elseif($ticket->status === 'blocked') bg-red-100 text-red-800
                                @elseif($ticket->status === 'done') bg-green-100 text-green-800
                                @endif">
                                {{ ucfirst($ticket->status) }}
                            </span>
                            <div class="flex space-x-1">
                                <x-primary-button wire:click="updateStatus('open')" class="px-2 py-1 text-xs rounded @if($ticket->status === 'open') bg-blue-600 text-white @else bg-blue-100 text-blue-800 hover:bg-blue-200 @endif">
                                    Open
                                </x-primary-button>
                                <x-primary-button wire:click="updateStatus('in progress')" class="px-2 py-1 text-xs rounded @if($ticket->status === 'in progress') bg-yellow-600 text-white @else bg-yellow-100 text-yellow-800 hover:bg-yellow-200 @endif">
                                    In Progress
                                </x-primary-button>
                                <x-primary-button wire:click="updateStatus('blocked')" class="px-2 py-1 text-xs rounded @if($ticket->status === 'blocked') bg-red-600 text-white @else bg-red-100 text-red-800 hover:bg-red-200 @endif">
                                    Blocked
                                </x-primary-button>
                                <x-primary-button wire:click="updateStatus('done')" class="px-2 py-1 text-xs rounded @if($ticket->status === 'done') bg-green-600 text-white @else bg-green-100 text-green-800 hover:bg-green-200 @endif">
                                    Done
                                </x-primary-button>
                            </div>
                        </div>
                    </dd>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">
                        Priority
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2">
                        <div class="flex items-center space-x-2">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($ticket->priority === 'low') bg-gray-100 text-gray-800
                                @elseif($ticket->priority === 'medium') bg-yellow-100 text-yellow-800
                                @elseif($ticket->priority === 'high') bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                            <div class="flex space-x-1">
                                <x-primary-button wire:click="updatePriority('low')" class="px-2 py-1 text-xs rounded @if($ticket->priority === 'low') bg-gray-600 text-white @else bg-gray-100 text-gray-800 hover:bg-gray-200 @endif">
                                    Low
                                </x-primary-button>
                                <x-primary-button wire:click="updatePriority('medium')" class="px-2 py-1 text-xs rounded @if($ticket->priority === 'medium') bg-yellow-600 text-white @else bg-yellow-100 text-yellow-800 hover:bg-yellow-200 @endif">
                                    Medium
                                </x-primary-button>
                                <x-primary-button wire:click="updatePriority('high')" class="px-2 py-1 text-xs rounded @if($ticket->priority === 'high') bg-red-600 text-white @else bg-red-100 text-red-800 hover:bg-red-200 @endif">
                                    High
                                </x-primary-button>
                            </div>
                        </div>
                    </dd>
                </div>
                <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">
                        Assigned To
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2">
                        <div class="flex items-center space-x-2">
                            @if($ticket->assignedUser)
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 bg-indigo-500 rounded-full flex items-center justify-center text-white">
                                        {{ $ticket->assignedUser->initials() }}
                                    </div>
                                    <div class="ml-2">
                                        {{ $ticket->assignedUser->name }}
                                    </div>
                                </div>
                            @else
                                <span class="text-gray-400">Unassigned</span>
                            @endif
                            <div class="ml-4">
                                <select wire:model.live="selectedUser" wire:change="assignUser($event.target.value)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Change Assignment</option>
                                    <option value="null">Unassign</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>
