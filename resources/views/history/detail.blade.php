 <!-- Halaman Detail pemesanan -->
 @extends('layouts.app')
 @section('content')
 <div class="container">
     <div class="row">
         <div class="col-md-12">
             <a href="{{ url('history') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
         </div>
         <div class="col-md-12 mt-2">
             <nav aria-label="breadcrumb">
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                     <li class="breadcrumb-item"><a href="{{ url('history') }}">Riwayat Pemesanan</a></li>
                     <li class="breadcrumb-item active" aria-current="page">Konfirmasi Pemesanan</li>
                 </ol>
             </nav>
         </div>
         <div class="col-md-12">
             <div class="card mt-2">
                 <div class="card-body" style="border:solid 1px #00AA9E">
                     <h3><i class="fa fa-shopping-cart"></i> konfirmasi Pemesanan</h3>
                     <!-- Jika pesanan kosong maka tidak menampilkan data-->
                     @if(!empty($pesanan))
                     <p align="left">Tanggal Pesan : {{ $pesanan->tanggal }}</p>
                     <p align="left" style="color: red;">Kode Pemesanan : #{{ number_format($pesanan->kode) }}</p>
                     <p align="left">Nama Penerima : {{ $user->name }}</p>
                     <p align="left">No. Hp : {{ $user->nohp }}</p>
                     <p align="left">Alamat Pengiriman: {{ $user->alamat }}</p>
                     <table class="table table-striped">
                         <thead>
                             <tr>
                                 <th>No</th>
                                 <th>Gambar</th>
                                 <th>Nama Barang</th>
                                 <th>Jumlah</th>
                                 <th>Harga</th>
                                 <th>Total Harga</th>

                             </tr>
                         </thead>
                         <tbody>
                             <?php $no = 1; ?>
                             <!-- Jika pesanan ada maka foreach dari pesanan_Detail-->
                             @foreach($pesanan_details as $pesanan_detail)
                             <tr>
                                 <td>{{ $no++ }}</td>
                                 <td>
                                     <img src="{{ url('uploads') }}/{{ $pesanan_detail->barang->gambar }}" width="100"
                                         alt="...">
                                 </td>
                                 <td>{{ $pesanan_detail->barang->nama_barang }}</td>
                                 <td>{{ $pesanan_detail->jumlah }} unit</td>
                                 <td align="right">Rp. {{ number_format($pesanan_detail->barang->harga) }}</td>
                                 <td align="right">Rp. {{ number_format($pesanan_detail->jumlah_harga) }}</td>

                             </tr>
                             @endforeach

                             <tr>
                                 <td colspan="5" align="right"><strong>Total Harga :</strong></td>
                                 <td align="right"><strong>Rp. {{ number_format($pesanan->jumlah_harga) }}</strong></td>

                             </tr>
                             <tr>
                                 <td colspan="5" align="right"><strong>Total yang harus ditransfer :</strong></td>
                                 <td align="right"><strong>Rp.
                                         {{ number_format($pesanan->kode+$pesanan->jumlah_harga) }}</strong></td>

                             </tr>
                         </tbody>
                     </table>
                     @endif

                 </div>
             </div>
             <p>
                 <button class="btn btn-success btn-lg btn-block" type="button" data-toggle="collapse"
                     data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"
                     style="position:center;">
                     Lakukan Pembayaran
                 </button>
             </p>
             <div class="collapse float" id="collapseExample">
                 <div class="card">
                     <div class="card-body" style="background-color: #cceeff; border:solid 1px #00AA9E">
                         <h3>Prosedur pembayaran</h3>
                         <h5>Pesanan anda berhasil check out, selanjutnya silahkan pilih metode pembayaran : <br />
                             <br />
                             <i class="fa fa-university" aria-hidden="true"></i> Bank BNI : 345678-921512-321<br />
                             <br />
                             <i class="fa fa-mobile" aria-hidden="true"></i></i> Gopay/OVO/ShoppePay : 081259583762
                             <br /> <br />
                             Nominal : <strong>Rp.
                                 {{ number_format($pesanan->kode+$pesanan->jumlah_harga) }}</strong></h5>
                     </div>
                 </div>
             </div>
         </div>

     </div>
 </div>
 @endsection
