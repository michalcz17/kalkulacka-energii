<?php

$page["title"] = "Porovnání";

/* select pro název komodity */
$komodita = $komodity->fetch_assoc();

/* výpočet ceny současné nabídky */
$celkemCena = $_POST["spotreba"] * $_POST["cena"] + 12 * $_POST["opm"];

/* select z databáze pro nabídky */
$prepare = $mysqli->prepare("SELECT nabidky.spotreba_od, nabidky.spotreba_do, nabidky.cena, nabidky.poplatek, dodavatele.nazev FROM nabidky JOIN dodavatele ON dodavatele.id=nabidky.dodavatel WHERE nabidky.spotreba_od <= ? AND nabidky.spotreba_do >= ? AND nabidky.komodita = ?");
$prepare->bind_param("sss", $_POST["spotreba"], $_POST["spotreba"], $_POST["komodita"]);
$prepare->execute();
$data = $prepare->get_result();

/* ověří, zda byli v databázi nalezeny záznamy splňující požadavky (zda existují nabídky) */
if($data->num_rows == 0){
    $nabidkyExist = false;
}else{
    $nabidkyExist = true;
    
    /* loop pro nahrání dat z databáze do pole */
    $nabidky = [];
    while($row = $data->fetch_assoc()){
        $row["celkem"] = $_POST["spotreba"] * $row["cena"] + 12 * $row["poplatek"];
        $nabidky[] = $row;
    }

    /* bubble sort pro srovnání nabídek od nejvýhodnější */
    $length = count($nabidky);
    for ($i = 0; $i < $length - 1; $i++) {
        for ($j = 0; $j < $length - $i - 1; $j++) {
            if ($nabidky[$j]["celkem"] > $nabidky[$j + 1]["celkem"]) {
                $temp = $nabidky[$j];
                $nabidky[$j] = $nabidky[$j + 1];
                $nabidky[$j + 1] = $temp;
            }
        }
    }
    
    /* zkontroluje, jestli existuje výhodnější nabídka než současná */
    $vyhodnaNabidka = false;
    if($nabidky[0]["celkem"] < $celkemCena){
        $vyhodnaNabidka = true;
    }
}

?>
<?php require_once("./pages/req.header.php"); ?>

<a href="./" class="btn btn-primary" style="margin: 20px;"><i class="bi bi-reply"></i> Zpět na formulář</a>
<div class="container" style="margin-top: 30px;">
    <h3>Porovnání nabídek</h3>
    <div class="card">
        <h4 class="card-header">Vaše nabídka</h4>
        <div class="card-body">
            <table class="table">
                <thead>
                <tbody>
                    <tr>
                        <td><strong>Komodita:</strong></td>
                        <td><?php echo($komodita["nazev"]); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Roční spotřeba:</strong></td>
                        <td><?php echo($_POST["spotreba"]); ?> MWh</td>
                    </tr>
                    <tr>
                        <td><strong>Cena za MWh:</strong></td>
                        <td><?php echo($_POST["cena"]); ?> Kč/MWh</td>
                    </tr>
                    <tr>
                        <td><strong>Poplatek za OPM:</strong></td>
                        <td><?php echo($_POST["opm"]); ?> Kč/měsíc</td>
                    </tr>
                    <tr>
                        <td><strong>Vaše nabídka celkem:</strong></td>
                        <td><strong><?php echo($celkemCena); ?> Kč</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="card">
        <h4 class="card-header alert alert-success">Nejvýhodnější nabídka</h4>
        <div class="card-body">
            <?php ob_start() ?>
            <table class="table">
                <thead>
                <tbody>
                    <tr>
                        <td><strong>Dodavatel:</strong></td>
                        <td><?php echo($nabidky[0]["nazev"]); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Minimální spotřeba:</strong></td>
                        <td><?php echo($nabidky[0]["spotreba_od"]); ?> MWh</td>
                    </tr>
                    <tr>
                        <td><strong>Maximální spotřeba:</strong></td>
                        <td><?php echo($nabidky[0]["spotreba_do"]); ?> MWh</td>
                    </tr>
                    <tr>
                        <td><strong>Cena za MWh:</strong></td>
                        <td><?php echo($nabidky[0]["cena"]); ?> Kč/MWh</td>
                    </tr>
                    <tr>
                        <td><strong>Poplatek za OPM:</strong></td>
                        <td><?php echo($nabidky[0]["poplatek"]); ?> Kč/měsíc</td>
                    </tr>
                    <tr>
                        <td><strong>Vaše nabídka celkem:</strong></td>
                        <td><strong><?php echo($nabidky[0]["celkem"]); ?> Kč</strong></td>
                    </tr>
                </tbody>
            </table>
            <?php 
                $nejNabidkaHTML = ob_get_clean();
                if($nabidkyExist === true && $vyhodnaNabidka === true){
                    echo($nejNabidkaHTML);
                }else{
                    echo("<p>Nebyla nalezena lepší nabídka než vaše</p>");
                }
            ?>
        </div>
    </div>
    <br>
    <h4>Ostatní nabídky</h4>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Dodavatel</th>
                    <th scope="col">Minimální spotřeba</th>
                    <th scope="col">Maximální spotřeba</th>
                    <th scope="col">Cena za MWh</th>
                    <th scope="col">Poplatek za OPM</th>
                    <th scope="col">Celková cena</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($nabidkyExist === true){
                        foreach ($nabidky as $key => $row) {
                            if($key !== 0 || $vyhodnaNabidka === false){
                                echo('<tr>');
                                echo('<td>' . $row["nazev"] . '</td>');
                                echo('<td>' . $row["spotreba_od"] . ' MWh</td>');
                                echo('<td>' . $row["spotreba_do"] . ' MWh</td>');
                                echo('<td>' . $row["cena"] . ' Kč/MWh</td>');
                                echo('<td>' . $row["poplatek"] . ' Kč/měsíc</td>');
                                echo('<td><strong>' . $row["celkem"] . ' Kč</strong></td>');
                                echo('</tr>');
                            }
                        }
                    }else{
                        echo('<tr><td colspan="6" class="text-center">Nebyly nalezeny žádné nabídky pro zadané parametry</td></tr>');
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once("./pages/req.footer.php"); ?>