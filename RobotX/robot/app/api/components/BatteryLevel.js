import React from 'react';

var generalAPI = require('../robot/general').default;

class BatteryLevel extends React.Component {
    constructor() {
        super();
        this.state = {
            battery: 0,
            level: this.getLevel(0),
            charging: ''
        };
        this.getBattery();
        this.getCharging();
    }

    getLevel(battery) {
        if (battery < 5) {
            return 'fa fa-battery-0 battery-low';
        }
        if (battery < 30) {
            return 'fa fa-battery-1';
        }
        if (battery < 60) {
            return 'fa fa-battery-2';
        }
        if (battery < 90) {
            return 'fa fa-battery-3';
        }
        return 'fa fa-battery-4 battery-ok';
    }


    getBattery() {
        generalAPI.getBattery(function(battery) {
            this.setState({
                battery: battery,
                level: this.getLevel(battery)
            });
        }.bind(this));
    }

    getCharging() {
        generalAPI.getBatteryCharging(function(charging) {
            this.setState({
                charging: ((charging)?'fa fa-bolt':'')
            });
        }.bind(this));
    }

    render () {
        return (
            <p className="navbar-text" style={{ color: 'black' }}><i className={ this.state.level } ></i> { this.state.battery }% <i className={ this.state.charging } ></i></p>
        );
    }
}

export default BatteryLevel;