<?php
//controller untuk history belanja
namespace App\Http\Controllers;
//menggunakan/memanggil model user,auth,alert,dll
use App\Models\Barang;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\PesananDetail;
use Auth;
use Alert;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    //fungsi untuk auth
    public function __construct()
    {
        $this->middleware('auth');
    }
    //fungsi untuk menampilkan history pemesanan
    public function index()
    {   //Yang tidak sama dengan nul maka menampikan 1 (karena get)
    	$pesanans = Pesanan::where('user_id', Auth::user()->id)->where('status', '!=',0)->get();
        //view menampilkan banyak
    	return view('history.index', compact('pesanans'));
    }
    //fungsi untuk menampilkan detail pemesanan
    public function detail($id)
    {
    	$pesanan = Pesanan::where('id', $id)->first();
    	$pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)->get();

     	return view('history.detail', compact('pesanan','pesanan_details'));
    }
}
