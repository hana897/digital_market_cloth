<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$totalItems = 0;
if (isset($_SESSION['cart'])) {
    $totalItems = array_sum($_SESSION['cart']);
}
$currentLang = $_SESSION['lang'] ?? 'en';
?>
<nav class="fixed top-0 w-full glass-nav z-50 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="index.php" class="font-display text-xl md:text-2xl font-bold cultural-gradient">
                Ethiopian Heritage
            </a>
            
            <div class="hidden lg:flex space-x-6 items-center">
                <a href="index.php" class="nav-link text-gray-700 hover:text-terracotta font-semibold text-sm uppercase tracking-wider transition-colors"><?= __('home') ?></a>
                <a href="products.php" class="nav-link text-gray-700 hover:text-terracotta font-semibold text-sm uppercase tracking-wider transition-colors"><?= __('products') ?></a>
                <a href="culture.php" class="nav-link text-gray-700 hover:text-terracotta font-semibold text-sm uppercase tracking-wider transition-colors"><?= __('culture') ?></a>
                <a href="favorites.php" class="nav-link text-gray-700 hover:text-terracotta font-semibold text-sm uppercase tracking-wider transition-colors"><?= __('favorites') ?></a>
                
                <!-- Theme Toggle -->
                <button onclick="toggleTheme()" class="p-2 glass rounded-xl text-gray-700 hover:text-[--terracotta] transition-all" title="Toggle Theme">
                    <svg id="theme-icon-sun" class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.364 17.636l-.707.707M6.364 6.364l.707-.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path></svg>
                    <svg id="theme-icon-moon" class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </button>

                <!-- Language Switcher -->
                <div class="flex glass rounded-xl overflow-hidden p-1">
                    <a href="?lang=en" class="px-2 py-1 text-[10px] font-bold <?= $currentLang === 'en' ? 'bg-[--terracotta] text-white rounded-lg' : 'text-gray-500' ?>">EN</a>
                    <a href="?lang=am" class="px-2 py-1 text-[10px] font-bold <?= $currentLang === 'am' ? 'bg-[--terracotta] text-white rounded-lg' : 'text-gray-500' ?>">አማ</a>
                </div>

                <a href="cart.php" class="relative p-2 group">
                    <div class="p-2 glass rounded-xl group-hover:bg-[--terracotta] group-hover:text-white transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <span id="cart-count" class="absolute -top-1 -right-1 bg-[--terracotta] text-white text-[10px] font-black rounded-full h-5 w-5 flex items-center justify-center border-2 border-[--bg-color] shadow-sm transition-transform duration-300 <?= $totalItems > 0 ? 'scale-100' : 'scale-0' ?>">
                        <?= $totalItems ?>
                    </span>
                </a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="settings.php" class="nav-link text-gray-700 hover:text-terracotta font-semibold text-sm uppercase tracking-wider"><?= __('settings') ?></a>
                    <a href="logout.php" class="text-red-500 font-bold text-sm uppercase tracking-wider hover:text-red-600"><?= __('logout') ?></a>
                <?php else: ?>
                    <a href="login.php" class="btn-primary px-6 py-2 rounded-xl text-xs font-bold uppercase tracking-widest"><?= __('login') ?></a>
                <?php endif; ?>
            </div>

            <!-- Mobile Controls -->
            <div class="lg:hidden flex items-center gap-2">
                <button onclick="toggleTheme()" class="p-2 glass rounded-xl text-gray-700">
                    <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.364 17.636l-.707.707M6.364 6.364l.707-.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path></svg>
                </button>
                <a href="cart.php" class="relative p-2">
                    <div class="p-2 glass rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <span id="mobile-cart-count" class="absolute -top-1 -right-1 bg-[--terracotta] text-white text-[10px] font-black rounded-full h-5 w-5 flex items-center justify-center border-2 border-[--bg-color] shadow-sm transition-transform duration-300 <?= $totalItems > 0 ? 'scale-100' : 'scale-0' ?>">
                        <?= $totalItems ?>
                    </span>
                </a>
                <button id="mobile-menu-button" onclick="toggleMobileMenu()" class="p-2 glass rounded-xl text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden lg:hidden glass backdrop-blur-xl border-t border-[--border-color] animate-fade-in transition-all">
        <div class="p-6 space-y-4 bg-[--card-bg]">
            <div class="flex justify-between items-center pb-4 border-b border-[--border-color]">
                <span class="text-xs font-bold uppercase tracking-widest text-gray-400">Language</span>
                <div class="flex glass rounded-xl overflow-hidden p-1">
                    <a href="?lang=en" class="px-4 py-2 text-xs font-bold <?= $currentLang === 'en' ? 'bg-[--terracotta] text-white rounded-lg' : 'text-gray-500' ?>">English</a>
                    <a href="?lang=am" class="px-4 py-2 text-xs font-bold <?= $currentLang === 'am' ? 'bg-[--terracotta] text-white rounded-lg' : 'text-gray-500' ?>">አማርኛ</a>
                </div>
            </div>
            <a href="index.php" class="block py-2 text-lg font-display font-bold text-[--text-color]"><?= __('home') ?></a>
            <a href="products.php" class="block py-2 text-lg font-display font-bold text-[--text-color]"><?= __('products') ?></a>
            <a href="culture.php" class="block py-2 text-lg font-display font-bold text-[--text-color]"><?= __('culture') ?></a>
            <a href="favorites.php" class="block py-2 text-lg font-display font-bold text-[--text-color]"><?= __('favorites') ?></a>
            <a href="contact.php" class="block py-2 text-lg font-display font-bold text-[--text-color]"><?= __('contact') ?></a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="settings.php" class="block py-2 text-lg font-display font-bold text-[--text-color]"><?= __('settings') ?></a>
                <a href="logout.php" class="block py-2 text-lg font-display font-bold text-red-500"><?= __('logout') ?></a>
            <?php else: ?>
                <a href="login.php" class="block btn-primary py-4 rounded-2xl text-center font-bold uppercase tracking-widest"><?= __('login') ?></a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
    function toggleTheme() {
        const isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        // Icon toggle logic if needed, but Tailwind 'dark:block' handles it
    }

    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }

    function updateCartBadge(count) {
        const desktopBadge = document.getElementById('cart-count');
        const mobileBadge = document.getElementById('mobile-cart-count');
        [desktopBadge, mobileBadge].forEach(badge => {
            if (!badge) return;
            badge.textContent = count;
            if (count > 0) {
                badge.classList.remove('scale-0');
                badge.classList.add('scale-100', 'animate-bounce');
                setTimeout(() => badge.classList.remove('animate-bounce'), 1000);
            } else {
                badge.classList.remove('scale-100');
                badge.classList.add('scale-0');
            }
        });
    }

    // Re-attach button listener just in case
    document.getElementById('mobile-menu-button')?.addEventListener('click', toggleMobileMenu);
</script>