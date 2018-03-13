var gamepadAPI = require('../peripherals/gamepad').default;

function scaleBetween(unscaledNum, minAllowed, maxAllowed, min, max) {
    var u = (maxAllowed - minAllowed) * (unscaledNum - min) / (max - min) + minAllowed;
    if (u >  1) u = 1;
    if (u < -1) u = -1;
    return u;
}

var headAPI = {
    position: {
        horizontal: 0,
        vertical: 0
    },
    waitH: false,
    waitHTimer: 0,
    service: null,

    init: function(motion) {
        this.service = motion;
        // this.service.setAngles("HeadYaw", this.position.horizontal, 0.1);
    },

    setPosition: function(x, y, speed) {
        if (this.service !== null) {
            // console.log('X:' + x + " Y: " + y + " S: " + speed);
            x = scaleBetween(x, -1, 1, 0, 200);
            y = scaleBetween(y, -1, 1, 0, 200);

            // Set left/right
            this.service.setAngles("HeadYaw",   x, speed/2);
            // Set up/down
            this.service.setAngles("HeadPitch", y, speed/2);
        }
    },

    isInArray: function(value, array) {
        return array.indexOf(value) > -1;
    },

    hasMovement: function(value) {
        return value > 0.2 || value < -0.2;
    },

    update: function() {
        if (this.service !== null) {
            var h = gamepadAPI.axesStatus[2];
            var v = gamepadAPI.axesStatus[3];

            if (this.hasMovement(h)) {
                if (h >  1.0) h = 1;
                if (h < -1.0) h = -1;
                // console.log('H:' + h);

                // 0.05 fastest.
                var speed = 0;

                if (h > 0) {
                    this.service.changeAngles("HeadYaw", -0.25, 0.05);
                } else {
                    this.service.changeAngles("HeadYaw",  0.25, 0.05);
                }
            }

            if (this.hasMovement(v)) {
                if (v >  1.0) v = 1;
                if (v < -1.0) v = -1;
                // console.log("V: " + v);

                if (v > 0) {
                    this.service.changeAngles("HeadPitch",  0.25, 0.05);
                } else {
                    this.service.changeAngles("HeadPitch", -0.25, 0.05);
                }

            }
        }
    }
};

export default headAPI;