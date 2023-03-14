@extends('layouts.app')

@section('content')
<div class="container">
<table class="table table-hover">
<thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Email</th>
      <th scope="col">Name</th>
      <th scope="col">Surname</th>
        <th scope="col">PhoneNumber</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($users as $user)
        <tr>
            <th scope="row">{{$user->id}}</th>
            <td>{{$user->email}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->surname}}</td>
            <td>{{$user->phone_number}}</td>
            <td>
              <button class="btn btn-danger btn-sm delete" data-id="{{$user->id}}">
                X
              </button>
            </td>
        </tr>
    @endforeach
  </tbody>
</table>
{{ $users->links() }}
</div>
@endsection
@section('javascript')
    $(function() {
        $('.delete').click(function() {

          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
                method: "DELETE",
                url: "http://shop.test/users/" + $(this).data("id")
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