
<!-- ========================================
   جاوااسکریپت دارک/لایت مود
   ======================================== -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ========================================
        // ۱. مدیریت تم
        // ========================================
        const htmlElement = document.getElementById('html-theme');
        const themeToggleSidebar = document.getElementById('themeToggleSidebar');
        const themeToggleHeader = document.getElementById('themeToggleHeader');
        const themeIconSidebar = document.getElementById('themeIconSidebar');
        const themeIconHeader = document.getElementById('themeIconHeader');
        const themeTextSidebar = document.getElementById('themeTextSidebar');

        // دریافت تم ذخیره شده
        let currentTheme = localStorage.getItem('adminTheme') || 'light';
        
        // اعمال تم
        function setTheme(theme) {
            currentTheme = theme;
            htmlElement.setAttribute('data-bs-theme', theme);
            htmlElement.setAttribute('data-theme', theme);
            localStorage.setItem('adminTheme', theme);
            
            // به‌روزرسانی آیکون‌ها و متن
            if (theme === 'dark') {
                themeIconSidebar.className = 'fas fa-sun';
                themeIconHeader.className = 'fas fa-sun';
                themeTextSidebar.textContent = 'دارک مود';
            } else {
                themeIconSidebar.className = 'fas fa-moon';
                themeIconHeader.className = 'fas fa-moon';
                themeTextSidebar.textContent = 'لایت مود';
            }
        }

        // تغییر تم
        function toggleTheme() {
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            setTheme(newTheme);
        }

        // رویدادها
        themeToggleSidebar.addEventListener('click', toggleTheme);
        themeToggleHeader.addEventListener('click', toggleTheme);

        // اعمال تم ذخیره شده در ابتدا
        setTheme(currentTheme);

        // ========================================
        // ۲. منوی موبایل
        // ========================================
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('mobileToggle');

        function toggleSidebar() {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        }

        toggleBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // بستن با ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar.classList.contains('open')) {
                toggleSidebar();
            }
        });

        // بستن در موبایل هنگام کلیک روی لینک
        document.querySelectorAll('.sidebar-menu a').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                }
            });
        });

        // ========================================
        // ۳. ذخیره تم در مرورگر (قبلاً انجام شد)
        // ========================================
    });
</script>
    