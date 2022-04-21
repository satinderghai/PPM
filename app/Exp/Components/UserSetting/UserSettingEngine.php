<?php
/*
* UserSettingEngine.php - Main component file
*
* This file is part of the UserSetting component.
*-----------------------------------------------------------------------------*/

namespace App\Exp\Components\UserSetting;

use App\Exp\Base\BaseEngine;
use Auth; 
use App\Exp\Components\Media\MediaEngine;
use App\Exp\Components\UserSetting\Repositories\UserSettingRepository;
use App\Exp\Support\Country\Repositories\CountryRepository;
use App\Exp\Components\UserSetting\Interfaces\UserSettingEngineInterface;
use App\Exp\Support\CommonTrait;
use App\Exp\Components\User\Models\User;
use App\Exp\Components\User\Models\UserTag;
use App\Exp\Components\User\Models\UserProfile;
use ImageIntervention;
use Carbon\Carbon;

class UserSettingEngine extends BaseEngine implements UserSettingEngineInterface 
{   
     /**
     * @var CommonTrait - Common Trait
     */
     use CommonTrait;

    /**
     * @var  UserSettingRepository $userSettingRepository - UserSetting Repository
     */
    protected $userSettingRepository;

    /**
     * @var  CountryRepository $countryRepository - Country Repository
     */
    protected $countryRepository;
    
    /**
     * @var  MediaEngine $mediaEngine - Media Engine
     */
    protected $mediaEngine;

    /**
      * Constructor
      *
      * @param  UserSettingRepository $userSettingRepository - UserSetting Repository
      * @param  CountryRepository $countryRepository - Country Repository
      * @param  MediaEngine $mediaEngine - Media Engine
      *
      * @return  void
      *-----------------------------------------------------------------------*/

    function __construct(
        UserSettingRepository $userSettingRepository,
        CountryRepository $countryRepository,
        MediaEngine $mediaEngine
    )
    {
        $this->userSettingRepository    = $userSettingRepository;
        $this->countryRepository        = $countryRepository;
        $this->mediaEngine              = $mediaEngine;
    }

    /**
     * Prepare User Settings.
     *
     * @param string $pageType
     * 
     * @return array
     *---------------------------------------------------------------- */
    public function prepareUserSettings($pageType)
    {
        // Get settings from config
      $defaultSettings = $this->getDefaultSettings($this->getUserSettingConfig()['items'][$pageType]);

        // check if default settings exists
      if (__isEmpty($defaultSettings)) {
        return $this->engineReaction(18, ['show_message'=> true], __tr('Invalid page type.'));
    }

    $userSettings = $dbUserSettings = [];
        // Check if default settings exists
    if (!__isEmpty($defaultSettings)) {
            // Get selected default settings
     $userSettingCollection = $this->userSettingRepository->fetchUserSettingByName(array_keys($defaultSettings));

            // check if configuration collection exists
     if (!__isEmpty($userSettingCollection)) {
        foreach($userSettingCollection as $configuration) {
           $dbUserSettings[$configuration->key_name] = $this->castValue($configuration->data_type, $configuration->value);
       }
   }

            // Loop over the default settings
   foreach($defaultSettings as $defaultSetting) {
    $userSettings[$defaultSetting['key']] = $this->prepareDataForConfiguration($dbUserSettings, $defaultSetting);
}
}

return $this->engineReaction(1, [
    'userSettingData' => $userSettings
]);
}

