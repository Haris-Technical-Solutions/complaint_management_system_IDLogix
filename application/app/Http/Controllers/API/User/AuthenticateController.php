<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responses\Authentication\AuthenticateResponse;
use App\Mail\ForgotPassword;
use App\Repositories\ClientRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
//use Validator;

class AuthenticateController extends Controller
{
    
    protected $userrepo;

    /**
     * The client instance.
     */
    protected $clientrepo;

    public function __construct(
        UserRepository $userrepo,
        ClientRepository $clientrepo) {

        //parent
        parent::__construct();

        //vars
        $this->userrepo = $userrepo;
        $this->clientrepo = $clientrepo;

        //guest
        $this->middleware('guest')->except([
            'updatePassword',
        ]);

        //logged in
        $this->middleware('auth')->only([
            'updatePassword',
        ]);

        //general middleware
        $this->middleware('authenticationMiddlewareGeneral');
    }

    public function loginUser(Request $request)
    {
     
         //  return $request;
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->plainTextToken;

            $auth_user = User::where('email', $request->email)->first();
            // $auth_user->token = $token;
            $auth_user->api_token = $token;
            
            $auth_user->save();


            return response()->json(['token' => $token, 'user' => $user], 200);
        }

        return response()->json(['message' => 'Email or password is incorrect'], 200);
    }



    public function LoginAction(){
            //get credentials
           // return 'tree';
            $credentials = request()->only('email', 'password');
            $remember = (request('remember_me') == 'on') ? true : false;

            //check credentials
            if (Auth::attempt($credentials, $remember)) {
                //if client - check if account is not suspended
                if (auth()->user()->is_client) {
                    if ($client = \App\Models\Client::Where('client_id', auth()->user()->clientid)->first()) {
                        if ($client->client_status != 'active') {
                            abort(409, __('lang.account_has_been_suspended'));
                        }
                    } else {
                        abort(409, __('lang.item_not_found'));
                    }
                }

                //client are not allowed to login
                if (auth()->user()->is_client && config('system.settings_clients_app_login') != 'enabled') {
                    abort(409, __('lang.clients_disabled_login_error'));
                }

                //if account not active
                if (auth()->user()->status != 'active') {
                    auth()->logout();
                    abort(409, __('lang.account_has_been_suspended'));
                }
            } else {
                //login failed message
                abort(409, __('lang.invalid_login_details'));
            }

            $payload = [
                'type' => request('action'),
            ];
               return true;
              // return redirect()->route('home');

            //show the form
            //return new AuthenticateResponse($payload);

}
}
