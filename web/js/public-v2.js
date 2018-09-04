var dataValueArr = dataValueArrKey = dataValueArrValue = [];

$(function () {
    $('.birthday-picker').datepicker({
        format: 'yyyy-mm-dd',
        endDate: '-5y',
        startView: 'decade',
        autoclose: true
    });

    var $datepicker = $('.date-container');

    loadingOn();
    $.ajax({
        url: $datepicker.data('training-days-url'),
        type: 'GET'
    }).done(function (data) {
        $datepicker.on("show", function (e) {
            if (data.length) {
                var maxDate = moment(data[data.length - 1]);
                $datepicker.datepicker('setDate', new Date(maxDate.format("YYYY"), maxDate.format("MM") - 1, maxDate.format("DD")));

                loadData(moment($datepicker.datepicker('getDate')).format("YYYY-MM-DD").toString());
            } else {
                loadingOff();
            }
        }).datepicker({
            autoclose: true,
            beforeShowDay: function (date) {
                var date1 = moment(date).format("YYYY-MM-DD").toString();
                if (data.indexOf(date1) != -1) {
                    return 'enabled';
                }
                return false;
            }
        }).on('changeDate', function (e) {
            loadData(moment($datepicker.datepicker('getDate')).format("YYYY-MM-DD").toString());
        });
    }).fail(function () {
        loadingOff();
    });

    $('.chart-option').on('change', function () {
        var sessionId = $("#session-table tr.active").attr('id');

        // console.log(sessionId);
        var elementName = $(this).attr('id');
        if (elementName.indexOf('t_') !== -1) {
            $('.pace-option').prop('checked', false);
            $(this).prop('checked', true);
        }
        var seriesToDisplay = ['currant_distance'];
        $('.chart-option').each(function (index) {
            if ($(this).is(':checked')) {
                seriesToDisplay.push($(this).data('name'));
            }
        });

        refreshChart(sessionId, seriesToDisplay);
    });

    $('select').selectize({});
});

var sessions = [];
var myChart;
/* a speed nagyságrendekkel kisebb mint a strokes, ezért felszorozzuk, az arány megmarad úgyis */
var speedMultiplier = 1;

var dataOrder = [
    "t_1000",
    "t_500",
    "t_200",
    "speed",
    "strokes",
    "pull_force",
    "currant_distance"
];

var titles = {
    "t_200": "Pace 200M",
    "t_500": "Pace 500M",
    "t_1000": "Pace 1000M",
    "pull_force": "Pull force",
    "speed": "Speed",
    "strokes": "Strokes",
    "currant_distance": "Distance",
};

var lineColors = {
    "t_200": "#ffff00",
    "t_500": "#ffff00",
    "t_1000": "#ffff00",
    "pull_force": "#0dd278",
    "speed": "#005cff",
    "strokes": "#cd2929",
    "currant_distance": "#383E42",
};

var x_axes = {
    "t_200": "bottom",
    "t_500": "bottom",
    "t_1000": "bottom",
    "pull_force": "bottom",
    "speed": "bottom",
    "strokes": "bottom",
    "currant_distance": "top",
};

var y_axes = {
    "t_200": "left",
    "t_500": "left",
    "t_1000": "left",
    "pull_force": "right",
    "speed": "right",
    "strokes": "right",
    "currant_distance": "right",
};

function loadData(selectedDate) {
    var $stable = $("#session-table");
    loadingOn();

    $.ajax({
        url: $stable.data('trainings-url'),
        data: {'selectedDate': selectedDate},
        type: 'POST'
    }).done(function (data) {
        var $tbody = $stable.find('tbody');
        $tbody.html('');
        var firstSession = false;
        for (var sessionId in data) {
            if (!firstSession) {
                firstSession = sessionId;
            }
            sessions[sessionId] = data[sessionId];
            var start = moment(parseInt(data[sessionId]['startTime']));
            var end = moment(parseInt(data[sessionId]['endTime']));
            var ms = end.diff(start);
            var d = moment.duration(ms);
            var duration = Math.floor(d.asHours()) + moment.utc(ms).format(":mm:ss");

            var $tr = $("<tr>").attr('id', sessionId);
            if (data[sessionId]['trainingEnvironmentType'] == 'outdoor') {
                $tr.append($("<td style='padding:3px;'>").html('<img src="/images/sun.png" width="50%">'));
            }
            else {
                $tr.append($("<td style='padding:3px;'>").html('<img src="/images/lightBulb.png" width="50%">'));
            }
            $tr.append($("<td>").html(moment(parseInt(sessionId)).format("HH:mm").toString()))
                .append($("<td>").html(duration));
            if (data[sessionId]['sum_distance'])
                $tr.append($("<td>").html(Math.ceil(data[sessionId]['sum_distance']) + ' m'));
            else if (data[sessionId]['currant_distance_best']) {
                $tr.append($("<td>").html(Math.ceil(data[sessionId]['currant_distance_best']) + ' m'));
            }
            $tr.appendTo($tbody);
            $tr.on("click", function () {
                selectSession($(this).attr('id'));
            });
        }

        if (firstSession) {
            selectSession(firstSession);
        }
    }).always(function () {
        loadingOff();
    });

}

