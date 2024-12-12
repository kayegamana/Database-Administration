<?php
$airlineNameFilter = isset($_GET['airlineName']) ? $_GET['airlineName'] : '';
$aircraftTypeFilter = isset($_GET['aircraftType']) ? $_GET['aircraftType'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : '';


$flightLogsQuery = "SELECT * FROM flightlogs";

if ($airlineNameFilter != '' || $aircraftTypeFilter != '') {
  $flightLogsQuery = $flightLogsQuery . " WHERE";

  if ($airlineNameFilter != '') {
    $flightLogsQuery = $flightLogsQuery . " airlineName='$airlineNameFilter'";
  }

  if ($airlineNameFilter != '' && $aircraftTypeFilter != '') {
    $flightLogsQuery = $flightLogsQuery . " AND";
  }

  if ($aircraftTypeFilter != '') {
    $flightLogsQuery = $flightLogsQuery . " aircraftType='$aircraftTypeFilter'";
  }
}

if ($sort != '') {
  $flightLogsQuery = $flightLogsQuery . " ORDER BY $sort";

  if ($order != '') {
    $flightLogsQuery = $flightLogsQuery . " $order";
  }
}

if (isset($_GET['btnReset'])) {
  header('Location: index.php');
}

$flightLogsResults = executeQuery($flightLogsQuery);

$airlineNameQuery = "SELECT DISTINCT(airlineName) FROM flightlogs";
$airlineNameResults = executeQuery($airlineNameQuery);

$aircraftTypeQuery = "SELECT DISTINCT(aircraftType) FROM flightlogs";
$aircraftTypeResults = executeQuery($aircraftTypeQuery);
?>