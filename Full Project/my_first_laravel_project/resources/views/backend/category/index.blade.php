<x-backend.layouts.master>

    <x-slot:page_title>
        Category
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
                Category List
            </x-slot>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <!-- Un-authorized user ক্রিয়েট বাটন দেখতে পাবেনা, create-category হল Authorization এর Gate Name -->
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
                        <th>Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Ser</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <!-- ROW SERIAL NUMBER -->
                            <!-- প্রত্তেকটি পেজের ডাটা সিরিয়ালি দেখানোর জন্য, 1ম পেজের ডাটার সিরিয়াল যেখানে শেষ হবে 2য় পেজের সিরিয়াল সেখানে শুরু হবে। -->
                            <td>{{$categories->firstItem()+$loop->index}}</td>
                            <!-- PRINT TITLE FORM CATEGORIES TABLE-->
                            <td>{{ $category->title}}</td>
                            <!-- PRINT DESCRIPTION FORM DATABASE CATEGORIES TABLE -->
                            <td>{{ $category->description}}</td>
                            <td class="d-flex">
                                <!-- Execution Show পেজ এ যাওয়ার সাথে সাথে category list দেখানোর জন্য এখানে database হতে row এর যে id আসছে, সেটি web.php হয়ে CategoryController.php এ যাবে। -->
                                <a href="{{route('categories.show', ['category'=>$category->id])}}" class="btn btn-sm btn-primary mx-1">Show</a>
                                <!-- Execution Edit পেজ এ যাওয়ার সাথে সাথে এখান থেকে row  আইডি যাবে। -->
                                <a href="{{route('categories.edit', ['category'=>$category->id])}}" class="btn btn-sm btn-info mx-1">Edit</a>
                                <!-- Execution Delete পেজ এ যাওয়ার সাথে সাথে এখান থেকে row  আইডি যাবে। -->
                                <form action="{{ route('categories.destroy', ['category'=>$category->id])}}" method="post" style="display: inline">
                                    @csrf
                                    @method('delete')
                                    <button onclick="confirm('Are you sure ?')" class="btn btn-sm btn-danger mx-1" type="submit">Delete</button>
                                    <!-- or <button onclick="alert('Are you sure ?')" class="btn btn-sm btn-danger" type="submit">Delete</button> -->
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$categories->links()}}
        </div>
    </div>
</x-backend.layouts.master>