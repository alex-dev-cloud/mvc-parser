
<div class="row">
        <div class="card center col-lg-6 col-sm-10">
            <h2 class="text-center form-title">Log in</h2>
            <form method="post" id="login-form">
                <div class="form-group">
                    <input name="login" type="text" class="form-control" id="login-input" placeholder="Enter your login:">
                    <div class="error-box" id="login-error"></div>
                </div>
                <div class="form-group">
                    <input name="password" type="password" class="form-control" id="password-input" placeholder="Enter your password:">
                    <div class="error-box" id="password-error"></div>
                </div>
                <div class="error-message text-center"></div>
                <div class="mb-2">
                    <p class="text-muted input-message">You don't have an account? <a href="<?= URL ?>user/registration">Click to sign up</a></p>
                </div>
                <button name="submit" type="submit" class="btn btn-primary btn-block">Log in</button>
            </form>
        </div>
</div>
<script src="<?=URL . 'public/assets/js/login.js'?>"></script>
