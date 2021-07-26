@extends('layouts.app')

@section('content')
    <div class="col-12 heading">
        <h4>{{__('nav.links.exam')}}</h4>
        <a href="/exams/{{$exam->id}}"  class="btn btn-primary float-right">{{__('form.back')}}</a>
    </div>

    <div class="row">
        <div class="col-2 align-self-middle">
            <a href="/patients/{{ $exam->patient->id }}"><img src="{{ asset($exam->patient->image) }}" style="width:70%;"/></a>
        </div>
        <div class="col-10">
            <div class="row">
                <div class="col-5">
                    <label>{{__('exam.patient')}}:</label> <a href="/patients/{{ $exam->patient->id }}">{{ $exam->patient->fullname() }}</a><br>
                    <label>{{__('patient.birthdate')}}:</label> {{ $exam->patient->birthdate }}<br>
                    <label>{{__('patient.height')}}:</label> {{ $exam->patient->height }} cm<br>
                    <label>{{__('patient.weight')}}:</label> {{ $exam->patient->weight }} kg
                </div>
                <div class="col-7">
                    <label>{{__('patient.created_at')}}:</label> {{ $exam->patient->created_at }}<br>
                    <label>{{__('patient.updated_at')}}:</label> {{ $exam->patient->updated_at }}
                    <br>
                    <label>{{__('exam.time')}}:</label> {{ $exam->begin }} - {{ $exam->end }}<br>
                    <label>{{__('exam.user')}}:</label> <a href="/users/{{ $exam->user->id }}">{{ $exam->user->name }}</a>
                </div>
                <div class="col-12">
                    <label>{{__('exam.comments')}}:</label>{{ $exam->comments }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 heading">
        <h5>{{__('nav.links.exam_alarms')}}</h5>
    </div>

    <div class="row">
        <table class="table table-sm col-10 offset-1">
            <thead>
                <tr>
                    <th scope="col">{{__('exam.alarms.type')}}</th>
                    <th scope="col">{{__('exam.alarms.sensor')}}</th>
                    <th scope="col">{{__('exam.alarms.value')}}</th>
                    <th scope="col">{{__('exam.alarms.time')}}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $last = [
                        "temp" => "",
                        "resp" => "",
                        "pulse" => "",
                        "spo2" => "",
                        "galvanic" => "",
                        "bodypos" => "",
                        ];
                @endphp

                @foreach ($exam->alarms() as $alarm)
                    @php
                        $sensor = $exam->shield->sensors->where('uid', $alarm->sensor)->first();
                    @endphp

                    @if ($alarm->value < $sensor->normlow && $last[$alarm->sensor] == "norm")
                        <tr class="table-danger">
                            <td>{{__('exam.alarms.high')}}</td>
                            <td>{{$sensor->name}}</td>
                            <td>{{$alarm->value}}</td>
                            <td>{{\Carbon\Carbon::createFromTimestamp($alarm->time)}}</td>
                            <td><a href="/exams/{{$exam->id}}/sensors/{{$sensor->id}}/{{$alarm->time}}"><i class="material-icons" title="{{__('datatables.details')}}">details</i></a></td>
                        </tr>
                        @php $last[$alarm->sensor] = "low"; @endphp
                    @elseif ($alarm->value > $sensor->normhigh && $last[$alarm->sensor] == "norm")
                        <tr class="table-warning">
                            <td>{{__('exam.alarms.low')}}</td>
                            <td>{{$sensor->name}}</td>
                            <td>{{$alarm->value}}</td>
                            <td>{{\Carbon\Carbon::createFromTimestamp($alarm->time)}}</td>
                            <td><a href="/exams/{{$exam->id}}/sensors/{{$sensor->id}}"><i class="material-icons" title="{{__('datatables.details')}}">details</i></a></td>
                        </tr>
                        @php $last[$alarm->sensor] = "high"; @endphp
                    @elseif ($alarm->value >= $sensor->normlow && $last[$alarm->sensor] != "norm" && $alarm->value <= $sensor->normhigh)
                        <tr class="table-success">
                            <td>{{__('exam.alarms.norm')}}</td>
                            <td>{{$sensor->name}}</td>
                            <td>{{$alarm->value}}</td>
                            <td>{{\Carbon\Carbon::createFromTimestamp($alarm->time)}}</td>
                            <td><a href="/exams/{{$exam->id}}/sensors/{{$sensor->id}}"><i class="material-icons" title="{{__('datatables.details')}}">details</i></a></td>
                        </tr>
                        @php $last[$alarm->sensor] = "norm"; @endphp
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
