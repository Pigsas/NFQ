<?php

$title = "Švieslentė";
include 'view/templates/header.php';
include 'includes/autoloader.php';
include 'database.php';

$Clients = Client::getClients();

?>

<div class="container p-5">
    <ul class="list-group">
        <?php foreach ($Clients as $key => $client) { ?>
            <?='<li class="list-group-item '.($key == 0? 'active':'').'">'.$client['firstName'].(!empty($client['firstName'])?' '.$client['lastName']:'').'<span class="float-right">'.$client['meetingTime'].'</span>'.'</li>'?>
        <?php } ?>
    </ul>
</div>