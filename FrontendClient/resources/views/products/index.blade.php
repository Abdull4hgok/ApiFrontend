@extends('products.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Products</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>
                @if ($message = Session::get('logout'))
                                <a class="btn btn-danger" href="{{ route('logout') }}" style="float: right;"> Logout</a>

            <p>{{ $message }}</p>
        
    @endif

               
            </div>
        </div>
    </div>
    @if(\Session::has('status'))
    <div class="alert alert-success">
    {{\Session::get('success') }}
    </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Description</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($products as $product)
        <tr>
            <td>{{ $product['id'] }}</td> 
            <td>{{ $product['name'] }}</td>
            <td>{{ $product['price'] }}</td>
            <td>{{ $product['description'] }}</td>
            <td>
                <form action="{{ route('products.destroy',$product['id']) }}" method="GET">
                    <a class="btn btn-info" href="{{ route('products.show',$product['id']) }}">Show</a>
    
                    <a class="btn btn-primary" href="{{ route('products.edit',$product['id']) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
  {{-- {!! $products->links('products') !!} --}}
      
@endsection