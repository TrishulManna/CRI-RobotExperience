import React from 'react';

var generalAPI = require('../robot/general').default;

class VolumeControl extends React.Component {
    constructor() {
        super();
        this.state = {
            volume: 0
        };
        this.getVolume();
    }

    getVolume() {
        generalAPI.getVolume(function(volume) {
            this.setState({
                volume: volume
            });
        }.bind(this));

    }

    volumeDown(e) {
        generalAPI.volumeDown(function(volume) {
            this.setState({
                volume: volume
            });
        }.bind(this));
    }

    volumeUp(e) {
        generalAPI.volumeUp(function(volume) {
            this.setState({
                volume: volume
            });
        }.bind(this));
    }

    render () {
        return (
            <div className="btn-group btn-group-md" role="group" aria-label="...">
                <button type="button" onClick={this.volumeDown.bind(this)} className="btn btn-default navbar-btn"><i className="fa fa-volume-down"></i></button>
                <button type="button" disabled className="btn btn-default navbar-btn btn-disabled" style={{fontSize: '10px'}}>{ this.state.volume }%</button>
                <button type="button" onClick={this.volumeUp.bind(this)} className="btn btn-default navbar-btn"><i className="fa fa-volume-up"></i></button>
            </div>
        );
    }
}

export default VolumeControl;