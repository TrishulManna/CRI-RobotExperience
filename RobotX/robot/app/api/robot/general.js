var generalAPI = {
    session: null,
    volume: 0,
    charge: 0,

    init: function(session) {
        this.session = session;
    },

    stop: function() {
        if (this.session !== null) {
            this.session.service("ALBehaviorManager").done(function (bhv) {
                // bhv.startBehavior("pepperstop/pepperstop");
                bhv.stopAllBehaviors();
            });
        }
    },

    getBattery: function(cb) {
        if (this.session !== null) {
            this.session.service("ALMemory").then(function (ALMemory) {
                ALMemory.subscriber("BatteryChargeChanged").then(function (subscriber) {
                    subscriber.signal.connect(function (state) {
                        cb(state);
                    });
                });
            });

            this.session.service("ALBattery").done(function (battery) {
                battery.getBatteryCharge().done(function(charge) {
                    generalAPI.charge = charge;
                    cb(charge);
                });
            });
        }
    },

    getBatteryCharging: function(cb) {
        if (this.session !== null) {
            this.session.service("ALMemory").then(function (ALMemory) {
                ALMemory.subscriber("BatteryChargingFlagChanged").then(function (subscriber) {
                    subscriber.signal.connect(function (state) {
                        cb(state);
                    });
                });
            });
        }
    },

    getVolume: function(cb) {
        if (this.session !== null) {
            this.session.service("ALAudioDevice").done(function (audio) {
                audio.getOutputVolume().done(function(volume) {
                    generalAPI.volume = volume;
                    cb(volume);
                });
            });
        }
    },

    volumeDown: function(cb) {
        if (this.session !== null) {
            var new_volume = this.volume - 5;
            if (new_volume<5) {new_volume=5}; // Paul
            this.session.service("ALAudioDevice").done(function (audio) {
                this.volume = new_volume;
                audio.setOutputVolume(new_volume).done(function() {
                   cb(new_volume);
                });
            }.bind(this));
        }
    },

    volumeUp: function(cb) {
        if (this.session !== null) {
            var new_volume = this.volume + 5;
            this.session.service("ALAudioDevice").done(function (audio) {
                this.volume = new_volume;
                audio.setOutputVolume(new_volume).done(function() {
                    cb(new_volume);
                });
            }.bind(this));
        }
    }
};

export default generalAPI;