import React from 'react';
import { hashHistory } from 'react-router'

var ProjectItem = require('./ProjectItem').default;

class Projects extends React.Component {
    constructor() {
        super();
        this.state = {
            items: []
        };
    }

    getList() {
        fetch('/roboback/public/api/project').then(function(response) {
         //   fetch('http://localhost/roboback/public/api/project').then(function(response) {
            return response.json();
        }).then(function(json) {
            this.setState({items: json});
        }.bind(this));
    }

    componentDidMount() {
        this.getList();
    }
 
    render() {
        const projects = this.state.items.map((item, index) => {
             var img = "/roboback/public/data/" + item.image;
            //Paul var img = "http://localhost/roboback/public/data/" + item.image;
            // if (item.image === '') img = "https://placeholdit.imgix.net/~text?txtsize=33&txt=Robots.nu&w=242&h=200";
            if (item.image === '') img = "/robot//public/images/no-image.png";
            if (item.picture !== null) img = 'data:image/' + item.imgtype + ';base64,' + item.picture;
            return <ProjectItem key={index} id={item.id} name={item.name} date={item.date} image={img}/>;
        });

        return(
            <div className="container">
                <div className="row" style={{ marginTop: 40 }}>
                    { projects }
                </div>
            </div>
        );
    }
}

export default Projects;