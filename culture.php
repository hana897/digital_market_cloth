<?php 
$title = "Culture - Ethiopian Heritage";
include 'header.php'; 
?>

<div class="min-h-screen pt-20">
    <!-- Hero Header -->
    <header class="py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-[--terracotta]/10 to-transparent"></div>
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-[--terracotta]/5 to-transparent skew-x-12"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <span class="text-[--terracotta] font-bold tracking-[0.2em] uppercase text-sm mb-4 block animate-fade-in-up"><?= $_SESSION['lang'] === 'am' ? 'ቅርስ እና ታሪክ' : 'Heritage & History' ?></span>
            <h1 class="font-display text-5xl md:text-7xl font-bold mb-6 cultural-gradient drop-shadow-sm animate-fade-in-up delay-100">
                <?= __('culture_hero') ?>
            </h1>
            <p class="text-xl text-gray-500 max-w-3xl mx-auto font-light leading-relaxed animate-fade-in-up delay-200">
                <?= __('culture_desc') ?>
            </p>
        </div>
    </header>

    <!-- Timeline Section -->
    <section class="py-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-center font-display text-4xl font-bold mb-16 text-[--text-color]"><?= __('journey_time') ?></h2>
            
            <div class="relative">
                <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-px bg-gradient-to-b from-transparent via-[--terracotta] to-transparent opacity-30 hidden md:block"></div>

                <div class="space-y-12 md:space-y-24">
                    <!-- Item 1 -->
                    <div class="relative flex flex-col md:flex-row items-center justify-between group">
                        <div class="order-1 w-full md:w-5/12"></div>
                        <div class="z-20 flex items-center justify-center order-1 w-12 h-12 rounded-full glass border-2 border-[--terracotta] shadow-[0_0_20px_rgba(198,93,7,0.3)] bg-[--card-bg]">
                            <span class="font-bold text-[--terracotta]">1</span>
                        </div>
                        <div class="order-1 w-full md:w-5/12 glass p-8 rounded-3xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-white/10 mt-6 md:mt-0">
                            <span class="text-sm font-bold text-[--terracotta] mb-2 block"><?= $_SESSION['lang'] === 'am' ? 'ከክርስቶስ ልደት በኋላ ፬ኛው - ፯ኛው ክፍለ ዘመን' : '4th - 7th Century CE' ?></span>
                            <h3 class="font-display text-2xl font-bold mb-3 text-[--text-color]"><?= $_SESSION['lang'] === 'am' ? 'ጥንታዊ አመጣጥ' : 'Ancient Origins' ?></h3>
                            <p class="text-gray-500 leading-relaxed"><?= $_SESSION['lang'] === 'am' ? 'የአርኪዮሎጂ መረጃዎች እንደሚያሳዩት የኢትዮጵያ የሽመና ጥበብ ከ፪ሺህ ዓመታት በላይ ያስቆጠረ ሲሆን በጥንታዊው የአክሱም መንግሥት ውስጥ የተራቀቁ መጋዘኖች ተገኝተዋል።' : 'Archaeological evidence suggests Ethiopian weaving traditions date back over 2,000 years, with sophisticated looms found in the ancient Kingdom of Aksum.' ?></p>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="relative flex flex-col md:flex-row-reverse items-center justify-between group">
                        <div class="order-1 w-full md:w-5/12"></div>
                        <div class="z-20 flex items-center justify-center order-1 w-12 h-12 rounded-full glass border-2 border-[--terracotta] shadow-[0_0_20px_rgba(198,93,7,0.3)] bg-[--card-bg]">
                            <span class="font-bold text-[--terracotta]">2</span>
                        </div>
                        <div class="order-1 w-full md:w-5/12 glass p-8 rounded-3xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-white/10 mt-6 md:mt-0">
                            <span class="text-sm font-bold text-[--terracotta] mb-2 block"><?= $_SESSION['lang'] === 'am' ? '፲፯ኛው - ፲፱ኛው ክፍለ ዘመን' : '17th - 19th Century' ?></span>
                            <h3 class="font-display text-2xl font-bold mb-3 text-[--text-color]"><?= $_SESSION['lang'] === 'am' ? 'የንጉሠ ነገሥቱ ዘመን' : 'Imperial Era' ?></h3>
                            <p class="text-gray-500 leading-relaxed"><?= $_SESSION['lang'] === 'am' ? 'የንጉሣውያን ቤተ መንግሥቶች የጨርቃ ጨርቅ ፈጠራ ማዕከላት ሆኑ። ዋና ሸማኔዎች ለመኳንንት የተራቀቁ ልብሶችን በመሥራት ማዕረግን የሚገልጹ የየክልል የአሠራር ጥበቦችን አዳብረዋል።' : 'Royal courts became centers of textile innovation. Master weavers created elaborate garments for nobility, developing signature regional styles that defined status.' ?></p>
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="relative flex flex-col md:flex-row items-center justify-between group">
                        <div class="order-1 w-full md:w-5/12"></div>
                        <div class="z-20 flex items-center justify-center order-1 w-12 h-12 rounded-full glass border-2 border-[--terracotta] shadow-[0_0_20px_rgba(198,93,7,0.3)] bg-[--card-bg]">
                            <span class="font-bold text-[--terracotta]">3</span>
                        </div>
                        <div class="order-1 w-full md:w-5/12 glass p-8 rounded-3xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-white/10 mt-6 md:mt-0">
                            <span class="text-sm font-bold text-[--terracotta] mb-2 block"><?= $_SESSION['lang'] === 'am' ? '፳፩ኛው ክፍለ ዘመን' : '21st Century' ?></span>
                            <h3 class="font-display text-2xl font-bold mb-3 text-[--text-color]"><?= $_SESSION['lang'] === 'am' ? 'ዘመናዊ ህዳሴ' : 'Modern Renaissance' ?></h3>
                            <p class="text-gray-500 leading-relaxed"><?= $_SESSION['lang'] === 'am' ? 'ዘመናዊ ዲዛይነሮች ባህላዊ ጥበቦችን ከዘመናዊ ውበት ጋር በማዋሃድ የኢትዮጵያን ጨርቃ ጨርቅ ለዓለም አቀፍ የፋሽን ገበያ በማቅረብ ላይ ናቸው።' : 'Contemporary designers blend traditional techniques with modern aesthetics, bringing Ethiopian textiles to global fashion markets while preserving cultural authenticity.' ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Regional Grid -->
    <section class="py-24 bg-[--bg-color] relative">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h2 class="text-center font-display text-4xl font-bold mb-4 text-[--text-color]"><?= __('regional_trad') ?></h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
                <!-- Card 1 -->
                <div class="glass rounded-[2rem] overflow-hidden group hover:shadow-2xl transition-all duration-500">
                    <div class="h-64 overflow-hidden relative">
                        <img src="images/image1.webp" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute bottom-6 left-6 z-20"><h3 class="font-display text-2xl font-bold text-white"><?= $_SESSION['lang'] === 'am' ? 'ሸዋ እና አማራ' : 'Shewa & Amhara' ?></h3></div>
                    </div>
                    <div class="p-8"><p class="text-gray-500 text-sm"><?= $_SESSION['lang'] === 'am' ? 'በታዋቂው የጥበብ ጥልፍ የሚታወቁት እነዚህ አካባቢዎች በነጭ የጥጥ ልብሶች ላይ የሚሠሩት ውስብስብ ጥለቶች የጥበብ እና የእምነት መገለጫዎች ናቸው::' : 'Home to the famous "tibeb" embroidery. The intricate borders on white cotton garments are a signature of this region.' ?></p></div>
                </div>
                <!-- Card 2 -->
                <div class="glass rounded-[2rem] overflow-hidden group hover:shadow-2xl transition-all duration-500 transform md:-translate-y-8">
                    <div class="h-64 overflow-hidden relative">
                        <img src="images/image3.webp" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute bottom-6 left-6 z-20"><h3 class="font-display text-2xl font-bold text-white"><?= $_SESSION['lang'] === 'am' ? 'ትግራይ' : 'Tigray' ?></h3></div>
                    </div>
                    <div class="p-8"><p class="text-gray-500 text-sm"><?= $_SESSION['lang'] === 'am' ? 'በቀጭን የጥጥ ጨርቆች የታወቁ ናቸው:: በትግራይ ልብሶች ላይ የሚታዩት የወርቅ እና የብር ክሮች ረጅም የንግድ እና የእደ ጥበብ ታሪክን ያንፀባርቃሉ::' : 'Renowned for fine, translucent cotton fabrics. The intricate gold and silver threading reflects a rich history of trade.' ?></p></div>
                </div>
                <!-- Card 3 -->
                <div class="glass rounded-[2rem] overflow-hidden group hover:shadow-2xl transition-all duration-500">
                    <div class="h-64 overflow-hidden relative">
                        <img src="images/images5.jpg" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute bottom-6 left-6 z-20"><h3 class="font-display text-2xl font-bold text-white"><?= $_SESSION['lang'] === 'am' ? 'ዶርዜ እና ደቡብ' : 'Dorze & South' ?></h3></div>
                    </div>
                    <div class="p-8"><p class="text-gray-500 text-sm"><?= $_SESSION['lang'] === 'am' ? 'በደመቀው የዶርዜ ሽመና የታወቁ ናቸው:: የጂኦሜትሪክ ጥለቶች እና ደማቅ ቀለሞች በአፍሪካ ውስጥ በጣም አስደናቂ ከሆኑ ጨርቃ ጨርቆች መካከል ይጠቀሳሉ::' : 'Famous for vibrant Dorze weaving. Their geometric patterns and bold colors create striking textiles.' ?></p></div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-center font-display text-4xl font-bold mb-16 text-[--text-color]"><?= __('gallery_life') ?></h2>
            <div class="columns-1 sm:columns-2 lg:columns-3 gap-8 space-y-8">
                <div class="glass rounded-2xl overflow-hidden break-inside-avoid shadow-sm hover:shadow-xl transition-all duration-300"><img src="images/new1.jpg" class="w-full h-auto"></div>
                <div class="glass rounded-2xl overflow-hidden break-inside-avoid shadow-sm hover:shadow-xl transition-all duration-300"><img src="images/new7.jpg" class="w-full h-auto"></div>
                <div class="glass rounded-2xl overflow-hidden break-inside-avoid shadow-sm hover:shadow-xl transition-all duration-300"><img src="images/new8.jpg" class="w-full h-auto"></div>
                <div class="glass rounded-2xl overflow-hidden break-inside-avoid shadow-sm hover:shadow-xl transition-all duration-300"><img src="images/new3.jpg" class="w-full h-auto"></div>
                <div class="glass rounded-2xl overflow-hidden break-inside-avoid shadow-sm hover:shadow-xl transition-all duration-300"><img src="images/new5.jpg" class="w-full h-auto"></div>
                <div class="glass rounded-2xl overflow-hidden break-inside-avoid shadow-sm hover:shadow-xl transition-all duration-300"><img src="images/images6.png" class="w-full h-auto"></div>
            </div>
        </div>
    </section>
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
</style>

<?php include 'footer.php'; ?>
