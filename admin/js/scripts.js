// 文字編輯器
tinymce.init({
    selector: 'textarea'
});
$(document).ready(function () {
    $('#myTable').DataTable();
    $('#selectAllBoxes').click(function (event) {
        if (this.checked) {
            $('.checkBoxes').each(function () {
                this.checked = true;
            });

        } else {
            $('.checkBoxes').each(function () {
                this.checked = false;
            });
        }

    });
});