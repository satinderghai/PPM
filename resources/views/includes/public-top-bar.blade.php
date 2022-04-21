
<nav class="row navbar navbar-expand navbar-light topbar mb-4 static-top shadow menu-bar">

 <!-- Sidebar Toggle (Topbar) -->

 <button type="button" id="sidebarToggleTop" class="btn btn-link d-block d-md-none rounded-circle mr-3">

  <img class="lw-logo-img" src="<?= getStoreSettings('logo_image_url') ?>" alt="PPM">

</button>

<!-- Nav Item - Search Dropdown (Visible Only XS) -->
<?php $userProfileGet = \App\Exp\Components\User\Models\UserProfile::where('users__id',Auth::user()->_id)->first(); ?>

<div class="nav-item dropdown no-arrow d-flex">

  <div class="sidebar-brand d-flex align-items-center" href="home">

    <div class="sidebar-brand-icon">

        <img class="lw-logo-img" src="<?= getStoreSettings('logo_image_url') ?>" alt="PPM">

    </div>

    <a href="{{ url('/') }}">  <img class="lw-logo-img d-sm-none d-none d-md-block" src="<?= getStoreSettings('logo_image_url') ?>" alt="PPM"></a>

    <ul>
        <li class="nav-item dropdown no-arrow">

            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

               @if(isset($userProfileGet->profile_picture))
               <img class="img-profile rounded-circle" src="{{ asset('media-storage/users/') }}/{{ Auth::user()->_uid }}/profile/{{ $userProfileGet->profile_picture }}">                 @else               
               <img class="img-profile rounded-circle" src="{{ asset('imgs/no_thumb_image.jpg') }}">      
               @endif

           </a>
           <!-- Dropdown - User Information -->
           <div id="profile_drop_down"class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <div class="d-flex">
                <div class="img-profile-view">

                   @if(isset($userProfileGet->profile_picture))
                   <img class="img-profile rounded-circle" src="{{ asset('media-storage/users/') }}/{{ Auth::user()->_uid }}/profile/{{ $userProfileGet->profile_picture }}">                 @else               
                   <img class="img-profile rounded-circle" src="{{ asset('imgs/no_thumb_image.jpg') }}">      
                   @endif
               </div>
               <div>
                <p class="user-title">{{ Auth::user()->username }}</p>
                <p class="profile-type">Stander</p>
                <button class="upgrade-profile">Upgrade your profile</button>
            </div>
        </div>


        <div class="d-flex about-profile-button">
           <button class="web-button" onclick="window.location.href='<?= route("user.profile_view", ["username" => getUserAuthInfo('profile.username')]) ?>';">Edite Profile</button>

           <button class="web-button" onclick="window.location.href='<?= route("user.profile_view", ["username" => getUserAuthInfo('profile.username')]) ?>';">View Profile</button>

       </div>
       <div class="bost-profile-button">
        <button class="web-button">Boost Your Profile</button>
        <button class="web-button">Get Verification</button>
    </div>
    <div class="option-list">
        <p><i class="fa-solid fa-gear"></i><a href="{{ url('settings') }}">Setting</a></p>
        <p><i class="fa-solid fa-arrow-right-from-bracket"></i>

            <a href="#" data-toggle="modal" data-target="#logoutModal">
                <?= __tr('Logout Profile') ?>
            </a>
        </div>

    </div>
</li>
</ul>

</div>

<div class="d-flex align-items-center">

    <ul class="d-flex header-menu">

        <li> <a href="{{ url('search') }}"><i class="fa-solid fa-magnifying-glass"></i>Search</a></li>

        <li><i class="fa-solid fa-heart"></i>Interests</li>

        <li><i class="fa-solid fa-photo-film"></i>Events</li>

        <li><i class="fa-solid fa-comment-dots"></i>Message</li>

    </ul>

</div>  

</div>

