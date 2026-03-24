<x-app-layout>
    <x-slot name="header">
        <div class="space-y-1">
            <h2 class="text-2xl font-light text-stone-700 tracking-wide">ZenStack</h2>
            <p class="text-sm text-stone-500">Minimal tasks for a calm workflow</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div role="alert" class="rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <section class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-stone-100 sm:p-6">
                <form method="POST" action="{{ route('tasks.store') }}" class="space-y-3" autocomplete="off">
                    @csrf
                    <label for="title" class="text-sm text-stone-500">New task</label>
                    <div class="flex items-center gap-3">
                        <input
                            id="title"
                            name="title"
                            type="text"
                            value="{{ old('title') }}"
                            placeholder="Write one focused next step"
                            class="w-full rounded-2xl border-stone-200 text-stone-800 shadow-sm focus:border-emerald-400 focus:ring-emerald-400"
                            maxlength="255"
                            required
                        />
                        <button
                            type="submit"
                            class="rounded-2xl bg-stone-800 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-stone-700"
                        >
                            Save
                        </button>
                    </div>

                    @error('title')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </form>
            </section>

            <section class="space-y-3">
                <div class="flex items-center justify-between px-1">
                    <p class="text-xs uppercase tracking-wide text-stone-400">Your Tasks</p>
                    <span class="rounded-full bg-stone-100 px-2.5 py-1 text-xs text-stone-500">{{ $tasks->count() }}</span>
                </div>
                @forelse ($tasks as $task)
                    <div class="flex items-center justify-between rounded-2xl bg-white px-5 py-4 shadow-sm ring-1 ring-stone-100 transition hover:shadow">
                        <div class="flex items-center gap-4">
                            <form method="POST" action="{{ route('tasks.update', $task) }}">
                                @csrf
                                @method('PATCH')
                                <input
                                    type="checkbox"
                                    aria-label="Toggle task completion"
                                    onChange="this.form.submit()"
                                    {{ $task->is_completed ? 'checked' : '' }}
                                    class="h-5 w-5 rounded border-stone-300 text-emerald-600 focus:ring-emerald-500"
                                />
                            </form>

                            <p class="text-[15px] {{ $task->is_completed ? 'text-stone-400 line-through' : 'text-stone-700' }}">
                                {{ $task->title }}
                            </p>
                        </div>

                        <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-stone-400 transition hover:text-red-500">
                                Delete
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="rounded-2xl bg-white p-8 text-center text-sm text-stone-400 shadow-sm ring-1 ring-stone-100">
                        No tasks yet. Capture your first small step.
                    </div>
                @endforelse
            </section>
        </div>
    </div>
</x-app-layout>
