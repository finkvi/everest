<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/test', function () {
    //$search = Adldap::search()->where('sn', 'starts_with', 'Kosi')->get();
    //dd($search);

	$username = '';
	$password = '';
    if (Adldap::auth()->attempt($username, $password))
    {
    	echo('good!');
    	$search = 'edmitrieva1';
    	$user = Adldap::search()->where('mail','starts_with',$search.'@')->first();
    	dd($user);
	}
	else
	{
		die('failed!');
	}
});

Route::get('/test2', function() {
	//$user = new App\Http\Controllers\UserController;
	//dd(json_decode($user->getFromLDAP('akosinov')));

	$user = App\User::find(21);
	//dd($user);
	//Notification::send($user, new App\Task);
	//$task = App\Task::find(2);
	//dd($task);
	//$user->notify(new App\Notifications\TaskAddedTelegram($task));
	$user->notify(new \App\Notifications\UserAdded($user));

});

Route::get('/update_phones', function() {

	$users = App\User::all();

	foreach ($users as $u)
	{
		echo $u->name."<br>";
		$aduser = Adldap::search()->where('mail',$u->login.config('app.domain'))->first();
		if ($aduser)
		{
			echo "** ".$aduser->facsimiletelephonenumber[0];
			if ($aduser->facsimiletelephonenumber[0])
			{
				$u->phone = $aduser->facsimiletelephonenumber[0];
				$u->save();
			}
		}
		else
			echo "** not found";

		echo "<br><br>";
	}

});

