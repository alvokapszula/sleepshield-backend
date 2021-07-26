@extends('layouts.app')

@section('content')
  <div class="row align-items-center">

        @foreach ($shields as $shield)
        <div class="col-sm-6 col-lg-4">
          <div class="card mx-auto home @if ($shield->is_occupied()) occupied @endif ">
              <a href="/shields/{{__($shield->id)}}">
            <img class="card-img-top" src="{{ __('home.card.img') }}" alt="{{ __('home.card.alt') }}">
            </a>
            <div class="card-footer text-center px-0 py-1">
                 @if ($shield->is_occupied())
                    {{ __('home.card.occupied') }}
                 @else
                    {{ __('home.card.free') }}
                 @endif
            </div>
          </div>
        </div>
        @endforeach

  </div>
@endsection
