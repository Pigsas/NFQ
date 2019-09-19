<?php

$title = "Specialisto panelė";
include 'view/templates/header.php';
include 'includes/autoloader.php';
include 'database.php';

if(!empty($_POST['clientComplete']))
{
    $ticket = new Ticket($_POST['id_ticket']);
    $ticket->completed = 1;
    $ticket->meetingEnds = date('Y-m-d H:i');
    if($ticket->update())
    {

    }
}

$Tickets = Ticket::getTickets(1,10);

?>


<div class="container p-5">
    <ul class="list-group">
        <?php foreach ($Tickets as $key => $ticket) { 
            if(empty($ticket['id_client']))
                continue;
            if($key == 0 && empty($ticket['meetingTime']))
            {
                $firstTicket = new Ticket($ticket['id_ticket']);
                $firstTicket->meetingTime = date('Y-m-d H:i');
                $firstTicket->update();
            }
            $client = new Client($ticket['id_client']);
        ?>
            <?='
            <li class="list-group-item '.($key == 0? 'active':'').'">
                '.$client->firstName.(!empty($client->lastName)?' '.$client->lastName:'').'
                '.($key == 0? '
                <form action="admin.php" method="post" class="float-right ml-3">
                    <input type="hidden" name="id_ticket" value="'.$ticket['id_ticket'].'">
                    <input type="submit" name="clientComplete" class="btn btn-danger btn-sm" value="&times;">
                </form>
                ':'').'
                <span class="float-right">
                    '.(empty($ticket['meetingTime'])?($key != 0?'':$firstTicket->meetingTime):$ticket['meetingTime']).'
                </span>
            </li>
            '?>
        
        <?php }
            if(empty($Tickets))
            {
        ?>
        <li class="list-group-item text-center">Šuo metu nėra lankytojų</li>
        <?php
            }
        ?>
    </ul>
</div>