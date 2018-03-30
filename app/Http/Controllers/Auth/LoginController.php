<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\Hash;
use Adldap;
use Auth;
use Image;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function username()
    {
        return 'login';
    }

/*
    public function authenticate(Request $request)
    {
        dd($request);

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            // Authentication passed...
            return redirect()->intended('/');
        }
        else
        {

        }
    }
*/

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array(
                'login' => 'required',
                'password' => 'required'
            )
        );

        $user = User::where(['login'=>$request->login])->first();

        if ($user)
        {
            if (Hash::check($request->password,$user->password))
            {
                Auth::login($user, true);

                return redirect()->intended('/');
            }
            else
            {
                if (Adldap::auth()->attempt($request->login, $request->password))
                {
                    $user->password = Hash::make($request->password);
                    $user->save();

                    Auth::login($user, true);

                    return redirect()->intended('/');
                }
                else
                {
                    $validator->getMessageBag()->add('password', trans('auth.WrongPassword'));

                    return Redirect::back()->withErrors($validator)->withInput();
                }
            }
        }
        else
        {
            if (Adldap::auth()->attempt($request->login, $request->password))
            {   
                $aduser = Adldap::search()->where('mail',$request->login.config('app.domain'))->first();

                $data['name'] = $aduser->cn[0];
                $data['rusname'] = $aduser->st[0];
                $data['employeenumber'] = $aduser->employeenumber[0];
                $data['email'] = $aduser->mail[0];
                $data['phone'] = $aduser->facsimiletelephonenumber[0];
                $data['title'] = $aduser->title[0];
                $data['department'] = $aduser->department[0];
                $data['login'] = $request->login;
                $data['password'] = Hash::make($request->password);

                $avatar = '';
                if ($aduser->thumbnailphoto[0])
                {
                    $img = Image::make($aduser->thumbnailphoto[0]);
                    $avatar = (string)$img->encode('jpg', 85)->encode('data-url');
                }

                $data['avatar'] = $avatar;

                //dd($data);

                $user = User::create($data);

                Auth::login($user, true);

                return redirect()->intended('/');
            }
            else
            {
                $validator->getMessageBag()->add('login', trans('auth.NotFoundADLocal'));

                return Redirect::back()->withErrors($validator)->withInput();
            }

        }

    }
}
