<head>
    <title>GearUp Shop Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
        }

        .navbar-brand {
            font-weight: bold;
            color: #fff; /* White text color */
        }

        .navbar {
            padding: 1rem 0;
            background-color: #007bff; /* Blue background color */
        }

        .search-bar {
            display: flex;
            align-items: center;
        }

        #searchInput {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        #searchBtn {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .dashboard-content {
            padding: 2rem 0;
            text-align: center;
        }

        .dashboard-item {
            margin: 1rem;
            padding: 1.5rem;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .dashboard-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .dashboard-item i {
            font-size: 3rem;
            color: #007bff;
        }

        .dashboard-item h4 {
            margin-top: 1rem;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .signup-line {
            border: none;
            height: 2px;
            background: linear-gradient(to right, #007bff, #ff0000); /* Gradient color from blue to red */
            margin: 20px 0;
        }
    </style>
</head>

<div class="container">
    <?php if(isset($_SESSION['success_msg'])) { ?>
        <div class="alert alert-success" role="alert">
            <?php echo $_SESSION['success_msg']; ?>
        </div>
        <?php unset($_SESSION['success_msg']); ?>
    <?php } ?>

    <!-- Form to update user details -->
    <h2>Edit Profile</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="name" value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password" placeholder="Leave blank to keep the same password" />
        </div> 

        <div class="form-group">
            <label>Image</label>
            <input type="file" class="form-control" name="image" accept=".jpg, .jpeg, .png">
        </div>

        <button type="submit" class="btn btn-primary" name="submit">Update Profile</button>

        <a href="?delete_account" class="btn btn-danger">Delete Account</a>

    </form>
</div>
