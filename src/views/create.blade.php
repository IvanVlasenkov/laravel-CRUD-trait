@extends('crud.layout')

@section('content')
<div class="container card">

    <div class="card-header">
        <h2>Crud Create {{ $data['key'] }}</h2>
    </div>
	
	<form action="{{ route( $data['key'] . '.store' ) }}" 
        method="POST" 
        id="form-store-{{ $data['key'] }}" 
        name="form-store-{{ $data['key'] }}" 
        class="card-form">
        @csrf
        <div id="{{ $data['key'] }}--card" class="card-body card-table">		
            <!-- card header -->
            <div class="card-table-caption">
                <div class="card-table-caption-cell">Attribute</div>
                <div class="card-table-caption-cell">Value</div>
            </div> 
            <!-- end card header -->  
            <!-- card body -->
            @if( isset($data['fields']) && !empty($data['fields']) )
                @foreach( $data['fields'] as $name => $field )                       
                <div class="card-table-row">
                    <div class="card-table-row-cell">                
                        <label class="card-table-row-cell-label" for="">
                            {{ $field['name'] }}
                            @if( $field['required'] === true )
                                <span class="card-attention">*</span>
                            @endif
                        </label>
                    </div>
                    <div class="card-table-row-cell">
					@if( isset($field['binding']) && !empty($field['binding']) )
						@push('scripts')
							<script src="{{ asset('crud/binding.js')}}"></script>
						@endpush
					@endif
                    @if( $field['redact'] === true )                        
                        @switch( $field['type'] )
                            @case('numeric')
                                <input class="card-table-row-cell-input" name="{{ $data['key'] }}{{ $field['name'] }}" id="{{ $data['key'] }}{{ $field['name'] }}" type="number"
                                @if( $field['required'] === true )
                                    required="true"
                                @endif/>
                                @break
                            @case('string')
                                <input class="card-table-row-cell-input" name="{{ $data['key'] }}{{ $field['name'] }}" id="{{ $data['key'] }}{{ $field['name'] }}" type="string"
                                @if( $field['required'] === true )
                                    required="true"
                                @endif/>
                                @break
                            @case('enum')
                                <select class="card-table-row-cell-input" name="{{ $data['key'] }}{{ $field['name'] }}" id="{{ $data['key'] }}{{ $field['name'] }}">
                                    @forelse( $field['select'] as $option )
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @empty
                                        <option value="">---</option>
                                    @endforelse
                                </select>
                                @break
                        @endswitch
                    @endif
                    </div>
                </div>
                @endforeach
            @else
                @foreach( $data['fillable'] as $field )
                <div class="card-table-row">
                    <label class="card-table-row-cell" for="{{ $data['key'] }}{{ $field }}">{{ $field }}</label>
                    <input class="card-table-row-cell" name="{{ $data['key'] }}{{ $field }}" id="{{ $data['key'] }}{{ $field }}"/>
                </div>				
                @endforeach
            @endif
            <!-- card body -->
        </div>
        <div class="card-panel">
		    <a class="btn card-panel-btn" href="{{ url()->previous() }}" id="btn-back--{{ $data['key'] }}">Back</a>
            <button class="btn card-panel-btn" id="btn-store-{{ $data['key'] }}">Store</button>
        </div>            
	</form>

</div>
@endsection