<?php namespace Vlasenkov\Crud;

trait CrudTrait
{
    protected $request;
    protected $model;
    protected $data = [];
    protected $key;
    
    protected $index_view  = 'crud::list';
    protected $create_view = 'crud::create';
    protected $show_view   = 'crud::show';
    protected $edit_view   = 'crud::edit';
    
    protected $redirectTo;

    protected $use_views = true;
    
    protected $crud_errors = [];
    
    public function index()
    {
        $this->data['list'] = $this->model->get()->toArray();        
        if( $this->use_views === true )
        {
            return view( $this->index_view )->with(['data' => $this->data]);
        } 
        else
        {
            return json_encode($this->data);
        }
    }
    
    public function create()
    {
		if( !isset( $this->data['fields'] ) || empty( $this->data['fields'] ) )
		{
			$this->data['fillable'] = $this->model->getFillable();			
		}
        
        if( $this->use_views === true )
        {
            return view( $this->create_view )->with(['data' => $this->data]);
        }
        else
        {
            return redirect()->back()->withErrors(['View not set']);
        }
    }
    
    public function store()
    {
		$stored = new $this->model;
		$fields = $this->request->except( '_token', 'id', '_method' );
		foreach( $fields as $name => $field )
		{
			$clean_name = str_replace( $this->data['key'], '', $name );
			$stored->$clean_name = $field;
		}
		$errors = [];
		if( !$stored->save() ){
			
			array_push( $errors, $this->data['key'] . ': store error' );
		}
        
        if( !empty($this->redirectTo) )
        {
            return redirect()->route( $this->redirectTo )->withErrors($errors);
        }
        else
        {
            return redirect()->route( $this->key . '.index' )->withErrors($errors);
        }
    }
    
    public function show($id)
    {
        $this->data['item'] = $this->model->findOrFail($id)->toArray();
        if( $this->use_views === true )
        {
            return view( $this->show_view )->with(['data' => $this->data]);
        } 
        else
        {
            return json_encode($this->data);
        }
    }

    public function edit($id)
    {
        $this->data['item'] = $this->model->findOrFail($id)->toArray();
        if( $this->use_views === true )
        {
            return view( $this->edit_view )->with(['data' => $this->data]);
        } 
        else
        {
            return json_encode($this->data);
        }
    }

    public function update($id)
    {
        $crud_update_error = 'Update error';
        
        $updated = $this->model->findOrFail($id);
        foreach( $this->request->except( '_token', '_method', 'id' ) as $name => $val ){
            $clean_name = str_replace( $this->key, '', $name );
            $updated->$clean_name = $val;
        }
        if( $updated->save() ){
            array_push( $this->crud_errors, $crud_update_error );
        }
        
        if( !empty($this->redirectTo) )
        {
            return redirect()->route( $this->redirectTo )->withErrors($this->crud_errors);
        }
        else
        {
            return redirect()->back()->withErrors($this->crud_errors);
        }
    }
    
    public function destroy($id)    
    {
        $deleted = $this->model->findOrFail($id);
        $deleted->delete();
        
        if( !empty($this->redirectTo) )
        {
            return redirect()->route( $this->redirectTo );
        }
        else
        {
            return redirect()->route( $this->key . '.index' );
        }
    }    

}