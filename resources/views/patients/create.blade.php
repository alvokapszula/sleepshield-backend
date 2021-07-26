@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/fontawsome.min.css') }}" />
@endpush

@section('content')
<form class="row" method="POST" action="/patients" accept-charset="UTF-8" enctype="multipart/form-data">
    <div class="col-12 heading">
        <h4>{{__('nav.new.patient')}}</h4>
            <button type="submit" class="btn btn-primary float-right">{{__('form.save')}}</button>
            <a href="{{ url()->previous() }}" type="reset" class="btn btn-outline-danger float-right mr-3">{{__('form.cancel')}}</a>
    </div>


  {{ csrf_field() }}
    <div class="col">
        <div class="form-group">
            <label>{{__('form.labels.gender')}}</label>
            <div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input name="gender" id="gender_0" type="radio" required="required" class="custom-control-input" value="2" checked>
                    <label for="gender_0" class="custom-control-label">{{__('form.labels.woman')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input name="gender" id="gender_1" type="radio" required="required" class="custom-control-input" value="1">
                    <label for="gender_1" class="custom-control-label">{{__('form.labels.man')}}</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="lastname">{{__('form.labels.lastname')}}</label>
            <input id="lastname" name="lastname" type="text" required="required" class="form-control">
        </div>
        <div class="form-group">
            <label for="firstname">{{__('form.labels.firstname')}}</label>
            <input id="firstname" name="firstname" type="text" class="form-control" required="required">
        </div>

        <div class="form-group">
            <label for="date">{{__('form.labels.birthdate')}}</label>
            <div class="input-group date" id="birthdate" data-target-input="nearest">
                <input type="text" name="birthdate" class="form-control datetimepicker-input" data-target="#birthdate"/>
                <div class="input-group-append" data-target="#birthdate" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="material-icons">date_range</i></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="height">{{__('form.labels.height')}}</label>
                    <div class="input-group">
                        <input id="height" name="height" type="number" class="form-control" required="required">
                        <div class="input-group-append">
                            <span class="input-group-text">cm</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="weight">{{__('form.labels.weight')}}</label>
                    <div class="input-group">
                        <input id="weight" name="weight" type="number" class="form-control" required="required">
                        <div class="input-group-append">
                            <span class="input-group-text">kg</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="exam_types">{{__('form.labels.exam_types')}}</label>
            <select multiple size="3" class="custom-select" id="exam_types" name="exam_types[]">
                <?php $items = \App\ExamType::all(); ?>
                @foreach ($items as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col">
        <div class="avatar-upload">
            <div class="avatar-edit">
                <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg, .gif, .svg" />
                <label for="image"></label>
            </div>
            <div class="avatar-preview">
                <div id="imagePreview" style="background-image: url({{ asset('storage/patient_images/placeholder.png') }});">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="comments">{{__('form.labels.comments')}}</label>
            <textarea id="comments" name="comments" cols="40" rows="6" class="form-control"></textarea>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image").change(function() {
        readURL(this);
    });
</script>

<?php $locale = app()->getLocale(); ?>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/moment-locale-'.$locale.'.js') }}"></script>
<script src="{{ asset('js/tempusdominus-bootstrap-4.min.js') }}"></script>

<script type="text/javascript">
    $(function () {
        $('#birthdate').datetimepicker({
            locale: '{{$locale}}',
            format: 'YYYY-MM-DD'
        });
    });
</script>

@endpush
