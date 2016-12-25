<li class="collection-item hoverable row" id="{{ $oil['id'] }}">
    <div class="col m2 l1 hide-on-small-only">
        <img src="{{ $oil['photo'] }}" alt="{{ $oil['name'] }}"
             class="responsive-img materialboxed">
    </div>
    <div class="col m2">
        <h5 class="title">{{ $oil['name'] }}</h5>
        <p>目前數量:&nbsp;&nbsp; <span id="count_{{ $oil['id'] }}" class="red-text flow-text">{{ $oil['count'] }}</span></p>
    </div>
    <div class="col m3 l2">
        <div class="input-field inline">
            <input id="number_{{ $oil['id'] }}" type="number" class="validate" min="1">
            <label for="number">修改數量</label>
            <div id="hint_{{ $oil['id'] }}"></div>
        </div>
    </div>
    <div class="col m3">
        <div class="input-field">
            <button class="waves-effect btn btn-floating blue tooltipped" data-position="left" data-delay="50" data-tooltip="增加" onclick="changeCount({{ $oil['id'] }}, 'plus')"><i class="material-icons">add</i></button>
            <button class="waves-effect btn btn-floating orange tooltipped" data-position="buttom" data-delay="50" data-tooltip="減少" onclick="changeCount({{ $oil['id'] }}, 'cut')"><i class="material-icons">remove</i></button>
            <button class="waves-effect btn btn-floating red" title="刪除" data-target="destroyModal_{{ $oil['id'] }}"><i class="material-icons">delete</i></button>
        </div>
    </div>
</li>

{{--刪除小視窗--}}
<div id="destroyModal_{{ $oil['id'] }}" class="otherModal modal bottom-sheet">
    <div class="modal-content red lighten-1 white-text">
        <h4>確定刪除 {{ $oil['name'] }} ?</h4>
        <p>刪除後無法復原</p>
    </div>
    <div class="modal-footer">
        <a href="#" class=" modal-action modal-close waves-effect waves-green btn-flat teal-text" style="border: 1px solid teal;">取消</a>

        <form id="destroyForm_{{ $oil['id'] }}" action="{{ route('oil.destroy', ['oil' => $oil['id']]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class=" modal-action modal-close waves-effect waves-green btn-flat red white-text">刪除</button>
        </form>
    </div>
</div>