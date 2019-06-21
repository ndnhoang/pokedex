import React, { Component } from 'react';
import './Pokemon.css';
import axios from 'axios';
import InfiniteScroll from 'react-infinite-scroll-component';


import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Card from '@material-ui/core/Card';
import CardActionArea from '@material-ui/core/CardActionArea';
import CardActions from '@material-ui/core/CardActions';
import CardContent from '@material-ui/core/CardContent';
import CardMedia from '@material-ui/core/CardMedia';
import Button from '@material-ui/core/Button';
import Typography from '@material-ui/core/Typography';
import Container from '@material-ui/core/Container';
import Grid from '@material-ui/core/Grid';
import Loading from '../Loading/Loading';
import LazyLoad from 'react-lazy-load';
import $ from 'jquery';

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

class Pokemon extends Component {
  constructor(props){
    super(props);
    this.state = {
      pokemons: [],
      count: ITEM_PER_PAGE,
      start: 1,
      show: 1,
    };
  }

  fetchMoreData = () => {
    const { count } = this.state;
    this.setState({start: this.state.start + count});
    const url = `${API_URL}/pokemons/${count}/${this.state.start}`;
    axios.get(url)
      .then(res => this.setState({pokemons: this.state.pokemons.concat(res.data)})
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
    const url = `${API_URL}/pokemons/${count}/${start}`;
    axios.get(url)
      .then(res => res.data)
      .then((data) => {
        this.setState({ pokemons: data })
    });
    this.setState({show : 0});

  }

  render() {
    const { classes } = this.props;
    let loading;
    if (this.state.show === 1) {
      loading = <Loading />;
    } else {
      loading = '';
    } 
    console.log(loading)
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
                        <Button size="small" color="primary">
                          Share
                        </Button>
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

Pokemon.propTypes = {
  classes: PropTypes.object.isRequired,
};

export default withStyles(styles)(Pokemon);