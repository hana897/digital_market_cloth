<?php
session_start();
$title = "Contact Us - Ethiopian Heritage";
include 'header.php'; 
?>

<main class="pt-24 pb-16 min-h-screen">
    <section class="text-center mb-12 px-4">
        <h1 class="font-display text-5xl font-bold cultural-gradient mb-3"><?= __('contact_us') ?></h1>
        <p class="text-gray-600 max-w-2xl mx-auto text-lg"><?= __('contact_desc') ?></p>
    </section>

    <section class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 px-4">
        <!-- Phone -->
        <div class="glass rounded-[2rem] p-8 text-center hover:-translate-y-1 transition duration-300">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-amber-100 rounded-full mb-4 text-amber-800"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
            <h3 class="font-display text-xl font-bold mb-2 text-[--text-color]"><?= __('phone') ?></h3>
            <p class="text-gray-600 font-medium">+251 9 12 34 56 78</p>
            <p class="text-gray-500 text-sm mt-1"><?= __('mon_fri') ?></p>
        </div>
        <!-- Email -->
        <div class="glass rounded-[2rem] p-8 text-center hover:-translate-y-1 transition duration-300">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-amber-100 rounded-full mb-4 text-amber-800"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
            <h3 class="font-display text-xl font-bold mb-2 text-[--text-color]"><?= __('email') ?></h3>
            <p class="text-gray-600 font-medium">info@ethiopianheritage.com</p>
            <p class="text-gray-500 text-sm mt-1"><?= __('support_24') ?></p>
        </div>
        <!-- Location -->
        <div class="glass rounded-[2rem] p-8 text-center hover:-translate-y-1 transition duration-300">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-amber-100 rounded-full mb-4 text-amber-800"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
            <h3 class="font-display text-xl font-bold mb-2 text-[--text-color]"><?= __('location') ?></h3>
            <p class="text-gray-600 font-medium"><?= $_SESSION['lang'] === 'am' ? 'አዲስ አበባ፣ ኢትዮጵያ' : 'Addis Ababa, Ethiopia' ?></p>
            <p class="text-gray-500 text-sm mt-1"><?= $_SESSION['lang'] === 'am' ? 'ቦሌ መንገድ፣ ፍሬንድሺፕ ሞል' : 'Bole Road, Friendship Mall' ?></p>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>
