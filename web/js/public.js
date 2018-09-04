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


    $('select').selectize({});

});

if (document.getElementById("chart")) {
    var ctx = document.getElementById("chart").getContext("2d");
}
var sessions = [];
var myChart;

var dataOrder = [
    "t_1000",
    "t_500",
    "t_200",
    "speed",
    "strokes",
    "pull_force",
    "currant_distance"
];

var lineColors = {
    "t_200": "#ffff00",
    "t_500": "#ffff00",
    "t_1000": "#ffff00",
    "pull_force": "#0dd278",
    "speed": "#005cff",
    "strokes": "#cd2929",
    "currant_distance": "#008375",
};

var axes = {
    "t_200": "y-axis-0",
    "t_500": "y-axis-0",
    "t_1000": "y-axis-0",
    "pull_force": "y-axis-1",
    "speed": "y-axis-1",
    "strokes": "y-axis-1",
    "currant_distance": "y-axis-1",
};

var dataTypes = {
    "t_200": "PACE 200M",
    "t_500": "PACE 500M",
    "t_1000": "PACE 1000M",
    "pull_force": "PULL FORCE",
    "speed": "SPEED",
    "strokes": "STROKE",
    "currant_distance": "CURRANT DISTANCE",
};

function loadData(selectedDate) {

    var $stable = $("#session-table");
    loadingOn();

    $.ajax({
        url: $stable.data('trainings-url'),
        data: {'selectedDate': selectedDate},
        type: 'POST'
    }).done(function (data) {
        // console.log(data);
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

            var $tr = $("<tr>").attr('id', sessionId)
                .append($("<td>").html(moment(parseInt(sessionId)).format("HH:mm").toString()))
                .append($("<td>").html(duration))
                .append($("<td>").html(Math.ceil(data[sessionId]['sum_distance']) + ' m')).appendTo($tbody);
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

    // console.log(sessions[sessionId]);

    $("#avg-pace-1000 > span.avg-value").html(msToTime(sessions[sessionId]['t_1000_av']));
    $("#avg-pace-500 > span.avg-value").html(msToTime(sessions[sessionId]['t_500_av']));
    $("#avg-pace-200 > span.avg-value").html(msToTime(sessions[sessionId]['t_200_av']));
    $("#avg-stroke > span.avg-value").html(sessions[sessionId]['strokes_av']);
    $("#avg-speed > span.avg-value").html(sessions[sessionId]['speed_av']);
    $("#avg-speed > span.uom").html('km/h');
    $("#avg-pull-force > span.avg-value").html(sessions[sessionId]['pull_force_av']);
    $("#avg-pull-force > span.uom").html('N');


    $("#best-pace-1000 > span.best-value").html(msToTime(sessions[sessionId]['t_1000_best']));
    $("#best-pace-500 > span.best-value").html(msToTime(sessions[sessionId]['t_500_best']));
    $("#best-pace-200 > span.best-value").html(msToTime(sessions[sessionId]['t_200_best']));
    $("#best-stroke > span.best-value").html(sessions[sessionId]['strokes_best']);
    $("#best-speed > span.best-value").html(sessions[sessionId]['speed_best']);
    $("#best-speed > span.uom").html('km/h');
    $("#best-pull-force > span.best-value").html(sessions[sessionId]['pull_force_best']);
    $("#best-pull-force > span.uom").html('N');
    refreshChart(sessionId);
}


function refreshChart(sessionId) {
    var chartDatasets = [],
        dataValueArr = [];

    var jsonObj = sessions[sessionId].data;
    for (var j in jsonObj) {
        var dataType = jsonObj[j].dataType;

        if (dataType != "currant_distance") {
            if (typeof dataValueArr[dataType] == "undefined") {
                dataValueArr[dataType] = [];
            }
            dataValueArr[dataType].push({
                x: jsonObj[j].timestamp - sessions[sessionId]['startTime'],
                y: jsonObj[j].dataValue.toString()
            });
        }
    }

    for (var dataType in dataValueArr) {
        chartDatasets.push({
            label: dataType,
            fill: false,
            lineTension: 0.1,
            borderColor: lineColors[dataType],
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: lineColors[dataType],
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: lineColors[dataType],
            pointHoverBorderWidth: 4,
            pointRadius: 0,
            pointHitRadius: 10,
            yAxisID: axes[dataType],
            data: dataValueArr[dataType],
            hidden: false,
        });
    }

    if (typeof myChart == "undefined") {
        myChart = new Chart(ctx, {
            type: "line",
            options: {
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false,
                legendCallback: function (chart) {
                    var legendHtml = [],
                        inputType, inputStatus, inputName;
                    legendHtml.push('<div class="row">');
                    for (var i = 0; i < chart.data.datasets.length; i++) {
                        if (chart.data.datasets[i].label) {
                            inputType = chart.data.datasets[i].label.match(/t_/) ? 'radio' : 'checkbox';
                            inputName = chart.data.datasets[i].label.match(/t_/) ? 'radio-option' : 'checkbox-option[]';
                            inputStatus = chart.data.datasets[i].label.match(/t_1000/) ? 'checked="checked"' : '';
                            legendHtml[dataOrder.indexOf(chart.data.datasets[i].label) + 1] = '<div class="col-xs-2"><input type="' + inputType + '" class="' + inputType + '-option chart-option" id="' + inputType + chart.legend.legendItems[i].datasetIndex + '" name="' + inputName + '" value="' + chart.legend.legendItems[i].datasetIndex + '" ' + inputStatus + ' onclick="updateDataset(event, ' + '\'' + chart.legend.legendItems[i].datasetIndex + '\'' + ')"><label for="' + inputType + chart.legend.legendItems[i].datasetIndex + '" style="border-color:' + lineColors[chart.data.datasets[i].label] + '"><span class="label">' + dataTypes[chart.data.datasets[i].label] + '</span><span class="value" id="tooltip-' + chart.data.datasets[i].label + '"></span></label></div>';
                            if (!inputStatus) {
                                var meta = chart.getDatasetMeta(i);
                                meta.hidden = true;
                            }
                        }
                    }
                    legendHtml.push('</div>');
                    return legendHtml.join("");
                },
                scales: {
                    xAxes: [{
                        id: "x-axis-0",
                        type: 'time',
                        position: 'bottom',
                        time: {
                            displayFormats: {
                                'millisecond': 'mm:ss',
                                'second': 'mm:ss',
                                'minute': 'mm:ss',
                                'hour': 'hh:mm:ss',
                                'day': 'mm:ss',
                                'week': 'mm:ss',
                                'month': 'mm:ss',
                                'quarter': 'mm:ss',
                                'year': 'mm:ss'
                            },
                            unit: 'second',
                            unitStepSize: 10,
                        },
                        ticks: {
                            beginAtZero: 0,
                            maxTicksLimit: 20,
                            fontColor: '#ffffff'
                        },
                        gridLines: {
                            color: '#494949',
                            zeroLineColor: '#ffffff'
                        }
                    }],
                    yAxes: [{
                        position: "left",
                        id: "y-axis-0",
                        beginAtZero: true,
                        ticks: {
                            callback: function (value, index, labels) {
                                if (value) {
                                    return msToTime(value);
                                }
                            },
                            fontColor: '#ffffff'
                        },
                        gridLines: {
                            color: '#494949',
                            zeroLineColor: '#ffffff'
                        }
                    }, {
                        position: "right",
                        id: "y-axis-1",
                        gridLines: {
                            color: '#494949',
                            zeroLineColor: '#ffffff'
                        },
                        ticks: {
                            fontColor: '#ffffff'
                        }
                    }]
                },
                tooltips: {
                    enabled: true,
                    mode: 'index',
                    intersect: false,
                    custom: function(tooltip) {
                        tooltip.opacity = 0;
                    },
                    callbacks: {
                        label: function (tooltipItem, data) {
                            // console.log(data)
                            var label = data.datasets[tooltipItem.datasetIndex].label;
                            var sel = "#tooltip-" + data.datasets[tooltipItem.datasetIndex].label;
                            var val = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].y;
                            if (label == 't_1000' || label == 't_500' || label == 't_200') {
                                $(sel).html(msToTime(val));
                            } else {
                                $(sel).html(Math.round(val));
                            }
                        }
                    }
                },
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        bottom: 40,
                        top: 30
                    }
                }
            }
        });
    }

    myChart.data.datasets = chartDatasets;
    myChart.update();

    // var canvas = document.getElementById("mouse");
    // var context = canvas.getContext("2d");
    // context.setLineDash([3, 5]);
    //
    // canvas.addEventListener("mousemove", function(event) {
    //     var x = event.pageX - canvas.offsetLeft;
    //     var y = event.pageY - canvas.offsetTop;
    //     context.clearRect(0, 0, canvas.width, canvas.height);
    //     context.beginPath();
    //     context.moveTo(0,y);
    //     context.lineTo(595,y);
    //     context.moveTo(x,0);
    //     context.lineTo(x,595);
    //     context.strokeStyle = "black";
    //     context.stroke();
    //     context.closePath();
    //
    //     myChart.eventHandler(event);
    // });

    updateDataset = function (e, datasetIndex) {
        var index = datasetIndex;
        var ci = e.view.myChart;
        $(".chart-option").each(function () {
            if ($(this).is(":checked")) {
                ci.getDatasetMeta($(this).val()).hidden = false;
            } else {
                ci.getDatasetMeta($(this).val()).hidden = true;
                $("#tooltip-" + ci.data.datasets[$(this).val()].label).html('');
            }
        });
        ci.update();
    };


    $("#chart-legend").html(myChart.generateLegend());
}


function msToTime(s) {
    var ms = s % 1000;
    s = (s - ms) / 1000;
    var secs = s % 60;
    s = (s - secs) / 60;
    var mins = s % 60;
    mins = (mins < 10) ? '0' + mins : mins;
    secs = (secs < 10) ? '0' + secs : secs;
    return mins + ':' + secs;
}

function toMMSS(value) {
    var sec_num = parseInt(value, 10); // don't forget the second param
    var hours = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    // if (hours   < 10) {hours   = "0"+hours;}
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