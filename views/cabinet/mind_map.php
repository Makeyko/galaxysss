<?php
/* @var $this \yii\web\View */

$this->title = 'Моя карта сознания';

\app\assets\goSamples::register($this);
$this->registerJsFile('/js/pages/cabinet/mind_map.js', ['depends' => 'app\assets\goSamples']);

?>
<div class="container">
    <div class="page-header">
        <h1>Моя карта сознания</h1>
    </div>

    <div class="row">
        <a href="http://www.gojs.net/latest/samples/mindMap.html" class="btn btn-default">http://www.gojs.net/latest/samples/mindMap.html</a>
    </div>

    <div id="sample">
        Additional commands are available on the context menus.
        <div id="myDiagram" style="border: solid 1px blue; width:100%; height:300px;"></div>
        <p>
            The layout is controlled by moving the nodes closest to the tree's root node.
            When one of these nodes is moved horizontally to the other side of the root,
            all of its children will be sent to <a>Layout.doLayout</a> with a new direction,
            causing text to always be moved outwards from the root.
        </p>

        <p>
            When a node is deleted the <a>CommandHandler.deletesTree</a> property ensures that
            all of its children are deleted with it. When a node is dragged the <a>DraggingTool.dragsTree</a>
            property ensures that all its children are dragged with it.
            Both of these are set during the the Diagram's initalization.
        </p>
        <button id="SaveButton" onclick="save()">Save</button>
        <button onclick="load()">Load</button>
        <button onclick="layoutAll()">Layout</button>
        Diagram Model saved in JSON format:
        <br>
        <textarea id="mySavedModel" style="width:100%;height:400px">{ "class": "go.TreeModel",
            "nodeDataArray": [
            {"key":0, "text":"Mind Map", "loc":"0 0"},
            {"key":1, "parent":0, "text":"Getting more time", "brush":"skyblue", "dir":"right", "loc":"77 -22"},
            {"key":11, "parent":1, "text":"Wake up early", "brush":"skyblue", "dir":"right", "loc":"200 -48"},
            {"key":12, "parent":1, "text":"Delegate", "brush":"skyblue", "dir":"right", "loc":"200 -22"},
            {"key":13, "parent":1, "text":"Simplify", "brush":"skyblue", "dir":"right", "loc":"200 4"},
            {"key":2, "parent":0, "text":"More effective use", "brush":"darkseagreen", "dir":"right", "loc":"77 43"},
            {"key":21, "parent":2, "text":"Planning", "brush":"darkseagreen", "dir":"right", "loc":"203 30"},
            {"key":211, "parent":21, "text":"Priorities", "brush":"darkseagreen", "dir":"right", "loc":"274 17"},
            {"key":212, "parent":21, "text":"Ways to focus", "brush":"darkseagreen", "dir":"right", "loc":"274 43"},
            {"key":22, "parent":2, "text":"Goals", "brush":"darkseagreen", "dir":"right", "loc":"203 56"},
            {"key":3, "parent":0, "text":"Time wasting", "brush":"palevioletred", "dir":"left", "loc":"-20 -31.75"},
            {"key":31, "parent":3, "text":"Too many meetings", "brush":"palevioletred", "dir":"left", "loc":"-117
            -64.25"},
            {"key":32, "parent":3, "text":"Too much time spent on details", "brush":"palevioletred", "dir":"left",
            "loc":"-117 -25.25"},
            {"key":33, "parent":3, "text":"Message fatigue", "brush":"palevioletred", "dir":"left", "loc":"-117 0.75"},
            {"key":331, "parent":31, "text":"Check messages less", "brush":"palevioletred", "dir":"left", "loc":"-251
            -77.25"},
            {"key":332, "parent":31, "text":"Message filters", "brush":"palevioletred", "dir":"left", "loc":"-251
            -51.25"},
            {"key":4, "parent":0, "text":"Key issues", "brush":"coral", "dir":"left", "loc":"-20 52.75"},
            {"key":41, "parent":4, "text":"Methods", "brush":"coral", "dir":"left", "loc":"-103 26.75"},
            {"key":42, "parent":4, "text":"Deadlines", "brush":"coral", "dir":"left", "loc":"-103 52.75"},
            {"key":43, "parent":4, "text":"Checkpoints", "brush":"coral", "dir":"left", "loc":"-103 78.75"}
            ]
            }
        </textarea>
    </div>
</div>