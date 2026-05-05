<?php
session_start();
require 'data.php'; 
$title = "My Favorites - Ethiopian Heritage";
include 'header.php';
?>

<div class="min-h-screen pt-20">
    <!-- Header -->
    <div class="py-12 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-[--terracotta]/5 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="font-display text-4xl md:text-5xl font-bold mb-4 cultural-gradient"><?= __('my_favorites') ?></h1>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto font-light">
                <?= __('fav_desc') ?>
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        
        <!-- Controls -->
        <div class="flex justify-end mb-8">
            <button onclick="clearFavorites()" class="hidden text-sm font-semibold text-red-500 hover:text-red-600 transition-colors flex items-center gap-2 group glass px-4 py-2 rounded-xl" id="clear-btn">
                <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                <?= __('clear_all') ?>
            </button>
        </div>

        <!-- Grid -->
        <div id="favorites-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8"></div>
        
        <!-- Empty State -->
        <div id="empty-state" class="hidden">
            <div class="glass p-12 rounded-[3rem] text-center max-w-xl mx-auto backdrop-blur-md">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-[--terracotta]/10 rounded-full mb-6 text-[--terracotta]">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
                <h2 class="text-3xl font-display font-bold text-[--text-color] mb-4"><?= __('wishlist_empty') ?></h2>
                <p class="text-gray-500 mb-8 text-lg font-light"><?= __('wishlist_empty_desc') ?></p>
                <a href="products.php" class="btn-primary px-8 py-4 rounded-2xl font-bold text-lg inline-block shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">
                    <?= __('browse_coll') ?>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
const allProducts = <?= json_encode($products) ?>;
const labels = { view: "<?= __('view') ?>" };
document.addEventListener('DOMContentLoaded', () => { renderFavorites(); });
function escapeHtml(unsafe) { if (typeof unsafe !== 'string') return unsafe; return unsafe.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;"); }
function renderFavorites() {
    const wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
    const grid = document.getElementById('favorites-grid'), emptyState = document.getElementById('empty-state'), clearBtn = document.getElementById('clear-btn');
    if (wishlist.length === 0) { grid.innerHTML = ''; grid.classList.add('hidden'); emptyState.classList.remove('hidden'); clearBtn.classList.add('hidden'); return; }
    grid.classList.remove('hidden'); emptyState.classList.add('hidden'); clearBtn.classList.remove('hidden'); grid.innerHTML = '';
    wishlist.forEach(id => {
        const product = allProducts[id];
        if (product) {
            const safeName = escapeHtml(product.name), safeImage = escapeHtml(product.image), safeRegion = escapeHtml(product.region);
            const card = document.createElement('div'); card.className = 'product-card glass rounded-3xl overflow-hidden group transition-all duration-500 hover:-translate-y-2';
            card.innerHTML = `<div class="relative p-2"><div class="relative h-64 rounded-[1.5rem] overflow-hidden"><a href="product.php?id=${product.id}" class="block h-full"><img src="${safeImage}" alt="${safeName}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"></a><button onclick="removeFromFavorites(${product.id})" class="absolute top-3 right-3 w-10 h-10 glass rounded-full flex items-center justify-center text-red-500 hover:bg-red-50 hover:scale-110 transition-all z-10 shadow-sm"><svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/></svg></button></div></div><div class="p-6 pt-2"><a href="product.php?id=${product.id}"><h3 class="font-display text-xl font-bold mb-1 text-[--text-color] truncate hover:text-[--terracotta] transition-colors">${safeName}</h3></a><p class="text-xs font-bold text-[--terracotta] tracking-widest uppercase opacity-80 mb-4">${safeRegion}</p><div class="flex items-center justify-between mt-auto"><span class="text-xl font-bold text-[--text-color]">ETB ${parseFloat(product.price).toLocaleString()}</span><a href="product.php?id=${product.id}" class="glass border border-[--border-color] px-4 py-2 rounded-xl text-sm font-bold hover:bg-[--terracotta] hover:text-white hover:border-[--terracotta] transition-all">${labels.view}</a></div></div>`;
            grid.appendChild(card);
        }
    });
}
function removeFromFavorites(id) { let wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]'); wishlist = wishlist.filter(itemId => itemId !== id); localStorage.setItem('wishlist', JSON.stringify(wishlist)); renderFavorites(); }
function clearFavorites() { if(confirm('Are you sure?')) { localStorage.removeItem('wishlist'); renderFavorites(); } }
</script>
<?php include 'footer.php'; ?>
