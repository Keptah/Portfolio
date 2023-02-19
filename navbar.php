<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="library/bootstrap-5/css/bootstrap.min.css" rel="stylesheet" />
    <script src="library/bootstrap-5/js/bootstrap.bundle.min.js"></script>
    <title></title>
</head>
<body>
    <nav class="navbar navbar-static-top navbar-expand-sm navbar-light bg-light">
        <div class="container">
            <a href="home.php" class="navbar-brand mb-0 h1">
            <img class="d-inline-block " src="data/imgs/home.jpg" widht="50" height="50"/>
            Domů</a>
            <button 
            type="button"
            class="navbar-toggler"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li calss="nav-item active">
                        <a href="home.php" class="nav-link active">
                            
                        </a>
                    </li>
                    <li calss="nav-item active">
                        <a href="report.php" class="nav-link">
                            Záznam
                        </a>
                    </li>
                    <li calss="nav-item active">
                        <a href="stat.php" class="nav-link">
                            Statistika
                        </a>
                    </li>
                    <li calss="nav-item active">
                        <a href="location.php" class="nav-link">
                            Přidat stanici
                        </a>
                    </li>
                    <li calss="nav-item active">
                        <a href="contact.php" class="nav-link">
                            Kontakt
                        </a>
                    </li>
                </ul>
            </div>
            <a class="nav-item mr-3 nav-link p-3" href="logout.php">Odhlášení</a>
        </div>
    </nav>    
    <br>
</body>
</html>