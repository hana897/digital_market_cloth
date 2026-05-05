<?php
session_start();
require_once 'database/db.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php?redirect=settings.php"); exit(); }
$db = get_db_connection();
$userId = $_SESSION['user_id'];
$message = ''; $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deposit'])) {
        $amount = (float)$_POST['amount'];
        $method = $_POST['deposit_method'] ?? 'Bank';
        if ($amount > 0) {
            try {
                $stmt = $db->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
                $stmt->execute([$amount, $userId]);
                $message = ($_SESSION['lang'] === 'am' ? "በ $method በኩል ETB " : "Successfully deposited ETB ") . number_format($amount, 2) . ($_SESSION['lang'] === 'am' ? " ገቢ ተደርጓል::" : ".");
            } catch (PDOException $e) { $error = "Deposit failed: " . $e->getMessage(); }
        } else { $error = __('amount') . " error"; }
    }
    if (isset($_POST['change_password'])) {
        $currentPass = $_POST['current_password'];
        $newPass = $_POST['new_password'];
        $confirmPass = $_POST['confirm_password'];
        if ($newPass !== $confirmPass) { $error = "New passwords do not match."; }
        elseif (strlen($newPass) < 6) { $error = "New password must be at least 6 characters."; }
        else {
            $stmt = $db->prepare("SELECT password_hash FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($currentPass, $user['password_hash'])) {
                $newHash = password_hash($newPass, PASSWORD_DEFAULT);
                $stmt = $db->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
                $stmt->execute([$newHash, $userId]);
                $message = "Password updated successfully.";
            } else { $error = "Incorrect current password."; }
        }
    }
}

$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
$title = "Settings - Ethiopian Heritage";
include 'header.php'; 
?>

