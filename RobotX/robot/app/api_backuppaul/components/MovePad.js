import React from 'react';

var generalAPI = require('../robot/general').default;
var movementAPI = require('../robot/movement').default;
var videoAPI = require('../robot/video').default;

class MovePad extends React.Component {
    move(whereTo, e) {
        $("body").find('#move' + whereTo).addClass("runningbutton");
        movementAPI.move(whereTo, function() {
            $("body").find('#move' + whereTo).removeClass("runningbutton");
        });
    }

    wakeUp(e) {
        $("body").find('#dowakeup').addClass("runningbutton");
        movementAPI.wakeUp(function() {
            $("body").find('#dowakeup').removeClass("runningbutton");
        });
    }

    rest(e) {
        $("body").find('#gorest').addClass("runningbutton");
        movementAPI.rest(function() {
            $("body").find('#gorest').removeClass("runningbutton");
        });
    }

    stop(e) {
        movementAPI.stop();
    }

    render() {
        return(
            <div>
                <div className="row">
                    <div className="col-md-6">
                        <button id="dowakeup" onClick={this.wakeUp.bind(this)} className="btn btn-default btn-block"><i className="fa fa-child"></i> Wake up</button>
                    </div>
                    <div className="col-md-6">
                        <button id="gorest" onClick={this.rest.bind(this)}  className="btn btn-default btn-block"><i className="fa fa-power-off"></i> Rest</button>
                    </div>
                </div>
                <div className="row" style={{ marginTop: '10px' }}>
                    <div className="col-md-4">
                        <button disabled className="btn btn-default disabled btn-block"><i className="fa fa-circle-o"></i></button>
                    </div>
                    <div className="col-md-4">
                        <button id="moveup" onClick={this.move.bind(this, 'up')} className="btn btn-default btn-block"><i className="fa fa-arrow-circle-up"></i></button>
                    </div>
                    <div className="col-md-4">
                        <button disabled className="btn btn-default disabled btn-block"><i className="fa fa-circle-o"></i></button>
                    </div>
                </div>
                <div className="row" style={{ marginTop: '10px' }}>
                    <div className="col-md-4">
                        <button id="moveleft" onClick={this.move.bind(this, 'left')} className="btn btn-default btn-block"><i className="fa fa-arrow-circle-left"></i></button>
                    </div>
                    <div className="col-md-4">
                        <button onMouseLeave={this.stop.bind(this)} className="btn btn-default btn-block"><i className="fa fa-stop-circle"></i></button>
                    </div>
                    <div className="col-md-4">
                        <button id="moveright" onClick={this.move.bind(this, 'right')} className="btn btn-default btn-block"><i className="fa fa-arrow-circle-right"></i></button>
                    </div>
                </div>
                <div className="row" style={{ marginTop: '10px' }}>
                    <div className="col-md-4">
                        <button disabled className="btn btn-default disabled btn-block"><i className="fa fa-circle-o"></i></button>
                    </div>
                    <div className="col-md-4">
                        <button id="movedown" onClick={this.move.bind(this, 'down')} className="btn btn-default btn-block"><i className="fa fa-arrow-circle-down"></i></button>
                    </div>
                    <div className="col-md-4">
                        <button disabled className="btn btn-default disabled btn-block"><i className="fa fa-circle-o"></i></button>
                    </div>
                </div>
            </div>
        );
    }
};

export default MovePad;