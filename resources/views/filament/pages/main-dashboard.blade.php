<x-filament::page>
    <div class="space-y-4">
        <h1 class="text-3xl font-bold">Welcome to the Admin Panel</h1>
        <p class="text-gray-600">Manage tours, trips, activities, and more from here.</p>

        {{-- Add custom content here --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white shadow p-4 rounded-xl">
                <h2 class="font-semibold text-lg">Tours</h2>
                <p>Manage and update tours.</p>
            </div>
            <div class="bg-white shadow p-4 rounded-xl">
                <h2 class="font-semibold text-lg">Reservations</h2>
                <p>Track new reservations.</p>
            </div>
            <div class="bg-white shadow p-4 rounded-xl">
                <h2 class="font-semibold text-lg">Contact Messages</h2>
                <p>Review contact form submissions.</p>
            </div>
        </div>
    </div>
</x-filament::page>
