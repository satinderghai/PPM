@extends('public-master')
@section('content')

@section('page-title', strip_tags($userData['userName']))
@section('head-title', strip_tags($userData['userName']))
@section('page-url', url()->current())

@if(isset($userData['aboutMe']))
@section('keywordName', strip_tags($userProfileData['aboutMe']))
@section('keyword', strip_tags($userProfileData['aboutMe']))
@section('description', strip_tags($userProfileData['aboutMe']))
@section('keywordDescription', strip_tags($userProfileData['aboutMe']))
@endif

@if(isset($userData['profilePicture']))
@section('page-image', $userData['profilePicture'])
@endif
@if(isset($userData['coverPicture']))
@section('twitter-card-image', $userData['coverPicture'])
@endif

<style type="text/css">
    .action-button {
        width: fit-content;
        background: #F51B1C;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 5px;
        cursor: pointer;
        padding: 10px 20px;
        margin: 10px 5px;
    }
</style>
<!-- if user block then don't show profile page content -->
@if($isBlockUser)
<!-- info message -->
<div class="alert alert-info">
  <?= __tr('This user is unavailable.') ?>
</div>
<!-- / info message -->
@elseif($blockByMeUser)
<!-- info message -->
<div class="alert alert-info">
  <?= __tr('You have blocked this user.') ?>
</div>
<!-- / info message -->
@else


<!-- Begin Page Content -->

<div class="lw-page-content">

    <!-- header advertisement -->

    <div class="lw-ad-block-h90">

    </div>

    <div class="card mobile-view-none ">

     <div class="card-header ">

      <!-- <h4><i class="fa-solid fa-user" style="color:#F51B1C; border:none !important;"></i>My Profile</h4> -->


      <div class="row">

          <div class="col-sm-12">

            <div class="ProfileInfoCard">
                <div class="ProfileInfoCard-content" style="width: 100%;">
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">
                        <h1 class="ProfileInfoCard-title" style="margin-right: 8px; margin-bottom: 8px;" data-cy="member-right-username"><span class="css-14op033" style="padding: 0px; display: inline;">{{ Auth::user()->username }}</span><span class="css-aa5qdl"></span></h1>
                        <a class="lw-icon-btn" href role="button" id=""  data-toggle="modal" data-target="#userSmallProfileEditPopup">
                            <i class="fa fa-pencil-alt"></i>
                        </a>

                    </div><div>
                      <!-- <p data-cy="heading-txt" class="ProfileInfoCard-bio">{{ $userData['userName'] }}</p> -->
                      <p class="ProfileInfoCard-heading" style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;"><span>{{ $userData['userAge'] }} • </span><span>
                       @if($userData['gender_selection'] == 1)
                       Male
                       @endif
                       @if($userData['gender_selection'] == 2)
                       Female
                       @endif
                   </span><span> • {{ $userData['UserProfile']->city }}</span></p>
                   <p data-cy="heading-txt" class="ProfileInfoCard-bio">{{ $userData['UserProfile']->heading }}</p>
               </div>
           </div>
       </div>
   </div>     
</div>

</div>

</div>

<div class="card mb-3 bg-white p-3">

    <div class="upload-img">

      <div class="row">

          <div class="col-sm-12">

           <div class="profile d-md-none">

               <div class="user-profile">

                <div class="user-about-short">

                      <a class="lw-icon-btn" href role="button" id=""  data-toggle="modal" data-target="#userSmallProfileEditPopup">
                        <i class="fa fa-pencil-alt"></i>
                    </a>

                    <div class="mobile-short-details">
                        <h4>{{ Auth::user()->username }}</h4>

                        <p class="ProfileInfoCard-heading" style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;"><span>{{ $userData['userAge'] }} • </span><span>
                           @if($userData['gender_selection'] == 1)
                           Male
                           @endif
                           @if($userData['gender_selection'] == 2)
                           Female
                           @endif
                       </span><span> • {{ $userData['UserProfile']->city }}</span></p>

                       <p data-cy="heading-txt" class="ProfileInfoCard-bio">{{ $userData['UserProfile']->heading }}</p>
                   </div>
               </div>

           </div>

       </div>

   </div>

</div>

<div class="row loaded_images">

    @forelse ($userData['userPhotoCollection'] as $key => $collections)


    @if($collections->type == 1)

    <?php  $imageType = 'public'; ?>
    @else
    <?php $imageType = 'private';  ?>
    @endif
    <?php  $imgURL = url('/').'/media-storage/users/'.getUserUID().'/'.$imageType.'/'.$collections->file; ?>


    <div class="col-4 col-sm-4 col-lg-3 col-md-3 p-1 ">

       <div class="image-box">

           <i class="fa-solid fa-lock lock"></i>

           <img class="upload-images" src="{{ $imgURL }}">

       </div>

   </div>

   @empty
   @endforelse 



   <div class="col-4 col-sm-4 col-lg-3 col-md-3 p-1 ">

       <div class="image-box add-new-image">

           <a data-toggle="modal" data-target="#userPhottoPopup">

              <i class="fa-solid fa-upload"></i>

              <p>Add New Image</p>

          </a>

      </div>

  </div>


