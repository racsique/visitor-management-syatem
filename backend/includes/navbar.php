<nav class="dashboard-navbar">
<div class="navbar-brand-custom">
    <div class="navbar-logo">
        <i class="bi bi-shield-lock-fill"></i>
    </div>

    <div>
        <strong>SecureGate</strong>
        <small>Visitor Management System</small>
    </div>
</div>

<div class="navbar-user">
    <div class="user-avatar">
        <i class="bi bi-person-fill"></i>
    </div>

    <div>
        <strong><?php echo htmlspecialchars($_SESSION['full_name'] ?? 'Admin'); ?></strong>
        <small><?php echo htmlspecialchars(ucfirst($_SESSION['role'] ?? 'admin')); ?></small>
    </div>
</div>
</nav>


