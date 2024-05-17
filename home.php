<?php 

require 'config.php';

$userid = null;
if(isset($_GET['id'])) {
    $userid = $_GET['id'];
} else {
    echo "id parameter is missing in the URL";
}

if ($_SERVER['REQUEST_METHOD']==="POST") {
    if (isset($_POST['participate'])) {
        $userid = $_POST['userid'];
        $eventid = $_POST['eventid'];
        
        $sql_check_total_events = "SELECT COUNT(*) as total_event_count FROM ind_events_participation WHERE player_id = ?";
        $stmt_check_total_events = $conn->prepare($sql_check_total_events);
        
        if ($stmt_check_total_events) {
            $stmt_check_total_events->bind_param("i", $userid);
            if ($stmt_check_total_events->execute()) {
                $result_check_total_events = $stmt_check_total_events->get_result();
                $row_check_total_events = $result_check_total_events->fetch_assoc();
                $total_event_count = $row_check_total_events['total_event_count'];
                
                if ($total_event_count >= 5) {
                    echo '<div class="alert alert-danger" role="alert">';
                    echo 'You have already participated in the maximum number of events (5).';
                    echo '</div>';
                } else {
                    $sql_check_participation = "SELECT COUNT(*) as participation_count FROM ind_events_participation WHERE player_id = ? AND event_id = ?";
                    $stmt_check_participation = $conn->prepare($sql_check_participation);
                    
                    if ($stmt_check_participation) {
                        $stmt_check_participation->bind_param("ii", $userid, $eventid);
                        if ($stmt_check_participation->execute()) {
                            $result_check_participation = $stmt_check_participation->get_result();
                            $row_check_participation = $result_check_participation->fetch_assoc();
                            $participation_count = $row_check_participation['participation_count'];
                            
                            if ($participation_count > 0) {
                                echo '<div class="alert alert-warning" role="alert">';
                                echo 'You have already participated in this event.';
                                echo '</div>';
                            } else {
                                $sql_insert_participant = "INSERT INTO ind_events_participation (player_id, event_id) VALUES (?, ?)";
                                $stmt_insert_participant = $conn->prepare($sql_insert_participant);
                                if ($stmt_insert_participant) {
                                    $stmt_insert_participant->bind_param("ii", $userid, $eventid);
                                    if ($stmt_insert_participant->execute()) {
                                        echo 'Participated successfully';
                                    } else {
                                        echo 'Problem at participating';
                                    }
                                    $stmt_insert_participant->close();
                                } else {
                                    echo 'Error in preparing SQL statement';
                                }
                            }
                        } else {
                            echo 'Error executing SQL statement';
                        }
                        $stmt_check_participation->close();
                    } else {
                        echo 'Error in preparing SQL statement';
                    }
                }
            } else {
                echo 'Error executing SQL statement';
            }
            $stmt_check_total_events->close();
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
    <title>Home</title>
</head>
<body>
<style>
.card{
    margin-top: 50px;
    text-align: center;
}
</style>
<div class="container">
    <nav class= "navbar" style="background-color: #D0E8FA;">
        <div class="container">
            <span class="navbar-brand mb-0 h1">individual events</span>
            <i class="nav-item"></i>
        </div>
    </nav>
</div>
<div class="container">
    <div class="row">
        <?php 
        include "config.php";
        if(isset($_GET['id'])) {
            $userid = $_GET['id'];
            $sql = "SELECT name FROM individuals WHERE id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $userid); 
                if ($stmt->execute()) {
                    $stmt->bind_result($name);
                    if ($stmt->fetch()) {
                        echo"<h6>";
                        echo "User name: " . $name;
                        echo"</h6>";
                    } else {
                        echo "No user with this id";
                    }
                } else {
                    echo "Something went wrong";
                }
                $stmt->close();
            }
        } else {
            echo "id parameter is missing in the URL";
        }    
        $sql = "SELECT * FROM ind_events";
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
                echo "<form action='home.php?id={$userid}' method='POST'>"; // Include id parameter in the form action
                echo "<input type='hidden' name='userid' value='" . $userid . "'></input>"; // Hidden input for userid
                echo "<input type='hidden' name='eventid' value='" . $row['id'] . "'></input>"; // Hidden input for eventid
                echo "<button type='submit' name='participate' class='card-link btn btn-primary'>participate</button>";
                echo "</form>";
                echo '</div>';
                echo '</div>';
                echo '</div>';
                $count++;
            }
        }
        ?>
    </div>
</div>
<script src="https://kit.fontawesome.com/58626e92ff.js" crossorigin="anonymous"></script>
</body>
</html>