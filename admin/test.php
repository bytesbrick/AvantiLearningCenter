<?php session_start(); ?>
<?php

// server info
$server = 'localhost';
$user = 'root';
$pass = 'root';
$db = 'user';
// connect to the database
$mysqli = new mysqli($server, $user, $pass, $db);
// show errors (remove this line if on a live site)
mysqli_report(MYSQLI_REPORT_ERROR);
?>
<?php
if ($_POST['submit']){
    $check = $_POST['representatives'];
    foreach ($check as $ch){
        echo $ch."<br>";
    }

} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
    <head>  
        <script type="text/javascript">
        function get_representatives_value()
        {
            for (var i=0; i < document.list.representatives.length; i++)

            {
                if (document.list.representatives[i].checked = true)
                {
                    var candidate = document.list.representatives[i].checked;

                }
                document.president.radio[i].value;
            }
        }
        }
        </script>
        <title></title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link href="candidate.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <form name="list" action="president2.php" method="post"  onClick="get_president_value">
            <div id="form"> 
            <?php
            // get the records from the database
            if ($result = $mysqli->query("SELECT * FROM candidate_info WHERE position= 'representatives' ORDER BY cand_id"))
            {
            // display records if there are records to display
                if ($result->num_rows > 0)
                {
                    // display records in a table
                    echo "<table border='1' cellpadding='10'>";
                    // set table headers

                    echo "<tr><th>Student ID</th><th>Candidate ID</td><th>Course</th><th colspan = '3'>Name</th></tr>";
                    while ($row = $result->fetch_object())
                    {
                        // set up a row for each record
                        echo "<tr>";
                        echo "<td>" . $row->cand_studid . "</td>";
                        echo "<td>".$row->cand_id."</td>"; 
                        echo "<td>" . $row->course . "</td>";
                        echo "<td coslpan ='5'>" . $row->fname . " ". $row->mname ." ". $row->lname ." </td>";
                        echo "<td><input type ='checkbox' name='representatives[]' id='". $row->studid ."' value='" . $row->fname . " ". $row->mname ." ". $row->lname .  "'onchange='get_representatives_value()' /></td>";
                        echo "</tr>";
                    }
                    cho "</table>";
                }
                // if there are no records in the database, display an alert message
                else
                {
                    echo "No results to display!";
                }
            }
            // show an error if there is an issue with the database query
            else
            {
                echo "Error: " . $mysqli->error;
            }

            // close database connection
            $mysqli->close();
            echo "<input type='submit' value='Submit'/>";
            ?>
            </div>
        </form>
    </body>
</html> 