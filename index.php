<?php
// Inkludera autoload-filen från Composer
require_once(__DIR__ . '/vendor/autoload.php'); // Se till att denna väg är korrekt

// Ladda miljövariabler från .env
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load(); // Detta laddar alla miljövariabler från .env

// Inkludera övriga nödvändiga filer
require_once('lib/PageTemplate.php');
require_once('classes/database.php'); // Lägg till databasklassen

// Skapa instans av Database-klassen för att få tillgång till $dbContext
$dbContext = new Database();

if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "My Title";
    $TPL->ContentBody = __FILE__;
    include "layout.php"; // Denna fil är där du hanterar innehållet
    exit;
}
?>
<p>
<div class="row">

    <div class="col-md-4 col-xs-6">
        <div class="shop">
            <div class="shop-img">
                <img src="/img/shop01.png" alt="Beverages" />
            </div>
            <div class="shop-body">
                <h3>Computers<br>Collection</h3>
                <a class="cta-btn" href="">Shop now <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xs-6">
        <div class="shop">
            <div class="shop-img">
                <img src="/img/shop02.png" alt="Condiments" />
            </div>
            <div class="shop-body">
                <h3>Cameras<br>Collection</h3>
                <a class="cta-btn" href="">Shop now <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xs-6">
        <div class="shop">
            <div class="shop-img">
                <img src="/img/shop03.png" alt="Confections" />
            </div>
            <div class="shop-body">
                <h3>Sound<br>Collection</h3>
                <a class="cta-btn" href="">Shop now <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
</div>


</p>