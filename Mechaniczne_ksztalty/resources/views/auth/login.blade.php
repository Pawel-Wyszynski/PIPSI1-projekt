@extends('layouts.app')

@section('content')
<section>
<div class="container">
    <div class="user signinBx">
                <div class="imgBx"><img src="https://lh3.googleusercontent.com/rNQ2s7ja8o6OpoInvAfuKRro5rqZeso1Zb2wjWoPm2tUzmSGC7ZNBDQFQDTmWSiR45Kavi8pIbz_V7k6wvISmskflj_Op_-gZzHiiUPE2L2AoDd8ozj5mRJEyO_VhFKMzg6HxFzY=w2400"></div>
                <div class="formBx">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <h2>{{ __('Login') }}</h2>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="E-mail" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Hasło">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
