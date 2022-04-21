@extends('public-master')
@section('content')
       <div class="lw-page-content px-2">

            <!-- header advertisement -->

            <div class="lw-ad-block-h90">

            </div>

            <div class="card mb-3 d-s-none d-block">

                <div class="card-header d-flex justify-content-between">

                   <h3><i class="fa-solid fa-gear"></i>Setting</h3>

                   <div class="d-flex"> 

                 </div>

             </div>

         </div>


     <div class="card mb-3 d-md-none ">
        <div class="card-header">
         <select class="mobile-setting-list">
             <option>Account</option>
             <option>Settings</option>
             <option>Notification</option>
             <!-- <option>Member Notes</option> -->
             <option>Hidden Members</option>
             <option>Video Chat Permissionss</option>
             <option>Subscription</option>
             <option>Verifications</option>
             <option>Help Center</option>
         </select>
 </div>

</div>

</div>


<div class="card m-2 mb-3">
            <div class="card-body settings-main">
                <!-- info message -->
                   
                    <ul style="list-style: none;">
                        <li class="setting-list-content" id="about-setting">
                            <h5 class="">About</h5>
                            <div class="d-flex py-2">
                                <span>Email :</span>
                                <span>ppm**@gmail.com  <a href="#" class="text-danger"> Edit email</a></span>
                            </div>
                             <div class="d-flex py-2">
                                <span>Password :</span>
                                <span>*****009  <a href="#" class="text-danger"> Edit email</a></span>
                            </div>
                        </li>
                         
                         <li class="setting-list-content" id="notification-setting">
                            <h5 class="">Your Activity</h5>
                            <div class="d-flex py-2">
                                <button class="setting-togle-button active">Visible</button><button class="setting-togle-button">Hidden</button>
                            </div>
                             <div class="py-2">
                                <span>Online Status / Last Active Date 
                                <span><label class="switch">
                                      <input type="checkbox" checked>
                                      <span class="slider round"></span>
                                    </label>
                                    </span></span><br>
                            </div>
                               <div class="py-2">
                                <span>When You View Someone
                                <span><label class="switch">
                                      <input type="checkbox" checked>
                                      <span class="slider round"></span>
                                    </label>
                                    </span></span><br>
                            </div>
                               <div class="py-2">
                                <span>When You Favorite Someone
                                <span><label class="switch">
                                      <input type="checkbox" checked>
                                      <span class="slider round"></span>
                                    </label>
                                    </span></span><br>
                            </div>
                        </li>
                        
                         <li class="setting-list-content">
                            <h5 class="">Search and Dashboard</h5>
                            <div class="d-flex py-2">
                                <button class="setting-togle-button active">Visible</button><button class="setting-togle-button">Hidden</button>
                            </div>
                        </li>
                        <li class="setting-list-content" id="hidden_members">
                            <h5 class="">Hidden Members</h5>
                        </li>
                        <li class="setting-list-content" id="video_chat_permissions">
                            <h5 class="">Video Chat Permissions</h5>
                        </li>
                        <li class="setting-list-content" id="subscription-setting">
                            <h5 class="">Subscription</h5>
                        </li>
                        <li class="setting-list-content" id="security_information">
                            <h5 class="">Security Information</h5>
                        </li>
                        <li class="setting-list-content" id="verifications">
                            <h5 class="">Your Verifications</h5>
                            <div style="padding: 0px 10px;">Verifications help keep our members safe and trustworthy. Plus, members who have verifications are proven to get more views, favorites, and messages! In general, the more verifications you have the more popular you’ll be with our members!</div>
                            <div class="tabordion_settings">
                              <section id="">
                                <div class="grouped-inner">
                                    <label for="option1">ID Verification</label>
                                    <div class="inner-con" style="display: none;">
                                            <div class="inner-main">
                                                <h3 class="sett-title">ID Verification</h3>
                                                <p class="css-textarea">Having an ID verification badge proves that you are, in fact, who you say you are. It's as simple as taking a quick photo of your government issued ID (front and back) and a selfie, which will be compared to your profile. Once your ID is verified by our team, you will see an ID verification badge appear in your profile.</p>
                                                <div class="css-btm">
                                                    <div style="display: flex; justify-content: center; flex-direction: column;">
                                                        <button data-cy-idv="not_started" class="css-btn">Buy ID Verification Badge</button>
                                                    </div>
                                                    <div class="css-btm-con">
                                                        <p style="color: rgb(126, 126, 126); font-size: 12px; line-height: 15px;">Seeking will not store or even have access to the information you provide to this third party, we will merely receive a "Pass" or "Fail".</p>
                                                        <p style="color: rgb(126, 126, 126); font-size: 12px;">(Note: If you fail the background check, you will not receive the verification badge. We do not provide refunds for those who fail the background check, as the background check was performed.)</p>
                                                    </div>
                                                </div>
                                            </div>                                    
                                    </div>
                                </div>
                              </section>
                              <section id="">
                                <div class="grouped-inner">
                                    <label for="option1" class="social">Social Media Verification</label>
                                    <div class="inner-con" style="display: none;">
                                        <div class="inner-main">
                                            <h3 class="sett-title">Social Media Verification</h3>
                                            <p>Stand out from the crowd! Connect one of your social media accounts to your Seeking account and your profile will be given a corresponding badge. For your privacy, Seeking will never share information with these accounts, link to these accounts, or request to post to these accounts.</p>
                                            <div class="css-1ffo5h7"><button class="css-12vin3e"><i class="fa-brands fa-facebook-square"></i>Connect your Facebook</button><button class="css-12vin3e"><i class="fa-brands fa-instagram"></i>Connect your Instagram</button><button data-cy-social-button="linkedin" class="css-12vin3e"><i class="fa-brands fa-linkedin"></i>Connect your LinkedIn</button></div>
                                        </div>                                   
                                    </div>
                                </div>
                              </section>
                              <section id="section3">
                                <div class="grouped-inner">
                                    <label for="option1" class="photo">Photo Verification</label>
                                    <div class="inner-con" style="display: none;">
                                        <div class="inner-main">
                                            <h3 class="sett-title">Photo Verification</h3>
                                            <p>You can use this verification to prove that your profile photos are truly photos of you. It's as simple as taking a quick photo mimicking an example photo we'll show you and submitting it to us to compare to your profile.</p>
                                            <div class="css-3uf4f8" style="display: block; text-align: center;"><button disabled="" data-cy-button="photo-verification" class="css-12vin3e">Verify my photos</button><p class="css-areg8u"></p></div>
                                            <p class="css-btm-con">(Note: You must have at least one approved photo before verifying photos.)</p>
                                        </div>
                                    </div>
                                </div>
                              </section>
                              <section id="section4">
                                <div class="grouped-inner">
                                    <label for="option1" class="background">Background Check</label>
                                    <div class="inner-con" style="display: none;">
                                        <div class="inner-main">
                                            <h3 class="sett-title">We're sorry, background checks are only offered for members who live in the United States.</h3>
                                        </div>  
                                    </div>
                                </div>
                              </section>
                            </div>
                        </li>
                        <li class="setting-list-content" id="help_center">
                            <h5 class="">Help Center</h5>
                        </li>

                          <li class="setting-list-content">
                            <h5 class="">Other Profile Information</h5>
                            <div class="d-flex py-2">
                                <button class="setting-togle-button">Visible</button><button class="setting-togle-button">Hidden</button>
                            </div>
                             <div class="py-2">
                                <span>Join Date
                                <span><label class="switch">
                                      <input type="checkbox" checked>
                                      <span class="slider round"></span>
                                    </label>
                                    </span></span><br>
                            </div>
                               <div class="py-2">
                                <span>Recent Login Location
                                <span><label class="switch">
                                      <input type="checkbox" checked>
                                      <span class="slider round"></span>
                                    </label>
                                    </span></span><br>
                            </div>
                        </li>
                        
                
                        
                          <li class="setting-list-content">
                        
                            <p class="text-danger">Deactivate or Delete Account</p>
                        </li>
                        
                        
                    </ul>
              </div>
