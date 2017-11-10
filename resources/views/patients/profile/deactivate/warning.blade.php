<div class="row form default">
	<div class="col-sm-12 subtitle">
        <h3 class="warning upper center">Advertencia</h3>
    </div>

    <div class="col-sm-12">
        <span class="icon document"></span>
        <p class="justify">Este perfil tiene {{ $count === 1 ? $count.' receta médica.': $count.' recetas médicas.' }} Debido a esto, solamente se puede desactivar el perfil en caso de que este duplicado. Antes de poder desactivar la cuenta, las recetas se tienen que asociar con el prefil correcto. Indique el número de identificación del perfil:</p>
    </div>

	<div class="col-sm-6 col-sm-offset-3">
        <form method="post" action="{{ Request::fullUrl().'/search' }}">
            {{ csrf_field() }}
    		<div class="col-xs-12 col-sm-9">
    			{{ place_input('profileId', 'No. de Perfil', old('profileId')) }}
    		</div>
    		<div class="col-xs-12 col-sm-3 button_container">
    			<button type="submit" class="button green">Buscar</button>
    		</div>
        </form>
        @if($errors->any())
            <div class="col-xs-12 marTop-1">
                <ul class="error_message">
                    @foreach($errors->all() as $error)
                        <li>* {{ $error }} </li>
                    @endforeach
                </ul>
            </div>
        @endif
	</div>

	<div class="col-xs-12 marTop-1">
        <div class="col-xs-12 center">
            <a href="javascript:void(0);" class="sh_toggle" data-tab="find_id">¿Ayuda?</a>
        </div>
        <div id="find_id" class="col-sm-12" style="display:none;">
        	
        	<div class="col-xs-12 pad-0">
                <div class="divider gray"></div>   
            </div>

            <div class="col-xs-12 col-sm-6 marBot-1">
            	<img src="{{ asset('images/find_profile_1.jpg') }}"  width="100%"/>
            </div>
            <div class="col-xs-12 col-sm-6 justify">
                <strong>¿Donde se ubica el número de perfil?</strong> <br />
                Este dato se encuentra en la sección "Detalles" del paciente. En la parte superior del lado derecho se encuentra el número requerido para asociar las recetas. 
            </div>
        </div>
    </div>

</div>