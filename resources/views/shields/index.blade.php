@extends('layouts.app')

@section('content')
<div class="col-12 heading">
    <h4>{{__('nav.links.shields')}}</h4>
    <a href="/shields/create" class="btn btn-primary float-right">{{__('nav.new.shield')}}</a>
</div>

<div class="table-responsive pb-5">
	<table id="datatable" class="table table-sm table-hover table-striped dt-responsive" style="width:100%">
		<thead>
			<tr>
                <th>&nbsp;</th>
                <th>Azonosító</th>
                <th>Vizsgálatok száma</th>
                <th>Vizsgálati berendezés</th>
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
			stateSave: true,
			pageLength: 10,
            order: [[1, 'asc'], [2,'asc']],
			"language": {
				"url": "{{ asset('i18/DT-hungarian.json') }}"
			},
			ajax: '/datatables/shields',
			columns: [
                { data: 'img', width: '10%', searchable: false, orderable: false},
				{ data: 'name', width: '30%', className: "align-middle", searchable: true},
				{ data: 'exam_count', width: '20%', className: "align-middle", searchable: true},
				{ data: 'exam_types_as_string', width: '30%', className: "align-middle", searchable:true },
                { data: 'actions', width: '10%', className: "align-middle text-center", searchable: false, orderable:false},
			],
		});
	});
</script>
@endpush
