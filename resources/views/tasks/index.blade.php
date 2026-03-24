<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-light text-stone-700 tracking-wide">
            ZenStack Tasks
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 space-y-8">
            @if (session('success'))
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-stone-100 sm:p-8">
                <form method="POST" action="{{ route('tasks.store') }}" class="space-y-3">
                    @csrf
                    <label for="title" class="text-sm text-stone-500">Add a task</label>
                    <div class="flex items-center gap-3">
                        <input
                            id="title"
                            name="title"
                            type="text"
                            value="{{ old('title') }}"
                            placeholder="One clear thing to do next..."
                            class="w-full rounded-2xl border-stone-200 text-stone-800 shadow-sm focus:border-emerald-400 focus:ring-emerald-400"
                            required
                        />
                        <button
                            type="submit"
                            class="rounded-2xl bg-stone-800 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-stone-700"
                        >
                            Add
                        </button>
                    </div>

                    @error('title')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </form>
            </section>

            <section class="space-y-3">
                @forelse ($tasks as $task)
                    <div class="flex items-center justify-between rounded-2xl bg-white px-5 py-4 shadow-sm ring-1 ring-stone-100">
                        <div class="flex items-center gap-4">
                            <form method="POST" action="{{ route('tasks.update', $task) }}">
                                @csrf
                                @method('PATCH')
                                <input
                                    type="checkbox"
                                    onChange="this.form.submit()"
                                    {{ $task->is_completed ? 'checked' : '' }}
                                    class="h-5 w-5 rounded border-stone-300 text-emerald-600 focus:ring-emerald-500"
                                />
                            </form>

                            <p class="text-sm {{ $task->is_completed ? 'text-stone-400 line-through' : 'text-stone-700' }}">
                                {{ $task->title }}
                            </p>
                        </div>

                        <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-stone-400 transition hover:text-red-500">
                                Remove
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="rounded-2xl bg-white p-8 text-center text-sm text-stone-400 shadow-sm ring-1 ring-stone-100">
                        No tasks yet. Start with one calm step.
                    </div>
                @endforelse
            </section>
        </div>
    </div>
</x-app-layout>
