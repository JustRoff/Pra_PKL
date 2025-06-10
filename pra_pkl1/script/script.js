function formatRupiah(angka) {
    let number_string = angka.replace(/[^,\d]/g, "").toString();
    let split = number_string.split(",");
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        let separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    return rupiah + (split[1] != undefined ? "," + split[1] : "");
}

function setupRupiahInput(id) {
    const input = document.getElementById(id);

    input.addEventListener("input", function (e) {
        let original = input.value;

        // Hapus semua karakter kecuali angka
        let sanitized = original.replace(/[^\d]/g, '');

        // Format ke rupiah
        let formatted = formatRupiah(sanitized);
        input.value = formatted;
    });

    // Mencegah input selain angka dengan keypress
    input.addEventListener("keypress", function (e) {
        if (!/[0-9]/.test(e.key)) {
            e.preventDefault();
        }
    });

    // Atasi paste agar tidak masuk karakter aneh
    input.addEventListener("paste", function (e) {
        let paste = (e.clipboardData || window.clipboardData).getData('text');
        if (!/^\d+$/.test(paste.replace(/\./g, ''))) {
            e.preventDefault();
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    // Format dan batasi input min & max harga
    setupRupiahInput("minPrice");
    setupRupiahInput("maxPrice");

    // Tombol search aktif jika input keyword diisi
    const searchInput = document.querySelector('.search-input');
    const searchBtn = document.getElementById('searchBtn');

    function updateSearchButton() {
        const keywordInput = document.querySelector('input[name="keywords"]');
        const minInput = document.getElementById('minPrice');
        const maxInput = document.getElementById('maxPrice');
        const searchBtn = document.getElementById('searchBtn');
    
        if (keywordInput && minInput && maxInput && searchBtn) {
            const keywordFilled = keywordInput.value.trim() !== '';
            const minFilled = minInput.value.trim() !== '';
            const maxFilled = maxInput.value.trim() !== '';
    
            if (keywordFilled || minFilled || maxFilled) {
                searchBtn.classList.remove('search-disabled');
                searchBtn.classList.add('search-enabled');
                searchBtn.disabled = false;
            } else {
                searchBtn.classList.remove('search-enabled');
                searchBtn.classList.add('search-disabled');
                searchBtn.disabled = true;
            }
        }
    }

    updateSearchButton();
    if (searchInput) searchInput.addEventListener('input', updateSearchButton);
    document.getElementById('minPrice').addEventListener('input', updateSearchButton);
    document.getElementById('maxPrice').addEventListener('input', updateSearchButton);

    // Saat form disubmit, hilangkan titik dari input harga
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function () {
            const min = document.getElementById('minPrice');
            const max = document.getElementById('maxPrice');

            if (min) min.value = min.value.replace(/\./g, '');
            if (max) max.value = max.value.replace(/\./g, '');
        });
    }
});
