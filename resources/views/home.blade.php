@extends('layouts.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        @auth
        @if(Auth::user()->username=="admin")
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">
            Upload Inventory CSV 
        </button>
        @endif
       
        @if(Auth::user()->username=="admin" || Auth::user()->username=="superadmin") 
        <a href="{{url('/inventory/generateReport')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        @endif
        @endauth        
    </div>

    <!-- Content  -->

    <div class="container-fluid">
        @if(Auth::user()->role=="admin")
        @forelse ($notifications as $notification)
            <div class="alert alert-danger" role="alert">
                <p>This stock <b>{{$notification->data['name']}}</b> is low. Quantity is <b>{{$notification->data['quantity']}}.</b> </p>
                 <a href="#" class="float-right mark-as-read" data-id="{{$notification->id}}">Mark as read</a>  
            </div>
            @if($loop->last)
              <a href="#" id="mark-all">Mark all as read</a>
            @endif     
        @empty
           <p>There is no notification </p>                         
        @endforelse
        @endif
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Inventory Tables</h1>
        @auth
        @if(Auth::user()->username=="admin")
            <a type="button" href="/inventory-items/create" class="btn btn-primary offset-md-10" >
                Add Inventory Item
            </a>
        @endif
        @endauth    
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
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($inventoryItems as $inventoryItem)
                            <tr>
                                <td>{{ $inventoryItem->name }}</td>
                                <td>{{ $inventoryItem->description }}</td>
                                <td>{{ $inventoryItem->quantity }}</td>
                                <td>{{ $inventoryItem->price }}</td>
                                @auth
                                 @if(Auth::user()->username=="admin")
                                <td>
                                    <a href="{{ route('inventory-items.edit', $inventoryItem->id) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('inventory-items.destroy', $inventoryItem->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
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
    
 
<!-- Content Row -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload CSV File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('import.inventory.csv') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="csv_file" class="form-label">Choose CSV File:</label>
                        <input type="file" class="form-control" id="csv_file" name="csv_file">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.mark-as-read',(function(e) {
            e.preventDefault();
            var notificationId = $(this).data('id');

            $.ajax({
                url: '/mark-notification/' +notificationId,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $(e.target).closest('.alert').remove();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }));

        $('#mark-all').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: '/mark-all-notifications',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('.alert').remove();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
