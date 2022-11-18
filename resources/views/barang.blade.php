@extends('main/main')
@section('title','Barang')
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
            <h1 class="mt-4">Barang</h1>
            <div class="card mb-4">
                <div class="card-body">
                    <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#tambah">Tambah Barang</button>
                    <hr/>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table id="t" class="display cell-border">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Opsi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($barang as $b)
                                <tr>
                                    <td>{{$b->id}}</td>
                                    <td>{{$b->nama_barang}}</td>
                                    <td>Rp. {{number_format($b->harga, '0', ',', '.')}}</td>
                                    <td>{{$b->stok}}</td>
                                    <td>
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#edit{{$b->id}}">Edit</button>
                                    <!-- <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$b->id}}">Delete</button> -->
                                    </td>
                                </tr>
                                <!-- Modal Edit -->
                                <div class="modal fade" id="edit{{$b->id}}" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form autocomplete="off" method="post" action="{{ url('/barang/update/'.$b->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="nama_barang">Nama</label>
                                                        <input type="text" class="form-control" id ="nama_barang" name="nama_barang" value="{{ $b->nama_barang }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="harga">Harga</label>
                                                            <input type="text" class="form-control rupiah" id ="harga" name="harga" value="Rp. {{number_format($b->harga,'0',',','.')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="stok">Stok</label>
                                                            <input type="number" class="form-control" id ="stok" name="stok" value="{{ $b->stok }}">
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
                                </div>
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
                            <form autocomplete="off" method="post" action="{{ url('/barang/store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <label for="nama_barang">Nama</label>
                                    <input type="text" class="form-control" id ="nama_barang" name="nama_barang">
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="harga">Harga</label>
                                        <input type="text" class="form-control rupiah" id ="harga" name="harga">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="stok">Stok</label>
                                        <input type="number" class="form-control" id ="stok" name="stok" value="0">
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
        </script>
    @endguest
@endsection