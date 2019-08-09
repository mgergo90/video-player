import React from 'react';
import PropTypes from 'prop-types';
import { Helmet } from 'react-helmet';
import { injectIntl, intlShape } from 'react-intl';
import { compose } from 'redux';
import { createStructuredSelector } from 'reselect';
import { connect } from 'react-redux';

import { withStyles } from '@material-ui/core/styles';

import { makeSelectCurrentUser } from 'containers/App/selectors';
import Redirect from 'react-router-dom/Redirect';
import messages from './messages';
import LoginForm from './loginForm';

const styles = {
  loginCard: {
    display: 'flex',
    width: '100%',
    height: '100%',
    alignItems: 'center',
    justifyContent: 'center',
    margin: '60px auto',
  },
};

const LoginPage = ({ classes, intl, user }) => {
  if (user) {
    return <Redirect to="/" />;
  }
  return (
    <div className={classes.loginCard}>
      <Helmet>
        <title>{intl.formatMessage(messages.header)}</title>
      </Helmet>
      <LoginForm />
    </div>
  );
};

LoginPage.defaultProps = {
  user: null,
};

LoginPage.propTypes = {
  intl: intlShape.isRequired,
  classes: PropTypes.instanceOf(Object).isRequired,
  user: PropTypes.instanceOf(Object),
};

const mapStateToProps = createStructuredSelector({
  user: makeSelectCurrentUser(),
});

const withConnect = connect(mapStateToProps);

export default compose(
  injectIntl,
  withConnect,
)(withStyles(styles)(LoginPage));
