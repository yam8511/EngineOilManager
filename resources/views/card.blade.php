<div class="card horizontal hoverable">
    <div class="card-image">
        <img src="{{ url(Storage::url('4R.jpg')) }}" class="responsive-img">
    </div>
    <div class="card-stacked">
        <div class="card-content">
            <p>OIL</p>
            <p>Now: </p>
            <span class="flow-text red-text">14</span>
<h4><i class="material-icons">error_outline</i>132</h4>
        </div>
        <div class="card-action">
            <div class="input-field">
                <input id="number" type="number" class="validate" min="0">
                <label for="number" data-error="Please enter integer" data-success="ok">Number</label>
                <button class="waves-effect btn btn-floating blue"><i class="material-icons">add</i></button>
                <button class="waves-effect btn btn-floating red"><i class="material-icons">remove</i></button>
            </div>
        </div>
    </div>
</div>