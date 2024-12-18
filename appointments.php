<?php
session_start();
include 'db.php';
include_once('sidebar_users.php');

// $user_id = $_SESSION['id'];
// $user_email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Owner's | Appointment</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <link rel="stylesheet" href="css/appointment.css">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var today = new Date();
            today.setHours(0, 0, 0, 0);

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                dateClick: function(info) {
                    var selectedDate = new Date(info.dateStr);
                    var today = new Date();
                    today.setHours(0, 0, 0, 0);
                    var options = { timeZone: 'Asia/Manila' };
                    var formattedToday = new Date(today.toLocaleString('en-US', options));

                    if (selectedDate < formattedToday) {
                        alert('You cannot select past dates.');
                        return;
                    }
                    $('#appointment_date').val(info.dateStr);
                    $('#appointment-modal').find('b').text(new Intl.DateTimeFormat('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: '2-digit',
                        timeZone: 'Asia/Manila'
                    }).format(selectedDate));
                    $('#appointment-modal').modal('show');
                },
                dayCellDidMount: function(cellInfo) {
                    var cellDate = new Date(cellInfo.date);
                    if (cellDate < today) {
                        cellInfo.el.style.pointerEvents = 'none';
                        cellInfo.el.style.opacity = '0.6';
                    }
                }
            });
            calendar.render();
        });

        // function to update pet dropdown
        function updatePetId() {
            var petSelect = document.getElementById('pet');
            var petId = petSelect.value;
            var petName = petSelect.options[petSelect.selectedIndex].text;
            // set the pet_id and pet_name hidden fields
            document.getElementById('pet_id').value = petId;
            document.getElementById('pet_name').value = petName;
            // fetch pet species and breed using ajax
            if (petId) {
                $.ajax({
                    url: 'conn/get_pet_details.php',
                    type: 'POST',
                    data: { pet_id: petId },
                    success: function(response) {
                        var petDetails = JSON.parse(response);
                        if (petDetails) {
                            document.getElementById('pet_species').value = petDetails.species;
                            document.getElementById('pet_breed').value = petDetails.breed;
                        }
                    },
                    error: function() {
                        console.error('Failed to fetch pet details');
                    }
                });
            }
        }
            function updateServiceId() {
                var serviceSelect = document.getElementById('service');
                var serviceId = serviceSelect.value;
                var serviceName = serviceSelect.options[serviceSelect.selectedIndex].text;

                document.getElementById('service_id').value = serviceId;
                document.getElementById('service_name').value = serviceName;
            }

    </script>
</head>
<body>
    <div class="main-content">
        <div id='calendar'></div>
    </div>

    <!-- Modal for Appointment -->
    <div class="modal fade" id="appointment-modal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentModalLabel">New Appointment</h5>
                </div>
                <div class="form-group">
                    <label class="text-muted">Appointment Schedule</label>
                    <p><b>No date selected</b></p>
                </div>
                <div class="modal-body">
                    <form id="appointment-form" action="conn/add_appointment.php" method="POST">
                        <!-- Hidden fields -->
                        <input type="hidden" name="user_id" value="<?= $_SESSION['id'] ?>">
                        <input type="hidden" name="pet_id" id="pet_id">
                        <input type="hidden" name="pet_name" id="pet_name">
                        <input type="hidden" name="service_id" id="service_id">
                        <input type="hidden" name="service_name" id="service_name">
                        <input type="hidden" name="pet_species" id="pet_species">
                        <input type="hidden" name="pet_breed" id="pet_breed">
                        <input type="hidden" name="appointment_date" id="appointment_date">

                        <!-- Username (read-only) -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username" value="<?php
                            if (isset($_SESSION['id'])) {
                                $user_id = $_SESSION['id'];
                                $user_query = mysqli_query($db,"SELECT username FROM users WHERE id = $user_id");
                                if ($user_query && $user_query->num_rows > 0) {
                                    $user = $user_query->fetch_assoc();
                                    echo htmlspecialchars($user['username']);
                                } else {
                                    echo 'Unknown User';
                                }
                            } else {
                                echo 'No User Logged In';
                            }
                            ?>" readonly>
                        </div>

                        <!-- Email (read-only) -->
                        <div class="mb-3">
                            <label for="useremail" class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" id="useremail" value="<?php
                            if (isset($_SESSION['id'])) {
                                $user_id = $_SESSION['id'];
                                $user_query = mysqli_query($db,"SELECT email FROM users WHERE id = $user_id");
                                if ($user_query && $user_query->num_rows > 0) {
                                    $user = $user_query->fetch_assoc();
                                    echo htmlspecialchars($user['email']);
                                } else {
                                    echo 'Unknown Email';
                                }
                            } else {
                                echo 'No User Email';
                            }
                            ?>" readonly>
                        </div>

                        <!-- Pet Dropdown -->
                        <div class="mb-3">
                            <label for="pet" class="form-label">Pet Name</label>
                            <select class="form-select" id="pet" name="pet" onchange="updatePetId()">
                                <option value="">Select Pet</option>
                                <?php
                                $pets = mysqli_query($db, "SELECT id, pet_name FROM pets WHERE user_id = $user_id");
                                while ($pet = $pets->fetch_assoc()) {
                                    echo "<option value='{$pet['id']}'>{$pet['pet_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Service Type Dropdown -->
                        <div class="mb-3">
                            <label for="service" class="form-label">Service Type</label>
                            <select class="form-select" id="service" name="service" onchange="updateServiceId()">
                                <option value="">Select Service</option>
                                <?php
                                $services = mysqli_query($db, "SELECT id, service_name FROM services");
                                while ($service = $services->fetch_assoc()) {
                                    echo "<option value='{$service['id']}'>{$service['service_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Appointment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
