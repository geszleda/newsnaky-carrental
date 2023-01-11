-- Autó tábla létrehozása
CREATE TABLE auto (
    id INTEGER PRIMARY KEY,
    marka VARCHAR(255),
    tipus VARCHAR(255),
    automatavaltos_e BOOLEAN,
    napidij INTEGER,
    kepHivatkozas VARCHAR(255)
);

-- Ügyfél tábla létrehozása
CREATE TABLE ugyfel (
    id INTEGER PRIMARY KEY,
    nev VARCHAR(255),
    felhasznalonev VARCHAR(255),
    jelszo VARCHAR(255),
    email VARCHAR(255)
);

-- Jogosítvány tábla létrehozása
CREATE TABLE jogositvany (
    id INTEGER PRIMARY KEY,
    ugyfel_id INTEGER,
    kategoria VARCHAR(255),
    azonositoszam VARCHAR(255),
    automatavaltos_e BOOLEAN,
    kiallitas_idopontja DATE,
    FOREIGN KEY (ugyfel_id) REFERENCES ugyfel(id)
);

-- Kölcsönzés tábla létrehozása
CREATE TABLE kolcsonzes (
    id INTEGER PRIMARY KEY,
    ugyfel_id INTEGER,
    auto_id INTEGER,
    kedvezmeny INTEGER,
    kezdete DATE,
    vege DATE,
    FOREIGN KEY (ugyfel_id) REFERENCES ugyfel(id),
    FOREIGN KEY (auto_id) REFERENCES auto(id)
);
