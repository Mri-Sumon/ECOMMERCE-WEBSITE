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
                Product Trast List | <a href="{{route('products.list')}}" class="text-decoration-none">List</a>
            </x-slot>
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-success table-striped">
                <thead>
                    <tr>
                        <th>Ser</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Ser</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($trashData as $product)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$product->name}}</td>
                            <td><img src="{{ asset('storage/products/'.$product->image)}}" alt="product image" height="150" width="200"></td>
                            <td>
                                <a href="{{route('products.restore', ['product'=>$product->id])}}" class="btn btn-sm btn-warning">Restore</a>
                                <form action="{{ route('products.delete', ['product'=>$product->id])}}" method="post" style="display: inline">
                                    @csrf
                                    @method('delete')
                                    <button onclick="confirm('Are you sure ?')" class="btn btn-sm btn-danger" type="submit">Permanent Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-backend.layouts.master>