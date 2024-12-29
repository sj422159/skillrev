@extends($layout)
@section('title','Subcategories')
@section('container')
<div class="container">
    <!-- Blue Header -->
    <div class="bg-primary text-white text-center ">
        <h2 class="bg-primary text-white text-center py-2 mb-4">Create Subcategory</h2>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Container -->
    <div class="card p-4">
        <form action="{{ route('subcategory.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $subcategory->id ?? '' }}">

            <!-- Group and Category Fields in One Row -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="groupid">Group</label>
                        <select name="groupid" id="groupid" class="form-control" required>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}" {{ (isset($subcategory) && $subcategory->groupid == $group->id) ? 'selected' : '' }}>
                                    {{ $group->Group }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="categoryid">Category</label>
                        <select name="categoryid" id="categoryid" class="form-control" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ (isset($subcategory) && $subcategory->categoryid == $category->id) ? 'selected' : '' }}>
                                    {{ $category->Category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Subcategory Field -->
            <div class="form-group mb-3">
                <label for="subcategory">Subcategory</label>
                <input type="text" name="subcategory" id="subcategory" class="form-control" 
                       value="{{ $subcategory->subcategory ?? '' }}" required>
            </div>

            <!-- Submit Button -->
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    {{ isset($subcategory) ? 'Update' : 'Create' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
