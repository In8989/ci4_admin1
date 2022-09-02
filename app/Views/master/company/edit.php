<!-- Content -->
<div class="layout-page">
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <span class="app-brand-text demo text-body fw-bolder">Company</span>
                        </div>
                        <!-- /Logo -->
                        <form method="POST" enctype="multipart/form-data" id="formAuthentication" class="mb-3">
                            <input type="hidden" name="<?php echo $primaryKey ?>" id="<?php echo $primaryKey ?>" value="<?php echo $idx?>">
                            <div class="mb-3">
                                <label for="com_id" class="form-label">ID</label>
                                <input type="text" class="form-control" id="com_id" name="com_id" placeholder="Enter your id" autofocus value="<?php echo $com_id ?>" />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="com_pass">Password</label>
                                <div class="input-group input-group-merge">
                                    <input
                                            type="password"
                                            id="com_pass"
                                            class="form-control"
                                            name="com_pass"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password"
                                            value="<?php echo $com_pass ?>"
                                    />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="com_name" class="form-label">Username</label>
                                <input
                                        type="text"
                                        class="form-control"
                                        id="com_name"
                                        name="com_name"
                                        placeholder="Enter your username"
                                        value="<?php echo $com_name ?>"
                                />
                            </div>
                            <div class="mb-3">
                                <label for="com_tel" class="form-label">TEL</label>
                                <input type="text" class="form-control" id="com_tel" name="com_tel" placeholder="Enter your tel" value="<?php echo $com_tel ?>" />
                            </div>
                            <div class="mb-3">
                                <label for="com_email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="com_email" name="com_email" placeholder="Enter your email" value="<?php echo $com_email ?>" />
                            </div>


                            <?php if ($idx == '') { ?>
                                <button class="btn btn-primary d-grid w-100">Sign up</button>
                            <?php } else { ?>
                                <button class="btn btn-primary d-grid w-100">Modify</button>
                            <?php } ?>
                        </form>

                        <p class="text-center">
                            <span>Already have an account?</span>
                            <a href="auth-login-basic.html">
                                <span>Sign in instead</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- Register Card -->
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