</div>

</div>

</div>







<!-- /User Profile and Cover photo -->

<!-- User Basic Information -->

<div class="card mb-3 d-md-none">            

    <!-- Basic information Header -->

    <div class="card-header">

        <!-- Check if its own profile -->

        <span class="float-right">

          <a class="lw-icon-btn" href role="button" id=""  data-toggle="modal" data-target="#userProfilePopup">

            <i class="fa fa-pencil-alt"></i>

        </a>



        <a class="lw-icon-btn" href role="button" id="lwCloseBasicInfoEditBlock" style="display: none;">

            <i class="fa fa-times"></i>

        </a>

    </span>

    <!-- /Check if its own profile -->

    <h5>Information</h5>

</div>

<!-- /Basic information Header -->

<!-- Basic Information content -->

<div class="card-body">

    <!-- Heading -->

    <li class="nav-item d-flex justify-content-between p-2">

        <span>Member Since</span><span><?= date("M d, Y", strtotime($userData['UserProfile']->created_at)); ?></span>
    </li>


    <li class="nav-item d-flex justify-content-between">

      <span><i class="fa-solid fa-circle-question"></i><a href="{{ url('settings') }}">Get your ID Verified</a> </span><span> </span>

  </li>

  <li class="nav-item d-flex justify-content-between">

      <span><i class="fa-solid fa-circle-question"></i><a href="{{ url('settings') }}">Verify your Photos</a> </span><span> </span>

  </li>

  <li class="nav-item d-flex justify-content-between">

      <span><i class="fa-solid fa-circle-question"></i><a href="{{ url('settings') }}">Connect your Facebook </a>   </span><span></span>

  </li>

  <li class="nav-item d-flex justify-content-between">

      <span><i class="fa-solid fa-circle-question"></i><a href="{{ url('settings') }}">Connect your Instagram</a> </span><span></span>

  </li>

  <li class="nav-item d-flex justify-content-between">

      <span><i class="fa-solid fa-circle-question"></i><a href="{{ url('settings') }}">Connect your LinkedIn</a> </span><span> </span>

  </li>


</div>

</div>







<!-- User Basic Information -->

<div class="card mb-3">            

    <!-- Basic information Header -->

    <div class="card-header">

        <!-- Check if its own profile -->

        <span class="float-right">

            <a class="lw-icon-btn" href role="button" id=""  data-toggle="modal" data-target="#userProfilePopup">

                <i class="fa fa-pencil-alt"></i>

            </a>

            <a class="lw-icon-btn" href role="button" id="lwCloseBasicInfoEditBlock" style="display: none;">

                <i class="fa fa-times"></i>

            </a>

        </span>

        <!-- /Check if its own profile -->

        <h5> Basic Information</h5>



    </div>

    <!-- /Basic information Header -->

    <!-- Basic Information content -->

    <div class="card-body">

        <!-- Static basic information container -->

        <div id="lwStaticBasicInformation">

            <div class="form-group row">

                <!-- First Name -->

                <div class="col-4 col-sm-4 mb-3 mb-sm-0">

                    <label for="looking_for"><strong><?= __tr('Looking For') ?></strong></label>


                    <div class="lw-inline-edit-text" data-model="userData.interest_selection">
                        @if($userData['interest_selection'] == 1)
                        Men
                        @elseif($userData['interest_selection'] == 2)
                        Women
                        @else
                        -
                        @endif
                    </div>

                </div>

                <div class="col-4 col-sm-4">

                    <label for="net_Worth"><strong><?= __tr('Net Worth') ?></strong></label>
                    <div class="lw-inline-edit-text" data-model="userData.last_name">{{ $userData['UserProfile']->user_net_worth ? $userData['UserProfile']->user_net_worth : '-' }}</div>

                </div>



                <div class="col-4 col-sm-4 mb-3 mb-sm-0">

                    <label for="annual_income"><strong><?= __tr('Annual Income') ?></strong></label>
                    <div class="lw-inline-edit-text" data-model="profileData.gender_text">
                        {{ $userData['UserProfile']->user_annual_income ? $userData['UserProfile']->user_annual_income : '-' }}
                    </div>

                </div>

            </div>


            <div class="form-group row">

                <!-- Gender -->


                <div class="col-4 col-sm-4">

                    <label><strong><?= __tr('Ethnicity') ?></strong></label>
                    <div class="lw-inline-edit-text" data-model="profileData.formatted_preferred_language">
                        {{ $userData['UserProfile']->user_ethnicity ? $userData['UserProfile']->user_ethnicity : '-' }}
                    </div>

                </div>



                <div class="col-4 col-sm-4 mb-3 mb-sm-0">
                    <label><strong><?= __tr('Children') ?></strong></label>
                    <div class="lw-inline-edit-text" data-model="profileData.formatted_relationship_status">
                        {{ $userData['UserProfile']->children ? $userData['UserProfile']->children : '-' }}
                    </div>

                </div>


                <div class="col-4 col-sm-4">
                    <label for="education"><strong><?= __tr('Education') ?></strong></label>
                    <div class="lw-inline-edit-text" data-model="profileData.formatted_work_status">
                       {{ $userData['UserProfile']->user_education ? $userData['UserProfile']->user_education : '-' }}
                   </div>

               </div>



           </div>

           <div class="form-group row">


            <div class="col-4 col-sm-4 mb-3 mb-sm-0">

                <label for="smokes"><strong><?= __tr('Smokes') ?></strong></label>
                <div class="lw-inline-edit-text" data-model="profileData.formatted_education">


                    @if($userData['UserProfile']->smoke == 1)
                    Non Smoker
                    @elseif($userData['UserProfile']->smoke == 2)
                    Light Smoker
                    @elseif($userData['UserProfile']->smoke == 3)
                    Heavy Smoker
                    @else
                    -
                    @endif
                </div>

            </div>


            <div class="col-4 col-sm-4">

                <label for="body_type"><strong><?= __tr('Body Type') ?></strong></label>
                <div class="lw-inline-edit-text" data-model="profileData.birthday">
                   {{ $userData['UserProfile']->user_body_type ? $userData['UserProfile']->user_body_type : '-' }}
               </div>
           </div>


           <div class="col-4 col-sm-4 mb-3 mb-sm-0">

            <label for="occupation_industry"><strong><?= __tr('Occupation Industry') ?></strong></label>
            <div class="lw-inline-edit-text" data-model="profileData.mobile_number">
              {{ $userData['UserProfile']->occupation_industry ? $userData['UserProfile']->occupation_industry : '-' }}
          </div>

      </div>




      <!-- /Work Status -->


      <!-- Education -->


  </div>

  <div class="form-group row">




      <div class="col-4 col-sm-4 mb-3 mb-sm-0">

        <label for="drinks"><strong><?= __tr('Drinks') ?></strong></label>
        <div class="lw-inline-edit-text" data-model="profileData.mobile_number">
           @if($userData['UserProfile']->drink == 1)
           Non Drinker
           @elseif($userData['UserProfile']->drink == 2)
           Light Drinker
           @elseif($userData['UserProfile']->drink == 3)
           Heavy Drinker
           @else
           -
           @endif

       </div>

   </div>


   <div class="col-4 col-sm-4">

     <label for="height"><strong><?= __tr('Height') ?></strong></label>
     <div class="lw-inline-edit-text" data-model="profileData.mobile_number">
        {{ $userData['UserProfile']->height ? $userData['UserProfile']->height  : '-' }}
    </div>


