<main>
  <div class="box-sign">
    <div class="container-left">
      <img src="<?= UPLOAD_IMG ?>/job_portal_sign.jpg" alt="">
    </div>
    <div class="container-right">
      <form id="signin-form" action="" method="POST">
        <div class="title">
          <h1>LOGIN ACCOUNT</h1>
        </div>
        <div class="container-description">
          <div class="container-upper">
            <label for="username">Username</label>
            <div class="container-upper-box">
              <i class="fa-solid fa-user"></i>
              <input type="text" name="username" id="username" placeholder="Username" required>
            </div>
          </div>
          <div class="container-upper next">
            <label for="password">Password</label>
            <div class="container-upper-box">
              <i class="fa-solid fa-lock"></i>
              <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
          </div>
          <!-- <span id="login-err"></span> -->
          <div class="container-lower">
            <div class="container-lower-sub">
              <input type="checkbox" name="remember-me" id="show-password" onclick="ShowPassword()">
              <span>Show Password</span>
            </div>
            <div class="container-lower-sub">
              <a href="">Forget password?</a>
            </div>
          </div>
        </div>
        <div class="wrong-login">Username or Password are wrong!</div>
        <div class="btn-form"><button type="submit">Login</button></div>
        <div class="container-register">
          <p>
            Don't have account? <a href="<?= BASE_URL ?>/signup"> Register here.</a>
          </p>
        </div>
        <div class="container-or">
          --------------- or ---------------
        </div>

        <!-- <div class="g-signin2" data-onsuccess="onSignIn" style="width: 5rem; height: 4rem;"></div> -->
        <div class="container-google">
          <button onclick=""> <img src="<?= UPLOAD_IMG ?>/google.svg" alt=""> Continue with Google</button>
        </div>
      </form>

    </div>
  </div>
</main>

<script>
  function ShowPassword() {
    var x = document.getElementById("password");
    if (x.type == "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }

  function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
  }
</script>

<script>
  const form = document.querySelector("#signin-form");
  form.addEventListener('submit', async (e) => {
    e.preventDefault()
    // todo: add logic for js input check
    const username = form.querySelector("#username").value;
    const password = form.querySelector("#password").value;

    const url = "<?= API ?>/auth?action=validate";
    console.log(url);
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'ContentType': 'application/json'
      },
      body: JSON.stringify({
        'username': username,
        'password': password
      })
    })
    const res = await response.json();
    if (res.status == 'success') {
      window.location.href = "<?= BASE_URL ?>";
    } else {
      // document.querySelector("#login-err").innerHTML = res.msg;
      const wrong = document.querySelector(".wrong-login");
      wrong.style.display = "flex";
    }
  })
</script>