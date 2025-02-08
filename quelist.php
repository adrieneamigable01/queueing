<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queueing System</title>
    <!-- Bootstrap 4 CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Global Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            padding-top: 30px;
        }

        .container {
            max-width: 1300px;
            margin: 0 auto;
        }

        h4 {
            font-weight: 500;
            color: #2c3e50;
        }

        /* Card styling for current taken queues */
        .current-queue-card {
            padding: 20px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .queue-table {
            margin-top: 30px;
        }

        /* Table styling */
        .table th, .table td {
            text-align: center;
        }

        .table th {
            background-color: #f1f1f1;
        }

        /* Flexbox Layout */
        .row {
            display: flex;
            justify-content: space-between;
        }

        /* Left column styling */
        .left-column, .right-column {
            width: 48%;
        }

        .right-column {
            padding-left: 30px;
        }

    </style>
</head>
<body>

<!-- Modal to Select Teller -->
<!-- Modal to Select Teller -->
<div class="modal" tabindex="-1" role="dialog" id="tellerModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Teller</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card p-4">
                    <h4 class="text-center mb-4">Please choose which Teller you'd like to work with:</h4>
                    <div class="text-center">
                        <button class="btn btn-primary btn-lg m-3" id="select-teller1" style="width: 200px;">Teller 1</button>
                        <button class="btn btn-success btn-lg m-3" id="select-teller2" style="width: 200px;">Teller 2</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container mt-5">
    <!-- Current Queue Cards Section -->
    <div class="row">
        <div class="col-md-6">
            <div class="current-queue-card">
                <h5>Current Queue - Teller 1</h5>
                <div id="teller1-current"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="current-queue-card">
                <h5>Current Queue - Teller 2</h5>
                <div id="teller2-current"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column: Pending Queue -->
        <div class="col-md-6 left-column">
            <h4>Pending Queue</h4>
            <table class="table table-bordered table-striped queue-table">
                <thead>
                    <tr>
                        <th>Queue Number</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Queue Type</th>
                        <th>Action</th> <!-- Added a column for the "Take" button -->
                    </tr>
                </thead>
                <tbody id="pending-queue">
                    <!-- Pending queue items will be populated here -->
                </tbody>
            </table>
        </div>

        <!-- Right Column: Completed Queue -->
        <div class="col-md-6 right-column">
            <h4>Completed Queue</h4>
            <table class="table table-bordered table-striped queue-table">
                <thead>
                    <tr>
                        <th>Queue Number</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Queue Type</th>
                    </tr>
                </thead>
                <tbody id="completed-queue">
                    <!-- Completed queue items will be populated here -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap 4 JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- AJAX Script to pull the queue data -->
<script>
    let currentQueueTeller1 = null;
    let currentQueueTeller2 = null;
    let selectedTeller = null;

    // Show the modal on page load
    $(document).ready(function() {
        $('#tellerModal').modal('show');  // Open the modal

        // Select Teller 1
        $('#select-teller1').on('click', function() {
            selectedTeller = 1; // Set selected Teller to 1
            $('#tellerModal').modal('hide');  // Close the modal
            fetchQueueData(); // Fetch data after selection
        });

        // Select Teller 2
        $('#select-teller2').on('click', function() {
            selectedTeller = 2; // Set selected Teller to 2
            $('#tellerModal').modal('hide');  // Close the modal
            fetchQueueData(); // Fetch data after selection
        });
    });

    function fetchQueueData() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: 'https://queue.doitcebu.com/get_queue.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    let data = response.data;

                    // Clear previous data
                    $('#pending-queue').empty();
                    $('#completed-queue').empty();
                    $('#teller1-current').empty();
                    $('#teller2-current').empty();

                    let teller1Data = "";
                    let teller2Data = "";

                    // Loop through the queue data
                    $.each(data, function(k, item) {
                        // Pending items
                        if (item.status === null) {
                            const pendingRow = `<tr>
                                                    <td>${item.queue_number}</td>
                                                    <td>${item.name}</td>
                                                    <td>${item.status || 'Pending'}</td>
                                                    <td>${item.queue_type}</td>
                                                    <td><button class="btn btn-success btn-sm take-btn" data-queue-id="${item.queue_number}" data-teller="${item.teller_number || 1}">Take</button></td>
                                                </tr>`;

                            // Add to Pending Queue table
                            $('#pending-queue').append(pendingRow);
                        }
                        // Completed items
                        else if (item.status === 'Done') {
                            const completedRow = `<tr>
                                                    <td>${item.queue_number}</td>
                                                    <td>${item.name}</td>
                                                    <td>${item.status}</td>
                                                    <td>${item.queue_type}</td>
                                                </tr>`;

                            // Add to Completed Queue table
                            $('#completed-queue').append(completedRow);
                        }else if (item.status === "Pending") {
                            if (item.teller_number == 1) {
                                currentQueueTeller1 = item;
                                teller1Data = `Now serving: ${item.name}`;
                                $('#take-teller1').prop('disabled', false);
                            } else if (item.teller_number == 2) {
                                currentQueueTeller2 = item;
                                teller2Data = `Now serving: ${item.name}`;
                                $('#take-teller2').prop('disabled', false);
                            }
                            // Display current queue for Teller 1 and Teller 2
                            $('#teller1-current').html(teller1Data || 'No one is currently being served.');
                            $('#teller2-current').html(teller2Data || 'No one is currently being served.');
                        }
                    });

                    resolve(true);
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                    resolve(false);
                }
            });
        }).then(() => {
            setTimeout(() => {
                fetchQueueData();
            }, 1000); // Fetch data every 1 second
        });
    }

    // Function to handle the "Take" button for a specific queue
    $(document).on('click', '.take-btn', function() {
        const queueId = $(this).data('queue-id');
        const tellerNumber = selectedTeller;

        // Prepare data to send to the server
        const data = {
            queue_id: queueId,
            teller_number: tellerNumber,
            status: 'Pending'
        };

        // Send the request to add_serving.php using AJAX
        $.ajax({
            url: 'https://queue.doitcebu.com/add_serving.php',
            method: 'POST',
            data: data,
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    // Update the UI after successfully taking the queue
                    fetchQueueData(); // Refresh the queue data
                } else {
                    alert('Error: ' + res.message);
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred while taking the queue.');
            }
        });
    });
</script>

</body>
</html>
