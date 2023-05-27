<?php

$page["title"] = "Hlavní stránka";

?>
<?php require_once("./pages/req.header.php"); ?>

<div class="container" style="margin-top: 50px;">
    <?php
    
    if($formErr->noError() === false){
        echo('<div class="alert alert-danger">');
        echo('Ve formuláři nebyly vyplněny následující položky:');
        echo('<ul>');
        foreach ($formErr->listErrors() as $key => $err) {
            echo('<li>' . $err . '</li>');
        }
        echo('</ul>');
        echo('</div>');
    }
    
    ?>
    <div class="card">
        <h4 class="card-header">Kalkulačka energií</h4>
        <div class="card-body">
            <form method="post">
                <div class="mb-3 form-check">
                    <input class="form-check-input" type="radio" name="komodita" id="komodita1" required value="1" <?php if(isset($_POST["komodita"]) && $_POST["komodita"] == 1){echo("checked");} ?>>
                    <label class="form-check-label" for="komodita1">
                        Elektřina
                    </label>
                </div>
                <div class="mb-3 form-check">
                    <input class="form-check-input" type="radio" name="komodita" id="komodita2" required value="2" <?php if(isset($_POST["komodita"]) && $_POST["komodita"] == 2){echo("checked");} ?>>
                    <label class="form-check-label" for="komodita2">
                        Plyn
                    </label>
                </div>
                <div class="mb-3">
                    <label for="opm" class="form-label">Roční spotřeba</label>
                    <input type="number" class="form-control" min="0" step="any" placeholder="MWh" name="spotreba" id="spotreba" required value="<?php if(isset($_POST["spotreba"])){echo($_POST["spotreba"]);} ?>">
                </div>
                <div class="mb-3">
                    <label for="opm" class="form-label">Cena za MWh</label>
                    <input type="number" class="form-control" min="0" placeholder="Kč/MWh" name="cena" id="cena" required value="<?php if(isset($_POST["cena"])){echo($_POST["cena"]);} ?>">
                </div>
                <div class="mb-3">
                    <label for="opm" class="form-label">Poplatek za OPM</label>
                    <input type="number" class="form-control" min="0" placeholder="Kč/měsíc" name="opm" id="opm" required value="<?php if(isset($_POST["opm"])){echo($_POST["opm"]);} ?>">
                </div>
                <button type="submit" class="btn btn-primary" name="calculate">Spočítat</button>
                <button type="reset" class="btn btn-danger">Vymazat formulář</button>
            </form>
        </div>
    </div>
</div>

<?php require_once("./pages/req.footer.php"); ?>