</div>

<div class="col-4 col-sm-4 mb-3 mb-sm-0">

    <label for="relationship"><strong><?= __tr('Relationship') ?></strong></label>
    <div class="lw-inline-edit-text" data-model="profileData.mobile_number">
      {{ $userData['UserProfile']->relationship_status ? $userData['UserProfile']->relationship_status : '-' }}
  </div>

</div>

</div>
</div>
</div>

</div>







<!-- /User Basic Information -->

<div class="card mb-3">

    <div class="card-header">

        <span class="float-right">

            <a class="lw-icon-btn" href role="button" id="" data-toggle="modal" data-target="#userAboutMePopup">

                <i class="fa fa-pencil-alt"></i>

            </a>

            <a class="lw-icon-btn" href role="button" id="lwCloseLocationBlock" style="display: none;">

                <i class="fa fa-times"></i>

            </a>

        </span>

        <h5>About</h5>

    </div>

    <div class="card-body about-me-section">

        <!-- info message -->

        <p><?= $userData['UserProfile']->about_me ?></p>

    </div>

</div>



<!-- /User Basic Information -->

<div class="card mb-3">

    <div class="card-header">

        <span class="float-right">

            <a class="lw-icon-btn" href role="button" id="" data-toggle="modal" data-target="#userLookingForPopup">

                <i class="fa fa-pencil-alt"></i>

            </a>

            <a class="lw-icon-btn" href role="button" id="lwCloseLocationBlock" style="display: none;">

                <i class="fa fa-times"></i>

            </a>

        </span>

        <h5>Looking For</h5>

    </div>

    <div class="card-body looking_for_section">

       <div class="tag-group">
        @if(isset($userData['UserProfile']->user_tag))
        @forelse (unserialize($userData['UserProfile']->user_tag) as $key => $selectedTag)
        <?php  $tagData = \App\Exp\Components\User\Models\UserTag::find($selectedTag);  ?>
        @if($tagData)
        <button class="tag"><?php echo $tagData->name; ?><i class="fa-solid fa-plus"></i></button>
        @endif
        @empty
        <p class="mt-3">CleverHottie hasn't filled out this section yet.</p>
        @endforelse   
        @endif

    </div>

    <div class="tag-group">
      <span>  <?= $userData['UserProfile']->what_are_you_seeking ?></span>

  </div>


</div>

<!-- /User Specifications -->

</div>

</div>

@endif
<!-- /if user block then don't show profile page content -->


<!-- Usert Photto Model -->

