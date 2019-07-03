import React, { Component } from 'react';
import axios from 'axios';
import { Link } from "react-router-dom";


import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import CardMedia from '@material-ui/core/CardMedia';
import Button from '@material-ui/core/Button';
import Container from '@material-ui/core/Container';
import Grid from '@material-ui/core/Grid';
import Loading from '../Loading/Loading';
import LazyLoad from 'react-lazy-load';

const styles = {
  media: {
    width: 'auto',
    marginLeft: 'auto',
    marginRight: 'auto',
  },
  content: {
    textAlign: 'left',
  },
  scroll: {
    overflow: 'hidden !important',
  },
  sidebar: {
    textAlign: 'left',
  },
  typeRow: {
    padding: '10px',
  },
  typeItem: {
    width: '150px',
  },
};

const API_URL = 'http://localhost:8000/api';


class Type extends Component {
  constructor(props){
    super(props);
    this.state = {
      types: [],
      show: 1,
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
    const url = `${API_URL}/types`;
    axios.get(url)
      .then(res => res.data)
      .then((data) => {
        this.setState({ types: data, show : 0 })
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
    return (
      <div>
        <Container maxWidth="lg">
            <Grid container spacing={3}>
                <Grid item xs={3} className={classes.sidebar}>
                    { loading }
                    {this.state.types.map((type, index) => (
                        <Grid item xs={12} key={type.id} className={classes.typeRow}>
                            <Link to={"/type/" + type.name.toLowerCase()}
                                className="type-link"
                            >
                                <Button variant="contained" className={"type__" + type.name + " " + classes.typeItem}>
                                    {type.name}
                                </Button>
                            </Link>
                        </Grid>
                    ))}
                </Grid>
                <Grid item xs={9}>
                <LazyLoad
                    className="lazy-block"
                >
                    <CardMedia
                        component="img"
                        alt="Pokemon Type Chart"
                        image={require("../../images/typechart.png")}
                        title=""
                        className={classes.media}
                    />
                </LazyLoad>
                </Grid>
            </Grid>
        </Container>
      </div>
    );
  }
}

Type.propTypes = {
  classes: PropTypes.object.isRequired,
};

export default withStyles(styles)(Type);
