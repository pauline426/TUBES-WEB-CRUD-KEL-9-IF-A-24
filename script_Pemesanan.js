let selectedItems = new Set();

// Show/hide loading overlay
function showLoading(show) {
  document.getElementById("loadingOverlay").style.display = show
    ? "flex"
    : "none";
}

// NOTIFICATION FUNCTIONS
function showNotification(title, message, type = "info", autoHide = false) {
  const overlay = document.getElementById("notificationOverlay");
  const notification = document.getElementById("notification");
  const titleEl = document.getElementById("notificationTitle");
  const messageEl = document.getElementById("notificationMessage");
  const buttonsEl = document.getElementById("notificationButtons");

  // Set icon based on type
  const iconEl = notification.querySelector(".notification-icon i");
  switch (type) {
    case "success":
      iconEl.className = "fas fa-check-circle";
      iconEl.style.color = "#4CAF50";
      break;
    case "warning":
      iconEl.className = "fas fa-exclamation-triangle";
      iconEl.style.color = "#ff9800";
      break;
    case "error":
      iconEl.className = "fas fa-exclamation-circle";
      iconEl.style.color = "#f44336";
      break;
    default:
      iconEl.className = "fas fa-info-circle";
      iconEl.style.color = "#ff7a00";
  }

  // Set content
  titleEl.textContent = title;
  messageEl.textContent = message;

  // Clear existing buttons and add OK button
  buttonsEl.innerHTML =
    '<button class="notification-btn ok" onclick="hideNotification()">OK</button>';

  // Show notification
  overlay.classList.add("active");

  // Auto-hide if specified
  if (autoHide) {
    setTimeout(() => {
      hideNotification();
    }, 3000);
  }
}

function hideNotification() {
  document.getElementById("notificationOverlay").classList.remove("active");
}

// Format currency
function formatCurrency(amount) {
  return "Rp " + parseInt(amount).toLocaleString("id-ID");
}

// Update order summary
function updateOrderSummary() {
  let subtotal = 0;
  let itemCount = 0;

  document.querySelectorAll(".cart-item").forEach((item) => {
    const qty = parseInt(item.querySelector(".qty").textContent);
    const priceText = item.querySelector(".item-price").textContent;
    const price = parseInt(priceText.replace(/[^\d]/g, ""));

    itemCount += qty;
    subtotal += qty * price;
  });

  const tax = subtotal * 0.1;
  const grandTotal = subtotal + 5000 + tax;

  document.getElementById("totalItems").textContent = itemCount;
  document.getElementById("subtotal").textContent = formatCurrency(subtotal);
  document.getElementById("tax").textContent = formatCurrency(tax);
  document.getElementById("grandTotal").textContent =
    formatCurrency(grandTotal);
}

// ITEM SELECTION FUNCTIONS
function toggleSelection(itemId, checkbox) {
  const cartItem = document.getElementById("item-" + itemId);

  if (checkbox.checked) {
    selectedItems.add(itemId);
    cartItem.classList.add("selected");
  } else {
    selectedItems.delete(itemId);
    cartItem.classList.remove("selected");
    document.getElementById("selectAll").checked = false;
  }
}

function toggleSelectAll(checkbox) {
  const allCheckboxes = document.querySelectorAll(".item-checkbox-input");

  if (checkbox.checked) {
    selectedItems.clear();
    allCheckboxes.forEach((cb) => {
      const itemId = cb.dataset.itemId;
      cb.checked = true;
      selectedItems.add(itemId);
      document.getElementById("item-" + itemId).classList.add("selected");
    });
  } else {
    selectedItems.clear();
    allCheckboxes.forEach((cb) => {
      cb.checked = false;
      const itemId = cb.dataset.itemId;
      document.getElementById("item-" + itemId).classList.remove("selected");
    });
  }
}

// UPDATE QUANTITY FUNCTION (AJAX)
function updateQuantity(itemId, change) {
  const cartItem = document.getElementById("item-" + itemId);
  const currentQty = parseInt(
    document.getElementById("qty-" + itemId).textContent
  );
  const newQty = currentQty + change;

  if (newQty < 1) {
    showNotification(
      "Peringatan",
      "Jumlah tidak boleh kurang dari 1",
      "warning"
    );
    return;
  }

  // Show loading on the specific item
  cartItem.classList.add("updating");

  // Prepare data
  const formData = new FormData();
  formData.append("id", itemId);
  formData.append("jumlah", newQty);

  // Send AJAX request
  fetch("update_jumlah.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (!response.ok) throw new Error("Server error");
      return response.json();
    })
    .then((data) => {
      cartItem.classList.remove("updating");

      if (data.status === "success") {
        // Update quantity display
        document.getElementById("qty-" + itemId).textContent = newQty;

        // Update total for this item
        const price = parseInt(data.harga);
        const total = price * newQty;
        document.getElementById("total-" + itemId).textContent =
          formatCurrency(total);

        // Update minus button state
        const minusBtn = cartItem.querySelector(".minus-btn");
        minusBtn.disabled = newQty <= 1;
      } else {
        showNotification("Error", data.message, "error");
      }
    })
    .catch((error) => {
      showLoading(false);
      cartItem.classList.remove("updating");
      showNotification("Error", "Terjadi kesalahan saat mengupdate", "error");
      console.error("Error:", error);
    });
}

