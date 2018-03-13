import React from 'react';

var behaviorAPI = require('../robot/behavior').default;

class BehaviorMenu extends React.Component {
    constructor() {
        super();
        this.state = {
            iconclass: "fa fa-smile-o list-icon",
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
            // console.log("BehaviorMenu getIcon json " + icon + " " + JSON.stringify(icon));
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

    playBehavior(e) {
        e.persist();
        $(e.target).parent().addClass("runningbehavior");
        console.log(this.props);
        var slug = this.props.slug;
        behaviorAPI.run(slug);
        var timer = setInterval(function () {
            behaviorAPI.isRunning(slug, function(running) {
                if (running) {
                    $(e.target).parent().addClass("runningbehavior");
                } else {
                    clearInterval(timer);
                    $(e.target).parent().removeClass("runningbehavior");
                }
            }.bind(this));
        }.bind(this), 5000);
    }

    render() {
        if (this.state.icondata === null) {
            return (
                <li className="dropdowm-menuitem" style={ {cursor: 'pointer'} } onClick={ this.playBehavior.bind(this) }>
                    <i className={ this.state.iconclass }></i> <span className="name">{ this.props.name }</span>
                </li>
            );
        } else {
            return (
                <li className="dropdowm-menuitem" style={ {cursor: 'pointer'} } onClick={ this.playBehavior.bind(this) }>
                    <img className="dropdown-list-icon" src={ this.state.icondata }/>  <span className="name">{ this.props.name }</span>
                </li>
            );
        }
    }
}

export default BehaviorMenu;