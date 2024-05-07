@extends('layouts.app')
@section('content')
    <!-- Page Heading -->

    <!-- Content  -->

    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Inventory Tracker</h1>
           
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Inventory Data </h6>
            </div>
            <div class="card-body">
                
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Update Quantity</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Update Quantity</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($inventory  as $inventoryItem)
                            <tr>
                                <td>{{ $inventoryItem->name }}</td>
                                <td>{{ $inventoryItem->quantity }}</td>
                                @auth
                                 @if(Auth::user()->username=="admin")
                                 <td>
                                    <form method="post" action="/inventory/update/{{ $inventoryItem->id }}">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $inventoryItem->quantity }}">
                                        <button type="submit">Update</button>
                                    </form>
                                </td>                              
                                @else
                                  <td><p>Action rescricted</p>
                                @endif
                                @endauth
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
 @endsection   