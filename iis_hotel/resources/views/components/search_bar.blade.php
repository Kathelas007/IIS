<div class="col-md-10">
    <form action="/search" method="GET" role="search">
        <div class="input-group">
            <input type="text" class="form-control" name="query" id="query"
                   value="{{ request()->input('query') }}"
                   placeholder="Location or Hotel name">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-search"></i>
                </button>
            </span>
        </div>
    </form>
</div>
