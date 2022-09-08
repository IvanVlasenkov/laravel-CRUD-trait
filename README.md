Трейт и набор вспомогательных форм и стилей для CRUD операций.
Установка :

1. Проверить наличие composer.json в каталоге packages/Vlasenkov/Crud.
   Добавить в composer.json пректа ( котрорый в корне проекта !!! ) в секцию autoload {psr-4:}
   - "Vlasenkov\\Crud\\": "packages/Vlasenkov/Crud/src/"
   Выполнить composer dump-autoload
   
2. Добавить в config/app.php
    /*
     * Package Service Providers...
     */
    Vlasenkov\Crud\CrudServiceProvider::class,

3. Опубликовать пакет :
   php artisan vendor:publish

4. В роутах указываем маршруты через ресурс:
    Route::resource('example', 'PointController');
    
5. В контроллере указываем трейт:
    use Vlasenkov\Crud\CrudTrait;

    Пример загрузчика:
    public function __construct(Request $request, Example $model){
        $this->request     = $request;
        $this->model       = $model;
        $this->key         = $this->model->getTableName();
        $this->data['key'] = $this->key;
        
        $this->data['fields'] = $this->model->getFields();
    }
    Остальное в трейте.
    
6. В модели задаем:

    /**
     * The model table name.
     *
     * @var string
     */      
    protected $table = 'example'; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'status'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => 'Anonimus',
        'description' => '',
        'status' => 'unset',        
    ]; 
    
    /**
     * The attributes structure.
     *
     * @var array
     */    
    protected $fields = [
        'id' => 
            [ 'name' => 'id', 'type' => 'numeric', 'required' => true, 'redact' => false ],    

        'name' => 
            [ 'name' => 'name', 'type' => 'string', 'required' => true, 'redact' => true ],

        'description' => 
            [ 'name' => 'description', 'type' => 'string', 'required' => false, 'redact' => true ],

        'status' => 
            [ 'name' => 'status', 'type' => 'enum', 'select' =>['unset', 'deleted', 'public'], 'required' => false, 'redact' => true ],

        'created_at' => 
            [ 'name' => 'created_at', 'type' => 'datatime', 'required' => false, 'redact' => false ],

        'updated_at' => 
            [ 'name' => 'updated_at', 'type' => 'datatime', 'required' => false, 'redact' => false ],            
    ];

    public function getFields()
    {
        return $this->fields;
    }
    
    public function getTableName()
    {
        return $this->table;
    }    
