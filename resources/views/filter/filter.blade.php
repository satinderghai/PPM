@extends('public-master')
@section('content')


@section('page-title', __tr('Find Matches'))
@section('head-title', __tr('Find Matches'))
@section('keywordName', __tr('Find Matches'))
@section('keyword', __tr('Find Matches'))
@section('description', __tr('Find Matches'))
@section('keywordDescription', __tr('Find Matches'))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<div class="lw-page-content px-2">

    <!-- header advertisement -->

    <div class="lw-ad-block-h90">

    </div>

    <div class="card mb-3 ">

        <div class="card-header d-flex justify-content-between">

           <h3 class="mb-0"><div class="css-r0xk3p" style="font-size: 0.875rem; color: rgb(126, 126, 126);">About <?= $totalCount ?> Results...</div></h3>

           <div class="d-flex"> 


           </div>

       </div>

   </div>

   <div class="card mb-3 ">

    <div class="card-header d-flex justify-content-between align-items-center filter">

     <div class="d-flex">
       <p>Inbox</p>
       <p>Filterd Out</p>
   </div>

   <div class="d-flex align-items-center"> 
    <div class="d-flex list_style_togle">
       <i class="fa-solid fa-table-cells grid_block"></i>
       <i class="fa-solid fa-table-list listing"></i>
   </div>
   <div class="col-md-3 col-sm-12 text-right intrest-input">
       <form action="<?= route('user.read.search') ?>">
         <select name="paginate" id="paginateCountForm">
             <option value="30" @if(Request::get('paginate')) @if(Request::get('paginate') == 30) selected @endif @endif>30 per page</option>
             <option value="60" @if(Request::get('paginate')) @if(Request::get('paginate') == 60) selected @endif @endif>60 per page</option>
             <option value="100" @if(Request::get('paginate')) @if(Request::get('paginate') == 100) selected @endif @endif>100 per page</option>
         </select>
     </form>
 </div>

</div>

</div>

</div>




<div class="card mb-3 d-md-none event-filter">

    <div class="card-header">

     <ul class="mobile-filter">
        <li><a class="btn FormFooter-rightLink u-hide--tablet-up js-toggleSidebarBtn css-157uzvc" id="filterSidebarClose"><svg viewBox="0 0 24 24" fill="black" width="24px" height="24px"><g fill="#949494"><path d="M0 0h24v24H0z" fill="none"></path><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path></g></svg></a></li>
        <li class="nav-item ">

         <select class="select-sidebar">

             <option>Saved Searchs & Option</option>

             <option>List 1</option>

             <option>List 1</option>

         </select>

         <span class="d-flex justify-content-between align-items-center my-2"><button class="web-button">

             Load More

         </button><p>Reset All</p></span>

     </li>

     <!-- Heading -->

     <li class="nav-item justify-content-between text-left select-drop-down">

         <p>Location</p>

         <select class="select-sidebar">

             <option>City, Postel Code</option>

             <option>List 1</option>

             <option>List 1</option>

         </select>

     </li>

     <li class="nav-item justify-content-between text-left select-drop-down">

         <p>Meet Type</p>

         <select class="select-sidebar">

             <option>Any</option>

             <option>List 1</option>

             <option>List 1</option>

         </select>

     </li>

     <li class="nav-item justify-content-between text-left select-drop-down">

         <p>When</p>

         <select class="select-sidebar">

             <option>Any</option>

             <option>List 1</option>

             <option>List 1</option>

         </select>

     </li>

     <li class="nav-item justify-content-between text-left select-drop-down">

         <p>Profile</p>

         <select class="select-sidebar">

             <option>Jhone Deo, Honkin</option>

             <option>List 1</option>

             <option>List 1</option>

         </select>

         <span class="d-flex justify-content-between align-items-center my-2"><button class="web-button">

             Search

         </button><p>Reset All</p></span>

     </li>

 </ul>

</div>

</div>

</div>