    /**
     * Process User Setting Store.
     *
     * @param string $pageType
     * @param array $inputData
     * 
     * @return array
     *---------------------------------------------------------------- */
    public function processUserSettingStore($pageType, $inputData) 
    {
      $dataForStoreOrUpdate = $userSettingKeysForDelete = [];
      $isDataAddedOrUpdated = false;

        // Get settings from config
      $defaultSettings = $this->getDefaultSettings($this->getUserSettingConfig()['items'][$pageType]);

        // check if default settings exists
      if (__isEmpty($defaultSettings)) {
        return $this->engineReaction(18, ['show_message'=> true], __tr('Invalid page type.'));
    }

        //check page type is notifications
    if ($pageType == 'notification') {
     if (!__isEmpty($inputData)) {
        foreach ($inputData as $key => $value) {
           $inputData[$key] = (isset($value) and $value == 'true') ? true : false;
       }
   }
}

         // Check if input data exists
if (!__isEmpty($inputData)) {
 foreach($inputData as $inputKey => $inputValue) {
                // Get selected default settings
    $userSettingCollection = $this->userSettingRepository->fetchUserSettingByName(array_keys($defaultSettings));
                //pluck user setting value and key name
    $userSettingKeyName = $userSettingCollection->pluck('value', 'key_name')->toArray();

                // Check if default text and form text not same                
    if (array_key_exists($inputKey, $defaultSettings) and $inputValue != $defaultSettings[$inputKey]['default']) {
       $castValues = $this->castValue(
          ($defaultSettings[$inputKey]['data_type'] == 4)
                        ? 5 : $defaultSettings[$inputKey]['data_type'], // for Encode purpose only
                        $inputValue);
                    //if data exists in configuration then use existing data
       if (array_key_exists($inputKey, $userSettingKeyName)) {
          foreach ($userSettingCollection as $key => $settings) {
             if ($inputKey == $settings['key_name']) {
                $dataForStoreOrUpdate[] = [
                   '_id'            => $settings['_id'],
                   'key_name'      => $inputKey,
                   'value'      => $castValues,
                   'data_type'  => $defaultSettings[$inputKey]['data_type'],
                   'users__id'  => getUserID()
               ];
           }
       }
   } else {
      $dataForStoreOrUpdate[] = [
         'key_name'      => $inputKey,
         'value'        => $castValues,
         'data_type'    => $defaultSettings[$inputKey]['data_type'],
         'users__id'    => getUserID()
     ];
 }
}

                // Check if default value and input value same and it is exists
if ((array_key_exists($inputKey, $defaultSettings)) 
   and ($inputValue == $defaultSettings[$inputKey]['default'])
   and (!isset($defaultSettings[$inputKey]['hide_value']))) {
   if (array_key_exists($inputKey, $userSettingKeyName)) {
      foreach ($userSettingCollection as $key => $settings) {
         if ($inputKey == $settings['key_name']) {
            $userSettingKeysForDelete[] = $settings['_id'];
        }
    }
}
}
}   

            // Send data for store or update
if (!__isEmpty($dataForStoreOrUpdate) 
    and $this->userSettingRepository->storeOrUpdate($dataForStoreOrUpdate)) {
    activityLog('User settings stored / updated.');
$isDataAddedOrUpdated = true;
}

            // Check if deleted keys deleted successfully
if (!__isEmpty($userSettingKeysForDelete) 
 and $this->userSettingRepository->deleteUserSetting($userSettingKeysForDelete)) {
    $isDataAddedOrUpdated = true;
}

            // Check if data added / updated or deleted
if ($isDataAddedOrUpdated) {
    return $this->engineReaction(1, ['show_message'=> true], __tr('User setting updated successfully.'));
}
return $this->engineReaction(14, ['show_message'=> true], __tr('Nothing updated.'));
}
return $this->engineReaction(2, ['show_message'=> true], __tr('Something went wrong on server.'));
}

    /*
      * Process Store User General Settings
      *
      * @param array $inputData
      *
      * @return boolean.
      *-------------------------------------------------------- */

