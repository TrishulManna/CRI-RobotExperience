
///////////////////////////////////////////////////
// Display Video Images
////////////////////////////////////////////////////
Ibot.session = null;
Ibot.displayVideo = false;
Ibot.savedSubscriberID = null;

Ibot.getVideoImages = function(ipaddress){
    $("#subMenu").fadeOut("fast");
    Ibot.newConnect(ipaddress, function (ret,session) {
        Ibot.session = session;
        if (ret === "success") {
            Ibot.session.service("ALVideoDevice").done(function (vdev) {
                var fps = 1; // frame number
                var subID = "subscriberID";
                vdev.subscribeCamera(subID, 0, 1, 11, fps).done(function (subscriberID) {
                    $("#videoStop").unbind();
                    $("#videoStop").click(function(){
                        Ibot.displayVideo = false;
                        vdev.unsubscribe(subscriberID);
                    });
                    $("#dialogOK").unbind();
                    $("#dialogOK").click(function () {
                        Ibot.displayVideo = false;
                        vdev.unsubscribe(subscriberID);
                        $("#mdialog").fadeOut("fast");
                        $("#glayLayer").fadeOut("fast");
                    });
                    var delay = 1000/fps;// interval for timer
                    $( 'input[name="fpsValue"]:radio' ).change( function() {
                        Ibot.showConfirm("Network is too slow. It is possible for the robot to stop.",function(ret){
                            if(ret === "OK"){
                                var newFps = $(this).val(); // value
                                Ibot.showAlert("Change frame rate. newrate = " + newFps);
                                fps = parseInt(newFps);
                                vdev.setFrameRate(subscriberID, fps);
                                delay = 1000 / fps;
                            }else{
                                $('input[name="fpsValue"]').val(["1"]);
                                fps = 1;
                                vdev.setFrameRate(subscriberID, fps);
                                delay = 1000 / fps;
                            }
                        });
                    });
                    var canvas = $("#videocanvas");
                    var context = canvas[0].getContext('2d');
                    var img = context.createImageData(320, 240);
                    var timer; //timer
                    Ibot.displayVideo = true;
                    var loop = function () {
                        Ibot.drawImage(subscriberID, vdev,context,img);
                        clearTimeout(timer);
                        if(Ibot.displayVideo){
                            timer = setTimeout(loop, delay);
                        }else{
                        }
                    };
                    // loop start
                    loop();
                }).fail(function(){
                    Ibot.showAlert("Fail to subsctibe");
                });
            }).fail(function(){
                Ibot.showAlert("Fail to start video device.");
            });
        } else {
            Ibot.showAlert("Fail to connect to the robot.");
        }
    });
};
