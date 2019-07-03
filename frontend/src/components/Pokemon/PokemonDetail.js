import React, { Component } from 'react';
import axios from 'axios';
import { Link } from "react-router-dom";

import Chart from 'react-apexcharts';


import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Button from '@material-ui/core/Button';
import Typography from '@material-ui/core/Typography';
import Container from '@material-ui/core/Container';
import Grid from '@material-ui/core/Grid';
import Loading from '../Loading/Loading';
import LazyLoad from 'react-lazy-load';
import { CardMedia, CardActionArea } from '@material-ui/core';
import FormControl from '@material-ui/core/FormControl';
import Select from '@material-ui/core/Select';
import FilledInput from '@material-ui/core/FilledInput';
import InputLabel from '@material-ui/core/InputLabel';
import MenuItem from '@material-ui/core/MenuItem';

const styles = {
  content: {
    textAlign: 'left',
  },
  scroll: {
    overflow: 'hidden !important',
  },
  button: {
    marginLeft: '5px',
    marginRight: '5px',
    marginBottom: '10px',
  },
  weaknessRow: {
    textAlign: 'left',
  },
  weaknessTitle: {
    textAlign: 'center',
  },
  title: {
    padding: '15px 0 15px 0',
  },
  block: {
    width: '100%',
  },
  number: {
    display: 'inline-block',
    color: '#616161',
    paddingLeft: '10px',
  },
  media: {
    maxWidth: '100%',
    width: 'auto',
    margin: '0 auto',
  },
  type: {
    textAlign: 'left',
    marginTop: '30px',
  },
  typeRow: {
    marginBottom: '15px',
  },
  typeItem: {
    marginRight: '15px',
    marginBottom: '10px',
  },
  weakness_0: {
    color: '#2e3436',
  },
  weakness_50: {
    color: '#a40000',
  },
  weakness_200: {
    color: '#4e9a06',
  },
  formControl: {
    minWidth: '200px',
  },
  avatar: {
    marginTop: '30px',
  },
  mixed_chart: {
    marginTop: '50px',
  },
};

const API_URL = 'http://localhost:8000/api';
const IMAGE_URL = 'http://localhost:8000';

class PokemonDetail extends Component {
  constructor(props){
    super(props);
    this.state = {
      show: 1,
      pokemon: null,
      slug: null,
      form: 0,
      statistic: null,
      options: {
        chart: {
            id: "basic-bar",
            height: 300,
        },
        xaxis: {
            categories: ['HP', 'Attack', 'Defense', 'Sp. Attack', 'Sp. Defense', 'Speed'],
            tickPlacement: 'on',
            labels: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            axisBorder: {
                show: false,
            },
        },
        yaxis: {
            min: 0,
            max: 250,
        },
        colors: [function({value, seriesIndex, w}) {
            if (value < 50) {
                return '#F46036';
            } else if (value >= 50 && value < 100) {
                return '#FEB019';
            } else if (value >= 100 && value < 150) {
                return '#4CAF50';
            } else if (value >= 150 && value < 200) {
                return '#008FFB';
            } else {
                return '#A300D6';
            }
        }],
        plotOptions: {
            bar: {
                horizontal: true,
            },
        },
      },
      series: [
        {
            name: "statistic",
            data: [0, 0, 0, 0, 0, 0],
        }
      ],
      total: 0,
    };
    this.getPokemon = this.getPokemon.bind(this);
  }

  // componentWillMount(){}
  // componentDidMount(){}
  // componentWillUnmount(){}

  // componentWillReceiveProps(){}
  // shouldComponentUpdate(){}
  // componentWillUpdate(){}
  // componentDidUpdate(){}

