<?php $this->load->view("template/header-slider");?>
<link href="<?php echo base_url("public")?>/assets/css/carousel.css" rel="stylesheet">
</div>

<div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
  <div class="carousel-inner">
    <div class="item bg bg1 active">
     <div class="container">
      <div class="carousel-caption">
        <p>Dating is easy, Finding the perfect match is the hard part. Pmjakarta makes it easier than ever before</p>
        <a class="btn btn-large" href="<?php echo base_url("welcome")?>/index">Get Started</a>
      </div>
      <div class="kotak-twitter">
        <a target="_blank" href="https://twitter.com/pmjakarta">
          <label class="logo-twitter">
            <img src="<?php echo base_url("public")?>/assets/img/slideshow/twitter.png" class="img-responsive" alt="Responsive image">
          </label>
          <label class="label-twitter"> 
            PMJ Twitter
          </label>
        </a>
      </div>
    </div>

  </div> 

  <div class="item bg bg2">
   <div class="container">
    <div class="carousel-caption">
      <p>Stop wasting your time with meaningless bar 
        hopping, or dateless weekends</p>
        
        <a class="btn btn-large" href="<?php echo base_url("welcome")?>/index">Get Started</a>
      </div>

      <div class="kotak-twitter">
        <a target="_blank" href="https://twitter.com/pmjakarta">
          <label class="logo-twitter">
            <img src="<?php echo base_url("public")?>/assets/img/slideshow/twitter.png" class="img-responsive" alt="Responsive image">
          </label>
          <label class="label-twitter"> 
            PMJ Twitter
          </label>
        </a>
      </div>

    </div>

    
  </div> 

  <div class="item bg bg3">

    <div class="container">
      <div class="carousel-caption">
        <p>Ultimate security, privacy, and exclusivity to find your perfect match in Jakarta.
        </p>

        <a class="btn btn-large" href="<?php echo base_url("welcome")?>/index">Get Started</a>
      </div>
      <div class="kotak-twitter">
        <a target="_blank" href="https://twitter.com/pmjakarta">
          <label class="logo-twitter">
            <img src="<?php echo base_url("public")?>/assets/img/slideshow/twitter.png" class="img-responsive" alt="Responsive image">
          </label>
          <label class="label-twitter"> 
            PMJ Twitter
          </label>
        </a>
      </div>

    </div>
  </div> 

  <div class="item bg bg4">

    <div class="container">
      <div class="carousel-caption">
        <p>Do Yourself a favor in this new year. Sign up now, and find your perfect match today</p>

        <a class="btn btn-large" href="#">Get Started</a>
      </div>
      <div class="kotak-twitter">
        <a target="_blank" href="https://twitter.com/pmjakarta">
          <label class="logo-twitter">
            <img src="<?php echo base_url("public")?>/assets/img/slideshow/twitter.png" class="img-responsive" alt="Responsive image">
          </label>
          <label class="label-twitter"> 
            PMJ Twitter
          </label>
        </a>
      </div>

    </div>
  </div> 

  <div class="item bg bg5 active">

    <div class="container">

      <div class="carousel-caption" style="margin-top:-250px;"> 
        <img src="<?php echo base_url("public")?>/assets/img/logo-home.png">
        <br>
        <img src="<?php echo base_url('public') ?>/assets/img/slideshow/slide-signup.png" alt="">
        <br>
        <a class="btn btn-large" href="<?php echo base_url("welcome")?>/index">Get Started</a>
      </div>

      <div class="kotak-twitter">
        <a target="_blank" href="https://twitter.com/pmjakarta">
          <label class="logo-twitter">
            <img src="<?php echo base_url("public")?>/assets/img/slideshow/twitter.png" class="img-responsive" alt="Responsive image">
          </label>
          <label class="label-twitter"> 
            PMJ Twitter
          </label>
        </a>
      </div>

    </div>
  </div> 
</div>



</div>

<footer class="site-footer cl" id="colophon" role="contentinfo">
  <div class="col-sm-6 left-menu-footer">
    <nav class="nav-menu-footer-left">
      <ul class="nav navbar-left">
        <li>
          <a href="<?php echo base_url("pages")?>/why_us#why_us"><b>Why us ?</b></a>
        </li>
        <li>
          <a href="<?php echo base_url("pages")?>/why_us#about_us"><b>About us</b></a>
        </li>
        <li>
          <a href="<?php echo base_url("pages")?>/why_us#contact_us"><b>Contact</b></a>
        </li>
        <li>
          <a href="<?php echo base_url("pages")?>/why_us#safety_first"><b>Privacy policy</b></a>
        </li>
        <li>
          <a href="<?php echo base_url("pages")?>/why_us#term_condition"><b>Term & Condition</b></a>
        </li>
      </ul>
    </nav>

    <!-- end of .nav-menu-footer-left -->
  </div>
  <!-- end of .col-sm-8.left-menu-footer -->
  <div class="col-sm-6 right-menu-footer">
    <p class="text-right">
      Copyright &copy; 2014
      <a href="<?php echo base_url()?>">PMJakarta</a>
      by
      <a href="javascript:void(0);">SBS Incubator.</a>
      All rights reserved.
    </p>
  </div>

  <!-- end of .col-sm-4.right-menu-footer -->
</footer>

       <!-- Bootstrap core JavaScript
       ================================================== -->
       <!-- Placed at the end of the document so the pages load faster -->
       <script src="<?php echo base_url("public")?>/assets/js/jquery.js"></script>
       <script src="<?php echo base_url("public")?>/assets/js/bootstrap.js"></script>

     </body>
     </html>

     <script type="text/javascript">
     var $ = jQuery.noConflict();
     $(document).ready(function() { 
      $('#carousel').carousel({ interval: 7000, cycle: true,pause:false });
      $('#carousel').height( $(window).height() - 68 );
    });
     </script>
    <?php $this->load->view("template/ga");?>