    // exp-dev
    // for profile data save
    public function processStoreUserBasicSettings($inputData)
    {
        $transactionResponse = $this->userSettingRepository->processTransaction(function() use($inputData) {
            $isBasicSettingsUpdated = false;
            // Prepare User Details

            if(isset($inputData['action']) && $inputData['action'] == 'firstStepUserEditForm'){

              $user = User::findOrFail(Auth::user()->_id);
              $user->username = $inputData['username'];
              $user->save();

              $userProfile = UserProfile::where('users__id',Auth::user()->_id)->first();
              $userProfile->city = $inputData['city'];
              $userProfile->heading = $inputData['heading'];
              $userProfile->save();
        
              $userAge = isset($userProfile->dob) ? Carbon::parse($userProfile->dob)->age : null;

              $stepFirstHTML = '<div class="ProfileInfoCard-content" style="width: 100%;">
              <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">
              <h1 class="ProfileInfoCard-title" style="margin-right: 8px; margin-bottom: 8px;" data-cy="member-right-username"><span class="css-14op033" style="padding: 0px; display: inline;">'.$inputData['username'].'</span><span class="css-aa5qdl"></span></h1>
              <a class="lw-icon-btn" href role="button" id=""  data-toggle="modal" data-target="#userSmallProfileEditPopup">
              <i class="fa fa-pencil-alt"></i>
              </a></div><div>
              <p class="ProfileInfoCard-heading" style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;"><span>
              '.$userAge.' • </span><span>';

              if($user->gender_selection == 1){
                $stepFirstHTML .='Male';
            }
            if($user->gender_selection == 2){
             $stepFirstHTML .='Female';
         }
         $stepFirstHTML .='</span><span> • '.$userProfile->city.'</span></p>
         <p data-cy="heading-txt" class="ProfileInfoCard-bio">'.$userProfile->heading.'</p>
         </div>
         </div>';
      if($user->gender_selection == 1){
                $userGender ='Male';
            }
            if($user->gender_selection == 2){
             $userGender ='Female';
         }

         $mobileViewUserHTML = '<h4>'.$inputData['username'].'</h4>

                                       <p class="ProfileInfoCard-heading" style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;"><span>'.$userAge.' • </span><span>'.$userGender.'
                         </span><span> • '.$userProfile->city.'</span></p>

                               <p data-cy="heading-txt" class="ProfileInfoCard-bio">'.$userProfile->heading.'</p>';

     return $this->userSettingRepository->transactionResponse(1, ['first_section_data'=>$stepFirstHTML,'mobileViewUserHTML'=>$mobileViewUserHTML], __tr('Your basic information updated successfully.'));

 }elseif(isset($inputData['action']) && $inputData['action'] == 'aboutUsForm'){  

  if(isset($inputData['about_me'])){
    $userProfile = UserProfile::where('users__id',Auth::user()->_id)->first();
    $userProfile->about_me = $inputData['about_me'];
    $userProfile->save();
}

$stepThreeHTML = '<p>'.$inputData['about_me'].'</p>';
return $this->userSettingRepository->transactionResponse(1, ['about_me_data'=>$stepThreeHTML], __tr('Your basic information updated successfully.'));


}elseif(isset($inputData['action']) && $inputData['action'] == 'lookingForForm'){  


    if (isset($inputData['what_are_you_seeking'])) {
       $userProfile = UserProfile::where('users__id',Auth::user()->_id)->first();
       $userProfile->user_tag =  serialize($inputData['user_tag']);
       $userProfile->what_are_you_seeking = $inputData['what_are_you_seeking'];
       $userProfile->save();
   }

   $stepFourHTML = '<div class="card-body looking_for_section">
   <div class="tag-group">';

   if(isset($userProfile->user_tag)){
    foreach (unserialize($userProfile->user_tag) as $key => $selectedTag){
       $tagData =  UserTag::find($selectedTag);
       if($tagData){
        $stepFourHTML .= '<button class="tag">'.$tagData->name.'<i class="fa-solid fa-plus"></i></button>';
    }
}  
}

$stepFourHTML .= ' </div>

<div class="tag-group">';
$stepFourHTML .= $inputData['what_are_you_seeking'];
$stepFourHTML .= '</span> </div>';
return $this->userSettingRepository->transactionResponse(1, ['looking_for'=>$stepFourHTML], __tr('Your basic information updated successfully.'));


}elseif(isset($inputData['action']) && $inputData['action'] == 'secondStepUserEditForm'){

  $user = User::findOrFail(Auth::user()->_id);
  $user->interest_selection = implode(',', $inputData['interest_selection']);
  $user->save();

  $userProfile = UserProfile::where('users__id',Auth::user()->_id)->first();

  $userProfile->net_worth = $inputData['net_worth'];
  $userProfile->income = $inputData['income'];
  $userProfile->height = $inputData['height'];
  $userProfile->ethnicity = $inputData['ethnicity'];
  $userProfile->education = $inputData['education'];
  $userProfile->body_type = $inputData['body_type'];
  $userProfile->relationship_status = $inputData['relationship_status'];
  $userProfile->children = $inputData['children'];
  $userProfile->smoke = $inputData['smoke'];
  $userProfile->drink = $inputData['drink'];
  $userProfile->save();


  $UserProfile = UserProfile::query()
  ->select(
    'user_profiles.*',
    'net_worth.name as user_net_worth',
    'annual_income.name as user_annual_income',
    'body_type.name as user_body_type',
    'ethnicity.name as user_ethnicity',
    'education.name as user_education',
    'relationship_status.name as user_relationship_status',
    'users.interest_selection'
)
  ->join('users', 'users._id', '=', 'user_profiles.users__id')
  ->join('net_worth', 'net_worth._id', '=', 'user_profiles.net_worth')
  ->join('annual_income', 'annual_income._id', '=', 'user_profiles.income')
  ->join('body_type', 'body_type._id', '=', 'user_profiles.body_type')
  ->join('ethnicity', 'ethnicity._id', '=', 'user_profiles.ethnicity')
  ->join('education', 'education._id', '=', 'user_profiles.education')
  ->join('relationship_status', 'relationship_status._id', '=', 'user_profiles.relationship_status')
  ->where('user_profiles.users__id', '=', getUserID())
  ->first();

  $stepTwoHTML = '<div class="form-group row"><div class="col-4 col-sm-4 mb-3 mb-sm-0"><label for="looking_for"><strong>Looking For</strong></label><div class="lw-inline-edit-text" data-model="userData.interest_selection">';
  if($UserProfile->interest_selection == 1){
     $stepTwoHTML .='Men'; 
 }elseif($UserProfile->interest_selection == 2){
    $stepTwoHTML .='Women';
}
else{ $stepTwoHTML .='-'; }

$stepTwoHTML .='</div> </div><div class="col-4 col-sm-4">

<label for="net_Worth"><strong>Net Worth</strong></label>
<div class="lw-inline-edit-text" data-model="userData.last_name">';
$stepTwoHTML .=$UserProfile->user_net_worth;

$stepTwoHTML .=' </div>

</div> <div class="col-4 col-sm-4 mb-3 mb-sm-0">

<label for="annual_income"><strong>Annual Income</strong></label>
<div class="lw-inline-edit-text" data-model="profileData.gender_text">';
$stepTwoHTML .= $UserProfile->user_annual_income;
$stepTwoHTML .=' </div>

</div></div><div class="form-group row"> <div class="col-4 col-sm-4">

<label><strong>Ethnicity</strong></label>
<div class="lw-inline-edit-text" data-model="profileData.formatted_preferred_language">';
$stepTwoHTML .= $UserProfile->user_ethnicity;
$stepTwoHTML .= '</div>

</div>  <div class="col-4 col-sm-4 mb-3 mb-sm-0">
<label><strong>Children</strong></label>
<div class="lw-inline-edit-text" data-model="profileData.formatted_relationship_status">';
$stepTwoHTML .= $UserProfile->children;
$stepTwoHTML .=' </div>

</div> <div class="col-4 col-sm-4">
<label for="education"><strong>Education</strong></label>
<div class="lw-inline-edit-text" data-model="profileData.formatted_work_status">';
$stepTwoHTML .=$UserProfile->user_education;
$stepTwoHTML .='</div>

</div> </div>

<div class="form-group row">


<div class="col-4 col-sm-4 mb-3 mb-sm-0">

<label for="smokes"><strong>Smokes</strong></label>
<div class="lw-inline-edit-text" data-model="profileData.formatted_education">';


if($UserProfile->smoke == 1){
   $stepTwoHTML .='Non Smoker';
}elseif($UserProfile->smoke == 2)
{  $stepTwoHTML .='Light Smoker';}
elseif($UserProfile->smoke == 3)
    { $stepTwoHTML .='Heavy Smoker';}
else
   {$stepTwoHTML .=' -';}

$stepTwoHTML .='  </div>

</div>   <div class="col-4 col-sm-4">

<label for="body_type"><strong>Body Type</strong></label>
<div class="lw-inline-edit-text" data-model="profileData.birthday">';
$stepTwoHTML .=$UserProfile->user_body_type;
$stepTwoHTML .='</div>
</div><div class="col-4 col-sm-4 mb-3 mb-sm-0">

<label for="occupation_industry"><strong>Occupation Industry</strong></label>
<div class="lw-inline-edit-text" data-model="profileData.mobile_number">';
$stepTwoHTML .=$UserProfile->occupation_industry;
$stepTwoHTML .=' </div>
</div><div class="col-4 col-sm-4 mb-3 mb-sm-0">

<label for="drinks"><strong>Drinks</strong></label>
<div class="lw-inline-edit-text" data-model="profileData.mobile_number">';


if($UserProfile->drink == 1){
   $stepTwoHTML .='Non Drinker';
}elseif($UserProfile->drink == 2)
{  $stepTwoHTML .='Light Drinker';}
elseif($UserProfile->drink == 3)
    { $stepTwoHTML .='Heavy Drinker';}
else
   {$stepTwoHTML .='-';
}

$stepTwoHTML .='</div>

</div><div class="col-4 col-sm-4">

<label for="height"><strong>Height</strong></label>
<div class="lw-inline-edit-text" data-model="profileData.mobile_number">';
$stepTwoHTML .=$UserProfile->height;
$stepTwoHTML .='</div></div>

<div class="col-4 col-sm-4 mb-3 mb-sm-0">

<label for="relationship"><strong>Relationship</strong></label>
<div class="lw-inline-edit-text" data-model="profileData.mobile_number">';
$stepTwoHTML .=$UserProfile->relationship_status;
$stepTwoHTML .=' </div>

</div>

</div>';

return $this->userSettingRepository->transactionResponse(1, ['userData'=>$stepTwoHTML], __tr('Your basic information updated successfully.'));


}else{




}

return $this->userSettingRepository->transactionResponse(1, [], __tr('Your basic information updated successfully.'));


//                     echo "<pre>";
//            print_r($inputData);
//            die;

// die();

            // Check if user details exists
if (\__isEmpty($userDetails)) {
    return $this->engineReaction(18, null, __tr('User does not exists.'));
}
            // check if user details updated
if ($this->userSettingRepository->updateUser($user, $userDetails)) {
    activityLog($user->first_name.' '.$user->last_name. ' update own user info.');
    $isBasicSettingsUpdated = true;
}

            // Prepare User profile details
$userProfileDetails = [
    'net_worth'                => $inputData['gender_preference'],
    'income'                   => array_get($inputData, 'income'),
    'height'           => array_get($inputData, 'height'),
    'ethnicity'             => array_get($inputData, 'ethnicity'),
    'education'              => array_get($inputData, 'education'),
    'occupation'    => array_get($inputData, 'occupation'),
    'relationship_status'   => array_get($inputData, 'relationship_status')
];

            // get user profile
$userProfile = $this->userSettingRepository->fetchUserProfile($userId);
            // check if user profile exists
if (\__isEmpty($userProfile)) {
    $userProfileDetails['user_id'] = $userId;
    if ($this->userSettingRepository->storeUserProfile($userProfileDetails)) {
        activityLog($user->first_name.' '.$user->last_name. ' store own user profile.');
        $isBasicSettingsUpdated = true;
    }
} else {
    if ($this->userSettingRepository->updateUserProfile($userProfile, $userProfileDetails)) {
        activityLog($user->first_name.' '.$user->last_name. ' update own user profile.');
        $isBasicSettingsUpdated = true;
    }
}

if ($isBasicSettingsUpdated) {
    return $this->userSettingRepository->transactionResponse(1, [], __tr('Your basic information updated successfully.'));
}
            // // Send failed server error message
return $this->userSettingRepository->transactionResponse(2, [], __tr('Something went wrong on server.'));
});

return $this->engineReaction($transactionResponse);
}

