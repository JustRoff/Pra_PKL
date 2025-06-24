document.addEventListener("DOMContentLoaded", function () {
    // Inisialisasi flatpickr bulan
    flatpickr("#startMonth", {
        plugins: [
            new monthSelectPlugin({
                shorthand: true,
                dateFormat: "Y-m",
                altFormat: "F Y"
            })
        ]
    });

    flatpickr("#endMonth", {
        plugins: [
            new monthSelectPlugin({
                shorthand: true,
                dateFormat: "Y-m",
                altFormat: "F Y"
            })
        ]
    });

    // Tombol search aktif jika input keyword, harga, atau bulan diisi
    const keywordInput = document.querySelector('input[name="keywords"]');
    const minInput = document.getElementById('minPrice');
    const maxInput = document.getElementById('maxPrice');
    const startMonth = document.getElementById('startMonth');
    const endMonth = document.getElementById('endMonth');
    const searchBtn = document.getElementById('searchBtn');
    // const sortby = document.getElementById('sortby');

    function updateSearchButton() {
        const keywordFilled = keywordInput.value.trim() !== '';
        const minFilled = minInput.value.trim() !== '';
        const maxFilled = maxInput.value.trim() !== '';
        const startMonthFilled = startMonth.value.trim() !== '';
        const endMonthFilled = endMonth.value.trim() !== '';
        // const sortbyFilled = sortby.value.trim() !== '';

        if (keywordFilled || minFilled || maxFilled || startMonthFilled || endMonthFilled) {
            searchBtn.classList.remove('search-disabled');
            searchBtn.classList.add('search-enabled');
            searchBtn.disabled = false;
        } else {
            searchBtn.classList.remove('search-enabled');
            searchBtn.classList.add('search-disabled');
            searchBtn.disabled = true;
        }
    }

    // Jalankan saat halaman pertama kali dimuat
    updateSearchButton();

    // Tambahkan event listener untuk semua input
    keywordInput.addEventListener('input', updateSearchButton);
    minInput.addEventListener('input', updateSearchButton);
    maxInput.addEventListener('input', updateSearchButton);
    startMonth.addEventListener('input', updateSearchButton);
    endMonth.addEventListener('input', updateSearchButton);
    // sortby.addEventListener('input', updateSearchButton);
});