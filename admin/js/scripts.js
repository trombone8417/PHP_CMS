// 文字編輯器
tinymce.init({
    selector: 'textarea'
});

$(document).ready(function () {
    // 資料表
    $('#myTable').DataTable();
    // checkbox
    $('#selectAllBoxes').click(function (event) {
        if (this.checked) {
            // 全選
            $('.checkBoxes').each(function () {
                this.checked = true;
            });

        } else {
            // 全不選
            $('.checkBoxes').each(function () {
                this.checked = false;
            });
        }

    });
});

// loading 圖案
// var div_box = "<div id='load-screen'><div id='loading'></div></div>"
// $("body").prepend(div_box);
// $('#load-screen').delay(350).fadeOut(300, function(){
//     $(this).remove();
// });