import React from 'react';

var speakAPI = require('../robot/speak').default;

console.log(speakAPI);

class SpeechSpeedControl extends React.Component {
    constructor() {
        super();
        this.state = {
            speed: 0
        };
        this.getSpeed();
    }

    getSpeed() {
        speakAPI.getSpeed(function(speed) {
            console.log("getSpeed " + speed);
            this.setState({
                speed: Math.round((speed/100.0)*100.0)
            });
        }.bind(this));

    }

    speedDown(e) {
        speakAPI.speedDown(function(speed) {
            console.log("speedDown " + speed);
            this.setState({
                speed: Math.round((speed/100.0)*100.0)
            });
        }.bind(this));
    }

    speedUp(e) {
        speakAPI.speedUp(function(speed) {
            console.log("speedUp " + speed);
            this.setState({
                speed: Math.round((speed/100.0)*100.0)
            });
        }.bind(this));
    }

    render () {
        return (
            <div style={{marginRight: '20px'}} className="btn-group btn-group-md" role="group" aria-label="...">
                <button type="button" onClick={this.speedDown.bind(this)} className="btn btn-default navbar-btn"><i className="fa fa-arrow-down"></i></button>
                <button type="button" disabled className="btn btn-default navbar-btn btn-disabled" style={{fontSize: '10px'}}>{ this.state.speed }%</button>
                <button type="button" onClick={this.speedUp.bind(this)} className="btn btn-default navbar-btn"><i className="fa fa-arrow-up"></i></button>
            </div>
        );
    }
}

export default SpeechSpeedControl;