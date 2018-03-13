import React from 'react';

var behaviorAPI = require('../robot/behavior').default;

class BehaviorItem extends React.Component {
    constructor() {
        super();
        this.state = {
            iconclass: "fa fa-smile-o list-icon",
            icondata:  null,
            iconidx:   -1
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
            // console.log("BehaviorItem getIcon icon " + JSON.stringify(icon));
            if (icon[0] !== undefined) {
                this.setState({
                    icondata: 'data:image/' + icon[0].type + ';base64,' + icon[0].icon,
                    iconidx:  this.props.idx
                });
            } else {
                this.setState({
                    icondata: null,
                    iconidx:  this.props.idx
                });
            }
        }.bind(this));
    }

    componentDidMount() {
        if (this.props.available === false) this.state.iconclass = "fa fa-ban list-icon unavialable";
        if (this.props.icon !== null && this.props.icon !== '' && this.props.installed === 'false') {
            this.getIcon();
        } else {
            this.getBaseIcon();
        }
    }

    playBehavior(id, e) {
        // e.persist();
        $("body").find("#bhv" + id).addClass("runningbehavior");
        console.log(this.props);
        var slug = this.props.slug;
        behaviorAPI.run(slug);
        var timer = setInterval(function () {
            behaviorAPI.isRunning(slug, function(running) {
                if (running) {
                    $("body").find("#bhv" + id).addClass("runningbehavior");
                } else {
                    clearInterval(timer);
                    $("body").find("#bhv" + id).removeClass("runningbehavior");
                }
            }.bind(this));
        }.bind(this), 5000);  
    }

    render() {
        if (this.state.iconidx >= 0) {
            if (this.props.installed === 'true') {
                return (
                    <li id={"bhv" + this.state.iconidx} key={this.state.iconidx} style={{cursor: 'pointer'}} onClick={this.playBehavior.bind(this, this.state.iconidx)}>
                        <span className="name">{ this.props.name }</span>
                    </li>
                );
            }
            if (this.state.iconidx < 25) {  //Paul was 10
                if (this.state.icondata === null) {
                    if (this.props.available === false) {
                        return(
                            <td id={"bhv" + this.state.iconidx} key={this.state.iconidx} className="top10-icon" style={{cursor: 'not-allowed'}}><i style={{verticalAlign: 'bottom'}} className={ this.state.iconclass } title={ this.props.name }></i></td>
                        );
                    } else {
                        return(
                            <td id={"bhv" + this.state.iconidx} key={this.state.iconidx} className="top10-icon" style={{cursor: 'pointer'}} onClick={this.playBehavior.bind(this, this.state.iconidx)}><i style={{verticalAlign: 'bottom'}} className={ this.state.iconclass } title={ this.props.name }></i></td>
                        );
                    }
                } else {
                    if (this.props.available === false) {
                        return(
                            <td id={"bhv" + this.state.iconidx} key={this.state.iconidx} className="top10-icon" style={{cursor: 'not-allowed'}}><img className="conn-list-icon" src={ this.state.icondata } title={ this.props.name }/></td>
                        );
                    } else {
                        return(
                            <td id={"bhv" + this.state.iconidx} key={this.state.iconidx} className="top10-icon" style={{cursor: 'pointer'}} onClick={this.playBehavior.bind(this, this.state.iconidx)}><img className="conn-list-icon" src={ this.state.icondata } title={ this.props.name }/></td>
                        );
                    }
                }
            } else {
                if (this.state.icondata === null) {
                    if (this.props.available === false) {
                        return (
                            <li id={"bhv" + this.state.iconidx} key={this.state.iconidx} style={{cursor: 'not-allowed'}}>
                                <i className={ this.state.iconclass }></i> <span className="name unavialable">{ this.props.name }</span>
                            </li>
                        );
                    } else {
                        return (
                            <li id={"bhv" + this.state.iconidx} key={this.state.iconidx} style={{cursor: 'pointer'}} onClick={this.playBehavior.bind(this, this.state.iconidx)}>
                                <i className={ this.state.iconclass }></i> <span className="name">{ this.props.name }</span>
                            </li>
                        );
                    }
                } else {
                    if (this.props.available === false) {
                        return (
                            <li id={"bhv" + this.state.iconidx} key={this.state.iconidx} style={{cursor: 'not-allowed'}}>
                                <img className="conn-list-icon" src={ this.state.icondata }/> <span className="name unavialable">{ this.props.name }</span>
                            </li>
                        );
                    } else {
                        return (
                            <li id={"bhv" + this.state.iconidx} key={this.state.iconidx} style={{cursor: 'pointer'}} onClick={this.playBehavior.bind(this, this.state.iconidx)}>
                                <img className="conn-list-icon" src={ this.state.icondata }/> <span className="name">{ this.props.name }</span>
                            </li>
                        );
                    }
                }
            }
        } else {
            return null;
        }
    }
}

export default BehaviorItem;