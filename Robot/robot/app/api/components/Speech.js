import React from 'react';

var generalAPI = require('../robot/general').default;
var speakAPI = require('../robot/speak').default;
var spacekey = '';
var MicStarted = false; 

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
    };
    
    //var Title = React.createClass({
    //    handleTest: function(e) {
    //      if (e.charCode == 13) {
    //        alert('Enter... (KeyPress, use charCode)');
    //      }
    //      if (e.keyCode == 13) {
    //        alert('Enter... (KeyDown, use keyCode)');
    //      }
    //    },
    
    enableMicrophoneSpacebar(e) {     //Paul
        var b = document.getElementById("say_mic_button");
        var code = e.keyCode || e.charCode;
 
        e.preventDefault(); 

        if (spacekey == 'off'){
            MicStarted = false;     
            console.log('micstat UIT!!');
            console.log('OFFFF');
            this.state.micstat ='fa fa-microphone-slash say-mic';
           this.setState({
                micstat: 'fa fa-microphone-slash say-mic'
            });
            
            this.showInfo('');
            
            if (this.state.recognizing) {
                this.recognition.stop();
                this.recognition = null;
            };


        }; 
 
        b.addEventListener("keydown", function (e) {
            e = e || window.event;
            var code = e.keyCode || e.charCode;
            if (code == 32 ) { // enter or space
                spacekey = 'on';
            }
        });
        b.addEventListener("keyup", function (e) {
            e = e || window.event;
            var code = e.keyCode || e.charCode;
            if (code == 32 ) { // enter or space
                spacekey = 'off';
                console.log('space keyup '+spacekey)
            }
        });

       // document.getElementById(id).addEventListener('mousedown', function(ev) { action(); timeout = setInterval(action, interval); return false; }, false);
       // document.getElementById(id).addEventListener('mouseup', function(ev) { clearInterval(timeout); return false; }, false);
       // document.getElementById(id).addEventListener('touchend', function(ev) { clearInterval(timeout); return false; }, false);
      


        b.addEventListener("mousedown", function (e) {
            e = e || window.event;
            //var button = e.which || e.button;
            //if (e.button == 0) { // left click
            console.log('mouse down');
                       
            spacekey = 'on';
                e.preventDefault();     
            //}
        });
        b.addEventListener("mouseup", function (e) {
            e = e || window.event;
            console.log('mouse up');
            //var button = e.which || e.button;
            //    if (e.button == 0) { // left click
                    spacekey = 'off';
            //    }
        });
    
        if (spacekey == 'on'){
            console.log('micstat aan!!');
               this.state.start_timestamp = e.timeStamp;
            

            this.state.micstat =  'fa fa-microphone say-mic-on';
            this.setState({
                micstat: 'fa fa-microphone say-mic-on'
            });
            e.preventDefault()

           // this.enableMicrophone(e);
          // if (!('webkitSpeechRecognition' in window)) {
          //      this.showInfo('info_upgrade');
          //  }; 
          //  this.state.start_timestamp = e.timeStamp;
           if (!MicStarted) {
               console.log(MicStarted);
              this.state.start_timestamp = this.timeStamp;
              this.startMicrophoneSpaceBar(this);
           }
           else   { 

           };
        }  
              
        
       
        //e.preventDefault(); //Paul stop this event!!

    };  // enableMicrophoneSpacebar(e) {

        startMicrophoneSpaceBar(ctx) {
            MicStarted = true;    //Paul 
            console.log(ctx);
            ctx.recognition = new webkitSpeechRecognition();
            ctx.recognition.continuous = true;
            ctx.recognition.interimResults = true;
            ctx.state.ignore_onend = false;
    
            console.log('in start microphone spacebar');
    
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
            console.log('voor start recon');
            ctx.recognition.start();
    
            ctx.recognition.onstart = function () {
                console.log('in onstart');
                ctx.state.recognizing = true;
                ctx.showInfo('info_speak_now');
            };
    
            ctx.recognition.onerror = function (event) {
                console.log('in onerror');
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
                console.log('in onend');
                ctx.state.recognizing = false;
                if (ctx.state.ignore_onend) {
                    return;
                }
                ctx.showInfo('');
            };
    
            ctx.recognition.onresult = function (event) {
                console.log('in onresult');
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
        console.log(ctx);
        ctx.recognition = new webkitSpeechRecognition();
        ctx.recognition.continuous = true;
        ctx.recognition.interimResults = true;
        ctx.state.ignore_onend = false;

        console.log('in start microphone');

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
        console.log('voor start recon');
        ctx.recognition.start();

        ctx.recognition.onstart = function () {
            console.log('in onstart');
            ctx.state.recognizing = true;
            ctx.showInfo('info_speak_now');
        };

        ctx.recognition.onerror = function (event) {
            console.log('in onerror');
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
            console.log('in onend');
            ctx.state.recognizing = false;
            if (ctx.state.ignore_onend) {
                return;
            }
            ctx.showInfo('');
        };

        ctx.recognition.onresult = function (event) {
            console.log('in onresult');
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
                                <button id="say_mic_button" className="btn btn-default" 
                                    onClick={this.enableMicrophone.bind(this)} 
                                    onKeyPress={this.enableMicrophoneSpacebar.bind(this)}
                                    onKeyUp={this.enableMicrophoneSpacebar.bind(this)}>
                                <i className={this.state.micstat}></i></button>
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