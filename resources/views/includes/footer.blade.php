<!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2016 <a href="#">Company</a>.</strong> All rights reserved.
  </footer>

  @include('includes.control_sidebar')
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->

<script src={{asset("bower_components/jquery/dist/jquery.min.js")}}></script>
<script src={{asset("bower_components/jquery-ui/jquery-ui.min.js")}}></script>
<!-- Bootstrap 3.3.7 -->

<script src={{asset("bower_components/bootstrap/dist/js/bootstrap.min.js")}}></script>
<!-- AdminLTE App -->
<script src={{asset("bower_components/select2/dist/js/select2.min.js")}}></script>
<!-- InputMask -->
<script src={{asset("plugins/input-mask/jquery.inputmask.js")}}></script>
<script src={{asset("plugins/input-mask/jquery.inputmask.date.extensions.js")}}></script>
<script src={{asset("plugins/input-mask/jquery.inputmask.extensions.js")}}></script>
<!-- SlimScroll -->
<script src={{asset("bower_components/jquery-slimscroll/jquery.slimscroll.min.js")}}></script>
<!-- FastClick -->
<script src={{asset("bower_components/fastclick/lib/fastclick.js")}}></script>
<script src={{asset("/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")}}></script>
<script type="text/javascript" src={{asset("js/bootstrap-multiselect.js")}}></script>
<script src={{asset("dist/js/adminlte.min.js")}}></script>
<script src={{asset("dist/js/demo.js")}}></script>


  @yield('additional_js')

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->


