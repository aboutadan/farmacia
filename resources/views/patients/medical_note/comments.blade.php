
<div class="section">
	<div class="row form title">
		Comentarios (<span id="comments_count">{{ $totalComments }}</span>)
	</div>
    <div class="row form default">
		<div class="col-xs-12 comments_section">
			<div class="col-xs-12 pad-0">
				{!! Form::open(['url' => Request::fullUrl() ]) !!}
					
					{!! Form::text('idReceta', $note->id,['hidden' => true]) !!}
					
					{{ place_textarea('notas', 'Agregar Comentario', old('notas')) }}
					<div class="col-xs-12 pad-0">
						@if ($errors->any())
						    <div class="col-sm-8">
						        <ul class="error_message">
						            @foreach ($errors->all() as $error)
						                <li>{{ $error }}</li>
						            @endforeach
						        </ul>
						    </div>
						    <div class="col-sm-4 pad-0 right">
						    	<button type="submit" class="button green">Agregar</button>
						    </div> 
						@else
							<div class="col-sm-4 col-sm-offset-8 pad-0 right">
								<button type="submit" class="button green">Agregar</button>
							</div>
						@endif
					</div>
				{!! Form::close() !!}
			</div>

			<div class="col-xs-12 divider gray"></div>

			@if($comments->count() > 0)
	            @foreach($comments as $comment)
	            	@php 
	            		$user_comment = (int) $comment->type;
	            	@endphp
	            	@if($user_comment === 1)
	                <div class="col-xs-12 pad-0 comment">
	                    <div class="col-xs-12 pad-0 data">
	                        <ul>
	                            <li>
	                                <i class="fa fa-user-circle-o" aria-hidden="true"></i> 
	                                <strong>{{ $comment->fname.' '.$comment->lname }}</strong> agregó un comentario
	                            </li>
	                            <li>
	                            	<i class="fa fa-calendar" aria-hidden="true"></i>
	                            	{{ format_date($comment->fecha, 'long') }}
	                           	</li>
	                        </ul>
	                    </div>

	                    <div class="col-xs-12 pad-0">
	                        {{ $comment->notas }}
	                    </div>
	                </div>
	                @else 
	                <div class="col-xs-12 pad-0 comment">
	                    <div class="col-xs-12 pad-0 data">
	                        <ul>
	                            <li>
	                                <i class="fa fa-user-circle-o" aria-hidden="true"></i>
	                                <strong>{{ $comment->fname.' '.$comment->lname }}</strong> {{$comment->notas}} el {{ format_date($comment->fecha, 'sentence') }}
	                            </li>
	                        </ul>
	                    </div>
	                </div>
	                @endif
	            @endforeach
			@else 
				<div class="col-xs-12 pad-0 center marTop-1">
	                <i>No hay comentarios.</i>
	            </div>
        	@endif
        </div>

        @if($totalComments > 8)
			<div id="add_more_button" class="col-sm-12 marTop-2 center">
				<a id="add_more" href="javascript:void(0);" class="button blue" data-find="{{ $note->id }}">Ver mas</a>
          	</div>
		@endif
		
    </div> {{-- End of Form --}}
</div> {{-- End of Section--}}