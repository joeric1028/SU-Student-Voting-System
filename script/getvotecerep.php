<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <table class="w3-table-all w3-hoverable">
            <thead>
                <tr><th></th>
                    <th>ID</th>
                    <th class = 'w3-center' style="min-width: 20px; max-width: 30px;">Name</th>
                    <th>Year Level</th>
                    <th class='w3-center'>College</th>
                    <th class='w3-center'>Vote Count</th>
                    <th class='w3-right'>Vote Percentage</th>
                </tr>
            </thead>
            <?php
                require_once 'database.php';
                $currentyear = strftime("%Y");
                $q = intval($_GET['q']);
                $result = mysqli_query($con,"SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='Civil Engineering Representative' AND idcollege ='$q' AND candidateyear ='$currentyear';");
                if($result != FALSE)
                {
                    if(mysqli_num_rows($result) != 0)
                    {
                        while($row = mysqli_fetch_array($result))
                        {
                            $result2 = mysqli_query($con, "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['name']}' AND course.name = 'Bachelor of Science in Civil Engineering';");
                            $result3 = mysqli_query($con, "SELECT * FROM vote WHERE cerep ='{$row['idnum']}';");
                            $count = (mysqli_num_rows($result3));
                            $countall = (mysqli_num_rows($result2));
                            $percent = (mysqli_num_rows($result3)/mysqli_num_rows($result2))*100.00;
                            $percent = number_format($percent,2);
                            echo "<tr><td valign='middle'>";
                            if (empty($row['picture'])) {
                                if($row['sex'] == "Male")echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                                else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                            } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                            echo "</td>
                            <td valign='middle'>{$row['idnum']}</td>
                            <td valign='middle'>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td class ='w3-center' valign='middle'>{$row['yearlevel']}</td>
                            <td class ='w3-center' valign='middle'>{$row['collegecode']}</td>
                            <td class ='w3-center' valign='middle'>{$count}/{$countall}</td>
                            <td class='w3-right' valign='middle'>{$percent}%</td>
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
