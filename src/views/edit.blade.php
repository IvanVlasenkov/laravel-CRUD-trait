<link href="{{ asset('crud/crud.css') }}" rel="stylesheet">

<div class="container card">

    <div class="card-header">
        <h2>Crud Edit</h2>
    </div>
    
    <form id="form-update-{{ $data['key'] }}"
        name="form-update-{{ $data['key'] }}" 
        method="POST" 
        action="/crud/{{ $data['key']}}/{{ $data['item']['id'] }}"
        class="card-form">
        @csrf
        @method('PUT')
        
        <div id="{{ $data['key'] }}--card" class="card-body card-table">    
        @forelse( $data['item'] as $name => $value )
            <!-- card header -->
            @if( $loop->first )
            <div class="card-table-caption">
                <div class="card-table-caption-cell">Attribute</div>
                <div class="card-table-caption-cell">Value</div>
            </div>
            @endif   
            <!-- end card header --> 
            <!-- card body -->        
            <div class="card-table-row">
                <div class="card-table-row-cell">
                @if( !isset($data['fields']) || empty($data['fields']) )
                    <label for="{{ $data['key'] }}{{ $name }}"
                    class="card-table-row-cell-label">{{ $name }}</label>
                @else
                    <label for="{{ $data['key'] }}{{ $name }}"
                    class="card-table-row-cell-label">
                        {{ $data['fields'][$name]['name'] }}
                        @if( $data['fields'][$name]['required'] === true )
                            <span class="card-attention">*</span>
                        @endif
                    </label>
                @endif
                </div>
                <div class="card-table-row-cell">
                    @if( isset($data['fields']) 
                        && !empty($data['fields']) 
                        && $data['fields'][$name]['redact'] === false )
                        
                        {{ $value }}
                    @else
                        
                        @switch( $data['fields'][$name]['type'] )
                            @case('numeric')
                                <input class="card-table-row-cell-input" name="{{ $data['key'] }}{{ $name }}" id="{{ $data['key'] }}{{ $name }}" type="number"
                                @if( $data['fields'][$name]['required'] === true )
                                    required="true"
                                @endif
                                value="{{ $value }}"/>
                                @break
                            @case('string')
                                <input class="card-table-row-cell-input" name="{{ $data['key'] }}{{ $name }}" id="{{ $data['key'] }}{{ $name }}" type="string"
                                @if( $data['fields'][$name]['required'] === true )
                                    required="true"
                                @endif
                                value="{{ $value }}"/>
                                @break
                            @case('enum')
                                <select class="card-table-row-cell-input" name="{{$data['key'] }}{{ $name }}" id="{{ $data['key'] }}{{ $name }}">
                                    @forelse( $data['fields'][$name]['select'] as $option )
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
            <!-- end card body -->              
        @empty
            <h3>Not found</h3>        
        @endforelse
        </div>  
        <div class="card-panel">
            <a class="btn card-panel-btn" href="/crud/{{ $data['key']}}">List</a>
            <a class="btn card-panel-btn" href="{{ url()->previous() }}" id="btn-back--{{ $data['key'] }}">Back</a>
            <button class="btn card-panel-btn">Update</button>
        </div>
    </form>
</div>


