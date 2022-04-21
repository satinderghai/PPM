@section('page-title', __tr('Update Profile'))
@section('head-title', __tr('Update Profile'))
@section('keywordName', __tr('Update Profile'))
@section('keyword', __tr('Update Profile'))
@section('description', __tr('Update Profile'))
@section('keywordDescription', __tr('Update Profile'))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())


<!-- include header -->
@include('includes.header')

<script  src="{{ asset('public/public/frontend/css/font-awesome.css') }}"></script>
<style type="text/css">
    .error{
      color: red;
  }
</style>

<?= __yesset([
    'public/backend/style.css'
], true) ?>
<!-- /include header -->

<body class="user-profile-steps lw-login-register-page">

  <header id="header" class="Web-head" style="background-color: white;
  box-shadow: 4px 2px 9px -5px #c9c9c9;">
  <div class="container-fluid">
      <nav class="navbar navbar-expand-lg   ">
        <a class="navbar-brand" href="#"><img src="<?= getStoreSettings('logo_image_url') ?>" alt="<?= getStoreSettings('name') ?>" width="70px"></a>
        <div class="button-group mobile-hide d-lg-none d-flex">
           <!--<button class="web-btn login-btn">Login</button>-->
           <!--<button class="web-btn">Join Free</button>-->
       </div>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">

       </button>
       <div class="collapse navbar-collapse align-items-center justify-content-between" id="navbarTogglerDemo01">
          <!--<a class="navbar-brand mobile-hide" href="#"><h3>Logo</h3></a> -->
          <ul class="navbar-nav ">
            <li class="nav-item active">
              <!--<a class="nav-link" href="#">How PPM Works<span class="sr-only">(current)</span></a>-->
          </li>
      </ul>
      <div class="button-group mobile-hide d-flex">
       <!--<button class="web-btn login-btn">Login</button>-->
       <!--<button class="web-btn">Join Free</button>-->
   </div>
</div>
</nav>
</div>
</header>  


<form id="msform" action="{{ url('user/finish-wizard') }}" method="post" enctype="multipart/form-data">
    @csrf
    <a href="{{ url('skip-user-profile') }}">Skip For Now</a>
    <!-- progressbar -->
    <ul id="progressbar">
      <li class="active"></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
  </ul>
  <!-- fieldsets -->
  <fieldset  class="step-1">
   <div class="head">
     <h3 class="fs-subtitle">Choose a Username</h3>
     <div class="step-1-input">
        <input type="text" name="username" placeholder="Stay safe! Don't use your real name..." class="left-input username-input-field">
        <span class="username-message"></span>
        <input type="button" id="username-suggest-button" name="submit" value="Suggest" class="right-input">
    </div>
</div>

<div class="box-body">
  <h3 class="fs-subtitle">Add a Photo</h3>
  <img class="step1-user-icon" id="blah" >

  <!-- <input accept="image/*" id="imgInp" /> -->

  <input accept="image/*" id="imgInp" style="display: none;">

  <!-- <input id='userUploadFileButtonfileid' name="profile_picture" type='file' hidden/> -->
  <input id='userUploadFileButton' class="action-button" type='button' value='Choose Photo' />


  <!-- New Code -->


  <!-- input file -->
  <div class="box-profile">
    <input type="file" name="profile_picture" id="file-input" hidden>
</div>




<div id="overlay_profile">
  <div id="popup_profile">
    <div id="close_profile">X</div>
    <!-- leftbox -->
    <div class="box-2">
        <div class="result"></div>
    </div>
    <!--rightbox--> 
    <div class="box-2 img-result hide">
        <!-- result of crop -->
        <img class="cropped" src="" alt="">
    </div>
    <!-- input file -->
    <div class="box-profile">
        <div class="options hide">
            <input type="number" class="img-w" value="300" min="100" max="1200" />
        </div>
        <!-- save btn -->
        <button class="btn btn-profile save hide">Save</button> 
    </div> 
</div>
</div>



<!-- new code end -->

