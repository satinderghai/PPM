<?php
/*
* FilterEngine.php - Main component file
*
* This file is part of the Filter component.
*-----------------------------------------------------------------------------*/

namespace App\Exp\Components\Filter;

use Carbon\Carbon;
use App\Exp\Base\BaseEngine;
use App\Exp\Components\UserSetting\Repositories\UserSettingRepository;
use App\Exp\Components\User\Repositories\UserRepository;
use App\Exp\Support\CommonTrait;
use App\Exp\Components\UserSetting\UserSettingEngine;
use App\Exp\Components\Filter\Interfaces\FilterEngineInterface;
use Request;
use Auth;
use App\Exp\Components\User\Models\UserTag;
use App\Exp\Components\User\Models\AnnualIncome;
use App\Exp\Components\User\Models\Ethnicity;
use App\Exp\Components\User\Models\Education;
use App\Exp\Components\User\Models\Occupation;
use App\Exp\Components\User\Models\RelationshipStatus;
use App\Exp\Components\User\Models\BodyType;
use App\Exp\Components\User\Models\NetWorth;
use App\Exp\Components\User\Models\HairColor;

class FilterEngine extends BaseEngine implements FilterEngineInterface 
{
    /**
     * @var  UserSettingRepository $userSettingRepository - UserSetting Repository
     */
    protected $userSettingRepository;

     /**
     * @var CommonTrait - Common Trait
     */
    use CommonTrait;

    /**
     * @var UserRepository - User Repository
     */
    protected $userRepository;
    
    /**
     * @var  UserSettingEngine $userSettingEngine - UserSetting Engine
     */
    protected $userSettingEngine;

    /**
      * Constructor
      * @param  UserSettingRepository $userSettingRepository - UserSetting Repository
      * @return  void
      *-----------------------------------------------------------------------*/
    function __construct(
        UserSettingRepository $userSettingRepository,
        UserRepository $userRepository,
        UserSettingEngine $userSettingEngine
    )
    {
        $this->userSettingRepository = $userSettingRepository;
        $this->userRepository        = $userRepository;
        $this->userSettingEngine     = $userSettingEngine;
	}