    /*
      * process Store Profile Wizard
      *
      * @param array $inputData
      *
      * @return boolean.
      *-------------------------------------------------------- */
    public function processStoreProfileWizard($inputData)
    {
        $transactionResponse = $this->userSettingRepository->processTransaction(function() use($inputData) {
            $isBasicSettingsUpdated = false;

            $userId = getUserID();
            $user = $this->userSettingRepository->fetchUserDetails($userId);
            // Check if user details exists
            if (\__isEmpty($user)) {
                return $this->engineReaction(18, null, __tr('User does not exists.'));
            }

            // Prepare User profile details
            $userProfileDetails = [
                'gender'                => array_get($inputData, 'gender'),
                'dob'                   => array_get($inputData, 'birthday'),
            ];
            
            // get user profile
            $userProfile = $this->userSettingRepository->fetchUserProfile($userId);
            // check if user profile exists
            if (\__isEmpty($userProfile)) {
                $userProfileDetails['user_id'] = $userId;
                if ($this->userSettingRepository->storeUserProfile($userProfileDetails)) {
                    activityLog($user->first_name.' '.$user->last_name. ' store own user profile.');
                    $isBasicSettingsUpdated = true;
                }
            } else {
                if ($this->userSettingRepository->updateUserProfile($userProfile, $userProfileDetails)) {
                    activityLog($user->first_name.' '.$user->last_name. ' update own user profile.');
                    $isBasicSettingsUpdated = true;
                }
            }

            if ($isBasicSettingsUpdated) {
                return $this->userSettingRepository->transactionResponse(1, [], __tr('Your basic information updated successfully.'));
            }
            // // Send failed server error message
            return $this->userSettingRepository->transactionResponse(2, [], __tr('Something went wrong on server.'));
        });
        
        return $this->engineReaction($transactionResponse);
    }

