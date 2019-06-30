import React, { Component } from 'react';
import axios from 'axios';
import InfiniteScroll from 'react-infinite-scroll-component';
import { Link } from "react-router-dom";


import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Card from '@material-ui/core/Card';
import CardActionArea from '@material-ui/core/CardActionArea';
import CardActions from '@material-ui/core/CardActions';
import CardContent from '@material-ui/core/CardContent';
import CardMedia from '@material-ui/core/CardMedia';
import Typography from '@material-ui/core/Typography';
import Container from '@material-ui/core/Container';
import Grid from '@material-ui/core/Grid';
import Loading from '../Loading/Loading';
import LazyLoad from 'react-lazy-load';
import Button from '@material-ui/core/Button';

const styles = {
  card: {
    
  },
  media: {
    width: 200,
    marginLeft: 'auto',
    marginRight: 'auto',
  },
  content: {
    textAlign: 'left',
  },
  imageArea: {
    background: '#f2f2f2',
  },
  scroll: {
    overflow: 'hidden !important',
  },
};

const API_URL = 'http://localhost:8000/api';
const IMAGE_URL = 'http://localhost:8000';

const ITEM_PER_PAGE = 16;

class PokemonType extends Component {
  constructor(props){
    super(props);
    this.state = {
      pokemons: [],
      count: ITEM_PER_PAGE,
      start: 1,
      show: 1,
      type: 0,
    };
    this.myRef = React.createRef();
  }

  fetchMoreData = () => {
    const { count } = this.state;
    const type = this.props.match.params.name;
    this.setState({start: this.state.start + count});
    const url = `${API_URL}/pokemons/type/${type}/${count}/${this.state.start}`;
    console.log(url)
    axios.get(url)
      .then(res => this.setState({pokemons: this.state.pokemons.concat(res.data), type: type})
    );
  };

  // componentWillMount(){}
  // componentDidMount(){}
  // componentWillUnmount(){}

  // componentWillReceiveProps(){}
  // shouldComponentUpdate(){}
  // componentWillUpdate(){}
  // componentDidUpdate(){}
  

  componentDidMount() {
    const { count, start } = this.state;
    const type = this.props.match.params.name;
    const url = `${API_URL}/pokemons/type/${type}/${count}/${start}`;
    axios.get(url)
      .then(res => res.data)
      .then((data) => {
        this.setState({ pokemons: data })
    });
    this.setState({show : 0, type: type});
    
  }

  static getDerivedStateFromProps(nextProps, prevState){
    if(nextProps.match.params.name !== prevState.type){
      return { type: nextProps.match.params.name, start: 1, show: 1};
   } 
   else {
      return null;
   }
 }
 
 componentDidUpdate(prevProps, prevState) {
   if(prevProps.match.params.name !== this.state.type){
    const { count, start } = this.state;
    const type = this.props.match.params.name;
    const url = `${API_URL}/pokemons/type/${type}/${count}/${start}`;
    axios.get(url)
      .then(res => res.data)
      .then((data) => {
        this.setState({ pokemons: data })
    });
    this.setState({show : 0, type: type});
    window.scrollTo(0, 0);
   }
 }

  render() {
    const { classes } = this.props;
    let loading;
    if (this.state.show === 1) {
      loading = <Loading />;
    } else {
      loading = '';
    } 
    return (
      <div>
        { loading }
        <InfiniteScroll
          className={classes.scroll}
          dataLength={this.state.pokemons.length}
          next={this.fetchMoreData}
          hasMore={this.state.pokemons.length >= this.state.start}
          loader={<Loading />}
        >
          <Container maxWidth="lg">
            <Grid container spacing={3}>
              {this.state.pokemons.map((pokemon, index) => (
                  <Grid item xs={3} key={pokemon.id}>
                    <Card className={classes.card}>
                      <CardActionArea className={classes.imageArea}>
                        <Link key={pokemon.id} 
                          to={"/pokemon/" + pokemon.slug}
                          className="type-link">
                          <LazyLoad 
                            height={200}
                            width={200}
                            className="lazy-block"
                          >
                            <CardMedia
                              component="img"
                              alt={index}
                              width="100"
                              image={IMAGE_URL + pokemon.avatar}
                              title=""
                              className={classes.media}
                            />
                          </LazyLoad>
                        </Link>
                      </CardActionArea>
                      <CardContent className={classes.content}>
                        <Typography gutterBottom component="h6">
                          #{pokemon.number}
                        </Typography>
                        <Typography gutterBottom variant="h5" component="h2">
                          {pokemon.name}
                        </Typography>
                      </CardContent>
                      <CardActions>
                        
                        {pokemon.types.map((type, i) => {
                          return (
                            <Link key={type.id}
                             to={"/pokemons/type/" + type.name.toLowerCase()}
                             className="type-link">
                              <Button variant="contained" className={"type__" + type.name}>
                                {type.name}
                              </Button>
                            </Link>
                          )
                        })}
                       
                        
                      </CardActions>
                    </Card>
                  </Grid>
              ))}
            </Grid>
          </Container>  
        </InfiniteScroll>
      </div>
    );
  }
}

PokemonType.propTypes = {
  classes: PropTypes.object.isRequired,
};

export default withStyles(styles)(PokemonType);