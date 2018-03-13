import React from 'react';
import { hashHistory } from 'react-router'

var generalAPI = require('../robot/general').default;
var speakAPI = require('../robot/speak').default;

class LanguageControl extends React.Component {
    constructor() {
        super();
        this.state = {
            current: 'Dutch',
            languages: []
        };
        sessionStorage.setItem('lamguage', this.state.current);
    }

    componentDidMount() {
        this.getLanguages();
    }

    changeLanguage(new_language, e) {
        speakAPI.changeLanguage(new_language, function() {
            this.setState({
               current: new_language
            });
            sessionStorage.setItem('lamguage', this.state.current);
            hashHistory.push('dashboard/' + sessionStorage.getItem('project_id'));
        }.bind(this));
    }

    getLanguages() {
        speakAPI.getLanguages(function(languages, current) {
            this.setState({
                languages: languages,
                current: current
            });
            sessionStorage.setItem('lamguage', this.state.current);
        }.bind(this));
    }

    render () {
        var map = {
            'Dutch':   'nl',
            'English': 'gb',
            'French':  'fr',
            'German':  'de'
        };
        var current_class = 'icon-black flag flag-' + map[this.state.current];
        var that = this;
        const langs = this.state.languages.map((name, index) => {
            var c = 'flag flag-' + map[name];
            if(name === this.state.current) {
                return (
                    <li key={index} className="active">
                        <a href="javascript: void(0);"> <i className={c}></i> {name}</a>
                    </li>
                );
            } else {
                return (
                    <li key={index}>
                        <a href="javascript: void(0);" onClick={that.changeLanguage.bind(that, name)}> <i className={c}></i> {name}</a>
                    </li>
                );
            }
        });

        return (
            <ul className="nav navbar-nav">
                <li className="dropdown">
                    <a href="#" id="drop12" role="button" className="dropdown-toggle dropdown-toggle-lang" data-toggle="dropdown">
                        <i className={current_class}></i>
                        <b className="caret"></b></a>
                    <ul className="dropdown-menu" aria-labelledby="drop3">
                        { langs }
                    </ul>
                </li>
            </ul>
        );
    }
}

export default LanguageControl;