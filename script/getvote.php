<html>
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
            $c = $_GET['c'];
            switch ($c) {
                case "governor":
                    $candidatetype ='Governor';
                    $yearlevelorcollegename = '';
                    break;
                case "vicegovernor":
                    $candidatetype ='Vice Governor';
                    $yearlevelorcollegename = '';
                    break;
                case "assistantsecretary";
                    $candidatetype ='Assistant Secretary';
                    $yearlevelorcollegename = '';
                    break;
                case "secretary":
                    $candidatetype ='Secretary';
                    $yearlevelorcollegename = '';
                    break;
                case "treasurer":
                    $candidatetype ='Treasurer';
                    $yearlevelorcollegename = '';
                    break;
                case "auditor":
                    $candidatetype ='Auditor';
                    $yearlevelorcollegename = '';
                    break;
                case "mayor5yr":
                    $c = "5yrmayor";
                    $candidatetype = "5Yr Mayor";
                    $yearlevelorcollegename = "AND yearlevel = '5'";
                    break;
                case "vicemayor5yr":
                    $c = "5yrvicemayor";
                    $candidatetype = "5Yr Vice Mayor";
                    $yearlevelorcollegename = "AND yearlevel = '5'";
                    break;
                case "mayor4yr":
                    $c = "4yrmayor";
                    $candidatetype = "4Yr Mayor";
                    $yearlevelorcollegename = "AND yearlevel = '4'";
                    break;
                case "vicemayor4yr":
                    $c = "4yrvicemayor";
                    $candidatetype = "4Yr Vice Mayor";
                    $yearlevelorcollegename = "AND yearlevel = '4'";
                    break;
                case "mayor3yr":
                    $c = "3yrmayor";
                    $candidatetype = "3Yr Mayor";
                    $yearlevelorcollegename = "AND yearlevel = '3'";
                    break;
                case "vicemayor3yr":
                    $c = "3yrvicemayor";
                    $candidatetype = "3Yr Vice Mayor";
                    $yearlevelorcollegename = "AND yearlevel = '3'";
                    break;
                case "mayor2yr":
                    $c = "2yrmayor";
                    $candidatetype = "2Yr Mayor";
                    $yearlevelorcollegename = "AND yearlevel = '2'";
                    break;
                case "vicemayor2yr":
                    $c = "2yrvicemayor";
                    $candidatetype = "2Yr Vice Mayor";
                    $yearlevelorcollegename = "AND yearlevel = '2'";
                    break;
                case "mayor1yr":
                    $c = "1yrmayor";
                    $candidatetype = "1Yr Mayor";
                    $yearlevelorcollegename = "AND yearlevel = '1'";
                    break;
                case "vicemayor1yr":
                    $c = "1yrvicemayor";
                    $candidatetype = "1Yr Vice Mayor";
                    $yearlevelorcollegename = "AND yearlevel = '1'";
                    break;
                case "archirep":
                    $candidatetype = "Archetecture Representative";
                    $yearlevelorcollegename = "AND course.name = 'Bachelor of Science in Architecture'";
                    break;
                case "cerep":
                    $candidatetype = "Civil Engineering Representative";
                    $yearlevelorcollegename = "AND course.name = 'Bachelor of Science in Civil Engineering'";
                    break;
                case "cperep":
                    $candidatetype = "Computer Engineering Representative";
                    $yearlevelorcollegename = "AND course.name = 'Bachelor of Science in Computer Engineering'";
                    break;
                case "eerep":
                    $candidatetype = "Electrical Engineering Representative";
                    $yearlevelorcollegename = "AND course.name = 'Bachelor of Science in Electrical Engineering'";
                    break;
                case "merep":
                    $candidatetype = "Mechanical Engineering Representative";
                    $yearlevelorcollegename = "AND course.name = 'Bachelor of Science in Mechanical Engineering'";
                    break;
            }
            $pdo = Database::connect();
            $sql = "SELECT college.name AS collegename, idnum, firstname, middleinitial, lastname, yearlevel, collegecode, picture, sex FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='$candidatetype' AND idcollege ='$q' AND candidateyear ='$currentyear';";
            $result = $pdo->query($sql);
            $sql = "SELECT COUNT(*) FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype ='$candidatetype' AND idcollege ='$q' AND candidateyear ='$currentyear';";
            if ($result != FALSE) {
                if ($pdo->query($sql)->fetchColumn() != 0) {
                    foreach ($result as $row) {
                        $sql = "SELECT COUNT(*) FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE college.name ='{$row['collegename']}' AND admintype = 'Student' $yearlevelorcollegename;";
                        $countall = $pdo->query($sql)->fetchColumn();
                        $sql = "SELECT COUNT(*) FROM vote WHERE $c ='{$row['idnum']}';";
                        $count = $pdo->query($sql)->fetchColumn();
                        $percent = number_format(($count/$countall)*100,2);
                        echo "<tr><td valign='middle'>";
                        if (empty($row['picture'])) {
                            if ($row['sex'] == "Male") echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
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
                } else  echo "</table>No Candidate Yet";
            } else echo "</table>Error Retrieving Candidate Data";
            Database::disconnect();
        ?>
</html>
