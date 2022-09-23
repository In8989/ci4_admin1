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
                            <span class="app-brand-text demo text-body fw-bolder"><?php echo $conf['boc_title'] ?></span>
                        </div>
                        <!-- /Logo -->
                        <form method="POST" enctype="multipart/form-data" id="formAuthentication" class="mb-3">
                            <input type="hidden" name="<?php echo $primaryKey ?>" id="<?php echo $primaryKey ?>" value="<?php echo $idx ?>">

                            <div class="mb-3">
                                <label for="bod_title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="bod_title" name="bod_title" autofocus value="<?php echo $bod_title ?>" />
                            </div>
                            <div class="mb-3">
                                <label for="bod_content" class="form-label">Content</label>
                                <textarea class="form-control" id="bod_content" name="bod_content"><?php echo $bod_content ?></textarea>
                            </div>

                            <?php
                            if ($conf['boc_file_count'] > 0) {
                                for ($i = 1; $i <= $conf['boc_file_count']; $i++) { ?>
                                    <input class="form-control" type="file" id="userfile<?php echo $i ?>" name="userfile<?php echo $i ?>">
                                    <?php
                                    if ($i == $conf['boc_file_count']) echo "<br/>";
                                }
                            }
                            ?>

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

<script>

    function fileDel(num) {

        let column = "mem_thumb" + num;

        $.ajax({
            type    : 'POST',
            dataType: 'JSON',
            url     : '<?php echo $currentURL; ?>/del_file',
            data    : {'idx': <?php echo $idx ?>, 'column': column},
            success : function (data) {
                if (data['result'] === 'ok') {
                    alert('파일이 삭제되었습니다.');
                    //  이미지 영역 삭제처리
                    $('#thumb_' + num).remove();
                } else {
                    alert('실패');
                }

            },
            error   : function (xhr, ajaxOptions, thrownError) {
                alert('에러');
                console.log(xhr.status);
                console.log(thrownError);
            }
        });

        //document.location.reload();

    }

    function fileDown(fpath) {
        if (!fpath) {
            alert("존재하지 않는 이미지 입니다.");
            return;
        }

        var str = "/uploaded/download/" + fpath;
        window.open(str);
    }
</script>