    /**
     * Process Filter User Data.
     *
     * @param array $inputData
     * 
     * @return array
     *---------------------------------------------------------------- */
    public function processFilterData($inputData, $paginateCount = false)
    {
        // fetch current user profile data
        $userProfile = $this->userSettingRepository->fetchUserProfile(getUserID());

        // Store basic filter data
        if (!$this->userSettingEngine->processUserSettingStore('basic_search', $inputData)) {
            return $this->engineReaction(2, null, __tr('Something went wrong on server, please try again later.'));
        }
		
        // $inputData = array_merge([
        //     'looking_for' => getUserSettings('looking_for'),
        //     'min_age' => getUserSettings('min_age'),
        //     'max_age' => getUserSettings('max_age'),
        //     'distance' => 50000,
        // ], $inputData);
       
//               echo "<pre>";
// print_r($inputData);
// die();
if( strpos(Auth::user()->interest_selection, ',') !== false ) {
    $inputData['looking_for'] = [1, 2];
}else{
   $inputData['looking_for'] = Auth::user()->interest_selection; 
}

        $latitude =  '';
        $longitude = '';
        // check if user profile exists
        if (!\__isEmpty($userProfile)) {
            $latitude = $userProfile->location_latitude;
            $longitude = $userProfile->location_longitude;
        }

        $inputData['latitude'] = $latitude;
        $inputData['longitude'] = $longitude;

        //fetch all user like dislike data
        $getLikeDislikeData = $this->userRepository->fetchAllUserLikeDislike();



        //pluck to_users_id in array
        $toUserIds = $getLikeDislikeData->pluck('to_users__id')->toArray();


        // //all blocked user list
        $blockUserCollection = $this->userRepository->fetchAllBlockUser();
        //blocked user ids
        $blockUserIds = $blockUserCollection->pluck('to_users__id')->toArray();
        //blocked me user list
        $allBlockMeUser = $this->userRepository->fetchAllBlockMeUser();
        //blocked me user ids
        $blockMeUserIds = $allBlockMeUser->pluck('by_users__id')->toArray();
        //fetch user liked data by to user id
		$likedCollection = $this->userRepository->fetchUserLikeData(1, false);
		//pluck people like ids
		$peopleLikeIds = $likedCollection->pluck('to_users__id')->toArray();
		//get people likes me data
		$userLikedMeData = $this->userRepository->fetchUserLikeMeData(false)->whereIn('by_users__id', $peopleLikeIds);
		//pluck people like me ids
		$mutualLikeIds = $userLikedMeData->pluck('userId')->toArray();
		
        //array merge of unique users ids
        $ignoreUserIds = array_values(array_unique(array_merge($toUserIds, $blockUserIds, $blockMeUserIds, $mutualLikeIds, [getUserID()])));
        
         

    $userTag = UserTag::all()->toArray();
        $netWorth = NetWorth::all()->toArray();
        $hairColor = HairColor::all()->toArray();
        $annualIncome = AnnualIncome::all()->toArray();
        $bodyType = BodyType::all()->toArray();
        $ethnicity = Ethnicity::all()->toArray();
        $education = Education::all()->toArray();
        $occupation = Occupation::all()->toArray();
        $relationshipStatus = RelationshipStatus::all()->toArray();


        // Get filter collection data
        $filterDataCollection = $this->userSettingRepository->fetchFilterData($inputData, $ignoreUserIds, $paginateCount);
      
//               echo "<pre>";
// print_r($filterDataCollection);
// die();

// 'gender'        => $gender,


        $filterData = [];
        // check if filter data exists
        if (!\__isEmpty($filterDataCollection)) {
            foreach ($filterDataCollection as $filter) {


                $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $filter->user_uid]);
                $profilePictureUrl = noThumbImageURL();
                // Check if user profile exists
                if (!__isEmpty($filter)) {
                    if (!__isEmpty($filter->profile_picture)) {


                        $profilePictureDrive = getMediaUrl($profilePictureFolderPath, $filter->profile_picture);
                            $profilePictureUrl = $profilePictureDrive.'/'.$filter->profile_picture;


                    }
                }

                $userAge = isset($filter->dob) ? Carbon::parse($filter->dob)->age : null;
				$gender = isset($filter->gender) ? configItem('user_settings.gender', $filter->gender) : null;

                  $userPhotoCollection = $this->userSettingRepository->fetchUserPhotos($filter->user_uid);


                // Prepare data for filter
                $filterData[] = [
                    'id'            => $filter->user_id,
                    'username'      => $filter->username,
                    'fullName'      => $filter->first_name.' '.$filter->last_name,
                    'profileImage'  => $profilePictureUrl,
                    'totalPhotto'  => $userPhotoCollection->count(),
					'gender' 		=> $gender,
					'dob' 			=> $filter->dob,
                    'city'           => $filter->city,
                    'heading'           => $filter->heading,
                    'user_uid'           => $filter->user_uid,
                    'user_id'           => $filter->user_id,
                    'body_type_name'           => $filter->body_type_name,
                    'ethnicity_name'           => $filter->ethnicity_name,
                    'height'           => $filter->height,
					'userAge'		=> $userAge,
                    'countryName' 	=> $filter->countryName,
                    'userOnlineStatus' => $this->getUserOnlineStatus($filter->user_authority_updated_at),
					'isPremiumUser'		=> isPremiumUser($filter->user_id),
					'detailString'	=> implode(", ", array_filter([$userAge, $gender]))
                ];
            }
		}
		
        $currentPage = $filterDataCollection->currentPage() + 1;
        // $fullUrl = Request::fullUrl();
        $fullUrl = route('user.read.search');
        // check if url contains looking for
        if (!str_contains($fullUrl, 'looking_for')) {
            $fullUrl .= '?looking_for='.getUserSettings('looking_for');
        } 
        if (!str_contains($fullUrl, 'min_age')) {
            $fullUrl .= '&min_age='.getUserSettings('min_age');
        } 
        if (!str_contains($fullUrl, 'max_age')) {
            $fullUrl .= '&max_age='.getUserSettings('max_age');
        } 
        if (!str_contains($fullUrl, 'distance')) {
            $fullUrl .= '&distance='.getUserSettings('distance');
        }

        // Check if user search data exists
        if (session()->has('userSearchData')) {
            session()->forget('userSearchData');
        }
		

        return $this->engineReaction(1, [
            'filterData'            => $filterData,
            'LikeUserId'            => $toUserIds,
            'userDetails'            => $userProfile,
            'userTag'            => $userTag,
            'annualIncome'            => $annualIncome,
            'netWorth'            => $netWorth,
            'bodyType'            => $bodyType,
            'hairColor'            => $hairColor,
            'ethnicity'            => $ethnicity,
            'education'            => $education,
            'occupation'            => $occupation,
            'relationshipStatus'  => $relationshipStatus,
            'filterCount'           => count($filterData),
            'userSettings'          => configItem('user_settings'),
            'userSpecifications'    => $this->getUserSpecificationConfig(),
            'nextPageUrl'           => $fullUrl.'&page='.$currentPage,
            'hasMorePages'          => $filterDataCollection->hasMorePages(),
            'totalCount'            => $filterDataCollection->total()
        ]);
    }

    /**
     * Process Filter User Data.
     *
     * @param array $inputData
     * 
     * @return array
     *---------------------------------------------------------------- */
    public function prepareRandomUserData($inputData)
    {
        // fetch current user profile data
        $userProfile = $this->userSettingRepository->fetchUserProfile(getUserID());
      
        // Store basic filter data
        if (!$this->userSettingEngine->processUserSettingStore('basic_search', $inputData)) {
            return $this->engineReaction(2, null, __tr('Something went wrong on server, please try again later.'));
        }

        $inputData = array_merge([
            'looking_for' => getUserSettings('looking_for'),
            'min_age' => getUserSettings('min_age'),
            'max_age' => getUserSettings('max_age'),
            'distance' => getUserSettings('distance'),
        ], $inputData);
        
        // check if looking for is given in string
        if ((!\__isEmpty($inputData['looking_for']))) {
            if ((\is_string($inputData['looking_for']))
            and ($inputData['looking_for'] == 'all')) {
                $inputData['looking_for'] = [1, 2, 3];
            } else {
                $inputData['looking_for'] = [$inputData['looking_for']];
            }                
        } else {
            $inputData['looking_for'] = [];
        }
        $latitude =  '';
        $longitude = '';
        // check if user profile exists
        if (!\__isEmpty($userProfile)) {
            $latitude = $userProfile->location_latitude;
            $longitude = $userProfile->location_longitude;
        }

        $inputData['latitude'] = $latitude;
        $inputData['longitude'] = $longitude;

        //fetch all user like dislike data
        $getLikeDislikeData = $this->userRepository->fetchAllUserLikeDislike();
        //pluck to_users_id in array
        $toUserIds = $getLikeDislikeData->pluck('to_users__id')->toArray();
        // //all blocked user list
        $blockUserCollection = $this->userRepository->fetchAllBlockUser();
        //blocked user ids
        $blockUserIds = $blockUserCollection->pluck('to_users__id')->toArray();
        //blocked me user list
        $allBlockMeUser = $this->userRepository->fetchAllBlockMeUser();
        //blocked me user ids
        $blockMeUserIds = $allBlockMeUser->pluck('by_users__id')->toArray();
        //fetch user liked data by to user id
		$likedCollection = $this->userRepository->fetchUserLikeData(1, false);
		//pluck people like ids
		$peopleLikeIds = $likedCollection->pluck('to_users__id')->toArray();
		//get people likes me data
		$userLikedMeData = $this->userRepository->fetchUserLikeMeData(false)->whereIn('by_users__id', $peopleLikeIds);
		//pluck people like me ids
		$mutualLikeIds = $userLikedMeData->pluck('userId')->toArray();
		
        //array merge of unique users ids
		$ignoreUserIds = array_values(array_unique(array_merge($toUserIds, $blockUserIds, $blockMeUserIds, $mutualLikeIds, [getUserID()])));

		//fetch filter booster user data
		$boosterUser = $this->userSettingRepository->fetchFilterRandomUser($inputData, $ignoreUserIds, 'boosterUser');
	
		//pluck booster user ids
		$boosterUserIds = $boosterUser->pluck('user_id')->toArray();
			
		$totalRandomUser = getStoreSettings('booster_user_count') + getStoreSettings('premium_user_count') + getStoreSettings('normal_user_count');
		$randomBoosterUserCount = getStoreSettings('booster_user_count');
		
		//check is not empty and booster user length greater than or equal to 4 
		//then fetch 4 booster random user
		if (!__isEmpty($boosterUser) and $randomBoosterUserCount > 0 and $boosterUser->count() >= $randomBoosterUserCount) {
			$randomBoosterUser = $boosterUser->random($randomBoosterUserCount)->toArray();
			$totalRandomUser = $totalRandomUser - count($randomBoosterUser);
		
		//check is not empty and booster user length less than 4 
		//then total booster length count record
		} else if (!__isEmpty($boosterUser) and $randomBoosterUserCount > 0 and $boosterUser->count() < $randomBoosterUserCount) {
			$randomBoosterUser = $boosterUser->random($boosterUser->count())->toArray();
			$totalRandomUser = $totalRandomUser - count($randomBoosterUser);
		
		//if it is empty booster user then pass on blank array or total fetch user count
		} else {
			$randomBoosterUser = [];
			$totalRandomUser = $totalRandomUser - 0;
		}
	
		//array merge of unique users ids / or ignore booster filter user ids
		$ignoreBoosterUserIds = array_values(array_unique(array_merge($ignoreUserIds, $boosterUserIds)));

		//fetch filter premium user data
		$premiumUser = $this->userSettingRepository->fetchFilterRandomUser($inputData, $ignoreBoosterUserIds, 'premiumUser');
		
		//pluck premium user ids
		$premiumUserIds = $premiumUser->pluck('user_id')->toArray();
		
		$randomPremiumUserCount = getStoreSettings('premium_user_count');
		//check is not empty and premium user length greater than or equal to 4 
		//then fetch 4 premium random user
		if (!__isEmpty($premiumUser) and $randomPremiumUserCount > 0 and $premiumUser->count() >= $randomPremiumUserCount) {
			$randomPremiumUser = $premiumUser->random($randomPremiumUserCount)->toArray();
			$totalRandomUser = $totalRandomUser - count($randomPremiumUser);
		
		//check is not empty and premium user length less than 4 
		//then total premium length count record
		} else if (!__isEmpty($premiumUser) and $randomPremiumUserCount > 0 and $premiumUser->count() < $randomPremiumUserCount) {
			$randomPremiumUser = $premiumUser->random($premiumUser->count())->toArray();
			$totalRandomUser = $totalRandomUser - count($randomPremiumUser);
			
		//if it is empty booster user then pass on blank array or total fetch user count
		} else {
			$randomPremiumUser = [];
			$totalRandomUser = $totalRandomUser - 0;
		}
		
		//array merge of unique users ids / or ignore booster Premium filter user ids
		$ignorePremiumUserIds = array_values(array_unique(array_merge($ignoreUserIds, $ignoreBoosterUserIds, $premiumUserIds)));
		//fetch filter premium user data
		$normalUser = $this->userSettingRepository->fetchFilterRandomUser($inputData, $ignorePremiumUserIds, 'normalUser');
		
		//check is not empty then fetch total count random user
		if (!__isEmpty($normalUser) and $totalRandomUser > 0 and $normalUser->count() >= $totalRandomUser) {
			$randomNormalUser = $normalUser->random($totalRandomUser)->toArray();
		//check is not empty and normal user length less than 4 
		//then total normal length count record
		} else if (!__isEmpty($normalUser) and $totalRandomUser > 0 and $normalUser->count() < $totalRandomUser) {
			$randomNormalUser = $normalUser->random($normalUser->count())->toArray();
		//else fetch blank array
		} else {
			$randomNormalUser = [];
		}
		
		//get merge of fetch booster, premium and standard user data
		$filterDataCollection = array_merge($randomBoosterUser, $randomPremiumUser, $randomNormalUser);
		
        $filterData = [];
        // check if filter data exists
        if (!\__isEmpty($filterDataCollection)) {
            foreach ($filterDataCollection as $filter) {
				
                $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $filter['user_uid']]);
                $profilePictureUrl = noThumbImageURL();
                // Check if user profile exists
                if (!__isEmpty($filter)) {
                    if (!__isEmpty($filter['profile_picture'])) {
                        $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $filter['profile_picture']);
                    }
                }

                $userAge = isset($filter['dob']) ? Carbon::parse($filter['dob'])->age : null;
				$gender = isset($filter['gender']) ? configItem('user_settings.gender', $filter['gender']) : null;

                // Prepare data for filter
                $filterData[] = [
                    'id'            => $filter['user_id'],
                    'username'      => $filter['username'],
                    'fullName'      => $filter['first_name'].' '.$filter['last_name'],
                    'profileImage'  => $profilePictureUrl,
					'gender' 		=> $gender,
					'dob' 			=> $filter['dob'],
					'userAge'		=> $userAge,
                    'countryName' 	=> $filter['countryName'],
                    'userOnlineStatus' => $this->getUserOnlineStatus($filter['user_authority_updated_at']),
					'isPremiumUser'		=> isPremiumUser($filter['user_id']),
					'detailString'	=> implode(", ", array_filter([$userAge, $gender]))
                ];                
            }
        }

        return $this->engineReaction(1, [
            'filterData' => $filterData
        ]);
    }
}