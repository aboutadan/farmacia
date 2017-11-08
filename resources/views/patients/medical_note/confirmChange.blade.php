<div class="overlay">
	<div class="content">
		<div class="col-xs-12 center padTop-3 padBot-3">
			@if($status === 1)
				¿Estas seguro que quieres cancelar esta receta?
			@else
				¿Estas seguro que quieres activar la receta de nuevo?
			@endif

			<div class="col-xs-12 pad-0 marTop-2">
				<a href="javascript:void(0);" class="button red" onclick="closeOverlay();"> Cancelar </a>
				<a id="confirmChange" href="javascript:void(0);" class="button green"> Continuar </a>
			</div>			
		</div>
	</div>
</div>