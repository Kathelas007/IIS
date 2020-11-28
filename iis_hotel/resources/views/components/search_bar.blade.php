<div class="col-md-10 search-bar">
    <form action="/search" method="GET" role="search">
        <div class="input-group">
            <input type="text" class="form-control" name="query" id="query"
                   value="{{ request()->input('query') }}"
                   placeholder="Location or Hotel name">
            <input type="date" name="query_in" id="query_in"
                   value="{{ request()->input('query_in') }}"
                   placeholder="Check-in"
                   min="{{ date( "Y-m-d" , mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"))) }}"
                   max="{{ date( "Y-m-d" , mktime(0, 0, 0, date("m")+6  , date("d"), date("Y"))) }}"
                   onchange="check_ch_in()"
                   required="required">

            <input type="date" name="query_out" id="query_out"
                   value="{{ request()->input('query_out') }}"
                   placeholder="Check-out"
                   min="{{ date( "Y-m-d" , mktime(0, 0, 0, date("m")  , date("d")+2, date("Y"))) }}"
                   max="{{ date( "Y-m-d" , mktime(0, 0, 0, date("m")+6  , date("d")+1, date("Y"))) }}"
                   onchange="check_ch_out()"
                   required="required">

            <span class=" input-group-btn">
            <button type="submit" class="btn btn-primary">
                Search
            </button>
            </span>
        </div>
    </form>
</div>

<script type="text/javascript">
    window.onload = set_dates();

    function to_js_date(date_str, constant = 0) {
        var date_array = date_str.split("-");
        var js_date = new Date(parseInt(date_array[0]), parseInt(date_array[1]) - 1, parseInt(date_array[2]));
        js_date.setDate(js_date.getDate() + constant);
        return js_date;
    }

    function to_html_date(date = null, month_const = 0, day_const = 0) {
        if (date === null)
            date = new Date();

        var dd = String(date.getDate() + day_const).padStart(2, '0');
        var mm = String(date.getMonth() + 1 + month_const).padStart(2, '0'); //January is 0!
        var yyyy = date.getFullYear();
        var str = yyyy + "-" + mm + "-" + dd;
        return str;
    }

    function set_dates() {
        const ch_in = document.getElementById('query_in');
        const ch_out = document.getElementById('query_out');

        if (ch_in.value === "") {
            ch_in.value = to_html_date(null, 0, 1);
        }
        if (ch_out.value === "") {
            ch_out.value = to_html_date(null, 0, 2)
        }
    }

    function check_ch_in() {
        const ch_in = document.getElementById('query_in');
        const ch_out = document.getElementById('query_out');

        if (ch_out.value === "") return;

        if (to_js_date(ch_in.value) >= to_js_date(ch_out.value)) {
            ch_out.value = to_html_date(to_js_date(ch_in.value, 1));
        }
    }

    function check_ch_out() {
        const ch_in = document.getElementById('query_in');
        const ch_out = document.getElementById('query_out');

        if (ch_in.value === "") return;

        if (to_js_date(ch_in.value) >= to_js_date(ch_out.value)) {
            ch_in.value = to_html_date(to_js_date(ch_out.value, -1));
        }
    }
</script>


