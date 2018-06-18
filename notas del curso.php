|Crear repositorio en github 

----https://github.com/jheffersonmancera/CMS-Blog-en-LARAVEL-5.5.git
****tutorial https://www.youtube.com/watch?v=vhk7q--yD-4
________________________________________
| crear proyecto con composer

composer create-project --prefer-dist laravel/laravel blog
_________________________________________
creacion de primer modelo junto a la migracion:
php artisan make:model --help para pedir sugerencias
-Crear modelo de Categoria
php artisan make:model Category -m
-Crear modelo Post
php artisan make:model Post -m
-Crear modelo Tag
php artisan make:model Tag -m
//Los modelos se crean en ingles singular y las tablas en ingles plural asi 2017_12_05_023034_create_categories_table
//al adjuntar un -m a la creación del modelo se adjunta la migración que es el archivo que creara la tabla para dicho modelo
_____________________________________________
| CREAR UNA MIGRACION para relacion muchos a muchos
php artisan make:migration create_post_tag_table 
//para relacion muchos a muchos siempre se debe poner en orden alfabetico y en singular con este estandar por ejemplo si hubiera una relacion entre usuarios y categorias seria asi (create_category_user_table)
_________________________________________
|CONFIGURACION DE LA BASE DE DATOS
.env
---campos: DB_DATABASE , DB_USERNAME, DB_PASSWORD
__________________________________
|CREAR BASE DE DATOS
-se crea la base de datos vacia "blog"
___________________________________________________________
|
*1_create_users_table.php:
-se modifican en la carpeta migrations los campos de tablas para que tengan longitudes definidas ex: $table->string('email',128)->unique();

__________________________________
|EJECUTAR MIGRACION
php artisan migrate
__________________________________
|CREACION DE CAMPOS DE TABLAS
*1_create_categories_table.php:
en los archivos de database/migrations/ agregas los campos para la tabla
ex: 
$table->increments('id');

$table->string('name', 64);

$table->string('slug', 128)->unique();
*2_create_categories_table.php: unique:no se repite en esta tabla slug: url amigable ex: laravel5-5 en el campo slug se guarda una cadena de texto que se pondra en el url, esta cadena es con el fin de facilitar a google la busqueda de contenido en nuestra web
___________________________
|ACTUALIZAR BASE DE DATOS A MEDIDA DE CAMBIOS
php artisan migrate:refresh
_______________________________
*1_create_posts_table.php: unsigned: se usa para que no hayan numeros negativos, en el campo user_id guardaremos el id del usuario que sera el dueño de este post, lo mismo aplica para category_id

*2_create_posts_table.php: extracto es el contenido resumido del post y puede estar vacio

*3_create_posts_table.php: en este campo se guarda el titulo del post que seria algo asi juguetes star wars

*4_create_posts_table.php: en este campo se guarda el slug o rastro del pagina que seria juguetes-star-wars

*5_create_posts_table.php: es el contenido principal del post

*6_create_posts_table.php: el campo status puede tener 2 posibles valores published o draft y predeterminadamente sera draft//es importante que las constantes sean en mayusculas.

*7_create_posts_table.php: metodo de llaves foraneas "foreign". Se selecciona el campo user_id que hace referencia al campo id ->references('id') de la tabla users ->on('users')
cascade: si se elimina un usuario se eliminan los post de ese usuario

*8_create_posts_table.php: si eliminamos un usuario, es decir el portador del user_id, se eliminaran en consecuencia automatica los post que tengan relación con ese user_id

*9_create_posts_table.php: si eliminamos una categoria, es decir el portador del category_id, se eliminaran en consecuencia automatica los post que tengan relación con ese category_id

*1_create_tags_table.php: campos para crear la tabla tags

*1_create_post_tag_table.php: esta es una tabla intermedia de una relacion muchos a muchos, donde se relacionan el id del post y el id de la etiqueta, un post puede tener muchas etiquetas y una etiqueta puede tener muchos posts
//unsigned: se usa para que no hayan numeros negativos

