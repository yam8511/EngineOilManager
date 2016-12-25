<!DOCTYPE html>
<html>
<head>
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="{{ url('css/materialize.min.css') }}">
    <title>良偉機車行</title>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>

<body class="grey darken-4">

@if(count($oils) == 0)
    <div class="container-fluid show-on-medium-and-up">
        <div class="card-panel">
            <h5><a href="#createOil"><i class="material-icons medium">note_add</i>目前無任何產品, 點擊我可以新增產品</a></h5>
        </div>
    </div>
@endif

<div class="container-fluid show-on-medium-and-up">
    <ul class="collection">
        @foreach($oils as $index => $oil)
            @include('collection')
        @endforeach
    </ul>
</div>

{{-- 右下角選端按鈕 --}}
<div class="fixed-action-btn horizontal click-to-toggle">
    <a class="btn-floating btn-large yellow" href="#createOil">
        <i class="material-icons  black-text">create</i>
    </a>
</div>

{{--<div class="fixed-action-btn toolbar">--}}
    {{--<a class="btn-floating btn-large indigo">--}}
        {{--<i class="large material-icons">menu</i>--}}
    {{--</a>--}}
    {{--<ul>--}}
        {{--<li class="waves-effect waves-light purple"><a href="#!"><i class="material-icons">search</i></a></li>--}}
        {{--<li class="waves-effect grey darken-3">--}}
            {{--<div class="input-field">--}}
            {{--<i class="material-icons prefix">search</i>--}}
            {{--<input id="search_prefix" type="text" class="validate white-text">--}}
            {{--<label for="search_prefix">搜尋</label>--}}
            {{--</div>--}}
        {{--</li>--}}
        {{--<li class="waves-effect waves-light yellow"><a href="#createOil"><i class="material-icons black-text">create</i></a></li>--}}
    {{--</ul>--}}
{{--</div>--}}

@include('createOil')

<div class="container" style="height: 2.7rem"></div>

<!--Import jQuery before materialize.js-->
<script src="{{ url('js/materialize.min.js') }}"></script>
<script>
    var refresh = false;

    $(document).ready(function () {
        // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
        $('.otherModal').modal();
        $('#createOil').modal({
            complete: function () {
                if(refresh) {
                    window.location = "{{ route('oil.index') }}";
                }
            }
        });
        $('.materialboxed').materialbox();
        $('.tooltipped').tooltip({delay: 50});
    });

    var warning = '<span class="red-text"><i class="material-icons">error_outline</i>請輸入正確的數量</span>';
    var loading = '<div class="progress"><div class="indeterminate"></div></div>';

    function changeCount(id, method) {
        var count = parseInt($('#count_' + id).text());
        var number = parseInt($('#number_' + id).val());

        $('#hint_' + id).html('');

        if (!checkNumber(number, count, method)) {
            $('#hint_' + id).html(warning);
            return;
        }

        var total = 0;
        if (method == 'plus') {
            total = count + number;
        } else if (method == 'cut') {
            total = count - number;
        }

        ajaxAPI(id, total);

        console.log(count);
        console.log(number);
        console.log(total);
    }

    function ajaxAPI(id, number) {
        var success = '<span class="green-text"><i class="material-icons">done</i>數量修改成功</span>';

        $('#hint_' + id).html(loading);
        $.ajax({
            url: '{{ url('oil') }}/' + id,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                count: number
            },
            success: function (res) {
                if (res.result == 'ok') {
                    $('#count_' + id).text(res.count);
                    $('#hint_' + id).html(success);
                } else {
                    $('#hint_' + id).html('<span class="red-text"><i class="material-icons">error</i>' + res.msg + '</span>');
                }
                console.log(res);
            },
            error: function (xhr) {
                $('body').html(xhr.responseText);
            }
        });
    }

    function checkNumber(number, count, method) {

        if (isNaN(number) || isNaN(count)) {
            return false;
        }

        if (method == 'cut' && count < number) {
            return false;
        }

        if (number < 1) {
            return false;
        }

        return true;
    }

</script>
</body>
</html>
