$(document).ready(function () {
    // Load passengers data
    function loadPassengers() {
        $.ajax({
            url: "api/getPassengers.php",
            type: "GET",
            success: function (response) {
                let tbody = "";
                response.data.forEach(passenger => {
                    tbody += `
                        <tr>
                            <td>${passenger.name}</td>
                            <td>${passenger.flight_id}</td>
                            <td>${passenger.airline}</td>
                            <td>
                                <button class="btn btn-primary btn-edit" 
                                    data-id="${passenger.id}" 
                                    data-name="${passenger.name}" 
                                    data-flight_id="${passenger.flight_id}" 
                                    data-airline="${passenger.airline}">
                                    Edit
                                </button>
                                <button class="btn btn-danger btn-delete" data-id="${passenger.id}">Delete</button>
                            </td>
                        </tr>
                    `;
                });
                $("tbody").html(tbody);
            }
        });
    }
    

    loadPassengers();

    // Add passenger
    $("#add-passenger-form").on("submit", function (e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: "api/addPassenger.php",
            type: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                    toastr.success("Passenger added successfully");
                    $("#add-passenger-modal").modal("hide");
                    loadPassengers();
                } else {
                    toastr.error(response.message || "Failed to add passenger");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error: ", status, error);
                toastr.error("An error occurred while adding the passenger.");
            }
        });
    });

    // Edit passenger
    $(document).on("click", ".btn-edit", function () {
        const id = $(this).data("id");
        const name = $(this).data("name");
        const flight_id = $(this).data("flight_id");
        const airline = $(this).data("airline");

        $("#edit-id").val(id);
        $("#edit-name").val(name);
        $("#edit-flight-id").val(flight_id);
        $("#edit-airline").val(airline);

        $("#edit-passenger-modal").modal("show");
    });

    $("#edit-passenger-form").on("submit", function (e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: "api/updatePassenger.php",
            type: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                    toastr.success("Passenger updated successfully");
                    $("#edit-passenger-modal").modal("hide");
                    loadPassengers();
                } else {
                    toastr.error(response.message || "Failed to update passenger");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error: ", status, error);
                toastr.error("An error occurred while updating the passenger.");
            }
        });
    });

    // Delete passenger
    $(document).on("click", ".btn-delete", function () {
        const id = $(this).data("id");

        if (confirm("Are you sure you want to delete this passenger?")) {
            $.ajax({
                url: "api/deletePassenger.php",
                type: "POST",
                data: { id: id },
                success: function (response) {
                    if (response.success) {
                        toastr.success("Passenger deleted successfully");
                        loadPassengers();
                    } else {
                        toastr.error(response.message || "Failed to delete passenger");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error: ", status, error);
                    toastr.error("An error occurred while deleting the passenger.");
                }
            });
        }
    });
});
