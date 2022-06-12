<?php
//controller untuk profil user
namespace App\Http\Controllers;
//menggunakan/memanggil model user,auth,alert,dll
use Auth;
use Alert;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
	//fungsi untuk auth
     public function __construct()
    {
        $this->middleware('auth');
    }
	//fungsi menampilkan profil user berdasarkan id user
    public function index()
    {
    	$user = User::where('id', Auth::user()->id)->first();

    	return view('profile.index', compact('user'));
    }
	//fungsi update
    public function update(Request $request)
    {
    	 $this->validate($request, [
            'password'  => 'confirmed',
        ]);

    	$user = User::where('id', Auth::user()->id)->first();
    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->nohp = $request->nohp;
    	$user->alamat = $request->alamat;
    	if(!empty($request->password))
    	{
    		$user->password = Hash::make($request->password);
    	}
    	
    	$user->update();
	//Notifikasi pop up 
    	Alert::success('User Sukses diupdate', 'Success');
    	return redirect('profile');
    }
}
