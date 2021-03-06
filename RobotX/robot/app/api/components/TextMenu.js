import React from 'react';

var speakAPI = require('../robot/speak').default;
var behaviorAPI = require('../robot/behavior').default;

class TextMenu extends React.Component {
    constructor() {
        super();
        this.state = {
            iconclass: "fa fa-commenting-o dropdown-list-icon",
            icondata:  null,
            iconidx:   0
        };
    }

    getBaseIcon() {
        this.setState({
            icondata: null,
            iconidx:  this.props.idx
        });
    }

    getIcon() {
        fetch('/roboback/public/api/icon/' + this.props.icon).then(function(response) {
            return response.json();
        }).then(function(icon) {
            if (icon[0] !== undefined)
            {
                this.setState({
                    icondata: 'data:image/' + icon[0].type + ';base64,' + icon[0].icon,
                    iconidx:  this.props.idx
                });
            }
        }.bind(this));
    }

    componentDidMount() {
        if (this.props.icon !== null && this.props.icon !== '')
        {
            this.getIcon();
        }
        else
        {
            this.getBaseIcon();
        }
    }

    playText(e) {
        e.persist();
        $(e.target).parent().addClass("speakingtext");
        console.log(this.props);
        var text_to_speak = this.props.text;
        this.playAnimation(this.props.animations);
        speakAPI.speak(text_to_speak, function() {
            $(e.target).parent().removeClass("speakingtext");
        });
    }

    playAnimation(animations) {
        // console.log("playAnimation " + animations);
        if (animations !== null) {
            var ids = animations.split(";");
            var ani = 0;
            if (ids.length > 0) {
                ani = Math.floor(Math.random() * (ids.length + 1));
                if (ani >= ids.length) ani = 0;
            }
            this.getAnimation(ids[ani]);
        }
    }

    getAnimation(id) {
        console.log("getAnimation " + id);
        fetch('/roboback/public/api/behavior/animation/' + id).then(function(response) {
            return response.json();
        }).then(function(bhv) {
            // console.log("getAnimation bhv " + JSON.stringify(bhv));
            var slug = bhv[0]['slug'];
            // console.log('selected slug ' + slug);
            behaviorAPI.hasRunningBehaviors(slug, function(running) {
                if (!running) {
                    console.log('start slug ' + slug);
                    behaviorAPI.run(slug);
                    var timer = setInterval(function () {
                        behaviorAPI.isRunning(slug, function(running) {
                            if (running) {
                                console.log('slug ' + slug + ' still running!');
                            } else {
                                clearInterval(timer);
                            }
                        }.bind(this));
                    }.bind(this), 5000);
                }
            });
        }.bind(this));
    }

    render() {
        if (this.state.icondata === null) {
            return (
                <li className="dropdowm-menuitem" style={ {cursor: 'pointer'} } onClick={ this.playText.bind(this) }>
                    <i className={ this.state.iconclass }></i> <span className="name">{ this.props.name }</span>
                </li>
            );
        } else {
            return (
                <li className="dropdowm-menuitem" style={ {cursor: 'pointer'} } onClick={ this.playText.bind(this) }>
                    <img className="dropdown-list-icon" src={ this.state.icondata }/>  <span className="name">{ this.props.name }</span>
                </li>
            );
        }
    }
}

export default TextMenu;