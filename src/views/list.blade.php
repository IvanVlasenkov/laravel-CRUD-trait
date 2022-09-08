<link href="{{ asset('crud/crud.css') }}" rel="stylesheet">

<div class="container list">

    <div class="list-header">
        <h2>Crud List</h2>
    </div>

	<div class="card-panel">
		<a class="btn card-panel-btn" href="{{ route( $data['key'].'.create' ) }}">Create</a>
	</div>    

    <div id="{{ $data['key'] }}--list" class="list-body list-table">    
    @forelse( $data['list'] as $item )        
        <!-- table header -->
        @if( $loop->first )
        <div class="list-table-caption">
            @if( !isset($data['fields']) || empty($data['fields']) )
                @foreach( $item as $name => $col )
                <div class="list-table-caption-cell">{{ $name }}</div>
                @endforeach
            @else
                @foreach( $data['fields'] as $field )
                <div class="list-table-caption-cell">{{ $field['name']}}</div>
                @endforeach
            @endif
        </div>
        @endif
        <!-- end table header -->
        
        <!-- table body -->
        <a class="list-table-row" href="/crud/{{ $data['key']}}/{{ $item['id'] }}">
        
        @foreach( $item as $name => $cell )
            <div class="list-table-row-cell">{{ $cell }}</div>
        @endforeach
        </a>        
        <!-- end table body -->
        
    @empty
        <h3>Not found</h3>    
    @endforelse
    
    </div>

</div>

