<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', [HomeController::class, 'home'])->name('home2');

Route::get('/about',[HomeController::class, 'about'])->name('about');

Route::resource('posts',PostController::class)
->except(['index'])
->middleware(('auth'));

Route::match(['get','post'],'/register',[RegisterController::class,'register'])->name('register')
->middleware(('guest'));

Route::match(['get','post'],'/login',[LoginController::class,'login'])->name('login')
->middleware(('guest'));

Route::get('/logout',[AuthenticatedSessionController::class, 'destroy'])->name('logout')
->middleware(('auth'));

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Auth;
// use App\Models\User;

// class AuthController extends Controller
// {
//     public function register(Request $request){
//         if($request->isMethod(('get'))){
//             return view('auth.register');
//         }

//         $request->validate([
//             'name'=>'required',
//             'email'=>'required|email|unique:users',
//             'password'=>'required|min:6',
//         ]);

//         User::create([
//             'name'=>$request->input('name'),
//             'email'=>$request->input('email'),
//             'password'=>Hash::make($request->input('password')),
//         ]);

//         return redirect()
//         ->route('login')
//         ->with('success','Your account has been created! You can now login.');
//     }
//     public function login(Request $request){
//         if($request->isMethod(('get'))){
//             return view('auth.login');
//         }

//         $credentials=$request->validate([
//             'email'=>'required',
//             'password'=>'required',
//         ]);

//         if(Auth::attempt($credentials)){
//             return redirect()
//                 ->route('home2')
//                 ->with('success','You have successfully logged in');
//         }

//         return redirect()
//             ->route('login')
//             ->withErrors('Provided login information is not valid');

//     }
//     public function logout(Request $request){
//         Auth::logout();
//         $request->session()->invalidate();
//         $request->session()->regenerateToken();
//         return redirect()
//             ->route('home2')
//             ->with('success','You have successfully logged out');
//     }
// }