<div class="modal fade" id="userPhottoPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0  text-center">
        <h5 class="modal-title text-center" id="exampleModalLabel">Add a new photo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <hr />
  <form class="userPhottoForm" id="userPhottoForm" method="post" enctype="multipart/form-data">
   <input type="hidden" id="phottoFromInput" name="phottoFrom">
   <div class="modal-body">

       <div class="form-group text-center">
        <input id='userUploadPublicPhottoButton' name="public_profile_picture" type='file' hidden/>
        <input id='userPublicUploadFileButton' class="action-button" type='button' value='Add a public photo' />

    </div>

    <div class="form-group text-center">
      <input id='userUploadPrivatePhottoButton' name="private_profile_picture" type='file' hidden/>
      <input id='userPrivateUploadFileButton' class="action-button" type='button' value='Add a private photo' />      
  </div>

</div>
<hr />
<div class="modal-footer border-top-0 d-flex justify-content-center">
    <p class="css-naj1a3">Private photo can only be seen by members that you have shared access with.</p>

    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
      Cancel
  </button>
  <button type="submit" class="btn btn-success">Submit</button>
</div>
</form>
</div>
</div>
</div>



<!-- Information Edit Popup -->

<div class="modal fade" id="userProfilePopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title text-center" id="exampleModalLabel">Edit Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <hr />
  <form class="basicInfoSectionForm" id="basicInfoSectionForm" method="post" data-show-message="true" action="<?= route('user.write.basic_setting') ?>">
     <input type="hidden" name="action" value="secondStepUserEditForm">
     <div class="modal-body">
      <div class="form-group">
        <label for="email1">Net Worth</label>       


        <select name="net_worth" class="form-control" id="net_worth">
            @foreach($userData['netWorth'] as $key => $net)
            <option value="<?= $net['_id'] ?>"    <?= ($net['_id'] == $userData['UserProfile']->net_worth) ? 'selected' : '' ?> >$<?= $net['name'] ?></option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="email1">Annual Income</label>       


        <select name="income" class="form-control" id="net_worth">
            @foreach($userData['annualIncome'] as $key => $annual)
            <option value="<?= $annual['_id'] ?>"    <?= ($annual['_id'] == $userData['UserProfile']->income) ? 'selected' : '' ?> >$<?= $annual['name'] ?></option>
            @endforeach
        </select>
    </div>


    <div class="form-group">
        <label for="email1">Looking for</label>       


        <label class="css-kzbnq6 css-aan59y">
            <input type="checkbox" name="interest_selection[]" data-cy="male-checkbox" value="1"><span class="css-pwa2jd">Men</span>
        </label>

        <label class="css-kzbnq6 css-aan59y">
            <input type="checkbox" name="interest_selection[]" data-cy="female-checkbox" value="2" checked=""><span class="css-pwa2jd">Women</span>
        </label>

    </div>

    <div class="form-group">
        <label for="email1">Preferred Ages</label>       

        <div class="css-16wohxm">
            <input type="range" class="form-control" name="age" min="18" max="60" value="18">
        </div>
    </div>


    <div class="form-group">
        <label for="email1">Body Type</label>       


        <select name="body_type" class="form-control" id="body_type">
            @foreach($userData['bodyType'] as $key => $bodytypeval)
            <option value="<?= $bodytypeval['_id'] ?>"  <?= ($bodytypeval['_id'] == $userData['UserProfile']->body_type) ? 'selected' : '' ?> ><?= $bodytypeval['name'] ?></option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="email1">Height</label>    
        <select name="height" class="ppm-form-select" >
            <option text-value="137 cm" class="infoSelector" value="137">137 cm</option>
            <option text-value="138 cm" class="infoSelector" value="138">138 cm</option>
            <option text-value="139 cm" class="infoSelector" value="139">139 cm</option>
            <option text-value="140 cm" class="infoSelector" value="140">140 cm</option>
            <option text-value="141 cm" class="infoSelector" value="141">141 cm</option>
            <option text-value="142 cm" class="infoSelector" value="142">142 cm</option>
            <option text-value="143 cm" class="infoSelector" value="143">143 cm</option>
            <option text-value="144 cm" class="infoSelector" value="144">144 cm</option>
            <option text-value="145 cm" class="infoSelector" value="145">145 cm</option>
            <option text-value="146 cm" class="infoSelector" value="146">146 cm</option>
            <option text-value="147 cm" class="infoSelector" value="147">147 cm</option>
            <option text-value="148 cm" class="infoSelector" value="148">148 cm</option>
            <option text-value="149 cm" class="infoSelector" value="149">149 cm</option>
            <option text-value="150 cm" class="infoSelector" value="150">150 cm</option>
            <option text-value="151 cm" class="infoSelector" value="151">151 cm</option>
            <option text-value="152 cm" class="infoSelector" value="152">152 cm</option>
            <option text-value="153 cm" class="infoSelector" value="153">153 cm</option>
            <option text-value="154 cm" class="infoSelector" value="154">154 cm</option>
            <option text-value="155 cm" class="infoSelector" value="155">155 cm</option>
            <option text-value="156 cm" class="infoSelector" value="156">156 cm</option>
            <option text-value="157 cm" class="infoSelector" value="157">157 cm</option>
            <option text-value="158 cm" class="infoSelector" value="158">158 cm</option>
            <option text-value="159 cm" class="infoSelector" value="159">159 cm</option>
            <option text-value="160 cm" class="infoSelector" value="160">160 cm</option>
            <option text-value="161 cm" class="infoSelector" value="161">161 cm</option>
            <option text-value="162 cm" class="infoSelector" value="162">162 cm</option>
            <option text-value="163 cm" class="infoSelector" value="163">163 cm</option>
            <option text-value="164 cm" class="infoSelector" value="164">164 cm</option>
            <option text-value="165 cm" class="infoSelector" value="165">165 cm</option>
            <option text-value="166 cm" class="infoSelector" value="166">166 cm</option>
            <option text-value="167 cm" class="infoSelector" value="167">167 cm</option>
            <option text-value="168 cm" class="infoSelector" value="168">168 cm</option>
        </select>
    </div>



    <div class="form-group">
        <label for="email1">Ethnicity</label>       


        <select name="ethnicity" class="form-control" id="ethnicity">
            @foreach($userData['ethnicity'] as $key => $ethnicityval)
            <option value="<?= $ethnicityval['_id'] ?>"    <?= ($ethnicityval['_id'] == $userData['UserProfile']->ethnicity) ? 'selected' : '' ?> ><?= $ethnicityval['name'] ?></option>
            @endforeach
        </select>
    </div>


    <div class="form-group">
        <label for="email1">Education</label>       


        <select name="education" class="form-control" id="education">
            @foreach($userData['education'] as $key => $educationeval)
            <option value="<?= $educationeval['_id'] ?>"    <?= ($educationeval['_id'] == $userData['UserProfile']->education) ? 'selected' : '' ?> ><?= $educationeval['name'] ?></option>
            @endforeach
        </select>
    </div>



    <div class="form-group">
        <label for="email1">Occupation</label>       


        <select name="occupation" class="form-control" id="occupation">
            @foreach($userData['occupation'] as $key => $occupationval)
            <option value="<?= $occupationval['_id'] ?>"    <?= ($occupationval['_id'] == $userData['UserProfile']->occupation) ? 'selected' : '' ?> ><?= $occupationval['name'] ?></option>
            @endforeach
        </select>
    </div>



    <div class="form-group">
        <label for="email1">Relationship Status</label>       


        <select name="relationship_status" class="form-control" id="net_worth">
            @foreach($userData['relationshipStatus'] as $key => $relationshipStatusval)
            <option value="<?= $relationshipStatusval['_id'] ?>"    <?= ($relationshipStatusval['_id'] == $userData['UserProfile']->relationship_status) ? 'selected' : '' ?> ><?= $relationshipStatusval['name'] ?></option>
            @endforeach
        </select>
    </div>



    <div class="form-group">
        <label for="email1">Have Children?</label>       

        <select name="children" class="form-control" id="children">
            <option value="0" <?= ($userData['UserProfile']->children == 0) ? 'selected' : '' ?>>0</option>
            <option value="1" <?= ($userData['UserProfile']->children == 1) ? 'selected' : '' ?>>1</option>
            <option value="2" <?= ($userData['UserProfile']->children == 2) ? 'selected' : '' ?>>2</option>
            <option value="3" <?= ($userData['UserProfile']->children == 3) ? 'selected' : '' ?>>3</option>
            <option value="4" <?= ($userData['UserProfile']->children == 4) ? 'selected' : '' ?>>4</option>
            <option value="5" <?= ($userData['UserProfile']->children == 5) ? 'selected' : '' ?>>5</option>
            <option value="6" <?= ($userData['UserProfile']->children == 6) ? 'selected' : '' ?>>6+</option>
        </select>

    </div>


    <div class="form-group">
        <label for="email1">Smoke?</label>     

        <select name="smoke" class="form-control" id="smoke">

           <option value="">-</option>
           <option value="1" <?= ($userData['UserProfile']->smoke == 1) ? 'selected' : '' ?>>Non Smoker</option>
           <option value="2" <?= ($userData['UserProfile']->smoke == 2) ? 'selected' : '' ?>>Light Smoker</option>
           <option value="3" <?= ($userData['UserProfile']->smoke == 3) ? 'selected' : '' ?>>Heavy Smoker</option>

       </select>

   </div>

   <div class="form-group">
    <label for="email1">Drink?</label>     

    <select name="drink" class="form-control" id="smoke">
       <option value="">-</option>
       <option value="1" <?= ($userData['UserProfile']->drink == 1) ? 'selected' : '' ?>>Non Drinker</option>
       <option value="2" <?= ($userData['UserProfile']->drink == 2) ? 'selected' : '' ?>>Light Drinker</option>
       <option value="3" <?= ($userData['UserProfile']->drink == 3) ? 'selected' : '' ?>>Heavy Drinker</option>
   </select>

