import React from 'react';

var generalAPI = require('../robot/general').default;
var speakAPI = require('../robot/speak').default;

class NoMatch extends React.Component {
    render() {
        return(
            <div>
                Not found!
            </div>
        );
    }
};

export default NoMatch;