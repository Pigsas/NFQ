<?php

$title = "Švieslentė";
include 'view/templates/header.php';
include 'includes/autoloader.php';
include 'database.php';

$Tickets = Ticket::getTickets(1, 10);

?>

<div class="container p-5">
    <ul class="list-group">
        <?php foreach ($Tickets as $key => $ticket) {
            if(empty($ticket['id_client']))
                continue;
            $client = new Client($ticket['id_client']);
        ?>
            <?='<li class="list-group-item '.($key == 0? 'active':'').'">'.$client->firstName.(!empty($client->lastName)?' '.$client->lastName:'').'<span class="float-right">'.$ticket['meetingTime'].'</span>'.'</li>'?>
        <?php } ?>
    </ul>
</div>