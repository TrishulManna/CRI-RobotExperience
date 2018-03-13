import React from 'react';
import ReactDOM from 'react-dom';
import { Router, Route, Link, browserHistory, hashHistory } from 'react-router'

require('bootstrap');
require('jquery');

var $ = require("jquery");

var TextItem = require('./api/components/TextItem.js').default;
var TextList = require('./api/components/TextList.js').default;
var NoMatch = require('./api/components/NoMatch.js').default;
var SelectIP = require('./api/components/SelectIP.js').default;
var Projects = require('./api/components/Projects.js').default;
var App = require('./api/components/App.js').default;
var Main = require('./api/components/Main.js').default;

var generalAPI = require('./api/robot/general').default;
var speakAPI = require('./api/robot/speak').default;
var headAPI = require('./api/robot/head').default;
var movementAPI = require('./api/robot/movement').default;
var videoAPI = require('./api/robot/video').default;
var behaviorAPI = require('./api/robot/behavior').default;

var gamepadAPI = require('./api/peripherals/gamepad').default;
var app = require('./api/robot/app').default;

window.addEventListener("gamepadconnected", gamepadAPI.connect);
window.addEventListener("gamepaddisconnected", gamepadAPI.disconnect);

ReactDOM.render((
    <Router history={hashHistory}>
        <Route path="/" component={SelectIP} />
        <Route path="projects" component={Projects} />
        <Route path="dashboard/:projectId" component={App} />
    </Router>
), document.getElementById('connection-app'));