function selectSession(sessionId) {
    var $stable = $("#session-table");

    $stable.find('tbody tr').removeClass('active');
    $("#" + sessionId).addClass('active');

    $('.chart-option').each(function (index) {
        $(this).prop('checked', false);
        if ($(this).data('name') == 't_1000') {
            $(this).prop('checked', true);
        }
    });

    // console.log(sessions[sessionId]);

    $("#avg-pace-1000 > span.avg-value").html(msToTime(sessions[sessionId]['t_1000_av']));
    $("#avg-pace-500 > span.avg-value").html(msToTime(sessions[sessionId]['t_500_av']));
    $("#avg-pace-200 > span.avg-value").html(msToTime(sessions[sessionId]['t_200_av']));
    $("#avg-stroke > span.avg-value").html(sessions[sessionId]['strokes_av']);
    $("#avg-speed > span.avg-value").html(sessions[sessionId]['speed_av']);
    // $("#avg-speed > span.uom").html('km/h');
    $("#avg-pull-force > span.avg-value").html(sessions[sessionId]['pull_force_av']);
    // $("#avg-pull-force > span.uom").html('N');


    $("#best-pace-1000 > span.best-value").html(msToTime(sessions[sessionId]['t_1000_best']));
    $("#best-pace-500 > span.best-value").html(msToTime(sessions[sessionId]['t_500_best']));
    $("#best-pace-200 > span.best-value").html(msToTime(sessions[sessionId]['t_200_best']));
    $("#best-stroke > span.best-value").html(sessions[sessionId]['strokes_best']);

    // ha a legjobb speed és stroke között 10-nél is nagyobb a különbség, kell a szorzó
    if (sessions[sessionId]['strokes_best'] && sessions[sessionId]['speed_best'] && sessions[sessionId]['strokes_best'] > sessions[sessionId]['speed_best'] + 10) {
        speedMultiplier = Math.floor((sessions[sessionId]['strokes_best'] / sessions[sessionId]['speed_best']) / 2);
    }
    console.log(speedMultiplier);

    $("#best-speed > span.best-value").html(sessions[sessionId]['speed_best']);
    // $("#best-speed > span.uom").html('km/h');
    $("#best-pull-force > span.best-value").html(sessions[sessionId]['pull_force_best']);
    // $("#best-pull-force > span.uom").html('N');
    refreshChart(sessionId, ['t_1000', 'currant_distance']);
}