<div class="row" id="grid_block">

    @if(!__isEmpty($filterData))
    @foreach($filterData as $filter)

    <div class="col-6 col-sm-6 col-md-4">
        <div class="serch-result-box">
            <div class="result-box-img">
                <img src="<?= imageOrNoImageAvailable($filter['profileImage']) ?>" width="100%">
            </div>

            <?php if( in_array( $filter['user_id'] ,$LikeUserId ) )
{
   $hasLike = "like_true";
}else{
    $hasLike = "";
} 
?>
            <div class="result-box-body">
                <div class="like lw-like-dislike-box">
                   <a href data-action="<?= route('user.write.like_dislike', ['toUserUid' => $filter['user_uid'],'like' => 1]) ?>" data-method="post" data-callback="onLikeCallback" title="Like" class="lw-ajax-link-action lw-like-action-btn" id="lwLikeBtn"> 
                    <i class="fa-solid fa-heart {{ $hasLike }}"></i>
                   </a>
               </div>

               <p class="font-bold">  

                 @if($filter['userOnlineStatus'])

                 @if($filter['userOnlineStatus'] == 1)
                 <span class="lw-dot lw-dot-success" title="Online"></span>
                 @elseif($filter['userOnlineStatus'] == 2)
                 <span class="lw-dot lw-dot-warning" title="Idle"></span>
                 @elseif($filter['userOnlineStatus'] == 3)
                 <span class="lw-dot lw-dot-danger" title="Offline"></span>
                 @endif

                 @endif
                 <!--  -->
                 <?= $filter['username'] ?>
             </p>
             <P class="result-location text-gray-400">  @if($filter['countryName'])
                <?= $filter['userAge'] ?>  <?= $filter['countryName'] ?>
            @endif</P>
            <P>  @if($filter['heading'])
                <?= $filter['heading'] ?>
            @endif</P>
            <a href="{{ url('/') }}"><p>{{ $filter['totalPhotto'] }} photos</p></a>
        </div>
    </div>
</div>



@endforeach
@else
<!-- info message -->
<div class="col-sm-12 alert alert-info">
    <?= __tr('There are no matches found.') ?>
</div>
<!-- / info message -->
@endif

</div>


<div class="row" id="list_view">

   @if(!__isEmpty($filterData))
   @foreach($filterData as $filter)

   <div class="col-md-12">
       <div class="vister d-flex justify-content-between pb-3  align-items-center">
           <div class="img-about d-flex align-items-flex-start">
            <div class="vister-image-icon">
                <img width="300px" class="vister-profile-image" src="<?= imageOrNoImageAvailable($filter['profileImage']) ?>">
                <i class="fa-solid fa-camera"></i>
            </div>
            <div>
               <p class="user-name"> <?= $filter['fullName'] ?></p>
               <p class="location"><?= $filter['heading'] ?></p>
               <p class="adress"> <?= $filter['userAge'] ?> <?= $filter['city'] ?></p>
               <p class="height"><b>Height : </b><?= $filter['height'] ?>cm</p>
               <p class="body"><b>Body : </b><?= $filter['body_type_name'] ?></p>
               <p class="photos">4 photos</p>
           </div>
       </div>
       <div class="about-vistor">   
           <p class="ethnicty"><b>Ethncity : </b><?= $filter['ethnicity_name'] ?></p>
       </div>
       <div>

            <?php if( in_array( $filter['user_id'] ,$LikeUserId ) )
{
   $hasLike = "like_true";
}else{
    $hasLike = "";
} 
?>

        <p class="timing">10 mint Ago</p>
        <div class="like">  <a href data-action="<?= route('user.write.like_dislike', ['toUserUid' => $filter['user_uid'],'like' => 1]) ?>" data-method="post" data-callback="onLikeCallback" title="Like" class="lw-ajax-link-action lw-like-action-btn" id="lwLikeBtn"> 
                    <i class="fa-solid fa-heart {{ $hasLike }}"></i>
                   </a></div>
    </div>

</div>
</div>

@endforeach
@else
<!-- info message -->
<div class="col-sm-12 alert alert-info">
    <?= __tr('There are no matches found.') ?>
</div>
<!-- / info message -->
@endif


<div class="col-md-12">


    <div class="lw-load-more-container">
           @if(!__isEmpty($nextPageUrl))
        <a href="<?= $nextPageUrl ?>"><?= __tr('Load more') ?></a>

        @else
<div class="col-sm-12 alert alert-dark text-center bg-dark text-secondary border-0 mt-5"><?= __tr('Looks like you reached the end.') ?></div>
@endIf

    </div>

