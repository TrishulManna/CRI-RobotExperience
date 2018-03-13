import React from 'react';

var generalAPI = require('../robot/general').default;
var speakAPI   = require('../robot/speak').default;
var audioAPI   = require('../peripherals/audio').default;

class StopButton extends React.Component {
    constructor() {
        super();
    }

    stop(e) {
        generalAPI.stop();
        speakAPI.stop();
    }

    render() {
        return (
            <div className="btn-group btn-group-md" style={{paddingTop: '0px', 'marginLeft': '20px'}}>
                <button onClick={this.stop.bind(this)} className="btn btn-danger navbar-btn btn-md"><i className="fa fa-hand-stop-o"></i> Stop</button>
            </div>
        );
    }
}

export default StopButton;