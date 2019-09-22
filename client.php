<?php

$title = "Kliento puslapis";
include 'includes/autoloader.php';
include 'database.php';

if(empty($_GET['id']))
{
    header('location: ./');
}

$ini = parse_ini_file(getcwd().'\config.ini');
$iv = substr(hash('sha256', $ini['iv']), 0, 16);
$key = hash('sha256', $ini['key']);
$id = openssl_decrypt($_GET['id'], $ini['cipher'], $key, 0, $iv);
$ticket = new Ticket($id);

if(!empty($_GET['id']) && !empty($_GET['action']))
{
    if($_GET['action'] == "getTime")
    {
        $ticket = new Ticket($id);
        if(empty($ticket->id))
            $message = [
                'text' => 'TOKIO LANKYTOJO NĖRA !',
                'id' => 1
            ];
        elseif(!empty($ticket->meetingEnds))
            $message = [
                'text' => 'JŪSŲ APSILANKYMAS JAU BAIGĖSI !',
                'id' => 2
            ];
        elseif(!empty($ticket->meetingTime))
            $message = [
                'text' => 'JŪSŲ APSILANKYMAS VYSTA DABAR !',
                'id' => 3
            ];
        else
        {
            $eile = array_search($id, array_column(Ticket::getTickets($ticket->id_specialist), 'id_ticket'));
            $eile++;
            $message = [
                'text' => "IKI APSILANKYMO LIKO:<b> ".date('H:i', mktime(0,$eile*$ticket->averageTime()))."</b> min.",
                'id' => 4
            ];
        }
        die(json_encode($message));
    }
    if($_GET['action'] == "changeTime")
    {   

        die($ticket->changeTime());

    }
}

include 'view/templates/header.php';

    
?>
<div class="" id="alert" role="alert">
</div>
<div class="container p-5" onload="getMessage()">
    <ul class="list-group text-center" id="button">
        <li class="list-group-item">
            <button class="btn btn-primary" id="changeTime" onclick="changeTime()">Vėlinti susitikimą</button>
        </li>
        <li class="list-group-item" id="message"></li>
    </ul>
</div>

<script>
    function getMessage()
    {
        var ajax = new XMLHttpRequest();
        ajax.open("GET", "./client?id=<?=$_GET['id']?>&action=getTime", true);
        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(ajax.responseText);
                document.getElementById('message').innerHTML = response['text'];
                if(response['id'] != 4)
                    document.getElementById('changeTime').disabled = true;
            }
        };
        ajax.send();
    }
    function changeTime()
    {
        var ajax = new XMLHttpRequest();
        ajax.open("GET", "./client?id=<?=$_GET['id']?>&action=changeTime", true);
        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(ajax.responseText);
                document.getElementById('alert').className = "alert alert-"+response['alert'];
                document.getElementById('alert').innerHTML = response['text'];
            }
        };
        ajax.send();
        getMessage();
    }
    getMessage()
    window.setInterval(function(){
        getMessage()
    }, 5000);
</script>