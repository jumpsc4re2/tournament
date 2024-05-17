<?php
require 'config.php';
$teamid = null;
if(isset($_GET['id'])) {
    $teamid = $_GET['id'];
} else {
    echo "id parameter is missing in the URL";
}
if ($_SERVER['REQUEST_METHOD']==="POST") {
    if (isset($_POST['participate'])) {
        $eventid = $_POST['eventid'];
        $sql_check_total_team_events = "SELECT COUNT(*) as total_team_event_count FROM team_events_participation WHERE team_id = ?";
        $stmt_check_total_team_events = $conn->prepare($sql_check_total_team_events);
        
        if ($stmt_check_total_team_events) {
            $stmt_check_total_team_events->bind_param("i", $teamid);
            if ($stmt_check_total_team_events->execute()) {
                $result_check_total_team_events = $stmt_check_total_team_events->get_result();
                $row_check_total_team_events = $result_check_total_team_events->fetch_assoc();
                $total_team_event_count = $row_check_total_team_events['total_team_event_count'];
                
                if ($total_team_event_count >= 5) {
                    echo '<div class="alert alert-danger" role="alert">';
                    echo 'Your team has already participated in the maximum number of events (5).';
                    echo '</div>';
                } else {
                    $sql_check_team_participation = "SELECT COUNT(*) as team_participation_count FROM team_events_participation WHERE team_id = ? AND event_id = ?";
                    $stmt_check_team_participation = $conn->prepare($sql_check_team_participation);
                    
                    if ($stmt_check_team_participation) {
                        $stmt_check_team_participation->bind_param("ii", $teamid, $eventid);
                        if ($stmt_check_team_participation->execute()) {
                            $result_check_team_participation = $stmt_check_team_participation->get_result();
                            $row_check_team_participation = $result_check_team_participation->fetch_assoc();
                            $team_participation_count = $row_check_team_participation['team_participation_count'];
                            
                            if ($team_participation_count > 0) {
                                echo '<div class="alert alert-warning" role="alert">';
                                echo 'Your team has already participated in this event.';
                                echo '</div>';
                            } else {
                                $sql_insert_team_participant = "INSERT INTO team_events_participation (team_id, event_id) VALUES (?, ?)";
                                $stmt_insert_team_participant = $conn->prepare($sql_insert_team_participant);
                                if ($stmt_insert_team_participant) {
                                    $stmt_insert_team_participant->bind_param("ii", $teamid, $eventid);
                                    if ($stmt_insert_team_participant->execute()) {
                                        echo 'Team participated successfully';
                                    } else {
                                        echo 'Problem at team participating';
                                    }
                                    $stmt_insert_team_participant->close();
                                } else {
                                    echo 'Error in preparing SQL statement';
                                }
                            }
                        } else {
                            echo 'Error executing SQL statement';
                        }
                        $stmt_check_team_participation->close();
                    } else {
                        echo 'Error in preparing SQL statement';
                    }
                }
            } else {
                echo 'Error executing SQL statement';
            }
            $stmt_check_total_team_events->close();
        } else {
            echo 'Error in preparing SQL statement';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <title>team events</title>
</head>
<style>
    .card{
    margin-top: 50px;
    margin-left: 150px;
    text-align: center;
}
h6{
    margin-left:165px
}
</style>
<body>
<div class="container">
    <nav class= "navbar" style="background-color: #D0E8FA;">
        <div class="container">
            <span class="navbar-brand mb-0 h1">teams events</span>
            <i class="nav-item"></i>
        </div>
    </nav>
</div>
</body>
</html>
<?php 
        if(isset($_GET['id'])) {
            $teamid = $_GET['id'];
            $sql = "SELECT team_name FROM teams WHERE id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $teamid); 
                if ($stmt->execute()) {
                    $stmt->bind_result($name);
                    if ($stmt->fetch()) {
                        echo" <h6>";
                        echo "Team Name: " . $name;
                        echo"</h6>";
                    } else {
                        echo "No team found with this id";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
                $stmt->close();
            }
        } else {
            echo "id parameter is missing in the URL";
        } 
$sql = "SELECT * FROM team_events";
$result = $conn->query($sql);
if ($result !== false && $result->num_rows > 0){
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        if ($count % 3 == 0) {
            echo '</div><div class="row">';
        }
        echo '<div class="col">';
        echo '<div class="card" style="width: 15rem;">';
        echo '<div class="card-body">';
        echo "<h3 class='card-title'>{$row['event_name']}</h3>";
        echo "<p class='card-text'>{$row['description']}</p>";
        echo "<form action='team-home.php?id={$teamid}' method='POST'>"; 
        echo "<input type='hidden' name='teamid' value='" . $teamid . "'></input>"; 
        echo "<input type='hidden' name='eventid' value='" . $row['id'] . "'></input>";
        echo "<button type='submit' name='participate' class='card-link btn btn-primary'>participate</button>";
        echo "</form>";
        echo '</div>';
        echo '</div>';
        echo '</div>';
        $count++;
    }
}
?>