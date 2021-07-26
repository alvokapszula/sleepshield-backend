@extends('layouts.app')

@section('content')
<form class="row">
    <div class="col-12 heading">
        <h4>{{__('nav.show.shield')}}</h4>
            <a href="{{ url()->previous() }}"  class="btn btn-primary float-right">{{__('form.back')}}</a>
            <a href="/shields/{{ $shield->id }}/edit"  class="btn btn-secondary float-right mr-3">{{__('form.edit')}}</a>
    </div>

    <div class="col">

        <div class="form-group">
            <label for="name">{{__('form.labels.name')}}</label>
            <input id="name" name="name" type="text" required="required" class="form-control" value="{{ $shield->name }}" disabled>
        </div>
        <div class="form-group">
            <label for="uid">{{__('form.labels.uid')}}</label>
            <input id="uid" name="uid" type="text" class="form-control" required="required" value="{{ $shield->uid }}" disabled>
        </div>

        <div class="form-group">
            <label for="exam_types">{{__('form.labels.exam_types')}}</label>
            <select multiple size="3" class="custom-select" id="exam_types" name="exam_types[]" disabled>
                <?php $items = \App\ExamType::all(); ?>
                @foreach ($items as $item)
                <option value="{{$item->id}}"
                    {{ $shield->exam_types->contains($item->id) ? 'selected' : '' }}
                    >{{$item->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

</form>

<div class="row">
    <div class="col-12 heading">
        <h4>{{__('shield.sensors')}}</h4>
    </div>

    @foreach ($shield->sensors as $sensor)

    <ul class="list-group list-group-flush col-12">
        <li class="list-group-item">
          <div class="media p-1">
            <img src="{{ asset($sensor->img()) }}" alt="{{__('form.labels.sensor_picture')}}" class="mr-3 mt-3" style="width:60px;">
            <div class="media-body">

                <div class="row">
                    <div class="col-4 pl-5 pt-3">
                        <h5>{{ $sensor->name }}</h5>
                        <h5 class="mb-0 {{ $sensor->out_of_range() ? 'text-danger' : 'text-success' }}" id="sensor-data-time{{ $sensor->uid }}"
                            title="{{ $sensor->last_measure_time() }}" data-normlow="{{ $sensor->normlow}}" data-normhigh="{{ $sensor->normhigh}}">
                            <b> <span id="sensor-data{{ $sensor->uid }}">{{ $sensor->last_measure_value() }}</span></b> <b>{{ $sensor->unit }}</b></h5>
                        @if ($sensor->normlow != 0 && $sensor->normhigh != 0)
                        <small> <i>{{__('form.sensors.normal_value')}}: {{ number_format($sensor->normlow, 2) }}</i> - <i>{{ number_format($sensor->normhigh, 2) }} {{ $sensor->unit }}</i></small>
                        @endif
                    </div>
                    <div class="col-6">
                        <p>{{$sensor->description}}</p>
                    </div>
                    <div class="col-2">
                        <div class="float-right mb-0 text-right">
                            <a class="text-reset" href="/sensors/{{$sensor->id}}"><i class="material-icons" style="font-size:5rem;">keyboard_arrow_right</i></a>
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
            client.subscribe("sleepshield/{{ $shield->uid }}/#");

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
