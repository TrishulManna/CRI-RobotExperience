import React from 'react';
import { hashHistory } from 'react-router'

var app = require('../robot/app.js').default;

class SelectIP extends React.Component {
    constructor(props) {
        super(props);
        console.log('PROPS ' + JSON.stringify(props));
        console.log('LOC ' + JSON.stringify(window.location));

        if (sessionStorage.getItem('ip') === null) {
            sessionStorage.setItem('ip', '');
        }

        this.state = {
            ip: sessionStorage.getItem('ip'),
            statusmsg: '',
            msgstyle: {}
        };
    }

    componentDidMount() {
        var connecterror = sessionStorage.getItem('connect-error');
        if (connecterror !== null)
        {
            if (connecterror.includes('QiSession is not defined'))
            {
               this.setState({
                    statusmsg: "JavaScript interface with robot not available",
                    msgstyle: {color: 'red', fontWeight: 'bold'}
                });
            }
            else
            {
                this.setState({
                    statusmsg: connecterror,
                    msgstyle: {color: 'red', fontWeight: 'bold'}
                });
            }
        }
        sessionStorage.removeItem('connect-error');
    }

    handleIPChange(e) {
        this.setState({ip: e.target.value, statusmsg: '', msgstyle: {}});
    }

    handleSubmit(e) {
        e.preventDefault();

        var ipnum = this.state.ip.trim();
        if (!ipnum) {
            return;
        }
        sessionStorage.setItem('ip', ipnum);
        app.ip = ipnum;

        jQuery("#status-msg").html("<p>Check connection</p>");
        var $script = require("scriptjs");
        $script("./assets/ping.min.js", function() {
            var p = new Ping();
            // jQuery('body').css( 'cursor', 'wait' );

            p.ping("http://"+ipnum, function(ms) {
                console.log("PING " + ipnum + " " + ms + "ms");
                // jQuery('body').css( 'cursor', 'arrow' );
                //Paul: Aan/Uit onderstaande voor testen zonder robot
               if (ms > 2499) {
                    jQuery("#status-msg").html("<p><span style=\"color: red; font-weight: bold;\">Robot is not responding</span></p>");
                } else {
                    hashHistory.push('projects');
               }
            }, 2500);
        }.bind(this));
    }

    render() {
        return(
            <div className="container">
                <div className="row" style={{marginTop: 40 }}>
                    <div className="col-md-4 col-md-offset-4">
                        <img src="/robot/public/images/Robotrentals-rent-a-robot-top.png" style={{width: '500px', marginBottom: 30}} />
                            <div id="status-msg" style={this.state.msgstyle}><p>{this.state.statusmsg}</p></div>
                        <form onSubmit={this.handleSubmit.bind(this)}>
                            <div className="form-group">
                                <label htmlFor="ip">IP address of the robot</label>
                                <input onChange={this.handleIPChange.bind(this)} value={this.state.ip} type="text" className="form-control" id="ip" placeholder="IP adres" />
                            </div>
                            <button type="submit" className="btn btn-default btn-block">Submit</button>
                        </form>
                        <p>
                            <br />
                            <a href="/roboback/public/index.php">Back to Behaviours Management</a>
                        </p>
                    </div>
                </div>
            </div>
        );
    }
}

export default SelectIP;