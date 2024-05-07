@extends('layouts.app')

@section('content')
@auth
  @if(Auth::user()->username=="admin")
    <div class="card o-hidden border-0 shadow-lg my-5"></div>  
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-7 ">
                <div class="p-5 card offset-md-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Create an Inventory Item</h1>
                    </div>
                    <form action="{{ route('inventory-items.update', $inventoryItem->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $inventoryItem->name) }}" >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $inventoryItem->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', $inventoryItem->quantity) }}" >
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $inventoryItem->price) }}" >
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update Inventory Item</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
 @endif

@endauth    


@endsection
