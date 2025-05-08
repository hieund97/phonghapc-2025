<div class="card">
    <form role="form">
        <div class="card-body">
            @include('tags.elements.filter-input')
        </div>

        <div class="card-footer">
            <button type="submit" name="submit" class="btn btn-info btn-sm">
                <i class="fa fa-search"></i> {{__('Apply')}}
            </button>

            <div class="btn btn-default btn-sm pull-left" id="btn_reset">
                <a href="{{ url()->current() }} }}">
                    <i class="fa fa-undo"> {{__('Reset')}}</i>
                </a>
            </div>
        </div>
    </form>
</div>
