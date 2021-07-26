@extends('layouts.app')

@section('content')
<form class="row" method="POST" action="/shields" accept-charset="UTF-8" enctype="multipart/form-data">
    <div class="col-12 heading">
        <h4>{{__('nav.new.shield')}}</h4>
            <button type="submit" class="btn btn-primary float-right">{{__('form.save')}}</button>
            <a href="{{ url()->previous() }}" type="reset" class="btn btn-outline-danger float-right mr-3">{{__('form.cancel')}}</a>
    </div>

    {{ csrf_field() }}

    <div class="col">

        <div class="form-group">
            <label for="name">{{__('form.labels.name')}}</label>
            <input id="name" name="name" type="text" required="required" class="form-control">
        </div>
        <div class="form-group">
            <label for="uid">{{__('form.labels.uid')}}</label>
            <input id="uid" name="uid" type="text" class="form-control" required="required">
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

</form>
@endsection
