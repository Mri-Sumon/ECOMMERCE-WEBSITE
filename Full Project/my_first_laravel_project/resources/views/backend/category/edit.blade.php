<x-backend.layouts.master>

    <x-slot:page_title>
        Category
    </x-slot>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            <x-slot:title>
                Category Update | <a href="{{ route('categories.list')}}" class="text-decoration-none">List</a>
            </x-slot>
        </div>
        <div class="card-body">
            <!-- Edit Form এর ডাটা update ফাইলে যাবে, একই সাথে index.blade.php (category list) ফাইলের যে row কে update করবো, সেই row এর জন্য ডাটাবেস থেকে যে id আসছে তা update ফাইলে যাবে। -->
            <form action="{{route('categories.update', ['category'=>$category->id])}}" method="POST" enctype="multipart/form-data">
                <!-- form এর ভীতর patch মেথড কে চেনায় দিতে হবে। -->
                @method('patch')
                <!-- @csrf use for error 419-PAGE EXPIRED -->
                @csrf

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
                
                <!-- CREATE ERROR MESSAGE FOR TITLE -->
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <!-- CREATE TITLE TEXT FIELD -->
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" value="{{old ('title', $category->title)}}" class="form-control" id="title" aria-describedby="emailHelp">
                </div>

                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description" value="" placeholder="" cols="40" rows="5">
                    {{old ('description', $category->description)}}
                    </textarea>
                </div>
                <!-- description এর value ট্যাগ থাকেনা, তাই বাইরে use করা হয়েছে। -->
                
                @error('image')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="mb-3">
                    <label for="file" class="form-label">Upload Image</label>
                    <input type="file" name="image" id="file">
                </div>
                <!-- image এর value ট্যাগ থাকেনা, তাই বাইরে use করা হয়েছে। -->
                {{old ('image')}}

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-backend.layouts.master>