<?php
//controller untuk pemesanan barang,dll
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

class PesanController extends Controller
{
    //fungsi untuk auth
    public function __construct()
    {
        $this->middleware('auth');
    }

    //fungsi untuk menampilkan barang di home berdasarkan id
    public function index($id)
    {
    	$barang = Barang::where('id', $id)->first();

    	return view('pesan.index', compact('barang'));
    }
    //fungsi untuk buy dan check out
    public function pesan(Request $request, $id)
    {	//get data dari tabel barang
    	$barang = Barang::where('id', $id)->first();
    	$tanggal = Carbon::now();

    	//validasi jika pemebelian barang melebihi stok maka tidak bisa 
    	if($request->jumlah_pesan > $barang->stok)
    	{
            Alert::error('Pemesanan tidak berhasil karena Melebih stok', 'Error');
    		return redirect('pesan/'.$id);
    	}

    	//cek validasi
    	$cek_pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
    	//simpan ke database pesanan (jika profil user telah lengkap)
    	if(empty($cek_pesanan))
    	{
    		$pesanan = new Pesanan;
	    	$pesanan->user_id = Auth::user()->id;
	    	$pesanan->tanggal = $tanggal;
	    	$pesanan->status = 0;
	    	$pesanan->jumlah_harga = 0;
            $pesanan->kode = mt_rand(100, 999);
	    	$pesanan->save();
    	}
    	

    	//simpan ke database pesanan_detail (jika melakukan pembelian barang lagi)
    	$pesanan_baru = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();

    	//cek pesanan_detail. Jika membeli barang!
    	$cek_pesanan_detail = PesananDetail::where('barang_id', $barang->id)->where('pesanan_id', $pesanan_baru->id)->first();
    	if(empty($cek_pesanan_detail))
        { //jika tidak ada maka buat pesanan_detail baru
    		$pesanan_detail = new PesananDetail;
	    	$pesanan_detail->barang_id = $barang->id;
	    	$pesanan_detail->pesanan_id = $pesanan_baru->id;
	    	$pesanan_detail->jumlah = $request->jumlah_pesan;
	    	$pesanan_detail->jumlah_harga = $barang->harga*$request->jumlah_pesan;
	    	$pesanan_detail->save();
    	}else  //jika ada maka tambahkan (jumlah barang dan harga)
    	{
    		$pesanan_detail = PesananDetail::where('barang_id', $barang->id)->where('pesanan_id', $pesanan_baru->id)->first();

    		$pesanan_detail->jumlah = $pesanan_detail->jumlah+$request->jumlah_pesan;

    		//harga terbaru hasil akumulasi semua harga pesanan_detail
    		$harga_pesanan_detail_baru = $barang->harga*$request->jumlah_pesan;
	    	$pesanan_detail->jumlah_harga = $pesanan_detail->jumlah_harga+$harga_pesanan_detail_baru;
	    	$pesanan_detail->update();
    	}

    	//jumlah total pesanan(harga)
    	$pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
    	$pesanan->jumlah_harga = $pesanan->jumlah_harga+$barang->harga*$request->jumlah_pesan;
    	$pesanan->update();
    	
        Alert::success('Pesanan Sukses Masuk Keranjang', 'Success');
    	return redirect('check-out');

    }
    //fungsi menampilkan pesanan di check out
    public function check_out()
    {
        //get data dari tabel pesanan
        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
        $pesanan_details = [];    
        if(!empty($pesanan))
        {
            $pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)->get();
        }
        
    return view('pesan.check_out', compact('pesanan', 'pesanan_details'));
    }

    //fungsi delete pesanan pada halaman check out
    public function delete($id)
    {
        $pesanan_detail = PesananDetail::where('id', $id)->first();

        $pesanan = Pesanan::where('id', $pesanan_detail->pesanan_id)->first();
        $pesanan->jumlah_harga = $pesanan->jumlah_harga-$pesanan_detail->jumlah_harga;
        $pesanan->update();


        $pesanan_detail->delete();
        //Notifikasi berhasil dihapus
        Alert::error('Pesanan Sukses Dihapus', 'Hapus');
        return redirect('check-out');
    }

    //Fungsi konfirmasi check out 
    public function konfirmasi()
    {
        //get data user dari tabel user
        $user = User::where('id', Auth::user()->id)->first();
        //cek validasi terlebih dahulu(alamat), jika tidak ada maka ke halaman profile
        if(empty($user->alamat))
        {
            Alert::error('Identitasi Harap dilengkapi', 'Error');
            return redirect('profile');
        }
        //cek validasi terlebih dahulu (no hp), jika tidak ada maka ke halaman profile
        if(empty($user->nohp))
        {
            Alert::error('Identitasi Harap dilengkapi', 'Error');
            return redirect('profile');
        }
        //jika profil lengkap maka pemesanan update status
        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
        $pesanan_id = $pesanan->id;
        $pesanan->status = 1;
        $pesanan->update();
        //update stok barang jika berhasil check out
        $pesanan_details = PesananDetail::where('pesanan_id', $pesanan_id)->get();
        foreach ($pesanan_details as $pesanan_detail) {
            $barang = Barang::where('id', $pesanan_detail->barang_id)->first();
            $barang->stok = $barang->stok-$pesanan_detail->jumlah;
            $barang->update();
        }


        //setelah konfirmasi check out maka ke halaman detail pemesanan untuk melakukan pembayaran
        Alert::success('Pesanan Sukses Check Out Silahkan Lanjutkan Proses Pembayaran', 'Success');
        return redirect('history/'.$pesanan_id);
    }
}
