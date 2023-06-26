<!-- এখানে ডিজাইনের জন্য HTML Class কাজ করে না। -->
<table>
    <thead>
        <tr>
            <th>Ser</th>
            <th>Name</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $category->title}}</td>
                <td>{{ $category->description}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
