$(document).ready(function () {
    // Fungsi untuk memuat data
    function loadData() {
        $.ajax({
            url: "api/getData.php",  // Ganti dengan API yang sesuai
            type: "GET",
            success: function(response) {
                let tbody = "";
                response.data.forEach(item => {
                    tbody += `
                        <tr>
                            <td>${item.title}</td>
                            <td>${item.description}</td>
                            <td>
                                <button class="btn btn-primary btn-edit" data-id="${item.id}">Edit</button>
                                <button class="btn btn-danger btn-delete" data-id="${item.id}">Delete</button>
                            </td>
                        </tr>
                    `;
                });
                $("tbody").html(tbody);
            }
        });
    }

    // Panggil fungsi loadData saat halaman pertama kali dimuat
    loadData();
});
