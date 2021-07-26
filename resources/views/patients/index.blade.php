@extends('layouts.app')

@section('content')
<div class="col-12 heading">
    <h4>{{__('nav.links.patients')}}</h4>
    <a href="/patients/create" class="btn btn-primary float-right">{{__('nav.new.patient')}}</a>
</div>

<div class="table-responsive pb-5">
	<table id="datatable" class="table table-sm table-hover table-striped dt-responsive" style="width:100%">
		<thead>
			<tr>
                <th>&nbsp;</th>
                <th>Vezetéknév</th>
                <th>Keresztnév</th>
                <th>Magasság</th>
                <th>Tömeg</th>
                <th>Született</th>
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
			ajax: '/datatables/patients',
			columns: [
                { data: 'img', width: '10%', searchable: false, orderable: false},
				{ data: 'lastname', width: '10%', className: "align-middle", searchable: true},
				{ data: 'firstname', width: '10%', className: "align-middle", searchable: true},
				{ data: 'height', width: '10%', className: "align-middle", searchable:true },
				{ data: 'weight', width: '10%', className: "align-middle", searchable: true},
                { data: 'birthdate', width: '10%', className: "align-middle", searchable: true},
                { data: 'actions', width: '10%', className: "align-middle text-center", searchable: false, orderable:false},
			],
		});
	});
</script>
@endpush