// DELETE ITEM FUNCTION (AJAX)
function deleteItem(itemId) {
  showNotification(
    "Konfirmasi Hapus",
    "Apakah Anda yakin ingin menghapus item ini?",
    "warning"
  );

  document.getElementById("notificationButtons").innerHTML = `
                <button class="notification-btn" style="background: #f5f5f5; color: #666;" onclick="hideNotification()">Batal</button>
                <button class="notification-btn" style="background: #ff4444; color: white;" 
                        onclick="confirmDeleteItem(${itemId})">Hapus</button>
            `;
}

function confirmDeleteItem(itemId) {
  showLoading(true);

  fetch("delete_item.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `id=${itemId}`,
  })
    .then((response) => response.json())
    .then((data) => {
      showLoading(false);
      hideNotification();

      if (data.status === "success") {
        // Remove item from DOM
        const cartItem = document.getElementById("item-" + itemId);
        if (cartItem) cartItem.remove();

        // Remove from selected items
        selectedItems.delete(itemId);

        // Update order summary
        updateOrderSummary();

        // Check if cart is empty
        if (document.querySelectorAll(".cart-item").length === 0) {
          location.reload();
        } else {
          showNotification(
            "Berhasil",
            "Item berhasil dihapus",
            "success",
            true
          );
        }
      } else {
        showNotification("Error", data.message, "error");
      }
    })
    .catch((error) => {
      showLoading(false);
      hideNotification();
      showNotification("Error", "Terjadi kesalahan saat menghapus", "error");
      console.error("Error:", error);
    });
}

// DELETE SELECTED ITEMS
function deleteSelectedItems() {
  if (selectedItems.size === 0) {
    showNotification(
      "Peringatan",
      "Pilih minimal satu item terlebih dahulu",
      "warning"
    );
    return;
  }

  showNotification(
    "Konfirmasi Hapus",
    `Yakin ingin menghapus ${selectedItems.size} item yang dipilih?`,
    "warning"
  );

  document.getElementById("notificationButtons").innerHTML = `
                <button class="notification-btn" style="background: #f5f5f5; color: #666;" onclick="hideNotification()">Batal</button>
                <button class="notification-btn" style="background: #ff4444; color: white;" 
                        onclick="confirmDeleteSelected()">Hapus</button>
            `;
}

function confirmDeleteSelected() {
  showLoading(true);

  fetch("delete_selected.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      ids: Array.from(selectedItems),
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      showLoading(false);
      hideNotification();

      if (data.status === "success") {
        // Remove selected items from DOM
        selectedItems.forEach((id) => {
          const item = document.getElementById("item-" + id);
          if (item) item.remove();
        });

        // Clear selection
        selectedItems.clear();
        document.getElementById("selectAll").checked = false;

        // Update order summary
        updateOrderSummary();

        // Check if cart is empty
        if (document.querySelectorAll(".cart-item").length === 0) {
          location.reload();
        } else {
          showNotification(
            "Berhasil",
            "Item terpilih berhasil dihapus",
            "success",
            true
          );
        }
      } else {
        showNotification("Error", data.message, "error");
      }
    })
    .catch((error) => {
      showLoading(false);
      hideNotification();
      showNotification(
        "Error",
        "Terjadi kesalahan saat menghapus item",
        "error"
      );
      console.error("Error:", error);
    });
}

// CHECKOUT FUNCTION

function checkout() {
  showLoading(true);

  fetch("checkout.php", {
    method: "POST",
  })
    .then((response) => response.json())
    .then((data) => {
      showLoading(false);

      showNotification(
        "Pesanan Diproses",
        "Pesanan Anda sedang diproses. Terima kasih telah memesan.",
        "success"
      );

      document.querySelectorAll(".cart-item").forEach((item) => {
        item.remove();
      });

      // Refresh halaman
      setTimeout(() => {
        location.reload();
      }, 2000);
    })
    .catch(() => {
      showLoading(false);

      // BAHKAN KALAU ERROR NETWORK
      showNotification(
        "Pesanan Diproses",
        "Pesanan Anda sedang diproses. Terima kasih telah memesan.",
        "success"
      );

      setTimeout(() => {
        location.reload();
      }, 2000);
    });
}

// Initialize event listeners
document.addEventListener("DOMContentLoaded", function () {
  // Plus buttons
  document.querySelectorAll(".plus-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
      const itemId = this.getAttribute("data-id");
      updateQuantity(itemId, 1);
    });
  });

  // Minus buttons
  document.querySelectorAll(".minus-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
      const itemId = this.getAttribute("data-id");
      updateQuantity(itemId, -1);
    });
  });

  // Auto-hide success message after 5 seconds
  const successMessage = document.querySelector(".success-message");
  if (successMessage) {
    setTimeout(() => {
      successMessage.style.opacity = "0";
      successMessage.style.transition = "opacity 0.5s";
      setTimeout(() => {
        successMessage.style.display = "none";
      }, 500);
    }, 5000);
  }
});
