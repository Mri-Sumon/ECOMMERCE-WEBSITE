<x-backend.layouts.master>

    <x-slot:page_title>
        Roll
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
                Role List
            </x-slot>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    @can('create-category')
                        <button type="button" class="btn btn-primary"><a href="{{ route('categories.create')}}" class="text-white text-decoration-none">Create Category</a></button>
                    @endcan
                    <button type="button" class="btn btn-warning"><a href="{{ route('categories.pdf')}}" class="text-white text-decoration-none">Download PDF</a></button>
                    <button type="button" class="btn btn-info"><a href="{{ route('categories.excel')}}" class="text-white text-decoration-none">Download Excel</a></button>
                </div>
                <div class="col-md-6">
                    <!-- SEARCHING FIELD -->
                    <form action="" method="get" class="d-flex justify-content-end">
                        @csrf
                        <input type="search" name="keyword" id="search">
                        <button type="submit">Search</button>
                    </form>
                </div>
            </div>
            <!-- <table id="datatablesSimple" class="table table-success table-striped"> -->
            <table class="table table-success table-striped mt-2">
                <thead>
                    <tr>
                        <th>Ser</th>
                        <th>Role</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Ser</th>
                        <th>Role</th>
                        <th>Name</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{$roles->firstItem()+$loop->index}}</td>
                            <td>{{$role->name}}</td>
                            <td>
                                <a href="{{route('role.user-list', ['role'=>$role->id])}}" class="btn btn-sm btn-primary mx-1">Show</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$roles->links()}}
        </div>
    </div>
</x-backend.layouts.master>

