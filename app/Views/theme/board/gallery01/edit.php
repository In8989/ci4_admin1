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
                                <label><input type="checkbox" name="bod_is_notice" value="1" autocomplete="off"> 공지사항으로 설정</label>
                            </div>
                            <div class="mb-3">
                                <label for="bod_title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="bod_title" name="bod_title" autofocus value="<?php echo $bod_title ?>" />
                            </div>
                            <div class="mb-3">
                                <label for="bod_content" class="form-label">Content</label>
                                <?php if ($conf['boc_use_editor']) { ?>
                                    <script type="text/javascript" src="/assets/plugins/smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
                                    <script>
                                        function fnSmartEditorFilePathGet(){
                                            return;
                                        }
                                    </script>
                                    <div id="smarteditor">
                                        <textarea name="bod_content" id="bod_content" rows="20" cols="10" placeholder="내용을 입력해주세요" style="width: 100%"><?php echo $bod_content ?></textarea>
                                    </div>
                                    <script>
                                        let oEditors = []
                                        let fieldName = 'bod_content';

                                        nhn.husky.EZCreator.createInIFrame({
                                            oAppRef      : oEditors,
                                            elPlaceHolder: fieldName,
                                            sSkinURI     : "/assets/plugins//smarteditor/SmartEditor2Skin.html",
                                            fCreator     : "createSEditor2",
                                            fOnAppLoad   : function () {
                                                oEditors.getById[fieldName].exec("PARSE_HTML", ["내용을 입력하세요."])
                                            },
                                        })

                                        function click_submit(f) {
                                            oEditors.getById[fieldName].exec("UPDATE_CONTENTS_FIELD", []);
                                            return true;
                                        }

                                        $('form').on('submit', function () {
                                            click_submit(this);
                                        });
                                    </script>
                                <?php } else { ?>
                                    <textarea class="form-control" id="bod_content" name="bod_content"><?php echo $bod_content ?></textarea>
                                <?php } ?>
                            </div>

                            <?php
                            if ($conf['boc_file_count'] > 0) {
                                for ($i = 1; $i <= $conf['boc_file_count']; $i++) { ?>
                                    <input class="form-control" type="file" id="userfile<?php echo $i ?>" name="userfile<?php echo $i ?>">
                                    <?php if (isset($bof_list[$i]['bof_idx'])) { ?>
                                        <div id="thumb_<?php echo $bof_list[$i]['bof_idx'] ?>">
                                            <img src="/uploaded/file/<?php echo $bof_list[$i]['bof_file_save'] ?>" width="100">
                                            <button type="button" onclick="fileDown('<?php echo $bof_list[$i]['bof_file_save'] ?>')">다운로드</button>
                                        </div>
                                    <?php }
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

    function fileDown(fpath) {
        if (!fpath) {
            alert("존재하지 않는 이미지 입니다.");
            return;
        }

        var str = "/uploaded/download/" + fpath;
        window.open(str);
    }
</script>