<ul class="navbar-nav">

    <li class="nav-item d-none d-sm-none d-md-block">
        <a class="nav-link" onclick="getChatMessenger('<?= route('user.read.all_conversation') ?>', true)" id="lwAllMessageChatButton" data-chat-loaded="false" data-toggle="modal" data-target="#messengerDialog">
            <i class="far fa-comments"></i>
        </a>
    </li>

    <!-- Notification Link -->
    <!-- Notification Link -->
    <li class="nav-item dropdown no-arrow mx-1 d-none d-sm-none d-md-block">
        <a class="nav-link dropdown-toggle lw-ajax-link-action" href="<?= route('user.notification.write.read_all_notification') ?>" data-callback="onReadAllNotificationCallback" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-method="post">
            <i class="fas fa-bell fa-fw"></i>
            <span class="badge badge-danger badge-counter" data-model="totalNotificationCount"><?= (getNotificationList()['notificationCount'] > 0) ? getNotificationList()['notificationCount'] : '' ?></span>
        </a>
        <!-- Dropdown - Alerts -->
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">
                <?= __tr('Notification') ?>
            </h6>
            <!-- Notification block -->     
            <div id="lwNotificationContent"></div>
            <script type="text/_template" id="lwNotificationListTemplate">
                <% if(!_.isEmpty(__tData.notificationList)) { %>
                <% _.forEach(__tData.notificationList, function(notification) { %>
                <!-- show all notification list -->
                <a class="dropdown-item d-flex align-items-center" href="<%- notification['actionUrl'] %>">
                    <div>
                        <div class="small text-gray-500"><%- notification['created_at'] %></div>
                        <span class="font-weight-bold"><%- notification['message'] %></span>
                    </div>
                </a>
                <!-- show all notification list -->
                <% }); %>
                <!-- show all notification link -->
                <a class="dropdown-item text-center small text-gray-500" href="<?= route('user.notification.read.view') ?>" id="lwShowAllNotifyLink" data-show-if="showAllNotifyLink"><?= __tr('Show All Notifications.') ?></a>
                <!-- /show all notification link -->
                <% } else { %>
                <!-- info message -->
                <a class="dropdown-item text-center small text-gray-500"><?= __tr('There are no notification.') ?></a>
                <!-- /info message -->
                <% } %>
            </script>
            <!-- /Notification block -->
        </div>
    </li>
    <!-- /Notification Link -->
    <?php
    $translationLanguages = getStoreSettings('translation_languages');
    ?>
    <!-- Notification Link -->

    <!-- Language Menu -->
    @if(!__isEmpty($translationLanguages))
    <?php 
    $translationLanguages['en_US'] = [
        'id' => 'en_US',
        'name' => 'English',
        'is_rtl' => false,
        'status' => true
    ];
    ?>
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="d-none d-md-inline-block"><?= (isset($translationLanguages[CURRENT_LOCALE])) ? $translationLanguages[CURRENT_LOCALE]['name'] : '' ?></span>
            &nbsp; <i class="fas fa-language"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <h6 class="dropdown-header">
             <?= __tr('Choose your language') ?>
         </h6>
         <div class="dropdown-divider"></div>
         <?php foreach($translationLanguages as $languageId => $language) {
            if ($languageId == CURRENT_LOCALE or (isset($language['status']) and $language['status'] == false)) continue;
            ?>
            <a class="dropdown-item" href="<?= route('locale.change', ['localeID' => $languageId]) .'?redirectTo='.base64_encode(Request::fullUrl());  ?>">
                <?= $language['name'] ?>
            </a>
        <?php } ?>
    </div>
</li>
@endif
<!-- Language Menu -->

<!-- Nav Item - User Information -->

<li class="nav-item dropdown no-arrow">

    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">


     @if(isset($userProfileGet->profile_picture))
     <img class="img-profile rounded-circle" src="{{ asset('media-storage/users/') }}/{{ Auth::user()->_uid }}/profile/{{ $userProfileGet->profile_picture }}">                 @else               
     <img class="img-profile rounded-circle" src="{{ asset('imgs/no_thumb_image.jpg') }}">      
     @endif

 </a>
 <!-- Dropdown - User Information -->
 <div id="profile_drop_down"class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
    <div class="d-flex">
        <div class="img-profile-view">

         @if(isset($userProfileGet->profile_picture))
         <img class="img-profile rounded-circle" src="{{ asset('media-storage/users/') }}/{{ Auth::user()->_uid }}/profile/{{ $userProfileGet->profile_picture }}">            
              @else               
         <img class="img-profile rounded-circle" src="{{ asset('imgs/no_thumb_image.jpg') }}">      
         @endif

     </div>
     <div>
        <p class="user-title">{{ Auth::user()->username }}</p>
        <p class="profile-type">Stander</p>
        <button class="upgrade-profile">Upgrade your profile</button>
    </div>
</div>


<div class="d-flex about-profile-button">
   <button class="web-button" onclick="window.location.href='<?= route("user.profile_view", ["username" => getUserAuthInfo('profile.username')]) ?>';">Edite Profile</button>

   <button class="web-button" onclick="window.location.href='<?= route("user.profile_view", ["username" => getUserAuthInfo('profile.username')]) ?>';">View Profile</button>

</div>
<div class="bost-profile-button">
    <button class="web-button">Boost Your Profile</button>
    <button class="web-button">Get Verification</button>
</div>
<div class="option-list">
    <p><i class="fa-solid fa-gear"></i><a href="{{ url('settings') }}">Setting</a></p>
    <p><i class="fa-solid fa-arrow-right-from-bracket"></i>

        <a href="#" data-toggle="modal" data-target="#logoutModal">
            <?= __tr('Logout Profile') ?>
        </a>
    </div>
    
</div>
</li>

</ul>

</nav>