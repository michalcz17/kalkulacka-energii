<?php

if(isset($_POST["calculate"])){

    /* Validace požadovaných hodnot */

    /* komodita */
    if(!isset($_POST["komodita"]) || empty($_POST["komodita"])){
        $formErr->addError("Musíte vybrat komoditu, kterou chcete vypočítat!");
    }
    if(!is_numeric($_POST["komodita"])){
        $formErr->addError("Došlo k chybě při výběru komodity (zadaný parametr není číslo), zkuste to prosím znovu! Pokud bude chyba přetrvávat, kontaktujte administrátora stránky.");
    }
    /* zda zadaná komodita existuje nebo ne */
    $prepare = $mysqli->prepare("SELECT nazev FROM praxe.komodity WHERE id=?;");
    $prepare->bind_param("s", $_POST["komodita"]);
    $prepare->execute();
    $komodity = $prepare->get_result();
    if($komodity->num_rows !== 1){
        $formErr->addError("Zadaná komodita nebyla nalezena, zkuste to prosím znovu! Pokud bude chyba přetrvávat, kontaktujte administrátora stránky.");
    }

    /* spotreba */
    if(!isset($_POST["spotreba"])){
        $formErr->addError("Roční spotřeba je vyžadovaná!");
    }
    if(!is_numeric($_POST["spotreba"])){
        $formErr->addError("Roční spotřeba musí být číslo!");
    }else if($_POST["spotreba"] <= 0){
        $formErr->addError("Zadaná roční spotřeba musí být větší než 0 !");
    }

    /* cena */
    if(!isset($_POST["cena"])){
        $formErr->addError("Cena za MWh je vyžadovaná!");
    }
    if(!is_numeric($_POST["cena"])){
        $formErr->addError("Cena za MWh musí být číslo!");
    }else if($_POST["spotreba"] <= 0){
        $formErr->addError("Zadaná cena za MWh musí být větší než 0 !");
    }

    /* opm */
    if(!isset($_POST["opm"])){
        $formErr->addError("Poplatek za OPM je vyžadován!");
    }
    if(!is_numeric($_POST["opm"])){
        $formErr->addError("Poplatek za OPM musí být číslo!");
    }

    /* Pokud je formulář validní */

    if($formErr->noError() === true){
        require_once("./pages/show.page.php");
        exit;
    }
}
?>