<div id="createOil" class="modal">
    <div class="modal-content">
        {{--Title--}}
        <h5 class="indigo-text">新增產品<span class="right modal-close"><i class="material-icons">close</i></span></h5>

        {{--Form--}}
        <form id="createOilForm" name="createOilForm" enctype="multipart/form-data" action="{{ route('oil.store') }}" method="post">
            {{ csrf_field() }}
            {{--Name--}}
            <div class="input-field">
                <input id="name" name="name" type="text" class="validate" required>
                <label for="name">產品名稱<span class="red-text">*</span></label>
            </div>

            {{--Count--}}
            <div class="input-field">
                <input id="count" name="count" type="number" class="validate" min="0" required>
                <label for="count">數量<span class="red-text">*</span></label>
            </div>

            {{--Photo--}}
            <div class="file-field input-field">
                <div class="btn">
                    <span>產品圖片</span>
                    <input name="photo" type="file">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" name="photoname" type="text" placeholder="選擇圖片">
                </div>
            </div>
        </form>

        {{--Uploading--}}
        <div id="storing"></div>
    </div>
    <div class="modal-footer">
        <button class="btn waves-effect waves-light" type="submit" name="action" onclick="storeOil()">確認
            <i class="material-icons right">send</i>
        </button>
    </div>
</div>

<script src="http://malsup.github.io/min/jquery.form.min.js"></script>
<script>
    function storeOil() {
        var warning = '<h4 class="red-text"><i class="material-icons">error_outline</i>請輸入正確的產品名稱或數量</h4>';
        var error = '<h4 class="red-text"><i class="material-icons">error</i>錯誤</h4>';
        var success = '<h4 class="green-text"><i class="material-icons">done</i>產品儲存成功</h4>';

        var name = document.createOilForm.name.value;
        var count = document.createOilForm.count.value;
        if (name.length < 1 || isNaN(parseInt(count))) {
            $('#storing').html(warning);
            return;
        }

        $('#storing').html(loading);

        $('#createOilForm').ajaxSubmit({
            success: function (res) {
                var time = new Date();
                if (res.result == 'ok') {
                    refresh = true;
                    document.createOilForm.name.value = '';
                    document.createOilForm.count.value = 0;
                    document.createOilForm.photo.value = '';
                    document.createOilForm.photoname.value = '';
                    response = '<span>' + time.toLocaleDateString() + ' ' +  time.toTimeString() + '</span>' + success;
                    $('#storing').html(response);
                } else {
                    if(typeof(res.msg) == 'object' ) {
                        var message = '<ul class="red-text">';
                        for (var key in res.msg) {
                            console.log(key)
                            for (var m in res.msg[key]) {
                                message += '<li>' + res.msg[key][m] + '</li>';
                            }
                        }
                        message += '</ul>';
                        $('#storing').html(error + message);
                    } else {
                        var message = '<p class="red-text">' + res.msg + '</p>'
                        $('#storing').html(error + message);
                    }
                }
                console.log(res);
            },
            error: function (xhr) {
                $('body').html(xhr.responseText);
            }
        });
    }
</script>