Route::get('/phpinfo', function () {

	phpinfo();

});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

	Route::get('/logout', function(){
		Auth::logout();
		return redirect('/');
	});

	Route::get('/', ['as'=>'user.profile', 'uses'=>'UserController@profile']);
	Route::get('/profile', ['as'=>'user.profile', 'uses'=>'UserController@profile']);
	Route::put('/user/avatar', ['as'=>'user.avatar-upload', 'uses'=>'UserController@uploadAvatar']);

	Route::get('/user/salary/{user}/{salary?}', ['as'=>'user.salary.form', 'uses'=>'UserController@formSalary']);
	Route::put('/user/salary', ['as'=>'user.salary.store', 'uses'=>'UserController@storeSalary']);

	Route::get('/user/sync-ad/{user}', ['as'=>'user.sync.ad', 'uses'=>'UserController@syncUserWithAD']);

	// My employees
	Route::get('/myemployees', ['as'=>'user.myemployees', 'uses'=>'UserController@myemployees']);
	Route::get('/myemployees/{user}', ['as'=>'user.employee_profile', 'uses'=>'UserController@profile']);

	// Support forum
	Route::get('/support', ['as'=>'support.list', 'uses'=>'PostController@list']);
	Route::get('/support/post', ['as'=>'support.form', 'uses'=>'PostController@form']);
	Route::post('/support/post', ['as'=>'support.post', 'uses'=>'PostController@store_post']);
	Route::put('/support/comment/{post}', ['as'=>'support.comment', 'uses'=>'PostController@store_comment']);

	// BusinessUnits
	Route::get('/admin/bu', ['as'=>'bu.list', 'uses'=>'BusinessUnitController@list']);
	Route::get('/admin/bu/store/{bu?}', ['as'=>'bu.form', 'uses'=>'BusinessUnitController@form']);
	Route::put('/admin/bu/store', ['as'=>'bu.store', 'uses'=>'BusinessUnitController@store']);
	Route::get('/admin/bu/delete/{bu?}', ['as'=>'bu.delete', 'uses'=>'BusinessUnitController@delete']);

	// Flows
	Route::get('/admin/flows', ['as'=>'flow.list', 'uses'=>'FlowController@list']);
	Route::get('/admin/flow/store/{flow?}', ['as'=>'flow.form', 'uses'=>'FlowController@form']);
	Route::put('/admin/flow/store', ['as'=>'flow.store', 'uses'=>'FlowController@store']);
	Route::get('/admin/flow/delete/{flow?}', ['as'=>'flow.delete', 'uses'=>'FlowController@delete']);
	Route::get('/admin/flow/users/{flow?}', ['as'=>'flow.users', 'uses'=>'FlowController@usersList']);
	Route::post('/admin/flow/users', ['as'=>'flow.storeusers', 'uses'=>'FlowController@usersStore']);
	Route::get('/admin/flow/competences/{flow?}', ['as'=>'flow.competences', 'uses'=>'FlowController@listCompetences']);
	Route::post('/admin/flow/competences', ['as'=>'flow.storecompetences', 'uses'=>'FlowController@storeCompetences']);

	// Programs
	Route::get('/admin/programs', ['as'=>'program.list', 'uses'=>'ProgramController@list']);
	Route::get('/admin/program/store/{program?}', ['as'=>'program.form', 'uses'=>'ProgramController@form']);
	Route::put('/admin/program/store', ['as'=>'program.store', 'uses'=>'ProgramController@store']);
	Route::get('/admin/program/delete/{program?}', ['as'=>'program.delete', 'uses'=>'ProgramController@delete']);
	Route::get('/admin/program/flows/{program?}', ['as'=>'program.flows', 'uses'=>'ProgramController@flowsList']);
	Route::post('/admin/program/flows', ['as'=>'program.storeflows', 'uses'=>'ProgramController@flowStore']);
	Route::get('/admin/program/users/{program?}', ['as'=>'program.users', 'uses'=>'ProgramController@usersList']);
	Route::post('/admin/program/users', ['as'=>'program.storeusers', 'uses'=>'ProgramController@usersStore']);

	// Projects
	Route::get('/admin/projects', ['as'=>'project.list', 'uses'=>'ProjectController@list']);
	Route::get('/admin/project/store/{project?}', ['as'=>'project.form', 'uses'=>'ProjectController@form']);
	Route::put('/admin/project/store', ['as'=>'project.store', 'uses'=>'ProjectController@store']);
	Route::get('/admin/project/delete/{project?}', ['as'=>'project.delete', 'uses'=>'ProjectController@delete']);
	Route::get('/admin/project/flows/{project?}', ['as'=>'project.flows', 'uses'=>'ProjectController@flowsList']);
	Route::post('/admin/project/flows', ['as'=>'project.storeflows', 'uses'=>'ProjectController@flowStore']);
	Route::get('/admin/project/users/{project?}', ['as'=>'project.users', 'uses'=>'ProjectController@usersList']);
	Route::post('/admin/project/users', ['as'=>'project.storeusers', 'uses'=>'ProjectController@usersStore']);

	// Users
	Route::get('/admin/users', ['as'=>'user.list', 'uses'=>'UserController@list']);
	Route::get('/admin/user/store/{user?}', ['as'=>'user.form', 'uses'=>'UserController@form']);
	Route::put('/admin/user/store', ['as'=>'user.store', 'uses'=>'UserController@store']);
	Route::get('/admin/user/delete/{user?}', ['as'=>'user.delete', 'uses'=>'UserController@delete']);
	Route::get('/admin/user-from-ldap/{login}', ['as'=>'user.getldap', 'uses'=>'UserController@getFromLDAP']);

	// Competences
	Route::get('/admin/competences', ['as'=>'competence.list', 'uses'=>'CompetenceController@list']);
	Route::get('/admin/competence/store/{competence?}', ['as'=>'competence.form', 'uses'=>'CompetenceController@form']);
	Route::put('/admin/competence/store', ['as'=>'competence.store', 'uses'=>'CompetenceController@store']);
	Route::get('/admin/competence/delete/{competence?}', ['as'=>'competence.delete', 'uses'=>'CompetenceController@delete']);
	Route::get('/admin/clevel/store/{competence}/{clevel?}', ['as'=>'competence.levelform', 'uses'=>'CompetenceController@formLevel']);
	Route::put('/admin/clevel/store', ['as'=>'competence.levelstore', 'uses'=>'CompetenceController@storeLevel']);
	Route::get('/admin/clevel/delete/{clevel?}', ['as'=>'competence.deletelevel', 'uses'=>'CompetenceController@deleteLevel']);
	Route::get('/competence-level/{competence}/{clevel}', ['as'=>'competence.levelinfo', 'uses'=>'CompetenceController@getLevelInfo']);

	// SubCompetences
	Route::get('/admin/subcompetence/{competence}/{subcompetence?}', ['as'=>'subcompetence.form', 'uses'=>'SubCompetenceController@form']);
	Route::put('/admin/subcompetence', ['as'=>'subcompetence.store', 'uses'=>'SubCompetenceController@store']);
	Route::get('/admin/subcompetence-delete/{subcompetence?}', ['as'=>'subcompetence.delete', 'uses'=>'SubCompetenceController@delete']);
	Route::get('/admin/subclevel/store/{subcompetence}/{subclevel?}', ['as'=>'subcompetence.levelform', 'uses'=>'SubCompetenceController@formLevel']);
	Route::put('/admin/subclevel/store', ['as'=>'subcompetence.levelstore', 'uses'=>'SubCompetenceController@storeLevel']);
	Route::get('/admin/subclevel/delete/{subclevel?}', ['as'=>'subcompetence.deletelevel', 'uses'=>'SubCompetenceController@deleteLevel']);

	// Profiles
	Route::get('/admin/profiles', ['as'=>'profile.list', 'uses'=>'ProfileController@list']);
	Route::get('/admin/profile/store/{flow}/{profile?}', ['as'=>'profile.form', 'uses'=>'ProfileController@form']);
	Route::put('/admin/profile/store', ['as'=>'profile.store', 'uses'=>'ProfileController@store']);
	Route::get('/admin/profile/delete/{profile?}', ['as'=>'profile.delete', 'uses'=>'ProfileController@delete']);

	//Evaluation
	Route::get('/evaluate/{user?}', ['as'=>'evaluate.form', 'uses'=>'EvaluationController@form']);
	Route::post('/evaluate', ['as'=>'evaluate.store', 'uses'=>'EvaluationController@store']);

	//Tasks
	Route::get('/task/{user}/{competence}/{task?}', ['as'=>'task.form', 'uses'=>'TaskController@form']);
	Route::post('/task', ['as'=>'task.store', 'uses'=>'TaskController@store']);
	//Route::get('/task/complete/{task}', ['as'=>'task.complete', 'uses'=>'TaskController@complete']);
	Route::get('/task-complete/{task}', ['as'=>'task.complete', 'uses'=>'TaskController@complete']);
	Route::get('/task-confirm/{task}', ['as'=>'task.confirm', 'uses'=>'TaskController@confirm']);

	//Recomends
	Route::get('/recomends', ['as'=>'recomend.index', 'uses'=>'RecomendController@index']);
	Route::get('/recomend/store/{rec?}', ['as'=>'recomend.form', 'uses'=>'RecomendController@form']);
	Route::put('/recomend/store', ['as'=>'recomend.store', 'uses'=>'RecomendController@store']);
	Route::get('/recomend/delete/{rec?}', ['as'=>'recomend.delete', 'uses'=>'RecomendController@delete']);

	Route::get('/home', 'HomeController@index');

});



