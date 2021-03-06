<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <table class="w3-table-all w3-hoverable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th class = 'w3-center' style="min-width: 20px; max-width: 30px;">Name</th>
                    <th>Year Level</th>
                    <th class='w3-center'>College</th>
                    <th class='w3-right'>Vote Count</th>
                </tr>
            </thead>
            <?php
                require_once 'database.php';
                $currentyear = strftime("%Y");
                $q = intval($_GET['q']);
                $result = mysqli_query($con,"SELECT * FROM listofcandidates WHERE candidatetype ='Governor' AND idcollege ='$q' AND candidateyear ='$currentyear';");
                if($result != FALSE)
                {
                    if(mysqli_num_rows($result) != 0)
                    {
                        while($row = mysqli_fetch_array($result))
                        {
                            $result2 = mysqli_query($con, "SELECT * FROM listofstudents WHERE college ='{$row['college']}';");
                            $result3 = mysqli_query($con, "SELECT * FROM vote WHERE governor ='{$row['idnum']}';");
                            $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                            $percent = number_format($percent,2);
                            echo "<tr>
                            <td>{$row['idnum']}</td>
                            <td>{$row['fullname']}</td>
                            <td class ='w3-center'>{$row['yearlevel']}</td>
                            <td class ='w3-center'>{$row['collegecode']}</td>
                            <td class='w3-right'>{$percent}%</td>
                            </tr>\n";
                        }
                    }else{
                        echo "</table>No Candidate Yet";
                    }
                }else{
                    echo "</table>Error Retrieving Candidate Data";
                }
                echo "</table>";
                mysqli_close($con);
            ?>
    </body>
</html>