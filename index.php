<?php 
$title = "Ethiopian Traditional Clothing - A New Look";
include 'header.php'; 
include 'data.php';
?>

<style>
    .ken-burns-container {
        position: absolute;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .ken-burns-image {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0;
        transform: scale(1.1);
        transition: opacity 2s ease-in-out, transform 10s linear;
    }

    .ken-burns-image.active {
        opacity: 1;
        transform: scale(1);
    }
    
    .hero-text-shadow {
        text-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
</style>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center overflow-hidden bg-[#050505]">
        <!-- Ken Burns Background with Vignette -->
        <div class="ken-burns-container opacity-60">
            <img src="images/image1.webp" class="ken-burns-image active" alt="Ethiopian Traditional Clothing">
            <img src="images/image3.webp" class="ken-burns-image" alt="Ethiopian Traditional Clothing">
            <img src="images/images4.jpg" class="ken-burns-image" alt="Ethiopian Traditional Clothing">
            <img src="images/images5.jpg" class="ken-burns-image" alt="Ethiopian Traditional Clothing">
            <img src="images/images6.png" class="ken-burns-image" alt="Ethiopian Traditional Clothing">
        </div>
        
        <div class="absolute inset-0 bg-gradient-to-r from-black via-black/40 to-transparent z-10"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_transparent_0%,_black_100%)] z-10 opacity-60"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-30">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                
                <!-- Left: Editorial Content -->
                <div class="space-y-8 animate-fade-in-up">
                    <div class="inline-flex items-center gap-3 px-4 py-2 bg-[--terracotta]/10 border border-[--terracotta]/20 rounded-full backdrop-blur-md">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[--terracotta] opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-[--terracotta]"></span>
                        </span>
                        <span class="text-[--terracotta] text-[10px] font-black tracking-[0.4em] uppercase">
                            <?= $_SESSION['lang'] === 'am' ? 'የ፳፻፲፯ አዲስ ስብስብ' : 'NEW SEASON 2025' ?>
                        </span>
                    </div>

                    <h1 class="font-display text-5xl md:text-7xl font-bold text-white leading-[1.1] tracking-tighter">
                        <?= str_replace(['Soul', 'በነፍስ'], ['<span class="cultural-gradient block italic py-2">Soul</span>', '<span class="cultural-gradient block italic py-2">በነፍስ</span>'], __('hero_title')) ?>
                    </h1>

                    <div class="max-w-md">
                        <p class="text-lg md:text-xl text-gray-200 font-light leading-relaxed mb-10 hero-text-shadow">
                            <?= __('hero_subtitle') ?>
                        </p>
                        
                        <div class="flex flex-wrap gap-6 items-center">
                            <a href="products.php" class="btn-primary px-10 py-4 rounded-full font-bold text-sm tracking-widest uppercase shadow-lg hover:-translate-y-1 transition-all active:scale-95">
                                <?= __('explore') ?>
                            </a>
                            <a href="culture.php" class="group flex items-center gap-4 text-white hover:text-[--terracotta-light] transition-colors font-bold tracking-widest text-xs uppercase">
                                <span class="w-12 h-12 rounded-full border border-white/40 flex items-center justify-center group-hover:border-[--terracotta] group-hover:bg-[--terracotta]/20 transition-all">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M6 4l10 6-10 6V4z"/></svg>
                                </span>
                                <?= __('our_story') ?>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right: Floating Showcase Card -->
                <div class="hidden lg:block relative h-[500px] animate-float">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <!-- Layered glass circles -->
                        <div class="absolute w-80 h-80 rounded-full border border-white/5 bg-white/[0.02] backdrop-blur-3xl animate-pulse"></div>
                        
                        <!-- Main Preview Card -->
                        <div class="relative glass w-64 aspect-[3/4] rounded-[2.5rem] overflow-hidden border-white/20 shadow-2xl rotate-3 hover:rotate-0 transition-transform duration-700">
                            <img src="images/image1.webp" class="w-full h-full object-cover opacity-80" alt="Featured">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                            <div class="absolute bottom-8 left-8 right-8">
                                <p class="text-[--terracotta-light] text-[10px] font-bold tracking-widest mb-1 uppercase">Top Pick</p>
                                <h4 class="text-white font-display text-xl font-bold">Classic Kemis</h4>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Animated Bottom Transition -->
        <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-[--bg-color] to-transparent z-10"></div>
    </section>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 1.2s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(1deg); }
        }
        .animate-float {
            animation: float 8s ease-in-out infinite;
        }
    </style>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
    </style>

    <!-- Featured Products -->
    <section class="py-24 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(ellipse_at_top,_var(--terracotta)_0%,_transparent_20%)] opacity-5"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <h2 class="font-display text-4xl md:text-5xl font-bold mb-4 cultural-gradient"><?= __('featured_pieces') ?></h2>
                <p class="text-gray-500 text-lg"><?= $_SESSION['lang'] === 'am' ? 'ለእርስዎ ብቻ የተመረጡ ምርጥ ስራዎች።' : 'Handpicked selections just for you.' ?></p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php 
                $featured = array_slice($products, 0, 4);
                foreach($featured as $index => $product): 
                ?>
                <div class="group relative">
                    <div class="glass rounded-3xl overflow-hidden h-full hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-[--border-color]">
                        <div class="relative overflow-hidden aspect-[3/4]">
                            <?php if ($index === 0): ?>
                                <span class="absolute top-4 left-4 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full z-20 shadow-md"><?= __('new_arrival') ?></span>
                            <?php endif; ?>
                            
                            <a href="product.php?id=<?= $product['id'] ?>">
                                <img src="<?= htmlspecialchars($product['image']) ?>" 
                                     alt="<?= htmlspecialchars($product['name']) ?>" 
                                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                            </a>
                            
                            <!-- Hover Action -->
                            <div class="absolute bottom-4 left-4 right-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                <a href="product.php?id=<?= $product['id'] ?>" class="btn-primary w-full py-3 rounded-xl font-bold text-center block shadow-lg">
                                    <?= __('view_details') ?>
                                </a>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <h3 class="font-display text-xl font-bold mb-1 text-[--text-color] truncate">
                                <a href="product.php?id=<?= $product['id'] ?>" class="hover:text-[--terracotta] transition-colors">
                                    <?= htmlspecialchars($product['name']) ?> 
                                </a>
                            </h3>
                            <p class="text-gray-500 text-sm mb-3"><?= htmlspecialchars($product['region']) ?></p>
                            <div class="flex justify-between items-center">
                                <p class="text-xl font-bold text-[--terracotta]">ETB <?= number_format($product['price']) ?></p>
                                <button class="text-gray-400 hover:text-red-500 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center mt-16">
                <a href="products.php" class="inline-flex items-center gap-2 text-[--terracotta] font-bold text-lg hover:gap-4 transition-all">
                    <?= __('view_all') ?> 
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Cultural Significance -->
    <section class="py-24">
        <div class="container mx-auto px-4">
            <div class="glass bg-[--card-bg] rounded-[3rem] p-8 md:p-16 relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23000000\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                
                <div class="grid md:grid-cols-2 gap-12 items-center relative z-10">
                    <div class="space-y-8">
                        <span class="text-[--terracotta] font-black tracking-widest uppercase text-xs"><?= $_SESSION['lang'] === 'am' ? 'የእኛ ቅርስ' : 'Our Heritage' ?></span>
                        <h2 class="font-display text-4xl md:text-5xl font-bold mb-6 text-[--text-color] leading-tight"><?= __('heritage_title') ?></h2>
                        <p class="text-lg text-[--text-color] opacity-90 leading-relaxed font-light">
                            <?= __('heritage_desc') ?>
                        </p>
                        
                        <div class="grid grid-cols-2 gap-6 pt-4">
                            <div>
                                <h4 class="font-bold text-3xl text-[--terracotta] mb-1">100%</h4>
                                <p class="text-xs font-bold uppercase tracking-wider text-[--text-color] opacity-60"><?= __('handwoven_cotton') ?></p>
                            </div>
                            <div>
                                <h4 class="font-bold text-3xl text-[--terracotta] mb-1">50+</h4>
                                <p class="text-xs font-bold uppercase tracking-wider text-[--text-color] opacity-60"><?= __('artisan_weavers') ?></p>
                            </div>
                        </div>
                        
                        <a href="culture.php" class="btn-primary px-10 py-4 rounded-2xl font-bold inline-block shadow-xl hover:shadow-2xl transition-all hover:-translate-y-1 mt-4">
                            <?= __('discover_story') ?>
                        </a>
                    </div>
                    
                    <div class="relative group">
                        <div class="absolute -inset-4 bg-[--terracotta] rounded-full blur-3xl opacity-10 group-hover:opacity-20 transition-opacity"></div>
                        <img src="images/images6.png" alt="Artisan weaving" class="relative rounded-3xl shadow-2xl transform rotate-2 group-hover:rotate-0 transition-transform duration-1000 w-full object-cover aspect-square">
                    </div>
                </div>
            </div>
        </div>
    </section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kenBurnsImages = document.querySelectorAll('.ken-burns-image');
    let currentImageIndex = 0;

    function showNextImage() {
        if(kenBurnsImages.length > 0) {
            kenBurnsImages[currentImageIndex].classList.remove('active');
            currentImageIndex = (currentImageIndex + 1) % kenBurnsImages.length;
            kenBurnsImages[currentImageIndex].classList.add('active');
        }
    }

    if(kenBurnsImages.length > 0) setInterval(showNextImage, 6000);
});
</script>

<?php include 'footer.php'; ?>
