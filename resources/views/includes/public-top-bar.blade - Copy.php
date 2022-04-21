
<nav class="row navbar navbar-expand navbar-light topbar mb-4 static-top shadow menu-bar">

 <!-- Sidebar Toggle (Topbar) -->

 <button type="button" id="sidebarToggleTop" class="btn btn-link d-block d-md-none rounded-circle mr-3">

  <img class="lw-logo-img" src="<?= getStoreSettings('logo_image_url') ?>" alt="PPM">

</button>

<!-- Nav Item - Search Dropdown (Visible Only XS) -->

<div class="nav-item dropdown no-arrow d-flex">

  <a class="sidebar-brand d-flex align-items-center" href="home">

    <div class="sidebar-brand-icon">

        <img class="lw-logo-img" src="<?= getStoreSettings('logo_image_url') ?>" alt="PPM">

    </div>

    <img class="lw-logo-img d-sm-none d-none d-md-block" src="<?= getStoreSettings('logo_image_url') ?>" alt="PPM">

    <img class="lw-logo-img d-sm-block d-md-none" src="backend/media-storage/small_logo/images.png?ver=1644474798" alt="PPM">

</a>

<div class="d-flex align-items-center">

    <ul class="d-flex header-menu">

     <li><i class="fa-solid fa-magnifying-glass"></i>Search</li>

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
        <img class="img-profile rounded-circle" src="<?= getUserAuthInfo('profile.profile_picture_url') ?>">
    </a>
    <!-- Dropdown - User Information -->
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <h6 class="dropdown-header">
            <?= getUserAuthInfo('profile.full_name') ?>
        </h6>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?= route('user.profile_view', ['username' => getUserAuthInfo('profile.username')]) ?>">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            <?= __tr('Profile') ?>
        </a>
        <a class="dropdown-item" href="<?= route('user.read.setting', ['pageType' => 'notification']) ?>">
            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
            <?= __tr('Settings') ?>
        </a>
        <a class="dropdown-item" href="<?= route('user.change_password') ?>">
            <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
            <?= __tr('Change Password') ?>
        </a>
        <a class="dropdown-item" href="<?= route('user.change_email') ?>">
            <i class="fas fa-envelope fa-sm fa-fw mr-2 text-gray-400"></i>
            <?= __tr('Change Email') ?>
        </a>
        @if(!isAdmin())
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#lwDeleteAccountModel">
            <i class="fas fa-trash-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            <?= __tr('Delete Account') ?>
        </a>
        @endif
        @if(isAdmin())
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-primary" target="_blank" href="<?= route('manage.dashboard') ?>">
            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
            <?= __tr('Admin Panel') ?>
        </a>
        @endif
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            <?= __tr('Logout') ?>
        </a>
    </div>
</li>

</ul>

</nav>