<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - Neco Cafe</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css" rel="stylesheet">
    <style>
        /* Style for buttons */
        .btn-primary {
            margin-left: 85%;
        }

        img {
            width: 80px;
            border: 2px solid #343a40;
            border-radius: 10px;
        }

        .container-content {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .container-content .a-content {
            margin: 0 10px;
        }

        .container-content img {
            transition: transform 0.3s, border-color 0.3s;
        }

        .container-content img:hover {
            transform: scale(1.1);
            border-color: #495057;
        }

        .modal-header {
            background-color: #343a40;
            color: white;
        }

        .modal-content {
            border-radius: 15px;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <!-- CONTENT -->
    <div class="container-content mb-4">
        <a href="https://youtube.com" class="a-content">
            <img src="/resto/assets/images/yt.png" class="img-content" alt="YouTube" />
        </a>
        <a href="https://instagram.com" class="a-content">
            <img src="/resto/assets/images/ig.png" class="img-content" alt="Instagram" />
        </a>
        <a href="https://tiktok.com" class="a-content">
            <img src="/resto/assets/images/tiktok.png" class="img-content" alt="TikTok" />
        </a>
    </div>
    <!-- CONTENT END -->

    <div class="container mt-5">
        <button type="button" class="btn btn-primary text-end mt-5" data-toggle="modal" data-target="#exampleModal">
            Contact Us
        </button>

        <!-- Modal Add -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form action="kontak.php" method="post">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Kontak Kami</h1>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="message">Messages:</label>
                                <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Modal End -->
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
