import React from 'react';
import SkyLight from 'react-skylight';

var BehaviorItem = require('./BehaviorItem.js').default;
var BehaviorMenu = require('./BehaviorMenu.js').default;
var behaviorAPI  = require('../robot/behavior.js').default;

class BehaviorList extends React.Component {
    constructor() {
        super();
        this.handleBehaviorChange = this.handleBehaviorChange.bind(this);
        this.handleBehaviorChangeAll = this.handleBehaviorChangeAll.bind(this);
        this.state = {
            behaviors: [],
            robotitems: [],
            items: [],
            installed: [],
            dancemenu: [],
            greetingsmenu: [],
            interactionmenu: [],
            presentationmenu: []
        };
    }

    getList() {
        console.log("BehaviorList getList for project " + this.props.projectId);

        if (this.state.robotitems.length === 0) {
            behaviorAPI.getInstalled(function(list) {
                // console.log("BehaviorList installed on robot " + list);
                this.state.robotitems = list;
                this.setState({installed: list});
                this.getBehaviors();
            }.bind(this));
        } else {
            this.setState({installed: this.state.robotitems});
            this.getBehaviors();
        }
    }

    getBehaviors() {
        if (this.state.behaviors.length === 0) {
            behaviorAPI.getAll(this.props.projectId, function(list) {
                if (this.state.robotitems.length > 0) {
                    var update = list.map((item) => {
                        var avail = $.grep(this.state.robotitems, function(e) {
                            return e === item.slug;
                        });
                        if (avail.length > 0) {
                            item.available = true;
                        } else {
                            item.available = false;
                        }
                        return item;
                    });
                    this.state.behaviors = update;
                    this.setState({items: update});
                } else {
                    this.state.behaviors = list;
                    this.setState({items: list});
                }
            }.bind(this));
        } else {
            this.setState({items: this.state.behaviors});
        }
    }

    getMainMenu(themenu) {
        fetch('/roboback/public/api/behavior/mainmenu/' + themenu + "/" + this.props.projectId).then(function(response) {
            return response.json();
        }).then(function(json) {
            // console.log("BehaviorList getMainMenu json " + themenu + " " + JSON.stringify(json));
            switch (themenu) {
                case 'Dance menu':
                    this.state.dancemenu = json;
                    break;
                case 'Greetings menu':
                    this.state.greetingsmenu = json;
                    break;
                case 'Interaction menu':
                    this.state.interactionmenu = json;
                    break;
                case 'Presentation menu':
                    this.state.presentationmenu = json;
                    break;
            }
        }.bind(this));
    }

    componentDidMount() {
        this.getMainMenu('Dance menu');
        this.getMainMenu('Greetings menu');
        this.getMainMenu('Interaction menu');
        this.getMainMenu('Presentation menu');
        this.getList();
    }

    handleBehaviorChange(e) {
        if(e.target.value.length <= 0) {
            this.getList();
        } else {
            const condition = new RegExp(e.target.value, 'i');
            const names = this.state.items.filter((item, index) => {
                if (index < 20) {  //Paul was 10
                   return true;
                }
                if (condition.test(item.name) || condition.test(item.slug)) {
                    return true;
                }
                return false;
            });

            this.setState({
                items: names
            });
        }
    }

    handleBehaviorChangeAll(e) {
        if(e.target.value.length <= 0) {
            this.getList();
        } else {
            const condition = new RegExp(e.target.value, 'i');
            const names = this.state.installed.filter(item => {
                return condition.test(item);
            });

            this.setState({
                installed: names
            });
        }
    }

    selectDancesMenu(e) {
         if ($("#bhv-dances-menu").is(":visible") === true) {
            $("#bhv-dances-menu").hide();
        } else {
            $("#bhv-dances-menu").show();
        }
    }
    selectGreetingsMenu(e) {
        if ($("#bhv-greetings-menu").is(":visible") === true) {
            $("#bhv-greetings-menu").hide();
        } else {
            $("#bhv-greetings-menu").show();
        }
    }
    selectInteractionsMenu(e) {
        if ($("#bhv-interactions-menu").is(":visible") === true) {
            $("#bhv-interactions-menu").hide();
        } else {
            $("#bhv-interactions-menu").show();
        }
    }
    selectPresentationsMenu(e) {
        if ($("#bhv-precentations-menu").is(":visible") === true) {
            $("#bhv-precentations-menu").hide();
        } else {
            $("#bhv-precentations-menu").show();
        }
    }

