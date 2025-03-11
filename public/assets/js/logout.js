const PUBLIC_BASE_URL = "http://localhost/supervisor_module_web/public";
document.addEventListener("DOMContentLoaded", function () {
  const logoutButton = document.getElementById("logoutButton");
  const confirmLogoutBtn = document.getElementById("confirmLogout");
  const logoutModalEl = document.getElementById("logoutModal");
  const logoutModal = new bootstrap.Modal(logoutModalEl, {});

  logoutButton.addEventListener("click", function () {
    logoutModal.show();
  });

  confirmLogoutBtn.addEventListener("click", function () {
    window.location.href = PUBLIC_BASE_URL + "/index?logout=true";
  });
});
