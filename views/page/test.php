<?php
$this->title = 'Одежда';

\app\assets\Jplayer\Asset::register($this);

?>
<div class="container">
    <div class="page-header">
        <h1>Test</h1>
    </div>

    <script>

        $(document).ready(function () {

            $("#jquery_jplayer").jPlayer({

                ready: function () {

                    $("#jquery_jplayer").change('01.mp3');

                },

                cssPrefix: "different_prefix_example"

            });

            $("#jquery_jplayer").jPlayerId("play", "player_play");

            $("#jquery_jplayer").jPlayerId("pause", "player_pause");

            $("#jquery_jplayer").jPlayerId("stop", "player_stop");

            $("#jquery_jplayer").jPlayerId("loadBar", "player_progress_load_bar");

            $("#jquery_jplayer").jPlayerId("playBar", "player_progress_play_bar");

            $("#jquery_jplayer").jPlayerId("volumeMin", "player_volume_min");

            $("#jquery_jplayer").jPlayerId("volumeMax", "player_volume_max");

            $("#jquery_jplayer").jPlayerId("volumeBar", "player_volume_bar");

            $("#jquery_jplayer").jPlayerId("volumeBarValue", "player_volume_bar_value");

            $("#jquery_jplayer").onProgressChange(function (loadPercent, playedPercentRelative, playedPercentAbsolute, playedTime, totalTime) {

                var myPlayedTime = new Date(playedTime);

                var ptMin = (myPlayedTime.getMinutes() < 10) ? "0" + myPlayedTime.getMinutes() : myPlayedTime.getMinutes();

                var ptSec = (myPlayedTime.getSeconds() < 10) ? "0" + myPlayedTime.getSeconds() : myPlayedTime.getSeconds();

                $("#play_time").text(ptMin + ":" + ptSec);

                var myTotalTime = new Date(totalTime);

                var ttMin = (myTotalTime.getMinutes() < 10) ? "0" + myTotalTime.getMinutes() : myTotalTime.getMinutes();

                var ttSec = (myTotalTime.getSeconds() < 10) ? "0" + myTotalTime.getSeconds() : myTotalTime.getSeconds();

                $("#total_time").text(ttMin + ":" + ttSec);

            });

            $("#jquery_jplayer").onSoundComplete(function () {

                $("#jquery_jplayer").play();

            });

        });

    </script>

    <div id="jquery_jplayer"></div>

    <div id="player_container">

        <ul id="player_controls">

            <li id="player_play"><a href="#" onClick="$('#jquery_jplayer').play(); return false;" title="play"><span>play</span></a>
            </li>

            <li id="player_pause"><a href="#" onClick="$('#jquery_jplayer').pause(); return false;" title="pause"><span>pause</span></a>
            </li>

            <li id="player_stop"><a href="#" onClick="$('#jquery_jplayer').stop(); return false;" title="stop"><span>stop</span></a>
            </li>

            <li id="player_volume_min"><a href="#" onClick="$('#jquery_jplayer').volume(0); return false;"
                                          title="min volume"><span>min volume</span></a></li>

            <li id="player_volume_max"><a href="#" onClick="$('#jquery_jplayer').volume(100); return false;"
                                          title="max volume"><span>max volume</span></a></li>

        </ul>

        <div id="player_progress">

            <div id="player_progress_load_bar">

                <div id="player_progress_play_bar"></div>

            </div>

        </div>

        <div id="player_volume_bar">

            <div id="player_volume_bar_value"></div>

        </div>

        <div id="player_playlist_message">

            <div id="song_title">Bubble</div>

            <div id="play_time"></div>

            <div id="total_time"></div>

        </div>

    </div>
</div>