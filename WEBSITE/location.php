<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAZBEAR LOCATION</title>
    <link rel="stylesheet" href="css/location.css">
</head>
<body>

    <nav>
        <ul>
            <li><img src="images/fnaflogo.png" alt="logo" width="190" height="190"></li>
        </ul>
    </nav>
    
    <div class="section">

        <img src="Images/pizzeria.png" alt="pizzeria" height="300" width="300">
        <h1>Freddy Fazbear's Pizzeria</h1>
        <h3>Welcome To Freddy Fazbear's Pizza. A Magical Place For Kids And Grownups Alike, Where Fantasy And Fun Come To Life.</h3>
        <br>
        <br>
        <h2>Meet The Animatronics</h2>
        <div class="card-container">
            <div class="card-row">
                <div class="card">
                    <img src="images/freddy.png" alt="freddy" width="190" height="250">
                    <div class="container">
                        <h4><?= "Freddy Fazbear" ?></h4>
                        <p><?= "A light brown animatronic bear; wears a black bow tie and black top hat; carries a microphone in his right hand." ?></p>
                    </div>
                </div>
                <div class="card">
                    <img src="images/bonnie.png" alt="bonnie" width="190" height="250">
                    <div class="container">
                        <h4><?= "Bonnie" ?></h4>
                        <p><?= "A blueish-purple animatronic rabbit; wears a red bow tie; plays guitar in the animatronic band." ?></p>
                    </div>
                </div>
                <div class="card">
                    <img src="images/foxy.png" alt="foxy" width="190" height="250">
                    <div class="container">
                        <h4><?= "Foxy" ?></h4>
                        <p><?= "A reddish-brown animatronic fox with yellow eyes; wears an eye patch on his right eye and has a hook for a right hand." ?></p>
                    </div>
                </div>
                <div class="card">
                    <img src="images/chica.png" alt="chica" width="190" height="250">
                    <div class="container">
                        <h4><?= "Chica" ?></h4>
                        <p><?= "A yellow animatronic chicken with an orange beak and magenta eyes; wears bib the reads 'LET'S EAT!'" ?></p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</body>
</html>
