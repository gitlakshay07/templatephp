<div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
  <span class="mask bg-gradient-dark opacity-6"></span>
  <div class="container my-auto">
    <div class="row">
      <div class="col-lg-4 col-md-8 col-12 mx-auto">
        <div class="card z-index-0 fadeIn3 fadeInBottom">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
              <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Enter OTP</h4>
            </div>
          </div>
          <div class="card-body">
            <form role="form" action="/sign-in" method="post" id="otpform" class="text-start">
              <div class="input-group input-group-outline mb-3">
                <label class="form-label" for="otp">OTP</label>
                <input type="text" class="form-control" name="otp" id="otp">
                <label class="error w-100" for="otp"></label>
              </div>
              <div id="newpassfield" class="d-none">
                <div class="input-group input-group-outline my-3">
                  <label class="form-label" for="password">Password</label>
                  <input type="password" name="password" id="password" class="form-control">
                  <label class="error w-100" for="password"></label>
                </div>
                <div class="input-group input-group-outline my-3">
                  <label class="form-label" for="confpassword">Confirm Password</label>
                  <input type="password" name="conf_password" id="confpassword" class="form-control">
                  <label class="error w-100" for="confpassword"></label>
                </div>
              </div>
              <div class="text-center">
                <label class="error w-100" for="otpform"></label>
                <input type="hidden" id="email" name="email" value="<?php echo $_POST['email'] ?>">
                <button type="submit" id="submitbtn" class="btn bg-gradient-dark w-100 my-4 mb-2">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>