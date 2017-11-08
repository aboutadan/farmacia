@if(Request::segment(2) !== 'results')
	<div class="section">
		<div class="row form title">
			@if($notes->count() === 1)
				Consulta Nueva ({{ $notes->count() }})
			@else 
				Consultas Nuevas ({{ $notes->count() }})
			@endif
		</div>
		@if($notes->count() > 0)
			<div class="row form default">
				<div class="col-sm-12 result_titles">
					<span class="col-sm-1">#</span>
		            <span class="col-sm-5">Nombre de Paciente</span>
		            <span class="col-sm-6">IDX</span>
				</div>
				@foreach($notes as $count => $note)
					<div class="col-sm-12 results">
						@php 
							$patient = $patientInfo[$count];
						@endphp
						<a href="{{ asset('patient/details/'.$note->cliente_id.'?status=1') }}">
							<span class="col-sm-1">{{ $count + 1 }}</span>
				            <span class="col-sm-5 upper">{{ $patient->nombre.' '.$patient->apellido }}</span>
				            <span class="col-sm-6 upper">{{ $note->idx }}</span>
			        	</a>
					</div>
				@endforeach
			</div>
		@else
			<div class="row form default center">
				Aún no cuentas con consultas el día de hoy.
			</div>
		@endif
	</div> {{-- End of Section --}}
@endif