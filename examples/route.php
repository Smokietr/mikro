<?php

route\get('/', function() {
    return response\html('Hello world!');
});

route\get('/foo/bar', function() {}, 'route.name');

view\path('/path/to/views'); // set views path
route\get('/show_template', function() {
    return route\view('template', ['data' => 'data']); // rendered: /path/to/views/template.php
});

route\post('/save', 'PostController@save');
route\put('/update/:id', ['PostController', 'update']);
route\delete('/destroy/:id', 'destroy_function');
route\any('/hello', 'HelloController@index');

route\group([
    'path' => '/admin',
    'namespace' => 'App\Controllers\Admin\\',
    'middleware' => [],
    'name' => 'admin.'
], function() {
    route\get('/', 'Dashboard@index');

    /*
        route\get('/categories', 'CategoryController@index');
        route\get('/categories/create', 'CategoryController@create');
        route\get('/categores/:id', 'CategoryController@show');
        route\post('/categories', 'CategoryController@store');
        route\get('/categories/:id/edit', 'CategoryController@edit');
        route\put('/categories/:id', 'CategoryController@update');
        route\delete('/categories/:id', 'CategoryController@destroy');
     */
    route\resource('/posts', 'PostController');

    /*
        route\get('/categories', 'CategoryController@index');
        route\get('/categores/:id', 'CategoryController@show');
        route\post('/categories', 'CategoryController@store');
        route\put('/categories/:id', 'CategoryController@update');
        route\delete('/categories/:id', 'CategoryController@destroy');
     */
    route\api_resource('/categories', 'CategoryController');
});

route\resource('/posts', 'App\Controllers\PostController');
route\resource('/posts', 'App\Controllers\PostController', 'resource.name');
route\resource('/categories', App\Controllers\CategoryController::class);
route\resource('/categories', App\Controllers\CategoryController::class, [
  'name' => 'resource.name',
  'middleware' => ['MiddlewareCallback'],
  'only' => ['index', 'show']
]);

route\api_resource('/admin/posts', App\Controllers\Admin\PostController::class);

route\resource('/foo', new class {
  public function index()
  {
    return response\view('foo.index');
  }

  public function show($id) {}
  public function create() {}
  public function store() {}
  public function edit($id) {}
  public function update($id) {}
  public function destroy($id) {}
}, [
  'name' => 'groupname',
  'middleware' => ['FooMiddleware']
]);

route\resource('/bar', [
  'index' => function() {}

  // other resource methods
]);

route\error(function() {
    return response\json(['error' => 404]);
});

route\url('route.name'); // return "/foo/bar"

route\get('/show/page/:id', 'PageController@show', 'show.page');
route\url('show.page', 5); // "/show/page/5"

route\collection(); // returns route collection
route\resolve(); // returns matched route
route\run(); // runs matched route
