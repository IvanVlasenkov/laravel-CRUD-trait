<link href="{{ asset('crud/crud.css') }}" rel="stylesheet">

<div class="container card">

    <div class="card-header">
        <h2>Crud Show</h2>
    </div>

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
            {{ $name }}
            @else
            {{ $data['fields'][$name]['name'] }}
            @endif
            </div>
            <div class="card-table-row-cell">
            {{ $value }}
            </div>
        </div>
        <!-- end card body -->              
    @empty
        <h3>Not found</h3>        
    @endforelse    
    </div>

    <div class="card-panel">
        <a class="btn card-panel-btn" href="/crud/{{ $data['key']}}">List</a>
        <form class="card-panel-form" method="POST" action="/crud/{{ $data['key']}}/{{ $data['item']['id'] }}">
            @csrf
            @method('DELETE')
            <button class="btn card-panel-btn">Delete</button>
        </form>
        <a class="btn card-panel-btn" href="{{ url()->previous() }}" id="btn-back--{{ $data['key'] }}">Back</a>
        <a class="btn card-panel-btn" href="/crud/{{ $data['key']}}/{{ $data['item']['id'] }}/edit">Edit</a>
    </div>
    

</div>

