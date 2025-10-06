<?php
session_start();
if (isset($_SESSION['plususername'])) {
if (isset($_POST['location'])) {
  $_SESSION['location'] = $_POST['location'];

  $loc = $_POST['location'];

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "ticketflix";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    echo "Error connecting to server";
  }

  $movies = array();

  $checkdata = "SELECT DISTINCT movies.* FROM movies, current, theatre WHERE theatre.tcity='$loc' AND theatre.tid=current.tid AND current.mid=movies.m_id";


  $result = $conn->query($checkdata);
  while ($row = $result->fetch_assoc()) {
    $movies[] = $row;
  }

  if (!empty($movies)) {
    foreach ($movies as $movie) {
      $mname = $movie['name'];
      $rating = $movie['censor_rating'];
      $imageURL = 'movies/' . $movie['fname'];
      $movieId = $movie['m_id'];
      ?>
      <div class="movie-item">
        <a href="plusbooking.php?movie_id=<?php echo $movieId; ?>">
          <table class="table table-light movie-table">
            <tr>
              <td><img style="height: 270px;" src="<?php echo $imageURL; ?>" alt=""></td>
            </tr>
            <tr>
              <td class="title"><?php echo "Name: " . $mname; ?></td>
            </tr>
            <tr>
              <td><?php echo "Duration: " . $movie['duration_h'] . "h : " . $movie['duration_m'] . "m"; ?></td>
            </tr>
            <tr>
              <td><?php echo "Rated: " . $rating; ?></td>
            </tr>
          </table>
        </a>
      </div>
    <?php
    }
  } else {
    echo "<p>No Movies found...</p>";
  }
}
}
$conn->close();
?>
