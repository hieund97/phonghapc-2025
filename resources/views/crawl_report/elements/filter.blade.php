<div class="card">
    <form role="form">
        <input type="hidden" name="from_admin" value="1">
        <input type="hidden" name="view_hidden" value="{{ request('view_hidden', false) }}">
        <div class="card-body">
            @include('crawl_report.elements.filter-input')
        </div>

        <div class="card-footer">
            <button type="submit" name="submit" class="btn btn-info btn-sm">
                <i class="fa fa-search"></i> {{__('Apply')}}
            </button>

            <div class="btn btn-default btn-sm pull-left" id="btn_reset">
                <a href="{{ url()->current() }}?view_hidden={{ request('view_hidden', false) }}">
                    <i class="fa fa-undo"> {{__('Reset')}}</i>
                </a>
            </div>
        </div>
    </form>
</div>
