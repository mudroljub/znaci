<?php

require_once __DIR__ . "/../ukljuci/povezivanje.php";
include_once "Izvor.php";

/*
  Na osnovu id-a dobavlja sve povezane materijale
*/
class Odrednica {

    public
        $id,
        $naziv,
        $vrsta,
        $dogadjaji = [],
        $dokumenti = [],
        $fotografije = [];

    public function __construct($id) {
        global $mysqli;

        $rezultat_za_entia = $mysqli->query("SELECT naziv, vrsta FROM entia WHERE id=$id ");
        $red_za_entia = $rezultat_za_entia->fetch_assoc();
        $naziv_taga = $red_za_entia["naziv"];
        $vrsta_entia = $red_za_entia["vrsta"];

        $upit_za_hronologiju = "SELECT hr_int.zapis, hr1.dd, hr1.mm, hr1.yy
        FROM hr1 INNER JOIN hr_int
        ON hr1.id = hr_int.zapis
        WHERE hr_int.broj = $id AND hr_int.vrsta_materijala = 1
        ORDER BY hr1.yy,hr1.mm,hr1.dd; ";

        $upit_za_dokumente = "SELECT hr_int.zapis, dokumenti.dan_izv, dokumenti.mesec_izv, dokumenti.god_izv
        FROM dokumenti INNER JOIN hr_int
        ON dokumenti.id = hr_int.zapis
        WHERE hr_int.broj = $id AND hr_int.vrsta_materijala = 2
        ORDER BY dokumenti.god_izv, dokumenti.mesec_izv, dokumenti.dan_izv; ";

        $upit_za_fotke = "SELECT hr_int.zapis, fotografije.datum
        FROM fotografije INNER JOIN hr_int
        ON fotografije.inv = hr_int.zapis
        WHERE hr_int.broj = $id AND hr_int.vrsta_materijala = 3
        ORDER BY fotografije.datum; ";

        if($rezultat_za_hronologiju = $mysqli->query($upit_za_hronologiju)) {
            while($red_za_hronologiju = $rezultat_za_hronologiju->fetch_assoc()) {
                $zapis = $red_za_hronologiju["zapis"];
                $this->dogadjaji[] = $zapis;
            }
            $rezultat_za_hronologiju->close();
        }

        if($rezultat_za_dokumente = $mysqli->query($upit_za_dokumente)) {
            while($red_za_dokumente = $rezultat_za_dokumente->fetch_assoc()) {
                $zapis2 = $red_za_dokumente["zapis"];
                $this->dokumenti[] = $zapis2;
            }
            $rezultat_za_dokumente->close();
        }

        if($rezultat_za_fotke = $mysqli->query($upit_za_fotke)) {
            while($red_za_fotke = $rezultat_za_fotke->fetch_assoc()) {
                $zapis3 = $red_za_fotke["zapis"];
                $this->fotografije[] = $zapis3;
            }
            $rezultat_za_fotke->close();
        }

        if($vrsta_entia == 2){
            $naziv_taga = $naziv_taga . " u oslobodilačkom ratu";
        }

        $this->id = $id;
        $this->naziv = $naziv_taga;
        $this->vrsta = $vrsta_entia;
    }    // konstrukt

}
