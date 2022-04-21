@section('page-title', __tr('Create an Account'))
@section('head-title', __tr('Create an Account'))
@section('keywordName', strip_tags(__tr('Create an Account!')))
@section('keyword', strip_tags(__tr('Create an Account!')))
@section('description', strip_tags(__tr('Create an Account!')))
@section('keywordDescription', strip_tags(__tr('Create an Account!')))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())



<!-- include header -->
@include('includes.header')

<!-- /include header -->

<body style="background-color:#E1E1E1">
  <!-- desktop only -->
  <header id="header" class="Web-head" style="background-color: white;
  box-shadow: 4px 2px 9px -5px #c9c9c9;">
  <div class="container-fluid">
      <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="{{ url('/') }}">   <img class="lw-logo-img" src="<?= getStoreSettings('logo_image_url') ?>" alt="<?= getStoreSettings('name') ?>" width="70px"></a>
        <div class="button-group mobile-hide d-lg-none d-flex">
            <a href="<?= route('user.login') ?>" class="web-btn login-btn"><?= __tr('Login') ?></a>
             <a href="<?= route('user.sign_up') ?>" class="web-btn"><?= __tr('Join Free') ?></a>
     </div>
     <!--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">-->

        <!--</button>-->
        <div class="collapse navbar-collapse align-items-center justify-content-between" id="navbarTogglerDemo01">
         <!-- <a class="navbar-brand mobile-hide" href="#"><h3>Logo</h3></a> -->
         <ul class="navbar-nav ">
            <!--<li class="nav-item active">-->
                <!--  <a class="nav-link" href="#">How PPM Works<span class="sr-only">(current)</span></a>-->
                <!--</li>-->
            </ul>
            <div class="button-group mobile-hide d-flex">
             <button class="web-btn login-btn">Login</button>
             <button class="web-btn">Join Free</button>
         </div>
     </div>
 </nav>
</div>
</header>
<!-- partial:index.partial.html -->
<!-- multistep form -->
<form id="msform" class="rg-form-box" method="post" action="<?= route('user.sign_up.process') ?>" data-show-processing="true" data-secured="true" data-unsecured-fields="first_name,last_name">

    @csrf
    <h2 class="fs-title"><?= __tr('Create an Account!') ?></h2>
    <p>Signing up for is fast and free</p>
    <fieldset>

        <input type="hidden" name="gender_selection" id="gender_selection">
        <input type="hidden" name="interest_selection" id="interest_selection">
        <input type="hidden" name="type_selection_generous" id="type_selection_generous">

        <div class="head rg-form step-result-section">
          <p class="head-option step-common-section step-1"></p>
          <p class="head-option step-common-section step-2"></p>
          <p class="head-option step-common-section step-3"></p>
      </div>



      <div class="head rg-form btn-steps" id="step-1">
          <p class="head-option">I am <a href="#">......</a></p>
          <div>
            <button class="action-button" data-value="woman" db-value="2">Woman</button>
            <button class="action-button" data-value="man" db-value="1"> Man</button>
        </div>

    </div>

    <div class="head rg-form btn-steps" id="step-2">
      <p class="head-option">I am Intrested in <a href="#">......</a></p>
      <div>
        <button class="action-button" data-value="man" db-value="1">Man</button><button class="action-button" data-value="woman" db-value="2">Women</button>
    </div>
</div>


<div class="head rg-form btn-steps" id="step-3">
  <p class="head-option">I want to meet someone who has <a href="#">......</a></p>
  <div>
    <button class="action-button" data-value="Looks & Charm">Looks & Charm</button><button class="action-button" data-value="Success & Wealth">Success & Wealth</button>
</div>
</div>



<div class="box-body btn-steps" id="step-4">
 <p>Email</p>
 <input type="email" name="email" placeholder="Email" required/>
 <ul><li class="edu_email_address" style="position: relative; top: -5px; background: rgb(217, 237, 247) none repeat scroll 0% 0%; border: 1px solid rgb(181, 220, 240); padding: 10px; margin-bottom: 0px; border-radius: 1px;" data-cy-email="edu"><span><b>Tip: </b></span><span>Using a .edu email address earns you a free premium upgrade!</span></li></ul>
 <p>Birth Date</p>
 <input type="text" name="dob" placeholder="mm/dd/yyyy" required/>





 <div class="text-center">


