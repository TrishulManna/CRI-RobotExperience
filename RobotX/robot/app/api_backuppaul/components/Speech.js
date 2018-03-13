import React from 'react';

var generalAPI = require('../robot/general').default;
var speakAPI = require('../robot/speak').default;

class Speech extends React.Component {
    constructor() {
        super();
        this.state = {
            text: '',
            micstat: 'fa fa-microphone-slash say-mic',
            recognizing: false,
            ignore_onend: false,
            start_timestamp: 0
        };
        this.recognition = null;
    }

    handleTextChange(e) {
        this.setState({text: e.target.value});
    }

    handleSubmit(e) {
        e.preventDefault();
        var text = this.state.text.trim();
        if (!text) {
            if (sessionStorage.getItem('saytext') !== null) {
                this.state.text = sessionStorage.getItem('saytext');
                text = this.state.text;
            }
        }
        sessionStorage.setItem('saytext', text);
        this.setState({text: text});
        $("body").find('#saytext').addClass("speakingtext");
        speakAPI.speak(text, function() {
            $("body").find('#saytext').removeClass("speakingtext");
            this.setState({text: ''});
        }.bind(this));
    }

    enableMicrophone(e) {
        e.preventDefault();
        if (this.state.recognizing === false) {
            if (!('webkitSpeechRecognition' in window)) {
                this.showInfo('info_upgrade');
            } else {
                this.setState({
                    micstat: 'fa fa-microphone say-mic-on'
                });
                this.state.start_timestamp = e.timeStamp;
                this.startMicrophone(this);
           }
        } else {
            this.showInfo('');
            this.setState({
                micstat: 'fa fa-microphone-slash say-mic'
            });
            if (this.state.recognizing) {
                this.recognition.stop();
                this.recognition = null;
            }
        }
    }

    startMicrophone(ctx) {
        ctx.recognition = new webkitSpeechRecognition();
        ctx.recognition.continuous = true;
        ctx.recognition.interimResults = true;
        ctx.state.ignore_onend = false;
        switch (sessionStorage.getItem('lamguage'))
        {
            case 'English':
                ctx.recognition.lang = 'en-US';
                break;
            case 'French':
                ctx.recognition.lang = 'fr-FR';
                break;
            case 'German':
                ctx.recognition.lang = 'de-DE';
                break;
            default:
            case 'Dutch':
                ctx.recognition.lang = 'nl-NL';
                break;
        }

        ctx.recognition.start();

        ctx.recognition.onstart = function () {
            ctx.state.recognizing = true;
            ctx.showInfo('info_speak_now');
        };

        ctx.recognition.onerror = function (event) {
            if (event.error === 'no-speech') {
                ctx.setState({
                    micstat: 'fa fa-microphone-slash say-mic'
                });
                ctx.showInfo('info_no_speech');
                ctx.state.ignore_onend = true;
            }
            if (event.error === 'audio-capture') {
                ctx.setState({
                    micstat: 'fa fa-microphone-slash say-mic'
                });
                ctx.showInfo('info_no_microphone');
                ctx.state.ignore_onend = true;
            }
            if (event.error === 'not-allowed') {
                if (event.timeStamp - ctx.state.start_timestamp < 100) {
                    ctx.showInfo('info_blocked');
                } else {
                    ctx.showInfo('info_denied');
                }
                ctx.state.ignore_onend = true;
            }
        };

        ctx.recognition.onend = function () {
            ctx.state.recognizing = false;
            if (ctx.state.ignore_onend) {
                return;
            }
            ctx.showInfo('');
        };

        ctx.recognition.onresult = function (event) {
            var interim = '';
            var transcript = '';
            if (typeof (event.results) === 'undefined') {
                ctx.recognition.onend = null;
                ctx.recognition.stop();
                ctx.showInfo('info_upgrade');
                return;
            }
            for (var i = event.resultIndex; i < event.results.length; ++i) {
                if (event.results[i].isFinal) {
                     transcript = event.results[i][0].transcript;
                } else {
                    interim += event.results[i][0].transcript;
                }
            }
            console.log('interim ' + interim);
            if (transcript !== '') {
                console.log('saytext ' + transcript);
                $("#saytext").val(transcript);
                $("body").find('#saytext').addClass("speakingtext");
                speakAPI.speak(transcript, function() {
                    $("body").find('#saytext').removeClass("speakingtext");
                    sessionStorage.setItem('saytext', transcript);
                    transcript = '';
                    ctx.setState({text: transcript});
               });
            }
        };
    }

    showInfo(s) {
        $('#mic-info').children().hide();
        if (s !== '') {
            $('#mic-'+s).show();
        }
    }

    render() {
        return (
            <div className="row" style={{ marginTop: '20px'}}>
                <div className="col-md-12">
                    <form className="form-horizontal" onSubmit={this.handleSubmit.bind(this)}>
                        <div className="input-group">
                            <input id="saytext" onChange={this.handleTextChange.bind(this)} value={this.state.text} type="text" className="form-control say-input" placeholder="Search text" />
                            <span className="input-group-btn">
                                <button type="submit" className="btn btn-primary">Say</button>
                            </span>
                            <span className="input-group-btn">
                                <button id="say_mic_button" className="btn btn-default" onClick={this.enableMicrophone.bind(this)}><i className={this.state.micstat}></i></button>
                            </span>
                        </div>
                    </form>
                    <div id="mic-info">
                        <p id="info_start" style={{display: 'none'}}>
                            Click on the microphone icon and begin speaking.
                        </p>
                        <p id="mic-info_speak_now" style={{display: 'none'}}>
                            Speak now.
                        </p>
                        <p id="mic-info_no_speech" style={{display: 'none'}}>
                            No speech was detected. You may need to adjust your <a href="//support.google.com/chrome/bin/answer.py?hl=en&amp;answer=1407892">microphone settings</a>.
                        </p>
                        <p id="mic-info_no_microphone" style={{display: 'none'}}>
                            No microphone was found. Ensure that a microphone is installed and that <a href="//support.google.com/chrome/bin/answer.py?hl=en&amp;answer=1407892">microphone settings</a> are configured correctly.
                        </p>
                        <p id="mic-info_allow" style={{display: 'none'}}>
                            Click the "Allow" button above to enable your microphone.
                        </p>
                        <p id="mic-info_denied" style={{display: 'none'}}>
                            Permission to use microphone was denied.
                        </p>
                        <p id="mic-info_blocked" style={{display: 'none'}}>
                            Permission to use microphone is blocked. To change, go to chrome://settings/contentExceptions#media-stream
                        </p>
                        <p id="mic-info_upgrade" style={{display: 'none'}}>
                            Web Speech API is not supported by this browser. Upgrade to <a href="//www.google.com/chrome">Chrome</a> version 25 or later.
                        </p>
                    </div>
                </div>
            </div>
        );
    }
}

export default Speech;