# newsnaky-carrental
Adatbázis rendszerek programozása beadandó: AUTÓKÖLCSÖNZŐ (46.)


Három darab jogosultsági kör létezik az weboldalon: vendég, felhasználó és admin:
Horráférhető funckiók a jogosultságok alapján:

    **JOGOSULTSÁG** // **KÓD** // **NAVIGÁCIÓ A UI-on**
Vendég: 
-	Kínálat	autó típus // (offers.php) // KÍNÁLAT
-	Árkalkuláció* // (autoprofile.php -> calculatePrice) // KÍNÁLAT -> Tovább az autó profiljára -> Árkalkuláció

Felhasználó:
felhasználónév: molnaristvan, jelszo: jelszo15

-	Kínálat	autó típus szerint // (offers.php) // KÍNÁLAT
-	Árkalkuláció* // (autoprofile.php -> calculatePrice) // KÍNÁLAT -> Tovább az autó profiljára -> Árkalkuláció
-	Foglalás*	// (rent.php -> insertNewRent) // KÍNÁLAT -> Tovább az autó profiljára -> FOGLALÁS

Admin: 
felhasználónév: admin, jelszó: admin
-	Kínálat	autó típus szerint // (offers.php) // KÍNÁLAT
-	Kínálat példány (id) szerint	// (adminview.php) // ADMIN-KEZELŐFELÜLET
-	Árkalkuláció* // (autoprofile.php -> calculatePrice) // KÍNÁLAT -> Tovább az autó profiljára -> Árkalkuláció
-	Új autó hozzáadása	// admin_autoprofile.php -> doAddAuto // ADMIN-KEZELŐFELÜLET -> Új autó hozzáadása +
-	Meglévő autó szerkesztése	// (admin_autoprofile.php -> doEditExistingAuto) // ADMIN-KEZELŐFELÜLET -> Szerkesztés
-	Autó törlése // (admin_autoprofile.php -> doDeleteAuto) // ADMIN-KEZELŐFELÜLET -> Törlés
-	Statisztikai kimutatások // (statistics.php) // KIMUTATÁSOK

*Foglalás:
- NEM jogosult manuális váltós autó foglalására az a felhasználó, akinek automataváltós autó vezetésére van kiállítva a jogosítványa		(rent.php -> isUserEntitledToRentThisCar)
például:
    felhasználónév: horvathjanos, jelszó: jelszo4 
    NEM jogosult a 
	  autó: Hyundai Sedan autó kölcsönzésére
*Árkalkuláció:
	- aki 5 napon túl foglal autót, az 5% kedvezményre jogosult
	- aki 7 napon túl foglal autót, a 10% kedvezményre jogosult  (autoprofile.php -> getDiscountDependingOnDate)