    /**
     * Process Store Location Data
     *
     * @param array $inputData
     * 
     * @return json object
     *---------------------------------------------------------------- */
    public function processStoreLocationData($inputData)
    {
        // Get country from input data
        $placeData = $inputData['placeData'];
        // check if place data exists
        if (__isEmpty($placeData)) {
            return $this->engineReaction(2, null, __tr('Invalid data proceed.'));
        }

        $countryCode = $cityName = $countryName = '';
        // Loop over the place data
        foreach($placeData as $place) {
            if (in_array('country', $place['types']) or in_array('continent', $place['types'])) {
                $countryCode = $place['short_name'];
                $countryName = $place['long_name'];
            }
            if (in_array('locality', $place['types'])) {
                $cityName = $place['long_name'];
            }
        }
        // Fetch Country code
        $countryDetails = $this->countryRepository->fetchByCountryCode($countryCode);
        // Check if country exists
        if (!__isEmpty($countryDetails)) {
            $countryId = $countryDetails->_id;
            $countryName = $countryDetails->name;
        } else {
            $countryStoreData = [
                'iso_code'          => $countryCode,
                'name_capitalized'  => strtoupper($countryName),
                'name'              => $countryName,
                'iso3_code'         => $countryCode
            ];
            // check if country is stored
            if (!$newCountry = $this->countryRepository->storeCountry($countryStoreData)) {
                return $this->engineReaction(2, null, __tr('Something went wrong on server while processing.'));
            }
            $countryId = $newCountry->_id;
        }
        $isUserLocationUpdated = false;
        $userId = getUserID();
        $user = $this->userSettingRepository->fetchUserDetails($userId);
        // Check if user details exists
        if (\__isEmpty($user)) {
            return $this->engineReaction(18, null, __tr('User does not exists.'));
        }
        $userProfileDetails = [
            'countries__id' => $countryId,
            'city' => $cityName,
            'location_latitude' => $inputData['latitude'],
            'location_longitude' => $inputData['longitude']
        ];        
        // get user profile
        $userProfile = $this->userSettingRepository->fetchUserProfile($userId);
        
        // check if user profile exists
        if (\__isEmpty($userProfile)) {
            $userProfileDetails['user_id'] = $userId;
            if ($this->userSettingRepository->storeUserProfile($userProfileDetails)) {
                activityLog($user->first_name.' '.$user->last_name. ' store own location.');
                $isUserLocationUpdated = true;
            }
        } else {
            if ($this->userSettingRepository->updateUserProfile($userProfile, $userProfileDetails)) {
                activityLog($user->first_name.' '.$user->last_name. ' update own location.');
                $isUserLocationUpdated = true;
            }
        }

        // check if user profile stored or update
        if ($isUserLocationUpdated) {
            return $this->engineReaction(1, [
                'country_name' => $countryName,
                'city' => $cityName 
            ], __tr('Location stored successfully.'));
        }

        return $this->engineReaction(2, null, __tr('Something went wrong on server.'));
    }

