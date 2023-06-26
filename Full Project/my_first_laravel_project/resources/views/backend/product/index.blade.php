<x-backend.layouts.master>

    <x-slot:page_title>
        Product
    </x-slot>
    <!-- CATEGORY CREATE SUCCESSFULLY MESSAGE RECEIVED -->
    @if(session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Holy guacamole!</strong> {{session('message')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!-- DATABASE TABLE -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            <x-slot:title>
                Product List
            </x-slot>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-primary"><a href="{{route('products.create')}}" class="text-white text-decoration-none">Create</a></button>         
            <button type="button" class="btn btn-warning"><a href="{{route('products.trashed')}}" class="text-white text-decoration-none">Trust List</a></button>         
            <table id="datatablesSimple" class="table table-success table-striped">
                <thead>
                    <tr>
                        <th>Ser</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Ser</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->price}}</td>
                            <td><img src="{{ asset('storage/products/'.$product->image)}}" alt="product image" height="150" width="200"></td>
                            <td>
                                <a href="{{route('products.show', ['product'=>$product->id])}}" class="btn btn-sm btn-primary">Show</a>
                                <a href="{{route('products.edit', ['product'=>$product->id])}}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('products.destroy', ['product'=>$product->id])}}" method="post" style="display: inline">
                                    @csrf
                                    @method('delete')
                                    <button onclick="confirm('Are you sure ?')" class="btn btn-sm btn-danger" type="submit">Delete</button>
                                    <!-- or <button onclick="alert('Are you sure ?')" class="btn btn-sm btn-danger" type="submit">Delete</button> -->
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-backend.layouts.master>