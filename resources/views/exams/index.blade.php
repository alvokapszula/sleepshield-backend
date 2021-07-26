@extends('layouts.app')

@section('content')
<div class="col-12 heading">
    <h4>{{__('nav.links.exams')}}</h4>
    <a href="/exams/create" class="btn btn-primary float-right">{{__('nav.new.exam')}}</a>
</div>

<div class="table-responsive pb-5">
	<table id="datatable" class="table table-sm table-hover table-striped dt-responsive" style="width:100%">
		<thead>
			<tr>
                <th>&nbsp;</th>
                <th>Páciens</th>
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
            order: [[8, 'desc'], [9, 'desc'], [5, 'desc'], [6,'desc']],
			"language": {
				"url": "{{ asset('i18/DT-hungarian.json') }}"
			},
			ajax: '/datatables/exams',
			columns: [
                { data: 'img', width: '10%', searchable: false, orderable: false},
				{ data: 'patient', width: '10%', className: "align-middle", searchable: true},
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
