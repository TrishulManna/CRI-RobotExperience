import React from 'react';
import { hashHistory } from 'react-router'

var app = require('../robot/app.js').default;

class ProjectItem extends React.Component {
    constructor() {
        super();
    }

    selectProject(e) {
        e.preventDefault();
        var project_id = this.props.id;
        sessionStorage.setItem('project_name', this.props.name);
        sessionStorage.setItem('project_id', project_id);
        hashHistory.push('dashboard/' + project_id);
    }

    render() {
        return (
            <div className="col-sm-6 col-md-4">
                <div className="thumbnail">
                <a href="#" onClick={this.selectProject.bind(this)}><img style={{ height: '75px' }} src={ this.props.image } alt="Image" /></a>
                    <div className="caption">
                        <h3>{ this.props.name }</h3>
                        <p>{ this.props.date }</p>
                        <p>
                            <a href="#" onClick={this.selectProject.bind(this)} className="btn btn-primary" role="button">Use Dashboard</a>
                        </p>
                    </div>
                </div>
            </div>
        );
    }
}

export default ProjectItem;