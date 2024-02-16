<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>User List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 60%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            border-radius: 3px;
        }

        .delete-btn:hover {
            background-color: #d32f2f;
        }

        .blue-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            outline: none;
        }

        .blue-button:hover {
            background-color: #0056b3;
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 9999;
        }

        .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index:  1; /* Sit on top */
        left:  0;
        top:  0;
        width:  100%; /* Full width */
        height:  100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .modal-content {
        background-color: #fefefe;
        position: absolute; /* Position relative to the modal */
        margin: auto; /* Automatically set margins on both sides */
        padding:  20px;
        border:  1px solid #888;
        width:  80%; /* Width of the modal content */
        max-width:  600px; /* Maximum width */
        /* Center the modal vertically and horizontally */
        top:  50%;
        left:  50%;
        transform: translate(-50%, -50%);
        align-items: center; /* Center horizontally */
        justify-content: center; /* Center vertically */
        }

        .close-btn {
        color: #aaa;
        float: right;
        font-size:  28px;
        font-weight: bold;
        }

        .close-btn:hover,
        .close-btn:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
        }
    </style>
</head>
<body>
    <button class="blue-button" onclick="window.location.href='/GBProject/public/'">Add User</button>
    <div class="container">
        <h1>User List</h1>
        <table>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td onclick="getUserDetails('<?php echo $user['username']; ?>')"><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td>
                        <form action="delete-user" method="POST">
                            <input type="hidden" name="username" value="<?php echo $user['username']; ?>">
                            <button type="button" class="delete-btn" onclick="confirmDelete(this)">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
  
    <div id="userDetailsModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <p id="userDetails"></p>
        </div>
    </div>

    <script>
        function confirmDelete(button) {
            if (confirm("Are you sure you want to delete this user?")) {
                var form = button.closest('form');
                form.submit();
            }
        }

    
        function getUserDetails(username) {
            // console.log(username);
            $.ajax({
                url: 'GBProject/public/get-user-details', 
                type: 'GET',
                data: { username: username },
                success: function(response) {
                    var userDetails = JSON.parse(response);
                    $('#userDetails').html(`
                        <p>Username: ${userDetails.Username}</p>
                        <p>Email: ${userDetails.Email}</p>
                        <p>Password: ${userDetails.Password}</p>
                        <p>Birthday: ${userDetails.Birthdate}</p>
                        <p>Phone: ${userDetails.Phone_number}</p>
                        <p>URL: ${userDetails.URL}</p>
                    `); 
                    $('#userDetailsModal').show();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching user details:', error);
                }
            });
        }
        
        // close the popup
        function closeModal() {
            $('#userDetailsModal').hide();
        }s
    </script>
</body>
</html>
