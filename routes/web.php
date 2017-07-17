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
    return \App\Models\Bug::all();
}]);

$app->post('/bugs', function (\Illuminate\Http\Request $request) use ($app) {
    $this->validate($request, [
        'happening' => 'required',
        'supposed' => 'required',
        'reproduce' => 'required',
        'contact' => 'required'
    ]);
    $bug = new \App\Models\Bug();
    $data = $request->json();
    $bug->happening = $data->get('happening');
    $bug->supposed = $data->get('supposed');
    $bug->reproduce = $data->get('reproduce');
    $bug->contact = $data->get('contact');
    $bug->client_os = $data->get('os');
    $bug->game_version = $data->get('verson');
    $bug->ip = $request->ip();
    try{
        $bug->saveOrFail();
    } catch (\Illuminate\Database\QueryException $exception) {
        return response()->json(['status'=>'failure', 'message'=>'database error']);
    }
    return response()->json(['status' => 'success']);

});

$app->delete('/bugs/{id}',['middleware' => 'auth', function(\Illuminate\Http\Request $request, $id) use ($app){
    try {
        $bug = \App\Models\Bug::query()->findOrFail($id);
        $bug->delete();
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
        return response()->setStatusCode(400)->json(['status' => 'failure', 'message' => 'bug not found']);
    } catch (Exception $exception) {
        return response()->setStatusCode(500)->json(['status' => 'failure', 'message' => 'server error']);
    }
}]);
