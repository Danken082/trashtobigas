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
<div class="tabs">
  <button class="tab active" data-tab="redeemTab">Redemption History</button>
  <button class="tab" data-tab="convertTab">Conversion History</button>
</div>



  <div class="filter">
      <label for="filterDate"><strong>Filter by Date:</strong></label><br>
      <input type="date" id="filterDate" />
    </div>


  <div id="redeemTab" class="tab-content active">
  <h2>Redeem History</h2>

  <?php if (!empty($clienthistory)): ?>
    <div id="historyRedeemList">
      <?php foreach ($clienthistory as $clh): ?>
        <div class="history-item" data-code="<?= $clh['redeem_Code'] ?>" data-date="<?= date('Y-m-d', strtotime($clh['created_at'])) ?>">
          <strong><?= date('F j, Y g:i A', strtotime($clh['created_at'])) ?></strong><br>
          <p style="color:red;">- <?= $clh['points_used']?> Points</p>
          <p style="color:red;">Current Points: <?= $clh['totalCurrentPoints']?></p>
          <small>Redeemed at <?= $clh['address'] ?></small><br>
          <small>Purchase Product: <?= $clh['item'] ?></small><br>
          <small>Redeemed Code: <?= $clh['redeem_Code'] ?></small><br>

        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <strong>No history found</strong>
  <?php endif; ?>

  
<div style="margin-top: 1.5rem;">
  <?= $pager->links() ?>
</div>

</div>


<?php if (!empty($clienthistoryCon)): ?>
<div id="convertTab" class="tab-content">
<h2>Convertion History</h2>
<?php foreach ($clienthistoryCon as $clh): ?>
  <div class="history-item" data-date="<?= date('Y-m-d', strtotime($clh['created_at'])) ?>">
  <strong><?= date('F j, Y g:i A', strtotime($clh['created_at'])) ?></strong><br>
          <p style="color:blue;">+ <?= $clh['gatherPoints']?> Points</p>
          <p style="color:blue;">Current Points: <?= $clh['totalCurrentPoints']?></p>
          <small>weight:  <?= $clh['weight'] . ' ' . $clh['categ'] ?></small><br>
          <small>Convert at <?= $clh['address'] ?></small><br>

  
  <div style="margin-top: 1.5rem;">
  <?php endforeach; ?>
    </div>
  <?php else: ?>

    <p>No conversion history available.</p>
  <?php endif; ?>

  
</div>

</div>

  <p id="noResults" class="no-results" style="display: none;">No history found for selected date.</p>
</div>

<div id="redeemModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close-modal" style="float:right; cursor:pointer;">&times;</span>
    <h3>Redeemed History with Same Code</h3>
    <div id="modalContentArea"></div>
  </div>
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



    const showButtons = document.querySelectorAll('.show-redeem-btn');
  const modal = document.getElementById('redeemModal');
  const modalContentArea = document.getElementById('modalContentArea');
  const closeModalBtn = document.querySelector('.close-modal');

  showButtons.forEach(button => {
    button.addEventListener('click', () => {
      const targetCode = button.getAttribute('data-code');
      modalContentArea.innerHTML = ''; // clear previous content

      document.querySelectorAll('.history-item').forEach(item => {
        if (item.getAttribute('data-code') === targetCode) {
          const clone = item.cloneNode(true);
          // Remove the "Show All" button inside modal clone
          const btn = clone.querySelector('.show-redeem-btn');
          if (btn) btn.remove();
          modalContentArea.appendChild(clone);
        }
      });

      modal.style.display = 'flex';
    });
  });

  closeModalBtn.addEventListener('click', () => {
    modal.style.display = 'none';
  });

  window.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.style.display = 'none';
    }
  });

  // Tab switcher
const tabs = document.querySelectorAll('.tab');
const tabContents = document.querySelectorAll('.tab-content');

tabs.forEach(tab => {
  tab.addEventListener('click', () => {
    const targetId = tab.getAttribute('data-tab');

    tabs.forEach(t => t.classList.remove('active'));
    tabContents.forEach(tc => tc.classList.remove('active'));

    tab.classList.add('active');
    document.getElementById(targetId).classList.add('active');
  });
});

  </script>

</body>
</html>
