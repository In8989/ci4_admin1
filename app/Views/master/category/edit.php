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
                            <span class="app-brand-text demo text-body fw-bolder">Board Config</span>
                        </div>
                        <!-- /Logo -->

                        <form method="POST" enctype="multipart/form-data" id="formAuthentication" class="mb-3">
                            <input type="hidden" name="<?php echo $primaryKey ?>" id="<?php echo $primaryKey ?>" value="<?php echo $idx ?>">

                            <?php if ($mode == 'addChild') { ?>
                                <input type="hidden" name="cat_group" id="cat_group" value="<?php echo $cat_group ?>">
                                <div class="mb-3">
                                    <label class="form-label">상위분류</label>
                                    <span><?php echo $cat_title ?></span>
                                </div>
                                <div class="mb-3">
                                    <label for="cat_title" class="form-label">카테고리명</label>
                                    <input type="text" class="form-control" id="cat_title" name="cat_title" placeholder="Enter your code" autofocus value="" />
                                </div>
                            <?php } else { ?>

                                <div class="mb-3">
                                    <label for="cat_title" class="form-label">카테고리명</label>
                                    <input type="text" class="form-control" id="cat_title" name="cat_title" placeholder="Enter your code" autofocus value="<?php echo $cat_title ?>" />
                                </div>

                            <?php } ?>

                            <div class="mb-3">
                                <label class="form-label">상태</label>
                                <div>
                                    <input type="radio" class="form-check-input" id="cat_state_1" name="cat_state" value="1" />
                                    <label for="cat_state_1">사용</label>
                                    <input type="radio" class="form-check-input" id="cat_state_0" name="cat_state" value="0" />
                                    <label for="cat_state_0">사용안함</label>
                                </div>
                            </div>

                            <?php if ($idx) { ?>
                                <div class="mb-3">
                                    <label class="form-label">순서</label>
                                    <div>
                                        <label for="cat_sort" class="form-label">카테고리명</label>
                                        <input type="text" class="form-control" id="cat_sort" name="cat_sort" placeholder="Enter your code" autofocus value="<?php echo $cat_sort ?>" />
                                    </div>
                                </div>
                            <?php } ?>

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
