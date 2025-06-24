let selectedAlamatId = null;
let selectedElement = null;

// Fungsi untuk membuka modal
function openModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

// Fungsi untuk menutup modal
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
    // Reset selection
    if (selectedElement) {
        selectedElement.classList.remove('selected');
    }
    selectedAlamatId = null;
    selectedElement = null;
    document.getElementById('btnConfirm').disabled = true;
}

// Fungsi untuk memilih alamat
function selectAlamat(alamatId, element) {
    // Remove selection from previous item
    if (selectedElement) {
        selectedElement.classList.remove('selected');
    }
    
    // Add selection to current item
    element.classList.add('selected');
    selectedElement = element;
    selectedAlamatId = alamatId;
    
    // Enable confirm button
    document.getElementById('btnConfirm').disabled = false;
}

// Fungsi untuk konfirmasi pemilihan
function confirmSelection() {
    if (selectedAlamatId) {
        document.getElementById('selected_alamat_id').value = selectedAlamatId;
        closeModal('alamatModal');
        // Submit form untuk memuat ulang halaman dengan alamat yang dipilih
        document.querySelector('form').submit();
    }
}

// Tutup modal jika user klik di luar modal
window.onclick = function(event) {
    const modal = document.getElementById('alamatModal');
    if (event.target === modal) {
        closeModal('alamatModal');
    }
}

// Tutup modal dengan tombol ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('alamatModal');
        if (modal.style.display === 'block') {
            closeModal('alamatModal');
        }
    }
});

// Auto-select alamat pertama saat modal dibuka (opsional)
function openModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
    
    // Auto-pilih alamat pertama jika ada dan belum ada yang dipilih
    const firstAlamat = document.querySelector('.alamat-item');
    if (firstAlamat && !selectedAlamatId) {
        // Ambil ID dari onclick attribute
        const onclickAttr = firstAlamat.getAttribute('onclick');
        const alamatId = onclickAttr.match(/selectAlamat\((\d+)/)[1];
        selectAlamat(parseInt(alamatId), firstAlamat);
    }
}