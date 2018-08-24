<?php

/*
 uzima id pojma i vraća sve fotografije vezane za taj pojam
 prima GET odakle-dokle učitava, podrazumevano vraća sve
*/
require_once("../ukljuci/config.php");
require_once(ROOT_PATH . "model/Odrednica.php");
require_once(ROOT_PATH . "ukljuci/povezivanje2.php");
include_once(ROOT_PATH . "funkcije/jel-polozena.php");

$broj_pojma = $_GET['br'];
$ovaj_pojam = new Odrednica($broj_pojma);
$broj_tagovanih_slika = count($ovaj_pojam->tagovane_slike);
$svi_tagovi = array();

$ucitaj_od = isset($_GET['ucitaj_od']) ? $_GET['ucitaj_od'] : 0;  // default od početka
$ucitaj_do = isset($_GET['ucitaj_do']) ? $_GET['ucitaj_do'] : $broj_tagovanih_slika;  // default učitava sve
if ($ucitaj_do > $broj_tagovanih_slika) $ucitaj_do = $broj_tagovanih_slika;  // da ne učitava preko postojećih

if ($broj_tagovanih_slika == 0) {
  echo "Nema pronađenih fotografija za ovaj pojam. ";
  die();
}

for ($i = $ucitaj_od; $i < $ucitaj_do; $i++) {
    $br_slike = $ovaj_pojam->tagovane_slike[$i];
    $ova_datoteka = new Izvor($br_slike, 3);
    $ovaj_opis = $ova_datoteka->opis;
    $ovi_tagovi = $ova_datoteka->tagovi;

    if ($ovi_tagovi) {
        for ($brojac = 0; $brojac < count($ovi_tagovi); $brojac++) {
            // ako je unutra niz tagova iterira ga
            if (is_array($ovi_tagovi[$brojac])){
                for ($j = 0; $j < count($ovi_tagovi[$brojac]); $j++) {
                    $svi_tagovi[] = $ovi_tagovi[$brojac][$j];
                } // for
            } else {
                $svi_tagovi[] = $ovi_tagovi[$brojac];
            }
        } // for
    } // if
    $izvor_slike = REMOTE_ROOT . "slike/smanjene/$br_slike-200px.jpg";
    $orjentacija_slike = jelPolozena(ROOT_PATH . $izvor_slike) ? "polozena" : "uspravna";
    echo "<a target='_blank' href='izvor.php?br=$br_slike&vrsta=3'><img class='slike $orjentacija_slike' src='$izvor_slike'></a>";
} // for

$tagovi_fotografija = json_encode($svi_tagovi);
echo "<p class='prikupljeni_tagovi hide'>$tagovi_fotografija</p>";

if ($ucitaj_do < $broj_tagovanih_slika) {
    echo '<p class="ucitavac"><img src="slike/ajax-loader.gif" alt="loading" /> Još fotografija se učitava...</p>';
}

?>
