var generalAPI = require('./general').default;

var behaviorAPI = {
    session: null,

    init: function (session) {
        this.session = session;
    },

    getAll: function(project_id, cb) {
        fetch('/roboback/public/api/behavior/' + project_id).then(function(response) {
            return response.json();
        }).then(function(json) {
            cb(json);
        }.bind(this));
    },

    getInstalled: function(cb) {
        if (this.session !== null) {
            this.session.service("ALBehaviorManager").done(function(bhv) {
                bhv.getInstalledBehaviors().done(function(behaviors) {
                    // console.log(behaviors);
                    cb(behaviors);
                });
            });
        }
    },

    run: function(name) {
        if (this.session !== null) {
            this.session.service("ALBehaviorManager").done(function(bhv) {
                bhv.runBehavior(name).fail(function(e) {
                    alert(e);
                });
            });
        }
    },

    isRunning: function(name, cb) {
        if (this.session !== null) {
            this.session.service("ALBehaviorManager").done(function(bhv) {
                bhv.isBehaviorRunning(name).done(function(running) {
                    cb(running);
                });
            });
        }
    },

    hasRunningBehaviors: function(name, cb) {
        if (this.session !== null) {
            this.session.service("ALBehaviorManager").done(function(bhv) {
                bhv.getRunningBehaviors().done(function(behaviors) {
                    if (behaviors.length > 0) {
                        cb(true);
                    } else {
                        cb(false);
                    }
                });
            });
        }
    }
};

export default behaviorAPI;