    checkLanguage(languages) {
        if (languages !== null) {
            var res = languages.split(" ");
            for (var s in res) {
                if (sessionStorage.getItem('lamguage') === res[s]) {
                    return true;
                }
            }
        }
        return false;
    }

    checkEmptyList(items) {
        if (items !== null) {
            for (var i in items) {
                if (items[i] !== null) {
                    return false;
                }
            }
        }
        return true;
    }


    render() {
        console.log('render behaviorlist');
        $('#bhv-dances').show();
        $('#bhv-greetings').show();
        $('#bhv-interactions').show();
        $('#bhv-precentations').show();

        var dialogStyle = {
            height: '400px',
            overflow: 'scroll'
        };

        const top5 = this.state.items.map((item, index) => {
            if (index < 5) {
                return <BehaviorItem key={index} installed='false' idx={index} name={item.name} slug={item.slug} icon={item.icon} available={item.available} />;
            }
        });

        const top10 = this.state.items.map((item, index) => {
            if (index > 4 && index < 10) {
                return <BehaviorItem key={index} installed='false' idx={index} name={item.name} slug={item.slug} icon={item.icon} available={item.available} />;
            }
        });

        //Paul
        const top15 = this.state.items.map((item, index) => {
            if (index > 9 && index < 15) {
                return <BehaviorItem key={index} installed='false' idx={index} name={item.name} slug={item.slug} icon={item.icon} available={item.available} />;
            }
        });
        const top20 = this.state.items.map((item, index) => {
            if (index > 14 && index < 20) {
                return <BehaviorItem key={index} installed='false' idx={index} name={item.name} slug={item.slug} icon={item.icon} available={item.available} />;
            }
        });
        const top25 = this.state.items.map((item, index) => {
            if (index > 19 && index < 25) {
                return <BehaviorItem key={index} installed='false' idx={index} name={item.name} slug={item.slug} icon={item.icon} available={item.available} />;
            }
        });

        //Paul


        var names = [];
        if (this.state.items.length > 25) { //Paul was 10
            names = this.state.items.map((item, index) => {
                if (index > 24) { // Paul: was 9
                    return <BehaviorItem key={index} installed='false' idx={index} name={item.name} slug={item.slug} icon={item.icon} available={item.available} />;
                }
            });
        }

        const allInstalled = this.state.installed.map((name, index) => {
            return <BehaviorItem key={index} installed='true' idx={index} name={name} slug={name}/>;
        });

        var danceitems = [ <li key="danceitems" className="list">No dances</li> ];
        if (this.state.dancemenu.length > 0) {
            danceitems = this.state.dancemenu.map((item, index) => {
                if (item.menuvisible === false) $('#bhv-dances').hide();
                if (item.id !== 0 && this.checkLanguage(item.language) === true) {
                    return <BehaviorMenu key={index} idx={index} name={item.name} slug={item.slug} icon={item.icon} />;
                } else if (item.id !== 0 && this.checkLanguage(item.language) === false) {
                    return null;
                } else {
                    return <li key={index} className="list">No dances</li>;
                }
            });
            if (this.checkEmptyList(danceitems)) {
                danceitems = [ <li key="danceitems" className="list">No dances</li> ];
            }
        }
        var greetingitems = [ <li key="greetingitems" className="list">No activities</li> ];
        if (this.state.greetingsmenu.length > 0) {
            greetingitems = this.state.greetingsmenu.map((item, index) => {
                if (item.menuvisible === false) $('#bhv-greetings').hide();
                if (item.id !== 0 && this.checkLanguage(item.language) === true) {
                    return <BehaviorMenu key={index} idx={index} name={item.name} slug={item.slug} icon={item.icon} />;
                } else if (item.id !== 0 && this.checkLanguage(item.language) === false) {
                      return null;
                } else {
                    return <li key={index} className="list">No activities</li>;
                }
            });
            if (this.checkEmptyList(greetingitems)) {
                greetingitems = [ <li key="greetingitems" className="list">No activities</li> ];
            }
        }
        var interactionitems = [ <li key="interactionitems" className="list">No interactions</li> ];
        if (this.state.interactionmenu.length > 0) {
            interactionitems = this.state.interactionmenu.map((item, index) => {
                if (item.menuvisible === false) $('#bhv-interactions').hide();
                if (item.id !== 0 && this.checkLanguage(item.language) === true) {
                    return <BehaviorMenu key={index} idx={index} name={item.name} slug={item.slug} icon={item.icon} />;
                } else if (item.id !== 0 && this.checkLanguage(item.language) === false) {
                      return null;
                } else {
                    return <li key={index} className="list">No interactions</li>;
                }
            });
            if (this.checkEmptyList(interactionitems)) {
                interactionitems = [ <li key="interactionitems" className="list">No interactions</li> ];
            }
        }
        var presentationitems = [ <li key="presentationitems" className="list">No presentations</li> ];
        if (this.state.presentationmenu.length > 0) {
            presentationitems = this.state.presentationmenu.map((item, index) => {
                if (item.menuvisible === false) $('#bhv-precentations').hide();
                if (item.id !== 0 && this.checkLanguage(item.language) === true) {
                    return <BehaviorMenu key={index} idx={index} name={item.name} slug={item.slug} icon={item.icon} />;
                } else if (item.id !== 0 && this.checkLanguage(item.language) === false) {
                      return null;
                } else {
                    return <li key={index} className="list">No presentations</li>;
                }
            });
            if (this.checkEmptyList(presentationitems)) {
                interactionitems = [ <li key="presentationitems" className="list">No presentations</li> ];
            }
        }

        return (
            <div>

                <div>
                   
 
                    <input className="search" placeholder="Search behavior" onChange={ this.handleBehaviorChange } />    
                                 
                        <button style={{marginLeft: '5px' }} onClick={() => this.refs.simpleDialog.show()} className="btn btn-default btn-sm"><i className="fa fa-list"></i> Installed </button>
                  
                



                    <table className="table"><tbody>
                        <tr className="top10-row">{ top5 }</tr>
                        <tr className="top10-row">{ top10 }</tr>
                        <tr className="top10-row">{ top15 }</tr>
                        <tr className="top10-row">{ top20 }</tr>
                        <tr className="top10-row">{ top25 }</tr>
                        </tbody>
                     </table>
                 
                     
                </div>



                <div className="dropdown dropdown-body">
                    <button className="dropbtn dropdown-body"><h3><i className="fa fa-list"></i> Behaviors</h3></button>
                    <div className="dropdown-content">
                        <ul className="list" style={{ paddingTop: '0px'}}>
                            <li id="bhv-dances">
                                <span onClick={this.selectDancesMenu.bind(this)}>Dances</span><br />
                                <ul id="bhv-dances-menu" className="list dropdowm-menuitem" style={{ paddingTop: '0px', display: 'none' }}>
                                    { danceitems }
                                </ul>
                            </li>
                            <li id="bhv-greetings">
                                <span onClick={this.selectGreetingsMenu.bind(this)}>Activities</span><br />
                                <ul id="bhv-greetings-menu" className="list" style={{ paddingTop: '0px', display: 'none' }}>
                                    { greetingitems }
                                </ul>
                            </li>
                            <li id="bhv-interactions">
                                <span onClick={this.selectInteractionsMenu.bind(this)}>Interactions</span><br />
                                <ul id="bhv-interactions-menu" className="list" style={{ paddingTop: '0px', display: 'none' }}>
                                    { interactionitems }
                                </ul>
                            </li>
                            <li id="bhv-precentations">
                                <span onClick={this.selectPresentationsMenu.bind(this)}>Presentations</span><br />
                                <ul id="bhv-precentations-menu" className="list" style={{ paddingTop: '0px', display: 'none' }}>
                                    { presentationitems }
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div>
                   <ul className="list" style={{ paddingTop: '0px' }}>{ names }</ul>
                </div>

                <SkyLight dialogStyles={dialogStyle} hideOnOverlayClicked ref="simpleDialog" title="Installed behaviors">
                    <input className="search" placeholder="Search behavior" onChange={ this.handleBehaviorChangeAll } />
                    <ul className="list">
                        { allInstalled }
                    </ul>
                </SkyLight>
            </div>
        );
    }
}

export default BehaviorList;