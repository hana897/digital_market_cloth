<?php
session_start();

$title = "Our Collection - Ethiopian Heritage";
include 'header.php';
include 'data.php';
?>

<div class="min-h-screen pt-20">
    <!-- Modern Header -->
    <header class="py-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-[--terracotta]/5 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="font-display text-5xl md:text-7xl font-bold mb-6 cultural-gradient"><?= __('discover_auth') ?></h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto font-light leading-relaxed">
                <?= __('explore_curated') ?>
            </p>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        <div class="flex flex-col lg:flex-row gap-12">
            
            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-64 space-y-8 shrink-0">
                <!-- Search -->
                <div class="glass p-6 rounded-3xl">
                    <h3 class="font-bold text-lg mb-4 text-[--text-color]"><?= __('search') ?></h3>
                    <div class="relative">
                        <input type="text" id="product-search" placeholder="<?= __('search_placeholder') ?>" class="w-full pl-10 pr-4 py-3 rounded-2xl border border-[--border-color] focus:ring-2 focus:ring-[--terracotta] transition bg-transparent outline-none">
                        <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                <!-- Categories -->
                <div class="glass p-6 rounded-3xl">
                    <h3 class="font-bold text-lg mb-4 text-[--text-color]"><?= __('categories') ?></h3>
                    <div class="space-y-2">
                        <button class="filter-btn active w-full text-left px-4 py-2 rounded-xl text-sm font-semibold transition-all" data-filter="all"><?= __('all_items') ?></button>
                        <button class="filter-btn w-full text-left px-4 py-2 rounded-xl text-sm font-medium hover:bg-[--terracotta]/10 transition-all" data-filter="habesha-kemis"><?= __('habesha_kemis') ?></button>
                        <button class="filter-btn w-full text-left px-4 py-2 rounded-xl text-sm font-medium hover:bg-[--terracotta]/10 transition-all" data-filter="netela"><?= __('netela_shawls') ?></button>
                        <button class="filter-btn w-full text-left px-4 py-2 rounded-xl text-sm font-medium hover:bg-[--terracotta]/10 transition-all" data-filter="gabi"><?= __('gabi_blankets') ?></button>
                        <button class="filter-btn w-full text-left px-4 py-2 rounded-xl text-sm font-medium hover:bg-[--terracotta]/10 transition-all" data-filter="accessories"><?= __('accessories') ?></button>
                    </div>
                </div>

                <!-- Promo Banner -->
                <div class="relative rounded-3xl overflow-hidden aspect-[4/5] group">
                    <img src="images/new5.jpg" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex flex-col justify-end p-6 text-white">
                        <p class="text-xs font-bold tracking-widest mb-2 opacity-80 uppercase"><?= $_SESSION['lang'] === 'am' ? 'የተወሰነ ቅናሽ' : 'Limited Offer' ?></p>
                        <h4 class="text-xl font-bold mb-4"><?= $_SESSION['lang'] === 'am' ? 'የአዲሱ ወቅት ስብስቦች' : 'New Season Arrivals' ?></h4>
                        <a href="#" class="btn-primary py-2 px-4 rounded-lg text-xs text-center"><?= $_SESSION['lang'] === 'am' ? 'አሁን ይግዙ' : 'Shop Now' ?></a>
                    </div>
                </div>
            </aside>

            <!-- Main Grid -->
            <main class="flex-grow">
                <div id="products-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8"></div>
            </main>
        </div>
    </div>
</div>

