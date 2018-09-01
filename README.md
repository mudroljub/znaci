[![](screen.png)](http://znaci.net/arhiv/)

# Arhiv Znaci

Baza dokumenata o drugom svetskom ratu na tlu Jugoslavije.

Poseti: [znaci.net/arhiv](http://znaci.net/arhiv/)

## Razvoj

- Prekopiraj bazu `znaci` na lokalni mysql server
- Iskljuci strogi SQL mod, jer pucaju upiti bez podrazumevanih vrednosti
  - Proveri jel uključen: `SHOW VARIABLES LIKE 'sql_mode';`
  - Ako jeste isključi: `SET GLOBAL sql_mode='';`
- Prekopiraj sa produkcije fajlove `ukljuci/povezivanje2.php` i `ukljuci/povezivanje-staro.php` i unesi podatke za povezivanje sa lokalnom bazom
- Podesi naziv podomena u fajlu `ukljuci/config.php`
- Podesi naziv podomena u fajlu `js/main.js`
- Instaliraj i omogući mode rewrite za apache server (negde je omogućeno po defaultu)
- Pokreni projekat preko lokalnog servera

### Menjanje CSS-a

Build proces za `CSS` se pokreće komandom:
```
npm install
npm start
```

CSS se edituje u `css/dev` folderu, i automatski se kompajlira (spajanje, minifikacija, autoprefiksi) u `css/dist`.

Ne možeš editovati CSS direktno u `css/dist/style.css` fajlu.

### Pravljenje sličica

Za masovno pravljenje malih sličica (thumbnails), pokreni skriptu `admin/prevelicaj-slike.php` iz konzole na serveru.

Skripta smanjuje sve slike iz foldera `znaci.net/images` na visinu 200px i izvozi ih u `slike/smanjene`.

## TODO

- kada pravi novu odrednicu da odmah pravi slug
- srediti dinamičke naslove
- azurira opis, datum, oblast i pripadnost prebaciti iz ukljuci u api
- odvojiti iste elemente sa index.php i odrednica.php
- dodati odrednice (teme) u galeriju
