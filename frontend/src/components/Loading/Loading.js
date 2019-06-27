import React, { Component } from 'react';
import './Loading.css';

class Loading extends Component {
  // constructor(props){
    // super(props);
    // this.state = {};
  // }

  // componentWillMount(){}
  // componentDidMount(){}
  // componentWillUnmount(){}

  // componentWillReceiveProps(){}
  // shouldComponentUpdate(){}
  // componentWillUpdate(){}
  // componentDidUpdate(){}

  render() {
    return (
      <div>
        <div className="loading">
          <img src={require("../../images/pokeball-loading.gif")} alt="Loading..."/>
        </div>
      </div>
    );
  }
}

export default Loading;