    /**
     * Process upload profile image.
     *
     * @param array $inputData
     * @param string $requestType
     * 
     * @return json object
     *---------------------------------------------------------------- */
    public function processUploadProfileImage($inputData, $requestType)
    {
        $uploadedFile = $this->mediaEngine->processUploadProfile($inputData, $requestType);
        $isProfilePictureUpdated = false;
        // check if file uploaded successfully
        if ($uploadedFile['reaction_code'] == 1) {
            $uploadedFileData = $uploadedFile['data'];
            $fileName = $uploadedFileData['fileName'];
            $userId = getUserID();
            $userInfo = getUserAuthInfo();
            $fullName = array_get($userInfo, 'profile.full_name');
            // get user profile data
            $userProfile = $this->userSettingRepository->fetchUserProfile($userId);
            $userProfileData = [
                'profile_picture' => $fileName
            ];
            
            // check if user profile exists
            if (__isEmpty($userProfile)) {
                $userProfileData['user_id'] = $userId;
                // Check if user profile stored
                if ($this->userSettingRepository->storeUserProfile($userProfileData)) {
                    activityLog($fullName. ' store profile picture.');
                    $isProfilePictureUpdated = true;
                }
            } else {
                // check if existing profile picture exists
                if (!__isEmpty($userProfile->profile_picture)) {
                    $profileFolderPath = getPathByKey('profile_photo', ['{_uid}' => authUID()]);
                    $this->mediaEngine->delete($profileFolderPath, $userProfile->profile_picture);
                }
                // Check if user profile updated
                if ($this->userSettingRepository->updateUserProfile($userProfile, $userProfileData)) {
                    activityLog($fullName. ' update profile picture.');
                    $isProfilePictureUpdated = true;
                }                
            }
        }
        // check if profile picture updated successfully.
        if ($isProfilePictureUpdated) {
            return $this->engineReaction(1, [
                'image_url' => $uploadedFileData['path']
            ], __tr('Profile picture updated successfully.'));
        }

        return $uploadedFile;
    }

