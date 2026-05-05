<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set default language
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

// Handle language change
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    if (in_array($lang, ['en', 'am'])) {
        $_SESSION['lang'] = $lang;
    }
}

$translations = [
    'en' => [
        // Nav
        'home' => 'Home',
        'products' => 'Products',
        'culture' => 'Culture',
        'favorites' => 'Favorites',
        'contact' => 'Contact',
        'settings' => 'Settings',
        'logout' => 'Logout',
        'login' => 'Login',
        
        // Home
        'hero_title' => 'Woven with Soul',
        'hero_subtitle' => 'Experience the timeless elegance of Ethiopian craftsmanship.',
        'explore' => 'Explore the Collection',
        'our_story' => 'Our Story',
        'featured_pieces' => 'Featured Pieces',
        'new_arrival' => 'NEW ARRIVAL',
        'view_details' => 'View Details',
        'view_all' => 'View All Products',
        'heritage_title' => 'A Legacy in Every Thread',
        'heritage_desc' => 'More than just clothing, our garments are a celebration of Ethiopian heritage. Each piece is meticulously handcrafted by skilled artisans.',
        'discover_story' => 'Discover the Story',
        'handwoven_cotton' => 'Handwoven Cotton',
        'artisan_weavers' => 'Artisan Weavers',
        
        // Products Listing
        'discover_auth' => 'Discover Authenticity',
        'explore_curated' => 'Explore our curated collection of handwoven Ethiopian textiles, where tradition meets contemporary elegance.',
        'search' => 'Search',
        'search_placeholder' => 'Looking for...',
        'categories' => 'Categories',
        'all_items' => 'All Items',
        'habesha_kemis' => 'Habesha Kemis',
        'netela_shawls' => 'Netela Shawls',
        'gabi_blankets' => 'Gabi Blankets',
        'accessories' => 'Accessories',
        'custom_orders' => 'Custom Orders',
        'try_on' => 'Try On',
        'add_to_cart' => 'Add to Cart',
        'buy_now' => 'Buy Now',
        'est_value' => 'Estimated Value',
        
        // Product Detail
        'in_stock' => 'In Stock',
        'ships_worldwide' => 'Ships Worldwide',
        'quantity' => 'Quantity',
        'auth_quality' => 'Authentic Quality',
        'secure_payment' => 'Secure Payment',
        'also_like' => 'You May Also Like',
        'view' => 'View',
        
        // Culture
        'culture_hero' => 'Threads of Tradition',
        'culture_desc' => 'Explore the rich tapestry of Ethiopian textile history, where every pattern tells a story and every garment carries centuries of wisdom.',
        'journey_time' => 'A Journey Through Time',
        'regional_trad' => 'Regional Traditions',
        'gallery_life' => 'Gallery of Life',
        
        // Favorites
        'my_favorites' => 'My Favorites',
        'fav_desc' => 'Your curated collection of styles. Save them for later or make them yours today.',
        'clear_all' => 'Clear All',
        'wishlist_empty' => 'Your Wishlist is Empty',
        'wishlist_empty_desc' => 'Start exploring our collection and save the items that speak to your soul.',
        'browse_coll' => 'Browse Collection',
        
        // Contact
        'contact_us' => 'Contact Us',
        'contact_desc' => 'We would love to hear from you. Reach us using the details below or visit our store.',
        'phone' => 'Phone',
        'email' => 'Email',
        'location' => 'Location',
        'support_24' => 'Online support 24/7',
        'mon_fri' => 'Mon-Fri 9am to 6pm',
        
        // Settings
        'account_settings' => 'Account Settings',
        'settings_desc' => 'Manage your profile, secure your account, and top up your digital wallet.',
        'wallet_funds' => 'Wallet & Funds',
        'security' => 'Security',
        'appearance' => 'Appearance',
        'avail_balance' => 'Available Balance',
        'refill_funds' => 'Refill Funds',
        'amount' => 'Amount',
        'method' => 'Method',
        'complete_dep' => 'Complete Deposit',
        'privacy_sec' => 'Privacy & Security',
        'curr_pass' => 'Current Password',
        'new_pass' => 'New Password',
        'conf_new' => 'Confirm New',
        'update_cred' => 'Update Credentials',
        'interface_set' => 'Interface Settings',
        'dark_mode_exp' => 'Dark Mode Experience',
        'dark_mode_desc' => 'Toggle between light and atmospheric dark themes.'
    ],
    'am' => [
        // Nav
        'home' => 'መነሻ',
        'products' => 'ምርቶች',
        'culture' => 'ባህል',
        'favorites' => 'ተወዳጆች',
        'contact' => 'እውቂያ',
        'settings' => 'ቅንብሮች',
        'logout' => 'ውጣ',
        'login' => 'ግባ',
        
        // Home
        'hero_title' => 'በነፍስ የተሸመነ',
        'hero_subtitle' => 'የኢትዮጵያን ጥበብ ዘላለማዊ ውበት ይለማመዱ።',
        'explore' => 'ስብስቡን ያስሱ',
        'our_story' => 'ታሪካችን',
        'featured_pieces' => 'ተለይተው የቀረቡ',
        'new_arrival' => 'አዲስ የመጣ',
        'view_details' => 'ዝርዝር እይ',
        'view_all' => 'ሁሉንም ምርቶች እይ',
        'heritage_title' => 'በእያንዳንዱ ክር ውስጥ ያለ ቅርስ',
        'heritage_desc' => 'ልብሶቻችን ከጨርቅ በላይ የኢትዮጵያ ቅርስ መገለጫዎች ናቸው። እያንዳንዱ ቁራጭ በባለሙያ የእጅ ጥበብ ባለሙያዎች በጥንቃቄ የተሰራ ነው።',
        'discover_story' => 'ታሪኩን ይወቁ',
        'handwoven_cotton' => 'በእጅ የተሸመነ ጥጥ',
        'artisan_weavers' => 'የእጅ ጥበብ ባለሙያዎች',
        
        // Products Listing
        'discover_auth' => 'ጥበብን ያግኙ',
        'explore_curated' => 'ባህል ከዘመናዊነት ጋር የተዋሃደበትን የእጅ ስራዎቻችንን ስብስብ ይመርምሩ።',
        'search' => 'ፈልግ',
        'search_placeholder' => 'ምን ይፈልጋሉ...',
        'categories' => 'ምድቦች',
        'all_items' => 'ሁሉም እቃዎች',
        'habesha_kemis' => 'ሐበሻ ቀሚስ',
        'netela_shawls' => 'ነጠላ',
        'gabi_blankets' => 'ጋቢ',
        'accessories' => 'ጌጣጌጥ',
        'custom_orders' => 'ልዩ ትዕዛዞች',
        'try_on' => 'ልክህን እይ',
        'add_to_cart' => 'ወደ ቅርጫት',
        'buy_now' => 'አሁን ግዛ',
        'est_value' => 'ግምታዊ ዋጋ',
        
        // Product Detail
        'in_stock' => 'በክምችት ላይ ያለ',
        'ships_worldwide' => 'በየትኛውም ቦታ እናደርሳለን',
        'quantity' => 'ብዛት',
        'auth_quality' => 'ትክክለኛ ጥራት',
        'secure_payment' => 'አስተማማኝ ክፍያ',
        'also_like' => 'እነዚህንም ሊወዷቸው ይችላሉ',
        'view' => 'እይ',
        
        // Culture
        'culture_hero' => 'የባህል ክሮች',
        'culture_desc' => 'እያንዳንዱ ጥለት ታሪክ የሚናገርበትን የኢትዮጵያ የጨርቃ ጨርቅ ታሪክ ይመርምሩ።',
        'journey_time' => 'የጊዜ ጉዞ',
        'regional_trad' => 'የየክልሉ ወጎች',
        'gallery_life' => 'የባህል ማዕከለ-ስዕላት',
        
        // Favorites
        'my_favorites' => 'የእኔ ተወዳጆች',
        'fav_desc' => 'የመረጧቸው ምርጥ ስራዎች። በኋላ ለመግዛት ያስቀምጧቸው ወይም አሁን የእርስዎ ያድርጓቸው።',
        'clear_all' => 'ሁሉንም አጥፋ',
        'wishlist_empty' => 'ተወዳጅ ዝርዝርዎ ባዶ ነው',
        'wishlist_empty_desc' => 'ስብስቦቻችንን ማየት ይጀምሩ እና የሚወዷቸውን እቃዎች እዚህ ያስቀምጡ።',
        'browse_coll' => 'ስብስቦችን እይ',
        
        // Contact
        'contact_us' => 'እኛን ያግኙን',
        'contact_desc' => 'ከእርስዎ መስማት እንፈልጋለን። ከታች ያሉትን ዝርዝሮች በመጠቀም ያግኙን።',
        'phone' => 'ስልክ',
        'email' => 'ኢሜይል',
        'location' => 'አድራሻ',
        'support_24' => 'የ24/7 የኢንተርኔት ድጋፍ',
        'mon_fri' => 'ከሰኞ - አርብ ከጠዋቱ 3:00 - 12:00',
        
        // Settings
        'account_settings' => 'የመለያ ቅንብሮች',
        'settings_desc' => 'መገለጫዎን ያስተዳድሩ፣ ደህንነትዎን ይጠብቁ እና የዲጂታል ቦርሳዎን ይሙሉ::',
        'wallet_funds' => 'ቦርሳ እና ገንዘብ',
        'security' => 'ደህንነት',
        'appearance' => 'ገጽታ',
        'avail_balance' => 'ያለዎት ቀሪ ሂሳብ',
        'refill_funds' => 'ገንዘብ ይጨምሩ',
        'amount' => 'መጠን',
        'method' => 'መንገድ',
        'complete_dep' => 'ክፍያውን ይፈጽሙ',
        'privacy_sec' => 'ግላዊነት እና ደህንነት',
        'curr_pass' => 'የአሁኑ የይለፍ ቃል',
        'new_pass' => 'አዲስ የይለፍ ቃል',
        'conf_new' => 'አዲሱን ያረጋግጡ',
        'update_cred' => 'መረጃውን ያድሱ',
        'interface_set' => 'የገጽታ ቅንብሮች',
        'dark_mode_exp' => 'የጨለማ ገጽታ',
        'dark_mode_desc' => 'በብርሃን እና በጨለማ ገጽታዎች መካከል ይቀያይሩ።'
    ]
];

function __($key) {
    global $translations;
    $lang = $_SESSION['lang'] ?? 'en';
    return $translations[$lang][$key] ?? $key;
}
?>