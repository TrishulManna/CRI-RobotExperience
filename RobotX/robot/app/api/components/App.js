import React from 'react';
import { hashHistory } from 'react-router'

var TextList = require('./TextList.js').default;
var BehaviorList = require('./BehaviorList.js').default;
var VolumeControl = require('./VolumeControl.js').default;
var SpeechSpeedControl = require('./SpeechSpeedControl.js').default;
var LanguageControl = require('./LanguageControl.js').default;
var BatteryLevel = require('./BatteryLevel.js').default;

var MovePad = require('./MovePad.js').default;
var HeadPad = require('./HeadPad.js').default;

var StopButton = require('./StopButton').default;
var Speech = require('./Speech').default;
var Video = require('./Video').default;
var MainButtons = require('./MainButtons.js').default;
var app = require('../robot/app.js').default;

class App extends React.Component {
    constructor() {
        super();
        this.state = {
            projectId: false,
            loading: true
        };
    }

    componentDidMount() {
        this.setState({
            projectId: this.props.params.projectId
        });
        app.projectId = this.props.params.projectId;
        app.connect(function(err) {
            if (!!err)
            {
                sessionStorage.setItem('connect-error', err);
                hashHistory.push('/?error=true');
            }
            else
            {
                this.setState({
                    loading: false,
                    projectname: sessionStorage.getItem('project_name')
                });
            }
        }.bind(this));
    }

    render () {
        if (this.state.loading) {
            return (
                <div>
                    <i className="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                </div>
            );
        } else {
            return (
                <div>
                    <nav className="navbar navbar-inverse navbar-fixed-top header-border">
                        <div className="container-fluid header-body">
                            <div className="navbar-header">
                                <button type="button" className="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                    <span className="sr-only">Toggle navigation</span>
                                    <span className="icon-bar"></span>
                                    <span className="icon-bar"></span>
                                    <span className="icon-bar"></span>
                                </button>
                                <a className="navbar-brand" href="/robot"><img src="/robot/public/images/Robotrentals-rent-a-robot-top.png" style={{height: '25px', marginTop: '-5px'  }} /></a>
                                <span className="navbar-brand" style={{ paddingLeft: '50px' }}><a style={{ color: 'black' }} href={ '/roboback/public/projects/' + this.state.projectId + '/edit' }>Dashboard: {this.state.projectname}</a></span>
                            </div>
                            <div id="navbar" className="navbar-collapse collapse pull-right">
                                <SpeechSpeedControl />
                                <VolumeControl />
                                <StopButton />
                                <LanguageControl />
                                <BatteryLevel />
                            </div>

                        </div>
                    </nav>

                    <div className="container-fluid">
                        <div className="row top-row">
                            <div className="col-md-3">
                                <BehaviorList projectId={this.props.params.projectId}/>
                            </div>
                            <div className="col-md-6">
                       
                                   <div className="row">
                                    <div className="col-md-6">
                                        <MovePad />
                                    </div>
                                    <div className="col-md-6">
                                        <HeadPad />
                                    </div>
                                    <Speech projectId={this.props.params.projectId}/>
                                    <MainButtons />
                                    <Video />

                                </div>
                            </div>
                            <div className="col-md-3">
                                <TextList projectId={this.props.params.projectId}/>
                            </div>
                        </div>
                    </div>
                </div>
            );
        }
    }
}

export default App;