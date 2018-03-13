var Q = require('q');
var app = require('../robot/app.js').default;

console.log(app);

function downsampleBuffer(buffer, sampleRate, outSampleRate) {
    if (outSampleRate === sampleRate) {
        return buffer;
    }
    if (outSampleRate > sampleRate) {
        throw "downsampling rate show be smaller than original sample rate";
    }
    var sampleRateRatio = sampleRate / outSampleRate;
    var newLength = Math.round(buffer.length / sampleRateRatio);
    var result = new Int16Array(newLength);
    var offsetResult = 0;
    var offsetBuffer = 0;
    while (offsetResult < result.length) {
        var nextOffsetBuffer = Math.round((offsetResult + 1) * sampleRateRatio);
        var accum = 0, count = 0;
        for (var i = offsetBuffer; i < nextOffsetBuffer && i < buffer.length; i++) {
            accum += buffer[i];
            count++;
        }

        result[offsetResult] = Math.min(1, accum / count)*0x7FFF;
        offsetResult++;
        offsetBuffer = nextOffsetBuffer;
    }
    return result.buffer;
}

var audioAPI = {
    loop: false,
    streaming: false,
    audioContext: null,
    mySource: null,
    aSyncAudio: null,
    audioQueue: [],
    waiting: true,
    ws: null,
    startTime: 0,
    ip: '',

    init: function(ip) {
        this.ip = ip;
        try {
            if (this.audioContext === null) {
                if ('AudioContext' in window) {
                    this.audioContext = new AudioContext();
                } else if ('webkitAudioContext' in window) {
                    this.audioContext = new webkitAudioContext();
                } else {
                    console.log('audioerror');
                }
            }
            this.audioQueue = [];
            console.log('initialized AUDIO');
            console.log(this.audioContext);
        } catch(e) {
            console.log('error!');
            console.log(e);
        }
    },

    connect: function() {
        var that = this;
        var defer = Q.defer();

        this.ws = new WebSocket("ws://" + sessionStorage.getItem('ip') + "/audiostreamsocket/");
        this.ws.binaryType = 'arraybuffer';
        this.ws.onopen = function() {
            console.log('start streaming');
            defer.resolve("connected");
            that.ws.send("start streaming");
        };
        this.ws.onmessage = function(e) {
            console.log('message received');
            that.audioQueue.push(e.data);
            if(that.audioQueue.length > 0 && that.waiting) {
                that.aSyncAudio.resolve(that.audioQueue.length + " packet(s) available in the queue");
            }
        };
        this.ws.onerror = function() {
            console.log("Websocket Error");
            defer.reject("error");
            that.stop();
        };
        this.play();
    },

    play: function() {
        console.log('PLAY!');
        var that = this;
        that.streaming = true;
        console.log(this.audioContext);
        console.log('audio queue');
        console.log(this.audioQueue);
        if (this.audioContext)
        {
            var audioPacket = this.audioQueue.shift();

            // var audioPacket = downsampleBuffer(audioPacket, 1200);

            // console.log('audioPacket ' + audioPacket);
            if (audioPacket === undefined) {
                this.waiting = true;
                this.aSyncAudio = Q.defer();
                this.aSyncAudio.promise.then(function() {
                    that.waiting = false;
                    that.play();
                });
                return;
            } else {
                this.asyncAudio = null;
            }

            try {
                this.audioContext.decodeAudioData(audioPacket, function(audioData) {
                    that.playBuffer(audioData);
                    that.play();
                }, function(error) {
                    console.error("decoding error: " + error);
                });
            }
            catch(e) {
                console.error('An error occured: ' + e.message);
            }
        }
    },

    playBuffer: function (buf) { // jitter
        var source    = this.audioContext.createBufferSource();
        source.buffer = buf;
        source.connect(this.audioContext.destination);

        if (this.startTime === 0) {
            this.startTime = this.audioContext.currentTime + 0.01; // some delay 150ms to buy some time
        } else if(this.startTime < this.audioContext.currentTime){
            this.startTime = this.audioContext.currentTime + 0.05;
        } else {
            this.startTime = this.startTime+source.buffer.duration;
        }

        if ('AudioContext' in window) {
            source.start(this.startTime);
        } else if ('webkitAudioContext' in window) {
            source.noteOn(this.startTime);
        }

        this.mySource = source;
        //console.log("played " + myAudioContext.currentTime + " " + startTime + "(duration:"+ source.buffer.duration +")");
    },

    stop: function() {
        this.play();
        this.ws.close();
    }
};

export default audioAPI;