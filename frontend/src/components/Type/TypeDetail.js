import React, { Component } from 'react';
import axios from 'axios';
import './Type.css';
import { Link } from "react-router-dom";


import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Button from '@material-ui/core/Button';
import Typography from '@material-ui/core/Typography';
import Container from '@material-ui/core/Container';
import Grid from '@material-ui/core/Grid';
import Loading from '../Loading/Loading';

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
    padding: '15px 0 40px 0',
  },
};

const API_URL = 'http://localhost:8000/api';


class TypeDetail extends Component {
  constructor(props){
    super(props);
    this.state = {
      show: 1,
      type: null,
      type_name: null,
    };
  }

  // componentWillMount(){}
  // componentDidMount(){}
  // componentWillUnmount(){}

  // componentWillReceiveProps(){}
  // shouldComponentUpdate(){}
  // componentWillUpdate(){}
  // componentDidUpdate(){}

  componentDidMount() {
    const type_name = this.props.match.params.name;
    const url = `${API_URL}/type/${type_name}`;
    axios.get(url)
      .then(res => res.data)
      .then((data) => {
        this.setState({ type: data, show : 0 })
    });
  }

  static getDerivedStateFromProps(nextProps, prevState){
    if(nextProps.match.params.name !== prevState.type_name){
      return { type_name: nextProps.match.params.name, show: 1};
   }
   else {
      return null;
   }
 }

 componentDidUpdate(prevProps, prevState) {
   if(prevProps.match.params.name !== this.state.type_name)  {
    const type_name = this.props.match.params.name;
    const url = `${API_URL}/type/${type_name}`;
    axios.get(url)
      .then(res => res.data)
      .then((data) => {
        this.setState({ type: data, show : 0, type_name: type_name })
    });
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
    const type = this.state.type;
    let weakness_0, weakness_50, weakness_200;
    if (type) {
        weakness_0 = type[0].weakness_0;
        weakness_50 = type[0].weakness_50;
        weakness_200 = type[0].weakness_200;
    }
    return (
      <div>
        { loading }
        <Container maxWidth="lg">
            <Grid container spacing={3}>
                {type &&
                  <Grid item xs={12}>
                    <Typography variant="h4" gutterBottom className={classes.title}>
                      Type: <span className={"title__" + type[0].name}>{type[0].name}</span>
                    </Typography>
                  </Grid>
                }
                <Grid item xs={4} className={classes.weaknessRow}>
                    <Typography variant="h6" gutterBottom className={classes.weaknessTitle}>
                        No effect
                    </Typography>
                    { weakness_0 && weakness_0.map((weakness, i) => {
                        return (
                            <Link key={weakness.id}
                                to={"/type/" + weakness.name.toLowerCase()}
                                className="type-link">
                                <Button variant="contained" className={"type__" + weakness.name + " " + classes.button}>
                                    {weakness.name}
                                </Button>
                            </Link>
                        )
                    })}
                </Grid>
                <Grid item xs={4} className={classes.weaknessRow}>
                    <Typography variant="h6" gutterBottom className={classes.weaknessTitle}>
                        Not very effective
                    </Typography>
                    { weakness_50 && weakness_50.map((weakness, i) => {
                        return (
                            <Link key={weakness.id}
                                to={"/type/" + weakness.name.toLowerCase()}
                                className="type-link">
                                <Button variant="contained" className={"type__" + weakness.name + " " + classes.button}>
                                    {weakness.name}
                                </Button>
                            </Link>
                        )
                    })}
                </Grid>
                <Grid item xs={4} className={classes.weaknessRow}>
                    <Typography variant="h6" gutterBottom className={classes.weaknessTitle}>
                        Super effective
                    </Typography>
                    {weakness_200 && weakness_200.map((weakness, i) => {
                        return (
                            <Link key={weakness.id}
                                to={"/type/" + weakness.name.toLowerCase()}
                                className="type-link">
                                <Button variant="contained" className={"type__" + weakness.name + " " + classes.button}>
                                    {weakness.name}
                                </Button>
                            </Link>
                        )
                    })}
                </Grid>
            </Grid>
        </Container>
      </div>
    );
  }
}

TypeDetail.propTypes = {
  classes: PropTypes.object.isRequired,
};

export default withStyles(styles)(TypeDetail);
