/* ================= VARIABEL GLOBAL ================= */
let totalItemsInCart = 0;
let currentCategory = "utama";

/* ================= DATA MENU ================= */
const dataMenu = {
  utama: [
    {
      img: "Produk/Img/hidangan/makanan1.jpeg",
      title: "Ikan Bakar",
      price: "Rp 28.000",
    },
    {
      img: "Produk/Img/hidangan/makanan2.jpeg",
      title: "Perkedel",
      price: "Rp 5.000",
    },
    {
      img: "Produk/Img/hidangan/makanan3.jpeg",
      title: "Cumi Bakar",
      price: "Rp 32.000",
    },
    {
      img: "Produk/Img/hidangan/makanan4.jpeg",
      title: "Ayam Goreng Serundeng",
      price: "Rp 22.000",
    },
    {
      img: "Produk/Img/hidangan/makanan5.jpeg",
      title: "Sop Iga",
      price: "Rp 38.000",
    },
    {
      img: "Produk/Img/hidangan/makanan6.jpeg",
      title: "Sambal Joss",
      price: "Rp 4.000",
    },
    {
      img: "Produk/Img/hidangan/makanan7.jpeg",
      title: "Ayam Goreng",
      price: "Rp 20.000",
    },
    {
      img: "Produk/Img/hidangan/makanan8.jpeg",
      title: "Sop Ayam",
      price: "Rp 18.000",
    },
    {
      img: "Produk/Img/hidangan/makanan9.jpeg",
      title: "Gule Sapi",
      price: "Rp 35.000",
    },
    {
      img: "Produk/Img/hidangan/makanan10.jpeg",
      title: "Nasi Goreng",
      price: "Rp 15.000",
    },
    {
      img: "Produk/Img/hidangan/makanan11.jpeg",
      title: "Nasi Biasa",
      price: "Rp 6.000",
    },
    {
      img: "Produk/Img/hidangan/makanan12.jpeg",
      title: "Nasi Kuning",
      price: "Rp 10.000",
    },
  ],
  paket: [
    {
      img: "Produk/Img/paket/paket1.jpeg",
      title: "Paket 1",
      price: "Rp 180.000",
    },
    {
      img: "Produk/Img/paket/paket2.jpeg",
      title: "Paket 2",
      price: "Rp 200.000",
    },
    {
      img: "Produk/Img/paket/paket3.jpeg",
      title: "Paket 3",
      price: "Rp 220.000",
    },
    {
      img: "Produk/Img/paket/paket4.jpeg",
      title: "Paket 4",
      price: "Rp 240.000",
    },
    {
      img: "Produk/Img/paket/paket5.jpeg",
      title: "Paket 5",
      price: "Rp 107.000",
    },
    {
      img: "Produk/Img/paket/paket6.jpeg",
      title: "Paket 6",
      price: "Rp 280.000",
    },
  ],
  minuman: [
    {
      img: "Produk/Img/minuman/minuman1.jpeg",
      title: "Cappuccino",
      price: "Rp 14.000",
    },
    {
      img: "Produk/Img/minuman/minuman2.jpeg",
      title: "Es Cendol",
      price: "Rp 8.000",
    },
    {
      img: "Produk/Img/minuman/minuman3.jpeg",
      title: "Es Teh Manis",
      price: "Rp 14.000",
    },
    {
      img: "Produk/Img/minuman/minuman4.jpeg",
      title: "Brown Sugar",
      price: "Rp 5.000",
    },
    {
      img: "Produk/Img/minuman/minuman5.jpeg",
      title: "Kopi Hitam",
      price: "Rp 7.000",
    },
    {
      img: "Produk/Img/minuman/minuman6.jpeg",
      title: "Es Jeruk Peras",
      price: "Rp 8.000",
    },
  ],
  camilan: [
    {
      img: "Produk/Img/cemilan/cemilan1.jpeg",
      title: "Dimsum",
      price: "Rp 12.000",
    },
    {
      img: "Produk/Img/cemilan/cemilan2.jpeg",
      title: "Cireng",
      price: "Rp 6.000",
    },
    {
      img: "Produk/Img/cemilan/cemilan3.jpeg",
      title: "Pisang Keju",
      price: "Rp 12.000",
    },
    {
      img: "Produk/Img/cemilan/cemilan4.jpeg",
      title: "Nugget Goreng",
      price: "Rp 10.000",
    },
    {
      img: "Produk/Img/cemilan/cemilan5.jpeg",
      title: "Tahu Crispy",
      price: "Rp 6.000",
    },
    {
      img: "Produk/Img/cemilan/cemilan6.jpeg",
      title: "Onde-Onde",
      price: "Rp 5.000",
    },
  ],
};