</div>

<style type="text/css">

.inner-main {
    padding: 0px 30px;
}
.sett-title {
    color: rgb(71, 71, 71);
    font-size: 18px;
    font-weight: 800;
    line-height: 22px;
    margin: 20px 0px;
    font-family: 'source sans pro,HelveticaNeue,Helvetica,Arial,Sans';
}
.css-textarea {
    font-size: 16px;
    line-height: 22px;
    margin: 0px;
}
.css-btm {
    margin: 40px 0px;
}
.inner-con i.fa-brands {
    font-size: 30px;
}
button.css-btn {
    border-radius: 2px;
    display: inline-flex;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;
    box-sizing: border-box;
    padding: 12px 16px;
    font-family: "Source Sans Pro", HelveticaNeue, Helvetica, Arial, Sans;
    font-size: 16px;
    font-weight: 700;
    line-height: 1;
    outline: none;
    cursor: pointer;
    white-space: nowrap;
    width: 100%;
    border: rgb(207, 4, 4);
    background-color: rgb(207, 4, 4);
    color: rgb(255, 255, 255);
    margin: 0px auto;
    text-overflow: ellipsis;
    overflow: hidden;
    width: 270px !important;
    display: inline-block !important;
}
.css-btm-con {
    margin-top: 40px;
}

