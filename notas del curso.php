|Crear repositorio en github 

----https://github.com/jheffersonmancera/CMS-Blog-en-LARAVEL-5.5.git
****tutorial https://www.youtube.com/watch?v=vhk7q--yD-4
________________________________________
| crear proyecto con composer

composer create-project --prefer-dist laravel/laravel blog
_________________________________________
creacion de primer modelo junto a la migracion:
php artisan make: model --help para pedir sugerencias
php artisan make:model Category -m
php artisan make:model Post -m
php artisan make:model Tag -m
_____________________________________________
| CREAR UNA MIGRACION para relacion muchos a muchos
php artisan make:migration create_post_tag_table 
//se debe hacer en orden alfabetico con este estandar
_________________________________________
|CONFIGURACION DE LA BASE DE DATOS
.env
---campos: DB_DATABASE , DB_USERNAME, DB_PASSWORD
__________________________________
|CREAR BASE DE DATOS
-se crea la base de datos vacia "blog"
___________________________________________________________
|se modifican en la carpeta migrations los campos de tablas para que tengan longitudes definidas ex: $table->string('email',128)->unique();
__________________________________
|EJECUTAR MIGRACION
php artisan migrate
__________________________________
|CREACION DE CAMPOS DE TABLAS
en los archivos de database/migrations/ agregas los campos para la tabla
ex: 
$table->increments('id');

$table->string('name', 64);

$table->string('slug', 128)->unique();
___________________________
|ACTUALIZAR BASE DE DATOS A MEDIDA DE CAMBIOS
php artisan migrate:refresh

_______________________________
|LLENAR BASE DE DATOS CON DATOS DE PRUEBA
*Hacer Factory: el factory representa la estructura de una tabla
php artisan make:factory CategoryFactory
php artisan make:factory PostFactory
php artisan make:factory TagFactory
*Crear Seeder: el seeder ayuda a llenar la tabla de datos falsos
php artisan make:seeder CategoriesTableSeeder
php artisan make:seeder PostsTableSeeder
php artisan make:seeder TagsTableSeeder
php artisan make:seeder UsersTableSeeder

*Llenar informacion de los Factory:
*ex: CategoryFactory
$factory->define(App\Category::class, function (Faker $faker) {//se define el modelo en App\Category

    $title= $faker->sentence(4);

    return [

        'name'=> $title,

        'slug'=> $str_slug($title),

        'body'=> $faker->text(500),

    ];

});
*Llenar seeder
*ex: TagsTableSeeder:
factory(App\Tag::class,20)->create();

*Dar orden de llenado de las tablas en DatabseSeeder
ex:        
$this->call(UsersTableSeeder::class);

$this->call(CategoriesTableSeeder::class);

*EJECUTAR LLENADO con:
php artisan migrate:refresh --seed

*LLENAR en una tabla relacionada
factory(App\Post::class,300)->create()->each(function(App\Post $post){

        	$post->tags()->attach([
        		rand(1,5),
        		rand(6,14),
        		rand(15,20),
        	]);
        });
*Crear funciones en el modelo para llenar tablas relacionadas
public function user(){
    	return $this->belongsTo(User::class);
    }
    public function tags(){
    	return $this->belongsTo(Tag::class); 	
    }
    public function category(){
    	return $this->belongsToMany(category::class);

___________________________
|CREAR LOGIN
*php artisan make:auth
____________________________
|CREAR RUTA A PAGINA PRINCIPAL DE blog
routes/web.php
______________________________________
|CREAR CONTROLADOR 
php artisan make:controller Web/PageController
_____________________________________
|CREAR METODO blog dentro de Web/PageController
 public function blog(){

    	return view('web.posts'); 

    }
    
_________________________________________
|CREAR VISTA
crear views/web/posts.blade.php
cuando se crea el sistema de autenticacion aparece una plantilla en layouts/app.blade.php
de esta se extendera para la vista
________________________________
|CONTENIDO DE POSTS.BLADE.PHP
@extends('layouts.app')


@section('content')

<div class="container">

	<div class="col-md-8 col-md-offset-2">

		<h1>Lista de artículos</h1>

	</div>


</div>
______________________________
__________
|ROUT PARA LOS SLUG
Route::get('blog/{slug}', 'Web\PageController@post')->name('post');
_______________________________
____________
|REDIRECCIONAR A RAIZ DESPUES DE LOGUEARSE REGISTRARSE ETC
logincontroller.php
ResetPasswordController.php
RegisterController.php
:
    protected $redirectTo = '/';
_____________________________
|Creacion de botones de administracion
app.blade.php
<li><a href="{{route('tags.index')}}">Etiquetas</a></li>

-crear rutas-
Route::resource('posts', 'Admin\PostController');

_______________________________
|CONFIGURAR NOMBRE DE LA APLICACION
.env
APP_NAME= CMS

_________________________
|CREAR CONTROLADORES
php artisan make:controller Admin/TagController --resource
//Controlador con metodos para crud

php artisan make:controller Admin/PostController --resource

php artisan make:controller Admin/CategoryController --resource
________________________________
|CREAR vistas administrativas
views/admin/tag/create.blade.php
views/admin/tag/edit.blade.php
views/admin/tag/index.blade.php
views/admin/tag/partials/form.blade.php
________________________________
|TAGS
tagcontroller.php
-agreagas uso de modelo:
    use App\Tag; 
//agregar funcion de autenticacion obligatoria
    public function __construct()
    {
        $this->middleware('auth');
    }


//Configurar metodo index.

crear variable con los tag ordenados por id y paginados.
con la funcion dd($tags); se puede ver el contenido de la variable

//Configurar metodo create.
retornar la vista de crear etiquetas

//configurar metodo store
//configurar metodo update
//configurar metodo destroy

_______________________________________
|CREAR REQUEST 
php artisan make:request TagStoreRequest
php artisan make:request TagUpdateRequest
-invocar archivos request en el tagcontroller
-Actualizar el parametro en los metodos para que llament al correspondiente request.
TagStoreRequest.php
poner en true el authorize()

php artisan route:list// sirve para ver el listado de rutas y parametros
