<?php

/* načtení konfigurace a tříd */
require("./config/loader.php");
require("./class/loader.php");

/* handler pro formuláře pokud je nějaký odeslán */
if(!empty($_POST)){
    require("./server/formHandler.php");
}

/* pokud není odeslán formulář nebo nastaly chyby při validaci, zobrazí se stránka s formulářem */
require_once("./pages/home.page.php");
exit;

?>