$(document).ready(function(){
    init_tags('profile_tags', available_tags);

    $('[name="disabled_channel"]').on('change', function (e) {
        var inputs = $(this).parents('table').find('input, textarea').not('#disabled_channel');
        inputs.each( (i,e)=> $(e).prop('disabled', ($(this).val() === 'yes')))
    });

    if( visual_editor_comments_enabled ){
        Array.from(document.querySelectorAll('#comments .itemdiv .body .col-md-7 span')).forEach((comment,index) => {
            new toastui.Editor.factory({
                el: comment,
                viewer: true,
                usageStatistics: false,
                initialValue: comment.innerHTML
            });
        });
    }

    AmCharts.makeChart("history", {
        "type": "serial",
        "dataDateFormat": "",
        "startDuration": 1,
        "mouseWheelZoomEnabled": true,
        "autoDisplay": true,
        "theme": "light",
        "pathToImages": "https://www.amcharts.com/lib/3/images/",
        "categoryField": "date_histo",
        "categoryAxis": {
            "gridPosition": "start",
            "parseDates": true,
        },
        "trendLines": [],
        "graphs": [
            {
                "id": "AmGraph-1",
                "title": "graph 1",
                "type": "line",
                "valueField": "storage_used",
                "bullet": "round",
                "bulletBorderAlpha": 1,
                "bulletColor": "#FFFFFF",
                "bulletSize": 5,
                "lineThickness": 2,
                "lineColor": "#20acd4",
                "useLineColorForBulletBorder": true,
                "balloonText": "<b style='font-size: 130%'>[[value]]</b>",
                "balloonFunction": function (item, graph) {
                    var text = graph.balloonText;
                    var value = get_readable_filesize(item.dataContext['storage_used']);
                    return text.replace("[[value]]", value);
                }
            }
        ],
        "guides": [],
        "valueAxes": [
            {
                "id": "ValueAxis-1",
                "title": lang_storage_use,
                "labelFunction": function(value) {
                    return get_readable_filesize(value);
                }
            }
        ],
        "allLabels": [],
        "balloon": {},
        "titles": [
            {
                "bold": false,
                "id": "Title-1",
                "size": 15,
                "text": lang_storage_history
            }
        ],
        "dataProvider": storage_history
    });
});