  componentDidMount() {
    const slug = this.props.match.params.slug;
    const url = `${API_URL}/pokemon/${slug}`;
    const url_statistic = `${API_URL}/pokemon/statistic/${slug}`;
    axios.get(url)
      .then(res => res.data)
      .then((data) => {
        this.setState({ pokemon: data, form: data[0].slug, show : 0, slug: slug })
    });
    // get statistic
    axios.get(url_statistic)
        .then(res => res.data)
        .then((data) => {
        this.setState({ statistic: data })
        if (this.state.statistic) {
            const statistic = this.state.statistic;
            const total = statistic.hp + statistic.attack + statistic.defense + statistic.special_attack + statistic.special_defense + statistic.speed;
            this.setState({
                series: [
                    {
                        name: "statistic",
                        data: [statistic.hp, statistic.attack, statistic.defense, statistic.special_attack, statistic.special_defense, statistic.speed]
                    },
                ],
                total: total,
            });
        }
    });
  }

  static getDerivedStateFromProps(nextProps, prevState){
    if(nextProps.match.params.slug !== prevState.slug){
      return { slug: nextProps.match.params.slug, show: 1};
   }
   else {
      return null;
   }
 }

 componentDidUpdate(prevProps, prevState) {
   if(prevProps.match.params.slug !== this.state.slug)  {
    const slug = this.props.match.params.slug;
    const url = `${API_URL}/pokemon/${slug}`;
    const url_statistic = `${API_URL}/pokemon/statistic/${slug}`;

    axios.get(url)
      .then(res => res.data)
      .then((data) => {
        this.setState({ pokemon: data, form: data[0].slug, show : 0, slug: slug })
    });

    // get statistic
    axios.get(url_statistic)
        .then(res => res.data)
        .then((data) => {
        this.setState({ statistic: data })
        if (this.state.statistic) {
            const statistic = this.state.statistic;
            const total = statistic.hp + statistic.attack + statistic.defense + statistic.special_attack + statistic.special_defense + statistic.speed;
            this.setState({
                series: [
                    {
                        name: "statistic",
                        data: [statistic.hp, statistic.attack, statistic.defense, statistic.special_attack, statistic.special_defense, statistic.speed]
                    },
                ],
                total: total,
            });
        }
    });
    window.scrollTo(0, 0);
   }
 }

 getPokemon(event) {
   const slug = event.target.value;
   this.setState({slug: slug}, () => {
    this.props.history.push(`/pokemon/${slug}`);
   });
 }

