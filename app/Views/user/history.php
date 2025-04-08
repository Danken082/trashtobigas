<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="<?= base_url('css/user/history.css')?>">
  <title>History with Filter</title>

</head>
<body>
<?php include('include/header.php');?>
  <div class="container">
    <h2>Redeem History</h2>

    <div class="filter">
      <label for="filterDate"><strong>Filter by Date:</strong></label><br>
      <input type="date" id="filterDate" />
    </div>

    <div id="historyList">
      <div class="history-item" data-date="2025-03-25">
        <strong>March 25, 2025</strong>
        Redeemed 100 points for discount.<br>
        <small>Redeemed at barangay Ilaya</small>
      </div>
      <div class="history-item" data-date="2025-03-10">
        <strong>March 10, 2025</strong>
        Redeemed 50 points for a free item.
      </div>
      <div class="history-item" data-date="2025-02-28">
        <strong>February 28, 2025</strong>
        Redeemed 150 points for a voucher.
      </div>
    </div>

    <p id="noResults" class="no-results" style="display: none;">No history found for selected date.</p>
  </div>


  <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>
  <script>
    const filterInput = document.getElementById('filterDate');
    const historyItems = document.querySelectorAll('.history-item');
    const noResults = document.getElementById('noResults');

    filterInput.addEventListener('input', () => {
      const selectedDate = filterInput.value;
      let matchFound = false;

      historyItems.forEach(item => {
        const itemDate = item.getAttribute('data-date');
        if (selectedDate === "" || itemDate === selectedDate) {
          item.style.display = 'block';
          matchFound = true;
        } else {
          item.style.display = 'none';
        }
      });

      noResults.style.display = matchFound ? 'none' : 'block';
    });

    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      sidebar.classList.toggle('open');
      overlay.classList.toggle('show');
    }
  </script>

</body>
</html>
