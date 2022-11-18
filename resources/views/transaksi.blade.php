@extends('main/main')
@section('title','Transaksi')
@section('content')
    @guest
        <script>window.location = "/";</script>
    @else
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
        <style>
            /* col search */
            tfoot input {
                width: 100%;
                padding: 3px;
                box-sizing: border-box;
            }
            tfoot {
                display: table-header-group;
            }
        </style>
        <!---->
        <div class="container-fluid px-4">
            <h1 class="mt-4">Transaksi</h1>
            <div class="card mb-4">
                <div class="card-body">
                    <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#tambah">Tambah Transaksi</button>
                    <hr/>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table id="t" class="display cell-border">
                        <thead>
                            <tr>
                                <th>Nomor Transaksi</th>
                                <th>Tanggal</th>
                                <th>Barang</th>
                                <th>Type</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total Stok..</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nomor Transaksi</th>
                                <th>Tanggal</th>
                                <th>Barang</th>
                                <th>Type</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total Stok..</th>
                                <th>Opsi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($transaksi as $t)
                                <tr>
                                    <td>TR{{sprintf("%08d", $t->id)}}</td>
                                    <td>{{$t->tanggal}}</td>
                                    <td>{{$t->barang->nama_barang}}</td>
                                    <td>{{$t->type}}</td>
                                    <td>Rp. {{number_format($t->barang->harga,'0',',','.')}}</td>
                                    <!-- <td>Rp. {{number_format($t->harga,'0',',','.')}}</td> -->
                                    <td>{{$t->jumlah}}</td>
                                    <td>{{$t->total_stok}}</td>
                                    <td>
                                    <a href="{{ url('/transaksi'.$t->id) }}"><button class="btn btn-success">Edit</button></a>
                                    <form autocomplete="off" method="post" action="{{ url('/transaksi/delete/'.$t->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="form-control" id ="_id_barang" name="id_barang" value="{{$t->id_barang}}">
                                        <input type="hidden" class="form-control" id ="_stok" name="stok" value="{{$t->barang->stok}}">
                                        <input type="hidden" class="form-control" id ="_jumlah" name="jumlah" value="{{ $t->jumlah }}">
                                        <input type="hidden" class="form-control" id ="_type" name="type" value="{{ $t->type }}">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus transaksi?')">Delete</button>
                                    </form>
                                    </td>
                                </tr>
                                <!-- Modal Edit
                                <div class="modal fade" id="edit{{$t->id}}" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form autocomplete="off" method="post" action="{{ url('/transaksi/update/'.$t->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="nama_barang">Nama</label>
                                                        <input type="text" class="form-control" id ="nama_barang" name="nama_barang" value="{{ $t->id_barang }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="harga">Harga</label>
                                                            <input type="text" class="form-control rupiah" id ="harga" name="harga" value="Rp. {{number_format($t->harga,'0',',','.')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="stok">Stok</label>
                                                            <input type="number" class="form-control" id ="stok" name="stok" value="{{ $t->total_stok }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                    </br>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </form>
                                                        <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                    </div>
                                        </div>
                                    </div>
                                </div> -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--Modal tambah -->
        <div class="modal fade" id="tambah" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                </div>
                        <div class="modal-body">
                            <form autocomplete="off" method="post" action="{{ url('/transaksi/store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" class="form-control" id ="tanggal" name="tanggal" value="<?php echo date('Y-m-d');?>">
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="id_barang">ID Barang</label>
                                        <input type="text" class="form-control" name="id_barang" id ="id_barang" list="barang">
                                        <datalist id="barang">
                                            @foreach($barang as $b)
                                                <option value="{{$b->id}}" hrg="{{$b->harga}}" stk="{{$b->stok}}">{{$b->nama_barang}}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="stok">Stok saat ini</label>
                                        <input type="number" class="form-control" id ="stok_b" name="stok_b" disabled>
                                        <input type="number" class="form-control" id ="stok_barang" name="stok_barang" hidden>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="type">Type</label><br>
                                    <input type="radio" id="penambahan" name="type" value="penambahan">
                                    <label for="penambahan">penambahan</label><br>
                                    <input type="radio" id="pengurangan" name="type" value="pengurangan">
                                    <label for="pengurangan">pengurangan</label><br>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="harga">Harga</label>
                                        <input type="text" class="form-control rupiah" id ="harga_" name="harga_" disabled>
                                        <input type="text" class="form-control rupiah" id ="harga" name="harga" hidden>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="jumlah">Jumlah</label>
                                        <input type="number" class="form-control" id ="jumlah" name="jumlah">
                                    </div>
                                </div>
                            </div>
                        </div>
                            </br>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
            </div>
        </div>
        <!---->
        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#t tfoot th').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            });
        
            // DataTable
            var table = $('#t').DataTable({
                initComplete: function () {
                    // Apply the search
                    this.api()
                        .columns()
                        .every(function () {
                            var that = this;
        
                            $('input', this.footer()).on('keyup change clear', function () {
                                if (that.search() !== this.value) {
                                    that.search(this.value).draw();
                                }
                            });
                        });
                },
            });
        });
        const select = Object.values(document.getElementsByClassName('rupiah'));
        select.forEach(harga => {
            harga.addEventListener("keyup", function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatharga() untuk mengubah angka yang di ketik menjadi format angka
            harga.value = formatharga(this.value, "Rp. ");
            });
        });
        /* Fungsi formatharga */
        function formatharga(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            harga = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? "." : "";
            harga += separator + ribuan.join(".");
        }

        harga = split[1] != undefined ? harga + "," + split[1] : harga;
        return prefix == undefined ? harga : harga ? "Rp. " + harga : "";
        }

        $('#id_barang').on('change', function(){
        var value = $(this).val();
        var harga = $('#barang [value="' + value + '"]').attr('hrg');
        var stokb = $('#barang [value="' + value + '"]').attr('stk');
        console.log(harga);
        $('#stok_barang').val(stokb);
        $('#stok_b').val(stokb);
        $('#harga').val(formatharga(harga, "Rp. "));;
        $('#harga_').val(formatharga(harga, "Rp. "));;
    })
        </script>
    @endguest
@endsection