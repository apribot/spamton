<section class="w-full">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ 'Edit Ticket' }}</flux:heading>
        <flux:separator variant="subtle" />
    </div>

    @if (session()->has('message'))
        <flux:text class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </flux:text>
    @endif

    <form wire:submit="save" class="my-6 w-full space-y-6">
        <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus />

        <div data-flux-field>
            <label for="description" data-flux-label>{{ __('Description') }}</label>
            <textarea id="description" wire:model="description" rows="4" data-flux-control class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div data-flux-field>
            <label for="importance" data-flux-label>{{ __('Importance Level') }}</label>
            <select id="importance" wire:model="importance" data-flux-control class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
            @error('importance') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div data-flux-field>
            <label for="status" data-flux-label>{{ __('Progress State') }}</label>
            <select id="status" wire:model="status" data-flux-control class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="open">Open</option>
                <option value="in progress">In Progress</option>
                <option value="blocked">Blocked</option>
                <option value="done">Done</option>
            </select>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div data-flux-field>
            <label for="user_id" data-flux-label>{{ __('Assign To') }}</label>
            <select id="user_id" wire:model="user_id" data-flux-control class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            @error('user_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full">
                    {{ 'Update Ticket' }}
                </flux:button>
            </div>
        </div>
    </form>
</section>
