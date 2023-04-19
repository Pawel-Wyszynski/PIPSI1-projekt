<div class ="row">
  <div class="col-12">
  @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>

</div>
</div>
@endif
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>

</div>
</div>
@endif