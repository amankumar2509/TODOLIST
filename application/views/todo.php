<!doctype>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ToDo List - Codeigniter 4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js">
    </script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">ToDo List</h2>
        <div class="mb-3">
            <button id="openTaskForm" class="btn btn-primary">Add Task</button>
        </div>
        <table id="tasksTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div class="modal fade " id="newModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="save" action="" method="post">
                        <div class="container">
                            <label for="Task">Task: </label>
                            <input type="text" id="task" name="task"></input>
                        </div>
                        <br>
                        <div class="container">
                            <label for="discription">Discription: </label>
                            <input type="text" id="Discription" name="discription"></input>
                        </div>
                        <br>


                </div>

                <div class="modal-footer pop">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn btn-primary ">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- edit Modal -->


    <!-- <div class="modal fade " id="editModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editexampleModalLabel">Edit Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="save" action="" method="post">
                        <div class="container">
                            <label for="Task">Task: </label>
                            <input type="text" id="edittask" name="edittask"></input>
                        </div>
                        <br>
                        <div class="container">
                            <label for="discription">Discription: </label>
                            <input type="text" id="editdis" name="editdis"></input>
                        </div>
                        <br>
                </div>

                <div class="modal-footer pop">
                    
                    <button type="submit" class="btn btn-primary ">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div> -->

    <script>
        $(document).ready(function () {
            var dataTable = $('#tasksTable').DataTable({
                "paging": true,
                "lengthMenu": [[1, 5, 25, -1], [1, 5, 25, "All"]],

                "ajax": {
                    "url": "<?= base_url('Todo_controller/ajax_getData') ?>",
                    "type": "POST",
                    "dataType": "json"
                },
                "columns": [
                    { data: "title" },
                    { data: "description" },
                    //{ data: "status" },
                    {
                        data: null,
                        render: function (data, type, full, meta) {
                            return `
                        
                        <button class="btn btn-warning btn-status" data-id="${data.id}">Pending</button>`;
                        }
                    },
                    {
                        data: null,
                        render: function (data, type, full, meta) {
                            return `
                        
                        <button class="btn btn-danger btn-delete" data-id="${data.id}">Delete</button>`;
                        }
                    }
                ]
            });


            $('#openTaskForm').click(function () {
                $('#newModal').modal('show');
            });
            $("#save").submit(function (event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>Todo_Controller/addTask",
                    dataType: "json",
                    data: formData,
                    success: function (res) {
                        console.log(res);
                        if (res == 1) {
                            $('#newModal').hide();
                            window.location.reload();
                            alert("Task inserted Successfully");


                        } else {

                            alert("Task inserted Unsuccessful");

                        }
                    }

                });

            });
            // Add event handler for the Delete button
            $('#tasksTable').on('click', '.btn-delete', function () {
                var taskId = $(this).data('id');

                // Confirm the delete action
                if (confirm("Are you sure you want to delete this task?")) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>Todo_Controller/deleteTask", // Replace with the actual URL for deleting tasks
                        dataType: "json",
                        data: { id: taskId },
                        success: function (res) {
                            console.log(res);
                            if (res.success) {
                                dataTable.ajax.reload(); // Reload the DataTable after successful deletion
                                alert("Task deleted successfully");
                            } else {
                                alert("Task deletion failed");
                            }
                        },
                        error: function () {
                            alert("An error occurred while deleting the task");
                        }
                    });
                }
            });

            //add for status column 

            $('#tasksTable').on('click', '.btn-status', function () {
                var taskId = $(this).data('id');
                var $statusButton = $(this);
                var currentStatus = $statusButton.hasClass('btn-success') ? 1 : 0;
                
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>Todo_Controller/updateStatus",
                    dataType: "json",
                    data: { id: taskId, status: currentStatus },
                    success: function (res) {
                        if (res.success) {
                            // Toggle the button
                            if (res.new_status == 1) {
                                $statusButton.removeClass('btn-warning').addClass('btn-success');
                                $statusButton.text('Complete');
                            } else {
                                $statusButton.removeClass('btn-success').addClass('btn-warning');
                                $statusButton.text('Pending');
                            }
                        } else {
                            alert("Status update failed");
                        }
                    },

                    error: function () {
                        alert("An error occurred while updating the status");
                    }
                });

            });













        });


    </script>
</body>

</html>