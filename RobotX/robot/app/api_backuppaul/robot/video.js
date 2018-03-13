var videoAPI = {
    service: null,
    displayVideo: true,
    subID: "RobtotsNU2212",

    init: function (video) {
        this.service = video;
        //this.start();
    },

    drawImage: function (subscriberID, vdev, context, img) {
        if (this.service !== null) {
            vdev.getImageRemote(subscriberID).done(function (video) {
                var arrayBuf = videoAPI.base64ToArrayBuffer(video[6]);
                var tpx = 320 * 240;
                var uint8array = new Uint8Array(arrayBuf);
                for (var j = 0; j < tpx; j++) {
                    img.data[j * 4] = uint8array[j * 3];
                    img.data[j * 4 + 1] = uint8array[j * 3 + 1];
                    img.data[j * 4 + 2] = uint8array[j * 3 + 2];
                    img.data[j * 4 + 3] = 200;
                }
                context.putImageData(img, 0, 0);
                vdev.releaseImage(subscriberID);
            }).fail(function (error) {
                videoAPI.displayVideo = false;
                videoAPI.service.unsubscribe(subscriberID);
                console.log("Fail to get video image. error = " + error);
            });
        }
    },

    base64ToArrayBuffer: function (base64) {
        var binary_string = window.atob(base64);
        var len = binary_string.length;
        var bytes = new Uint8Array(len);
        for (var i = 0; i < len; i++) {
            bytes[i] = binary_string.charCodeAt(i);
        }
        return bytes.buffer;
    },

    start: function () {
        if (this.service !== null) {
            var that = this;
            var fps = 1; // frame number
            this.subID = "RobotsNU5221" + Math.floor((Math.random() * 100) + 1);

            this.service.subscribeCamera(this.subID, 0, 1, 11, fps).done(function (res) {
                var delay = 1000 / fps;
                var canvas = $("#video");
                var context = canvas[0].getContext('2d');
                var img = context.createImageData(320, 240);
                var timer; //timer
                this.displayVideo = true;
                var loop = function () {
                    that.drawImage(res, that.service, context, img);
                    clearTimeout(timer);
                    if (videoAPI.displayVideo) {
                        timer = setTimeout(loop, delay);
                    }
                };
                // loop start
                loop();
            }).fail(function () {
               alert("Fail to subsctibe");
            });
        }
    },

    stop: function() {
        videoAPI.displayVideo = false;
        videoAPI.service.unsubscribe(this.subID);
    }
};

export default videoAPI;
