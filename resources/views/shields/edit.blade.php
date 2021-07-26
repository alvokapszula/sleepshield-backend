@extends('layouts.app')

@section('content')
<form class="row" method="POST" action="/shields/{{ $shield->id }}" accept-charset="UTF-8" enctype="multipart/form-data">
    <div class="col-12 heading">
        <h4>{{__('nav.edit.shield')}}</h4>
            <button type="submit" class="btn btn-primary float-right">{{__('form.save')}}</button>
            <a href="{{ url()->previous() }}" type="reset" class="btn btn-outline-danger float-right mr-3">{{__('form.cancel')}}</a>
    </div>

    {{ csrf_field() }}
    {{ method_field('PATCH') }}

    <div class="col">

        <div class="form-group">
            <label for="name">{{__('form.labels.name')}}</label>
            <input id="name" name="name" type="text" required="required" class="form-control" value="{{ $shield->name }}">
        </div>
        <div class="form-group">
            <label for="uid">{{__('form.labels.uid')}}</label>
            <input id="uid" name="uid" type="text" class="form-control" required="required" value="{{ $shield->uid }}">
        </div>

        <div class="form-group">
            <label for="exam_types">{{__('form.labels.exam_types')}}</label>
            <select multiple size="3" class="custom-select" id="exam_types" name="exam_types[]">
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

<form class="row" method="POST" action="/shields/{{ $shield->id }}" accept-charset="UTF-8" enctype="multipart/form-data">
    <div class="col-12 heading">
        <h4>{{__('nav.delete.shield')}}</h4>
    </div>

    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    {!! Form::button(__('form.delete'), array('class' => 'btn btn-danger','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => __('shield.delete.title'), 'data-message' => __('shield.delete.message'))) !!}

</form>

@include('assets.modal-delete')
@endsection

@push('scripts')
@include('assets.delete-modal-script')
@endpush
