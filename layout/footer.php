    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    
    <!-- Custom JS -->
   <script>
    $(document).ready(function() {
        // Toggle sidebar
        $('[data-widget="pushmenu"]').click(function(e) {
            e.preventDefault();
            $('body').toggleClass('sidebar-collapse');
            
            // Simpan state di localStorage
            if ($('body').hasClass('sidebar-collapse')) {
                localStorage.setItem('sidebarState', 'collapsed');
            } else {
                localStorage.setItem('sidebarState', 'expanded');
            }
        });
        
        // Cek state sebelumnya
        var sidebarState = localStorage.getItem('sidebarState');
        if (sidebarState === 'collapsed') {
            $('body').addClass('sidebar-collapse');
        }
        
        // Aktifkan tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
</body>
</html>