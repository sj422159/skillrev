@extends($layout)
@section('title','Subcategories')
@section('container')
<div class="container">
    <h2>Expense Subcategories</h2>
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('subcategory.create') }}" class="btn btn-primary">Add New Subcategory</a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <!-- Display message if no subcategories are found -->
    @if($subcategories->isEmpty())
        <div class="alert alert-warning">No subcategories present.</div>
    @else
        <table class="table table-bordered">
            <thead style="background-color: black; color: white;">
                <tr>
                    <th>Group</th>
                    <th>Category</th>
                    <th>Subcategory</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subcategories as $subcategory)
                    <tr>
                        <td>{{ $subcategory->group->Group ?? 'N/A' }}</td>
                        <td>{{ $subcategory->category->Category ?? 'N/A' }}</td>
                        <td>{{ $subcategory->subcategory }}</td>
                        <td>
                            <!-- Link to Edit -->
                            <a href="{{ route('subcategory.create', ['id' => $subcategory->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                            
                            <!-- Form for Delete -->
                            <form action="{{ route('subcategory.delete', $subcategory->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Are you sure you want to delete this subcategory?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
