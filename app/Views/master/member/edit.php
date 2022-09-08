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
                            <span class="app-brand-text demo text-body fw-bolder">Member</span>
                        </div>
                        <!-- /Logo -->
                        <form method="POST" enctype="multipart/form-data" id="formAuthentication" class="mb-3">
                            <input type="hidden" name="<?php echo $primaryKey ?>" id="<?php echo $primaryKey ?>" value="<?php echo $idx?>">
                            <div class="mb-3">
                                <label for="mem_id" class="form-label">ID</label>
                                <input type="text" class="form-control" id="mem_id" name="mem_id" placeholder="Enter your id" autofocus value="<?php echo $mem_id ? $mem_id : '1111' ?>" />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="mem_pass">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="mem_pass" class="form-control" name="mem_pass" placeholder="********" aria-describedby="password" value="<?php echo $mem_pass ?>" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="mem_name" class="form-label">Username</label>
                                <input type="text" class="form-control" id="mem_name" name="mem_name" placeholder="Enter your username" value="<?php echo $mem_name ?>" />
                            </div>
                            <div class="mb-3">
                                <label for="mem_tel" class="form-label">TEL</label>
                                <input type="text" class="form-control" id="mem_tel" name="mem_tel" placeholder="Enter your tel" value="<?php echo $mem_tel ?>" />
                            </div>
                            <div class="mb-3">
                                <label for="mem_email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="mem_email" name="mem_email" placeholder="Enter your email" value="<?php echo $mem_email ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="userfile" class="form-label">File Upload</label>
                                <?php
                                if ($mem_thumb1 == '') { ?>
                                <input class="form-control" type="file" id="userfile" name="userfile[]" multiple>
                                <?php } else { ?>
                                    <img src="" alt="image">
                                <?php } ?>
                            </div>


                            <?php if ($idx == '') { ?>
                                <button class="btn btn-primary d-grid w-100">Sign up</button>
                            <?php } else { ?>
                                <button class="btn btn-primary d-grid w-100">Modify</button>
                            <?php } ?>
                        </form>


                    </div>
                </div>
                <!-- Register Card -->
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