*2_create_post_tag_table.php: el campo post_id de esta tabla hace referencia al campo id de la tabla posts
*3_create_post_tag_table.php: si se elimina un post_id es decir si se elimina un id de la tabla post que este relacionado en esta tabla intermedia entonces se eliminaran en esta tabla tambien. Aqui basicamente se lleva el registro por filas de los etiquetas que tiene un post, cuando deja de existir dicho post, debe dejar de existir la relacion con la etiqueta.
*4_create_post_tag_table.php: el campo tag_id de esta tabla intermedia se refiere al id de la tabla tags,
*5_create_post_tag_table.php: si se elimina de la tabla tags algun item que tenga el id relacionado en esta tabla intermedia entonces se elimina de aca toda fila que contenga ese id eliminado.

-php artisan migrate:refresh


_______________________________
|LLENAR BASE DE DATOS CON DATOS DE PRUEBA
*Hacer Factory: el factory representa la estructura de una tabla
php artisan make:factory CategoryFactory
php artisan make:factory PostFactory
php artisan make:factory TagFactory
*Crear Seeder: el seeder ayuda a llenar la tabla de datos falsos, los nombres de los seeders van en plural porque se refieren a las tablas de la base de datos
php artisan make:seeder CategoriesTableSeeder
php artisan make:seeder PostsTableSeeder
php artisan make:seeder TagsTableSeeder
php artisan make:seeder UsersTableSeeder

*Llenar informacion de los Factory:
*1CategoryFactory: se define el modelo en App\Category, la funcion llega con un parametro que invoca a Faker y una variable
*ex: CategoryFactory
$factory->define(App\Category::class, function (Faker $faker) {//se define el modelo en App\Category

    $title= $faker->sentence(4);

    return [

        'name'=> $title,

        'slug'=> $str_slug($title),

        'body'=> $faker->text(500),

    ];

});
*2CategoryFactory.php: el helper de laravel str_slug convierte una cadena a formato slug
*1PostFactory.php: en este caso como solamente existen 2 posibles valores para llenar el campo status de la tabla se llama a faker para que por medio de randomElemten escoja entre el arreglo que le damos.

*1UserFactory.php: en este campo se guarda el token para recordar el inicio de sesión.

*Llenar seeder
*ex: TagsTableSeeder:
factory(App\Tag::class,20)->create();
   
*1DatabseSeeder: Dar orden de llenado de las tablas en DatabseSeeder
database seeder sera llamado a la hora de ejecutar los seeders aqui relacionamos todos los archivos que queremos ejecutar para el llenado

$this->call(CategoriesTableSeeder::class);

*EJECUTAR LLENADO con:
php artisan migrate:refresh --seed

*LLENADO  en una tabla relacionada
factory(App\Post::class,300)->create()->each(function(App\Post $post){

        	$post->tags()->attach([//*1PostsTableSeeder.php: con attach relaciono un post con una etiqueta o varias como en este caso, el tags() hace referencia a la funcion que esta en el modelo Post.php (*1Post.php) el cual devuelve la relacion entre Post y Tag
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

*1Post.php:belongs to many relacion de muchos a muchos tiene y pertenece a muchas Tag
*2Post.php: como la relación implica varias tags se pone en plural  
*3Post.php: en el caso de category al se una relacion de uno a uno se usa en singular el nombre de la función.

*4Post: relacionamos todos los campos que tienen permitido guardarse fuera de eso permitimos que un formulario envie datos en forma masiva, si hay un campo vulnerable en nuestra base de datos, al no estar registrado aqui no se podra llenar de forma maliciosa.

//EN LA ENTIDAD Post.php basicamente relaciono la misma relación que hay en la base de datos

*1Category.php: en este caso usamos hasmay porque es una relacion de uno a muchos
uno a muchos -> hasmany, una categoria tiene muchos post
muchos a muchos -> belongsToMany, un post tiene y pertenece a muchas etiquetas
uno a uno -> belongsto, un post pertenece a una categoria

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
