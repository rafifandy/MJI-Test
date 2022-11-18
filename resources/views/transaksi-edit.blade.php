@extends('main/main')
@section('title','Transaksi')
@section('content')
    @guest
        <script>window.location = "/";</script>
    @else
        <!---->
        @foreach($transaksi as $t)
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit Transaksi</h1>
            <div class="card mb-4">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <form autocomplete="off" method="post" action="{{ url('/transaksi/update/'.$t->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="id">ID</label>
                                        <input type="text" class="form-control" id ="id" name="id" value="{{$t->id}}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label for="nomor_transaksi">Nomor Transaksi</label>
                                        <input type="text" class="form-control" id ="nomor_transaksi" name="nomor_transaksi" value="TR{{sprintf('%08d', $t->id)}}" disabled>
                                    </div>
                                </div>
                                <br/>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="tanggal">Tanggal</label>
                                        <input type="date" class="form-control" id ="tanggal" name="tanggal" value="{{$t->tanggal}}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="id_barang">ID Barang</label>
                                        <input type="text" class="form-control" name="old_id_barang" id ="old_id_barang" value="{{$t->id_barang}}" hidden>
                                        <input type="text" class="form-control" name="id_barang" id ="id_barang" list="barang" value="{{$t->id_barang}}">
                                        <datalist id="barang">
                                            @foreach($barang as $b)
                                                <option value="{{$b->id}}" hrg="{{$b->harga}}" stk="{{$b->stok}}">{{$b->nama_barang}}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="stok">Stok saat ini</label>
                                        <input type="number" class="form-control" id ="stok_b" name="stok_b" value="{{$t->barang->stok}}" disabled>
                                        <input type="number" class="form-control" id ="old_stok_barang" name="old_stok_barang" value="{{$t->barang->stok}}" hidden>
                                        <input type="number" class="form-control" id ="stok_barang" name="stok_barang" value="{{$t->barang->stok}}" hidden>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="type">Type</label><br>
                                    <input type="text" class="form-control" name="old_type" id ="old_type" value="{{$t->type}}" hidden>
                                    @if($t->type == "penambahan")
                                        <input type="radio" id="penambahan" name="type" value="penambahan" checked>
                                        <label for="penambahan">penambahan</label><br>
                                        <input type="radio" id="pengurangan" name="type" value="pengurangan">
                                        <label for="pengurangan">pengurangan</label><br>
                                    @else
                                        <input type="radio" id="penambahan" name="type" value="penambahan">
                                        <label for="penambahan">penambahan</label><br>
                                        <input type="radio" id="pengurangan" name="type" value="pengurangan"checked>
                                        <label for="pengurangan">pengurangan</label><br>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="harga">Harga</label>
                                        <input type="text" class="form-control rupiah" id ="harga_" name="harga_" value="Rp. {{number_format($t->barang->harga,'0',',','.')}}" disabled>
                                        <input type="text" class="form-control rupiah" id ="harga" name="harga" value="Rp. {{number_format($t->barang->harga,'0',',','.')}}" hidden>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="jumlah">Jumlah</label>
                                        <input type="number" class="form-control" name="old_jumlah" id ="old_jumlah" value="{{$t->jumlah}}" hidden>
                                        <input type="number" class="form-control" id ="jumlah" name="jumlah" value="{{$t->jumlah}}">
                                    </div>
                                </div>
                            </div>
                            </br>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                </div>
            </div>
        </div>
        @endforeach
        
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