    /**
     * Process upload cover image.
     *
     * @param array $inputData
     * @param string $requestType
     * 
     * @return json object
     *---------------------------------------------------------------- */
    public function processUploadCoverImage($inputData, $requestType)
    {
        $uploadedFile = $this->mediaEngine->processUploadCoverPhoto($inputData, $requestType);
        $isCoverPictureUpdated = false;
        // check if file uploaded successfully
        if ($uploadedFile['reaction_code'] == 1) {
            $uploadedFileData = $uploadedFile['data'];
            $fileName = $uploadedFileData['fileName'];
            $userId = getUserID();
            $userInfo = getUserAuthInfo();
            $fullName = array_get($userInfo, 'profile.full_name');
            // get user profile data
            $userProfile = $this->userSettingRepository->fetchUserProfile($userId);
            $userProfileData = [
                'cover_picture' => $fileName
            ];
            // check if user profile exists
            if (__isEmpty($userProfile)) {
                $userProfileData['user_id'] = $userId;
                // Check if user profile stored
                if ($this->userSettingRepository->storeUserProfile($userProfileData)) {
                    activityLog($fullName. ' store cover picture.');
                    $isCoverPictureUpdated = true;
                }
            } else {
                // check if existing profile picture exists
                if (!__isEmpty($userProfile->profile_picture)) {
                    $profileFolderPath = getPathByKey('cover_photo', ['{_uid}' => authUID()]);
                    $this->mediaEngine->delete($profileFolderPath, $userProfile->profile_picture);
                }
                // Check if user profile updated
                if ($this->userSettingRepository->updateUserProfile($userProfile, $userProfileData)) {
                    activityLog($fullName. ' update cover picture.');
                    $isCoverPictureUpdated = true;
                }                
            }
        }
        // check if cover picture updated successfully.
        if ($isCoverPictureUpdated) {
            return $this->engineReaction(1, [
                'image_url' => $uploadedFileData['path']
            ], __tr('Profile cover picture updated successfully.'));
        }

        return $uploadedFile;
    }

     /*
      * Process Store User Profile Data
      *
      * @param array $inputData
      *
      * @return boolean.
      *-------------------------------------------------------- */
     public function processStoreUserProfileSetting($inputData)
     {
        $userId = getUserID();
        $userSpecifications = $storeOrUpdateData = [];
        // Get collection of user specifications
        $userSpecificationCollection = $this->userSettingRepository->fetchUserSpecificationById($userId);
        // check if user specification exists
        if (!__isEmpty($userSpecificationCollection)) {
            $userSpecifications = $userSpecificationCollection->pluck('_id', 'specification_key')->toArray();
        }
        
        $index = 0;
        foreach ($inputData as $inputKey => $inputValue) {
            if (!__isEmpty($inputValue)) {
                $storeOrUpdateData[$index] = [
                    'type'                  => 1,
                    'status'                => 1,
                    'specification_key'     => $inputKey,
                    'specification_value'   => $inputValue,
                    'users__id'             => $userId
                ];
                if (array_key_exists($inputKey, $userSpecifications)) {
                    $storeOrUpdateData[$index]['_id'] = $userSpecifications[$inputKey];
                }
                $index++;
            }
        }

        // Check if user profile updated or store
        if ($this->userSettingRepository->storeOrUpdateUserSpecification($storeOrUpdateData)) {
            $userInfo = getUserAuthInfo();
            $fullName = array_get($userInfo, 'profile.full_name');
            activityLog($fullName. ' update own user settings.');
            return $this->engineReaction(1, null, __tr('Profile updated successfully.'));
        }

        return $this->engineReaction(2, null, __tr('Something went wrong on server.'));
    }

