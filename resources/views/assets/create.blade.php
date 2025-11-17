@extends('layouts.app')

@section('title', 'Add Asset')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add New Asset</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('assets.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Asset Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="serial_number" class="form-label">Serial Number</label>
                        <input type="text" class="form-control" id="serial_number" name="serial_number" required>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="laptop">Laptop</option>
                    <option value="mobile">Mobile</option>
                    <option value="tablet">Tablet</option>
                    <option value="monitor">Monitor</option>
                    <option value="accessory">Accessory</option>
                    <option value="furniture">Furniture</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="purchase_price" class="form-label">Purchase Price ($)</label>
                        <input type="number" step="0.01" class="form-control" id="purchase_price" name="purchase_price">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="purchase_date" class="form-label">Purchase Date</label>
                        <input type="date" class="form-control" id="purchase_date" name="purchase_date">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="available">Available</option>
                    <option value="maintenance">Under Maintenance</option>
                    <option value="retired">Retired</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Asset</button>
            <a href="{{ route('assets.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection