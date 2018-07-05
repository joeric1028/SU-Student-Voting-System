<html>
    <table class="w3-table-all w3-hoverable">
        <thead>
            <tr><th></th>
                <th>ID</th>
                <th class = 'w3-center' style="min-width: 20px; max-width: 30px;">Name</th>
                <th>Year Level</th>
                <th class='w3-center'>College</th>
            </tr>
        </thead>
        <?php
            require_once '../script/database.php';
            $currentyear = strftime("%Y");
            $error = 'No Candidate Yet';
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
                    $candidatetype = "5Yr Mayor";
                    $yearlevelorcollegename = "AND yearlevel = '5'";
                    break;
                case "vicemayor5yr":
                    $candidatetype = "5Yr Vice Mayor";
                    $yearlevelorcollegename = "AND yearlevel = '5'";
                    break;
                case "mayor4yr":
                    $candidatetype = "4Yr Mayor";
                    $yearlevelorcollegename = "AND yearlevel = '4'";
                    break;
                case "vicemayor4yr":
                    $candidatetype = "4Yr Vice Mayor";
                    $yearlevelorcollegename = "AND yearlevel = '4'";
                    break;
                case "mayor3yr":
                    $candidatetype = "3Yr Mayor";
                    $yearlevelorcollegename = "AND yearlevel = '3'";
                    break;
                case "vicemayor3yr":
                    $candidatetype = "3Yr Vice Mayor";
                    $yearlevelorcollegename = "AND yearlevel = '3'";
                    break;
                case "mayor2yr":
                    $candidatetype = "2Yr Mayor";
                    $yearlevelorcollegename = "AND yearlevel = '2'";
                    break;
                case "vicemayor2yr":
                    $candidatetype = "2Yr Vice Mayor";
                    $yearlevelorcollegename = "AND yearlevel = '2'";
                    break;
                case "mayor1yr":
                    $candidatetype = "1Yr Mayor";
                    $yearlevelorcollegename = "AND yearlevel = '1'";
                    break;
                case "vicemayor1yr":
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
            $sql = "SELECT * FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype = '$candidatetype' AND candidateyear = '$currentyear';";
            $result = $pdo->query($sql);
            $sql = "SELECT COUNT(*) FROM user INNER JOIN course ON course_idcourse = idcourse INNER JOIN college ON college_idcollege = idcollege WHERE candidatetype = '$candidatetype' AND candidateyear = '$currentyear';";
            if ($result != FALSE) {
                if ($pdo->query($sql)->fetchColumn() != 0) {
                    foreach ($result as $row) {
                        echo "<tr><td valign='middle'>";
                        if (empty($row['picture'])) {
                            if ($row['sex'] == "Male") echo '<img src="../img/avatarM.png" width="100" height="100" class="w3-circle w3-card-2">';
                            else echo '<img src="../img/avatarF.png" width="100" height="100" class="w3-circle">';
                        } else echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" height="100" class="w3-circle w3-card-2">';
                        echo "</td>
                            <td>{$row['idnum']}</td>
                            <td>{$row['firstname']} {$row['middleinitial']} {$row['lastname']}</td>
                            <td>{$row['yearlevel']}</td>
                            <td>{$row['collegecode']}</td>
                            </tr>\n";
                    }
                } else  echo "</table>No Candidate Yet";
            } else echo "</table>Error Retrieving Candidate Data";
            Database::disconnect();
        ?>
</html>