</div>

</div>

<!-- /User Specifications -->
@push('appScripts')
<script>
    function loadMoreUsers(responseData) {
        $(function() {
            applyLazyImages();
        });
        var requestData = responseData.data,
        appendData = responseData.response_action.content;
        $('#lwUserFilterContainer').append(appendData);
        $('#lwLoadMoreButton').data('action', requestData.nextPageUrl);
        if (!requestData.hasMorePages) {
            $('.lw-load-more-container').hide();
        }
    }
// Show advance filter
$('#lwShowAdvanceFilterLink').on('click', function(e) {
    e.preventDefault();
    $('.lw-advance-filter-container').addClass('lw-expand-filter');
    $('#lwShowAdvanceFilterLink').hide();
    $('#lwHideAdvanceFilterLink').show();
    // $('.lw-advance-filter-container').show();
});
// Hide advance filter
$('#lwHideAdvanceFilterLink').on('click', function(e) {
    e.preventDefault();
    $('.lw-advance-filter-container').removeClass('lw-expand-filter');
    $('#lwShowAdvanceFilterLink').show();
    $('#lwHideAdvanceFilterLink').hide();
    // $('.lw-advance-filter-container').hide();
});

</script>


<!-- /Logout Modal-->

<script type="text/javascript">
    $(document).ready(
        function(){
            $(".event-filter").hide();
            $(".event-filter-button").click(function () {
                $(".event-filter").show("slow");
            });
            $("#filterSidebarClose").click(function () {
                $(".event-filter").hide("slow");
            });
        });
    </script>
    <script>
        $(document).ready(function() {

           jQuery('#paginateCountForm').change(function() {
            this.form.submit();
        });


          //toggle the component with class accordion_body
          $(".accordion_head").click(function() {
              $(this).toggleClass("active");
              if ($('.accordion_body').is(':visible')) {
                  $(".accordion_body").slideUp(300);
                  $(".plusminus").text('+');
              }
              if ($(this).next(".accordion_body").is(':visible')) {
                  $(this).next(".accordion_body").slideUp(300);
                  $(this).children(".plusminus").text('+');
              } else {
                  $(this).next(".accordion_body").slideDown(300);
                  $(this).children(".plusminus").text('-');
              }
          });
      });



        $(".lw-like-action-btn, .lw-dislike-action-btn").on('click', function() {
            $('.lw-like-dislike-box').addClass("lw-disable-anchor-tag");
        });


         $(".lw-like-action-btn i").on('click', function() {

    if ($(this).hasClass("like_true")) {
      
   $(this).removeClass("like_true");
}else{
     $(this).addClass("like_true");
}

 });





                //on like Callback function
                function onLikeCallback(response) {
                    var requestData = response.data;
        //check reaction code is 1 and status created or updated and like status is 1
        if (response.reaction == 1 && requestData.likeStatus == 1 && (requestData.status == "created" || requestData.status == 'updated')) {
            __DataRequest.updateModels({
                'userLikeStatus'    : '<?= __tr('Liked') ?>', //user liked status
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
                'userLikeStatus'    : '<?= __tr('Like') ?>', //user like status
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
                'userLikeStatus'    : '<?= __tr('Like') ?>', //user like status
            });
            $(".lw-animated-like-heart").toggleClass("lw-is-active");
        }
        //check reaction code is 1 and status deleted and like status is 2
        if (response.reaction == 1 && requestData.likeStatus == 2 && requestData.status == "deleted") {
            __DataRequest.updateModels({
                'userDislikeStatus'     : '<?= __tr('Dislike') ?>', //user like status
            });
            $(".lw-animated-broken-heart").toggleClass("lw-is-active");
        }
        //remove disabled anchor tag class
        _.delay(function() {
            $('.lw-like-dislike-box').removeClass("lw-disable-anchor-tag");
        }, 1000);
    }
    /**************** User Like Dislike Fetch and Callback Block End ******************/

  $('#searchTextField').hide();
 $(document).ready(function(){
  $('body').on('click','.locationFilterMap',function(){
  $('#searchTextField').show();
  });

    $('body').on('click','.locationFilterCity',function(){
  $('#searchTextField').hide();
  });
 });

</script>

@endpush

@stop