/* ================= FUNGSI UPDATE KERANJANG ================= */
function updateCartBadge() {
  fetch("get_cart.php")
    .then(res => res.json())
    .then(cartData => {
      // Hitung total SEMUA item (jumlah kuantitas semua menu)
      totalItemsInCart = Object.values(cartData).reduce((sum, qty) => {
        return sum + parseInt(qty);
      }, 0);
      
      console.log("Cart Data:", cartData);
      console.log("Total Items:", totalItemsInCart);
      
      // Update badge
      const keranjangDiv = document.querySelector('.keranjang');
      let existingBadge = keranjangDiv.querySelector('.cart-badge');
      
      if (totalItemsInCart > 0) {
        if (!existingBadge) {
          const cartBadge = document.createElement('div');
          cartBadge.className = 'cart-badge';
          cartBadge.textContent = totalItemsInCart;
          keranjangDiv.appendChild(cartBadge);
          
          keranjangDiv.classList.add('has-items');
          
          setTimeout(() => {
            keranjangDiv.classList.remove('has-items');
          }, 3000);
        } else {
          existingBadge.textContent = totalItemsInCart;
          
          existingBadge.style.transform = 'scale(1.2)';
          setTimeout(() => {
            existingBadge.style.transform = 'scale(1)';
          }, 300);
        }
      } else {
        if (existingBadge) {
          existingBadge.remove();
          keranjangDiv.classList.remove('has-items');
        }
      }
    })
    .catch(err => {
      console.error('Gagal mengambil data keranjang:', err);
    });
}

/* ================= RENDER MENU ================= */
function renderMenu(list) {
  const container = document.querySelector(".menu-grid");
  container.innerHTML = "";

  fetch("get_cart.php")
    .then((res) => res.json())
    .then((cartData) => {
      drawMenu(list, cartData);
      updateCartBadge();
    })
    .catch(() => {
      drawMenu(list, {});
      updateCartBadge();
    });
}

function drawMenu(list, cartData) {
  const container = document.querySelector(".menu-grid");

  list.forEach((item) => {
    const qty = cartData[item.title] ? parseInt(cartData[item.title]) : 0;

    container.innerHTML += `
      <div class="card">
        <img src="${item.img}">
        <div class="card-info">
          <div>
            <div class="card-title">${item.title}</div>
            <div class="card-price">${item.price}</div>
          </div>
          <div class="qty-control"
            data-title="${item.title}"
            data-harga="${item.price.replace(/[^0-9]/g, "")}"
            data-type="${currentCategory}">
            <button class="minus" ${qty === 0 ? 'disabled' : ''}>−</button>
            <span class="qty">${qty}</span>
            <button class="plus">+</button>
          </div>
        </div>
      </div>
    `;
  });

  initQtyButtons();
}



/* ================= SIDEBAR FILTER ================= */
document.querySelectorAll(".menu-item").forEach((item) => {
  item.addEventListener("click", () => {
    const text = item.innerText.toLowerCase();

    if (text.includes("hidangan")) {
      currentCategory = "utama";
      renderMenu(dataMenu.utama);
    } else if (text.includes("paket")) {
      currentCategory = "paket";
      renderMenu(dataMenu.paket);
    } else if (text.includes("minuman")) {
      currentCategory = "minuman";
      renderMenu(dataMenu.minuman);
    } else if (text.includes("cemilan")) {
      currentCategory = "cemilan";
      renderMenu(dataMenu.camilan);
    }
  });
});

/* ================= INISIALISASI SAAT HALAMAN DIMUAT ================= */
document.addEventListener('DOMContentLoaded', function() {
  updateCartBadge();
  
  const keranjangDiv = document.querySelector('.keranjang');
  if (keranjangDiv) {
    keranjangDiv.addEventListener('click', function() {
      this.classList.remove('has-items');
    });
  }
});


function initQtyButtons() {
  document.querySelectorAll(".qty-control").forEach(control => {
    const title = control.dataset.title;

    const minusBtn = control.querySelector(".minus");
    const plusBtn = control.querySelector(".plus");
    const qtySpan = control.querySelector(".qty");

    minusBtn.addEventListener("click", () => {
      let qty = parseInt(qtySpan.textContent);
      if (qty > 0) {
        qty--;
        qtySpan.textContent = qty;
        updateCartServer(title, qty); // update ke server atau localStorage
        if (qty === 0) minusBtn.disabled = true;
      }
    });

    plusBtn.addEventListener("click", () => {
      let qty = parseInt(qtySpan.textContent);
      qty++;
      qtySpan.textContent = qty;
      minusBtn.disabled = false;
      updateCartServer(title, qty); // update ke server atau localStorage
    });
  });
}

// Fungsi untuk update +- menu
function updateCartServer(title, qty) {
  fetch("update_jumlah.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ title, qty })
  })
  .then(res => res.json())
  .then(() => {
    updateCartBadge(); 
  })
  .catch(err => console.error(err));
}


/* ================= DEFAULT ================= */
renderMenu(dataMenu.utama);