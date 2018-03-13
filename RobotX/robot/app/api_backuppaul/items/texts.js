var textsAPI = {
    get: function() {
//        fetch('http://localhost/roboback/public/api/text/1').then(function(response) {
        fetch('/roboback/public/api/text/1').then(function(response) {
            console.log(response);
        });
    }
};