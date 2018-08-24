<?php
require_once("ukljuci/config.php");
require_once(ROOT_PATH . "model/Odrednica.php");

if($_GET){
    $broj_oznake = filter_input(INPUT_GET, 'br', FILTER_SANITIZE_NUMBER_INT);
} else { $broj_oznake = 1; }

$ovaj_pojam = new Odrednica($broj_oznake);
$naslov = $ovaj_pojam->naziv;
$vrsta = $ovaj_pojam->vrsta;
$broj_tagovanih_hro = count($ovaj_pojam->tagovana_hronologija);
$broj_tagovanih_dok = count($ovaj_pojam->tagovani_dokumenti);
$broj_tagovanih_fot = count($ovaj_pojam->tagovane_slike);
$svi_tagovi = array();

include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');
?>

    <div class="okvir pojam">

        <section class="gornji-odeljak">
            <div class="gore-levo">
                <img class="slika-ustanak" src="slike/ustanak.jpg" alt="ustanak" />
                <?php if($ulogovan) { ?>
                    <div id="promeni-naziv" class="dugme promeni-naziv">Promeni naziv</div><span></span>
                <?php } ?>
                <h1 id='pojam' <?php if($ulogovan) echo "contenteditable='true'";?> class="no-outline"><?php echo $ovaj_pojam->naziv ?></h1>

                <p class="krasnopis siva-donja-crta padding-sm-bottom inline-block">Za ovaj pojam je pronađeno <span><?php echo $broj_tagovanih_hro; ?></span> hronoloških zapisa, <span><?php echo $broj_tagovanih_dok; ?></span> dokumenata i <span><?php echo $broj_tagovanih_fot; ?></span> fotografija.</p>

                <input type="hidden" id="broj_tagovanih_hro" value="<?php echo $broj_tagovanih_hro; ?>">
                <input type="hidden" id="broj_tagovanih_dok" value="<?php echo $broj_tagovanih_dok; ?>">
                <input type="hidden" id="broj_tagovanih_fot" value="<?php echo $broj_tagovanih_fot; ?>">
            </div>
            <div class="clear"></div>
        </section>

        <div class="dve-kolone">
          <div class="hronologija-drzac relative">
            <div class="hide-lg kruzic prstodrzac prstodrzac-dole"></div>
            <div class="hide-lg prstodrzac polukrug-levo"></div>
            <div class="hide-lg prstodrzac polukrug-desno"></div>
            <section id="hronologija" class="podeok hronologija">
                <h2 class="naslov-odeljka">Hronologija </h2>
                <div id="hronologija-sadrzaj">
                    <div class="ucitavac">
                        <img src="slike/ajax-loader.gif" alt="loading" />
                        <p>Hronološki zapisi se učitavaju...</p>
                    </div>
                </div>
            </section>
          </div>

          <div class="relative full">
            <?php include(ROOT_PATH . 'ukljuci/prstodrzaci.php'); ?>
            <section id="dokumenti" class="podeok dokumenti">
                <h2 class="naslov-odeljka">Dokumenti </h2>
                <div id="dokumenti-sadrzaj">
                  <div class="ucitavac">
                      <img src="slike/ajax-loader.gif" alt="loading" />
                      <p>Molimo sačekajte, dokumenti se učitavaju...</p>
                  </div>
                </div>
            </section>
          </div>
        </div>

        <div class="relative">
          <?php include(ROOT_PATH . 'ukljuci/prstodrzaci.php'); ?>
          <section id="fotografije" class="podeok fotografije">
              <h2 class="naslov-odeljka">Fotografije </h2>
              <div id="fotografije-sadrzaj">
                <div class="ucitavac">
                    <img src="slike/ajax-loader.gif" alt="loading" />
                    <p>Istorijske fotografije se učitavaju...</p>
                </div>
              </div>
          </section>
        </div>

        <div class="relative">
          <div class="hide-lg kruzic prstodrzac prstodrzac-gore"></div>
          <section class="podeok tagovi">
              <h2 class="naslov-odeljka">Povezani pojmovi: </h2>
              <div id="tagovi">
                  <img src="slike/ajax-loader.gif" alt="loading" />
                  <p>Povezani pojmovi se generišu...</p>
              </div>
          </section>
        </div>

    </div>
<script src="js/pojam.js"></script>

<?php
include_once(ROOT_PATH . "ukljuci/podnozje.php");
?>