<!-- Virtual Try On Modal -->
<div class="virtual-try-on fixed inset-0 hidden items-center justify-center bg-black/90 backdrop-blur-md transition-all duration-300" id="virtual-try-on" style="z-index: 9999;">
    <div class="try-on-container glass w-[95%] max-w-5xl h-[85vh] rounded-[2.5rem] p-6 md:p-10 relative flex flex-col">
        <button class="absolute -top-4 -right-4 md:top-6 md:right-6 w-12 h-12 bg-white rounded-full flex items-center justify-center text-gray-900 text-2xl font-bold shadow-2xl border-4 border-black hover:bg-red-500 hover:text-white transition-all z-[10000]" onclick="closeVirtualTryOn()">&times;</button>
        
        <div class="flex flex-col lg:flex-row gap-10 h-full overflow-hidden">
            <!-- Canvas Side -->
            <div class="flex-1 flex flex-col min-h-0">
                <div class="flex-grow bg-slate-900/50 rounded-3xl relative flex items-center justify-center overflow-hidden border border-white/10 group">
                    <canvas id="try-on-canvas" width="500" height="600" class="max-w-full max-h-full object-contain drop-shadow-2xl"></canvas>
                    <div id="canvas-placeholder" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none transition-opacity duration-300">
                        <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mb-4 animate-pulse">
                            <svg class="w-10 h-10 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="text-white/60 font-medium"><?= $_SESSION['lang'] === 'am' ? 'የእርስዎን ፎቶ ያንሱ' : 'Capture your style' ?></p>
                    </div>
                </div>
                <div class="mt-6 flex gap-4 shrink-0">
                    <label class="flex-1 btn-primary py-4 px-6 rounded-2xl text-center font-bold cursor-pointer shadow-xl hover:-translate-y-1 transition-all">
                        <?= $_SESSION['lang'] === 'am' ? 'ፎቶ ይጫኑ' : 'Upload Photo' ?>
                        <input type="file" id="photo-upload" accept="image/*" class="hidden">
                    </label>
                    <button onclick="useDemoModel()" class="flex-1 glass text-[--text-color] py-4 px-6 rounded-2xl font-bold border-2 border-[--terracotta] hover:bg-[--terracotta] hover:text-white transition-all">
                        <?= $_SESSION['lang'] === 'am' ? 'ሞዴል ተጠቀም' : 'Demo Model' ?>
                    </button>
                </div>
            </div>

            <!-- Control Side -->
            <div class="w-full lg:w-80 flex flex-col shrink-0">
                <div class="mb-8">
                    <h3 class="font-display text-3xl font-bold mb-2 text-[--text-color]"><?= $_SESSION['lang'] === 'am' ? 'ትክክለኛ ልክ' : 'Perfect Fit' ?></h3>
                    <p class="text-sm text-gray-500"><?= $_SESSION['lang'] === 'am' ? 'የመረጡትን ልብስ አቀማመጥ ያስተካክሉ::' : 'Fine-tune the placement of your selected attire.' ?></p>
                </div>

                <div class="space-y-10 flex-grow">
                    <div class="space-y-4">
                        <div class="flex justify-between text-sm font-bold uppercase tracking-wider text-gray-400">
                            <span><?= $_SESSION['lang'] === 'am' ? 'መጠን' : 'Scale' ?></span>
                            <span id="scale-val">100%</span>
                        </div>
                        <input type="range" id="scale-slider" min="0.2" max="2.0" step="0.01" value="0.8" class="w-full h-1.5 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer accent-[--terracotta]">
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between text-sm font-bold uppercase tracking-wider text-gray-400">
                            <span><?= $_SESSION['lang'] === 'am' ? 'አቀማመጥ' : 'Position' ?></span>
                            <span id="y-val">Center</span>
                        </div>
                        <input type="range" id="y-slider" min="-100" max="600" step="1" value="150" class="w-full h-1.5 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer accent-[--terracotta]">
                    </div>
                </div>

                <div class="pt-8 border-t border-[--border-color] shrink-0">
                    <button onclick="saveCombination()" class="w-full btn-primary py-4 rounded-2xl font-bold text-lg mb-4 shadow-xl"><?= $_SESSION['lang'] === 'am' ? 'ምስሉን አውርድ' : 'Download Look' ?></button>
                    <p class="text-[10px] text-center text-gray-400 uppercase tracking-widest"><?= $_SESSION['lang'] === 'am' ? 'በ #EthiopianHeritage ያጋሩ' : 'Share with #EthiopianHeritage' ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .filter-btn.active { background: var(--terracotta) !important; color: white !important; box-shadow: 0 4px 12px rgba(198,93,7,0.3); }
</style>

<script>
const products = <?= json_encode(array_values($products)) ?>;
let wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
let currentFilter = 'all';
let searchTerm = '';
const lang = "<?= $_SESSION['lang'] ?>";

