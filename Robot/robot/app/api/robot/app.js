var speakAPI = require('./speak').default;
var videoAPI = require('./video').default;
var generalAPI = require('./general').default;
var movementAPI = require('./movement').default;
var headAPI = require('./head').default;
var ledsAPI = require('./leds').default;
var faceDetectionAPI = require('./face').default;
var behaviorAPI = require('./behavior').default;
var gamepadAPI = require('../peripherals/gamepad').default;
var audioAPI = require('../peripherals/audio').default;

var app = {
    ip: '192.168.1.35',
    projectId: false,
    
    connect: function(cb) {
        console.log('app connect ip ' + sessionStorage.getItem('ip'));

        if (sessionStorage.getItem('ip') !== null) {
            this.ip = sessionStorage.getItem('ip');
        }

        var $script = require("scriptjs");
        $script("http://" + this.ip + "/libs/qimessaging/1.0/qimessaging.js", function() {
        //Paul Ald  zie $script("http://" + this.ip + "/libs/qimessaging/2/qimessaging.js", function() {    
            try {
                var session = new QiSession(this.ip);
                var interval = null;

                session.socket().on('connect', function () {
                    console.log('QiSession connected!');
                    generalAPI.init(session);
                    gamepadAPI.init();
                    behaviorAPI.init(session);
                    audioAPI.init(this.ip);
                    headAPI.init(session);
                    ledsAPI.init(session);
                    faceDetectionAPI.init(session);

                    app.register(session, function() {
                        interval = setInterval(function() {
                          gamepadAPI.update();
                          movementAPI.update();
                            headAPI.update();
                        }, 250);  // Paul ;was 50
                    });
                    setTimeout(function() {
                        cb();
                    }, 2000);
                });
            }
            catch (e) {
                console.log('Exception: ' + e);
                cb(e); //Paul cb(e)
            }
        }.bind(this));
    },

    register: function(session, callback) {
        session.service("ALMotion").done(function(motion) {
            console.log('Initialized ALMotion');
            //motion.wakeUp();
            movementAPI.init(motion);
            headAPI.init(motion);

            session.service("ALTextToSpeech").done(function (tts) {
                console.log('Initialized ALTextToSpeech');
                speakAPI.init(tts);
                session.service("ALVideoDevice").done(function (vid) {
                    console.log('Initialized ALVideoDevice');
                    videoAPI.init(vid);
                    callback();
                });
            });
        });
    }
};

export default app;