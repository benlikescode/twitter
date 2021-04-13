<?php

    // This Controller returns search results from the DB
  

    session_start();  
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/twitter/config/db.php');
    
    $usertoken = $_SESSION['usertoken'];
    

    if (isset($_POST['loadresults'])) {
        $query = $_POST['query'];
         
        // Getting People you follow first
        $alreadyQueried = array();
        $sql = "SELECT * FROM profileactions WHERE profileaction='follow' AND usertoken='$usertoken'";
        $result = mysqli_query($conn,$sql);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $sql1 = "SELECT * FROM users WHERE usertoken='" . $row['profiletoken'] . "' AND username LIKE '%$query%'";
            $result1 = mysqli_query($conn,$sql1);

            while($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
                echo $row1["username"] . "<br>";
                array_push($alreadyQueried, $row1["username"]);
            }
        }


        $sql = "SELECT * FROM users WHERE username LIKE '%$query%' LIMIT 7";
        $result = mysqli_query($conn,$sql);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            if (in_array($row["username"], $alreadyQueried) == false) {
                echo $row["username"] . "<br>";
            }
           
        }
    }

    if (isset($_POST['loadrecents'])) {
        $sql = "SELECT * FROM queries WHERE usertoken='$usertoken' ORDER BY id DESC LIMIT 10";
        $result = mysqli_query($conn,$sql);

        echo "
            <div class='search-container'>
                <div class='search-top'>
                    <span>Recent</span>
                    <button id='clear-recent'>Clear all</button>
                </div>
            </div>
        ";

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo "
                <div class='recent-search-container'>
                    <div class='recent-search-left'>
                        <svg viewBox='0 0 24 24'><g><path d='M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z'></path></g></svg>
                        <span>" . $row['querycontent'] ."</span>
                    </div>
                    <div class='recent-search-right'>
                        <button class='clear-this-recent'>
                            <svg viewBox='0 0 24 24' class='r-13gxpu9 r-4qtqp9 r-yyyyoo r-1q142lx r-50lct3 r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-1srniue'><g><path d='M13.414 12l5.793-5.793c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0L12 10.586 6.207 4.793c-.39-.39-1.023-.39-1.414 0s-.39 1.023 0 1.414L10.586 12l-5.793 5.793c-.39.39-.39 1.023 0 1.414.195.195.45.293.707.293s.512-.098.707-.293L12 13.414l5.793 5.793c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L13.414 12z'></path></g></svg>
                        </button>
                    </div>
                </div> 
            ";
            
        }
    }

    if (isset($_POST['loadtrending'])) {
        $query = $_POST['query'];
        $sql = "SELECT * FROM queries WHERE querycontent LIKE '%$query%' GROUP BY 'querycontent' ORDER BY COUNT(*) DESC LIMIT 3";
        $result = mysqli_query($conn,$sql);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo $row['querycontent'] . "<br>";
        }
    }

    if (isset($_POST['submitquery'])) {
        $query = $_POST['query'];
        $querydate = date('m/d/Y h:i:s a', time());

        $sql = "INSERT INTO queries (querycontent, querydate, usertoken) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $query, $querydate, $usertoken);
        $stmt->execute();
    }

    if (isset($_POST['clearrecents'])) {
        $sql = "DELETE FROM queries WHERE usertoken='$usertoken'";
        if (mysqli_query($conn, $sql)) {
            echo "Record deleted successfully";
        } 
        else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
        mysqli_close($conn); 
    }
