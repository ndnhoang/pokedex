import React, { Component } from 'react';
import {Link } from 'react-router-dom';



class Nav extends Component {



  // componentWillMount(){}
  // componentDidMount(){}
  // componentWillUnmount(){}

  // componentWillReceiveProps(){}
  // shouldComponentUpdate(){}
  // componentWillUpdate(){}
  // componentDidUpdate(){}

  render() {
    
    return (
        <nav>
            <ul>
                <li><Link to='/'>Home</Link></li>
                <li><Link to='/pokemons'>Pokemons</Link></li>
                <li><Link to='/types'>Types</Link></li>
            </ul>
        </nav>
      
    );
  }
}



export default Nav;