<?php

$title = "Statistikos puslapis";
include 'includes/autoloader.php';
include 'database.php';
include 'view/templates/header.php';
 
?>
<div class="container p-5">
<?php 
    if(empty($_GET['id']))
    {
?>
    <form action="" method="GET">
        <div class="form-group">
            <select name="id" class="form-control">
                <option value="">Pasirink specialistą..</option>
            <?php
            foreach (Specialist::getSpecialists() as $specialist) {
            ?>
                <option value="<?=$specialist['id_specialist']?>"><?=$specialist['firstName']?> <?=$specialist['lastName']?></option>
            <?php
            }
            ?>
            </select>
        </div>
        <div class="form-group">
            <input type="submit" name="submitClient" class="form-control btn btn-outline-primary" value="Pateikti">
        </div>
    </form>
<?php
    }
    else
    {
        $Tickets = Ticket::averageTimeInMeeting($_GET['id']);
        $dataPoints = array();
        foreach ($Tickets as $value) {
            array_push($dataPoints, array("label" => $value['date'], "y" => $value['minutes']));
        }
        $specialist = new Specialist($_GET['id']);
?>

<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	animationEnabled: true,
	zoomEnabled: true,
	title: {
		text: "Specialisto <?=$specialist->firstName." ".$specialist->lastName?> apsilankymų statistika (žemesnis geresnis)"
	},
    axisX:{
        title: "Laikas",
        gridThickness: 2
    },
    axisY: {
        title: "Apsilankymo trukmė (min.)"
    },
	data: [{
		type: "area",     
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<?php
    }
?>
</div>