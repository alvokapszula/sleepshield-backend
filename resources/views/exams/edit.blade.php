@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/fontawsome.min.css') }}" />
@endpush

@section('content')
<form class="row" method="POST" action="/exams/{{$exam->id}}" accept-charset="UTF-8" enctype="multipart/form-data">
    <div class="col-12 heading">
        <h4>{{__('nav.edit.exam')}}</h4>
            <button type="submit" class="btn btn-primary float-right">{{__('form.save')}}</button>
            <a href="{{ url()->previous() }}" type="reset" class="btn btn-outline-danger float-right mr-3">{{__('form.cancel')}}</a>
    </div>

  {{ csrf_field() }}
  {{ method_field('PATCH') }}

    <div class="col-8 offset-2">

        <div class="form-group">
            <label for="patient">{{__('form.labels.patient')}}</label>
            <select class="custom-select" id="patient_id" name="patient_id" required>
                <?php $patients = \App\Patient::all(); ?>
                @foreach ($patients as $patient)
                <option value="{{$patient->id}}"
                    {{ $exam->user->id == $patient->id  ? 'selected' : '' }}
                    >{{$patient->fullname()}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="shield">{{__('form.labels.shield')}}</label>
            <select class="custom-select" id="shield_id" name="shield_id" required="required">
                <?php $patients = \App\Shield::all(); ?>
                @foreach ($patients as $patient)
                <option value="{{$patient->id}}"
                    {{ $exam->user->id == $patient->id  ? 'selected' : '' }}
                    >{{$patient->uid}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="user">{{__('form.labels.user')}}</label>
            <select class="custom-select" id="user_id" name="user_id" required="required">
                <?php $patients = \App\User::all(); ?>
                @foreach ($patients as $patient)
                <option value="{{$patient->id}}"
                    {{ $exam->user->id == $patient->id  ? 'selected' : '' }}
                    >{{$patient->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="exam_types">{{__('form.labels.exam_types')}}</label>
            <select multiple size="3" class="custom-select" id="exam_types" name="exam_types[]">
                <?php $items = \App\ExamType::all(); ?>
                @foreach ($items as $item)
                <option value="{{$item->id}}"
                    {{ $exam->exam_types->contains($item->id) ? 'selected' : '' }}
                    >{{$item->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col">
                <label for="begin">{{__('form.labels.begin')}}</label>
                <div class="input-group date" id="begin" data-target-input="nearest">
                    <input type="text" name="begin" class="form-control datetimepicker-input" data-target="#begin" value="{{ $exam->begin }}">
                    <div class="input-group-append" data-target="#begin" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="material-icons">date_range</i></div>
                    </div>
                </div>
            </div>
            <div class="col">
                <label for="end">{{__('form.labels.end')}}</label>
                <div class="input-group date" id="end" data-target-input="nearest">
                    <input type="text" name="end"  class="form-control datetimepicker-input" data-target="#end" value="{{ $exam->end }}">
                    <div class="input-group-append" data-target="#end" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="material-icons">date_range</i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="comments">{{__('form.labels.comments')}}</label>
            <textarea id="comments" name="comments" cols="40" rows="5" class="form-control">{{ $exam->comments }}</textarea>
        </div>

    </div>

</form>

<form class="row" method="POST" action="/exams/{{ $exam->id }}" accept-charset="UTF-8" enctype="multipart/form-data">
    <div class="col-12 heading">
        <h4>{{__('nav.delete.exam')}}</h4>
    </div>

    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    {!! Form::button(__('form.delete'), array('class' => 'btn btn-danger','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => __('exam.delete.title'), 'data-message' => __('exam.delete.message'))) !!}

</form>

@include('assets.modal-delete')
@endsection

@push('scripts')
@include('assets.delete-modal-script')
<?php $locale = app()->getLocale(); ?>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/moment-locale-'.$locale.'.js') }}"></script>
<script src="{{ asset('js/tempusdominus-bootstrap-4.min.js') }}"></script>

<script type="text/javascript">
    $(function () {
        $('#begin').datetimepicker({
            locale: '{{$locale}}',
            format: 'YYYY-MM-DD HH:mm:ss'
        });
    });
</script>
<script type="text/javascript">
    $(function () {
        $('#end').datetimepicker({
            locale: '{{$locale}}',
            format: 'YYYY-MM-DD HH:mm:ss'
        });
    });
</script>
@endpush