    /**
     * Prepare user photo settings.
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function prepareUserPhotosSettings()
    {
        $userPhotoCollection = $this->userSettingRepository->fetchUserPhotos(getUserID());
        $userPhotos = [];
        $userPhotosFolderPath = getPathByKey('user_photos', ['{_uid}' => authUID()]);
        // check if user photos exists
        if (!__isEmpty($userPhotoCollection)) {
            foreach ($userPhotoCollection as $photo) {
                $userPhotos[] = [
                    '_id' => $photo->_id,
                    'image_url' => getMediaUrl($userPhotosFolderPath, $photo->file)
                ];
            }
        }
        return $this->engineReaction(1, [
            'userPhotos' => $userPhotos,
            'photosCount' => $userPhotoCollection->count()
        ]);
    }

    /**
     * Process Upload Multiple Photots.
     *
     * @param array $inputData
     * 
     * @return json object
     *---------------------------------------------------------------- */
    public function processUploadPhotos($inputData)
    {

     $uploadDone = false;
     $userPhotoCollection = $this->userSettingRepository->fetchUserPhotos(getUserID());    


        // Check if user photos count is greater than or equal to 10
     if ($userPhotoCollection->count() >= 20) {
        return $this->engineReaction(2, null, __tr("You cannot upload more than 10 photos."));
    }


    if (!file_exists(public_path('/media-storage/users/'.getUserUID().'/profile'))) {
        mkdir(public_path('/media-storage/users/'.getUserUID().'/profile'), 0777, true);
    }

    if (!file_exists(public_path('/media-storage/users/'.getUserUID().'/public'))) {
        mkdir(public_path('/media-storage/users/'.getUserUID().'/public'), 0777, true);
    }
    if (!file_exists(public_path('/media-storage/users/'.getUserUID().'/private'))) {
        mkdir(public_path('/media-storage/users/'.getUserUID().'/private'), 0777, true);
    }

    if($inputData['phottoFrom'] == 1){

        if (isset($inputData['public_profile_picture'])) {
           $imagePublic = $inputData['public_profile_picture'];
           $userPublicImage = time().'.'.$imagePublic->getClientOriginalExtension();
           $destinationPath = public_path('/media-storage/users/'.getUserUID().'/public/');
           $imagePublic->move($destinationPath, $userPublicImage);   
           $uploadDone = true;

           $uploadedFileName = $userPublicImage;

        // 
       } 
   } 
   if($inputData['phottoFrom'] == 2){
       if (isset($inputData['private_profile_picture'])) {
           $imagePrivate = $inputData['private_profile_picture'];
           $userPrivateImage = time().'.'.$imagePrivate->getClientOriginalExtension();
           $destinationPath = public_path('/media-storage/users/'.getUserUID().'/private/');
           $imagePrivate->move($destinationPath, $userPrivateImage);   
           $uploadDone = true;
           $uploadedFileName = $userPrivateImage;


       }
   } 

        // check if file uploaded successfully
   if ($uploadDone) {
    $userPhotoData = [
        'users__id' => getUserID(),
        'file' => $uploadedFileName,
        'type' => $inputData['phottoFrom']
    ];

    if ($newUserPhoto = $this->userSettingRepository->storeUserPhoto($userPhotoData)) {
        $userInfo = getUserAuthInfo();

        $fullName = array_get($userInfo, 'profile.full_name');
        activityLog($fullName. ' upload new photos.');



        $imagesHTML = '';
        $userPhotoCollection = $this->userSettingRepository->fetchUserPhotos(getUserID());  

        foreach ($userPhotoCollection as $key => $value) {

            if($value->type == 1){
             $imageType = 'public';
         }else{
             $imageType = 'private';
         }
         $imgURL = url('/').'/media-storage/users/'.getUserUID().'/'.$imageType.'/'.$value->file; 
         $imagesHTML .= '<div class="col-4 col-sm-4 col-lg-3 col-md-3 p-1 "><div class="image-box"><i class="fa-solid fa-lock lock"></i> <img class="upload-images" src="'.$imgURL.'"></div></div>';
     }
     $imagesHTML .= ' <div class="col-4 col-sm-4 col-lg-3 col-md-3 p-1 "><div class="image-box add-new-image"><a data-toggle="modal" data-target="#userPhottoPopup"><i class="fa-solid fa-upload"></i><p>Add New Image</p></a></div></div>';


     return $this->engineReaction(1, [
        'stored_photo' => [
            '_id' => $newUserPhoto->_id,
            'image_url' => $imagesHTML
        ]
    ], __tr('Photos uploaded successfully.'));
 }            
}

return $uploadedFile;
}
}