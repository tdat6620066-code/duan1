// Toast notification
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => toast.classList.add('show'), 100);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => document.body.removeChild(toast), 300);
    }, 3000);
}

// Debounce function for search
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Search functionality
const searchInput = document.getElementById('search-input');
if (searchInput) {
    const debouncedSearch = debounce(function() {
        const query = searchInput.value.trim();
        if (query.length > 2) {
            fetch(`api/search.php?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    updateProductGrid(data);
                })
                .catch(error => console.error('Search error:', error));
        }
    }, 300);

    searchInput.addEventListener('input', debouncedSearch);
}

function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function updateProductGrid(products) {
    const grid = document.getElementById('products-grid');
    if (!grid) return;

    if (!Array.isArray(products) || products.length === 0) {
        grid.innerHTML = '<div class="lg:col-span-3 bg-white rounded-lg shadow-sm p-8 text-center text-gray-700">Không tìm thấy sản phẩm phù hợp.</div>';
        return;
    }

    grid.innerHTML = products.map(product => {
        let imgUrl = product.image_url || '';
        if (imgUrl && !/^https?:\/\//i.test(imgUrl)) {
            imgUrl = imgUrl.replace(/^\/+/, '');
        }
        if (!imgUrl) {
            imgUrl = 'https://via.placeholder.com/400x400?text=' + encodeURIComponent(product.name);
        }

        return `
            <div class="product-card bg-white rounded-xl shadow-sm overflow-hidden group">
                <div class="relative aspect-square overflow-hidden">
                    <img src="${escapeHtml(imgUrl)}" alt="${escapeHtml(product.name)}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="product-overlay">
                        <a href="?act=product&id=${encodeURIComponent(product.id)}" class="bg-white text-gray-900 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition-colors duration-200">Xem chi tiết</a>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">${escapeHtml(product.name)}</h3>
                    <p class="text-sm text-gray-600 mb-2">${escapeHtml(product.category_name || '')}</p>
                    <p class="text-2xl font-bold text-blue-600">${Number(product.price).toLocaleString('vi-VN')}đ</p>
                </div>
            </div>
        `;
    }).join('');
}

// Add to cart
function addToCart(variantId, quantity = 1) {
    console.log('Adding to cart:', variantId, quantity);
    const formData = new FormData();
    formData.append('variant_id', variantId);
    formData.append('quantity', quantity);

    fetch('?act=cart_add', {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            showToast(data.message, 'success');
            updateCartCount();
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Cart error:', error);
        showToast('Có lỗi xảy ra', 'error');
    });
}

// Update cart count
function updateCartCount() {
    // Implement cart count update
}

function formatCurrency(value) {
    return Number(value).toLocaleString('vi-VN') + 'đ';
}

function updateCartSummary(subtotal, shipping) {
    const shippingAmount = typeof shipping === 'number' ? shipping : (typeof SHIPPING_COST !== 'undefined' ? SHIPPING_COST : 0);
    const subtotalEl = document.getElementById('cart-subtotal');
    const totalEl = document.getElementById('cart-total');
    const shippingEl = document.getElementById('cart-shipping');
    if (subtotalEl) {
        subtotalEl.textContent = formatCurrency(subtotal);
    }
    if (shippingEl) {
        shippingEl.textContent = formatCurrency(shippingAmount);
    }
    if (totalEl) {
        totalEl.textContent = formatCurrency(subtotal + shippingAmount);
    }
}

function updateCartItem(variantId, quantity) {
    const formData = new FormData();
    formData.append('variant_id', variantId);
    formData.append('quantity', quantity);

    fetch('?act=cart_update', {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            showToast(data.message || 'Cập nhật không thành công', 'error');
            return;
        }

        const itemTotalEl = document.querySelector(`[data-item-total="${variantId}"]`);
        if (itemTotalEl && data.line_total !== undefined) {
            itemTotalEl.textContent = formatCurrency(data.line_total);
        }

        updateCartSummary(data.subtotal, data.shipping || 0);
        showToast('Cập nhật giỏ hàng thành công', 'success');
    })
    .catch(error => {
        console.error('Update cart error:', error);
        showToast('Có lỗi khi cập nhật giỏ hàng', 'error');
    });
}

function removeCartItem(event) {
    const button = event.currentTarget;
    const variantId = button.dataset.variantId;
    if (!variantId) {
        return;
    }

    const formData = new FormData();
    formData.append('variant_id', variantId);

    fetch('?act=cart_remove', {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            showToast(data.message || 'Xóa sản phẩm không thành công', 'error');
            return;
        }

        const itemRow = button.closest('.cart-item-row');
        if (itemRow) {
            itemRow.remove();
        }

        recalculateCartSummary();

        if (document.querySelectorAll('.cart-item-row').length === 0) {
            window.location.reload();
            return;
        }

        showToast('Đã xóa sản phẩm khỏi giỏ hàng', 'success');
    })
    .catch(error => {
        console.error('Remove cart item error:', error);
        showToast('Có lỗi khi xóa sản phẩm', 'error');
    });
}

function updateLocalCartTotals(input) {
    const variantId = input.dataset.variantId;
    const price = Number(input.dataset.price || 0);
    const quantity = Math.max(1, parseInt(input.value, 10) || 1);
    const itemTotalEl = document.querySelector(`[data-item-total="${variantId}"]`);

    if (itemTotalEl) {
        itemTotalEl.textContent = formatCurrency(price * quantity);
    }

    let subtotal = 0;
    document.querySelectorAll('.cart-quantity-input').forEach(rowInput => {
        const rowPrice = Number(rowInput.dataset.price || 0);
        const rowQty = Math.max(1, parseInt(rowInput.value, 10) || 1);
        subtotal += rowPrice * rowQty;
    });
    updateCartSummary(subtotal);
}

function recalculateCartSummary() {
    let subtotal = 0;
    document.querySelectorAll('.cart-item-row').forEach(itemRow => {
        const input = itemRow.querySelector('.cart-quantity-input');
        const price = Number(input?.dataset.price || 0);
        const quantity = Math.max(1, parseInt(input?.value, 10) || 1);
        subtotal += price * quantity;
    });
    updateCartSummary(subtotal);
}

function initCartUpdateHandlers() {
    const quantityInputs = document.querySelectorAll('.cart-quantity-input');
    quantityInputs.forEach(input => {
        const updateFromInput = () => {
            let quantity = parseInt(input.value, 10);
            if (Number.isNaN(quantity) || quantity < 1) {
                quantity = 1;
            }
            const variantId = input.dataset.variantId;
            input.value = quantity;
            updateLocalCartTotals(input);
            if (variantId) {
                updateCartItem(variantId, quantity);
            }
        };

        input.addEventListener('input', updateFromInput);
        input.addEventListener('change', updateFromInput);
    });

    const removeButtons = document.querySelectorAll('.cart-remove-btn');
    removeButtons.forEach(button => {
        button.addEventListener('click', removeCartItem);
    });
}

// Navbar scroll effect
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }
});

// Lazy loading images
const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            img.classList.remove('skeleton');
            observer.unobserve(img);
        }
    });
});

document.querySelectorAll('img[data-src]').forEach(img => {
    imageObserver.observe(img);
});

// Product image zoom
function initImageZoom() {
    const productImages = document.querySelectorAll('.product-image');
    productImages.forEach(img => {
        img.addEventListener('mousemove', function(e) {
            const rect = img.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const xPercent = (x / rect.width) * 100;
            const yPercent = (y / rect.height) * 100;

            img.style.transformOrigin = `${xPercent}% ${yPercent}%`;
            img.style.transform = 'scale(1.5)';
        });

        img.addEventListener('mouseleave', function() {
            img.style.transform = 'scale(1)';
        });
    });
}

function initDetailPage() {
    initImageZoom();
    initCartUpdateHandlers();
    
    let selectedVariantId = null;
    const sizeButtons = document.querySelectorAll('.size-btn');
    
    if (sizeButtons.length > 0) {
        console.log('Found size buttons:', sizeButtons.length);
        
        sizeButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                console.log('Size button clicked:', this.dataset.variantId);
                document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('border-blue-500', 'bg-blue-50'));
                this.classList.add('border-blue-500', 'bg-blue-50');
                selectedVariantId = this.dataset.variantId;
                
                const addBtn = document.getElementById('add-to-cart-btn');
                if (addBtn) {
                    addBtn.disabled = false;
                    addBtn.textContent = 'Thêm vào giỏ hàng';
                    addBtn.onclick = () => {
                        console.log('Add to cart clicked with variant:', selectedVariantId);
                        if (typeof addToCart === 'function') {
                            addToCart(selectedVariantId, 1);
                        } else {
                            console.error('addToCart function not found');
                        }
                    };
                }
            });
        });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDetailPage);
} else {
    initDetailPage();
}
