import React from 'react';
import PropTypes from 'prop-types';
import { Link } from 'react-router-dom';
import { connect } from 'react-redux';
import { compose } from 'redux';

import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import Button from '@material-ui/core/Button';
import { withStyles } from '@material-ui/core/styles';
import { createStructuredSelector } from 'reselect';
import { makeSelectCurrentUser } from './selectors';
import { logoutUser } from './actions';

const styles = {
  root: {
    flexGrow: 1,
    flex: 1,
  },
};

const Header = ({ classes, user, logout }) => (
  <div className={classes.root}>
    <AppBar position="static" color="default">
      <Toolbar>
        {user ? (
          <Button onClick={logout}>Logout</Button>
        ) : (
          <Link to="/login">
            <Button>Login</Button>
          </Link>
        )}
      </Toolbar>
    </AppBar>
  </div>
);

Header.propTypes = {
  classes: PropTypes.instanceOf(Object).isRequired,
  user: PropTypes.instanceOf(Object),
  logout: PropTypes.func.isRequired,
};

const mapStateToProps = createStructuredSelector({
  user: makeSelectCurrentUser(),
});

const mapDispatchToProps = dispatch => ({
  logout: compose(
    dispatch,
    logoutUser,
  ),
});

export default connect(
  mapStateToProps,
  mapDispatchToProps,
)(withStyles(styles)(Header));
