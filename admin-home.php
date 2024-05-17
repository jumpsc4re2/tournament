<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Admin</title>
</head>
<style>

</style>
<body>
<div class="container">
    <nav class= "navbar" style="background-color: #D0E8FA;">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Admin page</span>
            <a href='admin-allevents.php' class="nav-link">edit events</a>
        </div>
    </nav>
</div>
</body>
</html>
<div class="container text-center">
    <div class="row">
        <div class="col">
            <div class = 'container mt-5' >
        <h4>individual events</h4>'
        <table class ='table table-striped'>
        <thead>
                    <tr>
                        <th>
                        player Name
                        </th>
                        <th>
                        Event Name
                        </th>
                    </tr>
                </thead>
        <tbody>
                    <?php 
                    $sql = "SELECT individuals.name, ind_events.event_name 
                            FROM ind_events_participation 
                            INNER JOIN individuals ON ind_events_participation.player_id = individuals.id 
                            INNER JOIN ind_events ON ind_events_participation.event_id = ind_events.id";
                    $result = $conn->query($sql);
                    if ($result !== false && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>";
                            echo "{$row['name']}";
                            echo "</td>";
                            echo "<td>";
                            echo "{$row['event_name']}";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No data found</td></tr>";
                    }
                    if ($result === false) {
                        echo "Error: " . $conn->error;
                    }
                    ?>
                </tbody>
                </table>
        </div>
        </div>
        <div class="col">
        <div class = 'container mt-5' >
        <h4>team events</h4>
        <div>
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th>
                        Team Name
                        </th>
                        <th>
                        Event Name
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                    $sql = "SELECT teams.team_name, team_events.event_name 
                            FROM team_events_participation 
                            INNER JOIN teams ON team_events_participation.team_id = teams.id 
                            INNER JOIN team_events ON team_events_participation.event_id = team_events.id";
                    $result = $conn->query($sql);
                    if ($result !== false && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>";
                            echo "{$row['team_name']}";
                            echo "</td>";
                            echo "<td>";
                            echo "{$row['event_name']}";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No data found</td></tr>";
                    }
                    if ($result === false) {
                        echo "Error: " . $conn->error;
                    }
                    ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>
</div>
