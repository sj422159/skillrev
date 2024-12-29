@extends($layout)
@section('title','Items')
@section('container')
<div class="container mt-4">
    <h2 class="text-center bg-primary text-white p-3 rounded">
        {{ isset($item) ? 'Edit Expense Item' : 'Create Expense Item' }}
    </h2>

    <!-- Toggle Buttons for Forms -->
    <div id="uploadSection" class="text-center my-4">
        <button id="bulkUploadButton" class="btn btn-primary mx-2">Bulk Upload</button>
        <button id="singleInputButton" class="btn btn-secondary mx-2">Single Entry</button>
    </div>

    <!-- Bulk Upload Section -->
    <div id="bulkUploadForm" class="card p-4 mt-4" style="display: none;">
        <h4 class="text-center">Bulk Upload</h4>
        <div class="text-end mb-3">
            <a href="#" class="btn btn-success">Download Template</a>
        </div>
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="bulkFile" class="form-label">Upload XLSX File</label>
                <input type="file" class="form-control" id="bulkFile" name="bulkFile" accept=".xlsx" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Upload File</button>
            </div>
        </form>
    </div>

    <!-- Single Input Section -->
    <div id="singleInputForm" class="card p-4 mt-4">
        <h4 class="text-center">Single Expense Item Entry</h4>
        <form action="{{ isset($item) ? route('item.update', $item->id) : route('item.store') }}" method="POST">
            @csrf
            @if(isset($item))
                @method('PUT')
            @endif
        
            <!-- Group, Category, Subcategory Fields -->
            <div class="row mb-4">
                <!-- Group -->
                <div class="col-md-4">
                    <label for="groupid" class="form-label">Group</label>
                    <select class="form-select" id="groupid" name="groupid" required>
                        <option value="" selected disabled>Select Group</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" 
                                {{ isset($item) && $item->groupid == $group->id ? 'selected' : '' }}>
                                {{ $group->Group }}
                            </option>
                        @endforeach
                    </select>
                </div>
        
                <!-- Category -->
                <div class="col-md-4">
                    <label for="categoryid" class="form-label">Category</label>
                    <select class="form-select" id="categoryid" name="categoryid" required>
                        <option value="" selected disabled>Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ isset($item) && $item->categoryid == $category->id ? 'selected' : '' }}>
                                {{ $category->Category }}
                            </option>
                        @endforeach
                    </select>
                </div>
        
                <!-- Subcategory -->
                <div class="col-md-4">
                    <label for="subcategoryid" class="form-label">Subcategory</label>
                    <select class="form-select" id="subcategoryid" name="subcategoryid" required>
                        <option value="" selected disabled>Select Subcategory</option>
                        @foreach($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}" 
                                {{ isset($item) && $item->subcatid == $subcategory->id ? 'selected' : '' }}>
                                {{ $subcategory->subcategory }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        
            <!-- Item Name and Quantity Row -->
            <div class="row mb-4">
                <!-- Item Name -->
                <div class="col-md-6">
                    <label for="name" class="form-label">Item Name</label>
                    <input type="text" class="form-control" id="name" name="name" 
                        value="{{ old('item', $item->item ?? '') }}" placeholder="Enter item name" required>
                </div>
        
                <!-- Quantity -->
                <div class="col-md-6">
                    <label for="quantity" class="form-label">Quantity Measure</label>
                    <input type="text" class="form-control" id="amount" name="amount" 
                        value="{{ old('quantity', $item->quantity ?? '') }}" placeholder="Enter quantity Measure(kg,L,etc)" required>
                </div>
            </div>
        
            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary">
                    {{ isset($item) ? 'Update Item' : 'Save Item' }}
                </button>
            </div>
        </form>
        
        
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bulkUploadButton = document.getElementById('bulkUploadButton');
        const singleInputButton = document.getElementById('singleInputButton');
        const bulkUploadForm = document.getElementById('bulkUploadForm');
        const singleInputForm = document.getElementById('singleInputForm');

        // Show Bulk Upload Form
        bulkUploadButton.addEventListener('click', () => {
            singleInputForm.style.display = 'none';
            bulkUploadForm.style.display = 'block';
            bulkUploadButton.classList.add('btn-primary');
            bulkUploadButton.classList.remove('btn-secondary');
            singleInputButton.classList.remove('btn-primary');
            singleInputButton.classList.add('btn-secondary');
        });

        // Show Single Input Form
        singleInputButton.addEventListener('click', () => {
            bulkUploadForm.style.display = 'none';
            singleInputForm.style.display = 'block';
            singleInputButton.classList.add('btn-primary');
            singleInputButton.classList.remove('btn-secondary');
            bulkUploadButton.classList.remove('btn-primary');
            bulkUploadButton.classList.add('btn-secondary');
        });
    });
</script>
@endsection
