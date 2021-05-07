<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class UserAuthController extends Controller
{
    function login()
    {
        return view('auth.login');
    }

    function register()
    {
        return view('auth.register');
    }

    function create(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:12'
        ]);

        $params = [
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];
        $query = User::insertOrUpdateUser($params);

        if ($query) {
            return back()->with('success', 'You have been successfuly registered');
        }else {
            return back()->with('fail', 'Something went wrong');
        }
    }

    function check(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:6|max:12'
        ]);

        $user = User::checkLogin($request);

        if ($user) {
            if (Hash::check($request->password, $user['password'])) {
                $request->session()->put('LoggedUser', $user['id']);
                return redirect('home');
            } else {
                return back()->with('fail', 'Invalid password');
            }
        } else {
            return back()->with('fail', 'No account found for this user name');
        }
    }

    function home()
    {
        if (session()->has('LoggedUser')) {
            $data['id'] = session('LoggedUser');
            $user = User::checkLogin($data);
        }
        if ($user['permission'] == 0 || $user['permission'] == 1) {
            session(['UserName' => $user['name']]);
            return view('admin.home');
        }

        if ($user['permission'] == 2) {
            session(['UserName' => $user['name']]);
            return redirect()->to('/');
        }
    }

    function logout()
    {
        if(session()->has('LoggedUser'))
        {
            session()->flush();
            return redirect('login');
        }
    }



    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        try{
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('login');
        }
        
        if(explode("@", $user->email)[1] !== 'gmail.com')
        {
            return redirect()->to('/');
        }
 
        $data['email'] = $user->email;
        $existingUser = User::checkLogin($data);
        
        if($existingUser)
        {
            session()->put('LoggedUser', $existingUser['id']);
            return redirect('home');
        }else
        {
            $params = [
                'name' => $user->name,
                'email' => $user->email,
                'password' => null,
                'permission' => 2,
                'google_id' => $user->id,
                'avatar' => $user->avatar,
                'avatar_original' => $user->avatar_original
            ];
            $query = User::insertOrUpdateUser($params);
        }
        return redirect()->to('/');
    }
}
