<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insecure Landing Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background: #f0f2f5;
        }
        header {
            background-color: #232f3e;
            color: white;
            padding: 1rem 2rem;
            text-align: center;
        }
        section.hero {
            text-align: center;
            padding: 4rem 2rem;
            background: linear-gradient(120deg, #0073e6, #00c6ff);
            color: white;
        }
        section.hero h1 {
            margin-bottom: 1rem;
            font-size: 2.5rem;
        }
        section.hero p {
            font-size: 1.2rem;
        }
        .content {
            max-width: 800px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        footer {
            text-align: center;
            padding: 1rem;
            background: #232f3e;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <h1>My Insecure Lab</h1>
    </header>
    <section class="hero">
        <h1>Welcome to Insecure Landing Page</h1>
        <p>This is a demo site with Local File Inclusion (LFI) for educational use.</p>
    </section>
    <div class="content">
        <h2>Available Pages:</h2>
        <ul>
            <li><a href="index.php?page=home.php">Home</a></li>
            <li><a href="index.php?page=about.php">About</a></li>
            <li><a href="upload.php">Upload</a></li>
        </ul>
        <hr>
        <?php
            $page = $_GET['page'] ?? 'home.php';
            if (preg_match('/\.\./', $page)) {
                echo "<p style='color:red;'>Directory traversal detected!</p>";
            } elseif (file_exists($page)) {
                include($page);
            } else {
                echo "<p style='color:red;'>File not found.</p>";
            }
        ?>
    </div>
    <footer>
        <p>&copy; 2025 Insecure Lab - For Pentest Practice Only</p>
    </footer>
</body>
</html>