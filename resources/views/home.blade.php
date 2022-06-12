<!-- halaman home setelah login/regis -->

@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 mb-5">
            <img src="{{ url('images/logo.png') }}" class="rounded mx-auto d-block" width="700" alt="">
        </div>
        <!-- perulangan untuk membaca data array di tabel barang -->
        @foreach($barangs as $barang)
        <div class="col-md-4">
            <div class="card" style="background-color: #e6ffff; border:solid 1px #00AA9E">
            <!-- get gambar barang di folder upload -->
              <img src="{{ url('uploads') }}/{{ $barang->gambar }}" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">{{ $barang->nama_barang }}</h5>
                <p class="card-text">
                    <strong>Harga :</strong> Rp. {{ number_format($barang->harga)}} <br>
                    <strong>Stok :</strong> {{ $barang->stok }} <br>
                    <hr>
                    <strong>Keterangan :</strong> <br>
                    {{ $barang->keterangan }} 
                </p>
                <a href="{{ url('pesan') }}/{{ $barang->id }}" class="btn btn-outline-success"><i class="fa fa-shopping-cart"></i> Beli</a>
              </div>
            </div> 
        </div>
        @endforeach
    </div>
</div>
@endsection
