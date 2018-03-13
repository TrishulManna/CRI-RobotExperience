import React from 'react';

var generalAPI = require('../robot/general').default;
var videoAPI = require('../robot/video').default;

class Video extends React.Component {
    constructor() {
        super();
        this.state = {
            videoActivated: false,
        };
    }

    triggerVideo(e) {
        if(this.state.videoActivated) {
            $("body").find('#showvideo').removeClass("runningbutton");
            videoAPI.stop();
        }
        else {
            $("body").find('#showvideo').addClass("runningbutton");
            videoAPI.start();
        }

        this.setState({
            videoActivated: !this.state.videoActivated
        });
    }

    render() {
        var text = this.state.videoActivated ? 'Stop' : 'Start';

        return (
            <div style={{position: 'relative'}}>
                <div className="video-overlay" style={{ opacity: '0.4', padding: '8px', position: 'absolute', top: 0, left: 0, width: '100%', height: '50px', backgroundColor: 'black' }}>
                    <button id="showvideo" style={{ opacity: '1.0 !important', color: 'black' }} onClick={this.triggerVideo.bind(this)} className="btn btn-default pull-right">
                        <span>{text}</span>
                    </button>
                </div>
                <canvas id="video">

                </canvas>
            </div>
        );
    }
}

export default Video;