{!! Captcha::display() !!}

     <a href class="lw-ajax-form-submit-action btn btn-primary btn-user btn-block">
        <?= __tr('Register Account') ?>
    </a>

    <!-- <button class="next action-button rg-button" type="submit">Continue</button> -->
    <p>or</p>



    @if(getStoreSettings('allow_facebook_login'))
    <a href="<?= route('social.user.login', [getSocialProviderKey('facebook')]) ?>" class="btn btn-facebook btn-user btn-block">
        <i class="fab fa-facebook-f fa-fw"></i> <?= __tr('Register with Facebook') ?>
    </a>
    @endif
  <!--   <a href="<?= route('social.user.login', [getSocialProviderKey('facebook')]) ?>">
        <button class="next action-button rg-button facebook-btn"><i class="fab fa-facebook-f fa-fw"></i> <?= __tr('Register with Facebook') ?></button>
    </a> -->
</div>
<p class="image-dis">By continuing you agree to Seeking's <a href="#">Terms</a> and <a href="#">Privacy Policy</a> and to receive our emails. Promoting illegal commercial activities (such as prostitution) is prohibited. Users must be at least 18 years old.</p>
</div>

</fieldset>
</form>
</body>
<!-- include footer -->
<!-- Messenger Dialog -->
<img src="<?= asset('imgs/ajax-loader.gif') ?>" style="height:1px;width:1px;">
<script>

    window.appConfig = {
        debug: "<?= config('app.debug') ?>",
        csrf_token: "<?= csrf_token() ?>"
    }
</script>

<?= __yesset([
    'public/dist/pusher-js/pusher.min.js',
    'public/dist/js/vendorlibs-public.js',
    'public/dist/js/vendorlibs-datatable.js',
    'public/dist/js/vendorlibs-photoswipe.js',
    'public/dist/js/vendorlibs-smartwizard.js'
], true) ?>

<?= __yesset([
    'public/dist/js/common-app.*.js'
], true) ?>
<script>

</script>
<!-- Include Audio Video Call Component -->
@include('messenger.audio-video')
<!-- /Include Audio Video Call Component -->


<script type="text/javascript">


    $(document).ready(function() {

      $("#step-2, #step-3, #step-4").hide();
      $(".step-common-section").hide();


      $('.action-button').click(function(){

          var whichStep = $(this).parent().parent().attr('id');
          var stepValue = $(this).attr('data-value');
          var dbValue = $(this).attr('db-value');

          if(whichStep == "step-1"){

            $("#"+whichStep).hide();
            $("#step-2").show();
            $('#gender_selection').val(dbValue);
            $("."+whichStep).html('<p>I am <a href="#" class="step-result" value="'+whichStep+'">'+stepValue+'</a><p>').show();
        }

        if(whichStep == "step-2"){

            $("#"+whichStep).hide();
            $("#step-3").show();
            $('#interest_selection').val(dbValue);
            $("."+whichStep).html('<p>I am interested in meeting <a href="#" class="step-result" value="'+whichStep+'">'+stepValue+'</a><p>').show();
        }

        if(whichStep == "step-3"){

            $("#"+whichStep).hide();
            $("#step-4").show();
            $('#type_selection_generous').val(stepValue);
            $("."+whichStep).html('<p>I want to meet someone who has <a href="#" class="step-result" value="'+whichStep+'">'+stepValue+'</a><p>').show();
        }

    });

      $(document).on("click",'.step-result', function(){
        var whichStep = $(this).attr('value');
        $('.btn-steps').hide();
        $('#'+whichStep).show();

    });
  });

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
        return false;
    };


    var tech = getUrlParameter('technology');


</script>
@stack('appScripts')

<!-- /include footer -->
</html>