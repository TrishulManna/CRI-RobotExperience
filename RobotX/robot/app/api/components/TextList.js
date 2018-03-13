import React from 'react';

var TextItem = require('./TextItem.js').default;
var TextMenu = require('./TextMenu.js').default;

class TextList extends React.Component {
    constructor() {
        super();
        this.handleTextChange = this.handleTextChange.bind(this);
        this.state = {
            items: [],
            dancemenu: [],
            greetingsmenu: [],
            interactionmenu: [],
            presentationmenu: []
        };
    }

    getList() {
        fetch('/roboback/public/api/text/' + this.props.projectId).then(function(response) {
            return response.json();
        }).then(function(json) {
            this.setState({items: json});
        }.bind(this));
    }

    getMainMenu(themenu) {
        fetch('/roboback/public/api/text/mainmenu/' + themenu + "/" + this.props.projectId).then(function(response) {
            return response.json();
        }).then(function(json) {
            // console.log("getMainMenu " + JSON.stringify(json));
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

    handleTextChange(e) {
        if(e.target.value.length <= 0) {
            this.getList();
        } else {
            const condition = new RegExp(e.target.value, 'i');
            const names = this.state.items.filter((item, index) => {
                if (index < 25) {  //Paul was 10
                   return true;
                }
                if (condition.test(item.name) || condition.test(item.text)) {
                    return true;
                }
                return false;
            });

            this.setState({
                items: names
            });
        }
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

    selectDancesMenu(e) {
        if ($("#text-dances-menu").is(":visible") === true) {
            $("#img-compliments").css('border', '0px');
            $("#text-dances-menu").hide();
            $("#text-standard-menu").show(); 
        } else {
            $("#text-standard-menu").hide();    
            $("#text-greetings-menu").hide();
            $("#text-interactions-menu").hide();
            $("#text-presentations-menu").hide();
            $("#img-presentations").css('border', '0px');
            $("#img-robotanswers").css('border', '0px');
            $("#img-greetings").css('border', '0px');
            $("#img-compliments").css('border', '2px solid blue');
            $("#text-dances-menu").show();
        }
    }
    selectGreetingsMenu(e) {
        if ($("#text-greetings-menu").is(":visible") === true) {
            $("#text-greetings-menu").hide();
            $("#img-greetings").css('border', '0px');
            $("#text-standard-menu").show();
        } else {
            $("#text-standard-menu").hide();    
            $("#text-dances-menu").hide();
            $("#text-interactions-menu").hide();
            $("#text-presentations-menu").hide();
            $("#img-compliments").css('border', '0px');
            $("#img-presentations").css('border', '0px');
            $("#img-robotanswers").css('border', '0px');
            $("#img-greetings").css('border', '2px solid blue');
            $("#text-greetings-menu").show();
        }
    }
    selectInteractionsMenu(e) {
        if ($("#text-interactions-menu").is(":visible") === true) {
            $("#text-interactions-menu").hide();
            $("#img-interactions").css('border', '0px');
            $("#text-standard-menu").show();
        } else {
            $("#text-standard-menu").hide();    
            $("#text-dances-menu").hide();
            $("#text-greetings-menu").hide();
            $("#text-presentations-menu").hide();    
            $("#img-compliments").css('border', '0px');
            $("#img-greetings").css('border', '0px');
            $("#img-robotanswers").css('border', '0px');
            $("#img-interactions").css('border', '2px solid blue');
            $("#text-interactions-menu").show();
        }
    }
    selectPresentationsMenu(e) {
        if ($("#text-presentations-menu").is(":visible") === true) {
            $("#text-presentations-menu").hide();
            $("#img-robotanswers").css('border', '0px');
            $("#text-standard-menu").show();
        } else {
            $("#text-standard-menu").hide();    
            $("#text-dances-menu").hide();
            $("#text-interactions-menu").hide();
            $("#text-greetings-menu").hide();  
            $("#img-compliments").css('border', '0px');
            $("#img-greetings").css('border', '0px');
            $("#img-interactions").css('border', '0px');
            $("#img-robotanswers").css('border', '2px solid blue');
            $("#text-presentations-menu").show();
        }
    }

    render() {
        console.log('render textlist ' + this.state.items.length);

        $('#text-dances').show(); 
        $('#text-greetings').show();
        $('#text-interactions').show();
        $('#text-presentations').show();
     

        const top5 = this.state.items.map((item, index) => {
            if (index < 5) {
                return <TextItem key={index} idx={index} name={item.name} text={item.text} icon={item.icon} animations={item.animations} />;
            }
        });

        const top10 = this.state.items.map((item, index) => {
            if (index > 4 && index < 10) {
                return <TextItem key={index} idx={index} name={item.name} text={item.text} icon={item.icon} animations={item.animations} />;
            }
        });

        //Paul
        const top15 = this.state.items.map((item, index) => {
            if (index > 9 && index < 15) {
                return <TextItem key={index} idx={index} name={item.name} text={item.text} icon={item.icon} animations={item.animations} />;
            }
        });

        const top20 = this.state.items.map((item, index) => {
            if (index > 14 && index < 20) {
                return <TextItem key={index} idx={index} name={item.name} text={item.text} icon={item.icon} animations={item.animations} />;
            }
        });

        const top25 = this.state.items.map((item, index) => {
            if (index > 19 && index < 25) {
                return <TextItem key={index} idx={index} name={item.name} text={item.text} icon={item.icon} animations={item.animations} />;
            }
        });

      

        var names = [];
        if (this.state.items.length > 25) {  //Paul: was 10
            names = this.state.items.map((item, index) => {
                if (index > 24) { //Paul was 9
                    return <TextItem key={index} idx={index} name={item.name} text={item.text} icon={item.icon} animations={item.animations} />;
                }
            });
        }

        var danceitems = [ <li key="danceitems" className="list">No compliments</li> ];
        if (this.state.dancemenu.length > 0) {
            danceitems = this.state.dancemenu.map((item, index) => {
                if (item.menuvisible === false) $('#text-dances').hide();
                if (item.id !== 0 && sessionStorage.getItem('lamguage') === item.language) {
                    return <TextMenu key={index} idx={index} name={item.name} text={item.text} icon={item.icon} animations={item.animations} />;
                } else if (item.id !== 0 && sessionStorage.getItem('lamguage') !== item.language) {
                    return null;
                } else {
                    return <li key={index} className="list">No compliments</li>;
                }
            });
            if (this.checkEmptyList(danceitems)) {
                danceitems = [ <li key="danceitems" className="list">No compliments</li> ];
            }
        }
        var greetingitems = [ <li key="greetingitems" className="list">No greetings</li> ];
        if (this.state.greetingsmenu.length > 0) {
            greetingitems = this.state.greetingsmenu.map((item, index) => {
                if (item.menuvisible === false) $('#text-greetings').hide();
                if (item.id !== 0 && sessionStorage.getItem('lamguage') === item.language) {
                    return <TextMenu key={index} idx={index} name={item.name} text={item.text} icon={item.icon} animations={item.animations} />;
                } else if (item.id !== 0 && sessionStorage.getItem('lamguage') !== item.language) {
                    return null;
                } else {
                    return <li key={index} className="list">No greetings</li>;
                }
            });
            if (this.checkEmptyList(greetingitems)) {
                greetingitems = [ <li key="greetingitems" className="list">No greetings</li> ];
            }
        }
        var interactionitems = [ <li key="interactionitems" className="list">No interactions</li> ];
        if (this.state.interactionmenu.length > 0) {
            interactionitems = this.state.interactionmenu.map((item, index) => {
                if (item.menuvisible === false) $('#text-interactions').hide();
                if (item.id !== 0 && sessionStorage.getItem('lamguage') === item.language) {
                    return <TextMenu key={index} idx={index} name={item.name} text={item.text} icon={item.icon} animations={item.animations} />;
                } else if (item.id !== 0 && sessionStorage.getItem('lamguage') !== item.language) {
                    return null;
                } else {
                    return <li key={index} className="list">No interactions</li>;
                }
            });
            if (this.checkEmptyList(interactionitems)) {
                interactionitems = [ <li key="interactionitems" className="list">No interactions</li> ];
            }
        }
        var presentationitems = [ <li key="presentationitems" className="list">No robotanswers</li> ];
        if (this.state.presentationmenu.length > 0) {
            presentationitems = this.state.presentationmenu.map((item, index) => {
                if (item.menuvisible === false) $('#text-presentations').hide();
                if (item.id !== 0 && sessionStorage.getItem('lamguage') === item.language) {
                    return <TextMenu key={index} idx={index} name={item.name} text={item.text} icon={item.icon} animations={item.animations} />;
                } else if (item.id !== 0 && sessionStorage.getItem('lamguage') !== item.language) {
                    return null;
                } else {
                    return <li key={index} className="list">No robotanswers</li>;
                }
            });
            if (this.checkEmptyList(presentationitems)) {
                presentationitems = [ <li key="presentationitems" className="list">No robotanswers</li> ];
            }
        }

        return (
            <div>

                <div>
                    <input className="search" placeholder="Search text" onChange={ this.handleTextChange } />
                    <table className="tableicons">
                        <tbody>
                            <tr className="top10-row">{ top5 }</tr>
                            <tr className="top10-row">{ top10 }</tr>
                            <tr className="top10-row">{ top15 }</tr>
                            <tr className="top10-row">{ top20 }</tr>
                            <tr className="top10-row">{ top25 }</tr>
                    </tbody></table>
                   
                </div>
             
                <table className="tableicons">
                    <tbody>
                    <tr className="top10-row">
                        <td onClick={this.selectDancesMenu.bind(this)} id="text-dances" className="menu-icon" style={{cursor: 'pointer'}}>
                           <img id="img-compliments" className="menulist-icon" src="../public/images/compliments-menu.jpg" title="Compliments"></img>
                        </td>
                        <td  onClick={this.selectGreetingsMenu.bind(this)} id="text-greetings" className="menu-icon" style={{cursor: 'pointer'}}>
                            <img id="img-greetings" className="menulist-icon" src="../public/images/greetings-menu.jpg" title="Greetings"></img>
                        </td>    
                        <td onClick={this.selectInteractionsMenu.bind(this)} id="text-interactions" className="menu-icon" style={{cursor: 'pointer'}}>
                            <img id="img-interactions" className="menulist-icon" src="../public/images/interactions-menu.jpg" title="Interactions"></img>
                        </td>    
                        <td onClick={this.selectPresentationsMenu.bind(this)} id="text-presentations" className="menu-icon" style={{cursor: 'pointer'}}>
                            <img id="img-robotanswers" className="menulist-icon" src="../public/images/robotanswers-menu.jpg" title="Robotanswers"></img>
                        </td>    
                   </tr>
                   </tbody>
                </table>
             
                <div>
                    <ul id="text-dances-menu" className="list" style={{ paddingTop: '0px', display: 'none' }}> { danceitems }  </ul>
                    <ul id="text-greetings-menu" className="list" style={{ paddingTop: '0px', display: 'none' }}> { greetingitems } </ul>
                    <ul id="text-interactions-menu" className="list" style={{ paddingTop: '0px', display: 'none' }}> { interactionitems }  </ul>
                    <ul id="text-presentations-menu" className="list" style={{ paddingTop: '0px', display: 'none' }}> { presentationitems } </ul>
                    
                    <ul id="text-standard-menu" className="list" style={{ paddingTop: '0px' , display: 'block' }}>{ names }</ul>
                </div>
            </div>
        );
    }
}

export default TextList;