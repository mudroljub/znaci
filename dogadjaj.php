<?php

require_once("ukljuci/config.php");
include_once(ROOT_PATH . 'model/Dogadjaj.php');
include_once(ROOT_PATH . 'model/Izvor.php');

if (empty($_GET['br'])) die();
$id = filter_input(INPUT_GET, 'br', FILTER_SANITIZE_NUMBER_INT);

if($_POST['novi_opis']) {
    $novi_opis = $mysqli->real_escape_string($_POST['novi_opis']);
    $update_opis = "UPDATE hr1 SET tekst='$novi_opis' WHERE id=$id ;";
    $mysqli->query($update_opis);
}

$dogadjaj = new Dogadjaj($id);
$naslov = $dogadjaj->getNaslov();
include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');
?>

    <article class="okvir izvor">
        <h1><?php echo $dogadjaj->getNaslov(); ?></h1>

        <div class="podaci_o_izvoru">
            <?php $dogadjaj->render_opis($ulogovan); ?>
            <?php
              $datum_prikaz = $dogadjaj->datum;
              if ($datum_prikaz == "0000-00-00.") $datum_prikaz = " nepoznat";
            ?>
            <b>Datum: </b><span><?php echo $datum_prikaz . "."; ?></span>
            <?php if($ulogovan) { ?>
                <input id='dan' type='number' value='<?php echo $dogadjaj->dan; ?>' class='unos-sirina'>
                <input id='mesec' type='number' value='<?php echo $dogadjaj->mesec; ?>' class='unos-sirina'>
                <input id='godina' type='number' value='<?php echo $dogadjaj->godina; ?>' class='unos-sirina'>
                <button type='submit' id='izmeni-datum-zasebno'>Izmeni datum</button><span></span>
            <?php } ?>
            <small>(napomena: neki datumi su okvirni)</small>
            <br>
            <b>Oblast:</b> <?php echo $dogadjaj->oblast_prevedeno; ?>
            <?php
                if($ulogovan) { ?>
                    <select name='nova_oblast' id='nova_oblast' value='<?php echo $dogadjaj->lokacija; ?>'>
                        <?php include "ukljuci/postojece-oblasti.php"; ?>
                    </select>
                    <button type='submit' id='promeni-oblast'>Izmeni oblast</button><span></span>
                <?php }
            ?><br>
            <b>Izvor:</b><i> <?php echo $dogadjaj->izvor; ?></i><br>
            <b>URL:</b> <a href="<?php echo $dogadjaj->url; ?>"><?php echo $dogadjaj->url; ?></a><br>

            <?php Izvor::rendaj_oznake($dogadjaj->tagovi, $ulogovan); ?>

        </div>
        <div class="clear"></div>

        <iframe id='datoteka-frejm' src='<?php echo $dogadjaj->url; ?>' frameborder='0'></iframe>
    </article>

<input type="hidden" id="izvor_id" value="<?php echo $id; ?>">
<input type="hidden" id="vrsta" value="1">
<script src="<?php echo BASE_URL; ?>js/izvor.js"></script>

<?php
include_once(ROOT_PATH . "ukljuci/podnozje.php");
?>
