@extends('layouts.app')

@section('content')
<div class="container pt-5">
              <div class="row">
                <div class="col-md-8 order-md-2 col-lg-9">
                  <div class="container-fluid">
                    <div class="row">
                      @forelse($products as $product)
                      <div class="col-6 col-md-6 col-lg-4 mb-3">
                        <div class="card h-100 border-0">
                          <div class="card-img-top">
                          @if(!is_null($product->image_path))
                            <img src="{{asset('storage/' . $product->image_path)}}" class="img-fluid mx-auto d-block" alt="Zdjęcie produktu">
                            @else
                              <img src="https://via.placeholder.com/240x240/5fa9f8/efefef" class="img-fluid mx-auto d-block" alt="Zdjęcie produktu">
                            @endif
                          </div>
                          <div class="card-body text-center">
                            <h4 class="card-title">
                            <a href="{{route('products.show', $product->id)}}" class=" font-weight-bold text-dark text-uppercase small"> {{$product->name}}</a>
                            </h4>
                            <h5 class="card-price small">
                              <i>PLN {{$product->price}} </i>
                            </h5>
                          </div>
                        </div>
                      </div>
                      @empty
                      <div>{{ __('No Results Found.') }}</div>
                      @endforelse
                      {{ $products->appends(request()->input())->links() }}
                    </div>
                  </div>
                </div>
                <div class="col-md-4 order-md-1 col-lg-3 sidebar-filter">
                <h3 class="mt-0 mb-5">{{ __('Products') }} <span class="text-primary">{{count($products)}}</span></h3>
                  
                  </div>
                  
                </div>

              </div>
            </div>
@endsection
    
