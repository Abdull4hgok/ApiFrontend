<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

 
class CustomAuthController extends Controller
{
    public function home()
    {
        return view('homepage');
    } 
 
    public function index()
    {
        return view('login');
    }  
       
    public function login(Request $request)
    {
        $response = Http::post('http://127.0.0.1:8000/api/login',[
            'email' => $request->email,
            'password'=> $request->password,
        ]);
       $jsonData = $response->json();
    // $response = Http::withToken(
    //     session('token')
    // )->post(    
    //     'http://127.0.0.1:8000/api/login',
    //     [
    //         'email' => $request->email,
    //         'password'=> $request->password,
    //     ]
    // )->json();
    
      if ($response ['status']==1) 
        {
            session(['token'=>$response[0]['token'],]);
            return redirect('products') ->with('logout',' ');;
        }
    elseif ($response ['status']==0)
        {
            
        return redirect('login')->with(['status'=>$response ['status']]);

        }
       
                
    }
 
    public function signup()
    {
        return view('registration');
    }
       
    public function signupsave(Request $request)
    {  
        $response = Http::post('http://127.0.0.1:8000/api/register',[
            'name' => $request->name,
            'email' => $request->email,
            'password'=> $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);
        $jsonData = $response->json();
        
        return redirect("dashboard");
        
    }
 
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }    
     
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
        return redirect('/login');
    }
     
    public function signOut() {
$response = Http::withToken(
        session('token')
    )->post(    
        'http://127.0.0.1:8000/api/logout',
       
    )->json();
    session(['token'=>'']);  
    return redirect()->route('login')
    ->with('success','Logged out successfully');
        return redirect('login');
    }
}