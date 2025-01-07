@extends($layout)

@section('container')
<div class="container">
    <div class="header" style="background-color: blue; color: white; padding: 10px;">
        <h1 style="color: white;">Raise Expense</h1>
    </div>
    <div class="box" style="border: 1px solid #ccc; padding: 20px; margin-top: 20px;">
        <form action="{{ isset($expense) ? route('nontech.manager.raise.update_expense', ['id' => $expense->id]) : route('nontech.manager.raise.store_expense') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="group">Group</label>
                    <select name="group" id="group" class="form-control">
                        <option value="">Select Group</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}" {{ isset($expense) && $expense->groupid == $group->id ? 'selected' : '' }}>
                                {{ $group->Group }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="form-control">
                        <option value="">Select Category</option>
                        @foreach ($categories as $id => $category)
                            <option value="{{ $id }}" {{ isset($expense) && $expense->categoryid == $id ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="subcategory">Subcategory</label>
                    <select name="subcategory" id="subcategory" class="form-control">
                        <option value="">Select Subcategory</option>
                        @foreach ($subcategories as $id => $subcategory)
                            <option value="{{ $id }}" {{ isset($expense) && $expense->subcatid == $id ? 'selected' : '' }}>
                                {{ $subcategory }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="border: 1px solid #ccc; padding: 10px; max-height: 200px; overflow-y: auto;" id="items-container">
                    @foreach ($items as $item)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="item[]" value="{{ $item->id }}" 
                                    {{ isset($expense) && in_array($item->id, $expenseItems) ? 'checked' : '' }}>
                                {{ $item->item_name }} <!-- Replace 'item_name' with the correct attribute -->
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="quantity_measure">Quantity Measure</label>
                    <select name="quantity_measure" id="quantity_measure" class="form-control">
                        <option value="">Select Measure</option>
                        @foreach ($quantity_measures as $measure)
                            <option value="{{ $measure }}" {{ isset($expense) && $expense->quantity_measure == $measure ? 'selected' : '' }}>
                                {{ $measure }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="quantity">Quantity</label>
                    <input type="text" name="quantity" id="quantity" class="form-control" 
                        value="{{ isset($expense) ? explode('_', $expense->quantity)[0] : '' }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const group = document.getElementById('group');
        const category = document.getElementById('category');
        const subcategory = document.getElementById('subcategory');
        const itemsContainer = document.getElementById('items-container');

        const fetchItems = () => {
            const groupId = group.value;
            const categoryId = category.value;
            const subcategoryId = subcategory.value;

            fetch(`/get-filtered-items?group_id=${groupId}&category_id=${categoryId}&subcategory_id=${subcategoryId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        itemsContainer.innerHTML = ''; // Clear previous items
                        const selectedItems = @json(isset($expense) ? $expenseItems : []);

                        // Dynamically add checkboxes
                        data.items.forEach(item => {
                            const isChecked = selectedItems.includes(Number(item.id));
                            const checkbox = `
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="item[]" value="${item.id}" ${isChecked ? 'checked' : ''}>
                                        ${item.item_name}
                                    </label>
                                </div>`;
                            itemsContainer.innerHTML += checkbox;
                        });

                        // Reapply 'checked' state explicitly
                        const checkboxes = itemsContainer.querySelectorAll('input[type="checkbox"]');
                        checkboxes.forEach(checkbox => {
                            const isChecked = selectedItems.includes(Number(checkbox.value));
                            checkbox.checked = isChecked; // Force checked state
                        });
                    }
                });
        };

        // Attach change events to dropdowns
        group.addEventListener('change', fetchItems);
        category.addEventListener('change', fetchItems);
        subcategory.addEventListener('change', fetchItems);

        // Fetch items on page load if editing
        if (@json(isset($expense))) {
            fetchItems();
        }
    });
</script>



@endsection
