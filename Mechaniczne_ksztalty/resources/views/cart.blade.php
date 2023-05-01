@extends('layouts.app')

@section('content')
<table id="cart" class="table table-hover table-condensed">
    <thead>
        <tr>
        <th style="width:50%">{{ __('Products') }}</th>
            <th style="width:10%">{{ __('Price') }}</th>
            <th style="width:8%">{{ __('Quantity') }}</th>
            <th style="width:22%" class="text-center">{{ __('Subtotal') }}</th>
            <th style="width:10%">{{ __('Delete') }}</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0 @endphp
        @if(session('cart'))
            @foreach(session('cart') as $id => $details)
                @php $total += $details['price'] * $details['quantity'] @endphp
                <tr data-id="{{ $id }}">
                    <td data-th="Product">
                        <div class="row">
                            <div class="col-sm-3 hidden-xs">
                            <img src="{{ asset('storage/') }}/{{ $details['photo'] }}"  class="img-fluid mx-auto d-block" alt="Zdjęcie produktu">
                            </div>
                            <div class="col-sm-9">
                                <h4 class="nomargin">{{ $details['product_name'] }}</h4>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price">{{ $details['price'] }} PLN</td>
                    <td data-th="Quantity">
                        <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity cart_update" min="1" />
                    </td>
                    <td data-th="Subtotal" class="text-center">{{ $details['price'] * $details['quantity'] }} PLN</td>
                    <td class="actions" data-th="Delete">
                        <button class="btn btn-danger btn-sm cart_remove"><i class="fa fa-trash-o"></i></button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-end"><h3><strong>{{ __('Total:') }} {{ $total }} PLN</strong></h3></td>
        </tr>
        <tr>
            <td colspan="5" class="text-end">
                <a href="{{ url('/') }}" class="btn btn-danger"> <i class="fa fa-arrow-left"></i> {{ __('Continue Shopping') }}</a>
                <button class="btn btn-success"><i class="fa fa-money"></i> {{ __('Checkout') }}</button>
            </td>
        </tr>
    </tfoot>
</table>   
@endsection
@section('scripts')
<script type="text/javascript">
   
    $(".cart_update").change(function (e) {
        e.preventDefault();
   
        var ele = $(this);
   
        $.ajax({
            url: '{{ route('update_cart') }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}', 
                id: ele.parents("tr").attr("data-id"), 
                quantity: ele.parents("tr").find(".quantity").val()
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });
   
    $(function() {
  $('.cart_remove').click(function(e) {
    e.preventDefault();
    var ele = $(this);
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
          url: '{{ route('remove_from_cart') }}',
          method: 'DELETE',
          data: {
            _token: '{{ csrf_token() }}',
            id: ele.parents('tr').attr('data-id')
          },
          success: function(response) {
            Swal.fire(
              '{{ __('Deleted!') }}',
              '{{ __('Your item has been deleted.') }}',
              'success'
            ).then((result) => {
              window.location.reload();
            });
          },
          error: function(response) {
            Swal.fire(
              'Oops...',
              'Something went wrong!',
              'error'
            );
          }
        });
      }
    });
  });
});
   
</script>
@endsection