</div>

</div>
<hr />
<div class="modal-footer border-top-0 d-flex justify-content-center">
    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
      Cancel
  </button>
  <button type="submit" class="btn btn-success">Submit</button>
</div>
</form>
</div>
</div>
</div>


<!-- model close -->


<!-- About Us Model -->

<div class="modal fade" id="userAboutMePopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title text-center" id="exampleModalLabel">Edit About Me</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <hr />
  <form class="userAboutMeForm" id="userAboutMeForm" method="post" data-show-message="true" action="<?= route('user.write.basic_setting') ?>">
    <input type="hidden" name="action" value="aboutUsForm">
    <div class="modal-body">

       <div class="form-group">

        <textarea class="form-control" name="about_me" rows="8"> <?= $userData['UserProfile']->about_me ?></textarea>
    </div>

</div>
<hr />
<div class="modal-footer border-top-0 d-flex justify-content-center">
    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
      Cancel
  </button>
  <button type="submit" class="btn btn-success">Submit</button>
</div>
</form>
</div>
</div>
</div>


<!-- model close -->
<!-- About Us Model -->

<div class="modal fade" id="userSmallProfileEditPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title text-center" id="exampleModalLabel">Edit About Me</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <hr />

  <form class="userSmallProfileEditForm" id="userSmallProfileEditForm" method="post" data-show-message="true" action="<?= route('user.write.basic_setting') ?>">

    <input type="hidden" name="action" value="firstStepUserEditForm">
    <div class="modal-body">
      <div class="form-group">
        <label for="email1">Display name</label>       

        <input type="text" name="username" value="{{ $userData['userName'] }}" class="form-control">

    </div>
    <div class="form-group">
        <label for="email1">Primary Location</label>       

        <input id="profileLocationTextField" type="text" class="form-control" name="city" value="{{ $userData['UserProfile']->city }}" autocomplete="on">


    </div>
    <div class="form-group">
        <label for="email1">Heading</label>
        <input type="text" class="form-control" name="heading" value="{{ $userData['UserProfile']->heading }}" autocomplete="on">     
    </div>
