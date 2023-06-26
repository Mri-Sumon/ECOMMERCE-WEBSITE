<x-backend.layouts.master>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            <x-slot:title>
                Category Show | List
            </x-slot>
        </div>
        <div class="card-body">
            <h3>Title: {{$key->title}}</h3>
            <h3>Description: {{$key->description}}</h3>
        </div>
    </div>
</x-backend.layouts.master>