function refreshChart(sessionId, seriesToDisplay) {
    $('.chart-option + label .value').html('');

    var chartDatasets = [];
    dataValueArr = [];
    dataValueArrKey = [];
    var jsonObj = sessions[sessionId].data;
    console.log(sessions[sessionId]);
    for (var j in jsonObj) {
        var dataType = jsonObj[j].dataType;
        var ttt = jsonObj[j].timestamp - sessions[sessionId]['startTime'];
        if (typeof dataValueArr[dataType] == "undefined") {
            dataValueArr[dataType] = [];
        }
        if (typeof dataValueArrKey[dataType] == "undefined") {
            dataValueArrKey[dataType] = [];
        }
        if (typeof dataValueArrValue[dataType] == "undefined") {
            dataValueArrValue[dataType] = [];
        }
        dataValueArrKey[dataType].push(ttt);

        if (dataType == "currant_distance") {
            dataValueArr[dataType].push([
                jsonObj[j].dataValue.toString(),
                0
            ]);
            dataValueArrValue[dataType][ttt] = (jsonObj[j].dataValue).toString();
        } else if (dataType == 'speed') {
            dataValueArr[dataType].push([
                ttt,
                (jsonObj[j].dataValue * speedMultiplier).toString()
            ]);
            dataValueArrValue[dataType][ttt] = (jsonObj[j].dataValue * speedMultiplier).toString();
        }
        else {
            dataValueArr[dataType].push([
                ttt,
                jsonObj[j].dataValue.toString()
            ]);
            dataValueArrValue[dataType][ttt] = (jsonObj[j].dataValue).toString();
        }
    }

    for (var dataType in dataValueArr) {
        // console.log(dataType, dataValueArr[dataType]);

        var ls = new EJSC.LineSeries(
            new EJSC.ArrayDataHandler(
                dataValueArr[dataType]
            ),
            {
                title: dataType,
                visible: true,
                color: lineColors[dataType],
                x_axis: x_axes[dataType],
                y_axis: y_axes[dataType],
                lineWidth: 3,
                padding: {
                    x_min: 0,
                    y_min: 1,
                    x_max: 0,
                    y_max: 10
                },
                pointBorderSize: 10
            }
        );

        chartDatasets[dataType] = ls;

        if (typeof myChart != "undefined") {
            myChart.remove();
            myChart = undefined;
        }
    }

    if (typeof myChart == "undefined") {
        myChart = new EJSC.Chart(
            'chart',
            {
                show_titlebar: false,
                allow_interactivity: true,
                allow_move: true,
                auto_zoom: 'y',
                allow_mouse_wheel_zoom: false,
                auto_find_point_by_x: true,
                show_legend: false,
                show_hints: false,
                axis_top: {
                    caption: 'Distance (m)',
                    color: '#676767',
                    crosshair: {
                        show: true,
                        color: "#FFF"
                    },
                    grid: {
                        show: false
                    },
                    visible: true
                },
                axis_bottom: {
                    caption: 'Time (HH:mm)',
                    color: '#676767',
                    crosshair: {
                        show: true,
                        color: "#FFF"
                    },
                    grid: {
                        show: true
                    },
                    visible: true
                },
                axis_left: {
                    caption: 'Pace &nbsp;&nbsp;&nbsp;<b style="background: #ffff00;">&nbsp;&nbsp;</b>',
                    color: '#676767',
                    crosshair: {
                        show: false
                    },
                    grid: {
                        show: false
                    },
                    visible: true
                },
                axis_right: {
                    caption: '<b style="background: #005cff;">&nbsp;&nbsp;</b> <b style="background: #cd2929;">&nbsp;&nbsp;</b> <b style="background: #0dd278;">&nbsp;&nbsp;</b>&nbsp;&nbsp;&nbsp; Value',
                    color: '#676767',
                    crosshair: {
                        show: false
                    },
                    grid: {
                        show: false
                    },
                    visible: true,
                    min_extreme: 0
                }
            }
        );
        myChart.axis_bottom.formatter = new EJSC.DateFormatter({
            format_string: "NN:SS"
        });
        myChart.axis_left.formatter = new EJSC.DateFormatter({
            format_string: "NN:SS"
        });

        myChart.axis_top.onShowCrosshair = function (coordinate, axis, chart) {
            $("#tooltip-currant_distance").html(Math.round(coordinate));
        };

        myChart.axis_bottom.onShowCrosshair = function (coordinate, axis, chart) {
            var goal = Math.ceil(coordinate);
            for (var i = 0; chart.getSeries().length > i; i++) {
                var ser = chart.getSeries()[i];
                var label = ser.title;
                if (label == 'currant_distance') continue;
                var closest = dataValueArrKey[label].reduce(function (prev, curr) {
                    return (Math.abs(curr - goal) < Math.abs(prev - goal) ? curr : prev);
                });
                // if (label == 'speed') {
                var sel = "#tooltip-" + label;
                if (label == 't_1000' || label == 't_500' || label == 't_200') {
                    $(sel).html(msToTime(dataValueArrValue[label][closest]));
                } else if (label == 'speed') {
                    $(sel).html(Math.round(dataValueArrValue[label][closest] / speedMultiplier * 10) / 10);
                }
                else {
                    $(sel).html(Math.round(dataValueArrValue[label][closest]));
                }
                // }
            }
            if (coordinate) {
                $("#tooltip-time").html(msToTime(coordinate));
            }
        };
    }
    for (index in seriesToDisplay) {
        myChart.addSeries(chartDatasets[seriesToDisplay[index]]);
    }
}

function msToTime(s) {
    if (typeof s == 'undefined' || !s) {
        return '-';
    }
    // Pad to 2 or 3 digits, default is 2
    function pad(n, z) {
        z = z || 2;
        return ('00' + n).slice(-z);
    }

    var ms = s % 1000;
    s = (s - ms) / 1000;
    var secs = s % 60;
    s = (s - secs) / 60;
    var mins = s % 60;
    var hrs = (s - mins) / 60;

    if (hrs > 0) {
        return pad(hrs) + ':' + pad(mins) + ':' + pad(secs);
    } else {
        return pad(mins) + ':' + pad(secs);
    }
}


function toMMSS(value) {
    var sec_num = parseInt(value, 10); // don't forget the second param
    var hours = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    // if (hours   < 10) {hours	  = "0"+hours;}
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
    if (seconds < 10) {
        seconds = "0" + seconds;
    }
    return minutes + ':' + seconds;
}

function loadingOn() {
    $("#loading-overlay").show();
}

function loadingOff() {
    $("#loading-overlay").hide();
}