</div>
<hr />
<div class="modal-footer border-top-0 d-flex justify-content-center">

    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
      Cancel
  </button>
  <button type="submit" class="btn btn-success">Submit</button>
</div>
</form>
</div>
</div>
</div>


<!-- model close -->



<!-- Looking For Model -->

<div class="modal fade" id="userLookingForPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title text-center" id="exampleModalLabel">What are you Seeking?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <hr />
  <form class="userLookingForForm" id="userLookingForForm" method="post" data-show-message="true" action="<?= route('user.write.basic_setting') ?>">
    <input type="hidden" name="action" value="lookingForForm">
    <div class="modal-body">

       <div class="form-group">


           @if($userData['userTag'])
           @forelse ($userData['userTag'] as $key => $tagList)

           <?php               
           if( in_array( $tagList['_id'] ,unserialize($userData['UserProfile']->user_tag) ) )
           {
            $tag_selected =  "tag_selected";
            $tag_value = 1;
        }else{
            $tag_selected =  "";
            $tag_value = '';
        }
        ?>

        <button class="tag user-profile-tag {{ $tag_selected }}" data-id="{{ $tagList['_id'] }}" value="{{ str_replace(' ', '-', $tagList['name']) }}">{{ $tagList['name'] }}<span class="user-tag-sign"> + </span></button>

        <input type="hidden" name="user_tag[]" value="{{ $tag_value }}" class="{{ str_replace(' ', '-', $tagList['name']) }}">
        @empty

        @endforelse  
        @endif


    </div>   
    <div class="form-group">
       <label>Describe what you're seeking (Optional)</label>
       <textarea class="form-control" name="what_are_you_seeking" rows="8"><?= $userData['UserProfile']->what_are_you_seeking ?></textarea>
   </div>

</div>
<hr />
<div class="modal-footer border-top-0 d-flex justify-content-center">
    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
      Cancel
  </button>
  <button type="submit" class="btn btn-success">Submit</button>
</div>
</form>
</div>
</div>
</div>


<!-- model close -->


