<?php
    $currentyear = strftime("%Y");
    if(isset($_POST['voteSubmit'])) {
        $voteResult = mysqli_query($con, "UPDATE vote
        SET voted='Yes', year='{$currentyear}', governor='{$_POST['governor']}', vicegovernor='{$_POST['vicegovernor']}',
        secretary='{$_POST['secretary']}', assistantsecretary='{$_POST['assistantsecretary']}', auditor='{$_POST['auditor']}',
        treasurer='{$_POST['treasurer']}', 5yrmayor='{$_POST['5mayor']}', 4yrmayor='{$_POST['4mayor']}',
        3yrmayor='{$_POST['3mayor']}', 2yrmayor='{$_POST['2mayor']}', 1yrmayor='{$_POST['1mayor']}',
        5yrvicemayor='{$_POST['5vicemayor']}', 4yrvicemayor='{$_POST['4vicemayor']}', 3yrvicemayor='{$_POST['3vicemayor']}',
        2yrvicemayor='{$_POST['2vicemayor']}', 1yrvicemayor='{$_POST['1vicemayor']}', archirep='{$_POST['archirep']}',
        cerep='{$_POST['cerep']}', cperep='{$_POST['cperep']}', eerep='{$_POST['eerep']}', merep='{$_POST['merep']}'
        WHERE idvote='{$_SESSION['voterid']}';");
        if($voteResult == TRUE)$voteResult = "Record updated successfully";
        else $voteResult = "Error updating record: " . $con->error;
    }
?>