<style type="text/css">


    .box-profile {
        padding: 0.5em;
        width: 100%;
        margin:0.5em;
    }

    .box-2 {
        padding: 0.5em;
        width: calc(100%/2 - 1em);
    }

    .options label,
    .options input{
        width:4em;
        padding:0.5em 1em;
    }
    .btn-profile{
        background:white;
        color:black;
        border:1px solid black;
        padding: 0.5em 1em;
        text-decoration:none;
        margin:0.8em 0.3em;
        display:inline-block;
        cursor:pointer;
    }

    .hide {
        display: none;
    }

    #overlay_profile {
      position: fixed;
      height: 100%;
      width: 100%;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      background: rgba(0,0,0,0.8);
      display: none;
  }

  #popup_profile {
      max-width: 600px;
      width: 80%;
      /*max-height: 300px;*/
      height: auto;
      padding: 20px;
      position: relative;
      background: #fff;
      margin: 20px auto;
  }

  #close_profile {
      position: absolute;
      top: 10px;
      right: 10px;
      cursor: pointer;
      color: #000;
  }
  .btn-opecity-profile {
    opacity: 0.7;
    pointer-events: none;
}
.text-char , .error_msg {
    text-align: left;
    font-size: .875rem;
}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js"></script>
<script type="text/javascript">

// vars
var result = document.querySelector('.result');
var img_result = document.querySelector('.img-result');
var img_w = document.querySelector('.img-w');
var img_h = document.querySelector('.img-h');
var options = document.querySelector('.options');
var save = document.querySelector('.save');
var cropped = document.querySelector('.cropped');
var upload = document.querySelector('#file-input');
var cropper = '';

