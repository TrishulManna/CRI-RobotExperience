var speakAPI = {
    service: null,
    speed: 100,

    init: function (speech) {
        this.service = speech;
    },

    getLanguages: function (cb) {
        if (this.service !== null) {
            this.service.getAvailableLanguages().done(function (languages) {
                this.service.getLanguage().done(function (current_language) {
                    cb(languages, current_language);
                });
            }.bind(this));
        }
    },

    changeLanguage: function (new_language, cb) {
        if (this.service !== null) {
            this.service.setLanguage(new_language).done(function () {
                cb();
            }.bind(this));
        }
    },

    speak: function (text, cb) {
        if (this.service !== null) {
            this.service.say(text).done(function() {
                cb();
            });
        }
    },

    getSpeed: function (cb) {
        if (this.service !== null) {
            this.service.getParameter("speed").done(function (speed) {
                // console.log("speakAPI speed " + speed);
                speed = Math.floor(speed / 10) * 10;
                if (speed > 150) speed = 150;
                speakAPI.speed = speed;
                cb(speed - 50);
            });
        }
    },

    speedDown: function (cb) {
        if (this.service !== null) {
            var new_speed = this.speed - 10;
            if (new_speed < 50 ) new_speed = 50;
            this.speed = new_speed;
            this.service.setParameter("speed", new_speed).done(function () {
                cb(new_speed - 50);
            });
        }
    },

    speedUp: function (cb) {
        if (this.service !== null) {
            var new_speed = this.speed + 10;
            if (new_speed > 150 ) new_speed = 150;  // Was 200
            this.speed = new_speed;
            this.service.setParameter("speed", new_speed).done(function () {
                cb(new_speed - 50);
            });
        }
    },

    stop: function () {
        if (this.service !== null) {
            this.service.stopAll();
        }
    }
};

export default speakAPI;