var faceDetectionAPI = {
    session: null,

    init: function(session) {
        this.session = session;
    },

    trackFace: function(cb, action) {
        if (this.session !== null) {
            this.session.service("ALFaceDetection").done(function (face) {
                console.log('trackFace ' + action +  " enabled " +  JSON.stringify(face.isRecognitionEnabled()));
                if (face.isRecognitionEnabled() === false) {
                    face.setRecognitionEnabled(true).done(function() {
                        face.setTrackingEnabled(action).done(function() {
                            // console.log('trackFace rec set ' + action);
                            cb();
                        });
                    });
                } else {
                    face.setTrackingEnabled(action).done(function() {
                        // console.log('trackFace set ' + action);
                        cb();
                    });
                }
            });
        }
    }
};

export default faceDetectionAPI;