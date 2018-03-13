var gamepadAPI = {
    controller: {},

    init: function() {
        var gp = navigator.getGamepads()[0];
        console.log(gp);
        if(typeof gp != 'undefined' && gp != null) {
            if(gp.connected) {
                gamepadAPI.controller = gp;
            }
        }
    },

    connect: function(evt) {
        gamepadAPI.controller = evt.gamepad;
        console.log('Gamepad connected.');
        return evt.gamepad;
    },

    disconnect: function(evt) {
        delete gamepadAPI.controller;
        console.log('Gamepad disconnected.');
    },

    arrowsPressed: function() {
        if(isInArray(14, gamepadAPI.buttonsStatus) || isInArray(15, gamepadAPI.buttonsStatus) || isInArray(12, gamepadAPI.buttonsStatus) || isInArray(13, gamepadAPI.buttonsStatus)) {
            
            return true;
        } else {
            return false;
        }
    },

    update: function() {
        navigator.getGamepads();
        //this.controller = navigator.getGamepads()[0];
        // clear the buttons cache
        gamepadAPI.buttonsCache = [];
        // move the buttons status from the previous frame to the cache
        for(var k=0; k<gamepadAPI.buttonsStatus.length; k++) {
            gamepadAPI.buttonsCache[k] = gamepadAPI.buttonsStatus[k];
        }
        // clear the buttons status
        gamepadAPI.buttonsStatus = [];
        // get the gamepad object
        var c = gamepadAPI.controller || {};

        // loop through buttons and push the pressed ones to the array
        var pressed = [];

        if(c.buttons) {
            for(var b=0,t=c.buttons.length; b<t; b++) {
                if(c.buttons[b].pressed) {
                    pressed.push(b);
                }
            }
        }
        // loop through axes and push their values to the array
        var axes = [];
        if(c.axes) {
            for(var a=0,x=c.axes.length; a<x; a++) {
                axes.push(c.axes[a].toFixed(2));
            }
        }

        if(pressed.length > 0) {
            //console.log(pressed);
        }

        // assign received values
        gamepadAPI.axesStatus = axes;
        gamepadAPI.buttonsStatus = pressed;
        // return buttons for debugging purposes

        //window.requestAnimationFrame(gamepadAPI.update);

        //console.log(gamepadAPI);

        return pressed;
    },
    buttonPressed: function() {},
    buttons: [],
    buttonsCache: [],
    buttonsStatus: [],
    axesStatus: []
};

export default gamepadAPI;