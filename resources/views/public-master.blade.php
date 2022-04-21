<!-- include header -->
@include('includes.header')
<!-- /include header -->
<body id="page-top" class="lw-page-bg lw-public-master">

   <!-- Page Wrapper -->

   <div class="container-fluid">

    <!-- Topbar -->
    @if(isLoggedIn())
    @include('includes.public-top-bar')
    @endif

</div>

<div class="bottom-bar-mobile">

    <ul class="d-flex justify-content-between">

       <li class="active"><i class="fa-solid fa-house"></i>Home</li>

       <li class=""><i class="fa-solid fa-magnifying-glass"></i>Search</li>

       <li><i class="fa-solid fa-heart"></i>Interests</li>

       <li><i class="fa-solid fa-photo-film"></i>Events</li>

       <li><i class="fa-solid fa-comment-dots"></i>Message</li>

   </ul>

</div>

<div id="wrapper" class="container-fluid">
    <!-- include sidebar -->

    @if (Request::is('search'))
    @if(isLoggedIn())
    @include('includes.search-sidebar')
    @endif
     @elseif(Request::is('settings'))
       @if(isLoggedIn())
    @include('includes.setting-sidebar')
    @endif
    @else
    @if(isLoggedIn())
    @include('includes.public-sidebar')
    @endif
    @endif

    <!-- Content Wrapper -->

    <div id="content-wrapper" class="d-flex flex-column lw-page-bg">

        <div id="content">

            <!-- include top bar -->



      @yield('content')


            <!-- product zoom gallery block -->

            <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

                <div class="pswp__bg"></div>

                <div class="pswp__scroll-wrap">

                    <div class="pswp__container">

                        <div class="pswp__item"></div>

                        <div class="pswp__item"></div>

                        <div class="pswp__item"></div>

                    </div>

                </div>

            </div>

            <!-- / product zoom gallery block -->

            <!-- End of Topbar -->

            <!-- /include top bar -->



            <!-- /.container-fluid -->

        </div>

    </div>

    <!-- End of Content Wrapper -->

</div>

<!-- End of Page Wrapper -->

<!-- include footer -->
@include('includes.footer')
<!-- /include footer -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<!-- /Scroll to Top Button-->

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><?= __tr('Ready to Leave?') ?></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <?= __tr('Select "Logout" below if you are ready to end your current session.') ?>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal"><?= __tr('Not now') ?></button>
            <a class="btn btn-primary" href="<?= route('user.logout') ?>"><?= __tr('Logout') ?></a>
        </div>
    </div>
</div>
</div>
<!-- /Logout Modal-->


<!-- Footer -->

<footer>

  <div class="container">

    <div class="row">

      <div class="col-lg-1 col-md-1 col-sm-12">

          <a class="sidebar-brand d-flex align-items-center" href="home">

            <div class="sidebar-brand-icon">

                <img class="lw-logo-img" src="backend/media-storage/small_logo/images.png?ver=1644474798" alt="PPM-f">

            </div>

            <img width="40px" src="backend/media-storage/logo/logo.png?ver=1644819848" alt="PPM-user">

            <img class="lw-logo-img d-sm-block d-md-none" src="<?= getStoreSettings('logo_image_url') ?>" alt="PP-u">

        </a>

    </div>

    <div class="col-lg-8 col-md-8 col-sm-12">

        <ul class="footer-menu">

            <li class="footer-item">

              <a class="footer-link" href="#">Company</a>

          </li>

          <li class="footer-item">

              <a class="footer-link" href="#">Career</a>

          </li>

          <li class="footer-item">

              <a class="footer-link" href="#">Press</a>

          </li>

          <li class="footer-item">

              <a class="footer-link" href="#">Contact</a>

          </li>

          <li class="footer-item">

              <a class="footer-link" href="#">Investors</a>

          </li>

      </ul>

  </div>

  <div class="col-lg-3 col-md-3 col-sm-12 icon-group ">

    <a class="navbar-brand" href="#"><i class="fa-brands fa-facebook"></i></a>

    <a class="navbar-brand" href="#"><i class="fa-brands fa-instagram-square"></i></a>

    <a class="navbar-brand" href="#"><i class="fa-brands fa-twitter-square"></i></a>

</div>

</div>

</div> 

</footer>

<!-- End of Footer -->

</body>
</html>