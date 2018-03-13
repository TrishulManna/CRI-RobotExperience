import React from 'react';

var audioAPI = require('../peripherals/audio').default;
var ledsAPI = require('../robot/leds').default;
var faceDetectionAPI = require('../robot/face').default;

class MainButtons extends React.Component {
    constructor() {
        super();
        this.state = {
            microphoneActivated: false,
            blinkEyes: false,
            faceTracking: false
        };
    }

    triggerMicrophone(e) {
        if (this.state.microphoneActivated) {
            audioAPI.stop();
            $("body").find('#triggermic').removeClass("runningbutton");
        } else {
            $("body").find('#triggermic').addClass("runningbutton");
            audioAPI.connect();
            setTimeout(function () {
               audioAPI.play();
            }, 4000);
        }

        this.setState({
            microphoneActivated: !this.state.microphoneActivated
        });
    }

    triggerBlickEyes(e) {
        $("body").find('#triggerblink').addClass("runningbutton");
        ledsAPI.blickEyes(function() {
            this.setState({
                blinkEyes: true
            });
            $("body").find('#triggerblink').removeClass("runningbutton");
        }.bind(this));
    }

    triggerFaceTracker(e) {
        if(this.state.faceTracking) {
            faceDetectionAPI.trackFace(function() {
                $("body").find('#triggerface').removeClass("runningbutton");
                console.log('stop face tracking');
                this.setState({
                    faceTracking: false
                });
            }.bind(this), false);
        } else {
            faceDetectionAPI.trackFace(function() {
                $("body").find('#triggerface').addClass("runningbutton");
                console.log('start face tracking');
                this.setState({
                    faceTracking: true
                });
            }.bind(this), true);
        }
    }

    render() {
        return (
            <div className="row" style={{marginTop: '15px' , marginBottom: '10px'}}> 
                <div className="col-md-4">
                    <button id="triggermic" onClick={this.triggerMicrophone.bind(this)} className="btn btn-default btn-block">Microphone</button>
                </div>
                <div onClick={this.triggerBlickEyes.bind(this)} className="col-md-4">
                    <button id="triggerblink" className="btn btn-default btn-block button-no-focus">Blink eyes</button>
                </div>
                <div onClick={this.triggerFaceTracker.bind(this)} className="col-md-4">
                    <button id="triggerface" className="btn btn-default btn-block">Face tracking</button>
                </div>
            </div>
        );
    }
}

export default MainButtons;