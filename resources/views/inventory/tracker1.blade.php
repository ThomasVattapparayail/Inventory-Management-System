@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h3 class="text-center mt-5">Inventory Tracker</h3>
  <div class="row card">
    <table class="card-body">
        <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Update Quantity</th>
        </tr>
        @foreach ($inventory as $item)
            <tr class="card-body">
                <td>{{ $item->name }}</td>
                <td>{{ $item->quantity }}</td>
                @auth
             @if(Auth::user()->username=="admin")
                <td>
                    <form method="post" action="/inventory/update/{{ $item->id }}">
                        @csrf
                        <input type="number" name="quantity" value="{{ $item->quantity }}">
                        <button type="submit">Update</button>
                    </form>
                </td>
             @else
             <td><p>Action Restricted</p><td> 
            @endif 
            @endauth     
            </tr>
        @endforeach
    </table>
  </div>
</div> 
@endsection
