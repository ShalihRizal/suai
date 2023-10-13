@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Parts</h1>

    <!-- Filter form -->
    <form method="GET" action="{{ route('part') }}">
        <div class="form-group">
            <label for="part_category_filter">Filter by Part Category:</label>
            <select id="part_category_filter" name="part_category">
                <option value="">All</option>
                @foreach ($partcategories as $partcategory)
                    <option value="{{ $partcategory->id }}"
                        @if ($partCategoryFilter == $partcategory->id)
                            selected
                        @endif
                    >{{ $partcategory->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Apply Filter</button>
    </form>

    <!-- Display filtered parts -->
    <table class="table">
        <thead>
            <tr>
                <th>Part Number</th>
                <th>Part Name</th>
                <th>Part Category</th>
                <!-- Add other table headers as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach ($parts as $part)
                <tr>
                    <td>{{ $part->part_no }}</td>
                    <td>{{ $part->name }}</td>
                    <td>{{ $part->partCategory->name }}</td>
                    <!-- Add other table cells as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
