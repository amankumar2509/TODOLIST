<!doctype>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ToDo List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js">
    </script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.3/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.3/dist/sweetalert2.min.css">



</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">ToDo List</h2>
        <div class="mb-3">
            <button id="openTaskForm" class="btn btn-primary">Add Task</button>
        </div>
        <table id="tasksTable" class="table table-striped table-bordered " style="width:100%">
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
                    <h5 class="modal-title" id="exampleModalLabel" >Add New Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="save" action="" method="post">
                        <div class="container">
                            <label for="Task">Task: </label>
                            <br>
                            <input type="text" id="task" name="task"></input>
                            <div id="taskError" class="error-message" style="color:#FF0000"></div>
                        </div>
                        <br>
                        <div class="container">
                            <label for="discription">Discription: </label>
                            <br>
                            <input type="text" id="Discription" name="discription"></input>
                            <div id="descriptionError" class="error-message" style="color:#FF0000"></div>
                        </div>
                        <br>


                </div>

                <div class="modal-footer pop justify-content-center ">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn btn-primary ">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- edit Modal -->
    <div class="modal" id="editModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="editModalLabel">Edit Question</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add your form elements for editing here -->
                    <form id="editForm" action="" method="post">
                        <br>
                        <div>
                            <label for="editTask" style="font-weight: bold;">Edit the Task:</label>
                            <input type="text" id="editTask" name="title" val="" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 10px;" />
                            <input type="text" id="taskid" name="id" val="" hidden />
                            <span id="editTask-error" style="color:red"></span>
                        </div>
                        <br>
                        <div>
                            <label for="Description" style="font-weight: bold;">Edit the Discription:</label>
                            <input type="text" id="editDescription" name="description" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 10px;" />
                            <span id="editDescription-error" style="color:red"></span>
                        </div>
                        <br>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveEdit">Save Changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            var dataTable = $('#tasksTable').DataTable({
                "paging": true,
                "lengthMenu": [2,5, 10, 25, "All"],
                columnDefs: [
                    { orderable: false, targets: [-1, -2] }
                ],
                //"serverSide":true,

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
                            if(data.status == 0){
                                return `
                        
                        <button class="btn btn-warning btn-status" data-id="${data.id}">Pending</button>`;
                            }
                            else{
                                return `
                        
                        <button class="btn btn-success btn-status" data-id="${data.id}">Completed</button>`;
                            }
                          
                        }
                    },
                    {
                        data: null,
                        render: function (data, type, full, meta) {
                            return `<button class="btn btn-danger btn-delete" data-id="${data.id}">Delete</button> &nbsp <button class="btn btn-success btn-edit" data-id="${data.id}">Edit</button>`;
                        
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
                const taskValue = $("#task").val().trim();
                const descriptionValue = $("#Discription").val().trim();

                $(".error-message").hide();

                // Validate the Task field (not empty)
                if (taskValue === "") {
                    $("#taskError").text("Task field is required.").show();
                    //alert("Task field is required.");
                    return;
                }

                // Validate the Description field (not empty)
                if (descriptionValue === "") {
                     $("#descriptionError").text("Description field is required.").show();
                    //alert("Description field is required.");
                    return;
                }

                
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>Todo_Controller/addTask",
                    dataType: "json",
                    data: formData,
                    success: function (res) {
                        console.log(res);
                        if (res == 1) {
                            $('#newModal').hide();
                            // window.location.reload();
                            //alert("Task inserted Successfully");
                            setTimeout(function () {
                                window.location.reload(); // Reload the DataTable after successful deletion
                            }, 1000);
                            toastr.success('Question added successfully', 'Success');


                        } else {

                            toastr.error('Failed to add Question', 'Failed');

                        }
                    }

                });

            });
            // Add event handler for the Delete button
            // $('#tasksTable').on('click', '.btn-delete', function () {
            //     var taskId = $(this).data('id');

            //     // Confirm the delete action
            //     if (confirm("Are you sure you want to delete this task?")) {
            //         $.ajax({
            //             type: "POST",
            //             url: "<?php echo base_url(); ?>Todo_Controller/deleteTask", // Replace with the actual URL for deleting tasks
            //             dataType: "json",
            //             data: { id: taskId },
            //             success: function (res) {
            //                 console.log(res);
            //                 if (res.success) {
            //                     dataTable.ajax.reload(); // Reload the DataTable after successful deletion
            //                     // alert("Task deleted successfully");
            //                     toastr.warning('Deleted:successful', 'Delete');
            //                 } else {
            //                    // alert("Task deletion failed");
            //                      toastr.error('Failed to add Question', 'Failed');
            //                 }
            //             },
            //             error: function () {
            //                 alert("An error occurred while deleting the task");
            //             }
            //         });
            //     }
            // });

            $('#tasksTable').on('click', '.btn-delete', function () {
                var taskId = $(this).data('id');

                // Display the confirmation dialog using Swal.fire
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>Todo_Controller/deleteTask",
                            dataType: "json",
                            data: { id: taskId },
                            success: function (res) {
                              //  console.log(res);
                                if (res.success) {
                                    dataTable.ajax.reload(); // Reload the DataTable after successful deletion
                                    toastr.warning('Deleted: successful', 'Delete');
                                } else {
                                    toastr.error('Failed to delete task', 'Failed');
                                }
                            },
                            error: function () {
                                toastr.error('An error occurred while deleting the task', 'Failed');
                            }
                        });
                    }
                });
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



           


            $(document).on('click', '.btn-edit', function() {
                var id = $(this).attr('data-id');
                $('#taskid').val(id);
                $("#editModal").modal('show');
                $.ajax({
                    url: "<?php echo base_url() ?>todo_controller/showInfo",
                    data: {
                        id: id
                    },
                    method: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        $('#editTask').val(data.title);
                        $('#editDescription').val(data.description);
                    }
                });
            });

            $('.close').click(function() {
                $('#editModal').modal('hide');
            });

            $("#editForm").submit(function(event) {
                event.preventDefault();

                var formData = $(this).serialize();
                $.ajax({
                    url: "<?php echo base_url(); ?>todo_controller/editTask",
                    data: formData,
                    method: 'POST',
                    success: function(data) {
                        if (data == 1) {
                            $('#editModal').modal('hide'); // Close the modal on successful submission
                            setTimeout(function() {
                                window.location.reload(); // Reload the DataTable after successful submission
                            }, 1000);
                            toastr.info('Info: Task Updation Successful', 'Task Updated');
                        } else {
                            toastr.warning('Info: New and Previous value can not be same', 'Task Not Updated');
                        }
                    },
                    error: function() {
                        toastr.error('An error occurred while updating the task', 'Failed');
                    }
                });
            });












        });


    </script>
</body>

</html>