// on change show image with crop options
upload.addEventListener('change', (e) => {
  if (e.target.files.length) {
        // start file reader
        const reader = new FileReader();
        reader.onload = (e)=> {
          if(e.target.result){

            jQuery('#overlay_profile').fadeIn(300);  

            document.getElementsByClassName('box-2')[0].style.display = 'block';
            document.getElementsByClassName('result')[0].style.display = 'block';
            jQuery('.box-profile').show();
                // create new image
                var img = document.createElement('img');
                img.id = 'image';
                img.src = e.target.result;
                // clean result before
                result.innerHTML = '';
                // append new image
                result.appendChild(img);
                // show save btn and options
                save.classList.remove('hide');
                // init cropper
                cropper = new Cropper(img);
            }
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});

// save on click
save.addEventListener('click',(e)=>{
  e.preventDefault();
  // get result to data uri
  let imgSrc = cropper.getCroppedCanvas({
        width: img_w.value // input value
    }).toDataURL();
  // remove hide class of img
  cropped.classList.remove('hide');
  img_result.classList.remove('hide');
    // show image cropped
    cropped.src = imgSrc;
    const att = document.createAttribute("src");
    att.value = imgSrc;
    jQuery('.box-profile').hide();
    document.getElementsByClassName('box-2')[0].style.display = 'none';
    document.getElementsByClassName('img-result')[0].style.display = 'none';
    document.getElementsByClassName("step1-user-icon")[0].setAttributeNode(att);
    document.getElementsByClassName('result')[0].style.display = 'none';
    jQuery('#overlay_profile').fadeOut(300);
    jQuery('.firstStepSubmitButton').show();

});

jQuery('#close_profile').click(function() {
    jQuery('#overlay_profile').fadeOut(300);
});

</script>


<input type="button" name="submit-step-1" class="next action-button firstStepSubmitButton btn-opecity-profile" value="Continue" />
<p class="image-dis">Photos need to be larger than 400px  400px and you 
    should be in the photo. Please, no nudity or revealing 
    photos. Read our <a href="#">photo help and guidelines.</a></p>
</div>

<?php 
// echo "<pre>";
// print_r($bodyType);
// die();

?>

</fieldset>

<fieldset  class="step-2">
   <div class="head">
      <h2 class="fs-title">Great! Tell us about yourself....</h2>
      <p class="fs-subtitle"><b>Birthday:</b> <?= __ifIsset($profileInfo['birthday'], $profileInfo['birthday']) ?></p>
  </div>
  <div class="box-body">
      <h3 class="fs-subtitle fs-subtitle-label">Where are you Located</h3>

      @if(getStoreSettings('allow_google_map'))
      <div id="lwUserEditableLocation" class="loaction-field">
        <div class="form-group">

            <input type="text" id="address-input" name="city" class="form-control map-input">
            <input type="hidden" name="location_latitude" id="address-latitude" value="<?= $profileInfo['location_latitude'] ?>" />
            <input type="hidden" name="location_longitude" id="address-longitude" value="<?= $profileInfo['location_longitude'] ?>" />
        </div>
        <div id="address-map-container" style="width:100%;height:400px; ">
            <div style="width: 100%; height: 100%" id="address-map"></div>
        </div>
    </div>
    @else
    <!-- info message -->
    <div class="alert alert-info">
        <?= __tr('Something went wrong with Google Api Key, please contact to system administrator.') ?>
    </div>
    <!-- / info message -->
    @endif


    <input type="button" name="previous" class="previous action-button" value="Previous" />
    <input type="button" name="next" class="next next-location action-button btn-opecity-profile " value="Next"/>
</div>
</fieldset>

<fieldset class="step-3">
 <div class="head">
    <h2 class="fs-title">What do you looking like ?</h2>
</div>
<div class="box-body">
    <!-- FAQ -->
    <div class="ex-accordion_container">
      <div class="ex-accordion_head">Height <span class="seletced-profile-item looking"> </span><span class="plusminus"><i class="fa-solid fa-caret-down"></i></span></div>
      <div class="ex-accordion_body" style="display: none;">

         <div class="user-profile-items"> 
            <select name="height" class="ppm-form-select" >
                <option text-value="" class="infoSelector" value="">Height</option>
                <option text-value="137 cm" class="infoSelector" value="71">137 cm</option>
                <option text-value="138 cm" class="infoSelector" value="394">138 cm</option>
                <option text-value="139 cm" class="infoSelector" value="395">139 cm</option>
                <option text-value="140 cm" class="infoSelector" value="72">140 cm</option>
                <option text-value="141 cm" class="infoSelector" value="396">141 cm</option>
                <option text-value="142 cm" class="infoSelector" value="73">142 cm</option>
                <option text-value="143 cm" class="infoSelector" value="397">143 cm</option>
                <option text-value="144 cm" class="infoSelector" value="398">144 cm</option>
                <option text-value="145 cm" class="infoSelector" value="74">145 cm</option>
                <option text-value="146 cm" class="infoSelector" value="399">146 cm</option>
                <option text-value="147 cm" class="infoSelector" value="75">147 cm</option>
                <option text-value="148 cm" class="infoSelector" value="400">148 cm</option>
                <option text-value="149 cm" class="infoSelector" value="401">149 cm</option>
                <option text-value="150 cm" class="infoSelector" value="76">150 cm</option>
                <option text-value="151 cm" class="infoSelector" value="402">151 cm</option>
                <option text-value="152 cm" class="infoSelector" value="77">152 cm</option>
                <option text-value="153 cm" class="infoSelector" value="403">153 cm</option>
                <option text-value="154 cm" class="infoSelector" value="404">154 cm</option>
                <option text-value="155 cm" class="infoSelector" value="78">155 cm</option>
                <option text-value="156 cm" class="infoSelector" value="405">156 cm</option>
                <option text-value="157 cm" class="infoSelector" value="79">157 cm</option>
                <option text-value="158 cm" class="infoSelector" value="406">158 cm</option>
                <option text-value="159 cm" class="infoSelector" value="407">159 cm</option>
                <option text-value="160 cm" class="infoSelector" value="80">160 cm</option>
                <option text-value="161 cm" class="infoSelector" value="408">161 cm</option>
                <option text-value="162 cm" class="infoSelector" value="409">162 cm</option>
                <option text-value="163 cm" class="infoSelector" value="81">163 cm</option>
                <option text-value="164 cm" class="infoSelector" value="410">164 cm</option>
                <option text-value="165 cm" class="infoSelector" value="82">165 cm</option>
                <option text-value="166 cm" class="infoSelector" value="411">166 cm</option>
                <option text-value="167 cm" class="infoSelector" value="412">167 cm</option>
                <option text-value="168 cm" class="infoSelector" value="83">168 cm</option>
            </select>

        </div>  
    </div>
    <div class="ex-accordion_head">Body Type <span class="seletced-profile-item"> </span><span class="plusminus"><i class="fa-solid fa-caret-down"></i></span></div>
    <div class="ex-accordion_body" style="display: none;">
      <div class="user-profile-items"> 
        <input type="hidden" class="body_type_value" name="body_type">
        <ul class="profile-info-content-types">
           @forelse($bodyType as $key => $bodytypeval)

           <li text-value="<?= $bodytypeval['name'] ?>" class="infoSelector info_body_type" data-name="body_type" value="<?= $bodytypeval['_id'] ?>" ><?= $bodytypeval['name'] ?></li>

           @empty
           @endforelse

       </ul>
   </div>
</div>
<div class="ex-accordion_head">Ethnicity <span class="seletced-profile-item"> </span> <span class="plusminus"><i class="fa-solid fa-caret-down"></i></span></div>
<div class="ex-accordion_body" style="display: none;">
  <div class="user-profile-items"> 
    <input type="hidden" class="ethnicity_value"  name="ethnicity">
    <ul class="profile-info-content-types">


       @forelse($ethnicity as $key => $ethnicityval)

       <li text-value="<?= $ethnicityval['name'] ?>" class="infoSelector info_ethnicity highlight-red" data-name="ethnicity" value="<?= $ethnicityval['_id'] ?>" data-info="3"><?= $ethnicityval['name'] ?></li>
       @empty
       @endforelse

   </ul>
</div>
</div>
</div>
<input type="button" name="previous" class="previous action-button" value="Previous" />
<input type="button" name="next" class="next action-button btn-opecity-profile" value="Next" />
</div>
</fieldset>

<fieldset class="step-4">
  <div class="head">
    <h2 class="fs-title">Almost done ...</h2>
</div>
<div class="box-body">
 <!-- FAQ -->
 <div class="ex-accordion_container">
    <div class="ex-accordion_head sec">Education <span class="seletced-profile-item"> </span> <span class="plusminus"><i class="fa-solid fa-caret-down"></i></span></div>
    <div class="ex-accordion_body user-profile-items" style="display: none;">
        <p>What is your level of education?</p>
        <input type="hidden" class="education_level education"  name="education">
        <ul class="profile-info-content-types">

           @forelse($education as $key => $educationeval)

           <li text-value="<?= $educationeval['name'] ?>" class="infoSelector" data-name="education" value="<?= $educationeval['_id'] ?>"><?= $educationeval['name'] ?></li>

           @empty
           @endforelse


       </ul>
   </div>
   <div class="ex-accordion_head">Relationship <span class="seletced-profile-item"> </span><span class="plusminus"><i class="fa-solid fa-caret-down"></i></span></div>
   <div class="ex-accordion_body user-profile-items" style="display: none;">
    <p>Are you currently in a relationship?</p>
    <input type="hidden" class="relationship_level"  name="relationship_status">
    <ul class="profile-info-content-types">

      @forelse($relationshipStatus as $key => $relationshipStatusval)

      <li text-value="<?= $relationshipStatusval['name'] ?>" class="infoSelector" data-name="relationship_status" value="<?= $relationshipStatusval['_id'] ?>" data-more-info="2"><?= $relationshipStatusval['name'] ?></li>

      @empty
      @endforelse
  </ul>
</div>
<div class="ex-accordion_head">Children <span class="seletced-profile-item"> </span><span class="plusminus"><i class="fa-solid fa-caret-down"></i></span></div>
<div class="ex-accordion_body user-profile-items" style="display: none;">
    <p>Do you have any children?</p>
    <input type="hidden" class="education_level children"  name="children">
    <ul class="profile-info-content-types">
        <li text-value="Prefer Not to Say" class="infoSelector" data-name="relationship_status" value="1" data-more-info="2">Prefer Not to Say</li>
        <li text-value="No" class="infoSelector" data-name="relationship_status" value="2" data-more-info="2">No</li>
        <li text-value="Yes" class="infoSelector" data-name="relationship_status" value="3" data-more-info="2">Yes</li>
    </ul>
</div>
<div class="ex-accordion_head">Smoke <span class="seletced-profile-item"> </span><span class="plusminus"><i class="fa-solid fa-caret-down"></i></span></div>
<div class="ex-accordion_body user-profile-items" style="display: none;">
    <p>Do you smoke?</p>
    <input type="hidden" class="education_level smoke"  name="smoke">
    <ul class="profile-info-content-types">
        <li text-value="Non Smoker" class="infoSelector" data-name="relationship_status" value="1" data-more-info="2">Non Smoker</li>
        <li text-value="Light Smoker" class="infoSelector" data-name="relationship_status" value="2" data-more-info="2">Light Smoker</li>
        <li text-value="Heavy Smoker" class="infoSelector" data-name="relationship_status" value="3" data-more-info="2">Heavy Smoker</li>
    </ul>
</div>
<div class="ex-accordion_head">Drink <span class="seletced-profile-item"> </span><span class="plusminus"><i class="fa-solid fa-caret-down"></i></span></div>
<div class="ex-accordion_body user-profile-items" style="display: none;">
    <p>Do you drink?</p>
    <input type="hidden" class="education_level drink"  name="drink">
    <ul class="profile-info-content-types">
     <li text-value="Non Drinker" class="infoSelector" data-name="relationship_status" value="1" data-more-info="2">Non Drinker</li>
     <li text-value="Light Drinker" class="infoSelector" data-name="relationship_status" value="2" data-more-info="2">Light Drinker</li>
     <li text-value="Heavy Drinker" class="infoSelector" data-name="relationship_status" value="3" data-more-info="2">Heavy Drinker</li>
 </ul>
</div>
</div>
<input type="button" name="previous" class="previous action-button " value="Previous" />
<input type="button" name="next" class="next action-button btn-opecity-profile" value="Next" />
</div>

</fieldset>



<fieldset class="step-5">
 <div class="head">
    <h2 class="fs-title">A bit about your finances ...</h2>
</div>
<div class="box-body">
    <!-- FAQ -->
    <div class="ex-accordion_container">
      <div class="ex-accordion_head">Net Worth <span class="seletced-profile-item"> </span><span class="plusminus"><i class="fa-solid fa-caret-down"></i></span></div>
      <div class="ex-accordion_body" style="display: none;">

         <div class="user-profile-items"> 
          <select class="profile-info-dropdown new_worth" name="net_worth" data-cy-select="net_worth">
            <option value="">-</option>

            @forelse($netWorth as $key => $netWorthval)
            <option text-value="<?= $netWorthval['name'] ?>" value="<?= $netWorthval['_id'] ?>"><?= $netWorthval['name'] ?></option>
            @empty
            @endforelse

        </select>

    </div>  
</div>
<div class="ex-accordion_head">Annual Income <span class="seletced-profile-item"> </span><span class="plusminus"><i class="fa-solid fa-caret-down"></i></span></div>
<div class="ex-accordion_body" style="display: none;">
 <div class="user-profile-items"> 
   <select class="profile-info-dropdown income" name="income" data-cy-select="income">
    <option value="">-</option>

    @forelse($annualIncome as $key => $annualIncomeval)
    <option text-value="<?= $annualIncomeval['name'] ?>" value="<?= $annualIncomeval['_id'] ?>"><?= $annualIncomeval['name'] ?></option>
    @empty
    @endforelse

</select>

</div>  
</div>

</div>
<input type="button" name="previous" class="previous action-button " value="Previous" />
<input type="button" name="next" class="next action-button btn-opecity-profile" value="Next" />
</div>
</fieldset>



<fieldset  class="step-6">
  <div class="head">
    <h2 class="fs-title">What are you seeking?</h2>
    <h3 class="fs-subtitle fs-subtitle-label">Choose at least one tag that will help define what you are seeking in a relationship. 7 max.(*Required)</h3>
</div>
<div class="box-body">
 <div class="tag-group">


    @forelse ($userTag as $key => $value)

    <button class="tag user-profile-tag" data-id="{{ $value['_id'] }}" value="{{ str_replace(' ', '-', $value['name']) }}">{{ $value['name'] }}<span class="user-tag-sign"> + </span></button>

    <input type="hidden" name="user_tag[]" class="{{ str_replace(' ', '-', $value['name']) }}">
    @empty

    @endforelse
</div>


<h3 class="fs-subtitle fs-subtitle-label">Describe what you're seeking (Optional)</h3>
<textarea placeholder="Explain the sort of relationships / arrangements you're interested in." rows="5" name="what_are_you_seeking"></textarea>
<input type="button" name="previous" class="previous action-button" value="Previous" />
<input type="button" name="next" class="next action-button btn-opecity-profile" value="Next" />
</div>
</fieldset>

<fieldset  class="step-7">
   <div class="head">
      <h2 class="fs-title">Add the finishing touches to your profile!</h2>
  </div>
  <div class="box-body">
   <div class="heading-group">
      <h3 class="fs-subtitle fs-subtitle-label">Heading</h3>
      <!-- <textarea placeholder="Address" name="address" rows="5"></textarea> -->
      <input  class="eye-catching" name="heading" type="text" placeholder="For an eye-catching first impression!">
      <div class="error_msg" style="color:#c33; display: none;"></div>
  </div>
  <div class="textarea-group">
      <h3 class="fs-subtitle fs-subtitle-label">About Me</h3>
      <textarea  placeholder="Tell Successful members a bit about yourself." name="about_me" rows="5"></textarea>
      <div class="error_msg" style="color:#c33; display: none;"></div>
      <div class="text-char" style="color:#c33;"><span id="remain">0</span><span class="con_length">/50 characters minimum.</span></div>
  </div>
  <input type="submit" name="submit" class="finish action-button btn-opecity-profile" value="Finish!" />
</div>
</fieldset>
</form>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-text="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><?= __tr('Ready to Leave?') ?></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-text="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <?= __tr('Select "Logout" below if you are ready to end your current session.') ?>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal"><?= __tr('Cancel') ?></button>
            <a class="btn btn-primary" href="<?= route('user.logout') ?>"><?= __tr('Logout') ?></a>
        </div>
    </div>
</div>
</div>
<!-- /Logout Modal-->

</body>
@push('appScripts')

<script src="https://maps.googleapis.com/maps/api/js?key=<?= getStoreSettings('google_map_key') ?>&libraries=places&callback=initialize" async defer></script>
<script type="text/javascript">

    document.getElementById('userUploadFileButton').addEventListener('click', openDialog);

    function openDialog() {
      document.getElementById('file-input').click();
  }


  function initialize() {

    $('form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    }); 


    const locationInputs = document.getElementsByClassName("map-input");
    const autocompletes = [];
    const geocoder = new google.maps.Geocoder;


    $('.next-location').on('click', function(e) {

       const locationInputsAddress = document.getElementById("address-input").value;

       geocoder.geocode({'address': locationInputsAddress}, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            const lat = results[0].geometry.location.lat();
            const lng = results[0].geometry.location.lng();

            document.getElementById("address-latitude").value = lat;
            document.getElementById("address-longitude").value = lng;

        }
    });
   });

    for (let i = 0; i < locationInputs.length; i++) {

        const input = locationInputs[i];
        const fieldKey = input.id.replace("-input", "");
        const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-longitude").value != '';

        const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || -33.8688;
        const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 151.2195;

        const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
            center: {lat: latitude, lng: longitude},
            zoom: 13
        });
        const marker = new google.maps.Marker({
            map: map,
            position: {lat: latitude, lng: longitude},
        });

        marker.setVisible(isEdit);

        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.key = fieldKey;
        autocompletes.push({input: input, map: map, marker: marker, autocomplete: autocomplete});
    }

    for (let i = 0; i < autocompletes.length; i++) {
        const input = autocompletes[i].input;
        const autocomplete = autocompletes[i].autocomplete;
        const map = autocompletes[i].map;
        const marker = autocompletes[i].marker;

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            marker.setVisible(false);
            const place = autocomplete.getPlace();

            // geocoder.geocode({'placeId': place.place_id}, function (results, status) {
            //     if (status === google.maps.GeocoderStatus.OK) {
            //         const lat = results[0].geometry.location.lat();
            //         const lng = results[0].geometry.location.lng();
            //         setLocationCoordinates(autocomplete.key, lat, lng, place);
            //     }
            // });

            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                input.value = "";
                return;
            }

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

        });
    }
}


