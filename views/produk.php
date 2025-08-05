<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Produk</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addProductModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Produk
        </a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Produk</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>PRD001</td>
                            <td><img src="https://via.placeholder.com/50" class="img-thumbnail" alt="Produk 1"></td>
                            <td>Laptop ASUS ROG</td>
                            <td>Elektronik</td>
                            <td>Rp 15.999.000</td>
                            <td>25</td>
                            <td><span class="badge badge-success">Tersedia</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>PRD002</td>
                            <td><img src="https://via.placeholder.com/50" class="img-thumbnail" alt="Produk 2"></td>
                            <td>Smartphone Samsung S21</td>
                            <td>Elektronik</td>
                            <td>Rp 12.500.000</td>
                            <td>18</td>
                            <td><span class="badge badge-success">Tersedia</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>PRD003</td>
                            <td><img src="https://via.placeholder.com/50" class="img-thumbnail" alt="Produk 3"></td>
                            <td>Kemeja Flanel</td>
                            <td>Pakaian</td>
                            <td>Rp 299.000</td>
                            <td>42</td>
                            <td><span class="badge badge-success">Tersedia</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>PRD004</td>
                            <td><img src="https://via.placeholder.com/50" class="img-thumbnail" alt="Produk 4"></td>
                            <td>Sepatu Sneakers</td>
                            <td>Olahraga</td>
                            <td>Rp 899.000</td>
                            <td>0</td>
                            <td><span class="badge badge-danger">Habis</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>PRD005</td>
                            <td><img src="https://via.placeholder.com/50" class="img-thumbnail" alt="Produk 5"></td>
                            <td>Blender Philips</td>
                            <td>Dapur</td>
                            <td>Rp 1.250.000</td>
                            <td>7</td>
                            <td><span class="badge badge-warning">Terbatas</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>PRD006</td>
                            <td><img src="https://via.placeholder.com/50" class="img-thumbnail" alt="Produk 6"></td>
                            <td>Buku Pemrograman PHP</td>
                            <td>Buku</td>
                            <td>Rp 175.000</td>
                            <td>33</td>
                            <td><span class="badge badge-success">Tersedia</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>PRD007</td>
                            <td><img src="https://via.placeholder.com/50" class="img-thumbnail" alt="Produk 7"></td>
                            <td>Mouse Wireless</td>
                            <td>Aksesoris Komputer</td>
                            <td>Rp 350.000</td>
                            <td>56</td>
                            <td><span class="badge badge-success">Tersedia</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>PRD008</td>
                            <td><img src="https://via.placeholder.com/50" class="img-thumbnail" alt="Produk 8"></td>
                            <td>Headphone Sony</td>
                            <td>Audio</td>
                            <td>Rp 2.499.000</td>
                            <td>12</td>
                            <td><span class="badge badge-success">Tersedia</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>PRD009</td>
                            <td><img src="https://via.placeholder.com/50" class="img-thumbnail" alt="Produk 9"></td>
                            <td>Jam Tangan Casio</td>
                            <td>Aksesoris</td>
                            <td>Rp 1.799.000</td>
                            <td>5</td>
                            <td><span class="badge badge-warning">Terbatas</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>PRD010</td>
                            <td><img src="https://via.placeholder.com/50" class="img-thumbnail" alt="Produk 10"></td>
                            <td>Tas Ransel</td>
                            <td>Aksesoris</td>
                            <td>Rp 450.000</td>
                            <td>0</td>
                            <td><span class="badge badge-danger">Habis</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>PRD011</td>
                            <td><img src="https://via.placeholder.com/50" class="img-thumbnail" alt="Produk 11"></td>
                            <td>Kamera Canon EOS</td>
                            <td>Elektronik</td>
                            <td>Rp 8.999.000</td>
                            <td>3</td>
                            <td><span class="badge badge-warning">Terbatas</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>PRD012</td>
                            <td><img src="https://via.placeholder.com/50" class="img-thumbnail" alt="Produk 12"></td>
                            <td>Meja Kerja Minimalis</td>
                            <td>Furniture</td>
                            <td>Rp 1.750.000</td>
                            <td>9</td>
                            <td><span class="badge badge-success">Tersedia</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Tambah Produk Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="productName">Nama Produk</label>
                        <input type="text" class="form-control" id="productName" placeholder="Masukkan nama produk">
                    </div>
                    <div class="form-group">
                        <label for="productCategory">Kategori</label>
                        <select class="form-control" id="productCategory">
                            <option selected disabled>Pilih kategori</option>
                            <option>Elektronik</option>
                            <option>Pakaian</option>
                            <option>Olahraga</option>
                            <option>Dapur</option>
                            <option>Buku</option>
                            <option>Aksesoris</option>
                            <option>Furniture</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="productPrice">Harga</label>
                        <input type="number" class="form-control" id="productPrice" placeholder="Masukkan harga">
                    </div>
                    <div class="form-group">
                        <label for="productStock">Stok</label>
                        <input type="number" class="form-control" id="productStock" placeholder="Masukkan jumlah stok">
                    </div>
                    <div class="form-group">
                        <label for="productImage">Gambar Produk</label>
                        <input type="file" class="form-control-file" id="productImage">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan Produk</button>
            </div>
        </div>
    </div>
</div>

<!-- DataTables Scripts -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css">

<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTable
        var table = $('#dataTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copy',
                    text: '<i class="fas fa-copy"></i> Copy',
                    className: 'btn btn-sm btn-secondary'
                },
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    className: 'btn btn-sm btn-success',
                    title: 'Daftar Produk'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    className: 'btn btn-sm btn-danger',
                    title: 'Daftar Produk'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Print',
                    className: 'btn btn-sm btn-info',
                    title: 'Daftar Produk'
                }
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
            },
            columnDefs: [
                {
                    targets: [1, 7], // Kolom gambar dan aksi
                    orderable: false,
                    searchable: false
                },
                {
                    targets: [4], // Kolom harga
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return data.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                        return data;
                    }
                }
            ]
        });

        // Custom search input
        $('#dataTable_filter input').addClass('form-control form-control-sm');
    });
</script>