@push('appScripts')
@if(getStoreSettings('allow_google_map'))
<script src="https://maps.googleapis.com/maps/api/js?key=<?= getStoreSettings('google_map_key') ?>&libraries=places&callback=initialize" async defer></script>
@endif
<script>

    document.getElementById('userPublicUploadFileButton').addEventListener('click', openDialogPublic);

    function openDialogPublic() {

        document.getElementById("phottoFromInput").value = "1";
        document.getElementById('userUploadPublicPhottoButton').click();
    }

    document.getElementById('userPrivateUploadFileButton').addEventListener('click', openDialogPrivate);

    function openDialogPrivate() {
       document.getElementById("phottoFromInput").value = "2";
       document.getElementById('userUploadPrivatePhottoButton').click();
   }

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
                __DataRequest.updateModels('userData', requestData.userData);
                __DataRequest.updateModels('profileData', requestData.userProfileData);
                __DataRequest.updateModels('specificationData', specificationUpdateData);
            });
        }
    }

    /**************** User Like Dislike Fetch and Callback Block Start ******************/

	//on like Callback function
	function onLikeCallback(response) {
		var requestData = response.data;
		//check reaction code is 1 and status created or updated and like status is 1
		if (response.reaction == 1 && requestData.likeStatus == 1 && (requestData.status == "created" || requestData.status == 'updated')) {
			__DataRequest.updateModels({
				'userLikeStatus' 	: '<?= __tr('Liked') ?>', //user liked status
				'userDislikeStatus' : '<?= __tr('Dislike') ?>', //user dislike status
			});
			//add class
			$(".lw-animated-like-heart").toggleClass("lw-is-active");
			//check if updated then remove class in dislike heart
			if (requestData.status == 'updated') {
				$(".lw-animated-broken-heart").toggleClass("lw-is-active");
			}
		}
		//check reaction code is 1 and status created or updated and like status is 2
		if (response.reaction == 1 && requestData.likeStatus == 2 && (requestData.status == "created" || requestData.status == 'updated')) {
			__DataRequest.updateModels({
				'userLikeStatus' 	: '<?= __tr('Like') ?>', //user like status
				'userDislikeStatus' : '<?= __tr('Disliked') ?>', //user disliked status
			});
			//add class
			$(".lw-animated-broken-heart").toggleClass("lw-is-active");
			//check if updated then remove class in like heart
			if (requestData.status == 'updated') {
				$(".lw-animated-like-heart").toggleClass("lw-is-active");
			}
		}
		//check reaction code is 1 and status deleted and like status is 1
		if (response.reaction == 1 && requestData.likeStatus == 1 && requestData.status == "deleted") {
			__DataRequest.updateModels({
				'userLikeStatus' 	: '<?= __tr('Like') ?>', //user like status
			});
			$(".lw-animated-like-heart").toggleClass("lw-is-active");
		}
		//check reaction code is 1 and status deleted and like status is 2
		if (response.reaction == 1 && requestData.likeStatus == 2 && requestData.status == "deleted") {
			__DataRequest.updateModels({
				'userDislikeStatus' 	: '<?= __tr('Dislike') ?>', //user like status
			});
			$(".lw-animated-broken-heart").toggleClass("lw-is-active");
		}
		//remove disabled anchor tag class
		_.delay(function() {
			$('.lw-like-dislike-box').removeClass("lw-disable-anchor-tag");
		}, 1000);
	}
	/**************** User Like Dislike Fetch and Callback Block End ******************/


	//send gift callback
	function sendGiftCallback(response) {
		//check success reaction is 1
		if (response.reaction == 1) {
			var requestData = response.data;
			//form reset after success
			$("#lwSendGiftForm").trigger("reset");
			//remove active class after success on select gift radio option
			$("#lwSendGiftRadioBtn_"+requestData.giftUid).removeClass('active');
			//close dialog after success
			$('#lwSendGiftDialog').modal('hide');
			//reload view after 2 seconds on success reaction
			_.delay(function() {
				__Utils.viewReload();
			}, 1000)
		//if error type is insufficient balance then show error message
  } else if (response.data['errorType'] == 'insufficient_balance') {
			//show error div
			$("#lwGiftModalErrorText").show();
		} else {
			//hide error div
			$("#lwGiftModalErrorText").hide();
		}
	}

	//close Send Gift Dialog
	$("#lwCloseSendGiftDialog").on('click', function(e) {
		e.preventDefault();
		//form reset after success
		$("#lwSendGiftForm").trigger("reset");
		//close dialog after success
		$('#lwSendGiftDialog').modal('hide');
	});

	//user report callback
	function userReportCallback(response) {
		//check success reaction is 1
		if (response.reaction == 1) {
			var requestData = response.data;
			//form reset after success
			$("#lwReportUserForm").trigger("reset");
			//close dialog after success
			$('#lwReportUserDialog').modal('hide');
			//reload view after 2 seconds on success reaction
			_.delay(function() {
				__Utils.viewReload();
			}, 1000)
		}
	}

	//close User Report Dialog
	$("#lwCloseUserReportDialog").on('click', function(e) {
		e.preventDefault();
		//form reset after success
		$("#lwReportUserForm").trigger("reset");
		//close dialog after success
		$('#lwReportUserDialog').modal('hide');
	});

	//block user confirmation
	$("#lwBlockUserBtn").on('click', function(e) {
		var confirmText = $('#lwBlockUserConfirmationText');
		//show confirmation 
		showConfirmation(confirmText, function() {
			var requestUrl = '<?= route('user.write.block_user') ?>',
            formData = {
               'block_user_id' : '<?= $userData['userUId'] ?>',
           };					
			// post ajax request
			__DataRequest.post(requestUrl, formData, function(response) {
				if (response.reaction == 1) {
					__Utils.viewReload();
				}
			});
		});
    });

    // Click on edit / close button 
    $('#lwEditBasicInformation, #lwCloseBasicInfoEditBlock').click(function(e) {
        e.preventDefault();
        showHideBasicInfoContainer();
    });
    // Show / Hide basic information container
    function showHideBasicInfoContainer() {
        // $('#lwUserBasicInformationForm').toggle();
        // $('#lwStaticBasicInformation').toggle();
        // $('#lwCloseBasicInfoEditBlock').toggle();
        // $('#lwEditBasicInformation').toggle();
    }
    // Show hide specification user settings
    function showHideSpecificationUser(formId, event) {
        event.preventDefault();
        $('#lwEdit'+formId).toggle();
        $('#lw'+formId+'StaticContainer').toggle();
        $('#lwUser'+formId+'Form').toggle();
        $('#lwClose'+formId+'Block').toggle();
    }
    // Click on profile and cover container edit / close button 
    $('#lwEditProfileAndCoverPhoto, #lwCloseProfileAndCoverBlock').click(function(e) {
        e.preventDefault();
        showHideProfileAndCoverPhotoContainer();
    });
    // Hide / show profile and cover photo container
    function showHideProfileAndCoverPhotoContainer() {
        $('#lwProfileAndCoverStaticBlock').toggle();
        $('#lwProfileAndCoverEditBlock').toggle();
        $('#lwEditProfileAndCoverPhoto').toggle();
        $('#lwCloseProfileAndCoverBlock').toggle();
    }
     // After successfully upload profile picture
     function afterUploadedProfilePicture(responseData) {
        $('#lwProfilePictureStaticImage, .lw-profile-thumbnail').attr('src', responseData.data.image_url);
    }
    // After successfully upload Cover photo
    function afterUploadedCoverPhoto(responseData) {
        $('#lwCoverPhotoStaticImage').attr('src', responseData.data.image_url);
    }
