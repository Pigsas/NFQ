<?php

$title = "Švieslentė";
include 'view/templates/header.php';
include 'includes/autoloader.php';
include 'database.php';

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
        $Tickets = Ticket::getTickets($_GET['id'], 10);
        $averageTicket = new Ticket;
        $timeLeft = "Vidutinis laukimo laikas: ".date('H:i', mktime(0,$averageTicket->averageTime()))." min.";
?>
    <p><?=$timeLeft?></p>
    <ul class="list-group">
        <?php foreach ($Tickets as $key => $ticket) {
            if(empty($ticket['id_client']))
                continue;
            $client = new Client($ticket['id_client']);
        ?>
            <?='<li class="list-group-item '.($key == 0? 'active':'').'">'.$client->firstName.(!empty($client->lastName)?' '.$client->lastName:'').'<span class="float-right">'.$ticket['meetingTime'].'</span>'.'</li>'?>
        <?php }
            if(empty($Tickets))
            {
        ?>
        <li class="list-group-item text-center">Šuo metu nėra lankytojų</li>
        <?php
            }
        ?>
    </ul>
<?php
    }
?>
</div>