@foreach($comments as $comment)
	<div class="col-sm-12 pad-0 comment">
		<div class="col-sm-12 pad-0 data">
			<ul>
				<li>
					<i class="fa fa-user-circle-o" aria-hidden="true"></i>
					<strong>{{ $comment->fname.' '.$comment->lname }}</strong> agregó un comentario ({{ $comment->id}})
				</li>
				<li>
					<i class="fa fa-calendar" aria-hidden="true"></i>
					{{ format_date($comment->fecha, 'long') }}
				</li>
			</ul>
		</div>

		<div class="col-sm-12 pad-0">
			{{ $comment->notas }}
		</div>
	</div>
@endforeach