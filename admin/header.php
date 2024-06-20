<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 56px;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #6c757d;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: #ffffff !important;
        }
        .navbar-brand:hover, .navbar-nav .nav-link:hover {
            color: #d3d3d3 !important;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 56px;
            left: 0;
            width: 220px;
            background-color: #343a40;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar .nav-link {
            color: #ffffff;
            font-weight: bold;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
            color: #ffffff;
        }
        .content {
            margin-left: 240px;
            padding: 20px;
        }
        .content h1 {
            color: #343a40;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <a class="navbar-brand" href="/resto/admin/">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/resto/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="/resto/admin/">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/resto/admin/create_user.php">Waitress Account</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/resto/admin/category/category.php">Category</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/resto/admin/menu/menu.php">Menu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/resto/admin/payment.php">Payment Method</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/resto/admin/table.php">Table</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/resto/admin/promo.php">Promo</a>
            </li>
        </ul>
    </div>

   

    
