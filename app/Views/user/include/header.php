<header>
    <div class="logo"><?= session()->get('idNumber')?></div>
    <div class="profile-icon" onclick="toggleSidebar()"><img src="<?= base_url('/images/client/') . session()->get('img') ?>" alt="hello"></div>
  </header>

  <div class="sidebar" id="sidebar">
    <h3>Profile Menu</h3>
    <a href="<?= base_url('clienthome')?>">Home</a>
    <a href="<?= base_url('clientprofile')?>">My Profile</a>
    <a href="<?= base_url('clienthistory')?>">History</a>
    <a href="<?= base_url('clientLogout')?>">Logout</a>
  </div>
