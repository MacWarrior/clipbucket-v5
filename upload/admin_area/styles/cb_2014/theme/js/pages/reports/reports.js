$(function () {
    var options = {
        series: {
            bars: {
                show: true,
                steps: true,
                barWidth: 0.6,
                align: "center"
            },
            points: {show: true},
            lines: {show: true}
        },
        xaxis: {
            mode: "categories",
            tickLength: 0
        },
        grid: {hoverable: true, clickable: true}

    };

    var iteration = 0;

    function fetchData() {
        // Daily Data //
        function onDataReceveDaily(series_daily) {

            data = series_daily;
            $.plot("#daily_chart_id", data, options);
            tooltip("#daily_chart_id", "#enableTooltipDaily");
        }

        $.ajax({
            url: "charts/reports/daily_activity_reports.php",
            type: "POST",
            data: "videos=videos",
            dataType: "json",
            success: onDataReceveDaily,
            error: function () {
            },
            complete: function () {
                $('#daily_chart_id .loading-image').hide();
            }
        });
        // !Daily Data //

        // Week Data //
        function onDataReceivedWeekly(series_weekly) {

            data = series_weekly;

            $.plot("#weekly_chart_id", data, options);
            tooltip("#weekly_chart_id", "#enableTooltipWeekly");
        }

        $.ajax({
            url: "charts/reports/weekly_activity_reports.php",
            type: "POST",
            data: "videos=videos",
            dataType: "json",
            success: onDataReceivedWeekly,
            error: function () {
            },
            complete: function () {
                $('#weekly_chart_id .loading-image').hide();
            }
        });
        // !Week Data //

        // Monthly Data //
        function onDataReceveMonthly(series_monthly) {

            data = series_monthly;
            $.plot("#monthly_chart_id", data, options);
            tooltip("#monthly_chart_id", "#enableTooltipMonthly");
        }

        $.ajax({
            url: "charts/reports/monthly_activity_reports.php",
            type: "POST",
            data: "videos=videos",
            dataType: "json",
            success: onDataReceveMonthly,
            error: function () {
            },
            complete: function () {
                $('#monthly_chart_id .loading-image').hide();
            }
        });
        // !Monthly Data //
    }

    fetchData();

    function showTooltip(x, y, contents) {
        $('<div id="tooltip">' + contents + '</div>').css({
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fee',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    }

    var previousPoint = null;

    function tooltip(chart_id, tooltip_id) {

        $(chart_id).bind("plothover", function (event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));

            if ($(tooltip_id).is(':checked')) {
                if (item) {
                    if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $("#tooltip").remove();
                        var x = item.datapoint[0].toFixed(2),
                            y = item.datapoint[1].toFixed(2);

                        showTooltip(item.pageX, item.pageY,
                            item.series.label + " = " + y);
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            }
        });
    }
});