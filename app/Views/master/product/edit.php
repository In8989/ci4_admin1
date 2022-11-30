<script type="text/javascript">
    $(document).ready(function () {

        categoryInit();
        categorySetting('prd_cat_idx');
    });

    function categoryInit() {
        const prd_cat_idx2 = '<?= $prd_cat_idx2 ?>';
        if (!prd_cat_idx2) return;

        const box1 = '#prd_cat_idx1';
        const box2 = '#prd_cat_idx2';

        let box1_group = $(box1).find("option:selected").attr('data-cat-group');
        let html = "<option>카테고리를 선택해주세요.</option>";

        $.ajax({
            type    : 'POST',
            dataType: 'JSON',
            url     : '/master/product/categoryChildGet',
            data    : {'cat_group': box1_group},
            success : function (data) {
                if (data['success'] === 'ok') {
                    const cate2 = data['result'];
                    if (cate2.length > 0) {
                        cate2.forEach(function (item) {
                            let selected = prd_cat_idx2 === item.cat_idx ? 'selected' : '';
                            html += "<option value='" + item.cat_idx + "' " + selected + ">" + item.cat_title + "</option>"
                        });
                        $(box2).parent().css('display', 'block');

                    } else {
                        $(box2).parent().css('display', 'none');
                    }

                    $(box2 + ' option').remove();
                    $(box2).append(html);
                }

            },
            error   : function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(thrownError);
            }
        });


    }
</script>

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
                                <label for="prd_cat_idx1" class="form-label">카테고리1</label>
                                <select name="prd_cat_idx1" id="prd_cat_idx1">
                                    <option>카테고리를 선택해주세요.</option>
                                    <?php foreach ($cate1 as $iValue) {
                                        $selected = $prd_cat_idx1 === $iValue['cat_idx'] ? 'selected' : '';
                                        echo "<option value='{$iValue['cat_idx']}' data-cat-group='{$iValue['cat_group']}' {$selected}>{$iValue['cat_title']}</option>";
                                    } ?>
                                </select>
                            </div>

                            <div class="mb-3" id="cat2_box" style="display: none;">
                                <label for="prd_cat_idx2" class="form-label">카테고리2</label>
                                <select name="prd_cat_idx2" id="prd_cat_idx2"></select>
                            </div>


                            <div class="mb-3">
                                <label class="form-label">제목</label>
                                <input type="text" class="form-control" id="prd_title" name="prd_title" autofocus value="<?php echo $prd_title ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="prd_subtitle" class="form-label">부제목</label>
                                <input type="text" class="form-control" id="prd_subtitle" name="prd_subtitle" autofocus value="<?php echo $prd_subtitle ?>" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">상태</label>
                                <div>
                                    <input type="radio" class="form-check-input" id="prd_state_1" name="prd_state" value="10" />
                                    <label for="prd_state_1">판매중</label>
                                    <input type="radio" class="form-check-input" id="prd_state_1" name="prd_state" value="1" />
                                    <label for="prd_state_1">품절</label>
                                    <input type="radio" class="form-check-input" id="prd_state_0" name="prd_state" value="-1" />
                                    <label for="prd_state_0">숨김</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="prd_sort" class="form-label">순서</label>
                                <input type="text" class="form-control" id="prd_sort" name="prd_sort" autofocus value="<?php echo $prd_sort ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="prd_common_price" class="form-label">일반가격</label>
                                <input type="text" class="form-control" id="prd_common_price" name="prd_common_price" autofocus value="<?php echo $prd_common_price ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="prd_price" class="form-label">가격</label>
                                <input type="text" class="form-control" id="prd_price" name="prd_price" autofocus value="<?php echo $prd_price ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="prd_content" class="form-label">내용</label>
                                <script type="text/javascript" src="/assets/plugins/smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
                                <script>
                                    function fnSmartEditorFilePathGet() {
                                        return;
                                    }
                                </script>

                                <div id="smarteditor">
                                    <textarea name="prd_content" id="prd_content" rows="20" cols="10" placeholder="내용을 입력해주세요" style="width: 100%"><?php echo $prd_content ?></textarea>
                                </div>

                                <script>
                                    let oEditors = []
                                    let fieldName = 'prd_content';

                                    nhn.husky.EZCreator.createInIFrame({
                                        oAppRef      : oEditors,
                                        elPlaceHolder: fieldName,
                                        sSkinURI     : "/assets/plugins/smarteditor/SmartEditor2Skin.html",
                                        fCreator     : "createSEditor2",
                                        fOnAppLoad   : function () {
                                            oEditors.getById[fieldName].exec("PARSE_HTML", ["내용을 입력하세요."])
                                        },
                                    })
                                    /*
                                    function click_submit(f) {
                                        //let len = oEditors.length;
                                        //for(k=0;k<len;k++)oEditors[k].exec("UPDATE_CONTENTS_FIELD", []);

                                        oEditors.getById[fieldName].exec("UPDATE_CONTENTS_FIELD", []);
                                        return true;
                                    }

                                    $('form').on('submit', function () {
                                        click_submit(this);
                                    });*/
                                </script>
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
