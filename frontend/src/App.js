import React from 'react';
import './App.css';
import Pokemon from './components/Pokemon/Pokemon';
import 'typeface-roboto';
import {Switch, Route } from 'react-router-dom';
import PokemonType from './components/PokemonType/PokemonType';
import Nav from './components/Nav/Nav';

function App() {
  return (
    <div className="App">
      <Switch>
        <Route exact path='/' component={Pokemon} />
        <Route path='/pokemons' component={Pokemon} />
        <Route path='/types/:id?' component={PokemonType} />
      </Switch>
    </div>
  );
}

export default App;
