<main>
  <div class="box-sign">
    <div class="container-left">
      <img src="<?= UPLOAD_IMG ?>/job_portal_sign.jpg" alt="">
    </div>
    <div class="container-right">
      <form id="register-form" action="" method="POST">
        <div class="title">
          <h1>REGISTER ACCOUNT</h1>
        </div>
        <div class="container-description">
          <div class="container-upper">
            <label for="username">Username</label>
            <div class="container-upper-box">
              <i class="fa-solid fa-user"></i>
              <input type="text" name="username" id="username" placeholder="Enter Username" required>
            </div>
          </div>
          <div class="username-taken" >This username had been already taken.</div>
          <div class="container-upper next">
            <label for="email">Email</label>
            <div class="container-upper-box">
              <i class="fa-solid fa-envelope"></i>
              <input type="email" name="email" id="email" placeholder="Enter your Email" required>
            </div>
          </div>
          <div class="email-taken">This email had been already taken.</div>
          <div class="container-upper next">
            <label for="company">Company</label>
            <div class="container-upper-box">
              <i class="fa-solid fa-briefcase"></i>
              <input type="text" name="company" id="company" placeholder="Enter your Company" required>
            </div>
          </div>
          <div class="company-taken">This company has been registered.</div>
          <div class="container-upper next">
            <label for="password">Password</label>
            <div class="container-upper-box">
              <i class="fa-solid fa-lock"></i>
              <input type="password" name="password" id="password" placeholder="Enter your Password" required>
            </div>
          </div>
          <div class="container-upper next">
            <label for="confirm-password">Confirm Password</label>
            <div class="container-upper-box">
              <i class="fa-solid fa-lock"></i>
              <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm your Password" required>
            </div>
          </div>
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
        <div class="btn-form"><button type="submit">Register</button></div>
        <div class="container-register">
          <p>
            Already have account? <a href="<?= BASE_URL ?>/signin"> Login here.</a>
          </p>
        </div>

      </form>

    </div>
  </div>
</main>

<script>
  function ShowPassword() {
    var x = document.getElementById("password");
    var y = document.getElementById("confirm-password");
    if (x.type == "password") {
      x.type = "text";
      y.type = "text";
    } else {
      x.type = "password";
      y.type = "password";
    }
  }
</script>

<script>
  const form = document.querySelector("#register-form");
  form.addEventListener('submit', async (e) => {
    e.preventDefault()
    // todo: add logic for js input check
    const username = form.querySelector("#username").value;
    const password = form.querySelector("#password").value;
    const confirmPassword = form.querySelector("#confirm-password").value;
    if (password !== confirmPassword) {
      alert("Passwords do not match!");
      return;
    }
    const email = form.querySelector("#email").value;
    const company = form.querySelector("#company").value;
    const url = "<?= API ?>/auth?action=register";
    console.log(url);
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        'username': username,
        'password': password,
        'email': email,
        'company': company,
      })
    })
    const res = await response.json();
    console.log(res);
    if (res.status == 'success') {
      window.location.href = window.BASE_URL;
    } else if (res.status == 'duplicate') {
      if ('exist_username' in res){
        if (res.exist_username == 1) {
          const a =document.querySelector('.username-taken');
          a.style.display = "block";
        } else {
          const a =document.querySelector('.username-taken');
          a.style.display = "none";
        }
        if (res.exist_email == 1){
          const b =document.querySelector('.email-taken');
          b.style.display = "block";
        } else {
          const b =document.querySelector('.email-taken');
          b.style.display = "none";
        }
        if (res.exist_company == 1){
          const c =document.querySelector('.company-taken');
          c.style.display = "block";
        } else {
          const c =document.querySelector('.company-taken');
          c.style.display = "none";
        }
      }
    }
  })
</script>