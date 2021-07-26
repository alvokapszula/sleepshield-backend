@extends('layouts.app')

@section('content')
<div class="col-12 heading">
    <h4>{{$sensor->shield->name}} {{$sensor->name}}</h4>
    <a href="{{ url()->previous() }}"  class="btn btn-primary float-right">{{__('form.back')}}</a>
</div>

<div class="row">
    <div class="col-6">
        <label>{{__('exam.patient')}}:</label> <a href="/patients/{{ $exam->patient->id }}">{{ $exam->patient->fullname() }}</a><br>
        <label>{{__('exam.user')}}:</label> <a href="/users/{{ $exam->user->id }}">{{ $exam->user->name }}</a>
    </div>
    <div class="col-6">
        <label>{{__('exam.time')}}:</label> {{ $exam->begin }} - {{ $exam->end }}<br>
    </div>
</div>

<div id="chartdiv" class="col-12" style="width: 100%; min-height: 400px">

</div>
@endsection

@push('scripts')
    <?php $locale = app()->getLocale(); ?>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/moment-locale-'.$locale.'.js') }}"></script>
    <script src="{{ asset('js/echarts-en.min.js') }}" charset="utf-8"></script>
    <script src="{{ asset('js/mqttws31.min.js')}}" type="text/javascript"></script>
    <script>

        {!! $sensor->fullchart($exam, $time) !!}

    </script>
@endpush
