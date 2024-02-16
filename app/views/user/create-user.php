<!DOCTYPE html>
<html>

<head>
    <title>GBG Assessment - User Form</title>
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

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        input[type="tel"],
        input[type="url"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }

        .blue-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            /* Blue color */
            color: #fff;
            /* White text */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            outline: none;
            /* Remove default button outline */
        }

        .blue-button:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
        }
    </style>
</head>

<body>
    <button class=blue-button onclick="window.location.href='/GBProject/public/all-users'">View All Users</button>
    <div class="container">
        <h1>GBG Assessment - Add New User</h1>
        <?php if (!empty($validationErrors)): ?>
            <div class="error">
                <?php foreach ($validationErrors as $error): ?>
                    <p>
                        <?php echo $error; ?>
                    </p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="create-user" method="post">
            <!-- handle the validation entirely on the server side we need to remove the type att -->
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <label for="birthdate">Birthdate:</label>
            <input type="date" id="birthdate" name="birthdate" required><br>

            <label for="phone_number">Phone Number:</label>
            <input type="tel" id="phone_number" name="phone_number" required><br>

            <label for="url">URL:</label>
            <input type="url" id="url" name="url" required><br>

            <input type="submit" value="Create User">

        </form>
        <?php if (isset($success) && $success): ?>
            <div class="success">
                <p> User created successfully! </p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>