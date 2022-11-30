$(document).ready(function () {

    $('form').on('submit', function () {
        click_submit(this);
    });

})

function click_submit(f) {
    //let len = oEditors.length;
    //for(k=0;k<len;k++)oEditors[k].exec("UPDATE_CONTENTS_FIELD", []);

    oEditors.getById[fieldName].exec("UPDATE_CONTENTS_FIELD", []);
    return true;
}

// 카테고리 1 의 선택에 따라 카테고리 2 만들기
function categorySetting(box_id) {

    const box1 = '#' + box_id + '1';
    const box2 = '#' + box_id + '2';
    $(box1).change(function () {

        let box1_group = $(this).find("option:selected").attr('data-cat-group');

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
                            html += "<option value='" + item.cat_idx + "'>" + item.cat_title + "</option>"
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
                console.log(xhr.status);
                console.log(thrownError);
            }
        });

    });
}