const labels = {
    est_value: "<?= __('est_value') ?>",
    try_on: "<?= __('try_on') ?>",
    add_to_cart: "<?= __('add_to_cart') ?>",
    buy_now: "<?= __('buy_now') ?>",
    no_items: "<?= __('wishlist_empty') ?>",
    low: lang === 'am' ? 'ዝቅ ያለ' : 'Low',
    high: lang === 'am' ? 'ከፍ ያለ' : 'High'
};

document.addEventListener('DOMContentLoaded', () => {
    applyFilters();
    initializeFilters();
    initializeSearch();
    initializeVirtualTryOn();
});

function escapeHtml(unsafe) { if (typeof unsafe !== 'string') return unsafe; return unsafe.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;"); }

function renderProducts(productsToRender) {
    const grid = document.getElementById('products-grid');
    grid.innerHTML = '';
    if (productsToRender.length === 0) { grid.innerHTML = `<div class="col-span-full text-center py-20 glass rounded-[3rem]"><p class="text-gray-400 text-xl font-light">${labels.no_items}</p></div>`; return; }
    
    productsToRender.forEach(p => {
        const isInWishlist = wishlist.includes(p.id);
        const safeName = escapeHtml(p.name);
        const safeImage = escapeHtml(p.image);
        const safeRegion = escapeHtml(p.region);
        
        const card = document.createElement('div');
        card.className = 'product-card glass rounded-[2.5rem] overflow-hidden group transition-all duration-500 hover:-translate-y-3';
        card.innerHTML = `
            <div class="relative p-3">
                <div class="relative h-80 rounded-[2rem] overflow-hidden shadow-inner">
                    <a href="product.php?id=${p.id}" class="block h-full">
                        <img src="${safeImage}" alt="${safeName}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                    </a>
                    <button onclick="toggleWishlist(${p.id})" class="absolute top-4 right-4 w-12 h-12 glass rounded-2xl flex items-center justify-center hover:scale-110 transition-all z-10">
                        <svg class="w-6 h-6 ${isInWishlist?'text-red-500 fill-current':'text-white'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                </div>
            </div>
            <div class="p-8 pt-4">
                <div class="mb-4">
                    <a href="product.php?id=${p.id}"><h3 class="font-display text-2xl font-bold text-[--text-color] mb-1 truncate">${safeName}</h3></a>
                    <p class="text-xs font-bold text-[--terracotta] tracking-widest uppercase opacity-80">${safeRegion}</p>
                </div>
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <p class="text-gray-400 text-[10px] uppercase tracking-tighter mb-1">${labels.est_value}</p>
                        <p class="text-2xl font-black text-[--text-color]">ETB ${parseFloat(p.price).toLocaleString()}</p>
                    </div>
                </div>
                <div class="flex flex-col gap-3">
                    <div class="flex gap-3">
                        <button onclick="openVirtualTryOn(${p.id})" class="flex-1 py-3 glass border-2 border-[--border-color] rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-[--text-color] hover:text-[--bg-color] transition-all">${labels.try_on}</button>
                        <button onclick="addToCart(${p.id}, this)" class="flex-1 glass border-2 border-[--terracotta] text-[--terracotta] py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-[--terracotta] hover:text-white transition-all">${labels.add_to_cart}</button>
                    </div>
                    <button onclick="buyNow(${p.id})" class="w-full btn-primary py-3 rounded-xl font-bold text-xs uppercase tracking-widest shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all">${labels.buy_now}</button>
                </div>
            </div>`;
        grid.appendChild(card);
    });
}

function applyFilters() { let filtered = products; if (currentFilter !== 'all') filtered = filtered.filter(p => p.category === currentFilter); if (searchTerm) { const term = searchTerm.toLowerCase(); filtered = filtered.filter(p => p.name.toLowerCase().includes(term) || p.short_desc.toLowerCase().includes(term) || p.long_desc.toLowerCase().includes(term)); } renderProducts(filtered); }
function toggleWishlist(id) { const i = wishlist.indexOf(id); if(i>-1) wishlist.splice(i,1); else wishlist.push(id); localStorage.setItem('wishlist', JSON.stringify(wishlist)); applyFilters(); }
function initializeFilters() { document.querySelectorAll('.filter-btn').forEach(btn => { btn.addEventListener('click', () => { document.querySelectorAll('.filter-btn').forEach(b=>b.classList.remove('active')); btn.classList.add('active'); currentFilter = btn.dataset.filter; applyFilters(); }); }); }
function initializeSearch() { document.getElementById('product-search').addEventListener('input', (e) => { searchTerm = e.target.value.trim(); applyFilters(); }); }

function initializeVirtualTryOn() {
    const canvas = document.getElementById('try-on-canvas');
    const ctx = canvas.getContext('2d');
    document.getElementById('scale-slider').addEventListener('input', (e) => { outfitScale = parseFloat(e.target.value); document.getElementById('scale-val').textContent = Math.round(outfitScale*100)+'%'; drawCanvas(); });
    document.getElementById('y-slider').addEventListener('input', (e) => { outfitY = parseFloat(e.target.value); document.getElementById('y-val').textContent = outfitY > 150 ? labels.low : labels.high; drawCanvas(); });
    document.getElementById('photo-upload').addEventListener('change', e => {
        const file = e.target.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = e => {
                const img = new Image();
                img.onload = () => { userImage = img; document.getElementById('canvas-placeholder').style.opacity = '0'; drawCanvas(); };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
}

let userImage = null, currentOutfitImage = null, outfitScale = 0.8, outfitY = 150;
function useDemoModel() { const img = new Image(); img.crossOrigin = "Anonymous"; img.onload = () => { userImage = img; document.getElementById('canvas-placeholder').style.opacity = '0'; drawCanvas(); }; img.src = "images/Selam_Tesfaye_5000x.webp"; }
function openVirtualTryOn(productId) { const product = products.find(p => p.id === productId); if (!product) return; document.getElementById('virtual-try-on').classList.remove('hidden'); document.getElementById('virtual-try-on').classList.add('flex'); document.body.style.overflow='hidden'; const img = new Image(); img.onload = () => { currentOutfitImage = img; drawCanvas(); }; img.src = product.image; }
function closeVirtualTryOn() { document.getElementById('virtual-try-on').classList.add('hidden'); document.getElementById('virtual-try-on').classList.remove('flex'); document.body.style.overflow='auto'; }
function drawCanvas() {
    const canvas = document.getElementById('try-on-canvas'); const ctx = canvas.getContext('2d'); ctx.clearRect(0, 0, canvas.width, canvas.height);
    if (userImage) { const ratio = Math.max(canvas.width / userImage.width, canvas.height / userImage.height); const cx = (canvas.width - userImage.width * ratio) / 2; const cy = (canvas.height - userImage.height * ratio) / 2; ctx.drawImage(userImage, 0, 0, userImage.width, userImage.height, cx, cy, userImage.width * ratio, userImage.height * ratio); }
    else { ctx.fillStyle = '#0f172a'; ctx.fillRect(0, 0, canvas.width, canvas.height); }
    if (currentOutfitImage) { const w = 350 * outfitScale; const h = (currentOutfitImage.height / currentOutfitImage.width) * w; const x = (canvas.width - w) / 2; ctx.shadowColor = "rgba(0,0,0,0.5)"; ctx.shadowBlur = 20; ctx.globalAlpha = 0.95; ctx.drawImage(currentOutfitImage, x, outfitY, w, h); ctx.globalAlpha = 1.0; ctx.shadowBlur = 0; }
}
function saveCombination(){ const link = document.createElement('a'); link.download = 'my-ethiopian-look.png'; link.href = document.getElementById('try-on-canvas').toDataURL(); link.click(); }
function addToCart(id,btn){
    const original=btn.innerHTML; btn.innerHTML='...'; btn.disabled=true;
    const fd=new FormData(); fd.append('product_id',id);
    fetch('add_to_cart_ajax.php',{method:'POST',body:fd}).then(r=>r.json()).then(d=>{
        if(d.success){ if (typeof updateCartBadge === 'function') updateCartBadge(d.totalItems); btn.innerHTML='✓'; setTimeout(()=>{btn.innerHTML=original; btn.disabled=false;},1500); }
    });
}
function buyNow(id) { const fd = new FormData(); fd.append('product_id', id); fetch('add_to_cart_ajax.php', { method: 'POST', body: fd }).then(r => r.json()).then(d => { if(d.success) window.location.href = 'checkout.php'; }); }
</script>
<?php include 'footer.php'; ?>
</body>
</html>