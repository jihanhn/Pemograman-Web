<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Jquery Ajax CRUD Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>PHP Jquery Ajax CRUD Example</h2>
        <button class="btn btn-success" data-toggle="modal" data-target="#create-item">Create Item</button>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data akan ditampilkan di sini -->
            </tbody>
        </table>
    </div>

    <!-- Modal untuk menambahkan item -->
    <div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createForm">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Edit item -->
    <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="editItemLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemLabel">Edit Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="edit-id" name="id">
                        <div class="form-group">
                            <label for="edit-title">Title</label>
                            <input type="text" class="form-control" id="edit-title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-description">Description</label>
                            <input type="text" class="form-control" id="edit-description" name="description" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(document).ready(function () {
    // Memuat data
    function loadData() {
        $.ajax({
            url: "api/getData.php",  // Pastikan URL ini mengarah ke getData.php
            type: "GET",
            success: function(response) {
                if(response.data) {
                    let tbody = "";
                    response.data.forEach(item => {
                        tbody += `
                            <tr>
                                <td>${item.title}</td>
                                <td>${item.description}</td>
                                <td>
                                    <button class="btn btn-primary btn-edit" data-id="${item.id}" data-title="${item.title}" data-description="${item.description}">Edit</button>
                                    <button class="btn btn-danger btn-delete" data-id="${item.id}">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                    $("tbody").html(tbody);  // Menampilkan data pada tabel
                } else {
                    toastr.error("Tidak ada data yang ditemukan");
                }
            },
            error: function() {
                toastr.error("Terjadi kesalahan saat memuat data");
            }
        });
    }

    // Panggil loadData saat halaman pertama kali dimuat
    loadData();
    
    // Tangani pengiriman formulir create item
    $("#createForm").on("submit", function (e) {
        e.preventDefault();

        var formData = $(this).serialize();  // Ambil data formulir

        $.ajax({
            url: "api/create.php",  // Pastikan URL ini mengarah ke create.php
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    $('#create-item').modal('hide');  // Menutup modal setelah submit
                    toastr.success("Item berhasil dibuat");
                    loadData();  // Memperbarui tampilan utama
                } else {
                    toastr.error("Gagal menambah data");
                }
            },
            error: function () {
                toastr.error("Terjadi kesalahan saat mengirim data");
            }
        });
    });

    // Tangani klik tombol Edit
    $(document).on("click", ".btn-edit", function () {
        var id = $(this).data("id");
        var title = $(this).data("title");
        var description = $(this).data("description");

        // Isi data pada modal Edit
        $("#edit-id").val(id);
        $("#edit-title").val(title);
        $("#edit-description").val(description);

        // Tampilkan modal Edit
        $('#edit-item').modal('show');
    });

    // Tangani pengiriman formulir Edit item
    $("#editForm").on("submit", function (e) {
        e.preventDefault();

        var formData = $(this).serialize();  // Ambil data formulir

        $.ajax({
            url: "api/edit.php",  // Pastikan URL ini mengarah ke edit.php
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    $('#edit-item').modal('hide');  // Menutup modal setelah submit
                    toastr.success("Item berhasil diperbarui");
                    loadData();  // Memperbarui tampilan utama
                } else {
                    toastr.error("Gagal memperbarui data");
                }
            },
            error: function () {
                toastr.error("Terjadi kesalahan saat mengirim data");
            }
        });
    });

    // Tangani klik tombol Delete
    $(document).on("click", ".btn-delete", function () {
        var id = $(this).data("id");

        if (confirm("Apakah Anda yakin ingin menghapus item ini?")) {
            $.ajax({
                url: "api/delete.php",  // Pastikan URL ini mengarah ke delete.php
                type: "POST",
                data: { id: id },
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        toastr.success("Item berhasil dihapus");
                        loadData();  // Memperbarui tampilan utama
                    } else {
                        toastr.error("Gagal menghapus data");
                    }
                },
                error: function () {
                    toastr.error("Terjadi kesalahan saat mengirim data");
                }
            });
        }
    });
});
</script>
</html>
