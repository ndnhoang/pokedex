import React from 'react';
import './App.css';
import Pokemon from './components/Pokemon/Pokemon';
import 'typeface-roboto';
import {Switch, Route } from 'react-router-dom';
import PokemonType from './components/PokemonType/PokemonType';
import Type from './components/Type/Type';
import TypeDetail from './components/Type/TypeDetail';
import PokemonDetail from './components/Pokemon/PokemonDetail';

function App() {
  return (
    <div className="App">
      <Switch>
        <Route exact path='/' component={Pokemon} />
        <Route exact path='/pokemons' component={Pokemon} />
        <Route path='/pokemons/type/:name?' component={PokemonType} />
        <Route path='/pokemon/:slug' component={PokemonDetail} />
        <Route path='/types' component={Type} />
        <Route path='/type/:name' component={TypeDetail} />
      </Switch>
    </div>
  );
}

export default App;
