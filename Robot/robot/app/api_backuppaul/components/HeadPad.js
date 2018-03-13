import React from 'react';
import Draggable, {DraggableCore} from 'react-draggable';

var generalAPI = require('../robot/general').default;
var headAPI = require('../robot/head').default;
var VolumeControl = require('./VolumeControl.js').default;

class HeadPad extends React.Component {
    constructor() {
        super();
        this.state = {
            speed: 0.3,
            perc: 50
        };
    }

    eventLogger(e, data) {
        console.log('Event: ', e);
        console.log('Data: ', data);
    }

    handleDrag(e, ui) {
        // console.log('handleDrag: x=' + ui.x + " y=" + ui.y + " s=" + this.state.speed);
        headAPI.setPosition(ui.x + 10, ui.y + 10, this.state.speed);
    }

    speedDown(e) {
        var speed = this.state.speed - 0.05;
        if (speed < 0) speed = 0;
        var perc = 200.0 * speed;
        this.setState({
            speed: speed,
            perc: perc.toFixed(0)
        });
    }

    speedUp(e) {
        var speed = this.state.speed + 0.05;
        if (speed > 0.5) speed = 0.5;
        var perc = 200.0 * speed;
        this.setState({
            speed: speed,
            perc: perc.toFixed(0)
        });
    }

    render() {
        return(
            <div style={{ display: 'table', margin: '0px auto' }}>
                <div id="headBox" style={{height: '170px', width: '170px', position: 'relative'}}>
                    <Draggable
                        defaultPosition={{x: 100, y: 100}}
                        zIndex={100}
                        onStart={this.handleStart}
                        onDrag={this.handleDrag.bind(this)}
                        onStop={this.handleStop}
                        grid={[3, 3]}
                        bounds={{left: -10, top: -10, right: 185, bottom: 185}}
                    >
                        <div style={{ width: '20px' }}>
                            <i className="fa fa-eye fa-2x"></i>
                        </div>
                    </Draggable>
                </div>
                <div className="btn-group btn-group-md" role="group" aria-label="..." style={{display: 'table', margin: '0px auto' }}>
                    <button type="button" onClick={this.speedDown.bind(this)} className="btn btn-default navbar-btn"><i className="fa fa-arrow-down"></i></button>
                    <button type="button" disabled className="btn btn-default navbar-btn btn-disabled" style={{fontSize: '10px'}}>{ this.state.perc }%</button>
                    <button type="button" onClick={this.speedUp.bind(this)} className="btn btn-default navbar-btn"><i className="fa fa-arrow-up"></i></button>
                </div>
            </div>
        );
    }
};

export default HeadPad;