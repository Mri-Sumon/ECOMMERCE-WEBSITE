<x-backend.layouts.master>

    <x-slot:page_title>
        Category
    </x-slot>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            <x-slot:title>
                Category Create | <a href="{{ route('categories.list')}}" class="text-decoration-none">List</a>
            </x-slot>
        </div>
        <div class="card-body">
            <form action="{{ route('categories.store')}}" method="POST" enctype="multipart/form-data">
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
                    <input type="text" name="title" value="{{old ('title')}}" class="form-control" id="title" aria-describedby="emailHelp">
                </div>

                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description" value="" placeholder="" cols="40" rows="5">
                    {{old ('description')}}
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</x-backend.layouts.master>