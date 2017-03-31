<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/bugs/view', function (\Illuminate\Http\Request $request) use ($app) {
    return view('bug_view');
});

$app->get('/bugs', ['middleware' => 'auth', function (\Illuminate\Http\Request $request) use ($app) {
    return app('db')->select('SELECT * FROM bugs');
}]);

$app->post('/bugs', function (\Illuminate\Http\Request $request) use ($app) {
    $this->validate($request, [
        'happening' => 'required',
        'supposed' => 'required',
        'reproduce' => 'required',
        'contact' => 'required'
    ]);
    $data = $request->json();
    app('db')->insert('insert into bugs (happening, supposed, reproduce, contact, ip, created_at) VALUES (?,?,?,?,?,?)', [
        $data->get('happening'),
        $data->get('supposed'),
        $data->get('reproduce'),
        $data->get('contact'),
        $request->ip(),
        \Carbon\Carbon::now()
    ]);
//    return response()->setContent('foo!');
    return response()->json(["status"=>"success"]);

});