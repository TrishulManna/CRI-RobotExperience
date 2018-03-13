import React from 'react';

class Main extends React.Component {
    render () {
        return (
           <div className="container">
               { this.props.children }
           </div>
        );
    }
};

export default Main;