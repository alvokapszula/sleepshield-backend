@extends('layouts.app')

@section('content')
    <div class="col-12 heading">
        <h4>{{__('nav.links.exam')}}</h4>
        <a href="/exams"  class="btn btn-primary float-right">{{__('form.back')}}</a>
        <a href="/exams/{{ $exam->id }}/edit"  class="btn btn-secondary float-right mr-3">{{__('form.edit')}}</a>
        @if ($exam->is_running)
            <a href="/exams/{{ $exam->id }}/stop" class="btn btn-outline-danger float-right mr-3">{{ __('datatables.stop') }}</a>
        @elseif ($exam->havent_started)
            <a href="/exams/{{ $exam->id }}/start" class="btn btn-outline-success float-right mr-3">{{ __('datatables.start') }}</a>
        @endif

        @if (!$exam->havent_started)
            <a href="/exams/{{ $exam->id }}/alarms" class="btn btn-warning float-right mr-3">{{ __('nav.links.exam_alarms') }}</a>
        @endif
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
                    <label>{{__('exam.comments')}}:</label> {{ $exam->comments }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 heading">
        <h5>{{__('nav.links.exam_data')}}</h5>
    </div>

    <div class="row">
        @foreach ($exam->shield->sensors as $sensor)

        <ul class="list-group list-group-flush col-12">
            <li class="list-group-item">
              <div class="media p-1">
                <img src="{{ asset($sensor->img()) }}" alt="{{__('form.labels.sensor_picture')}}" class="mr-3 mt-3" style="width:60px;">
                <div class="media-body">

                    <div class="row">
                        <div class="col-4 pl-5 pt-3">
                            <h5>{{ $sensor->name }}</h5>
                                @if ($exam->is_running)
                                <h5 class="mb-0 {{ $sensor->out_of_range() ? 'text-danger' : 'text-success' }}" id="sensor-data-time{{ $sensor->uid }}"
                                    title="{{ $sensor->last_measure_time() }}" title="{{ $sensor->last_measure_time() }}" data-normlow="{{ $sensor->normlow}}" data-normhigh="{{ $sensor->normhigh}}"><b>
                                    <span id="sensor-data{{ $sensor->uid }}">{{ $sensor->last_measure_value() }}</span></b> <b>{{ $sensor->unit }}</b>
                                </h5>
                                @else
                                <h5>&nbsp;</h5>
                                @endif

                            @if ($sensor->normlow != 0 && $sensor->normhigh != 0)
                            <small> <i>{{__('form.sensors.normal_value')}}: {{ number_format($sensor->normlow, 2) }}</i> - <i>{{ number_format($sensor->normhigh, 2) }} {{ $sensor->unit }}</i></small>
                            @endif
                        </div>
                    <div class="col-6">
                        <p>{{$sensor->description}}</p>
                    </div>
                    <div class="col-2">
                        <div class="float-right mb-0 text-right">
                            @if ($exam->is_running)
                            <a class="text-reset" href="/sensors/{{$sensor->id}}"><i class="material-icons" style="font-size:5rem;">keyboard_arrow_right</i></a>
                            @else
                            <a class="text-reset" href="/exams/{{$exam->id}}/sensors/{{$sensor->id}}"><i class="material-icons" style="font-size:5rem;">keyboard_arrow_right</i></a>
                            @endif
                        </div>
                    </div>
                    </div>
                </div>
              </div>
            </li>
        </ul>


        @endforeach
    </div>
@endsection

@if ($exam->is_running)
    @push('scripts')
        <?php $locale = app()->getLocale(); ?>
        <script src="{{ asset('js/moment.min.js') }}"></script>
        <script src="{{ asset('js/moment-locale-'.$locale.'.js') }}"></script>

        <script src="{{ asset('js/mqttws31.min.js')}}" type="text/javascript"></script>
        <script>

        // Create a client instance
        // client = new Paho.MQTT.Client("{{ env('MQTT_HOST') }}", {{ env('MQTT_PORT') }}, "{{ env('MQTT_CLIENTID') }}");
        client = new Paho.MQTT.Client("{{ config('mqtt.host')}}", {{ config('mqtt.port') }}, "{{ config('mqtt.clientid') }}");

        // set callback handlers
        client.onConnectionLost = onConnectionLost;
        client.onMessageArrived = onMessageArrived;

        // connect the client
        client.connect({
            userName: "{{ config('mqtt.user') }}",
            password: "{{ config('mqtt.password') }}",
            useSSL: true,
            onSuccess:onConnect
        });


        // called when the client connects
        function onConnect() {
            // client.subscribe("sleepshield/#");
            client.subscribe("sleepshield/{{ $exam->shield->uid }}/#");

        }

        // called when the client loses its connection
        function onConnectionLost(responseObject) {
          if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:"+responseObject.errorMessage);
          }
        }

        // called when a message arrives
        function onMessageArrived(message) {
            // obj = JSON.parse(message.payloadString);
            date = moment().format("YYYY-MM-DD HH:mm:ss");
            topic = message.destinationName.split("/");
            sensorid = "sensor-data" + topic[2];
            titleid = "sensor-data-time" + topic[2];
            sensor = $('#'+sensorid);
            title = $('#'+titleid);
            if (sensor !== null) {
                sensor.text(message.payloadString);
                title.prop('title', date);
                if (parseFloat(title.data('normlow')) > parseFloat(message.payloadString) || parseFloat(title.data('normhigh')) < parseFloat(message.payloadString)) {
                    title.removeClass('text-success');
                    title.addClass('text-danger');
                } else {
                    title.addClass('text-success');
                    title.removeClass('text-danger');
                }
            }

        }


        </script>
    @endpush
@endif