.grouped-inner label {
    font-size: 18px;
    font-weight: bold;
    max-height: 114px;
    padding-left: 16px !important;
    box-shadow: rgb(230 230 230) 0px 1px 0px 0px inset, rgb(230 230 230) 0px 1px 0px 0px inset;
    background-color: rgb(247, 247, 247) !important;
    border: none !important;
    text-align: left !important;
    padding: 34px 16px !important;
    width: 100%;
    padding-left: 5!important;
    padding-right: 0!important;
    margin-left: 0!important;
    margin-right: 0!important;
    text-align: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}
.grouped-inner label.active {
    border-right: 0px;
    border-bottom: 0px;
    border-image: initial;
    box-shadow: none;
    background-color: rgb(255, 255, 255) !important;
    border-top: 1px solid rgb(230, 230, 230) !important;
    border-left: 1px solid rgb(230, 230, 230) !important;
    border-radius: 3px !important;
}


.tabordion_settings{
    position: relative;  
    margin: 30px 0px !important;  
}
.tabordion_settings input[name="sections"] {
  left: -9999px;
  position: absolute;
  top: -9999px;
}

.tabordion_settings section {
  display: block;
}

.tabordion_settings section label {
  background: #ccc;
  border:1px solid #fff;
  cursor: pointer;
  display: block;
  font-size: 1.2em;
  font-weight: bold;
  padding: 15px 20px;
  position: relative;
  width: 30%;
  z-index:100;
}
.grouped-inner {
    display: flex;
    flex-direction: row;
}
.inner-con { 
    position: absolute;
    top: 0;
    left: 230px;   
    border-radius: 0px 4px 4px 0px;
    border-top: 1px solid rgb(230, 230, 230) !important;
    border-right: 1px solid rgb(230, 230, 230) !important;
    border-bottom: 1px solid rgb(230, 230, 230) !important;
    border-left: none !important;
    padding: 1em 1em;
    height: 100%;
}

/*Social Media*/
.css-1ffo5h7 {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 24px;
}
button.css-12vin3e {
    min-width: 288px;
    margin-top: 16px;
    border-radius: 2px;
    display: inline-flex;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;
    box-sizing: border-box;
    padding: 10px 16px;
    font-family: "Source Sans Pro", HelveticaNeue, Helvetica, Arial, Sans;
    font-size: 16px;
    font-weight: 700;
    line-height: 1;
    outline: none;
    cursor: pointer;
    white-space: nowrap;
    background: rgb(255, 255, 255);
    color: rgb(66, 66, 66);
    border: 1px solid rgb(204, 204, 204);
}
/*photo-verification*/
.css-12vin3e:disabled {
    color: rgb(153, 153, 153);
    border-color: rgb(153, 153, 153);
}
</style>

@stop
