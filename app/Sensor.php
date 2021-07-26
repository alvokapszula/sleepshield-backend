<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Sensor extends Model
{

    protected $guarded = ['id'];

    public function shield()
    {
        return $this->belongsTo(Shield::class);
    }

    public function img()
    {
        return "img/sensors/".$this->uid.".png";
    }

    public function out_of_range()
    {
        $last = $this->last_measure_value();
        if ($this->normlow > $last || $this->normhigh < $last) {
            return true;
        }
        return false;
    }

    public function last_measure_time()
    {
        $temp = $this->last_measure();
        return Carbon::createFromTimestamp($temp['time'])->setTimeZone(config('app.timezone'))->toDateTimeString();
    }

    public function last_measure_value()
    {
        $temp = $this->last_measure();
        return $temp["value"];
    }

    public function exam_last_measure_time(Exam $exam)
    {
        $temp = $this->exam_last_measure($exam);
        return Carbon::createFromTimestamp($temp['time'])->setTimeZone(config('app.timezone'))->toDateTimeString();
    }

    public function exam_last_measure_value(Exam $exam)
    {
        $temp = $this->exam_last_measure($exam);
        return $temp["value"];
    }

    public function last_measure()
    {
        $q = 'SELECT last(value) as value FROM '.config('laravelinfluxapi.serie').' WHERE sensor = \''.$this->uid.'\' AND shield = \''.$this->shield->uid.'\'';
        $temp = \InfluxApi::query($q, ['epoch' => 's'])->getPoints();
        try {
            $json = json_encode($temp);
            $ret = substr($json, 1, strlen($json)-2);
            return json_decode($ret, true);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function exam_last_measure(Exam $exam)
    {

        $end = isset($exam->end) ? Carbon::createFromTimestamp($exam->end)->setTimeZone('UTC')->toDateTimeString() : now();
        $q = 'SELECT last(value) as value FROM '.config('laravelinfluxapi.serie').' WHERE sensor = \''.$this->uid.'\' AND shield = \''.$this->shield->uid.'\' AND time < \''.$end.'\'';
        try {
            $temp = \InfluxApi::query($q, ['epoch' => 's'])->getPoints();
            $json = json_encode($temp);
            $ret = substr($json, 1, strlen($json)-2);
            return json_decode($ret, true);
        } catch (\Exception $e) {
            return null;
        }

    }

    public function last_1_hour()
    {
        // TODO put epoch parameter into InfluxApi class and config

        $q = 'SELECT value FROM '.config('laravelinfluxapi.serie').' WHERE sensor = \''.$this->uid.'\' AND shield = \''.$this->shield->uid.'\' AND time > now() - 1h';
        try {
            $temp = \InfluxApi::query($q, ['epoch' => 's'])->getPoints();
        } catch (\Exception $e) {
            $temp = null;
        }
        return $temp;
    }

    public function fulldata(Exam $exam)
    {
        // TODO put epoch parameter into InfluxApi class and config
        $begin = isset($exam->begin) ? $exam->begin->setTimeZone('UTC')->toDateTimeString() : now();
        $end = isset($exam->end) ? $exam->end->setTimeZone('UTC')->toDateTimeString() : now();

        $q = 'SELECT value FROM '.config('laravelinfluxapi.serie').' WHERE sensor = \''.$this->uid.'\' AND shield = \''.$this->shield->uid.'\' AND time > \''.$begin.'\' AND time < \''.$end.'\'';
        try {
            $temp = \InfluxApi::query($q, ['epoch' => 's'])->getPoints();
        } catch (\Exception $e) {
            $temp = null;
        }
        return $temp;
    }

    public function livechart()
    {
        $render = "var myChart = echarts.init(document.getElementById('chartdiv'));
        var option = {};
        $.get('/sensors/".$this->id."/data', function (data) {
            option = {
                tooltip: {
                    trigger: 'axis'
                },
                xAxis: {
                    data: data.map(function (item) {
                        return item[0];
                    })
                },
                yAxis: {
                    splitLine: {
                        show: false
                    }
                },
                dataZoom: [{
                    type: 'inside'
                }],
                visualMap: {
                    show: false,
                    pieces: [{
                        lt: ".$this->normlow.",
                        color: '#ff9933'
                    }, {
                        gt: ".$this->normlow.",
                        lte: ".$this->normhigh.",
                        color: '#096'
                    }, {
                        gt: ".$this->normhigh.",
                        color: '#ff9933'
                    }],
                    outOfRange: {
                        color: '#999'
                    }
                },
                series: {
                    name: '".$this->name."',
                    type: 'line',
                    data: data.map(function (item) {
                        return item[1];
                    }),
                    markLine: {
                        silent: true,
                        symbol: ['none','none'],
                        data: [{
                            yAxis: ".$this->normlow."
                        }, {
                            yAxis: ".$this->normhigh."
                        }]
                    }
                }
            };
        }).done(function(){
            myChart.setOption(option);

            // Create a client instance
            client = new Paho.MQTT.Client('".config('mqtt.host')."', ".config('mqtt.port').", '".config('mqtt.clientid')."');

            // set callback handlers
            client.onConnectionLost = onConnectionLost;
            client.onMessageArrived = onMessageArrived;

            // connect the client
            client.connect({
                userName: \"".config('mqtt.user')."\",
                password: \"".config('mqtt.password')."\",
                useSSL: true,
                onSuccess:onConnect
            });


            // called when the client connects
            function onConnect() {
                // client.subscribe(\"".config('mqtt.basetopic')."#\");
                // console.log(\"".config('mqtt.basetopic').$this->shield->uid ."/". $this->uid ."\");
                client.subscribe(\"".config('mqtt.basetopic').$this->shield->uid ."/". $this->uid ."\");
            }

            // called when the client loses its connection
            function onConnectionLost(responseObject) {
              if (responseObject.errorCode !== 0) {
                console.log(\"onConnectionLost:\"+responseObject.errorMessage);
              }
            }

            // called when a message arrives
            function onMessageArrived(message) {

              // console.log(\"onMessageArrived:\"+message.payloadString);
              // obj = JSON.parse(message.payloadString);
              date = moment().format(\"YYYY-MM-DD HH:mm:ss\");

              option.xAxis.data.push(date);
              option.series.data.push(message.payloadString);
              myChart.setOption(option);

            }
        });

        $(window).on('resize', function(){
            if(myChart != null && myChart != undefined){
                myChart.resize();
            }
        });";

        return $render;
    }

    public function fullchart(Exam $exam, $time = null)
    {

        if (isset($time)) {
            // $time = Carbon::createFromTimestamp($time);
            $percent = $exam->getPercentFromTime($time);
        } else {
            $percent = 95;
        }

        $render = "var myChart = echarts.init(document.getElementById('chartdiv'));
        var option = {};

        $.get('/exams/".$exam->id."/sensors/".$this->id."/data', function (data) {
            myChart.setOption(option = {
                tooltip: {
                    trigger: 'axis'
                },
                xAxis: {
                    data: data.map(function (item) {
                        return item[0];
                    })
                },
                yAxis: {
                    splitLine: {
                        show: false
                    }
                },
                toolbox: {
                    left: 'center',
                    feature: {
                        dataZoom: {
                            yAxisIndex: 'none'
                        },
                        restore: {},
                        saveAsImage: {}
                    }
                },
                dataZoom: [{
                    start: ".($percent-5).",
                    end: ".($percent+5)."
                }, {
                    type: 'inside'
                }],
                visualMap: {
                    show: false,
                    pieces: [{
                        lt: ".$this->normlow.",
                        color: '#ff9933'
                    }, {
                        gt: ".$this->normlow.",
                        lte: ".$this->normhigh.",
                        color: '#096'
                    }, {
                        gt: ".$this->normhigh.",
                        color: '#ff9933'
                    }],
                    outOfRange: {
                        color: '#999'
                    }
                },
                series: {
                    name: '".$this->name."',
                    type: 'line',
                    data: data.map(function (item) {
                        return item[1];
                    }),
                    markLine: {
                        silent: true,
                        data: [{
                            yAxis: ".$this->normlow."
                        }, {
                            yAxis: ".$this->normhigh."
                        }]
                    }
                }
            });
        })";

        if ($exam->is_running){
            $render .=".done(function(){
                myChart.setOption(option);

                // Create a client instance
                client = new Paho.MQTT.Client('".config('mqtt.host')."', ".config('mqtt.port').", '".config('mqtt.clientid')."');

                // set callback handlers
                client.onConnectionLost = onConnectionLost;
                client.onMessageArrived = onMessageArrived;

                // connect the client
                client.connect({
                    userName: \"".config('mqtt.user')."\",
                    password: \"".config('mqtt.password')."\",
                    useSSL: true,
                    onSuccess:onConnect
                });


                // called when the client connects
                function onConnect() {
                    // client.subscribe(\"".config('mqtt.basetopic')."#\");
                    // console.log(\"".config('mqtt.basetopic').$this->shield->uid ."/". $this->uid ."\");
                    client.subscribe(\"".config('mqtt.basetopic').$this->shield->uid ."/". $this->uid ."\");
                }

                // called when the client loses its connection
                function onConnectionLost(responseObject) {
                  if (responseObject.errorCode !== 0) {
                    console.log(\"onConnectionLost:\"+responseObject.errorMessage);
                  }
                }

                // called when a message arrives
                function onMessageArrived(message) {

                  // console.log(\"onMessageArrived:\"+message.payloadString);
                  // obj = JSON.parse(message.payloadString);
                  date = moment().format(\"YYYY-MM-DD HH:mm:ss\");

                  option.xAxis.data.push(date);
                  option.series.data.push(message.payloadString);
                  myChart.setOption(option);

                }
            });
            ";
        }

        $render .= "$(window).on('resize', function(){
            if(myChart != null && myChart != undefined){
                myChart.resize();
            }
        });";

        return $render;
    }
}