</script>
<script>
// Click on edit / close button 

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

            geocoder.geocode({'placeId': place.place_id}, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    const lat = results[0].geometry.location.lat();
                    const lng = results[0].geometry.location.lng();
                    setLocationCoordinates(autocomplete.key, lat, lng, place);
                }
            });

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
        showHideLocationContainer();
        var requestData = responseData.data;
        __DataRequest.updateModels('profileData', {
            city: requestData.city,
            country_name: requestData.country_name,
            latitude: lat,
            longitude: lng
        });
        var mapSrc = "https://maps.google.com/maps/place?q="+lat+","+lng+"&output=embed";
        $('#gmap_canvas').attr('src', mapSrc)
    });
};

// $(".lw-animated-heart").on("click", function() {
//     $(this).toggleClass("lw-is-active");
// });







$("body").on("submit", ".basicInfoSectionForm", function(e) {

    e.preventDefault();
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

    $.ajax({
      type:'POST',
      url:"{{ url('user/settings/process-basic-settings') }}",
      dataType : 'json',
      data :  $('#basicInfoSectionForm').serialize(),
      success:function(response){
       $('#userProfilePopup').modal('toggle');
       console.log(response.data.userData);
       $('#lwStaticBasicInformation').html(response.data.userData);

         // lwStaticBasicInformation


     }

 });

    return false;
});


$("body").on("submit", ".userSmallProfileEditForm", function(e) {

    e.preventDefault();
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

    $.ajax({
      type:'POST',
      url:"{{ url('user/settings/process-basic-settings') }}",
      dataType : 'json',
      data :  $('#userSmallProfileEditForm').serialize(),
      success:function(response){
       $('#userSmallProfileEditPopup').modal('toggle');
       $('.ProfileInfoCard').html(response.data.first_section_data);
       $('.mobile-short-details').html(response.data.mobileViewUserHTML);



   }

});

    return false;
});

$("body").on("submit", ".userAboutMeForm", function(e) {

    e.preventDefault();
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

    $.ajax({
      type:'POST',
      url:"{{ url('user/settings/process-basic-settings') }}",
      dataType : 'json',
      data :  $('#userAboutMeForm').serialize(),
      success:function(response){
       $('#userAboutMePopup').modal('toggle');
       $('.about-me-section').html(response.data.about_me_data);



   }

});

    return false;
});


$("body").on("submit", ".userPhottoForm", function(e) {

    e.preventDefault();
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
    $.ajax({
      type:'POST',
      url:"{{ url('user/settings/upload-photos') }}",
      dataType : 'json',
      data: new FormData(this),
      processData: false,
      contentType: false,
      success:function(response){
// if(response.data.message){

// }else{
    console.log(response.data.stored_photo.image_url);
    $('.loaded_images').html(response.data.stored_photo.image_url);
    $('#userPhottoPopup').modal('toggle');

// }
}

});

    return false;
});



$("body").on("submit", ".userLookingForForm", function(e) {

    e.preventDefault();
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

    $.ajax({
      type:'POST',
      url:"{{ url('user/settings/process-basic-settings') }}",
      dataType : 'json',
      data :  $('#userLookingForForm').serialize(),
      success:function(response){
       $('#userLookingForPopup').modal('toggle');
       $('.looking_for_section').html(response.data.looking_for);

   }

});

    return false;
});



$(document).ready(function() {

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
});
</script>
@endpush
@stop

