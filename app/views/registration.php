
    <div class="row">
        <div class="card center col-lg-6 col-sm-10">
            <h2 class="text-center form-title">Registration</h2>
            <form method="post" id="registration-form">
                <div class="form-group">
                    <input name="login" type="text" class="form-control" id="login-input" placeholder="Create your login:">
                    <div class="error-box" id="login-error"></div>
                </div>
                <div class="form-group">
                    <input name="email" type="email" class="form-control" id="email-input" placeholder="Your email address:">
                    <div class="error-box" id="email-error"></div>
                </div>
                <div class="form-group">
                    <input name="password" type="password" class="form-control" id="password-input" placeholder="Create your password:">
                    <div class="error-box" id="password-error"></div>
                </div>
                <div class="form-group">
                    <input name="passwordRepeat" type="password" class="form-control" id="password-repeat-input" placeholder="Repeat your password:">
                    <div class="error-box" id="passwordRepeat-error"></div>
                </div>
                <div class="mb-2">
                    <p class="text-muted input-message">Are you already signed up? <a href="<?= URL ?>user/login">Click to log in</a></p>
                </div>
                <button name="submit" type="submit" class="btn btn-primary btn-block">Sign Up</button>
            </form>
        </div>
    </div>

    <script src="<?=URL . 'public/assets/js/registration.js'?>"></script>
