@extends('layouts.app')

@section('content')
<div class="container">
  @include('helpers.messages')
  <div class="row">
    <div class="col-6">
        <h1>{{ __('Products list') }}</h1>
    </div>
    <div class="col-6">
        <a class="d-grid gap-2 d-md-flex justify-content-md-end" href="{{route('products.create')}}">
        <button type="button" class="btn btn-primary"><x-ri-add-fill />
{{ __('Add') }}</button>
        </a>
    </div>
  </div>
<div class="row">
<table class="table table-hover">
<thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">{{ __('Product name') }}</th>
      <th scope="col">{{ __('Description') }}</th>
      <th scope="col">{{ __('Amount') }}</th>
        <th scope="col">{{ __('Price') }}</th>
        <th scope="col">{{ __('Category') }}</th>
      <th scope="col">{{ __('Actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach($products as $product)
        <tr>
            <th scope="row">{{$product->id}}</th>
            <td>{{$product->name}}</td>
            <td>{{$product->description}}</td>
            <td>{{$product->amount}}</td>
            <td>{{$product->price}}</td>
            <td>@if ($product->hasCategory()){{$product->category->name}}@endif</td>
            <td>
            <a href="{{route('products.show', $product->id)}}">
              <button class="btn btn-primary btn-sm">
                S
              </button>
              </a>
              <a href="{{route('products.edit', $product->id)}}">
              <button class="btn btn-success btn-sm">
              <x-bi-pencil-fill />
              </button>
              </a>
              <button class="btn btn-danger btn-sm delete" data-id="{{$product->id}}">
              <x-bi-trash />
              </button>
            </td>
        </tr>
    @endforeach
  </tbody>
</table>
{{ $products->links() }}
</div>
</div>
@endsection
@section('javascript')
    $(function() {
        $('.delete').click(function() {

          Swal.fire({
            title: '{{ __('Are you sure?') }}',
            text: "{{ __('You will not be able to revert this!') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{ __('Yes') }}',
            cancelButtonText: '{{ __('Cancel') }}'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
                method: "DELETE",
                url: "http://shop.test/products/" + $(this).data("id")
              })
              .done(function(response) {
                window.location.reload();
            })
            .fail(function(response) {
              Swal.fire('Oops...','Something went wrong!','error');
            });
          }
        })
      });
    });
@endsection