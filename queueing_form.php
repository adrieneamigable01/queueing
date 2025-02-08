<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queueing Form</title>
    <!-- Bootstrap 4 CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        /* General body styling */
        body {
            background-color: #F0F4F8; /* Soft, light background */
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0 15px;
        }

        .form-container {
            width: 100%;
            max-width: 450px;
            padding: 40px;
            border-radius: 15px; /* Rounded corners */
            background-color: #fff;
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #3B3B3B; /* Darker gray for the title */
            font-size: 2.5em;
            font-weight: 700;
            margin-bottom: 30px;
            text-transform: uppercase; /* Modern, bold title */
            letter-spacing: 1.5px;
        }

        label {
            font-size: 1.1em;
            color: #5B5B5B; /* Lighter gray for label */
            margin-bottom: 15px;
        }

        .form-group input, .form-group select {
            padding: 15px;
            font-size: 1.1em;
            border-radius: 10px; /* Rounded input fields */
            border: 2px solid #D1D5DB; /* Soft borders */
            width: 100%;
            margin-bottom: 20px;
            transition: border-color 0.3s ease;
        }

        /* Hover effect for input fields */
        .form-group input:focus {
            border-color: #6A64F1; /* Highlight color on focus */
            outline: none;
        }

        /* Card selection styling */
        .card-selection {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card {
            cursor: pointer;
            border: 2px solid #D1D5DB;
            border-radius: 12px;
            padding: 20px;
            width: 48%;
            text-align: center;
            font-size: 1.2em;
            transition: all 0.3s ease;
            background-color: #F9FAFB;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Light shadow */
        }

        /* Hover effect for cards */
        .card:hover {
            background-color: #E0E7FF; /* Soft blue highlight on hover */
        }

        /* Highlighted card */
        .card.selected {
            border-color: #6A64F1;
            background-color: #D9E4FF; /* Light blue background */
        }

        .btn-submit {
            background-color: #6A64F1; /* Millennial purple color */
            color: white;
            width: 100%;
            padding: 15px 0;
            font-size: 1.2em;
            border: none;
            border-radius: 10px;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        .btn-submit:hover {
            background-color: #4E44D6; /* Darker purple on hover */
        }

        /* Mobile responsiveness */
        @media (max-width: 767px) {
            .card-selection {
                flex-direction: column;
            }

            .card {
                width: 100%;
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="logo">
            <img src="bplc-ogo2.png" width="100" alt="Logo">
        </div>
        <h6>BARILI PRIME LENDING CORPORATION</h6>
        <form id="frm-queue" class="mt-5">
            <div class="form-group">
                <label for="name">Full Name / Nickname:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="queue_type">Queue Type:</label>
                <div class="card-selection">
                    <div class="card" id="regularCard" onclick="selectQueueType('regular')">
                        Regular
                    </div>
                    <div class="card" id="priorityCard" onclick="selectQueueType('priority')">
                        Priority
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-submit">Submit</button>
        </form>
    </div>

    <!-- Bootstrap 4 JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Full jQuery version -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.min.js"></script>

    <!-- jQuery Validate Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>

    <script>
        // JavaScript function to handle card selection for Queue Type
        function selectQueueType(type) {
            // Remove 'selected' class from both cards
            document.getElementById('regularCard').classList.remove('selected');
            document.getElementById('priorityCard').classList.remove('selected');
            
            // Add 'selected' class to the clicked card
            if (type === 'regular') {
                document.getElementById('regularCard').classList.add('selected');
            } else {
                document.getElementById('priorityCard').classList.add('selected');
            }
        }

        // jQuery Validation for form submission
        $("#frm-queue").validate({
            errorElement: 'span',
            errorClass: 'text-danger',
            highlight: function (element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-warning");
                $(element).closest('.form-group').find("input").addClass('is-invalid');
                $(element).closest('.form-group').find("select").addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).closest('.form-group').removeClass("has-warning");
                $(element).closest('.form-group').find("input").removeClass('is-invalid');
                $(element).closest('.form-group').find("select").removeClass('is-invalid');
            },
            rules: {
                name: {
                    required: true,  // Name is required
                },
                queue_type: {
                    required: true,  // Queue type must be selected
                }
            },
            messages: {
                name: {
                    required: "Please enter your full name or nickname",  // Validation message for name
                },
                queue_type: {
                    required: "Please select a queue type (Regular or Priority)",  // Validation message for queue type
                }
            },
            submitHandler: function (form) {
                // Get the data from the form
                var data = {
                    'name': $(form).find(':input[name=name]').val(),
                    'queue_type': $('#regularCard').hasClass('selected') ? 'Regular' : 'Priority',
                };

                // Handle AJAX form submission
                $.ajax({
                    url: 'https://queue.doitcebu.com/add_queue.php',  // Your backend URL to handle the form
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        // SweetAlert2 success message
                        Swal.fire({
                            title: 'Success!',
                            text: 'Your queue has been submitted successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Reset the form after success
                            $("#frm-queue")[0].reset();
                            // Remove the selected class from both cards
                            $('#regularCard').removeClass('selected');
                            $('#priorityCard').removeClass('selected');
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle the error (e.g., show an error message)
                        Swal.fire({
                            title: 'Error!',
                            text: 'There was an error submitting the form.',
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    }
                });

                // Prevent the default form submission since we are handling it via AJAX
                return false;
            }
        });

        $(document).ready(function(){
            selectQueueType("regular")
        })
    </script>
</body>
</html>
