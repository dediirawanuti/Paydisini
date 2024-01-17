            </div>
            </div>
            <br>
            <br>
            <br>
            <!-- Page Content Ends -->
            <!-- ================== -->
            <!--Start of Tawk.to Script-->

            <!-- Footer -->
        <footer class="footer mt-3">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        2020 - <?= date('Y') ?> &copy; <a class="text-primary darken-2" href="<?= base_url(); ?>" target="_blank"><b><?= $_CONFIG['title']; ?></b>,</a>
                    </div>
                </div>
            </div>
        </footer>
            <!-- Footer Ends -->



        </section>
        <!-- Main Content Ends -->
        


        <!-- js placed at the end of the document so the pages load faster -->
        <script src="<?= base_url(); ?>library/assets/js/jquery.js"></script>
        <!-- jQuery  -->
        <script src="<?= base_url(); ?>library/assets/js/jquery.min.js"></script>
        <script src="<?= base_url(); ?>library/assets/js/popper.min.js"></script>
        <script src="<?= base_url(); ?>library/assets/js/bootstrap.min.js"></script>
        <script src="<?= base_url(); ?>library/assets/js/waves.js"></script>
        <script src="<?= base_url(); ?>library/assets/js/jquery.slimscroll.js"></script>

        <!-- Counter number -->
        <script src="<?= base_url(); ?>library/assets/waypoints/lib/jquery.waypoints.min.js"></script>
        <script src="<?= base_url(); ?>library/assets/counterup/jquery.counterup.min.js"></script>

        <!-- Chart JS -->
        <script src="<?= base_url(); ?>library/assets/chart.js/chart.bundle.js"></script>

        <!-- init dashboard -->
        <script src="<?= base_url(); ?>library/assets/pages/jquery.dashboard.init.js"></script>


        <!-- App js -->
        <script src="<?= base_url(); ?>library/assets/js/jquery.core.js"></script>
        <script src="<?= base_url(); ?>library/assets/js/jquery.app.js"></script>
        
        <script src="<?= assets('libs/datatables/jquery.dataTables.min.js') ?>"></script>
        <script src="<?= assets('libs/datatables/dataTables.bootstrap4.js') ?>"></script>
        <script src="<?= assets('libs/datatables/dataTables.responsive.min.js') ?>"></script>
        <script src="<?= assets('libs/datatables/responsive.bootstrap4.min.js') ?>"></script>
        <script src="<?= assets('libs/datatables/dataTables.buttons.min.js') ?>"></script>
        <script src="<?= assets('libs/datatables/buttons.bootstrap4.min.js') ?>"></script>
        <script src="<?= assets('libs/datatables/buttons.html5.min.js') ?>"></script>
        <script src="<?= assets('libs/datatables/dataTables.keyTable.min.js') ?>"></script>
        <script src="<?= assets('libs/datatables/dataTables.select.min.js') ?>"></script>


        <script type="text/javascript">
        /* ==============================================
             Counter Up
             =============================================== */
            jQuery(document).ready(function($) {
                $('.counter').counterUp({
                    delay: 100,
                    time: 1200
                });
            });
        </script>
</body>
</html>