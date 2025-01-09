$(document).ready(function () {
    // Base URL API
    var apiUrl = "http://localhost:3000/api/";

    // Function to load items
    function loadItems() {
        $.ajax({
            url: apiUrl + "read.php", // Perbaiki URL ke read.php
            type: "GET",
            dataType: "json",
            success: function (data) {
                var rows = "";
                data.forEach(function (item) {
                    rows += `<tr>
                                <td>${item.title}</td>
                                <td>${item.description}</td>
                                <td>
                                    <button class="btn btn-primary edit-item" data-id="${item.id}" data-title="${item.title}" data-description="${item.description}">Edit</button>
                                    <button class="btn btn-danger delete-item" data-id="${item.id}">Delete</button>
                                </td>
                            </tr>`;
                });
                $("tbody").html(rows); // Perbaiki selector ke tbody
            },
            error: function (err) {
                toastr.error("Failed to load items.");
            }
        });
    }

    // Load items on page load

        loadItems();

    // Create item
    $("#create-item form").on("submit", function (e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: apiUrl + "create.php",
            type: "POST",
            data: formData,
            success: function (response) {
                toastr.success("Item created successfully.");
                $("#create-item").modal("hide");
                $("#create-item form")[0].reset();
                loadItems();
            },
            error: function () {
                toastr.error("Failed to create item.");
            }
        });
    });

    // Show edit modal
    $(document).on("click", ".edit-item", function () {
        var id = $(this).data("id");
        var title = $(this).data("title");
        var description = $(this).data("description");

        $("#edit-item .edit-id").val(id);
        $("#edit-item [name='title']").val(title);
        $("#edit-item [name='description']").val(description);

        $("#edit-item").modal("show");
    });

    // Update item
    $("#edit-item form").on("submit", function (e) {
        e.preventDefault();
        var formData = $(this).serialize(); // ID sudah termasuk dalam formData

        $.ajax({
            url: apiUrl + "update.php",  
            type: "POST",
            data: formData,
            success: function (response) {
                if (response.status === 'success') {
                    toastr.success("Item updated successfully.");
                    $("#edit-item").modal("hide");
                    loadItems();
                } else {
                    toastr.error(response.message || "Failed to update item."); 
                }
            },
            error: function () {
                toastr.error("Failed to update item.");
            }
        });
    });


    // Delete item
    $(document).on("click", ".delete-item", function () {
        var id = $(this).data("id");

        if (confirm("Are you sure you want to delete this item?")) {
            $.ajax({
                url: apiUrl + "delete.php?id=" + id,
                type: "DELETE",
                success: function (response) {
                    toastr.success("Item deleted successfully.");
                    loadItems();
                },
                error: function () {
                    toastr.error("Failed to delete item.");
                }
            });
        }
    });
});