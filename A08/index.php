<?php
include("connect.php");
include("assets/process.php");
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PUP AIRPORT | Flight Logs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="assets/styles.css">
  <link rel="icon" href="assets/img/pupAirportIcon.png" type="image/png">
</head>

<body data-bs-theme="dark">
  <div class="container">
    <div class="row mt-5">
      <div class="col">
        <h1 class="pupAirportTitle">PUP AIRPORT</h1>
      </div>
    </div>

    <div class="row mt-3 mb-5">
      <div class="col">
        <form>
          <div class="card p-4 rounded-5">
            <div class="container text-center">
              <div class="row">

                <div class="col-md-4 py-3">
                  <div class="h6 optionsTitle">FILTER</div>

                  <div class="row">
                    <div class="col-md-6 d-flex align-items-center py-2">
                      <label for="airlineNameSelect" style="font-size: 0.8rem;">AIRLINE NAME</label>
                      <select id="airlineNameSelect" name="airlineName" class="form-control mx-2">
                        <option value="">Any</option>
                        <?php
                        if (mysqli_num_rows($airlineNameResults) > 0) {
                          while ($airlineNameRow = mysqli_fetch_assoc($airlineNameResults)) {
                            ?>

                            <option <?php if ($airlineNameFilter == $airlineNameRow['airlineName']) {
                              echo "selected";
                            } ?>
                              value="<?php echo $airlineNameRow['airlineName'] ?>">
                              <?php echo $airlineNameRow['airlineName'] ?>
                            </option>

                            <?php
                          }
                        }
                        ?>
                      </select>
                    </div>

                    <div class="col-md-6 d-flex align-items-center py-2">
                      <label for="airlineNameSelect" style="font-size: 0.8rem">AIRCRAFT TYPE</label>
                      <select id="aircraftTypeSelect" name="aircraftType" class="form-control mx-2">
                        <option value="">Any</option>
                        <?php
                        if (mysqli_num_rows($aircraftTypeResults) > 0) {
                          while ($aircraftTypeRow = mysqli_fetch_assoc($aircraftTypeResults)) {
                            ?>

                            <option <?php if ($aircraftTypeFilter == $aircraftTypeRow['aircraftType']) {
                              echo "selected";
                            } ?>
                              value="<?php echo $aircraftTypeRow['aircraftType'] ?>">
                              <?php echo $aircraftTypeRow['aircraftType'] ?>
                            </option>

                            <?php
                          }
                        }
                        ?>
                      </select>
                    </div>

                  </div>
                </div>

                <div class="col-md-4 py-3">
                  <div class="h6 pb-2 optionsTitle">SORT BY</div>
                  <select id="sort" name="sort" class="form-control mx-auto">
                    <option value="">None</option>
                    <option <?php if ($sort == "flightNumber") {
                      echo "selected";
                    } ?> value="flightNumber">Flight
                      Number
                    </option>
                    <option <?php if ($sort == "departureAirportCode") {
                      echo "selected";
                    } ?> value="departureAirportCode">
                      Departure Airport Code</option>
                    <option <?php if ($sort == "arrivalAirportCode") {
                      echo "selected";
                    } ?> value="arrivalAirportCode">
                      Arrival
                      Airport Code</option>
                    <option <?php if ($sort == "departureDatetime") {
                      echo "selected";
                    } ?> value="departureDatetime">
                      Departure
                      Datetime</option>
                    <option <?php if ($sort == "arrivalDatetime") {
                      echo "selected";
                    } ?> value="arrivalDatetime">
                      Arrival
                      Datetime
                    </option>
                    <option <?php if ($sort == "pilotName") {
                      echo "selected";
                    } ?> value="pilotName">Pilot Name
                    </option>
                  </select>
                </div>

                <div class="col-md-4 py-3">
                  <div class="h6 pb-2 optionsTitle">ORDER BY</div>
                  <select id="order" name="order" class="form-control mx-auto">
                    <option <?php if ($order == "ASC") {
                      echo "selected";
                    } ?> value="ASC">Ascending</option>
                    <option <?php if ($order == "DESC") {
                      echo "selected";
                    } ?> value="DESC">Descending</option>
                  </select>
                </div>

                <div class="text-center">
                  <button class="badge rounded-pill text-bg-primary mt-3 mx-2"
                    style="width: fit-content">SUBMIT</button>
                  <button class="badge rounded-pill text-bg-danger mt-3 mx-2" style="width: fit-content"
                    name="btnReset">RESET</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <h1 class="flightLogsTitle">FLIGHT LOGS</h1>
      </div>
    </div>

    <div class="row mt-1 mb-5">
      <div class="col">
        <div class="card p-4 rounded-5">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead style="font-family: 'Montserrat', sans-serif;">
                <tr>
                  <th scope="col">FLIGHT NUMBER</th>
                  <th scope="col">DEPARTURE AIRPORT CODE</th>
                  <th scope="col">ARRIVAL AIRPORT CODE</th>
                  <th scope="col">DEPARTURE DATETIME</th>
                  <th scope="col">ARRIVAL DATETIME</th>
                  <th scope="col">AIRLINE NAME</th>
                  <th scope="col">AIRCRAFT TYPE</th>
                  <th scope="col">PILOT NAME</th>
                </tr>
              </thead>
              <tbody class="table-group-divider">
                <?php
                if (mysqli_num_rows($flightLogsResults) > 0) {
                  while ($flightLogsRow = mysqli_fetch_assoc($flightLogsResults)) {
                    ?>
                    <tr>
                      <th scope="row"><?php echo $flightLogsRow['flightNumber'] ?></th>
                      <td><?php echo $flightLogsRow['departureAirportCode'] ?></td>
                      <td><?php echo $flightLogsRow['arrivalAirportCode'] ?></td>
                      <td><?php echo $flightLogsRow['departureDatetime'] ?></td>
                      <td><?php echo $flightLogsRow['arrivalDatetime'] ?></td>
                      <td><?php echo $flightLogsRow['airlineName'] ?></td>
                      <td><?php echo $flightLogsRow['aircraftType'] ?></td>
                      <td><?php echo $flightLogsRow['pilotName'] ?></td>
                    </tr>
                    <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>