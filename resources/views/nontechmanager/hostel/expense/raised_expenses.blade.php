@extends($layout)
@section('title', 'New Expense')
@section('container')
<div class="container">
    <div class="header" style="background-color: blue; color: white; padding: 10px;">
        <h1 style="color: white;">Raise Expense</h1>
    </div>
    <div class="box" style="border: 1px solid #ccc; padding: 20px; margin-top: 20px;">
        <form action="{{ isset($expense) ? route('nontech.manager.raise.update_expense', ['id' => $expense->id]) : route('nontech.manager.raise.store_expense') }}" method="POST">
            @csrf

            <div class="row">
                <div class="form-group col-md-4">
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

                <div class="form-group col-md-4">
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

                <div class="form-group col-md-4">
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
            </div>

            <div class="table-responsive" style="margin-top: 20px;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Group</th>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>Items</th>
                            <th>Quantity</th>
                            <th>Quantity Measure</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="items-container">
                        <!-- Items will be dynamically added here -->
                    </tbody>
                </table>
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

        const fetchItems = async () => {
            const groupId = group.value;
            const categoryId = category.value;
            const subcategoryId = subcategory.value;

            if (!subcategoryId) {
                itemsContainer.innerHTML = ''; // Clear items if subcategory is not selected
                return;
            }

            try {
                const response = await fetch(`/get-filtered-items?group_id=${groupId}&category_id=${categoryId}&subcategory_id=${subcategoryId}`);
                const data = await response.json();

                if (data.success) {
                    itemsContainer.innerHTML = ''; // Clear previous items
                    const selectedItems = @json(isset($expense) ? $expenseItems : []);

                    // Dynamically add rows to the table
                    data.items.forEach(item => {
                        const isChecked = selectedItems.some(selected => selected.item_id === item.id);
                        const row = `
                            <tr>
                                <td>${item.group_name}</td>
                                <td>${item.category_name}</td>
                                <td>${item.subcategory_name}</td>
                                <td>${item.item}</td>
                                <td>
                                    <input type="number" name="quantity[${item.id}]" class="form-control" value="${isChecked ? item.quantity : ''}" required>
                                </td>
                                <td>
                                    <select name="quantity_measure[${item.id}]" class="form-control" required>
                                        <option value="">Select Measure</option>
                                        @foreach ($quantity_measures as $measure)
                                            <option value="{{ $measure }}" ${isChecked && selectedItems.find(selected => selected.item_id === item.id)?.quantity_measure === '{{ $measure }}' ? 'selected' : ''}>
                                                {{ $measure }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm delete-item" data-item-id="${item.id}">Delete</button>
                                </td>
                            </tr>`;
                        itemsContainer.innerHTML += row;
                    });

                    // Attach delete event to buttons
                    document.querySelectorAll('.delete-item').forEach(button => {
                        button.addEventListener('click', function () {
                            this.closest('tr').remove();
                        });
                    });
                }
            } catch (error) {
                console.error('Error fetching items:', error);
            }
        };

        // Attach change events to dropdowns
        [group, category, subcategory].forEach(element => {
            element.addEventListener('change', fetchItems);
        });

        // Fetch items on page load if editing
        if (@json(isset($expense))) {
            fetchItems();
        }
    });
</script>
@endsection
