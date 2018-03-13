var ledsAPI = {
    session: null,

    init: function(session) {
        this.session = session;
    },

    randomEyes: function(cb) {
        if (this.session !== null) {
            this.session.service("ALLeds").done(function (leds) {
                leds.randomEyes(2).done(function() {
                    cb();
                });
            });
        }
    },

    blickEyes: function(cb) {
        if (this.session !== null) {
            this.session.service("ALLeds").done(function (leds) {
                for (var i=0; i<10; i++)
                {
                    leds.fade("FaceLedRight" + i, 0, 0.5);
                    leds.fade("FaceLedLeft" + i, 0, 0.5);
                }
                for (var i=0; i<10; i++)
                {
                    leds.fade("FaceLedRight" + i, 1, 1.5);
                    leds.fade("FaceLedLeft" + i, 1, 1.5);
                }
                setTimeout(function() {
                    cb();
                }.bind(this), 1000);
            });
        }
    }
};

export default ledsAPI;