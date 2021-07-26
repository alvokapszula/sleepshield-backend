@extends('layouts.app')

@section('content')
<form class="row">
    <div class="col-12 heading">
        <h4>{{__('nav.show.patient')}}</h4>
            <a href="{{ url()->previous() }}"  class="btn btn-primary float-right">{{__('form.back')}}</a>
            <a href="/patients/{{ $patient->id }}/edit"  class="btn btn-secondary float-right mr-3">{{__('form.edit')}}</a>
    </div>

    <div class="col">
        <div class="form-group">
            <label>{{__('form.labels.gender')}}</label>
            <div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input name="gender" id="gender_0" type="radio" required="required" class="custom-control-input" value="2" disabled {{ $patient->gender === 2 ? 'checked' : '' }}>
                    <label for="gender_0" class="custom-control-label">{{__('form.labels.woman')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input name="gender" id="gender_1" type="radio" required="required" class="custom-control-input" value="1" disabled {{ $patient->gender === 1 ? 'checked' : '' }}>
                    <label for="gender_1" class="custom-control-label">{{__('form.labels.man')}}</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="lastname">{{__('form.labels.lastname')}}</label>
            <input id="lastname" name="lastname" type="text" required="required" class="form-control" value="{{ $patient->lastname }}" disabled>
        </div>
        <div class="form-group">
            <label for="firstname">{{__('form.labels.firstname')}}</label>
            <input id="firstname" name="firstname" type="text" class="form-control" required="required" value="{{ $patient->firstname }}" disabled>
        </div>
        <div class="form-group">
            <label for="date">{{__('form.labels.birthdate')}}</label>
            <div class="input-group date" id="birthdate" data-target-input="nearest">
                <input type="text" name="birthdate" class="form-control datetimepicker-input" data-target="#birthdate" value="{{ $patient->birthdate }}" disabled/>
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
                        <input id="height" name="height" type="number" class="form-control" required="required" value="{{ $patient->height }}" disabled>
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
                        <input id="weight" name="weight" type="number" class="form-control" required="required" value="{{ $patient->weight }}" disabled>
                        <div class="input-group-append">
                            <span class="input-group-text">kg</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="exam_types">{{__('form.labels.exam_types')}}</label>
            <select multiple  size="3" class="custom-select" id="exam_types" name="exam_types[]" disabled>
                <?php $items = \App\ExamType::all(); ?>
                @foreach ($items as $item)
                <option value="{{$item->id}}"
                    {{ $patient->exam_types->contains($item->id) ? 'selected' : '' }}
                    >{{$item->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col">
        <div class="avatar-upload">
            <div class="avatar-preview">
                <div id="imagePreview" style="background-image: url({{ asset($patient->image) }});">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="comments">{{__('form.labels.comments')}}</label>
            <textarea id="comments" name="comments" cols="40" rows="5" class="form-control" disabled>{{ $patient->comments }}</textarea>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-12 heading">
        <h4>{{__('patient.exams')}}</h4>
    </div>

    <div class="table-responsive pb-5">
    	<table id="datatable" class="table table-sm table-hover table-striped dt-responsive" style="width:100%">
    		<thead>
    			<tr>
                    <th>Kapszula</th>
                    <th>Orvos</th>
                    <th>Típus</th>
                    <th>Eleje</th>
                    <th>Vége</th>
                    <th>&nbsp;</th>
    			</tr>
    		</thead>
    	</table>
    </div>

</div>
@endsection


@push('css')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script>
    $(function () {
        $('#datatable').DataTable({
			serverSide: true,
			processing: true,
			responsive: true,
			stateSave: false,
			pageLength: 10,
            order: [[6, 'desc'], [7, 'desc'], [3, 'desc'], [4,'desc']],
			"language": {
				"url": "{{ asset('i18/DT-hungarian.json') }}"
			},
			ajax: '/datatables/patients/{{$patient->id}}/exams',
			columns: [
				{ data: 'shield', width: '10%', className: "align-middle", searchable: true},
				{ data: 'user', width: '10%', className: "align-middle", searchable:true },
				{ data: 'exam_types_as_string', width: '10%', className: "align-middle", searchable: true},
                { data: 'begin', width: '10%', className: "align-middle", searchable: true},
                { data: 'end', width: '10%', className: "align-middle", searchable: true},
                { data: 'actions', width: '10%', className: "align-middle text-center", searchable: false, orderable:false},
                { data: 'is_running', visible: false, searchable: false, orderable: true},
                { data: 'havent_started', visible: false, searchable: false, orderable: true},
			],
		});
	});
</script>
@endpush
