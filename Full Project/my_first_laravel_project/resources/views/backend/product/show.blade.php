<x-backend.layouts.master>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            <x-slot:title>
                Product Show | <a href="{{route('products.list')}}" class="text-decoration-none">List</a>
            </x-slot>
        </div>
        <div class="card-body">
            <h3>Name: {{$product->name}}</h3>
            <p>Description: <strong>{{$product->description}}</strong></p>
            <p>Price: <strong>{{$product->price}} <span style="font-size: 20px;">&#2547</span></strong></p>
            <p>Image: <img src="{{asset('storage/products/'.$product->image )}}" alt="Product Image" width="400" height="auto"></p>
        </div>
    </div>
</x-backend.layouts.master>