<?php   include_once 'header.php';
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div id="carouselExampleCaptions" class="carousel slide" data-interval="1000" data-ride="carousel" data-cycle="true">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner ">
                    <div class="carousel-item active">
                    <img src="resources/img/0.webp" class="d-block w-100 imgmovemiddle">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>SZÁGULDÁS</h2>
                        <p class="text-uppercase">Válassza ki a kedvenc autóját hatalmas kínálatunkból és béreljen tőlünk!</p>
                    </div>
                    </div>
                    <div class="carousel-item">
                    <img src="resources/img/1.webp" class="d-block w-100 imgmovemaximal">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>PORSCHE</h3>
                        <p class="text-uppercase">Kiváló minőségű szolgáltatás, 98%-os ügyfél elégedettség ★★★★</p>
                    </div>
                    </div>
                    <div class="carousel-item">
                    <img src="resources/img/2.webp" class="d-block w-100 imgmoveminimal">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>SZERELEM</h3>
                        <p class="text-uppercase">Magyarország legjobb árajánlataival várjuk Önt!</p>
                    </div>
                    </div>
                </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="p-4 p-md-5 mb-4 rounded text-bg-dark">
            <div class="col-md-12 px-0">
                <h1 class="display-4 fst-italic">Üdvözli Önt a NewSnaky Cars Kft.!</h1>
                <div class="lead my-3">
                <h2>Adatbázis rendszerek programozása beadandó: AUTÓKÖLCSÖNZŐ (46.)</h2>
                <p>Három darab jogosultsági kör létezik az weboldalon: <i>vendég, felhasználó és admin.</i></p>
                <p>Hozzáférhető funckiók a jogosultságok alapján:</p>
                <pre><code>**JOGOSULTSÁG** // **KÓD** // **NAVIGÁCIÓ A UI-on**</code></pre>
                <h3>Vendég:</h3>
                    <ul>
                    <li>Kínálat autó típus szerint // (offers.php) // KÍNÁLAT</li>
                    <li>Árkalkuláció* // (autoprofile.php -&gt; calculatePrice) // KÍNÁLAT -&gt; Tovább az autó profiljára -&gt; Árkalkuláció</li>
                    </ul>
                <h3>Felhasználó:</h3>
                <p><i>felhasználónév: molnaristvan, jelszo: jelszo15</i></p>
                <ul>
                <li>Kínálat autó típus szerint // (offers.php) // KÍNÁLAT</li>
                <li>Árkalkuláció* // (autoprofile.php -&gt; calculatePrice) // KÍNÁLAT -&gt; Tovább az autó profiljára -&gt; Árkalkuláció</li>
                <li>Foglalás* // (rent.php -&gt; insertNewRent) // KÍNÁLAT -&gt; Tovább az autó profiljára -&gt; FOGLALÁS</li>
                </ul>
                <h3>Admin:</h3>
                <p><i>felhasználónév: admin, jelszó: admin</p></i>
                    <ul>
                    <li> Kínálat autó típus szerint // (offers.php) // KÍNÁLAT </li>
                    <li> Kínálat példány (id) szerint // (adminview.php) // ADMIN-KEZELŐFELÜLET </li>
                    <li> Árkalkuláció* // (autoprofile.php -&gt; calculatePrice) // KÍNÁLAT -&gt; Tovább az autó profiljára -&gt; Árkalkuláció </li>
                    <li> Új autó hozzáadása // admin_autoprofile.php -&gt; doAddAuto // ADMIN-KEZELŐFELÜLET -&gt; Új autó hozzáadása + </li>
                    <li> Meglévő autó szerkesztése // (admin_autoprofile.php -&gt; doEditExistingAuto) // ADMIN-KEZELŐFELÜLET -&gt; Szerkesztés </li>
                    <li> Autó törlése // (admin_autoprofile.php -&gt; doDeleteAuto) // ADMIN-KEZELŐFELÜLET -&gt; Törlés </li>
                    <li> Statisztikai kimutatások // (statistics.php) // KIMUTATÁSOK </li>
                    <br>
                <p>*Foglalás: <br>
                - NEM jogosult manuális váltós autó foglalására az a felhasználó, akinek automataváltós autó vezetésére van kiállítva a jogosítványa (rent.php -&gt; isUserEntitledToRentThisCar) <br>
                például: felhasználónév: horvathjanos, jelszó: jelszo4 NEM jogosult a autó: Hyundai Sedan autó kölcsönzésére</p>
                <p>*Árkalkuláció: <br>
                - aki 5 napon túl foglal autót, az 5% kedvezményre jogosult <br>
                - aki 7 napon túl foglal autót, a 10% kedvezményre jogosult (autoprofile.php -&gt; getDiscountDependingOnDate)</p>

                <h3> E-K model: </h3>
                <img class="maximizedWidth3" src="database_models/ERmodel.jpg" />
                <br>
                <h3> Relációs model: </h3>
                <img class="maximizedWidth3" src="database_models/relationalmodel.jpg" />
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<?php include_once 'footer.php'; ?>