<div class="min-h-screen pt-20">
    <div class="py-12 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-[--terracotta]/5 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="font-display text-4xl md:text-5xl font-bold mb-4 cultural-gradient"><?= __('account_settings') ?></h1>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto font-light"><?= __('settings_desc') ?></p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        <?php if ($message): ?><div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><?= htmlspecialchars($message) ?></div><?php endif; ?>
        <?php if ($error): ?><div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><?= htmlspecialchars($error) ?></div><?php endif; ?>

        <div class="grid lg:grid-cols-12 gap-12">
            <aside class="lg:col-span-4">
                <div class="glass p-4 rounded-[2rem] sticky top-24">
                    <div class="flex flex-col gap-2">
                        <button onclick="showSection('wallet')" class="tab-btn active group flex items-center gap-4 px-6 py-4 rounded-2xl font-bold transition-all" id="btn-wallet"><div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center transition-transform group-hover:scale-110"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg></div><span><?= __('wallet_funds') ?></span></button>
                        <button onclick="showSection('security')" class="tab-btn group flex items-center gap-4 px-6 py-4 rounded-2xl font-bold text-gray-500 transition-all" id="btn-security"><div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center transition-transform group-hover:scale-110"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg></div><span><?= __('security') ?></span></button>
                        <button onclick="showSection('appearance')" class="tab-btn group flex items-center gap-4 px-6 py-4 rounded-2xl font-bold text-gray-500 transition-all" id="btn-appearance"><div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center transition-transform group-hover:scale-110"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg></div><span><?= __('appearance') ?></span></button>
                    </div>
                </div>
            </aside>

            <main class="lg:col-span-8">
                <div id="section-wallet" class="section-content space-y-8 animate-fade-in">
                    <div class="relative group"><div class="absolute -inset-1 bg-gradient-to-r from-[--terracotta] to-amber-500 rounded-[2.5rem] blur opacity-25 transition"></div><div class="relative glass rounded-[2.5rem] p-10 overflow-hidden"><div class="relative z-10"><p class="text-sm font-bold uppercase tracking-widest text-[--terracotta] mb-2"><?= __('avail_balance') ?></p><h2 class="text-6xl font-black text-[--text-color] mb-8"><span class="text-2xl font-bold align-top mt-2 inline-block">ETB</span> <?= number_format($currentUser['balance'], 2) ?></h2></div></div></div>
                    <div class="glass rounded-[2.5rem] p-10"><h3 class="font-display text-2xl font-bold mb-6 text-[--text-color]"><?= __('refill_funds') ?></h3><form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-8"><div class="space-y-2"><label class="block text-sm font-bold text-gray-400 uppercase tracking-wider"><?= __('amount') ?></label><input type="number" name="amount" min="1" step="0.01" class="w-full glass border-2 border-[--border-color] rounded-2xl px-6 py-4 outline-none font-bold text-lg" placeholder="0.00" required></div><div class="space-y-2"><label class="block text-sm font-bold text-gray-400 uppercase tracking-wider"><?= __('method') ?></label><select name="deposit_method" class="w-full glass border-2 border-[--border-color] rounded-2xl px-6 py-4 outline-none font-bold bg-transparent text-[--text-color]"><option value="Telebirr">Telebirr</option><option value="CBE Birr">CBE Birr</option><option value="Boa">Bank of Abyssinia</option></select></div><button type="submit" name="deposit" class="md:col-span-2 btn-primary py-5 rounded-2xl font-bold text-lg shadow-xl active:scale-95 transition-all"><?= __('complete_dep') ?></button></form></div>
                </div>

                <div id="section-security" class="section-content hidden animate-fade-in"><div class="glass rounded-[2.5rem] p-10"><h2 class="font-display text-3xl font-bold mb-8 text-[--text-color]"><?= __('privacy_sec') ?></h2><form method="POST" class="space-y-6"><div class="space-y-2"><label class="block text-sm font-bold text-gray-400 uppercase tracking-wider"><?= __('curr_pass') ?></label><input type="password" name="current_password" class="w-full glass border-2 border-[--border-color] rounded-2xl px-6 py-4 outline-none" required></div><div class="grid md:grid-cols-2 gap-6"><div class="space-y-2"><label class="block text-sm font-bold text-gray-400 uppercase tracking-wider"><?= __('new_pass') ?></label><input type="password" name="new_password" class="w-full glass border-2 border-[--border-color] rounded-2xl px-6 py-4 outline-none" required></div><div class="space-y-2"><label class="block text-sm font-bold text-gray-400 uppercase tracking-wider"><?= __('conf_new') ?></label><input type="password" name="confirm_password" class="w-full glass border-2 border-[--border-color] rounded-2xl px-6 py-4 outline-none" required></div></div><button type="submit" name="change_password" class="w-full py-5 bg-[--text-color] text-[--bg-color] rounded-2xl font-bold text-lg active:scale-95 transition-all"><?= __('update_cred') ?></button></form></div></div>

                <div id="section-appearance" class="section-content hidden animate-fade-in"><div class="glass rounded-[2.5rem] p-10"><h2 class="font-display text-3xl font-bold mb-8 text-[--text-color]"><?= __('interface_set') ?></h2><div class="flex items-center justify-between p-8 glass border-2 border-[--border-color] rounded-[2rem]"><div><h4 class="font-bold text-xl text-[--text-color] mb-1"><?= __('dark_mode_exp') ?></h4><p class="text-sm text-gray-500"><?= __('dark_mode_desc') ?></p></div><label class="relative inline-flex items-center cursor-pointer"><input type="checkbox" id="theme-toggle" class="sr-only peer"><div class="w-14 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div></label></div></div></div>
            </main>
        </div>
    </div>
</div>

<style>
    .tab-btn.active { background: var(--card-bg) !important; color: var(--terracotta) !important; box-shadow: var(--glass-shadow); border: 1px solid var(--terracotta); }
    .tab-btn.active div { background: var(--terracotta) !important; color: white !important; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
</style>

<script>
    function showSection(sectionId) {
        document.querySelectorAll('.section-content').forEach(el => el.classList.add('hidden'));
        document.getElementById('section-' + sectionId).classList.remove('hidden');
        document.querySelectorAll('.tab-btn').forEach(btn => { btn.classList.remove('active', 'text-[--terracotta]'); btn.classList.add('text-gray-500'); });
        const activeBtn = document.getElementById('btn-' + sectionId);
        activeBtn.classList.remove('text-gray-500'); activeBtn.classList.add('active');
    }
    const themeToggle = document.getElementById('theme-toggle');
    if (document.documentElement.classList.contains('dark')) themeToggle.checked = true;
    themeToggle.addEventListener('change', function() {
        if (this.checked) { document.documentElement.classList.add('dark'); localStorage.setItem('theme', 'dark'); }
        else { document.documentElement.classList.remove('dark'); localStorage.setItem('theme', 'light'); }
    });
</script>
<?php include 'footer.php'; ?>