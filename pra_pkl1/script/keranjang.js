document.querySelectorAll('.btn-minus').forEach((btn, index) => {
    btn.addEventListener('click', () => {
      const input = document.querySelectorAll('.qty')[index];
      let qty = parseInt(input.value);
      if (qty > 1) {
        qty--;
        input.value = qty;
        updateSubtotal(index, qty);
      }
    });
  });
  
  document.querySelectorAll('.btn-plus').forEach((btn, index) => {
    btn.addEventListener('click', () => {
      const input = document.querySelectorAll('.qty')[index];
      let qty = parseInt(input.value);
      let max = parseInt(input.max);
      if (qty < max) {
        qty++;
        input.value = qty;
        updateSubtotal(index, qty);
      } else {
        alert("Melebihi stok!");
      }
    });
  });
  
  function updateSubtotal(index, qty) {
    const input = document.querySelectorAll('.qty')[index];
    const harga = parseInt(input.dataset.harga);
    const id = input.dataset.id;
    const subtotal = harga * qty;
    document.querySelectorAll('.subtotal')[index].innerText = 'Rp' + subtotal.toLocaleString('id-ID');
  
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "UpdateKeranjang.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
      if (xhr.status === 200) {
        const res = JSON.parse(xhr.responseText);
        if (res.status !== 'success') {
          alert("Gagal update keranjang: " + (res.message || ''));
        }
      } else {
        alert("Terjadi kesalahan saat menghubungi server.");
      }
    };
xhr.send(`id_keranjang=${id}&jumlah_item=${qty}&subtotal=${subtotal}`);
  }

document.querySelectorAll('.btn-delete').forEach((btn) => {
  btn.addEventListener('click', () => {
    const id = btn.dataset.id;
    if (confirm("Apakah Anda yakin ingin menghapus item ini dari keranjang?")) {
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "hapus_keranjang.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onload = function () {
        if (xhr.status === 200) {
          const res = JSON.parse(xhr.responseText);
          if (res.status === 'success') {
            // Hapus elemen cart-item dari DOM
            const cartItem = btn.closest('.cart-item');
            cartItem.remove();

          updateTotalBayar(); 
          } else {
            alert("Gagal menghapus item: " + (res.message || ''));
          }
        } else {
          alert("Terjadi kesalahan saat menghubungi server.");
        }
      };
      xhr.send(`id_keranjang=${id}`);
    }
  });
});

function updateTotalBayar() {
  let total = 0;
  document.querySelectorAll('.select-item').forEach((checkbox, index) => {
    if (checkbox.checked) {
      const input = document.querySelectorAll('.qty')[index];
      const qty = parseInt(input.value);
      const harga = parseInt(input.dataset.harga);
      total += qty * harga;
    }
  });

  document.getElementById('total-text').innerText = 'Rp' + total.toLocaleString('id-ID');
}

document.querySelectorAll('.select-item').forEach((cb) => {
  cb.addEventListener('change', updateTotalBayar);
});

// Update total saat user ketik jumlah langsung di input
document.querySelectorAll('.qty').forEach((input) => {
  input.addEventListener('input', updateTotalBayar);
});

// Update total juga setelah tombol +/- ditekan
document.querySelectorAll('.btn-minus, .btn-plus').forEach((btn) => {
  btn.addEventListener('click', () => {
    setTimeout(updateTotalBayar, 100); // beri delay agar nilai input sudah berubah
  });
});