function setLocationCoordinates(key, lat, lng, placeData) {

    __DataRequest.post("<?= route('user.write.location_data') ?>", {
        'latitude': lat,
        'longitude': lng,
        'placeData': placeData.address_components
    }, function(responseData) {
        var requestData = responseData.data;
        __DataRequest.updateModels('profileData', {
            city: requestData.city,
            country_name: requestData.country_name
        });

        // if (responseData.reaction == 1) {
        //     _.defer(function() {
        //         checkProfileStatus();
        //     });
        // }

        var mapSrc = "https://maps.google.com/maps/place?q="+lat+","+lng+"&output=embed";
        $('#gmap_canvas').attr('src', mapSrc);
    });
};

    // Get user profile data
    function getUserProfileData(response) {
        // If successfully stored data
        if (response.reaction == 1) {
            __DataRequest.get("<?= route('user.get_profile_data', ['username' => getUserAuthInfo('profile.username')]) ?>", {}, function(responseData) {
                var requestData = responseData.data;
                var specificationUpdateData = [];
                _.forEach(requestData.userSpecificationData, function(specification) {
                    _.forEach(specification['items'], function(item) {
                        specificationUpdateData[item.name] = item.value;
                    });
                });

                __DataRequest.updateModels('profileData', requestData.userProfileData);

            });
        }
    }
