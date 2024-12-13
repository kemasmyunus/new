<footer class="main-footer text-light" style="background-color: #242423;">
	<div class="container-fluid">
		<div class="row">
			<div class="col text-center  ">
				<strong>2024 &copy;Surgi Mufti</strong>
			</div>
		</div>
	</div>
</footer>

<!-- ./wrapper -->

<!-- jQuery -->
<script src="./assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./assets/dist/js/adminlte.min.js"></script>
<!-- Additional Plugins -->
<script src="./assets/plugins/summernote/summernote-bs4.min.js"></script>
<script src="./assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="./assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="./assets/dist/js/script-menu.js"></script>

<script>
	$(function() {
		// Initialize Summernote
		$('.textarea').summernote({
			height: 100
		});

		// Active sidebar menu
		var url = window.location;
		$('ul.nav-sidebar a').filter(function() {
			return this.href == url;
		}).addClass('active');
		$('ul.nav-treeview a').filter(function() {
			return this.href == url;
		}).parentsUntil(".nav-sidebar > .nav-treeview").css({
			'display': 'block'
		}).addClass('menu-open').prev('a').addClass('active');

		// Initialize DataTables
		$('#example2').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": true,
			"ordering": true,
			"info": true,
			"pageLength": 10,
			"autoWidth": true,
		});
	});
</script>
</body>

</html>