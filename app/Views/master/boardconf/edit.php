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
                            <div class="mb-3">
                                <label for="boc_code" class="form-label">게시판 코드</label>
                                <input type="text" class="form-control" id="boc_code" name="boc_code" placeholder="Enter your code" autofocus value="<?php echo $boc_code ?>" />
                            </div>
                            <div class="mb-3">
                                <label for="boc_title" class="form-label">게시판명</label>
                                <input type="text" class="form-control" id="boc_title" name="boc_title" placeholder="Enter your title" value="<?php echo $boc_title ?>" />
                            </div>
                            <div class="mb-3">
                                <label for="boc_skin" class="form-label">스킨</label>
                                <input type="text" class="form-control" id="boc_skin" name="boc_skin" placeholder="Enter your title" value="<?php echo $boc_skin ?>" />
                            </div>
                            <div class="mb-3">
                                <label for="boc_list_size" class="form-label">목록 수</label>
                                <input type="number" class="form-control" id="boc_list_size" name="boc_list_size" placeholder="Enter your size" value="<?php echo $boc_list_size ?>" />
                            </div>
                            <div class="mb-3">
                                <label for="boc_file_count" class="form-label">첨부파일 수</label>
                                <select class="form-select" name="boc_file_count" id="boc_file_count">
                                    <option value="0">사용안함</option>
                                    <option value="1" <?php if ($boc_file_count == '1') echo 'selected'; ?>>1</option>
                                    <option value="2" <?php if ($boc_file_count == '2') echo 'selected'; ?>>2</option>
                                </select>
                            </div>

                            <p>권한설정</p>

                            <div class="mb-3">
                                <label for="" class="form-label">게시판 접근</label>
                                <div>
                                    <span>
                                        <input class="form-check-input" type="radio" name="boc_auth_list" id="boc_auth_list_0" value="0" <?php if ($boc_auth_list == '0') echo 'checked'; ?>>
                                        <label for="boc_auth_list_0">비회원</label>
                                    </span>
                                    <span>
                                        <input class="form-check-input" type="radio" name="boc_auth_list" id="boc_auth_list_10" value="10" <?php if ($boc_auth_list == '10') echo 'checked'; ?>>
                                        <label for="boc_auth_list_10">일반회원</label>
                                    </span>
                                    <span>
                                        <input class="form-check-input" type="radio" name="boc_auth_list" id="boc_auth_list_90" value="90" <?php if ($boc_auth_list == '90') echo 'checked'; ?>>
                                        <label for="boc_auth_list_90">관리자</label>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">게시판 읽기</label>
                                <div>
                                    <span>
                                        <input class="form-check-input" type="radio" name="boc_auth_read" id="boc_auth_read_0" value="0" <?php if ($boc_auth_read == '0') echo 'checked'; ?>>
                                        <label for="boc_auth_read_0">비회원</label>
                                    </span>
                                    <span>
                                        <input class="form-check-input" type="radio" name="boc_auth_read" id="boc_auth_read_10" value="10" <?php if ($boc_auth_read == '10') echo 'checked'; ?>>
                                        <label for="boc_auth_read_10">일반회원</label>
                                    </span>
                                    <span>
                                        <input class="form-check-input" type="radio" name="boc_auth_read" id="boc_auth_read_90" value="90" <?php if ($boc_auth_read == '90') echo 'checked'; ?>>
                                        <label for="boc_auth_read_90">관리자</label>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">게시판 쓰기</label>
                                <div>
                                    <span>
                                        <input class="form-check-input" type="radio" name="boc_auth_write" id="boc_auth_write_0" value="0" <?php if ($boc_auth_write == '0') echo 'checked'; ?>>
                                        <label for="boc_auth_write_0">비회원</label>
                                    </span>
                                    <span>
                                        <input class="form-check-input" type="radio" name="boc_auth_write" id="boc_auth_write_10" value="10" <?php if ($boc_auth_write == '10') echo 'checked'; ?>>
                                        <label for="boc_auth_write_10">일반회원</label>
                                    </span>
                                    <span>
                                        <input class="form-check-input" type="radio" name="boc_auth_write" id="boc_auth_write_90" value="90" <?php if ($boc_auth_write == '90') echo 'checked'; ?>>
                                        <label for="boc_auth_write_90">관리자</label>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">게시판 답변</label>
                                <div>
                                    <span>
                                        <input class="form-check-input" type="radio" name="boc_auth_reply" id="boc_auth_reply_0" value="0" <?php if ($boc_auth_reply == '0') echo 'checked'; ?>>
                                        <label for="boc_auth_reply_0">비회원</label>
                                    </span>
                                    <span>
                                        <input class="form-check-input" type="radio" name="boc_auth_reply" id="boc_auth_reply_10" value="10" <?php if ($boc_auth_reply == '10') echo 'checked'; ?>>
                                        <label for="boc_auth_reply_10">일반회원</label>
                                    </span>
                                    <span>
                                        <input class="form-check-input" type="radio" name="boc_auth_reply" id="boc_auth_reply_90" value="90" <?php if ($boc_auth_reply == '90') echo 'checked'; ?>>
                                        <label for="boc_auth_reply_90">관리자</label>
                                    </span>
                                </div>
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
