<x-backend.layouts.master>

    <x-slot:page_title>
        Product
    </x-slot>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            <x-slot:title>
                Products Update | <a href="{{ route('products.list')}}" class="text-decoration-none">List</a>
            </x-slot>
        </div>
        <div class="card-body">
            <form action="{{ route('products.update', ['product'=>$product->id])}}" method="POST" enctype="multipart/form-data">
                <!-- @csrf use for error 419-PAGE EXPIRED -->
                @csrf
                @method('patch')
                <!-- SHOW ERROR AS LIST -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- CREATE ERROR MESSAGE FOR NAME -->
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <!-- CREATE NAME TEXT FIELD -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" value="{{old ('name', $product->name)}}" class="form-control" id="name" aria-describedby="emailHelp">
                </div>

                <!-- CREATE ERROR MESSAGE FOR DESCRIPTION -->
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <!-- CREATE DESCRIPTION TEXT FIELD -->
                <div class="mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description" value="" placeholder="" cols="40" rows="5">
                    {{old ('description', $product->description)}}
                    </textarea>
                    <!-- description এর value ট্যাগ থাকেনা, তাই বাইরে use করা হয়েছে। -->
                </div>


                <!-- CREATE ERROR MESSAGE FOR CATEGORY -->
                @error('category')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <!-- CREATE CATEGORY OPTION -->
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" name="category" aria-label="">
                        <option disabled>Select Category</option>
                        @foreach ($categories as $category)
                            <!-- যেখানে category id ও product id সমান হবে, সেটি সিলেক্টেড অবস্থায় থাকবে। -->
                            <option @selected($category->id == $product->category_id) value="{{old ('category', $category->id)}}">{{$category->title}}</option>
                        @endforeach
                    </select>
                </div>
                

                <!-- CREATE ERROR MESSAGE FOR PRICE -->
                @error('price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <!-- CREATE PRICE TEXT FIELD -->
                <div class="mb-3">
                    <label for="Price" class="form-label">Price</label>
                    <input type="Number" name="price" value="{{old ('Price', $product->price)}}" class="form-control" id="Price" aria-describedby="emailHelp">
                </div>

                <!-- IMAGE UPLOAD-->
                <div class="mb-3 form-check">
                    <label for="file">Image</label>
                    <img src="{{ asset('storage/products/'.$product->image)}}" alt="product image" height="150" width="200">
                    <input type="file" name="image" id="file">
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-backend.layouts.master>