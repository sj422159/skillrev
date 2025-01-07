@extends($layout)

@section('container')
<div class="container">
    <div class="header" style="background-color: blue; color: white; padding: 10px;">
        <h1 style="color: white;">Edit Expense</h1>
    </div>
    <div class="box" style="border: 1px solid #ccc; padding: 20px; margin-top: 20px;">
        <form action="{{ route('nontech.manager.raise.update_expense', ['id' => $expense->id]) }}" method="POST">
            @csrf
            
            <div class="row">
                <!-- Group -->
                <div class="form-group col-md-6">
                    <label for="group">Group</label>
                    <select name="group" id="group" class="form-control">
                        <option value="">Select Group</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}" {{ $expense->groupid == $group->id ? 'selected' : '' }}>
                                {{ $group->Group }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Category -->
                <div class="form-group col-md-6">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="form-control">
                        <option value="">Select Category</option>
                        @foreach ($categories as $id => $category)
                            <option value="{{ $id }}" {{ $expense->categoryid == $id ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <!-- Subcategory -->
                <div class="form-group col-md-6">
                    <label for="subcategory">Subcategory</label>
                    <select name="subcategory" id="subcategory" class="form-control">
                        <option value="">Select Subcategory</option>
                        @foreach ($subcategories as $id => $subcategory)
                            <option value="{{ $id }}" {{ $expense->subcatid == $id ? 'selected' : '' }}>
                                {{ $subcategory }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Items -->
                <div class="form-group col-md-6">
                    <label>Items</label>
                    <div style="border: 1px solid #ccc; padding: 10px; max-height: 200px; overflow-y: auto;" id="items-container">
                        @forelse ($items as $item)
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="item[]" value="{{ $item->id }}" 
                                        {{ in_array($item->id, $expenseItems ?? []) ? 'checked' : '' }}>
                                    {{ $item->item ?? 'Unnamed Item' }}
                                </label>
                            </div>
                        @empty
                            <p>No items available.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Quantity Measure -->
                <div class="form-group col-md-6">
                    <label for="quantity_measure">Quantity Measure</label>
                    <select name="quantity_measure" id="quantity_measure" class="form-control">
                        <option value="">Select Measure</option>
                        @foreach ($quantity_measures as $measure)
                            <option value="{{ $measure }}" {{ $expense->quantity && explode('_', $expense->quantity)[1] == $measure ? 'selected' : '' }}>
                                {{ $measure }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Quantity -->
                <div class="form-group col-md-6">
                    <label for="quantity">Quantity</label>
                    <input type="text" name="quantity" id="quantity" class="form-control" 
                        value="{{ $expense->quantity ? explode('_', $expense->quantity)[0] : '' }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
