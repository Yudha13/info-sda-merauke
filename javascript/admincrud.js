// Sembunyikan semua form edit secara default
document.querySelectorAll(".edit-form").forEach(function (form) {
  form.style.display = "none";
});

// Fungsi untuk menampilkan form edit
function showEditForm(id) {
  document.getElementById("editForm" + id).style.display = "table-row";
}

// Fungsi untuk menyembunyikan form edit
function hideEditForm(id) {
  document.getElementById("editForm" + id).style.display = "none";
}
