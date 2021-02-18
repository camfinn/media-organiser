<?php
// gets the current URI, remove the left / and then everything after the / on the right
$directory = $_SERVER['REQUEST_URI'];
// loop through each directory, check against the known directories, and add class
?>
  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link text-white <?= ($directory == '/dashboard') ? 'active':''; ?>" href="dashboard" aria-selected="true">
                <i class="fas fa-house fa-lg mr-2"></i>
                Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white <?= ($directory == '/browse') ? 'active':''; ?>" href="browse" aria-selected="false">
                <i class="fas fa-search fa-lg mr-2"></i>
                My Files
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white <?= ($directory == '/category') ? 'active':''; ?>" href="category" aria-selected="false">
                <i class="fad fa-file-audio fa-lg mr-2"></i>
                Categories
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white <?= ($directory == '/playlists') ? 'active':''; ?>" href="playlists" aria-selected="false">
                <i class="fas fa-list-music fa-lg mr-2"></i>
                Playlists
              </a>
            </li>
          </ul>
        </div>
      </nav>
