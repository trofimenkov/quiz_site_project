<html>
    <head>
    <title> Онлайн тести </title>
    <link rel="stylesheet" href="assets/css/header.css">
    </head>
    <body>
        <nav>
            <h2> Онлайн тести </h2>
            <ul>
                <li><a href="/">Головна</a></li>
                <?php if($_SESSION['user']['admin']==1) { 
                    echo "<li><a href='../admin/'>Адмін панель</a></li>" ; } ?>
                <?php if(isset($_SESSION['user'])) { 
                    echo "<li><a href='../profile.php'>Профіль</a></li>" ; 
                    echo "<li><a href='../vendor/logout.php'>Вийти</a></li>" ;
                }
                else {
                    echo "<li><a href='../register.php'>Регістрація</a></li>" ; } ?>
            </ul>
        </nav>
    </body>
</html>