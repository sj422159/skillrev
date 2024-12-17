@extends('nontechmanager/hostel/layout')

@section('container')
<div class="container mt-4">
    <h2 class="text-center bg-primary text-white p-3">Create Expense Item</h2>
    <a href="{{ route('subcategory.index') }}" class="btn btn-secondary mb-3">Back to Subcategories</a>

    <div id="uploadSection">
        <button id="bulkUploadButton" class="btn btn-primary mb-3">Bulk Upload</button>
    </div>

    <!-- Bulk Upload Section -->
    <div id="bulkUploadForm" style="display: none;">
        <div class="mb-3">
            <a href="#" class="btn btn-success">Download Template</a>
        </div>
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="bulkFile" class="form-label">Upload XLSX File</label>
                <input type="file" class="form-control" id="bulkFile" name="bulkFile" accept=".xlsx" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload File</button>
        </form>
    </div>

    <!-- Single Input Section -->
    <div id="singleInputForm" class="card p-4 mt-4">
        <form action="{{ route('item.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="mb-3">
                    <label for="groupid" class="form-label">Group</label>
                    <select class="form-select" id="groupid" name="groupid" required>
                        <option value="" selected disabled>Select Group</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->Group }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="categoryid" class="form-label">Category</label>
                    <select class="form-select" id="categoryid" name="categoryid" required>
                        <option value="" selected disabled>Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->Category }}</option>
                        @endforeach
                    </select>
                </div>
                
                
                
            </div>

            <div class="row mb-3">
                <div class="mb-3">
                    <label for="subcategoryid" class="form-label">Subcategory</label>
                    <select class="form-select" id="subcategoryid" name="subcategoryid" required>
                        <option value="" selected disabled>Select Subcategory</option>
                        @foreach($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}">{{ $subcategory->subcategory }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="name" class="form-label">Item Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" class="form-control" id="amount" name="amount" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Save Item</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('bulkUploadButton').addEventListener('click', function() {
        // Hide the single input form and show the bulk upload form
        document.getElementById('singleInputForm').style.display = 'none';
        document.getElementById('bulkUploadForm').style.display = 'block';
    });
</script>

@endsection