</script>
@endpush

<!-- include footer -->
@include('includes.footer')
<!-- /include footer -->

<script  src="{{ asset('public/frontend/js/script.js') }}"></script>
<script  src="{{ asset('public/frontend/js/registration-profile.js') }}"></script>

<script type="text/javascript">


    $(document).ready(function() {

          //toggle the component with class accordion_body
          $(".infoSelector").click(function(e) {
            var itemValue = $(this).attr('value');
            var itemText =  $(this).attr('text-value');

            $(this).closest('.ex-accordion_body').prev('.ex-accordion_head').find('.seletced-profile-item').html(itemText);
            $(this).closest('.user-profile-items').find('input').val(itemValue);

        });
          setTimeout(function(){
           $('.ex-accordion_container .ex-accordion_head:first-child').click();
           $('.ex-accordion_container .ex-accordion_head.sec:first-child').click();
       },2000);

      //toggle the component with class accordion_body
      $(".ex-accordion_head").click(function(e) {
        e.preventDefault();
        if ($('.ex-accordion_body').is(':visible')) {
          $(".ex-accordion_body").slideUp(300);
          $(".ex-plusminus").text('+');
      }
      if ($(this).next(".ex-accordion_body").is(':visible')) {
          $(this).next(".ex-accordion_body").slideUp(300);
          $(this).removeClass('arrow-cus');
          $(this).children(".ex-plusminus").text('+');
      } else {
          $(this).next(".ex-accordion_body").slideDown(300);
          $(this).addClass('arrow-cus');
          $(this).children(".ex-plusminus").text('-');
      }
  });  

//     imgInp.onchange = evt => {
//       const [file] = imgInp.files;
//       if (file) {
//         blah.src = URL.createObjectURL(file);
//     }
// }

// Username Suggest

$("#username-suggest-button").click(function(e){
    e.preventDefault();
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
    $.ajax({
      type:'POST',
      url:"{{ url('username-suggest') }}",
      dataType : 'json',
      success:function(data){
          if(data){
              $(".username-input-field").val(data.username);
          }
      }

  });
    return false;
});


// User Tag Saved
$(".firstStepSubmitButton").hide();
$("#userUploadFileButtonfileid").click(function(e){

 $(".firstStepSubmitButton").show();

});

$(".user-profile-tag").click(function(e){
    e.preventDefault();

    var selectedTag = $(this).attr('value');
    var selectedID =  $(this).attr('data-id');

    if ($(this).hasClass("tag_selected")) {
        $(this).find('.user-tag-sign').html(' + ');
        $('.'+selectedTag).val('');
        $(this).removeClass("tag_selected");
    }else{
     $(this).addClass("tag_selected");
     $('.'+selectedTag).val(selectedID);  
     $(this).find('.user-tag-sign').html(' - ');
 }

});
// Username manual type




$(".username-input-field").keyup(function(e){
    e.preventDefault();
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

    if($(this).val() == ''){
        $('.btn-opecity-profile').removeClass('btn-opecity-profile');
    }
    if($('.username-input-field').val().length > 3 )
    {
        $.ajax({
          type:'POST',
          url:"{{ url('username-exists') }}",
          dataType : 'json',
          data : {username:$(this).val()},
          success:function(data){

            console.log(data.avaliable);
            if(data.avaliable == true){
                $(".username-message").html('<div data-cy-message="success" class="FormFieldMessage username_success" style="color: rgb(92, 190, 76); display: block;" validateUser="avalible">Good choice for a username!</div>');
                $('.firstStepSubmitButton').removeClass('btn-opecity-profile');
                $(':input[name="submit-step-1"]').prop('disabled', false);
            }else{
              $(':input[name="submit-step-1"]').prop('disabled', true);
              $(".username-message").html('<div data-cy-message="success" class="FormFieldMessage username_success" style="color: red; display: block;" validateUser="exists">Username already exits!</div>');
              $('.firstStepSubmitButton').addClass('btn-opecity-profile');


          }
      }

  });
    }
    return false;
});

$("div#lwUserEditableLocation input#address-input").keyup(function(e){
    e.preventDefault();
    if($(this).val() == ''){
        $('fieldset.step-2 .next').addClass('btn-opecity-profile');
        return false;
    }else{
        $('fieldset.step-2 .next').removeClass('btn-opecity-profile');
    }


});

jQuery('.step-3 .profile-info-content-types li').click(function(){
    var body_type_value = $('.body_type_value').val();
    var ethnicity_value = $('.ethnicity_value').val();
    var selectedOption = $( ".ppm-form-select option:selected" ).val();
    if(body_type_value == '' || ethnicity_value == '' || selectedOption == ''){
        $('fieldset.step-3 .next').addClass('btn-opecity-profile');
        return false;
    }else{
        $('fieldset.step-3 .next').removeClass('btn-opecity-profile');
    }
});

jQuery('.step-4 .profile-info-content-types ').click(function(){
    var education_level = $('.education_level.education').val();
    var relationship_level = $('.relationship_level').val();
    var children = $('.education_level.children').val();
    var smoke = $('.education_level.smoke').val();
    var drink = $('.education_level.drink').val();
    if(education_level == '' || relationship_level == '' || children == '' || smoke == '' || drink == ''){
        $('fieldset.step-4 .next').addClass('btn-opecity-profile');
        return false;
    }else{
        $('fieldset.step-4 .next').removeClass('btn-opecity-profile');
    }
});

$('.ppm-form-select').on('change', function (e) {
    var valueSelected = this.value;
    if(valueSelected != ''){
        jQuery('.seletced-profile-item.looking').text(valueSelected);
    }
    var body_type_value = $('.body_type_value').val();
    var ethnicity_value = $('.ethnicity_value').val();
    if(body_type_value == '' || ethnicity_value == '' || valueSelected == ''){
        $('fieldset.step-3 .next').addClass('btn-opecity-profile');
        return false;
    }else{
        $('fieldset.step-3 .next').removeClass('btn-opecity-profile');
    }
});

$('.step-5 select.profile-info-dropdown.new_worth').on('change', function (e) {
    var new_worth = this.value;
    var income = $( ".step-5 select.profile-info-dropdown.income option:selected" ).val();
    if(new_worth == '' || income == ''){
        $('fieldset.step-5 .next').addClass('btn-opecity-profile');
        return false;
    }else{
        $('fieldset.step-5 .next').removeClass('btn-opecity-profile');
    }
});
$('.step-5 select.profile-info-dropdown.income').on('change', function (e) {
    var income = this.value;
    var new_worth = $( ".step-5 select.profile-info-dropdown.new_worth option:selected" ).val();
    if(new_worth == '' || income == ''){
        $('fieldset.step-5 .next').addClass('btn-opecity-profile');
        return false;
    }else{
        $('fieldset.step-5 .next').removeClass('btn-opecity-profile');
    }
});


jQuery('.step-6 .tag.user-profile-tag').click(function(){
    if(jQuery('.step-6 .tag.user-profile-tag').hasClass("tag_selected")){
        $('fieldset.step-6 .next').removeClass('btn-opecity-profile');
    }else{
        $('fieldset.step-6 .next').addClass('btn-opecity-profile');
    }
});

$(".step-7 .eye-catching").keyup(function(e){
    e.preventDefault();
    var head_length = $(this).val().length;
    if(head_length == ''){
        jQuery('.step-7 .heading-group .error_msg').show();
        jQuery('.step-7 .heading-group .error_msg').text('You are missing your heading.');
    }else if(head_length > 0 && head_length <= 1){           
        jQuery('.step-7 .heading-group .error_msg').text('This value is too short. It should have 4 characters or more.');
    }else if(head_length > 3){    
        jQuery('.step-7 .heading-group .error_msg').hide();
    }else{
        jQuery('.step-7 .heading-group .error_msg').show();
        jQuery('.step-7 .heading-group .error_msg').text('This value is too short. It should have 4 characters or more.');   
    }
    var tlength = jQuery('.step-7 textarea').val().length;
    if($(this).val() != '' && tlength > 50 && head_length > 3){
        $('.step-7 .finish').removeClass('btn-opecity-profile');
    }else{
        $('.step-7 .finish').addClass('btn-opecity-profile');
    }


});

jQuery('.step-7 textarea').keyup(function () {
    var tlength = $(this).val().length;
    jQuery('#remain').text(tlength);
    if(tlength == ''){
        jQuery('.step-7 .textarea-group .error_msg').show();
        jQuery('.step-7 .textarea-group .error_msg').text('You are missing your description.');
    }else if(tlength > 0 && tlength <= 1){           
        jQuery('.step-7 .textarea-group .error_msg').text('This is too short. It should have 50 characters or more.');
    }else if(tlength > 50){    
        jQuery('.step-7 .textarea-group .error_msg').hide();   
        jQuery('.step-7 .textarea-group .text-char').css('color','rgb(13, 184, 0)');
        jQuery('.step-7 .textarea-group .text-char .con_length').text('/4000 characters');
    }else{    
        jQuery('.step-7 .textarea-group .error_msg').show();  
        jQuery('.step-7 .textarea-group .error_msg').text('This is too short. It should have 50 characters or more.');
        jQuery('.step-7 .textarea-group .text-char').css('color','#c33');
        jQuery('.step-7 .textarea-group .text-char .con_length').text('/50 characters minimum.');
    }
    if($('.step-7 .eye-catching').val() != '' && tlength > 50){
        $('.step-7 .finish').removeClass('btn-opecity-profile');
    }else{
        $('.step-7 .finish').addClass('btn-opecity-profile');
    }
});

jQuery(document).on('click', 'ul#progressbar li.active', function(e){
    e.preventDefault();
    var currentLI = jQuery(this).index();
    jQuery('.user-profile-steps fieldset').hide();
    jQuery('.step-'+currentLI+'').show();
    jQuery('.step-'+currentLI+'').css('opacity','1').css('transform','revert').css('position','revert');
});
});
</script>
<!-- /include footer -->