  render() {
    const { classes } = this.props;
    let loading;
    if (this.state.show === 1) {
      loading = <Loading />;
    } else {
      loading = '';
    }
    let pokemon = this.state.pokemon;
    let weakness_0, weakness_50, weakness_200;

    if (pokemon && pokemon.length > 0 && pokemon[0].weakness) {
        weakness_0 = pokemon[0].weakness.type_0;
        weakness_50 = pokemon[0].weakness.type_50;
        weakness_200 = pokemon[0].weakness.type_200;
    }
    return (
      <div>
        { loading }
        <Container maxWidth="lg">
          <div>
              {pokemon && pokemon.map((pokemon, index) => (
                <Grid container spacing={3} key={pokemon.id} className={classes.block}>
                  <Grid item xs={3}>
                    {pokemon.prev &&
                      <Link to={"/pokemon/" + pokemon.prev.slug} className="type-link">
                        <Button variant="contained">
                            {"< " + pokemon.prev.name}
                        </Button>
                      </Link>
                    }
                  </Grid>
                  <Grid item xs={6}>
                    <Typography variant="h4" gutterBottom className={classes.title}>
                      {pokemon.name}
                      <span className={classes.number}>
                        #{pokemon.number}
                      </span>
                    </Typography>
                  </Grid>
                  <Grid item xs={3}>
                    {pokemon.next &&
                      <Link to={"/pokemon/" + pokemon.next.slug} className="type-link">
                        <Button variant="contained">
                            {pokemon.next.name + " >"}
                        </Button>
                      </Link>
                    }
                  </Grid>
                  <Grid item xs={12}>
                    {pokemon.forms && pokemon.forms.length > 1 &&
                      <FormControl variant="filled" className={classes.formControl}>
                        <InputLabel htmlFor="filled-pokemon-form">{pokemon.name}</InputLabel>
                        <Select
                          value={this.state.form}
                          onChange={this.getPokemon}
                          input={<FilledInput name="form" id="filled-pokemon-form" />}
                        >
                          {pokemon.forms.map((form, index) => (
                            <MenuItem value={form.slug} key={form.id}>{form.name}</MenuItem>
                          ))}
                        </Select>
                      </FormControl>
                    }
                  </Grid>
                  <Grid item xs={6} className={classes.avatar}>
                    <CardActionArea className={classes.imageArea}>
                      <LazyLoad
                        className="lazy-block"
                      >
                        <CardMedia
                          component="img"
                          alt={pokemon.name}
                          image={IMAGE_URL + pokemon.avatar}
                          title=""
                          className={classes.media}
                        />
                      </LazyLoad>
                    </CardActionArea>
                  </Grid>
                  <Grid item xs={6} className={classes.type}>
                    <Grid item xs={12} className={classes.typeRow}>
                      <Typography variant="h6" gutterBottom>
                        Type
                      </Typography>
                      <div>
                        {pokemon.types.map((type, index) => (
                          <Link to={"/type/" + type.name.toLowerCase()} key={type.id}
                              className="type-link"
                          >
                              <Button variant="contained" className={"type__" + type.name + " " + classes.typeItem}>
                                  {type.name}
                              </Button>
                          </Link>
                        ))}
                      </div>
                    </Grid>
                    <Grid item xs={12} className={classes.typeRow}>
                      <Typography variant="h6" gutterBottom>
                        Weakness
                      </Typography>
                      {weakness_0 && Object.keys(weakness_0).length > 0 &&
                        <Grid item xs={12} className={classes.typeRow}>
                            <Typography variant="body1" gutterBottom className={classes.weakness_0}>
                              No effect
                            </Typography>
                            <div>
                              {Object.values(weakness_0).map((weakness, index) => (
                                <Link to={"/type/" + weakness.name.toLowerCase()} key={weakness.id}
                                    className="type-link"
                                >
                                    <Button variant="contained" className={"type__" + weakness.name + " " + classes.typeItem}>
                                        {weakness.name}
                                    </Button>
                                </Link>
                              ))}
                            </div>
                        </Grid>
                      }
                      {weakness_50 && Object.keys(weakness_50).length > 0 &&
                        <Grid item xs={12} className={classes.typeRow}>
                          <Typography variant="body1" gutterBottom className={classes.weakness_50}>
                            Not very effective
                          </Typography>
                          <div>
                            {Object.values(weakness_50).map((weakness, index) => (
                              <Link to={"/type/" + weakness.name.toLowerCase()} key={weakness.id}
                                  className="type-link"
                              >
                                  <Button variant="contained" className={"type__" + weakness.name + " " + classes.typeItem}>
                                      {weakness.name}
                                  </Button>
                              </Link>
                            ))}
                          </div>
                        </Grid>
                      }
                      {weakness_200 && Object.keys(weakness_200).length > 0 &&
                        <Grid item xs={12} className={classes.typeRow}>
                          <Typography variant="body1" gutterBottom className={classes.weakness_200}>
                            Super effective
                          </Typography>
                          <div>
                            {Object.values(weakness_200).map((weakness, index) => (
                              <Link to={"/type/" + weakness.name.toLowerCase()} key={weakness.id}
                                  className="type-link"
                              >
                                  <Button variant="contained" className={"type__" + weakness.name + " " + classes.typeItem}>
                                      {weakness.name}
                                  </Button>
                              </Link>
                            ))}
                          </div>
                        </Grid>
                      }
                    </Grid>
                  </Grid>
                  <Grid item xs={6} className={classes.mixed_chart}>
                    <Typography variant="h6" gutterBottom>
                        Statistics
                    </Typography>
                    <Chart
                        options={this.state.options}
                        series={this.state.series}
                        type="bar"
                        width="500"
                    />
                    <div className="total-block">
                        <strong>Total: </strong>
                        <span className="total-statistic">{ this.state.total }</span>
                    </div>
                  </Grid>
                </Grid>
              ))}
            </div>
        </Container>
      </div>
    );
  }
}

PokemonDetail.propTypes = {
  classes: PropTypes.object.isRequired,
};

export default withStyles(styles)(PokemonDetail);
