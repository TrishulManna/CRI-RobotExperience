var gamepadAPI = require('../peripherals/gamepad').default;

var movementAPI = {
    service: null,
    block: false,

    init: function(motion) {
        this.service = motion;
        this.service.moveInit();
    },

    isInArray: function(value, array) {

       //wordt steeds uitgevoerd console.log('Paul: is in array funtcie');
        return array.indexOf(value) > -1;
    },

    hasMovement: function(value) {
       //wordt ook steeds uitgevoerd console.log('Paul: is in movement');
        
    
        
        return value > 0.2 || value < -0.2;
    },

    wakeUp: function(cb) {
        if (this.service !== null) {
            console.log('wakeUp');
            this.service.wakeUp().done(function() {
                cb();
            });
        }
    },

    rest: function(cb) {
        if (this.service !== null) {
            console.log('rest');
            this.service.rest().done(function() {
                cb();
            });
        }
    },

    move: function(direction, cb) {
        if (this.service !== null) {
            this.block = true;
            console.log('block now');
            console.log(direction);

            switch(direction) {
                case 'up':
                    this.service.moveTo(0.2, 0, 0).done(function() {
                        //movementAPI.update();
                        cb();
                    });
                    break;
                case 'down':
                    this.service.moveTo(-0.2, 0, 0).done(function() {
                       // movementAPI.update();
                        cb();
                    });
                    break;
                case 'left':
                    console.log('LEFTLEFT');
                    this.service.moveTo(0, 0.2, 0).done(function() {
                       // movementAPI.update();
                        cb();
                    });
                    break;
                case 'right':
                    this.service.moveTo(0, -0.2, 0).done(function() {
                       // movementAPI.update();
                        cb();
                    });
                    break;
                //Paul
                case 'rotateleft':
                console.log('rotate left');
                this.service.moveTo(0, 0, 0.5).done(function() {
                   // movementAPI.update();
                    cb();
                });
                break;
            case 'rotateright':
            console.log('rotate right');
                this.service.moveTo(0, 0, -0.5).done(function() {
                   // movementAPI.update();
                    cb();
                });
                break;
                //Paul        

                default:
                    break;
            }

            setTimeout(function() {
                this.block = false;
                console.log('unblock now');
            }.bind(this), 2000);
        }
    },

    stop: function() {
        if (this.service !== null) {
            console.log('STOP!!');
            this.service.stopMove();
        }
    },

    update: function() {
        if (this.service !== null) {
            var y = 0;
            // -1 = forward
            // 1 = backward
            // Range is -1 till 1
            var vertical = gamepadAPI.axesStatus[1];
            // -1 = left
            // 1 = right
            // range is -1 till 1
            var horizontal = gamepadAPI.axesStatus[0];

            if(this.isInArray(13, gamepadAPI.buttonsStatus)) {
                vertical = 1;
            }
            if(this.isInArray(12, gamepadAPI.buttonsStatus)) {
                vertical = -1;
            }
            // Left
            if(this.isInArray(14, gamepadAPI.buttonsStatus)) {
                horizontal = 0;
                y = 1;
            }
            // Right
            if(this.isInArray(15, gamepadAPI.buttonsStatus)) {
                horizontal = 0;
                y = -1;
            }

            if(!this.hasMovement(vertical)) {
                vertical = 0;
            }
            if(!this.hasMovement(horizontal)) {
                horizontal = 0;
            }

            if(!this.block) {
                if(!vertical && !horizontal) {
                    this.service.stopMove();
                } else {
                    this.service.moveToward(vertical * -1, y, horizontal * -1);
                }
            }
        }
    }
};

export default movementAPI;